<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../../db_connect.php";

    $property_ID = $_POST['property_ID'] ?? 0;

    $mvbmv            = $_POST['mvbmv'] ?? 0;
    $factor_first     = $_POST['factor_first'] ?? '';
    $percent_first    = $_POST['percentage_first'] ?? 0;
    $factor_second    = $_POST['factor_second'] ?? '';
    $percent_second   = $_POST['percentage_second'] ?? 0;
    $factor_third     = $_POST['factor_third'] ?? '';
    $percent_third    = $_POST['percentage_third'] ?? 0;
    $percent_total    = $_POST['percent_total'] ?? 0;
    $value_adjustment = $_POST['value_adjustment'] ?? 0;
    $market_value     = $_POST['market_value'] ?? 0;

    $stmt = $conn->prepare("
        INSERT INTO property_valuation_summary (
            property_ID,
            total_land_mv,
            factor_first,
            percent_first,
            factor_second,
            percent_second,
            factor_third,
            percent_third,
            percent_total,
            total_adjustment,
            total_market_value
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            total_land_mv = VALUES(total_land_mv),
            factor_first = VALUES(factor_first),
            percent_first = VALUES(percent_first),
            factor_second = VALUES(factor_second),
            percent_second = VALUES(percent_second),
            factor_third = VALUES(factor_third),
            percent_third = VALUES(percent_third),
            percent_total = VALUES(percent_total),
            total_adjustment = VALUES(total_adjustment),
            total_market_value = VALUES(total_market_value)
    ");

    $stmt->bind_param(
        "idsisisiidd",
        $property_ID,
        $mvbmv,
        $factor_first,
        $percent_first,
        $factor_second,
        $percent_second,
        $factor_third,
        $percent_third,
        $percent_total,
        $value_adjustment,
        $market_value
    );

    if ($stmt->execute()) {
        echo "Saved Successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
