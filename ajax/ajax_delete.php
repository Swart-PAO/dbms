<?php
ob_start();
date_default_timezone_set("Asia/Manila");

$action = $_GET['action'];
include 'admin_delete_class.php';
$crud = new Action();
if ($action == 'delete_user') {
    $delete_user = $crud->delete_user();
    if ($delete_user)
        echo $delete_user;
}



ob_end_flush();
