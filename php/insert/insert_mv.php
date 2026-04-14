<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../../db_connect.php";

    // Make sure $property_ID is set somewhere before, e.g., from GET or hidden input
    $property_ID = $_POST['property_ID'] ?? 0;

    // Collect form data safely
    $mvbmv          = $_POST['mvbmv'] ?? '';
    $factor_first    = $_POST['factor_first'] ?? '';
    $percent_first   = $_POST['percentage_first'] ?? 0;
    $factor_second   = $_POST['factor_second'] ?? '';
    $percent_second  = $_POST['percentage_second'] ?? 0;
    $factor_third    = $_POST['factor_third'] ?? '';
    $percent_third   = $_POST['percentage_third'] ?? 0;
    $percent_total   = $_POST['percent_total'] ?? 0;
    $value_adjustment = $_POST['value_adjustment'] ?? '';
    $market_value    = $_POST['market_value'] ?? '';

    // Prepare the UPDATE statement
    $stmt = $conn->prepare("
        UPDATE faas_property
        SET 
        total_land_mv = ?,
            factor_first = ?,
            percent_first = ?,
            factor_second = ?,
            percent_second = ?,
            factor_third = ?,
            percent_third = ?,
            percent_total = ?,
            total_adjustment = ?,
            total_market_value = ?
        WHERE FAAS_ID = ?
    ");

    // Bind parameters
    $stmt->bind_param(
        "dsisisiiddi",
        $mvbmv,
        $factor_first,
        $percent_first,
        $factor_second,
        $percent_second,
        $factor_third,
        $percent_third,
        $percent_total,
        $value_adjustment,
        $market_value,
        $property_ID
    );

    // Execute
    if ($stmt->execute()) {
        echo "Updated Successfully";
    } else {
        echo "error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
