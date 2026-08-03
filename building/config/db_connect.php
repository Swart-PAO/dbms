<?php
// Database Connection
$host = "localhost";
$username = "root";
$password = "";
$database = "faas_db";

$conn = new mysqli($host, $username, $password, $database);

// if($conn->connect_errno){
//     // Display if Database connedction is failed
//     die('Connection failed' . $conn->connect_error);
// }

// echo "Connected Successfully";
