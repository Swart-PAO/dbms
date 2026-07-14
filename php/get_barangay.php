<?php
include '../db_connect.php';

if (isset($_POST['mun_code']) && !empty($_POST['mun_code'])) {
    $mun_code = intval($_POST['mun_code']);

    $sql = "SELECT DISTINCT `brgy_name` as barangay 
            FROM `barangay_list` 
            WHERE `mun_code` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $mun_code);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="">-- Select Barangay --</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['barangay'] . '">' . $row['barangay'] . '</option>';
    }
}
