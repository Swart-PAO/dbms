<!DOCTYPE html>
<html lang="en">
<?php include 'header_link.php'; ?>

<?php
include 'db_connect.php';

$options = '<option value="">-- Select Municipality --</option>';
$sql = "SELECT class_ID, classification FROM classification ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . $row['classification'] . '">' . $row['classification'] . '</option>';
    }
}
?>


<!-- <select id="brgy-options" class="d-none">
    <option value="">-- Select Brgy --</option>

</select> -->


<body class="bg-light">

    <div class="container my-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center py-3">
                <h3 class="mb-0">FAAS Property Form</h3>
            </div>
            <div class="card-body p-4">

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
                                <?php

                                $sql1 = "SELECT * FROM municipality";
                                $result1 = $conn->query($sql1);

                                if ($result1->num_rows > 0) {
                                    while ($row1 = $result1->fetch_assoc()) {

                                        echo '<option value="' . $row1['mun_code'] . '">' . $row1['mun_desc'] . '</option>';
                                    }
                                }
                                ?>

                            </select>
                        </div>

                        <div class="col-md-3 d-flex align-items-end">
                            <button type="button" class="btn btn-success w-100" id="fetchBtn">
                                <i class="bi bi-search"></i> Fetch
                            </button>
                        </div>
                    </div>
                </form>
                <form>


                    <div class="card border-success mb-4">
                        <div class="card-header bg-light fw-bold" data-bs-toggle="collapse" data-bs-target="#general-description-section" style="cursor:pointer;">
                            General Description
                        </div>
                        <div class="card-body collapse show" id="general-description-section">

                            <h5> Building </h5>

                            <div class="row g-5">
                                <!-- Left Column -->
                                <div class="col-md-6 border-end">

                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Kind of Building:</label>
                                            <input type="text" class="form-control" name="kind_of_building" id="kind_of_building">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Structural Type: </label>
                                            <input type="text" class="form-control" name="structural_type" id="structural_type">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Building Permit no</label>
                                            <input type="text" class="form-control" name="building_permit_no" id="building_permit_no">
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Date Issued</label>
                                            <input type="date" class="form-control" name="permit_date_issued" id="permit_date_issued">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Condominium Certificate of Title (CCT)</label>
                                            <input type="text" class="form-control" name="cct" id="cct">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Certificate of Completion Issued on:</label>
                                            <input type="date" class="form-control" name="cert_completion_date" id="cert_completion_date">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Certificate of Completion Issued on:</label>
                                            <input type="date" class="form-control" name="cert_completion_date" id="cert_completion_date">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Date Constructed/Completed:</label>
                                            <input type="date" class="form-control" name="constructed_date" id="constructed_date">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Date Occupied:</label>
                                            <input type="date" class="form-control" name="occupied_date" id="occupied_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Building Age:</label>
                                            <input type="number" class="form-control" name="building_age" id="building_age">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">No. of Storeys:</label>
                                            <input type="number" class="form-control" name="storeys_no" id="storeys_no">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Area of 1st floor</label>
                                            <input type="number" class="form-control" name="area_first_floor" id="area_first_floor">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Area of 2nd floor:</label>
                                            <input type="number" class="form-control" name="area_second_floor" id="area_second_floor">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Area of 3rd floor</label>
                                            <input type="number" class="form-control" name="area_third_floor" id="area_third_floor">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Area of 4th floor</label>
                                            <input type="number" class="form-control" name="area_fourth_floor" id="area_fourth_floor">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Total Floor Area</label>
                                            <input type="number" class="form-control" name="floor_total_area" id="floor_total_area">
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column -->

                            </div>

                        </div>
                    </div>

                    <div class="card border-success mb-4">
                        <div class="card-header bg-light fw-bold" data-bs-toggle="collapse" data-bs-target="#structural-material-section" style="cursor:pointer;">
                            Structural Materials
                        </div>
                        <div class="card-body collapse show" id="structural-material-section">

                            <h5>Roof and Floooring </h5>

                            <div class="row g-5">
                                <div class="table-responsive">
                                    <table class="table table-striped custom-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%; ">Roof</th>
                                                <th class="text-center"></th>
                                                <th style="width: 15%">Floooring</th>
                                                <th class="text-center">1st Flr</th>
                                                <th class="text-center">2nd Flr</th>
                                                <th class="text-center">3rd Flr</th>
                                                <th class="text-center">4th Flr</th>
                                                <th style="width: 10%;">Wall & Partition</th>
                                                <th class="text-center">1st Flr</th>
                                                <th class="text-center">2nd Flr</th>
                                                <th class="text-center">3rd Flr</th>
                                                <th class="text-center">4th Flr</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold">Reinforced Concrete</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="fw-bold">Reinforced Concrete for upper floors</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="fw-bold">Reinforced Concrete</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="fw-bold">Tiles</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="fw-bold">Plain Cement</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="fw-bold">Plain Cement</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">G.I. Sheet</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="fw-bold">Marble</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="fw-bold">Wood</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Aluminum</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="fw-bold">Wood</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="fw-bold">CHB</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Asbestos</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="fw-bold">Tiles</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="fw-bold">G.I Sheet</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="fw-bold">Long Span</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="fw-bold">Other (specify) Elevated</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="fw-bold">Build-a-wall</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Concrete Desk</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="fw-bold">Columns: RC</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="fw-bold">Plywood</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Nipa/Anahaw/Cogon</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="fw-bold">Steel</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="fw-bold">Bamboo</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Others(Specify)</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="fw-bold">Wood</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="fw-bold">Others(Specify)</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold"></td>
                                                <td class="text-center">

                                                </td>
                                                <td class="fw-bold">Bamboo</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Truss Framing</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="fw-bold">Beams: RC</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Steel</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="fw-bold">Steel</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Wood</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="fw-bold">Wood</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Bamboo</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="fw-bold">Bamboo</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="card border-success mb-4">
                        <div class="card-header bg-light fw-bold" data-bs-toggle="collapse" data-bs-target="#prop-appraisal-section" style="cursor:pointer;">
                            Property Appraisal
                        </div>
                        <div class="card-body collapse show" id="prop-appraisal-section">

                            <h5> Information </h5>

                            <div class="row g-5">
                                <div class="col-md-6">

                                    <div class="row mb-1">
                                        <div class=" col-md-8 d-flex align-items-center mb-1">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Unit Construction Cost(sq.m.): P</label>
                                            <input type="text" class="form-control" name="ARP_no" id="ARP_no">
                                        </div>
                                        <div class="col-md-12 d-flex">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Building Core</label>
                                            <textarea class="form-control" id="myTextarea" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-5">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Cost of Additional Items:</label>
                                            <input type="text" class="form-control" name="cost_additional_items" id="cost_additional_items">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row g-5">
                                <div class="col-md-6">

                                    <div class="row mb-1 mt-4">
                                        <div class="col-md-4 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Sub-Total: P</label>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-center">
                                            <input type="text" class="form-control" name="ARP_no" id="ARP_no">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-md-4 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Depreciation Rate: P</label>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-center">
                                            <input type="text" class="form-control" name="ARP_no" id="ARP_no">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Depreciation Cost: P</label>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-center">
                                            <input type="text" class="form-control" name="ARP_no" id="ARP_no">
                                        </div>
                                    </div>

                                </div>


                                <div class="col-md-6">



                                    <div class="row mb-1 mt-4">
                                        <div class="col-md-4 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Sub-Total: P</label>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-center">
                                            <input type="text" class="form-control" name="ARP_no" id="ARP_no">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-md-4 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Total Construction Cost: P</label>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-center">
                                            <input type="text" class="form-control" name="ARP_no" id="ARP_no">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-md-4 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Total % Depreciation:</label>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-center">
                                            <input type="text" class="form-control" name="ARP_no" id="ARP_no">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Market Value: P</label>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-center">
                                            <input type="text" class="form-control" name="ARP_no" id="ARP_no">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

