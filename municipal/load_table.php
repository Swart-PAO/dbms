<?php
require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/db_connect.php';
require_once ROOT_PATH . "/php/php_class.php";   // contains getPropertiesByBarangay()

$mun_code  = $_POST['mun_code'] ?? '';
$barangay  = $_POST['barangay'] ?? '';
$land_type = $_POST['land_type'] ?? 0;
$faas      = isset($_POST['faas']) ? filter_var($_POST['faas'], FILTER_VALIDATE_BOOLEAN) : false;

$result = getPropertiesByBarangay(
    $mun_code,
    $barangay,
    $land_type,
    $faas,
    null
);

$counter = 1;

while ($row = $result->fetch_assoc()) {
?>
    <tr>
        <td><?= $counter++ ?></td>
        <td><?= htmlspecialchars($row['PIN']) ?></td>
        <td><?= htmlspecialchars($row['NAME OF OWNER']) ?></td>
        <td><?= htmlspecialchars($row['LOCATION OF PROPERTY']) ?></td>
        <td><?= htmlspecialchars($row['CADASTRAL LOT NUMBER']) ?></td>
        <td>
            <a href="faas_form.php?property_ID=<?= $row['property_ID'] ?>&mode=old">
                <i class="icofont-bubble-right text-success"></i>
            </a>
        </td>
    </tr>
<?php
}

if ($counter === 1) {
?>
    <tr>
        <td colspan="6" class="text-center">No records found.</td>
    </tr>
<?php
}
