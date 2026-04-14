<?php
session_start();
include '../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../signin.php");
    exit;
}

$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Extra variables from form
$extra_session = [
    'mun_code' => $_POST['mun_code'] ?? '',
    'brgy' => $_POST['brgy'] ?? '',
    'mun_desc' => $_POST['mun_desc'] ?? ''
];

$sql = "SELECT * FROM user WHERE username = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) {
    $_SESSION['error'] = "Invalid username or password.";
    header("Location: ../signin.php");
    exit;
}

// Check status
if ($row['status'] == 1) {  // closed
    $_SESSION['error'] = "Account is closed. Please contact admin.";
    header("Location: ../signin.php");
    exit;
}
if ($row['status'] == 2) { // archived
    $_SESSION['error'] = "Account is archived.";
    header("Location: ../signin.php");
    exit;
}

// Verify password
if (!password_verify($password, $row['password'])) {
    $_SESSION['error'] = "Invalid username or password.";
    header("Location: ../signin.php");
    exit;
}

// ------- SHORT SESSION SETTER ------- //
foreach ($row as $key => $value) {
    if ($key !== "password" && !is_numeric($key)) {
        $_SESSION[$key] = $value;
    }
}

// Add extra session values
$_SESSION = array_merge($_SESSION, $extra_session);

// Redirect to dashboard
header("Location: ../index.php");
exit;
