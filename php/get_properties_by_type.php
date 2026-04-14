<?php
require_once 'php_class.php';

$faas_type = $_POST['faas_type'] ?? '';

$results = getPropertiesByFAASType($mun_code, $brgy_session, $faas_type);

while ($row = $results->fetch_assoc()) {

    echo "<tr>

<td>{$row['PIN']}</td>

<td>{$row['NAME OF OWNER']}</td>

<td>{$row['LOCATION OF PROPERTY']}</td>

<td>{$row['CADASTRAL LOT NUMBER']}</td>

<td>{$row['DATE OF TRANSACTION']}</td>

<td>{$row['TRANCODE']}</td>

<td>
<a href='faas_form.php?property_ID={$row['property_ID']}'
class='btn btn-outline-secondary'>

<i class='icofont-bubble-right text-success'></i>

</a>
</td>

</tr>";
}
