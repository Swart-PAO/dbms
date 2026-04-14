<?php
include '../db_connect.php'; // adjust path if needed

$mun_code = $_POST['mun_code'] ?? '';

$sql = "SELECT * FROM `property information`";
if ($mun_code !== '') {
    $sql .= " WHERE `MUNICIPALITY CODE` = ?";
}

$stmt = $conn->prepare($sql);

if ($mun_code !== '') {
    $stmt->bind_param("s", $mun_code);
}

$stmt->execute();
$result = $stmt->get_result();

$output = "";
while ($row = $result->fetch_assoc()) {
    $output .= "<tr>
        <td>{$row['PIN']}</td>
        <td>{$row['NAME OF OWNER']}</td>
        <td>{$row['LOCATION OF PROPERTY']}</td>
        <td>{$row['CADASTRAL LOT NUMBER']}</td>
        <td>{$row['DATE OF TRANSACTION']}</td>
        <td>{$row['TRANCODE']}</td>
    </tr>";
}

echo $output === "" ? "<tr><td colspan='6' class='text-center'>No results found</td></tr>" : $output;

$conn->close();
