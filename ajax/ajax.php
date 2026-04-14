<?php
ob_start();
date_default_timezone_set("Asia/Manila");

$action = $_GET['action'];
include 'admin.php';
$crud = new Action();
if ($action == 'export_file') {
    $export_file = $crud->export_file();
    if ($export_file)
        echo $export_file;
}



ob_end_flush();
