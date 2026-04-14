<?php
// insert_user.php
include '../db_connect.php'; // make sure this has your mysqli connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $team = $_POST['team'];
    $department = $_POST['department'];
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash password
    $date_created = $_POST['date_created'];
    $status = 0; // default active

    // Handle file upload
    $picture = "";
    if (!empty($_FILES["picture"]["name"])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $fileName = time() . "_" . basename($_FILES["picture"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $targetFilePath)) {
            $picture = $fileName;
        }
    }

    $sql = "INSERT INTO user (name, team, department, role, picture, status, username, password, date_created) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $name, $team, $department, $role, $picture, $status, $username, $password, $date_created);

    if ($stmt->execute()) {
        echo "<script>alert('User added successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
