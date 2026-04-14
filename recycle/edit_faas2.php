<?php
include 'db_connect.php';

$faas_id = $_GET['faas_id'] ?? null;

if (!$faas_id) {
    echo json_encode(['error' => 'No FAAS_ID provided']);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM `faas_property`
    WHERE `FAAS_ID` = ? 
    LIMIT 1
");
$stmt->bind_param("i", $faas_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'BLK'     => $row['BLK'] ?? '',
        'survey'  => $row['survey'] ?? '',
        'title_type' => $row['title_type'] ?? '',
        'lot_no'  => $row['lot_no'] ?? '',
        'owner_name' => $row['owner_name'] ?? '',
        'owner_address' => $row['owner_address'] ?? '',
        'owner_tin' => $row['owner_tin'] ?? '',
        'owner_no' => $row['owner_no'] ?? '',
        'admin_name' => $row['admin_name'] ?? '',
        'admin_address' => $row['admin_address'] ?? '',
        'admin_no' => $row['admin_no'] ?? '',
        'street_no' => $row['street_no'] ?? '',
        'property_brgy' => $row['property_brgy'] ?? '',
        'property_municipality' => $row['property_municipality'] ?? '', // maybe split later
        'northern' => $row['northern'] ?? '',
        'eastern' => $row['eastern'] ?? '',
        'southern' => $row['southern'] ?? '',
        'western' => $row['western'] ?? '',
        'admin_tin' => $row['admin_tin'] ?? '',
        'previous_pin' => $row['previous_pin'] ?? '',
        'previous_td_no' => $row['previous_td_no'] ?? '',
        'previous_effectivity' => $row['previous_effectivity'] ?? '',
        'previous_assessed_value' => $row['previous_assessed_value'] ?? '',
        'north' => $row['north'] ?? '',
        'east' => $row['east'] ?? '',
        'south' => $row['south'] ?? '',
        'west' => $row['west'] ?? '',
        'previous_ARP_no' => $row['previous_ARP_no'] ?? ''
    ]);
} else {
    echo json_encode(['error' => 'No record found']);
}
