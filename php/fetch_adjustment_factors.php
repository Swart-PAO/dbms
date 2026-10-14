<?php

require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/db_connect.php';

header('Content-Type: application/json; charset=utf-8');

$data = [
    'ROAD' => [],
    'Location-Weather' => [],
    'Location-Trading' => []
];

$sql = "SELECT 
        type,
        description,
        percentage_A
    FROM adjustment_factor
    WHERE type IN ('ROAD', 'Location-Weather', 'Location-Trading')
    ORDER BY type, description
";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {

    if ($row['type'] === 'Road') {

        $data['ROAD'][] = [
            'description' => $row['description'],
            'percentage_A' => $row['percentage_A']
        ];
    } elseif ($row['type'] === 'Location-Weather') {

        $data['Location-Weather'][] = [
            'description' => $row['description'],
            'percentage_A' => $row['percentage_A']
        ];
    } elseif ($row['type'] === 'Location-Trading') {

        $data['Location-Trading'][] = [
            'description' => $row['description'],
            'percentage_A' => $row['percentage_A']
        ];
    }
}

echo json_encode($data);