</body>

<?php include 'footer_script.php'; ?>

</html>

<script src="faas_form.js"></script>

<script>
    const municipalityOptions = `<?= $options ?>`;

    function createRow() {
        return `
    <tr>
        <td>
            <select class="form-control classification" name="classification[]">
                ${municipalityOptions}
            </select>
        </td>
        <td>
            <select class="form-control sub_class" name="sub_class[]">
                <option value="">-- Select Sub --</option>
                <option value="1">1st</option>
                <option value="2">2nd</option>
                <option value="3">3rd</option>
                <option value="4">4th</option>
            </select>
        </td>
        <td><input type="number" class="form-control area" placeholder="Area"></td>
        <td><input type="number" class="form-control unit-value" placeholder="Unit Value"></td>
        <td><input type="text" class="form-control bmv" placeholder="BMV" readonly></td>
        <td><button class="btn btn-danger btn-sm remove-row">Remove</button></td>
    </tr>`;
    }

    // Use class instead of id to avoid duplicates
    // $(document).on("change", ".classification", function() {
    //     // alert($(this).val());
    //     var mun_code = $(this).val();


    //     var $row = $(this).closest("tr");
    //     var $subClass = $row.find(".sub_class");


    //     if (mun_code !== "") {
    //         $.ajax({
    //             url: "php/get_barangay.php",
    //             type: "POST",
    //             data: {
    //                 mun_code: mun_code
    //             },
    //             success: function(data) {
    //                 $subClass.html(data);
    //             },
    //         });
    //     } else {
    //         $subClass.html('<option value="">-- Select Barangay --</option>');
    //     }
    // });
