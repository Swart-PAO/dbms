<?php

require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/db_connect.php';

$mun_code = $_POST['mun_code'];

$sql = "SELECT *
        FROM barangay_list
        WHERE mun_code='$mun_code'
        ORDER BY brgy_name";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {

?>

    <div class="col-4">
        <div class="barangay-folder text-center p-2"
            data-brgy="<?= $row['brgy_name'] ?>">

            <i class="icofont-folder text-warning fs-2"></i>

            <div class="small mt-2">
                <?= $row['brgy_name'] ?>
            </div>

        </div>
    </div>

<?php } ?>