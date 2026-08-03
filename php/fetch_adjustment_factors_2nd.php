<?php
require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/db_connect.php';

$sql = "SELECT description, percentage_A, percentage_B FROM adjustment_factor WHERE type='Location-W'";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
