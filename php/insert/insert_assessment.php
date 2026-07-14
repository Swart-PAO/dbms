<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../../db_connect.php";
    $property_ID = $_POST['property_ID'] ?? '';

    if (!$property_ID) {
        echo "Missing property_ID";
        exit;
    }

    // Arrays from form
    $actual_use = $_POST['actual_use'];
    $taxable = $_POST['taxable'];
    $market_value_assessed = $_POST['market_value_assessed'];
    $assessed_value = $_POST['assessed_value'];
    $assessed_level = $_POST['assessed_level'];

    $total_assessed_value = $_POST['total_assessed_value'];
    $total_assessment_mv = $_POST['total_assessment_mv'];

    // 1️⃣ Check if assessment rows already exist for this property
    $check = $conn->prepare("SELECT COUNT(*) FROM assessment WHERE property_ID = ?");
    $check->bind_param("i", $property_ID);
    $check->execute();
    $check->bind_result($count);
    $check->fetch();
    $check->close();

    if ($count > 0) {
        // 2️⃣ Delete old rows before inserting updated values
        $delete = $conn->prepare("DELETE FROM assessment WHERE property_ID = ?");
        $delete->bind_param("i", $property_ID);
        $delete->execute();
        $delete->close();

        $mode = "Updated";
    } else {
        $mode = "Inserted";
    }

    // 3️⃣ Insert new / updated rows
    $stmt = $conn->prepare("
        INSERT INTO assessment
        (property_ID, actual_use, market_value_assessed, assessed_level, assessed_value, taxable)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $inserted = 0;

    for ($i = 0; $i < count($actual_use); $i++) {
        $stmt->bind_param(
            "isddds",
            $property_ID,
            $actual_use[$i],
            $market_value_assessed[$i],
            $assessed_level[$i],
            $assessed_value[$i],
            $taxable[$i]
        );

        if ($stmt->execute()) {
            $inserted++;
        }
    }

    $stmt->close();
    // 4️⃣ INSERT OR UPDATE PROPERTY VALUATION SUMMARY
    $summary = $conn->prepare("
    INSERT INTO property_valuation_summary (
        property_ID,
        total_assessment_mv,
        total_assessed_value
    )
    VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE
        total_assessment_mv = VALUES(total_assessment_mv),
        total_assessed_value = VALUES(total_assessed_value)
");

    $summary->bind_param(
        "idd",
        $property_ID,
        $total_assessment_mv,
        $total_assessed_value
    );

    if (!$summary->execute()) {
        echo "Summary update failed: " . $summary->error;
        exit;
    }

    $summary->close();
    $conn->close();

    echo "$mode $inserted assessment record(s).";
}
