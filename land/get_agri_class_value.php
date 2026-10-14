<?php
require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/db_connect.php';
$agri_class = $_GET['agri_class'] ?? '';
$sub_class  = $_GET['sub_class'] ?? '';

$allowed_columns = [
    '1' => 'first_C',
    '2' => 'second_C',
    '3' => 'third_C',
    '4' => 'fourth_C'
];

if (
    empty($agri_class) ||
    !isset($allowed_columns[$sub_class])
) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid agricultural classification or subclass.'
    ]);
    exit;
}

$column = $allowed_columns[$sub_class];

$stmt = $conn->prepare("
        SELECT `$column` AS unit_value
        FROM agricultural_class
        WHERE classification = ?
        LIMIT 1
    ");

$stmt->bind_param("s", $agri_class);
$stmt->execute();

$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {

    echo json_encode([
        'success' => true,
        'unit_value' => $row['unit_value']
    ]);
} else {

    echo json_encode([
        'success' => false,
        'unit_value' => null,
        'message' => 'Agricultural classification not found.'
    ]);
}

$stmt->close();
exit;
