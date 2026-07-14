<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../../db_connect.php";

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn->set_charset("utf8mb4");

    try {
        $conn->begin_transaction();

        $property_ID = $_POST['property_ID'] ?? '';
        $total_non_agri_area = $_POST['total_non_agri_area'] ?? 0;
        $total_non_agri_mv   = $_POST['total_non_agri_mv'] ?? 0;

        if (!$property_ID) {
            throw new Exception("Missing property_ID");
        }

        // Arrays from form (safe defaults)
        $kind               = $_POST['kind'] ?? [];
        $area_resid         = $_POST['area_resid'] ?? [];
        $unit_value_resid   = $_POST['unit_value_resid'] ?? [];
        $adjustment_factor  = $_POST['adjustment_factor'] ?? [];
        $market_value_resid = $_POST['market_value_resid'] ?? [];

        // 1️⃣ CHECK IF PROPERTY ALREADY EXISTS
        $check = $conn->prepare("SELECT COUNT(*) FROM non_agricultural_info WHERE property_ID = ?");
        $check->bind_param("i", $property_ID);
        $check->execute();
        $check->bind_result($count);
        $check->fetch();
        $check->close();

        if ($count > 0) {
            // 2️⃣ DELETE OLD ROWS
            $delete = $conn->prepare("DELETE FROM non_agricultural_info WHERE property_ID = ?");
            $delete->bind_param("i", $property_ID);
            $delete->execute();
            $delete->close();

            $mode = "Updated";
        } else {
            $mode = "Inserted";
        }

        // 3️⃣ INSERT RESIDENTIAL RECORDS
        $stmt = $conn->prepare("
            INSERT INTO non_agricultural_info
            (property_ID, kind, area_resid, unit_value_resid, adjustment_factor, market_value_resid)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $inserted = 0;

        for ($i = 0; $i < count($kind); $i++) {

            $stmt->bind_param(
                "isdddd",
                $property_ID,
                $kind[$i],
                $area_resid[$i],
                $unit_value_resid[$i],
                $adjustment_factor[$i],
                $market_value_resid[$i]
            );

            $stmt->execute();
            $inserted++;
        }
        $stmt->close();
        // 4️⃣ INSERT OR UPDATE VALUATION SUMMARY
        $summary = $conn->prepare("INSERT INTO property_valuation_summary
        (property_ID, total_non_agri_mv, total_non_agri_area)
    VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE
        total_non_agri_mv = VALUES(total_non_agri_mv),
        total_non_agri_area = VALUES(total_non_agri_area)
");

        $summary->bind_param(
            "idd",
            $property_ID,
            $total_non_agri_mv,
            $total_non_agri_area
        );

        $summary->execute();
        $summary->close();
        // 5️⃣ COMMIT IF ALL SUCCESS
        $conn->commit();

        echo "$mode $inserted residential record(s). "
            . "Total Area: $total_non_agri_area | "
            . "Total MV: $total_non_agri_mv";
    } catch (Throwable $e) {
        // ❌ ROLLBACK ON ANY FAILURE
        $conn->rollback();
        http_response_code(500);
        echo "Database Error: " . $e->getMessage();
    }

    $conn->close();
}
