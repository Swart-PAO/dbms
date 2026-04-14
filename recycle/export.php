<?php
// Allow only GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(403);
    exit('Forbidden');
}

$allowedTypes = ['sql', 'csv'];
$type = $_GET['export_type'] ?? '';

if (!in_array($type, $allowedTypes, true)) {
    exit('Invalid export type');
}

/* ===== CONFIG ===== */
$dbUser = 'root';
$dbPass = ''; // set if needed
$dbName = 'faas_db';
$table  = 'property information'; // table with space
$where  = '`MUNICIPALITY CODE` = 9';

$mysqlBin  = 'C:\\xampp\\mysql\\bin\\';
$exportDir = __DIR__ . '/exports/';

if (!is_dir($exportDir)) {
    mkdir($exportDir, 0755, true);
}

$filename = "property_mun9_" . date('Ymd_His') . ".$type";
$filePath = $exportDir . $filename;

/* ===== SQL EXPORT ===== */
if ($type === 'sql') {

    $mysqldump = $mysqlBin . 'mysqldump.exe';

    $cmd = sprintf(
        '"%s" -u%s %s %s "%s" --where="%s" > "%s"',
        $mysqldump,
        $dbUser,
        $dbPass !== '' ? '-p' . $dbPass : '',
        $dbName,
        $table,
        $where,
        $filePath
    );

    exec($cmd, $output, $status);

    if ($status !== 0 || !file_exists($filePath)) {
        exit('SQL export failed');
    }
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

    // CSV headers
    $firstRow = $result->fetch_assoc();
    fputcsv($fp, array_keys($firstRow));
    fputcsv($fp, $firstRow);

    while ($row = $result->fetch_assoc()) {
        fputcsv($fp, $row);
    }

    fclose($fp);
}

/* ===== FORCE DOWNLOAD ===== */
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
header('Content-Length: ' . filesize($filePath));
readfile($filePath);
exit;
