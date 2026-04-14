<?php
include 'db_connect.php'; // mysqli connection ($conn)

$faas_id             = $_POST['faas_id'] ?? null;
$transaction_code      = $_POST['transaction_code'] ?? '';
$ARP_no                = $_POST['ARP_no'] ?? '';
$title_type            = $_POST['title_type'] ?? '';
$title_dated           = $_POST['title_dated'] ?? '';
$PIN_no                = $_POST['input_pin_no'] ?? '';
$survey                = $_POST['survey'] ?? '';
$lot_no                = $_POST['lot_no'] ?? '';
$BLK                   = $_POST['BLK'] ?? '';
$owner_name            = $_POST['owner_name'] ?? '';
$owner_address         = $_POST['owner_address'] ?? '';
$owner_no              = $_POST['owner_no'] ?? '';
$owner_tin             = $_POST['owner_tin'] ?? '';
$admin_name            = $_POST['admin_name'] ?? '';
$admin_address         = $_POST['admin_address'] ?? '';
$admin_no              = $_POST['admin_no'] ?? '';
$admin_tin             = $_POST['admin_tin'] ?? '';
$street_no             = $_POST['street_no'] ?? '';
$property_brgy         = $_POST['property_brgy'] ?? '';
$property_municipality = $_POST['property_municipality'] ?? '';
$property_province     = $_POST['property_province'] ?? '';
$north                 = $_POST['north'] ?? '';
$east                  = $_POST['east'] ?? '';
$south                 = $_POST['south'] ?? '';
$west                  = $_POST['west'] ?? '';
$northern              = $_POST['northern'] ?? '';
$eastern               = $_POST['eastern'] ?? '';
$southern              = $_POST['southern'] ?? '';
$western               = $_POST['western'] ?? '';
$previous_pin          = $_POST['previous_pin'] ?? '';
$previous_ARP_no       = $_POST['previous_ARP_no'] ?? '';
$previous_td_no        = $_POST['previous_td_no'] ?? '';
$previous_assessed_value = $_POST['previous_assessed_value'] ?? '';
$previous_owner        = $_POST['previous_owner'] ?? '';
$previous_effectivity  = $_POST['previous_effectivity'] ?? '';

// Defaults
$status = "active";
$version = 1;

// Insert query
$sql = "UPDATE `faas_property`  SET 
            `transaction_code` = ?, 
            `ARP_no` = ?, 
            `title_type` = ?, 
            `title_dated` = ?, 
            `PIN_no` = ?, 
            `survey` = ?, 
            `lot_no` = ?, 
            `BLK` = ?, 
            `owner_name` = ?, 
            `owner_address` = ?, 
            `owner_no` = ?, 
            `owner_tin` = ?, 
            `admin_name` = ?, 
            `admin_address` = ?, 
            `admin_no` = ?, 
            `admin_tin` = ?, 
            `street_no` = ?, 
            `property_brgy` = ?, 
            `property_municipality` = ?, 
            `property_province` = ?, 
            `north` = ?, 
            `east` = ?, 
            `south` = ?, 
            `west` = ?, 
            `northern` = ?, 
            `eastern` = ?, 
            `southern` = ?, 
            `western` = ?, 
            `previous_pin` = ?, 
            `previous_ARP_no` = ?, 
            `previous_td_no` = ?, 
            `previous_assessed_value` = ?, 
            `previous_owner` = ?, 
            `previous_effectivity` = ?, 
            `status` = ?, 
            `version` = ?
        WHERE `FAAS_ID` = ?;";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param(
    "sssssssssssssssssssssssssssssssssssii",
    $transaction_code,
    $ARP_no,
    $title_type,
    $title_dated,
    $PIN_no,
    $survey,
    $lot_no,
    $BLK,
    $owner_name,
    $owner_address,
    $owner_no,
    $owner_tin,
    $admin_name,
    $admin_address,
    $admin_no,
    $admin_tin,
    $street_no,
    $property_brgy,
    $property_municipality,
    $property_province,
    $north,
    $east,
    $south,
    $west,
    $northern,
    $eastern,
    $southern,
    $western,
    $previous_pin,
    $previous_ARP_no,
    $previous_td_no,
    $previous_assessed_value,
    $previous_owner,
    $previous_effectivity,
    $status,
    $version,
    $faas_id
);

if ($stmt->execute()) {
    echo "✅ FAAS Property inserted successfully!";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
