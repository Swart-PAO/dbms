<?php
ob_start();
date_default_timezone_set("Asia/Manila");

$action = $_GET['action'];
include 'update_class.php';
$crud = new Action();
if ($action == 'update_user') {
    $update_user = $crud->update_user();
    if ($update_user)
        echo $update_user;
}

if ($action == 'get_user_info') {
    $get_user_info = $crud->get_user_info();
    if ($get_user_info)
        echo $get_user_info;
}


ob_end_flush();
