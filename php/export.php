<?php
// Allow only GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(403);
    exit('Forbidden');
}

$allowedTypes = ['sql', 'csv'];
$type = $_GET['export_type'] ?? '';
$mun_code = $_GET['mun_code'] ?? '';

if (!in_array($type, $allowedTypes, true)) {
    exit('Invalid export type');
}

/* ===== SANITIZE MUNICIPALITY CODE ===== */
$mun_code = preg_replace('/[^0-9]/', '', $mun_code);

if ($mun_code === '') {
    exit('Invalid municipality code');
}

/* ===== CONFIG ===== */
$dbUser = 'root';
$dbPass = '';
$dbName = 'faas_db';
$table  = 'property information'; // table with space
$where  = "`MUNICIPALITY CODE` = $mun_code";

$mysqlBin  = 'C:\\xampp\\mysql\\bin\\';

/* ===== CREATE MUNICIPALITY EXPORT FOLDER ===== */
$exportBase = __DIR__ . '/exports/';
$exportDir  = $exportBase . $mun_code . '/';

if (!is_dir($exportDir)) {
    mkdir($exportDir, 0755, true);
}

/* ===== FILE NAME ===== */
$filename = "property_mun_{$mun_code}_" . date('Ymd_His') . ".$type";
$filePath = $exportDir . $filename;

$rowsExported = 0;


/* ===== SQL EXPORT ===== */
if ($type === 'sql') {

    $mysqldump = $mysqlBin . 'mysqldump.exe';

    $cmd = "\"$mysqldump\" -u$dbUser "
        . ($dbPass !== '' ? "-p$dbPass " : '')
        . "$dbName \"$table\" --where=\"$where\"";

    file_put_contents($filePath, shell_exec($cmd));

    if (!file_exists($filePath) || filesize($filePath) === 0) {
        exit('SQL export failed');
    }

    $tableEscaped = str_replace('`', '``', $table);

    $countCmd = "\"{$mysqlBin}mysql.exe\" -u$dbUser "
        . ($dbPass !== '' ? "-p$dbPass " : '')
        . "$dbName -N -e \"SELECT COUNT(*) FROM `{$tableEscaped}` WHERE {$where}\"";

    $rowsExported = (int) trim(shell_exec($countCmd));
}


/* ===== CSV EXPORT ===== */
if ($type === 'csv') {

    require_once '../db_connect.php';

    $sql = "SELECT * FROM `$table` WHERE $where";
    $result = $conn->query($sql);

    if (!$result) {
        exit('Query failed');
    }

    $fp = fopen($filePath, 'w');

    if ($firstRow = $result->fetch_assoc()) {

        fputcsv($fp, array_keys($firstRow));
        fputcsv($fp, $firstRow);
        $rowsExported++;

        while ($row = $result->fetch_assoc()) {
            fputcsv($fp, $row);
            $rowsExported++;
        }
    }

    fclose($fp);
}


/* ===== DOWNLOAD RESPONSE ===== */
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . filesize($filePath));
header('X-Filename: ' . $filename);
header('X-Row-Count: ' . $rowsExported);

readfile($filePath);
exit;
