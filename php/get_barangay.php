<?php

require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/db_connect.php';

if (isset($_POST['mun_code']) && !empty($_POST['mun_code'])) {

    $mun_code = intval($_POST['mun_code']);

    $sql = "SELECT DISTINCT 
                brgy_code,
                brgy_name
            FROM barangay_list
            WHERE mun_code = ?
            ORDER BY brgy_name ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $mun_code);
    $stmt->execute();

    $result = $stmt->get_result();

    echo '<option value="">-- Select Barangay --</option>';

    while ($row = $result->fetch_assoc()) {

        echo '<option 
                value="' . htmlspecialchars($row['brgy_name']) . '" 
                data-brgy-code="' . htmlspecialchars($row['brgy_code']) . '">'
            . htmlspecialchars($row['brgy_name']) .
            '</option>';
    }

    $stmt->close();
}