</script>

<!-- <script>
    $(document).ready(function() {

        let property_ID = $('input[name="property_ID"]').val();
        // alert(property_ID);
        if (property_ID) {
            $.ajax({
                url: "ajax.php?action=get_property_revised",
                type: "GET",
                data: {
                    property_ID: property_ID
                }, // pass the FAAS_ID dynamically
                dataType: "json",
                success: function(data) {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    $('input[name="PIN_no"]').val($.trim(data.previous_pin));
                    $('input[name="BLK"]').val($.trim(data.BLK));
                    $('input[name="title_type"]').val($.trim(data.title_type));
                    $('input[name="lot_no"]').val($.trim(data.lot_no));
                    $('input[name="survey"]').val($.trim(data.survey));
                    $('input[name="owner_name"]').val($.trim(data.owner_name));
                    $('input[name="owner_address"]').val($.trim(data.owner_address));
                    $('input[name="owner_no"]').val($.trim(data.owner_no));
                    $('input[name="owner_tin"]').val($.trim(data.owner_tin));
                    $('input[name="admin_name"]').val($.trim(data.admin_name));
                    $('input[name="admin_address"]').val($.trim(data.admin_address));
                    $('input[name="admin_no"]').val($.trim(data.admin_no));
                    $('input[name="admin_tin"]').val($.trim(data.admin_tin));
                    $('input[name="property_brgy"]').val($.trim(data.property_brgy));
                    $('#property_municipality').val($.trim(data.property_municipality));

                    $('input[name="northern"]').val($.trim(data.northern));
                    $('input[name="eastern"]').val($.trim(data.eastern));
                    $('input[name="southern"]').val($.trim(data.southern));
                    $('input[name="western"]').val($.trim(data.western));
                    $('input[name="previous_pin"]').val($.trim(data.previous_pin));
                    $('input[name="previous_td_no"]').val($.trim(data.previous_td_no));
                    $('input[name="previous_assessed_value"]').val($.trim(data.previous_assessed_value));
                    $('input[name="previous_ARP_no"]').val($.trim(data.previous_ARP_no));
                    $('input[name="previous_owner"]').val($.trim(data.owner_name));
                    $('input[name="previous_effectivity"]').val($.trim(data.previous_effectivity));
                    $('input[name="street_no"]').val($.trim(data.street_no));

                    setSelectValue($('select[name="north"]'), $.trim(data.north));
                    setSelectValue($('select[name="east"]'), $.trim(data.east));
                    setSelectValue($('select[name="west"]'), $.trim(data.west));
                    setSelectValue($('select[name="south"]'), $.trim(data.south));

                }
            });
        }


        $('#mun_code').on('change', function() {
            let value = $(this).val();
            $('#property_municipality').val(value);
        });
        $('#property_municipality').on('change', function() {
            let value = $(this).val();
            $('#mun_code').val(value);
        });
        $('#prop_info_section').collapse('hide');
        $('#prop-loc-section').collapse('hide');
        $('#general-description-section').collapse('hide');
        $('#prop_info_section').collapse('hide');
        $('#prop-loc-section').collapse('hide');
        $('#general-description-section').collapse('hide');
        $('#structural-material-section').collapse('hide');
        // let $sel_north = $('select[name="north"]');
        // let $sel_east = $('select[name="east"]');
        // let $sel_west = $('select[name="west"]');
        // let $sel_south = $('select[name="south"]');
        $('#rec-seded-section').collapse('hide');
        $("#faas-insert-btn").on("click", function(e) {
            e.preventDefault(); // prevent normal form submit

            let form = $(this).closest("form"); // get the parent form
            $.ajax({
                url: "ajax.php?action=insert_property",
                type: "POST",
                data: form.serialize(), // send all input names/values
                success: function(response) {
                    alert(response); // show success or error message
                    location.href = 'faas_form.php'; // reload the page to see changes
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        });

    });
    $('#fetchBtn').click(function() {
        const pin = $('#search_pin').val();
        const mun_code = $('#mun_code').val();



        if (pin === '') {
            alert('Please enter a PIN No');
            return;
        }
        if (mun_code === '') {
            alert('Please enter a PIN No');
            return;
        }
        $.ajax({
            url: 'ajax.php?action=get_property_previous',
            type: 'GET',
            data: {
                search_pin: pin,
                mun_code: mun_code
            },
            dataType: 'json',
            success: function(data) {
                if (data.error) {
                    alert('Error: ' + data.error);
                } else {
                    $('input[name="PIN_no"]').val(data.previous_pin);
                    $('input[name="BLK"]').val(data.BLK);
                    $('input[name="title_type"]').val(data.title_type);
                    $('input[name="lot_no"]').val(data.lot_no);
                    $('input[name="survey"]').val(data.survey);
                    $('input[name="owner_name"]').val(data.owner_name);
                    $('input[name="owner_address"]').val(data.owner_address);
                    $('input[name="owner_no"]').val(data.owner_no);
                    $('input[name="owner_tin"]').val(data.owner_tin);
                    $('input[name="admin_name"]').val(data.admin_name);
                    $('input[name="admin_address"]').val(data.admin_address);
                    $('input[name="admin_no"]').val(data.admin_no);
                    $('input[name="admin_tin"]').val(data.admin_tin);
                    $('input[name="property_brgy"]').val(data.property_brgy);
                    $('input[name="property_municipality"]').val(data.property_municipality);
                    $('input[name="northern"]').val(data.northern);
                    $('input[name="eastern"]').val(data.eastern);
                    $('input[name="southern"]').val(data.southern);
                    $('input[name="western"]').val(data.western);
                    $('input[name="previous_pin"]').val(data.previous_pin);
                    $('input[name="previous_td_no"]').val(data.previous_td_no);
                    $('input[name="previous_assessed_value"]').val(data.previous_assessed_value);
                    $('input[name="previous_ARP_no"]').val(data.previous_ARP_no);
                    $('input[name="previous_owner"]').val(data.owner_name);
                    $('input[name="previous_effectivity"]').val(data.previous_effectivity);
                    $('input[name="street_no"]').val(data.street_no);
                    $('input[name="property_ID"]').val(data.property_ID);
                    setSelectValue($('select[name="north"]'), data.north);
                    setSelectValue($('select[name="east"]'), data.east);
                    setSelectValue($('select[name="west"]'), data.west);
                    setSelectValue($('select[name="south"]'), data.south);
                    // $sel_north.find('option:selected').text(data.north).val(data.north);
                    // $sel_east.find('option:selected').text(data.east).val(data.east);
                    // $sel_west.find('option:selected').text(data.west).val(data.west);
                    // $sel_south.find('option:selected').text(data.south).val(data.south);
                    // $('select[name="south"]').val("SOUTH");
                    // $('select[name="east"]').val("SOUTH");
                    // $('select[name="north"]').val("SOUTH");
                    // $('select[name="west"]').val("SOUTH");

                }
            },
            error: function(xhr, status, error) {
                alert('AJAX error: ' + error);
            }
        });
    });

    function setSelectValue($select, value) {
        // If the option doesn't exist, add it
        if ($select.find(`option[value="${value}"]`).length === 0) {
            $select.append(new Option(value, value, true, true)); // select it immediately
        } else {
            $select.val(value); // select existing option
        }
    }

    function fetchData() {

    }
</script>
<script>
    $(document).ready(function() {
        function recalculateTotals() {
            let totalArea = 0;
            let totalBMV = 0;

            $('#classification-table tbody tr').each(function() {
                const area = parseFloat($(this).find('.area').val()) || 0;
                const unitValue = parseFloat($(this).find('.unit-value').val()) || 0;
                const baseMarketValue = area * unitValue;

                $(this).find('.bmv').val(baseMarketValue.toFixed(2));

                totalArea += area;
                totalBMV += baseMarketValue;
            });

            $('#total-area').text(totalArea.toFixed(2));
            $('#total-bmv').text(totalBMV.toFixed(2));
        }

        function createRow() {
            return `<tr>
        <td><input type="text" class="form-control classification" placeholder="Classification"></td>
        <td><input type="text" class="form-control sub-classification" placeholder="Sub-classification"></td>
        <td><input type="number" class="form-control area" placeholder="Area"></td>
        <td><input type="number" class="form-control unit-value" placeholder="Unit Value"></td>
        <td><input type="text" class="form-control bmv" placeholder="BMV" readonly></td>
        <td><button class="btn btn-danger btn-sm remove-row">Remove</button></td>
      </tr>
    `;
        }


        $('#classification-table tbody').append(createRow());

        // Add row button
        $('#add-row').click(function() {
            $('#classification-table tbody').append(createRow());
        });

        // Remove row
        $('#classification-table').on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
            recalculateTotals();
        });

        // Trigger calculation on input
        $('#classification-table').on('input', '.area, .unit-value', function() {
            recalculateTotals();
        });
    });
</script> -->