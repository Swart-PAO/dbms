
<?php
// includes/property_functions.php

require_once 'db_connect.php';

function getBarangays($mun_code)
{
    global $conn;

    $stmt = $conn->prepare(
        "SELECT DISTINCT `NAME OF BARANGAY` 
         FROM `barangay list`
         WHERE `MUNICIPALITY CODE` = ?"
    );
    $stmt->bind_param("i", $mun_code);
    $stmt->execute();

    return $stmt->get_result();
}

// function getPropertiesByMunicipality($mun_code, $limit = 100)
// {
//     global $conn;

//     $stmt = $conn->prepare(
//         "SELECT *
//          FROM `property information`
//          WHERE `MUNICIPALITY CODE` = ?
//          LIMIT ?"
//     );
//     $stmt->bind_param("ii", $mun_code, $limit);
//     $stmt->execute();

//     return $stmt->get_result();
// }

// function getPropertiesByFAASType($mun_code, $barangay, $faas_type)
// {
//     global $conn;

//     $faas_type_query = "";

//     if ($faas_type === 'Building') {
//         $faas_type_query = "AND PIN LIKE '%(%'";
//     } elseif ($faas_type === 'Land') {
//         $faas_type_query = "AND PIN NOT LIKE '%(%'";
//     }

//     $sql = "
//         SELECT property_ID, PIN, `NAME OF OWNER`,
//                `LOCATION OF PROPERTY`,
//                `CADASTRAL LOT NUMBER`,
//                `DATE OF TRANSACTION`,
//                `TRANCODE`
//         FROM `property information`
//         WHERE `LOCATION OF PROPERTY` = ?
//         AND `MUNICIPALITY CODE` = ?
//         AND `faas_ID` IS NULL
//         $faas_type_query
//     ";

//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("si", $barangay, $mun_code);
//     $stmt->execute();

//     return $stmt->get_result();
// }

function getPropertiesByBarangay($mun_code, $barangay, $land_type, $faas, $limit)
{
    $land_type_query = "";
    if ($land_type != 4) {
        $land_type_query = " AND `LAND TYPE` = $land_type";
    }
    global $conn;

    $query = "
        SELECT
            property_ID,
            PIN,
            `NAME OF OWNER`,
            `LOCATION OF PROPERTY`,
            `CADASTRAL LOT NUMBER`,
            `DATE OF TRANSACTION`,
            `TRANCODE`
        FROM `property information`
        WHERE `LOCATION OF PROPERTY` = ?
        AND `MUNICIPALITY CODE` = ?
    ";

    $types = "si";
    $params = [$barangay, $mun_code];

    // LAND TYPE FILTER
    if ($land_type !== null && $land_type != 4) {
        $query .= " AND `LAND TYPE` = ?";
        $types .= "i";
        $params[] = $land_type;
    }

    if ($faas !== null) {
        $query .= $faas
            ? " AND `faas_ID` IS NOT NULL"
            : " AND `faas_ID` IS NULL";
    }

    $query .= " ORDER BY PIN ASC";
    if ($limit) {
        $query .= " LIMIT ?";
        $types .= "i";
        $params[] = $limit;
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();

    return $stmt->get_result();
}


function getPropertyStats($mun_code, $barangay)
{
    global $conn;

    $sql = "SELECT COUNT(*) AS total_rows, COUNT(CASE WHEN `MUNICIPALITY CODE` = ? THEN 1 END) AS total_mun_rows, COUNT(CASE WHEN `MUNICIPALITY CODE` = ? 
    AND `LOCATION OF PROPERTY` = ? THEN 1 END) AS total_mun_brgy_rows, COUNT(CASE WHEN `MUNICIPALITY CODE` = ? AND `LOCATION OF PROPERTY` = ? 
    AND `faas_ID` IS NOT NULL THEN 1 END) AS total_faas_rows FROM `property information`";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return [
            'total_rows'           => 0,
            'total_mun_rows'       => 0,
            'total_mun_brgy_rows'  => 0,
            'total_faas_rows'      => 0
        ];
    }

    // mun_code used 3 times, barangay used 2 times
    $stmt->bind_param(
        "iisis",
        $mun_code,
        $mun_code,
        $barangay,
        $mun_code,
        $barangay
    );

    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    return [
        'total_rows'           => (int) ($result['total_rows'] ?? 0),
        'total_mun_rows'       => (int) ($result['total_mun_rows'] ?? 0),
        'total_mun_brgy_rows'  => (int) ($result['total_mun_brgy_rows'] ?? 0),
        'total_faas_rows'      => (int) ($result['total_faas_rows'] ?? 0)
    ];
}

