<?php
ob_start();
date_default_timezone_set("Asia/Manila");

$action = $_GET['action'];
include 'admin_class.php';
include 'admin_class_market_value.php';

$crud = new Action();
$crudMarketValue = new ActionMarketValue();

if ($action == 'save_property') {
    $save_property = $crud->save_property();
    if ($save_property)
        echo $save_property;
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

if ($action == 'save_non_agri') {
    $save_non_agri = $crudMarketValue->save_non_agri();
    if ($save_non_agri)
        echo $save_non_agri;
}

ob_end_flush();
