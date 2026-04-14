<?php
include "../../db_connect.php";

$sql = "SELECT description, percentage_A FROM adjustment_factor WHERE type='ROAD'";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
