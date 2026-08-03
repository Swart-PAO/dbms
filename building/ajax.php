<?php
ob_start();
date_default_timezone_set("Asia/Manila");

$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if ($action == 'save_building_desc') {
    $save_building_desc = $crud->save_building_desc();
    if ($save_building_desc)
        echo $save_building_desc;
}

if ($action == 'save_structural_materials') {
    $save_structural_materials = $crud->save_structural_materials();
    if ($save_structural_materials)
        echo $save_structural_materials;
}

if ($action == 'get_building_desc') {
    $get_building_desc = $crud->get_building_desc();
    if ($get_building_desc)
        echo $get_building_desc;
}

if ($action == 'get_structural_materials') {
    $get_structural_materials = $crud->get_structural_materials();
    if ($get_structural_materials)
        echo $get_structural_materials;
}
if ($action == 'get_building_info') {
    $get_building_info = $crud->get_building_info();
    if ($get_building_info)
        echo $get_building_info;
}
ob_end_flush();