function getMunicipalities()
{
    global $conn;

    $sql = "SELECT mun_code, mun_desc FROM municipality ORDER BY mun_desc ASC";
    $result = $conn->query($sql);

    if (!$result) {
        return [];
    }

    $municipalities = [];
    while ($row = $result->fetch_assoc()) {
        $municipalities[] = $row;
    }

    return $municipalities;
}

function getBarangayProgress($mun_code)
{
    global $conn;

    $sql = "SELECT 
            b.`NAME OF BARANGAY` AS barangay,
            COUNT(DISTINCT fp.FAAS_ID) AS faas_total,
            COUNT(DISTINCT pi.property_ID) AS info_total
        FROM `barangay list` b
        LEFT JOIN faas_property fp 
            ON fp.property_brgy = b.`NAME OF BARANGAY`
        LEFT JOIN `property information` pi 
            ON pi.`LOCATION OF PROPERTY` = b.`NAME OF BARANGAY`
        WHERE b.`MUNICIPALITY CODE` = ?
        GROUP BY b.`NAME OF BARANGAY`
        ORDER BY b.`NAME OF BARANGAY`";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $mun_code);
    $stmt->execute();

    return $stmt->get_result();
}

function getRecentActivities($limit = 10)
{
    global $conn;

    $sql = "SELECT uh.*, u.name
        FROM user_history uh
        JOIN user u ON u.user_id = uh.user_id
        ORDER BY uh.created_at DESC
        LIMIT ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();

    return $stmt->get_result();
}

function totalTodayTransaction($user_ID)
{
    global $conn;

    $sql = "SELECT COUNT(*) AS total_today FROM faas_property WHERE DATE(recording_date) = CURDATE() AND recording_person_ID = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_ID);
    $stmt->execute();

    return $result = $stmt->get_result()->fetch_assoc();
}


function selectOptionData($data)
{

    global $conn;


    if (!$data) {
        return '<option value="">-- No options available --</option>';
    }

    if ($data === 'land_class') {
        $options = '<option value="">-- Select Classification --</option>';
        $sql = "SELECT class_ID, classification FROM classification";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $options .= '<option value="' . $row['classification'] . '">' . $row['classification'] . '</option>';
            }
        }
    } else if ($data === 'actual_use') {
        $options = '<option value="">-- Select Actual Use --</option>';

        $sql_au = "SELECT description, taxability, assessment_level FROM au_tbl";
        $result_au = $conn->query($sql_au);

        if ($result_au->num_rows > 0) {
            while ($row = $result_au->fetch_assoc()) {
                $options .= '
            <option 
                value="' . htmlspecialchars($row['description']) . '" 
                data-taxability="' . htmlspecialchars($row['taxability']) . '"
                data-assessment_lvl="' . htmlspecialchars($row['assessment_level']) . '">
                ' . htmlspecialchars($row['description']) . '
            </option>';
            }
        }
    } else if ($data === 'non_agri_kind') {

        $options = '<option value="">-- Select Kind --</option>';
        $sql_nao = "SELECT `PROPERTY_DESCRIPTION` FROM non_agri_classification";
        $result_nao = $conn->query($sql_nao);

        if ($result_nao->num_rows > 0) {
            while ($row = $result_nao->fetch_assoc()) {
                $options .= '<option value="' . $row['PROPERTY_DESCRIPTION'] . '">' . $row['PROPERTY_DESCRIPTION'] . '</option>';
            }
        }
    }
    return $options;
}
?>


