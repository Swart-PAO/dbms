<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../../db_connect.php";

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn->set_charset("utf8mb4");

    try {
        $conn->begin_transaction();

        $property_ID = $_POST['property_ID'] ?? '';
        $total_land_area = $_POST['total_land_area'] ?? 0;

        if (!$property_ID) {
            throw new Exception("Missing property_ID");
        }

        $classifications = $_POST['classification'] ?? [];
        $sub_classes     = $_POST['sub_class'] ?? [];
        $areas           = $_POST['area_land'] ?? [];
        $unit_values     = $_POST['unit_value_land'] ?? [];
        $bmvs            = $_POST['market_value_land'] ?? [];

        // 1️⃣ CHECK IF PROPERTY ALREADY EXISTS
        $check = $conn->prepare("SELECT COUNT(*) FROM land WHERE property_ID = ?");
        $check->bind_param("i", $property_ID);
        $check->execute();
        $check->bind_result($count);
        $check->fetch();
        $check->close();

        if ($count > 0) {
            // 2️⃣ DELETE OLD ROWS
            $delete = $conn->prepare("DELETE FROM land WHERE property_ID = ?");
            $delete->bind_param("i", $property_ID);
            $delete->execute();
            $delete->close();

            $mode = "Updated";
        } else {
            $mode = "Inserted";
        }

        // 3️⃣ INSERT LAND RECORDS
        $stmt = $conn->prepare("
            INSERT INTO land
            (property_ID, class, sub_class, area_land, unit_value_land, market_value_land)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $inserted = 0;

        for ($i = 0; $i < count($classifications); $i++) {
            $stmt->bind_param(
                "issddd",
                $property_ID,
                $classifications[$i],
                $sub_classes[$i],
                $areas[$i],
                $unit_values[$i],
                $bmvs[$i]
            );

            $stmt->execute();
            $inserted++;
        }
        $stmt->close();

        // 4️⃣ UPDATE TOTAL LAND AREA
        $update = $conn->prepare("
            UPDATE faas_property
            SET total_land_area = ?
            WHERE FAAS_ID = ?
        ");
        $update->bind_param("di", $total_land_area, $property_ID);
        $update->execute();
        $update->close();

        // 5️⃣ COMMIT IF ALL SUCCESS
        $conn->commit();

        echo "$mode $inserted land record(s). Total Area: $total_land_area";
    } catch (Throwable $e) {
        // ❌ ROLLBACK ON ANY ERROR
        $conn->rollback();

        http_response_code(500);
        echo "Database Error: " . $e->getMessage();
    }

    $conn->close();
}
