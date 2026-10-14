<?php

require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/db_connect.php';

header('Content-Type: application/json');

$land_property_ID = $_POST['land_property_ID'] ?? '';

if (!$land_property_ID) {
    echo json_encode([
        'success' => false,
        'message' => 'Property ID is missing.'
    ]);
    exit;
}

$data = [
    'success' => true,
    'agricultural' => null,
    'non_agricultural' => []
];

/*
|--------------------------------------------------------------------------
| 1. GET AGRICULTURAL INFO
|--------------------------------------------------------------------------
| Agricultural has only ONE row.
*/
$stmt = $conn->prepare("
    SELECT total_market_value, land_assessed_value, summary_id, actual_use, taxable, assessment_level
    FROM property_valuation_summary
    WHERE property_ID = ?
    LIMIT 1
");

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Agricultural query preparation failed: ' . $conn->error
    ]);
    exit;
}

$stmt->bind_param("i", $land_property_ID);
$stmt->execute();

$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $data['agricultural'] = [
        'market_value' => $row['total_market_value'],
        'assessed_value' => $row['land_assessed_value'],
        'summary_id' => $row['summary_id'],
        'actual_use' => $row['actual_use'],
        'taxable' => $row['taxable'],
        'assessment_level' => $row['assessment_level']
    ];
}

$stmt->close();


/*
|--------------------------------------------------------------------------
| 2. GET NON-AGRICULTURAL INFO
|--------------------------------------------------------------------------
| Non-agricultural can have MULTIPLE rows.
*/
$stmt = $conn->prepare("
    SELECT market_value_resid, kind, non_agri_ID, actual_use, taxable, assessment_level, assessed_value
    FROM non_agricultural_info
    WHERE property_ID = ?
");

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Non-agricultural query preparation failed: ' . $conn->error
    ]);
    exit;
}

$stmt->bind_param("i", $land_property_ID);
$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {

    $data['non_agricultural'][] = [
        'market_value' => $row['market_value_resid'],
        'kind' => $row['kind'],
        'non_agri_ID' => $row['non_agri_ID'],
        'actual_use' => $row['actual_use'],
        'taxable' => $row['taxable'],
        'assessment_level' => $row['assessment_level'], // Add assessment_level if it exists
        'assessed_value' => $row['assessed_value'] // Add assessed_value if it exists,
    ];
}

$stmt->close();

echo json_encode($data);
