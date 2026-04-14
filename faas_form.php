<!DOCTYPE html>
<html lang="en">
<?php include 'header_link.php';
require_once 'php/php_class.php';
$municipalities = getMunicipalities(); ?>

<?php
include 'db_connect.php';

$options = '<option value="">-- Select Classification --</option>';
$sql = "SELECT class_ID, classification FROM classification ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . $row['classification'] . '">' . $row['classification'] . '</option>';
    }
}

$au_options = '<option value="">-- Select Actual Use --</option>';

$sql_au = "SELECT description, taxability, assessment_level FROM au_tbl";
$result_au = $conn->query($sql_au);

if ($result_au->num_rows > 0) {
    while ($row = $result_au->fetch_assoc()) {
        $au_options .= '
            <option 
                value="' . htmlspecialchars($row['description']) . '" 
                data-taxability="' . htmlspecialchars($row['taxability']) . '"
                data-assessment_lvl="' . htmlspecialchars($row['assessment_level']) . '">
                ' . htmlspecialchars($row['description']) . '
            </option>';
    }
}


$non_agri_options = '<option value="">-- Select Kind --</option>';
$sql_nao = "SELECT `PROPERTY_DESCRIPTION` FROM non_agri_classification";
$result_nao = $conn->query($sql_nao);

if ($result_nao->num_rows > 0) {
    while ($row = $result_nao->fetch_assoc()) {
        $non_agri_options .= '<option value="' . $row['PROPERTY_DESCRIPTION'] . '">' . $row['PROPERTY_DESCRIPTION'] . '</option>';
    }
}
?>
<!-- <select id="brgy-options" class="d-none">
    <option value="">-- Select Brgy --</option>

</select> -->


