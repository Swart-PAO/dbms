<?php
include "../../db_connect.php";

$land_property_ID = $_POST['land_property_ID'] ?? '';

if (!$land_property_ID) {
    echo json_encode([]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM land WHERE property_ID = ?");
$stmt->bind_param("i", $land_property_ID);
$stmt->execute();
$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
