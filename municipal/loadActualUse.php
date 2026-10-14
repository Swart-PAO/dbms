<?php

require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/db_connect.php';
header('Content-Type: application/json');

try {

    $sql = "
        SELECT
            au_ID,
            description,
            assessment_level,
            taxability

        FROM au_tbl
        ORDER BY au_ID ASC
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