<body class="bg-light">
    <div id="mytask-layout" class="theme-indigo">

        <div class=" container my-5">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white text-center py-3 d-flex justify-content-between align-items-center">
                    <a href="index.php" class="btn btn-light btn-sm">
                        <i class="icofont-home fs-5"></i> Home
                    </a>
                    <h3 class=" mb-0">FAAS Property Form</h3>
                    <a href="printable_property.php?faas_id=<?= $row['FAAS_ID'] ?>" class="btn btn-light btn-sm">
                        <i class="icofont-print fs-5"></i> Print
                    </a>
                </div>
                <div class=" card-body p-4">

                    <!-- Search Section -->
                    <form class="mb-4">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">PIN</label>
                                <input type="text" class="form-control" id="search_pin" placeholder="Enter PIN">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-bold">Municipality</label>
                                <select name="mun_code" id="mun_code" class="form-select">
                                    <option value="">-- Select Municipality --</option>

                                    <?php foreach ($municipalities as $mun): ?>
                                        <option value="<?= (int) $mun['mun_code'] ?>">
                                            <?= htmlspecialchars($mun['mun_desc']) ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <button type="button" class="btn btn-success w-100" id="searchPinBtn">
                                    <i class="bi bi-search"></i> Fetch
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row align-items-center">
                        <div class="border-0 mb-4">
                            <div class="card-header p-0 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <h3 class="fw-bold py-3 mb-0"></h3>
                                <div class="d-flex py-2 project-tab flex-wrap w-sm-100">
                                    <!-- <button type="button" class="btn btn-dark w-sm-100" data-bs-toggle="modal" data-bs-target="#createproject"><i class="icofont-plus-circle me-2 fs-6"></i>Create Project</button> -->
                                    <ul class="nav nav-tabs tab-body-header rounded ms-3 prtab-set w-sm-100" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#Property-Tab" role="tab">Property Information</a></li>
                                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#Land-Tab" role="tab">Agricultural</a></li>
                                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#Non-Land-Tab" role="tab">Non-Agricultural</a></li>
                                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#Maket-Value-Tab" role="tab">Market Value</a></li>
                                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#Assessment-Tab" role="tab">Assessment</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 flex-column">
                        <div class="tab-content mt-4">

                            <div class="tab-pane fade show active" id="Property-Tab">
                                <form>
                                    <!-- Basic Property Information -->
                                    <div class="card border-success mb-4">
                                        <input name="input_old_property_ID" id="input_old_property_ID" type="text" value="<?= isset($_GET['property_ID']) ? $_GET['property_ID'] : '' ?>" hidden>
                                        <input name="input_new_property_ID" id="input_new_property_ID" type="text" value="<?= isset($_GET['FAAS_ID']) ? $_GET['FAAS_ID'] : '' ?>" hidden>
                                        <!-- <input name="input_land_ID" id="input_land_ID" type="text"> -->
                                        <div class="card-header bg-light fw-bold" data-bs-toggle="collapse" data-bs-target="#prop_info_section" style="cursor:pointer;">
                                            Administrator Information
                                        </div>
                                        <div class="card-body collapse show" id="prop_info_section">

                                            <h5> Title </h5>
                                            <div class="row mb-3 d-noneS">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <label class="form-label me-2 mb-0" for="transaction_code">Transaction Code:</label>

                                                    <input type="text" class="form-control" name="transaction_code" id="transaction_code" value="GR" style="width: auto;">
                                                </div>


                                            </div>

                                            <div class="row g-5">
                                                <!-- Left Column -->
                                                <div class="col-md-6">

                                                    <div class="row mb-3">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">ARP No:</label>
                                                            <input type="text" class="form-control" name="ARP_no" id="ARP_no">

                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">OCT/TCT/CLOA:</label>
                                                            <input type="text" class="form-control" name="title_type" id="title_type">
                                                        </div>

                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Title Dated:</label>
                                                            <input type="text" class="form-control" name="title_dated" id="title_dated">
                                                        </div>
                                                    </div>

                                                </div>

                                                <!-- Right Column -->
                                                <div class="col-md-6 border-start">

                                                    <div class="row mb-3">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">PIN:</label>
                                                            <input type="text" class="form-control" name="PIN_no" id="PIN_no">
                                                        </div>
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0" for="transaction_code">Revision Code:</label>
                                                            <select name="revision_code" id="revision_code" class="form-select">
                                                                <option value="GR">GR</option>
                                                                <option value="New">New</option>
                                                                <option value="Cancelled">Cancelled</option>
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class=" row mb-3">
                                                        <div class="col-md-4 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Survey:</label>
                                                            <input type="text" class="form-control" name="survey" id="survey">
                                                        </div>
                                                        <div class="col-md-4 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Lot No:</label>
                                                            <input type="text" class="form-control" name="lot_no" id="lot_no">
                                                        </div>
                                                        <div class="col-md-4 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Block (BLK):</label>
                                                            <input type="text" class="form-control" name="BLK" id="BLK">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <hr>
                                            <h5> Owner Information </h5>
                                            <div class="row g-5">

                                                <div class="col-md-6">
                                                    <div class="row mb-1">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0">Owner</label>
                                                            <input type="text" class="form-control" name="owner_name" id="owner_name">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0">Address</label>
                                                            <input type="text" class="form-control" name="owner_address" id="owner_address">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-5 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0">Tel No</label>
                                                            <input type="text" class="form-control" name="owner_no" id="owner_no">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 border-start">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Owner TIN</label>
                                                        <input type="text" class="form-control" name="owner_tin" id="owner_tin">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <!-- Administrator Information -->
                                            <h5>Administrator Information</h5>
                                            <div class="row g-5">
                                                <div class="col-md-6 border-end">
                                                    <div class="row mb-1">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0">Admin Name:</label>
                                                            <input type="text" class="form-control" name="admin_name" id="admin_name">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0">Admin Address:</label>
                                                            <input type="text" class="form-control" name="admin_address" id="admin_address">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0">Admin No:</label>
                                                            <input type="text" class="form-control" name="admin_no" id="admin_no">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="row mb-1">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0">Admin TIN:</label>
                                                            <input type="text" class="form-control" name="admin_tin" id="admin_tin">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- Property Location -->
                                    <div class="card border-success mb-4">
                                        <div class="card-header bg-light fw-bold" data-bs-toggle="collapse" data-bs-target="#prop-loc-section" style="cursor:pointer;">
                                            Property Location
                                        </div>
                                        <div class="card-body collapse show" id="prop-loc-section">

                                            <h5> Location </h5>
                                            <div class="row g-5">
                                                <div class="col-md-6">

                                                    <div class="row mb-1">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0">Street No:</label>
                                                            <input type="text" class="form-control" name="street_no" id="street_no">
                                                        </div>

                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0">Barangay:</label>
                                                            <input type="text" class="form-control" name="property_brgy" id="property_brgy">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label fw-bold">Municipality</label>
                                                            <select name="property_municipality" id="property_municipality" class="form-select">
                                                                <option value="">-- Select Municipality --</option>

                                                                <?php foreach ($municipalities as $mun): ?>
                                                                    <option value="<?= (int) $mun['mun_code'] ?>">
                                                                        <?= htmlspecialchars($mun['mun_desc']) ?>
                                                                    </option>
                                                                <?php endforeach; ?>

                                                            </select>
                                                        </div>

                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0">Province:</label>
                                                            <input type="text" class="form-control" name="property_province" id="property_province" value="Antique" readonly>
                                                        </div>
                                                    </div>

                                                    <h5>Property Boundaries</h5>

                                                    <div class="row">
                                                        <div class="col-md-12 d-flex align-items-center mb-2">
                                                            <select class="form-select me-2" name="north" id="north" style="min-width: 100px;">
                                                                <option selected disabled value="">North</option>
                                                                <option value="North">North</option>
                                                                <option value="North East">North East</option>
                                                                <option value="North West">North West</option>
                                                            </select>
                                                            <input type="text" class="form-control" name="northern" id="northern">
                                                        </div>

                                                        <div class="col-md-12 d-flex align-items-center mb-2">
                                                            <select class="form-select me-2" name="east" id="east" style="min-width: 100px;">
                                                                <option selected disabled value="">East</option>
                                                                <option value="East">East</option>
                                                                <option value="North East">North East</option>
                                                                <option value="South East">South East</option>
                                                            </select>
                                                            <input type="text" class="form-control" name="eastern" id="eastern">
                                                        </div>

                                                        <div class="col-md-12 d-flex align-items-center mb-2">
                                                            <select class="form-select me-2" name="south" id="south" style="min-width: 100px;">
                                                                <option selected disabled value="">South</option>
                                                                <option value="South">South</option>
                                                                <option value="South East">South East</option>
                                                                <option value="South West">South West</option>
                                                            </select>
                                                            <input type="text" class="form-control" name="southern" id="southern">
                                                        </div>

                                                        <div class="col-md-12 d-flex align-items-center mb-2">
                                                            <select class="form-select me-2" name="west" id="west" style="min-width: 100px;">
                                                                <option selected disabled value="">West</option>
                                                                <option value="West">West</option>
                                                                <option value="North West">North West</option>
                                                                <option value="South West">South West</option>
                                                            </select>
                                                            <input type="text" class="form-control" name="western" id="western">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-6 d-flex justify-content-center align-items-center mt-2">
                                                    <div style="width: 300px; height: 300px; border: 2px solid black; position: relative; text-align: center; background-image: url('your-image.jpg'); background-size: cover; background-position: center; opacity: 1;">
                                                        <!-- Watermark overlay (faded) -->
                                                        <div style="position: absolute; inset: 0; background-image: url('your-image.jpg'); background-size: cover; background-position: center; opacity: 0.1; z-index: 0;"></div>

                                                        <!-- Direction labels -->
                                                        <div style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); font-weight: bold; z-index: 1;">North</div>
                                                        <div style="position: absolute; bottom: -20px; left: 50%; transform: translateX(-50%); font-weight: bold; z-index: 1;">South</div>
                                                        <div style="position: absolute; top: 50%; left: -30px; transform: translateY(-50%) rotate(-90deg); font-weight: bold; z-index: 1;">West</div>
                                                        <div style="position: absolute; top: 50%; right: -30px; transform: translateY(-50%) rotate(90deg); font-weight: bold; z-index: 1;">East</div>

                                                        <!-- Center label -->
                                                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 14px; color: gray; z-index: 1;">
                                                            Land Sketch
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border-success mb-4">
                                        <div class="card-header bg-light fw-bold" data-bs-toggle="collapse" data-bs-target="#rec-seded-section" style="cursor:pointer;">
                                            Record of Superseded
                                        </div>
                                        <div class="card-body collapse show" id="rec-seded-section">

                                            <h5> Previous Tax Dec </h5>

                                            <div class="row g-5">
                                                <!-- Left Column -->
                                                <div class="col-md-6 border-end">

                                                    <div class="row mb-3">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Previous PIN:</label>
                                                            <input type="text" class="form-control" name="previous_pin" id="previous_pin">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Previous ARP No:</label>
                                                            <input type="text" class="form-control" name="previous_ARP_no" id="previous_ARP_no">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Total Assessed Value:</label>
                                                            <input type="number" class="form-control" name="previous_assessed_value" id="previous_assessed_value">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Previous Owner:</label>
                                                            <input type="text" class="form-control" name="previous_owner" id="previous_owner">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Effectivity:</label>
                                                            <input type="text" class="form-control" name="previous_effectivity" id="previous_effectivity">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                    <div class="row mb-3">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">TD No:</label>
                                                            <input type="text" class="form-control" name="previous_td_no" id="previous_td_no">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Right Column -->

                                            </div>

                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-8 offset-md-2">
                                            <label class="form-label">Remarks:</label>
                                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter remarks here..."></textarea>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="text-center mt-4">
                                        <button type="submit" id="faasSaveBtn" class="btn btn-success px-5">Save</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Land Appraisal Section -->
                            <div class="tab-pane fade" id="Land-Tab">
                                <div class="card border-success mb-4">
                                    <div class="card-header bg-light fw-bold" data-bs-toggle="collapse" data-bs-target="#agricultural-section" style="cursor:pointer;">
                                        Land Appraisal
                                    </div>
                                    <div class="card-body collapse show" id="agricultural-section">

                                        <h5> Agricultural </h5>
                                        <div class="row g-5">
                                            <div class="container">
                                                <form id="agricultural-form">
                                                    <table class="table table-bordered" id="classification-table">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Classification</th>
                                                                <th>Sub-classification</th>
                                                                <th>Area (Hectare)</th>
                                                                <th>Unit Value</th>
                                                                <th>Base Market Value</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>

                                                        </tbody>

                                                        <tfoot class="table-secondary fw-bold">
                                                            <tr>
                                                                <td colspan="2" class="text-end">TOTAL:</td>
                                                                <td id="total-area">0</td>
                                                                <td></td>
                                                                <td id="total-bmv">0</td>
                                                                <td> <button id="add-row-land" type="button" class="btn btn-sm btn-warning">Add</button></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                    <button id="save-land" type="submit" class="btn btn-success">Save to Database</button>
                                                </form>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Residential Section -->
                            <div class="tab-pane fade" id="Non-Land-Tab">
                                <div class="card border-success mb-4">
                                    <div class="card-header bg-light fw-bold" data-bs-toggle="collapse" data-bs-target="#residential-section" style="cursor:pointer;">
                                        Residential, Commercial, Industrial, Special
                                    </div>
                                    <div class="card-body collapse show" id="residential-section">

                                        <h5> Residential </h5>
                                        <div class="row g-5">
                                            <div class="container">
                                                <form id="residential-form">
                                                    <table class="table table-bordered" id="residential-table">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Kind</th>
                                                                <th>Area (Meter)</th>
                                                                <th>Unit Value</th>
                                                                <th>Adjustment Factor</th>
                                                                <th>Base Market Value</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                        <tfoot class="table-secondary fw-bold">
                                                            <tr>
                                                                <td colspan="2" class="text-end">TOTAL:</td>
                                                                <td id="total-area-residential">0</td>
                                                                <td></td>
                                                                <td id="total-bmv-residential">0</td>
                                                                <td> <button id="add-row-residential" type="button" class="btn btn-sm btn-warning">Add</button></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>

                                                    <button id="save-residential" type="submit" class="btn btn-success">Save</button>
                                                </form>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Land Market Value Section -->
                            <div class="tab-pane fade" id="Maket-Value-Tab">
                                <div class="card border-success mb-4">
                                    <div class="card-header bg-light fw-bold" data-bs-toggle="collapse" data-bs-target="#market-value-section" style="cursor:pointer;">
                                        Market Value
                                    </div>
                                    <div class="card-body collapse show" id="market-value-section">

                                        <form id="market-value-form">
                                            <h5> Market Value </h5>
                                            <div class="row g-5">


                                                <!-- Left Column -->

                                                <div class="col-md-6">
                                                    <div class="row mb-2">

                                                        <div class="col-md-4">
                                                            <label for="bmv" class="form-label">Base MV</label>
                                                            <input type="bmv" class="form-control" id="mvbmv" name="mvbmv" required readonly>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="lastname" class="form-label">Factors</label>
                                                            <select id="factor_first" name="factor_first" class="form-control" required>
                                                                <option value="">-- Select Factor --</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Percentage</label>
                                                            <select id="percentage_first" name="percentage_first" class="form-control" required>
                                                                <option value="">-- Select Percentage --</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">

                                                        <div class="col-md-4 ">
                                                        </div>
                                                        <div class="col-md-4">

                                                            <select id="factor_second" name="factor_second" class="form-control" required>
                                                                <option value="">-- Select Factor --</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">

                                                            <select id="percentage_second" name="percentage_second" class="form-control" required>
                                                                <option value="">-- Select Percentage --</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">

                                                        <div class="col-md-4 ">

                                                        </div>
                                                        <div class="col-md-4">

                                                            <input type="text" class="form-control" name="factor_third" id="factor_third">
                                                        </div>
                                                        <div class="col-md-4">

                                                            <select id="percentage_third" name="percentage_third" class="form-control" required>
                                                                <option value="">-- Select Percentage --</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                </div>
                                            </div>

                                            <div class="row g-5">
                                                <div class="col-md-6">

                                                    <div class="row mt-4">

                                                        <div class="col-md-4 ">

                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label float-end">Total</label>
                                                        </div>
                                                        <div class="col-md-4">

                                                            <input type="number" class="form-control" name="percent_total" id="percent_total">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Right Column -->
                                                <div class="col-md-4">
                                                    <div class="row mb-2">

                                                        <div class="col-md-6">
                                                            <label for="value_adjustment" class="form-label">Value Adjusment</label>
                                                            <input type="text" class="form-control" name="value_adjustment" id="value_adjustment" required readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="market_value" class="form-label">Market Value</label>
                                                            <input type="text" class="form-control" name="market_value" id="market_value" required readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <button id="save-market-value" type="submit" class="btn btn-success">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="Assessment-Tab">
                                <div class="card border-success mb-4">
                                    <div class="card-header bg-light fw-bold" data-bs-toggle="collapse" data-bs-target="#assessment-section" style="cursor:pointer;">
                                        Property Assessment
                                    </div>
                                    <div class="card-body collapse show" id="assessment-section">

                                        <h5> Property Assessment </h5>
                                        <div class="row g-5 mb-3">
                                            <div class="container">
                                                <form id="assessment-form">
                                                    <table class="table table-bordered" id="assessment-table">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Actual Use</th>
                                                                <th>Taxable</th>
                                                                <th>Market Value</th>
                                                                <th>Assessment Level (%)</th>
                                                                <th>Assessed Value</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                        <tfoot class="table-secondary fw-bold">
                                                            <tr>
                                                                <td colspan="2" class="text-end">TOTAL:</td>
                                                                <td id="total-area-assessment">0</td>
                                                                <td></td>
                                                                <td id="total-bmv-assessment">0</td>
                                                                <td> <button id="add-row-assessment" type="button" class="btn btn-sm btn-warning">Add</button></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>

                                                    <button id="save-assessment" type="submit" class="btn btn-success">Save</button>

                                                </form>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="form_success_saved" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Processing</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body text-center">

                        <!-- 🔄 LOADING STATE -->
                        <div id="loadingState">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-3 fs-5">Saving data, please wait...</p>
                        </div>

                        <!-- ✅ SUCCESS STATE -->
                        <div id="successState" style="display:none;">
                            <i class="icofont-check-circled text-success display-2"></i>
                            <p class="mt-4 fs-5" id="successMessage">Form Saved Successfully</p>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
</body>

<?php include 'footer_script.php'; ?>

</html>

<script src="faas_form.js"></script>
<script src="dynamic_row.js"></script>

<script>
    const municipalityOptions = <?= json_encode($options) ?>;
    const au_options = <?= json_encode($au_options) ?>;
    const non_agri_options = <?= json_encode($non_agri_options) ?>;
</script>