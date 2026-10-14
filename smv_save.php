
<?php

require_once __DIR__ . '/config.php';
require_once ROOT_PATH . '/db/db_connect.php';

header('Content-Type: application/json; charset=utf-8');

$munCode = $_POST['mun_code'] ?? null;

if (!$munCode) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid municipality code.'
    ]);
    exit;
}

$data = json_decode($_POST['data'] ?? '', true);

if (!is_array($data) || empty($data)) {
    echo json_encode([
        'success' => false,
        'message' => 'No data to save.'
    ]);
    exit;
}

try {

    $conn->begin_transaction();

    $sql = "
        INSERT INTO non_agri_class_value (
            mun_code,
            residential_unit_value,
            commercial_unit_value,
            industrial_unit_value,
            class
        )
        VALUES (?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            residential_unit_value = COALESCE(
                VALUES(residential_unit_value),
                residential_unit_value
            ),
            commercial_unit_value = COALESCE(
                VALUES(commercial_unit_value),
                commercial_unit_value
            ),
            industrial_unit_value = COALESCE(
                VALUES(industrial_unit_value),
                industrial_unit_value
            )
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception($conn->error);
    }

    foreach ($data as $row) {

        $class = (int) ($row['class'] ?? 0);

        if ($class <= 0) {
            throw new Exception(
                'Invalid classification number.'
            );
        }

        /*
         * Empty values become NULL.
         * This allows a row to be inserted even if
         * one or more unit values are empty.
         */

        $residential = (
            isset($row['residential_unit_value']) &&
            $row['residential_unit_value'] !== ''
        )
            ? (float) $row['residential_unit_value']
            : null;

        $commercial = (
            isset($row['commercial_unit_value']) &&
            $row['commercial_unit_value'] !== ''
        )
            ? (float) $row['commercial_unit_value']
            : null;

        $industrial = (
            isset($row['industrial_unit_value']) &&
            $row['industrial_unit_value'] !== ''
        )
            ? (float) $row['industrial_unit_value']
            : null;


        $stmt->bind_param(
            "idddi",
            $munCode,
            $residential,
            $commercial,
            $industrial,
            $class
        );

        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
    }

    $stmt->close();

    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Classification values saved successfully.'
    ]);
} catch (Throwable $e) {

    if ($conn->in_transaction) {
        $conn->rollback();
    }

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
