<?php

require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/db_connect.php';

header('Content-Type: text/html; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Invalid request method.');
}

$mun_code = $_POST['mun_code'] ?? null;

if (!is_numeric($mun_code) || (int)$mun_code <= 0) {
    http_response_code(400);
    exit('Invalid municipality code.');
}

$mun_code = (int)$mun_code;

$sql = "
    SELECT
        class,
        residential_unit_value,
        commercial_unit_value,
        industrial_unit_value
    FROM non_agri_class_value
    WHERE mun_code = ?
    ORDER BY class ASC
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    exit('Database prepare error.');
}

$stmt->bind_param("i", $mun_code);

if (!$stmt->execute()) {
    http_response_code(500);
    exit('Database execution error.');
}

$result = $stmt->get_result();

/*
 * Store existing database records by class.
 * This allows us to always display classes 1-5.
 */
$classes = [];

while ($row = $result->fetch_assoc()) {
    $class = (int)$row['class'];

    if ($class >= 1 && $class <= 5) {
        $classes[$class] = $row;
    }
}

/*
 * Always display fixed classes 1-5.
 */
for ($x = 1; $x <= 5; $x++) {

    $row = $classes[$x] ?? null;

    $residential = $row['residential_unit_value'] ?? '';
    $commercial  = $row['commercial_unit_value'] ?? '';
    $industrial  = $row['industrial_unit_value'] ?? '';

    echo '<tr>';

    echo '<th scope="row" class="table-primary">'
        . $x .
        '</th>';

    echo '<td class="table-success editable smv-value">'
        . htmlspecialchars($residential, ENT_QUOTES, 'UTF-8')
        . '</td>';

    echo '<td class="table-danger editable smv-value">'
        . htmlspecialchars($commercial, ENT_QUOTES, 'UTF-8')
        . '</td>';

    echo '<td class="table-warning editable smv-value">'
        . htmlspecialchars($industrial, ENT_QUOTES, 'UTF-8')
        . '</td>';

    echo '</tr>';
}

$stmt->close();
