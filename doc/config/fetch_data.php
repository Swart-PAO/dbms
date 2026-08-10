<?php
include "db_connect.php";

// Check for building_id instead of pin
if (isset($_POST['building_id'])) {
    $building_id = $_POST['building_id'];
    $data = [];

    // 1. Fetch Building Description (The main table)
    $stmt = $conn->prepare("SELECT * FROM building_desc WHERE building_id = ?");
    $stmt->bind_param("i", $building_id); // Use "i" for integer
    $stmt->execute();
    $data['building'] = $stmt->get_result()->fetch_assoc();

    // 2. Fetch Structural Materials (Flooring, Walls, Roof)
    $stmt = $conn->prepare("SELECT * FROM structural_material WHERE building_id = ?");
    $stmt->bind_param("i", $building_id);
    $stmt->execute();
    $structural = $stmt->get_result()->fetch_assoc();

    // Map structural data to your existing JS structure
    $data['flooring'] = $structural; 
    $data['walls'] = $structural;
    $data['roof'] = $structural['roof'] ?? null;

    // 3. Fetch Property Appraisal
    $stmt = $conn->prepare("SELECT * FROM property_appraisal WHERE building_id = ?");
    $stmt->bind_param("i", $building_id);
    $stmt->execute();
    $data['appraisal'] = $stmt->get_result()->fetch_assoc();

    // 4. Fetch Property Assessment
    $stmt = $conn->prepare("SELECT * FROM property_assessment WHERE building_id = ?");
    $stmt->bind_param("i", $building_id);
    $stmt->execute();
    $data['assessment'] = $stmt->get_result()->fetch_assoc();

    if ($data['building']) {
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Building ID not found']);
    }
} else {
    echo json_encode(['error' => 'No Building ID provided']);
}
?>