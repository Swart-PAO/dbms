<?php
ob_start();
date_default_timezone_set("Asia/Manila");

$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if ($action == 'get_property_previous') {
    $get_property_previous = $crud->get_property_previous();
    if ($get_property_previous)
        echo $get_property_previous;
}

if ($action == 'insert_property') {
    $insert_property = $crud->insert_property();
    if ($insert_property)
        echo $insert_property;
}
if ($action == 'get_property_revised') {
    $get_property_revised = $crud->get_property_revised();
    if ($get_property_revised)
        echo $get_property_revised;
}
// if ($action == 'edit_property') {
//     $edit_property = $crud->edit_property();
//     if ($edit_property)
//         echo $edit_property;
// }
if ($action == 'insert_user') {
    $insert_user = $crud->insert_user();
    if ($insert_user)
        echo $insert_user;
}

if ($action == 'delete_property') {
    $delete_property = $crud->delete_property();
    if ($delete_property)
        echo $delete_property;
}

if ($action == 'save_land') {
    $save_land = $crud->save_land();
    if ($save_land)
        echo $save_land;
}

ob_end_flush();
