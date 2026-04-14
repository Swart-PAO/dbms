<?php


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Invalid request');
}

include 'db_connect.php';

$action = $_POST['action'] ?? '';
$property_ID = $_POST['property_ID'] ?? null;

if (!$property_ID || !is_numeric($property_ID)) {
    exit('Missing or invalid property_ID');
}


switch ($action) {
    case 'assessment':
        handleAssessment($conn, $property_ID);
        break;

    case 'land':
        handleLand($conn, $property_ID);
        break;

    case 'residential':
        handleResidential($conn, $property_ID);
        break;

    case 'market_value':
        handleMV($conn, $property_ID);
        break;

    default:
        echo 'Invalid action';
}

$conn->close();





function handleAssessment($conn, $property_ID)
{
    $actual_use = $_POST['actual_use'];
    $taxable = $_POST['taxable'];
    $market_value_assessed = $_POST['market_value_assessed'];
    $assessed_value = $_POST['assessed_value'];
    $assessed_level = $_POST['assessed_level'];

    $check = $conn->prepare("SELECT COUNT(*) FROM assessment WHERE property_ID = ?");
    $check->bind_param("i", $property_ID);
    $check->execute();
    $check->bind_result($count);
    $check->fetch();
    $check->close();

    if ($count > 0) {
        $delete = $conn->prepare("DELETE FROM assessment WHERE property_ID = ?");
        $delete->bind_param("i", $property_ID);
        $delete->execute();
        $delete->close();
        $mode = "Updated";
    } else {
        $mode = "Inserted";
    }

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
        if ($stmt->execute()) $inserted++;
    }

    $stmt->close();
    echo "$mode $inserted assessment record(s).";
}

function handleLand($conn, $property_ID)
{
    $classifications = $_POST['classification'];
    $sub_classes = $_POST['sub_class'];
    $areas = $_POST['area_land'];
    $unit_values = $_POST['unit_value_land'];
    $bmvs = $_POST['market_value_land'];

    // 1️⃣ CHECK IF PROPERTY ALREADY EXISTS
    $check = $conn->prepare("SELECT COUNT(*) FROM land WHERE property_ID = ?");
    $check->bind_param("i", $property_ID);
    $check->execute();
    $check->bind_result($count);
    $check->fetch();
    $check->close();

    if ($count > 0) {
        // 2️⃣ IF EXISTS → DELETE OLD ROWS FIRST THEN REINSERT UPDATED DATA
        $delete = $conn->prepare("DELETE FROM land WHERE property_ID = ?");
        $delete->bind_param("i", $property_ID);
        $delete->execute();
        $delete->close();

        $mode = "Updated";
    } else {
        $mode = "Inserted";
    }

    // 3️⃣ INSERT NEW / UPDATED ROWS
    $stmt = $conn->prepare("
        INSERT INTO land (property_ID, class, sub_class, area_land, unit_value_land, market_value_land)
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

        if ($stmt->execute()) {
            $inserted++;
        }
    }



    echo "$mode $inserted land record(s).";
}

function handleResidential($conn, $property_ID)
{

    $kind = $_POST['kind'];
    $area_resid = $_POST['area_resid'];
    $unit_value_resid = $_POST['unit_value_resid'];
    $adjustment_factor = $_POST['adjustment_factor'];
    $market_value_resid = $_POST['market_value_resid'];

    // 1️⃣ CHECK IF PROPERTY ALREADY EXISTS
    $check = $conn->prepare("SELECT COUNT(*) FROM residential WHERE property_ID = ?");
    $check->bind_param("i", $property_ID);
    $check->execute();
    $check->bind_result($count);
    $check->fetch();
    $check->close();

    if ($count > 0) {
        // 2️⃣ DELETE OLD ROWS BEFORE REINSERTING UPDATED VALUES
        $delete = $conn->prepare("DELETE FROM residential WHERE property_ID = ?");
        $delete->bind_param("i", $property_ID);
        $delete->execute();
        $delete->close();

        $mode = "Updated";
    } else {
        $mode = "Inserted";
    }

    // 3️⃣ INSERT NEW / UPDATED ROWS
    $stmt = $conn->prepare("
        INSERT INTO residential 
        (property_ID, kind, area_resid, unit_value_resid, adjustment_factor, market_value_resid)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $inserted = 0;

    for ($i = 0; $i < count($kind); $i++) {
        $stmt->bind_param(
            "isddsd",
            $property_ID,
            $kind[$i],
            $area_resid[$i],
            $unit_value_resid[$i],
            $adjustment_factor[$i],
            $market_value_resid[$i]
        );

        if ($stmt->execute()) {
            $inserted++;
        }
    }

    echo "$mode $inserted residential record(s).";
}
function handleMV($conn, $property_ID)
{
    $mvbmv          = $_POST['mvbmv'] ?? '';
    $factor_first    = $_POST['factor_first'] ?? '';
    $percent_first   = $_POST['percent_first'] ?? 0;
    $factor_second   = $_POST['factor_second'] ?? '';
    $percent_second  = $_POST['percent_second'] ?? 0;
    $factor_third    = $_POST['factor_third'] ?? '';
    $percent_third   = $_POST['percent_third'] ?? 0;
    $percent_total   = $_POST['percent_total'] ?? 0;
    $value_adjusment = $_POST['value_adjusment'] ?? '';
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
        $value_adjusment,
        $market_value,
        $property_ID
    );

    // Execute
    if ($stmt->execute()) {
        echo "Updated Successfully";
    } else {
        echo "error: " . $stmt->error;
    }
}
