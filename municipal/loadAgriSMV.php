<?php

require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/db_connect.php';
header('Content-Type: application/json');

try {

    $sql = "
        SELECT
            agri_class_ID,
            classification,
            first_C,
            second_C,
            third_C,
            fourth_C
        FROM agricultural_class
        ORDER BY agri_class_ID ASC
    ";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        throw new Exception(mysqli_error($conn));
    }

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    echo json_encode([
        'success' => true,
        'data' => $rows
    ]);
} catch (Exception $e) {

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
