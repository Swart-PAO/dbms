function selectOptionData($options)
{

global $conn;

if (!$options) {
return '<option value="">-- No options available --</option>';
}

if ($options === 'land_class') {
$options = '<option value="">-- Select Classification --</option>';
$sql = "SELECT class_ID, classification FROM classification";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
$options .= '<option value="' . $row['classification'] . '">' . $row['classification'] . '</option>';
}
}
} else if ($options === 'actual_use') {
$options = '<option value="">-- Select Actual Use --</option>';

$sql_au = "SELECT description, taxability, assessment_level FROM au_tbl";
$result_au = $conn->query($sql_au);

if ($result_au->num_rows > 0) {
while ($row = $result_au->fetch_assoc()) {
$options .= '
<option
    value="' . htmlspecialchars($row['description']) . '"
    data-taxability="' . htmlspecialchars($row['taxability']) . '"
    data-assessment_lvl="' . htmlspecialchars($row['assessment_level']) . '">
    ' . htmlspecialchars($row['description']) . '
</option>';
}
}
} else if ($options === 'non_agri_kind') {

$options = '<option value="">-- Select Kind --</option>';
$sql_nao = "SELECT `PROPERTY_DESCRIPTION` FROM non_agri_classification";
$result_nao = $conn->query($sql_nao);

if ($result_nao->num_rows > 0) {
while ($row = $result_nao->fetch_assoc()) {
$options .= '<option value="' . $row['PROPERTY_DESCRIPTION'] . '">' . $row['PROPERTY_DESCRIPTION'] . '</option>';
}
}
}


return $options;
}

const agri_class_options = '<?= selectOptionData('land_class') ?>';
const actual_use_option = '<?= selectOptionData('actual_use') ?>';
const agri_class_options = '<?= selectOptionData('non_agri_kind') ?>';