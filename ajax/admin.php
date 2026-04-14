<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'faas_db';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die('DB Connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403);
    exit;
}


class Action
{
    private mysqli $db;

    public function __construct(mysqli $conn)
    {
        $this->db = $conn;
    }

    public function export_file()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(403);
            exit;
        }

        $type = $_GET['export_type'] ?? '';
        if (!in_array($type, ['sql', 'csv'], true)) {
            exit('Invalid export type');
        }

        /* CONFIG */
        $table = 'property information';
        $where = '`MUNICIPALITY CODE` = 9';

        $mysqlBin = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';
        $exportDir = __DIR__ . '../exports/';

        if (!is_dir($exportDir)) {
            mkdir($exportDir, 0755, true);
        }

        $filename = "property_mun9_" . date('Ymd_His') . ".$type";
        $filePath = $exportDir . $filename;

        /* COUNT ROWS */
        $countSql = "SELECT COUNT(*) total FROM `$table` WHERE $where";
        $rowRes = $this->db->query($countSql);
        $rowCount = (int)$rowRes->fetch_assoc()['total'];

        /* SQL EXPORT */
        if ($type === 'sql') {

            global $dbUser, $dbPass, $dbName;

            $cmd = sprintf(
                '"%s" -u%s %s %s "%s" --where=%s > "%s"',
                $mysqlBin,
                escapeshellarg($dbUser),
                $dbPass !== '' ? '-p' . escapeshellarg($dbPass) : '',
                escapeshellarg($dbName),
                $table,
                escapeshellarg($where),
                $filePath
            );

            exec($cmd, $out, $status);

            if ($status !== 0 || !file_exists($filePath)) {
                exit('SQL export failed');
            }
        }

        /* CSV EXPORT */
        if ($type === 'csv') {

            $sql = "SELECT * FROM `$table` WHERE $where";
            $result = $this->db->query($sql);

            if (!$result || $result->num_rows === 0) {
                exit('No data found');
            }

            $fp = fopen($filePath, 'w');

            $firstRow = $result->fetch_assoc();
            fputcsv($fp, array_keys($firstRow));
            fputcsv($fp, $firstRow);

            while ($row = $result->fetch_assoc()) {
                fputcsv($fp, $row);
            }

            fclose($fp);
        }

        /* DOWNLOAD */
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($filePath));
        header('X-Row-Count: ' . $rowCount);
        header('X-Filename: ' . $filename);
        header('Cache-Control: no-store');

        readfile($filePath);
        exit;
    }
}

// $action = new Action($conn);
// $action->export_file();
