<?php
require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/db_connect.php';
require_once ROOT_PATH . "/php/php_class.php";   // contains getPropertiesByBarangay()

$mun_code  = $_POST['mun_code'] ?? '';
$barangay  = $_POST['barangay'] ?? '';

$result = getBuildingByBarangayRevision($mun_code, $barangay, NULL, NULL);

$counter = 1;

while ($row = $result->fetch_assoc()) {
?>
    <tr>
        <td><?= $counter++ ?></td>
        <td><?= htmlspecialchars($row['previous_pin']) ?></td>
        <td><?= htmlspecialchars($row['owner_name']) ?></td>
        <td><?= htmlspecialchars($row['baranggay'] . ' ' . $row['municipality']) ?></td>
        <td><?= htmlspecialchars($row['recording_date']) ?></td>
        <td><?= htmlspecialchars($row['revision_code']) ?></td>
        <td>
            <a href="faas_form.php?property_ID=<?= $row['building_ID'] ?>&mode=old">
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
