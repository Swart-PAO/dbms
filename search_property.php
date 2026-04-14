<?php
include 'db_connect.php';

$where = [];
if (!empty($_GET['mun_code'])) {
    $mun_code = $conn->real_escape_string($_GET['mun_code']);
    $where[] = "`MUNICIPALITY CODE` = '$mun_code'";
}
if (!empty($_GET['brgy'])) {
    $brgy = $conn->real_escape_string($_GET['brgy']);
    $where[] = "`BARANGAY` = '$brgy'";
}

$whereSql = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";
$sql = "SELECT * FROM `property information` $whereSql LIMIT 100";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        $row['PIN'],
        $row['NAME OF OWNER'],
        $row['LOCATION OF PROPERTY'],
        $row['CADASTRAL LOT NUMBER'],
        $row['DATE OF TRANSACTION'],
        $row['TRANCODE']
    ];
}

echo json_encode(["data" => $data]); // DataTables expects { "data": [...] }

$conn->close();
