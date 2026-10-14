
<?php

require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/db_connect.php';

header('Content-Type: text/plain; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Invalid request method.";
    exit;
}

$property_ID = $_POST['property_ID'] ?? null;

$assessment_ID = $_POST['assessment_ID'] ?? [];
$kind = $_POST['kind'] ?? [];
$actual_use = $_POST['actual_use'] ?? [];
$taxable = $_POST['taxable'] ?? [];
$market_value_assessed = $_POST['market_value_assessed'] ?? [];
$assessed_level = $_POST['assessed_level'] ?? [];
$assessed_value = $_POST['assessed_value'] ?? [];


$total_assessment_mv = $_POST['total_assessment_mv'] ?? [];
$total_assessed_value = $_POST['total_assessed_value'] ?? [];

if (!$property_ID) {
    http_response_code(400);
    echo "Property ID is missing.";
    exit;
}

if (!is_array($assessment_ID)) {
    http_response_code(400);
    echo "Invalid assessment data.";
    exit;
}

try {

    $conn->begin_transaction();

    /*
    |--------------------------------------------------------------------------
    | PREPARE AGRICULTURAL UPDATE
    |--------------------------------------------------------------------------
    */

    $stmtAgri = $conn->prepare("
        UPDATE property_valuation_summary
        SET
            actual_use = ?,
        land_assessed_value = ?,
            total_assessment_mv = ?,
            total_assessed_value = ?,
            assessment_level = ?,
            taxable = ?
        WHERE property_ID = ?
          AND summary_id = ?
    ");

    if (!$stmtAgri) {
        throw new Exception(
            "Agricultural statement error: " . $conn->error
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PREPARE NON-AGRICULTURAL UPDATE
    |--------------------------------------------------------------------------
    */

    $stmtNonAgri = $conn->prepare("
        UPDATE non_agricultural_info
        SET
            kind = ?,
            actual_use = ?,
            taxable = ?,
            assessment_level = ?,
            assessed_value = ?
        WHERE property_ID = ?
          AND non_agri_ID = ?
    ");

    if (!$stmtNonAgri) {
        throw new Exception(
            "Non-agricultural statement error: " . $conn->error
        );
    }


    /*
    |--------------------------------------------------------------------------
    | LOOP THROUGH ASSESSMENT ROWS
    |--------------------------------------------------------------------------
    */

    $rowCount = count($assessment_ID);

    for ($i = 0; $i < $rowCount; $i++) {

        $id = trim($assessment_ID[$i] ?? '');
        $currentKind = trim($kind[$i] ?? '');

        $currentActualUse =
            trim($actual_use[$i] ?? '');

        $currentTaxable =
            trim($taxable[$i] ?? '');

        $currentAssessmentLevel =
            $assessed_level[$i] ?? 0;

        $currentAssessedValue =
            $assessed_value[$i] ?? 0;

        /*
        |--------------------------------------------------------------------------
        | SKIP INVALID ROW
        |--------------------------------------------------------------------------
        */

        if ($id === '') {
            continue;
        }


        /*
        |--------------------------------------------------------------------------
        | AGRICULTURAL
        |--------------------------------------------------------------------------
        */

        if (strcasecmp($currentKind, 'Agricultural') === 0) {

            $summary_id = (int)$id;

            $totalAssessedMV =
                (float)$total_assessment_mv ?? 0;
            $totalAssessedValue =
                (float)$currentAssessedValue;

            $assessmentLevel =
                (float)$currentAssessmentLevel;

            $propertyId =
                (int)$property_ID;

            $stmtAgri->bind_param(
                "sddddsii",
                $currentActualUse,
                $currentAssessedValue,
                $totalAssessedMV,
                $total_assessed_value,
                $assessmentLevel,
                $currentTaxable,
                $propertyId,
                $summary_id
            );

            if (!$stmtAgri->execute()) {
                throw new Exception(
                    "Failed to update Agricultural assessment: " .
                        $stmtAgri->error
                );
            }


            /*
            |--------------------------------------------------------------------------
            | VERIFY THAT A RECORD WAS ACTUALLY UPDATED
            |--------------------------------------------------------------------------
            */

            if ($stmtAgri->affected_rows === 0) {

                // This does NOT necessarily mean an error.
                // MySQL returns 0 if submitted values are unchanged.

                // If you want strict ID verification, use a SELECT here.
            }
        }


        /*
        |--------------------------------------------------------------------------
        | NON-AGRICULTURAL
        |--------------------------------------------------------------------------
        */ else {

            $nonAgriId =
                (int)$id;

            $currentKind =
                trim($currentKind);

            $assessmentLevel =
                (float)$currentAssessmentLevel;

            $currentAssessedValue =
                (float)$currentAssessedValue;

            $propertyId =
                (int)$property_ID;

            $stmtNonAgri->bind_param(
                "sssddii",
                $currentKind,
                $currentActualUse,
                $currentTaxable,
                $assessmentLevel,
                $currentAssessedValue,
                $propertyId,
                $nonAgriId
            );

            if (!$stmtNonAgri->execute()) {
                throw new Exception(
                    "Failed to update Non-Agricultural assessment: " .
                        $stmtNonAgri->error
                );
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CLOSE STATEMENTS
    |--------------------------------------------------------------------------
    */

    $stmtAgri->close();
    $stmtNonAgri->close();


    /*
    |--------------------------------------------------------------------------
    | COMMIT
    |--------------------------------------------------------------------------
    */

    $conn->commit();

    echo "Assessment updated successfully.";
} catch (Throwable $e) {

    /*
    |--------------------------------------------------------------------------
    | ROLLBACK
    |--------------------------------------------------------------------------
    */

    $conn->rollback();

    http_response_code(500);

    echo "Assessment update failed: " . $e->getMessage();
}
