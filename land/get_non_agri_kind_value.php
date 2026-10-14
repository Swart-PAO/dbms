<?php

require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/db_connect.php';

header('Content-Type: application/json');

$mun_code = $_GET['mun_code'] ?? null;
$kind     = trim($_GET['kind'] ?? '');
$class    = $_GET['class'] ?? null;


// Validate municipality
if (!$mun_code) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing municipality.'
    ]);
    exit;
}


// Validate kind
$unitValueColumns = [
    'Residential' => 'residential_unit_value',
    'Commercial'  => 'commercial_unit_value',
    'Industrial'  => 'industrial_unit_value'
];

if (!isset($unitValueColumns[$kind])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid property kind.'
    ]);
    exit;
}


// Validate class
if ($class === null || $class === '' || !is_numeric($class)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid class.'
    ]);
    exit;
}


$mun_code = (int) $mun_code;
$class    = (int) $class;


// Optional: restrict class to 1-7
if ($class < 1 || $class > 7) {
    echo json_encode([
        'success' => false,
        'message' => 'Class must be between 1 and 7.'
    ]);
    exit;
}


// Get the correct column from the whitelist
$unitValueColumn = $unitValueColumns[$kind];


// Build query
$sql = "
    SELECT 
        class,
        {$unitValueColumn} AS unit_value
    FROM non_agri_class_value
    WHERE mun_code = ?
      AND class = ?
    LIMIT 1
";


$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to prepare query.',
        'error'   => $conn->error
    ]);
    exit;
}


$stmt->bind_param(
    "ii",
    $mun_code,
    $class
);


if (!$stmt->execute()) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to execute query.',
        'error'   => $stmt->error
    ]);

    $stmt->close();
    exit;
}


$result = $stmt->get_result();


if ($row = $result->fetch_assoc()) {

    echo json_encode([
        'success' => true,
        'data' => [
            'class'      => (int) $row['class'],
            'unit_value' => $row['unit_value']
        ]
    ]);

    $stmt->close();
    exit;
}


echo json_encode([
    'success' => false,
    'message' => 'No unit value found.',
    'mun_code' => $mun_code,
    'kind'     => $kind,
    'class'     => $class
]);


$stmt->close();
