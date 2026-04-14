<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../../db_connect.php";

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn->set_charset("utf8mb4");

    try {
        $conn->begin_transaction();

        $property_ID = $_POST['property_ID'] ?? '';
        $total_residential_area = $_POST['total_residential_area'] ?? 0;
        $total_residential_mv   = $_POST['total_residential_mv'] ?? 0;

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
        $check = $conn->prepare("SELECT COUNT(*) FROM residential WHERE property_ID = ?");
        $check->bind_param("i", $property_ID);
        $check->execute();
        $check->bind_result($count);
        $check->fetch();
        $check->close();

        if ($count > 0) {
            // 2️⃣ DELETE OLD ROWS
            $delete = $conn->prepare("DELETE FROM residential WHERE property_ID = ?");
            $delete->bind_param("i", $property_ID);
            $delete->execute();
            $delete->close();

            $mode = "Updated";
        } else {
            $mode = "Inserted";
        }

        // 3️⃣ INSERT RESIDENTIAL RECORDS
        $stmt = $conn->prepare("
            INSERT INTO residential
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

        // 4️⃣ UPDATE TOTALS IN FAAS_PROPERTY
        $update = $conn->prepare("
            UPDATE faas_property
            SET total_residential_mv = ?, total_residential_area = ?
            WHERE FAAS_ID = ?
        ");
        $update->bind_param(
            "ddi",
            $total_residential_mv,
            $total_residential_area,
            $property_ID
        );
        $update->execute();
        $update->close();

        // 5️⃣ COMMIT IF ALL SUCCESS
        $conn->commit();

        echo "$mode $inserted residential record(s). "
            . "Total Area: $total_residential_area | "
            . "Total MV: $total_residential_mv";
    } catch (Throwable $e) {
        // ❌ ROLLBACK ON ANY FAILURE
        $conn->rollback();
        http_response_code(500);
        echo "Database Error: " . $e->getMessage();
    }

    $conn->close();
}
