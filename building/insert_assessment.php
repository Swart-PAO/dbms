<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Invalid request method.');
}





require_once 'config/db_connect.php';


$building_ID = filter_var(
    $_POST['building_ID'] ?? null,
    FILTER_VALIDATE_INT
);

if (!$building_ID || $building_ID <= 0) {
    http_response_code(400);
    exit('Invalid or missing building_ID.');
}

// Assessment arrays
$actual_use       = $_POST['actual_use'] ?? [];
$market_value     = $_POST['market_value'] ?? [];
$assessment_level = $_POST['assessment_level'] ?? [];
$taxable          = $_POST['taxable'] ?? [];
$assessed_value   = $_POST['assessed_value'] ?? [];

if (
    !is_array($actual_use) ||
    !is_array($market_value) ||
    !is_array($assessment_level) ||
    !is_array($taxable) ||
    !is_array($assessed_value)
) {
    http_response_code(400);
    exit('Invalid assessment data.');
}

$rowCount = count($actual_use);

if ($rowCount < 1) {
    http_response_code(400);
    exit('Please add at least one assessment row.');
}

// All arrays must contain matching rows.
if (
    count($market_value) !== $rowCount ||
    count($assessment_level) !== $rowCount ||
    count($taxable) !== $rowCount ||
    count($assessed_value) !== $rowCount
) {
    http_response_code(400);
    exit('Assessment rows do not match.');
}

try {
    $conn->begin_transaction();

    // Check existing building assessment records.
    $check = $conn->prepare(
        "SELECT COUNT(*)
         FROM building_assessment
         WHERE building_id = ?"
    );

    $check->bind_param("i", $building_ID);
    $check->execute();
    $check->bind_result($count);
    $check->fetch();
    $check->close();

    $mode = ($count > 0) ? 'Updated' : 'Inserted';

    // Remove previous rows only when records exist.
    if ($count > 0) {
        $delete = $conn->prepare(
            "DELETE FROM building_assessment
             WHERE building_id = ?"
        );

        $delete->bind_param("i", $building_ID);
        $delete->execute();
        $delete->close();
    }

    // Prepare insert statement.
    $stmt = $conn->prepare(
        "INSERT INTO building_assessment
        (
            building_id,
            actual_use,
            market_value,
            assessment_level,
            assessed_value,
            taxable
        )
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    $inserted = 0;

    for ($i = 0; $i < $rowCount; $i++) {
        $use = trim((string) ($actual_use[$i] ?? ''));
        $market = trim((string) ($market_value[$i] ?? ''));
        $level = trim((string) ($assessment_level[$i] ?? ''));
        $status = trim((string) ($taxable[$i] ?? ''));
        $assessed = trim((string) ($assessed_value[$i] ?? ''));

        // Validate required fields.
        if (
            $use === '' ||
            $market === '' ||
            $level === '' ||
            $assessed === '' ||
            !in_array($status, ['TAXABLE', 'EXEMPT'], true)
        ) {
            throw new Exception(
                'Please complete all fields in assessment row ' .
                    ($i + 1) . '.'
            );
        }

        // Validate numeric fields.
        foreach (
            [
                'Market value' => $market,
                'Assessment level' => $level,
                'Assessed value' => $assessed
            ] as $field => $value
        ) {
            if (!is_numeric($value) || (float) $value < 0) {
                throw new Exception(
                    $field . ' is invalid in row ' . ($i + 1) . '.'
                );
            }
        }

        $market = (float) $market;
        $level = (float) $level;
        $assessed = (float) $assessed;

        $stmt->bind_param(
            "isddds",
            $building_ID,
            $use,
            $market,
            $level,
            $assessed,
            $status
        );

        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }

        $inserted++;
    }

    $stmt->close();

    $conn->commit();

    echo $mode . ' ' . $inserted .
        ' building assessment record(s).';
} catch (Throwable $e) {
    $conn->rollback();

    http_response_code(500);

    error_log('Building assessment save failed: ' . $e->getMessage());

    echo 'Failed to save building assessment. ' .
        'No changes were committed.';
}
