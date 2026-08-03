<?php
include "config/db_connect.php";

// $b_id = isset($_GET['building_id']) ? intval($_GET['building_id']) : null;
// $desc = $struct = $appr = $assessed = [];

// if ($b_id) {
//     $desc = $conn->query("SELECT * FROM building_desc WHERE building_id = $b_id")->fetch_assoc() ?? [];
//     $struct = $conn->query("SELECT * FROM structural_material WHERE building_id = $b_id")->fetch_assoc() ?? [];
//     $appr = $conn->query("SELECT * FROM property_appraisal WHERE building_id = $b_id")->fetch_assoc() ?? [];
//     $assessed = $conn->query("SELECT * FROM property_assessment WHERE building_id = $b_id")->fetch_assoc() ?? [];
// }

function isChecked($code, $saved_string)
{
    if (empty($saved_string)) return "";
    $array = array_map('trim', explode(',', $saved_string));
    return in_array($code, $array) ? "checked" : "";
}
?>

<!doctype html>
<html lang="en">
<?php include 'header_link.php'; ?>

<!-- <select id="brgy-options" class="d-none">
    <option value="">-- Select Brgy --</option>

</select> -->
<style>
    .stepper-wrapper {
        display: flex;
        justify-content: 间-between;
        margin-bottom: 20px;
    }

    .stepper-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
    }

    .stepper-item::before {
        position: absolute;
        content: "";
        border-bottom: 2px solid #ccc;
        width: 100%;
        top: 20px;
        left: -50%;
        z-index: 0;
    }

    .stepper-item:first-child::before {
        content: none;
    }

    .stepper-item .step-counter {
        position: relative;
        z-index: 5;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e0e0e0;
        margin-bottom: 6px;
        font-weight: bold;
        transition: 0.3s;
    }

    .stepper-item.active .step-counter {
        background-color: #198754;
        color: white;
    }

    .stepper-item.completed .step-counter {
        background-color: #198754;
        color: white;
    }

    .stepper-item.active .step-name {
        font-weight: bold;
        color: #198754;
    }

    .step-name {
        font-size: 12px;
        color: #666;
    }
</style>

<body>
    <div class="container bg-white">
        <!-- For Search Building Pin UI -->
        <form class="" method="POST">
            <div class="d-flex justify-content-between align_items-center text-white my-3 fs-5 fw-bold bg-success p-2 rounded">
                <div class="flex-grow-1 text-start">REAL PROPERTY FIELD APPRAISAL & ASSESSMENT SHEET-BUILDING & OTHER STRUCTURE</div>
                <div class="input-group w-25">
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                    </span>

                    <input type="text" class="form-control border-start-0 ps-0" id="search_id" placeholder="Search by Building ID" value="<?php echo $b_id ?? '' ?>">

                    <button class="btn btn-success" type="button" id="fetchBtn">Search</button>
                </div>
            </div>
        </form>

        <!-- Form stepper -->
        <div class="stepper-wrapper mb-5 mt-4">
            <div class="stepper-item active" id="step-dot-building_description" onclick="to_building_description()">
                <div class="step-counter">1</div>
                <div class="step-name d-none d-md-block">Building Description</div>
            </div>
            <div class="stepper-item" id="step-dot-structural_material" onclick="to_structural_materials()">
                <div class="step-counter">2</div>
                <div class="step-name d-none d-md-block">Structural Materials</div>
            </div>
            <!-- <div class="stepper-item" id="step-dot-property_appraisal" onclick="to_property_appraisal()">
                <div class="step-counter">3</div>
                <div class="step-name d-none d-md-block">Property Appraisal</div>
            </div>
            <div class="stepper-item" id="step-dot-property_assessment" onclick="to_property_assessment()">
                <div class="step-counter">4</div>
                <div class="step-name d-none d-md-block">Property Assessment</div>
            </div>
            <div class="stepper-item" id="step-dot-appraisal-and-approval" onclick="to_appraisal_approval()">
                <div class="step-counter">5</div>
                <div class="step-name d-none d-md-block">Appraisal and Approval</div>
            </div>
            <div class="stepper-item" id="step-dot-superseded-assessment-record" onclick="to_superseded_record()">
                <div class="step-counter">6</div>
                <div class="step-name d-none d-md-block">Record of Superseded Assessment</div>
            </div> -->
        </div>





        <!-- Insert Data Form -->
        <?php if (isset($_GET['status'])): ?>
            <!-- <script>
                Swal.fire({
                    icon: '<?php echo $_GET['status'] === 'success' ? 'success' : 'error'; ?>',
                    title: '<?php echo $_GET['msg']; ?>',
                    timer: 2000
                });
            </script> -->
        <?php endif; ?>


        <!-- BUILDING ID -->
        <!-- <input type="hidden" name="building_id" id="building_id" value="<?php echo $desc['building_id'] ?? ''; ?>"> -->

        <!-- BUILDING DESCRIPTION -->
        <div class="text-end">TRANSACTION CODE:</div>
        <div class="card shadow-lg border-success mb-3 form-step" id="building_description">
            <form method="POST">
                <div class="p-4">
                    <div class="col-md">
                        <label for="pin" class="form_label">Enter PIN</label>
                        <input type="text" name="pin" id="pin" class="form-control border-success" placeholder="BP20-26" required />
                        <input type="number" name="building_id" id="building_id" value="<?= isset($_GET['building_ID']) ? $_GET['building_ID'] : '' ?>" class="form-control border-success" hidden />
                        <input type="number" name="building_id_2022" id="building_id_2022" value="<?= isset($_GET['property_ID']) ? $_GET['property_ID'] : '' ?>" class="form-control border-success" hidden />
                    </div>
                    <hr class="border-success">
                    <div class="row">
                        <div class="col-md">
                            <label for="" class="form-label">OWNER</label>
                            <input type="text" class="form-control border-success" name="owner_name" id="owner_name">
                        </div>
                        <div class="col-md">
                            <label for="" class="form-label">ADDRESS</label>
                            <input type="text" class="form-control border-success" name="owner_address" id="owner_address">
                        </div>
                        <div class="col-md">
                            <label for="" class="form-label">TELEPHONE NUMBER</label>
                            <input type="text" class="form-control border-success" name="owner_phone" id="owner_phone">
                        </div>
                        <div class="col-md">
                            <label for="" class="form-label">TIN</label>
                            <input type="text" class="form-control border-primary" name="owner_tin" id="owner_tin">
                        </div>
                    </div>
                    <hr class="border-success border-1">
                    <div class="row mb-4">
                        <div class="col-md">
                            <label for="" class="form-label">ADMINISTRATOR</label>
                            <input type="text" class="form-control border-success" name="admin_name" id="admin_name">
                        </div>
                        <div class="col-md">
                            <label for="" class="form-label">ADDRESS</label>
                            <input type="text" class="form-control border-success" name="admin_address" id="admin_address">
                        </div>
                        <div class="col-md">
                            <label for="" class="form-label">TELEPHONE NUMBER</label>
                            <input type="text" class="form-control border-success" name="admin_phone" id="admin_phone">
                        </div>
                        <div class="col-md">
                            <label for="" class="form-label">TIN</label>
                            <input type="text" class="form-control border-primary" name="admin_tin" id="admin_tin">
                        </div>
                    </div>
                </div>
                <div class="text-white bg-success p-2 fw-bolder">
                    <i class="bi bi-pin-map"></i> BUILDING LOCATION
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col-md">
                            <label for="" class="form-label">No./Street</label>
                            <input type="text" class="form-control border-success" name="street" id="street">
                        </div>
                        <div class="col-md">
                            <label for="" class="form-label">Brgy./District</label>
                            <input type="text" class="form-control border-success" name="baranggay" id="baranggay">
                        </div>
                        <div class="col-md">
                            <label for="" class="form-label">Municipality</label>
                            <select name="municipality" id="municipality" class="form-select">
                                <option value="">-- Select Municipality --</option>
                                <?php
                                $sql = "SELECT mun_code, mun_desc FROM municipality ORDER BY mun_desc ASC";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['mun_code'] . '">' . $row['mun_desc'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md">
                            <label for="" class="form-label">Province/City</label>
                            <input type="text" class="form-control border-success" name="province" id="province" value="Antique">
                        </div>
                    </div>
                </div>
                <div class="text-white bg-success p-2 fw-bolder">
                    <i class="bi bi-info-square"></i> LAND REFERENCE
                </div>
                <?php if (1 == 2): ?>
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label class="form-label">Owner</label>
                                    <input type="text" class="form-control border-success"
                                        name="owner_reference_name"
                                        id="owner_reference_name"
                                        value="<?= htmlspecialchars($land_reference['owner_name']) ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">TD/ARP No.</label>
                                    <input type="text" class="form-control border-success"
                                        name="arp_no"
                                        id="arp_no"
                                        value="<?= htmlspecialchars($land_reference['arp_no']) ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Area</label>
                                    <input type="text" class="form-control border-success"
                                        name="area"
                                        id="area"
                                        value="<?= htmlspecialchars($land_reference['area']) ?>">
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">OCT/TCT/CLOA No.</label>
                                            <input type="text" class="form-control border-success"
                                                name="cloa"
                                                id="cloa"
                                                value="<?= htmlspecialchars($land_reference['cloa']) ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Lot No.</label>
                                            <input type="text" class="form-control border-success"
                                                name="lot_no"
                                                id="lot_no"
                                                value="<?= htmlspecialchars($land_reference['lot_no']) ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Survey No.</label>
                                            <input type="text" class="form-control border-success"
                                                name="survey_no"
                                                id="survey_no"
                                                value="<?= htmlspecialchars($land_reference['survey_no']) ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Blk No.</label>
                                            <input type="text" class="form-control border-success"
                                                name="block_no"
                                                id="block_no"
                                                value="<?= htmlspecialchars($land_reference['block_no']) ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php else: ?>

                    <div class="alert alert-warning m-4 text-center">
                        <h5 class="mb-2">No Land Reference Found</h5>
                        <p class="mb-0">
                            No land reference record is available for this property.
                        </p>
                    </div>

                <?php endif; ?>
                <div class="text-white bg-success p-2 mb-3 fw-bolder">
                    <i class="bi bi-buildings"></i> GENERAL DESCIPTION
                </div>
                <div class="mb-3 px-4">
                    <div class="row mb-3">
                        <div class="col-md">
                            <label for="building_kind" class="form-label">Kind of Building</label>
                            <input type="text" class="form-control border-success" name="building_kind" id="building_kind">
                        </div>
                        <div class="col-md">
                            <label for="structural_type" class="form-label">Structural Type</label>
                            <select class="form-select border-success" name="structural_type" id="structural_type">
                                <option selected disabled value="">Choose type...</option>
                                <option value="I-A">I-A</option>
                                <option value="I-B">I-B</option>
                                <option value="II-A">II-A</option>
                                <option value="II-B">II-B</option>
                                <option value="II-C">II-C</option>
                                <option value="III-A">III-A</option>
                                <option value="III-B">III-B</option>
                                <option value="III-C">III-C</option>
                                <option value="III-A">IV-A</option>
                                <option value="III-B">IV-B</option>
                                <option value="III-C">IV-C</option>
                                <option value="V-A">V-C</option>
                                <option value="V-B">V-C</option>
                                <option value="V-C">V-C</option>
                            </select>
                        </div>
                        <div class="col-md">
                            <label for="cct" class="form-label">Condominium Certificate of Title (CCT)</label>
                            <input type="text" class="form-control border-success" name="cct" id="cct">
                        </div>
                    </div>
                    <div class="row">
                        <div class="card p-2 border-success text-white bg-success mb-3">
                            <div class="row">
                                <div class="col-md">
                                    <label for="building_permit_no" class="form-label">Building Permit No.</label>
                                    <input type="number" class="form-control" name="building_permit_no" id="building_permit_no">
                                </div>
                                <div class="col-md">
                                    <label for="building_permit_no" class="form-label">Date Issued</label>
                                    <input type="date" class="form-control datepicker" name="permit_date_issued" id="permit_date_issued">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md">
                            <label for="cert_completion_date" class="form-label">Certificate of Completion Issued</label>
                            <input type="date" class="form-control datepicker border-success" name="cert_completion_date" id="cert_completion_date">
                        </div>
                        <div class="col-md">
                            <label for="cert_occupancy_date" class="form-label">Certificate of Occupancy Issued</label>
                            <input type="date" class="form-control datepicker border-success" name="cert_occupancy_date" id="cert_occupancy_date">
                        </div>
                        <div class="col-md">
                            <label for="constructed_date" class="form-label">Date Constructed/Completed</label>
                            <input type="date" class="form-control datepicker border-success" name="constructed_date" id="constructed_date">
                        </div>
                        <div class="col-md">
                            <label for="occupied_date" class="form-label">Date Occupied</label>
                            <input type="date" class="form-control datepicker border-success" name="occupied_date" id="occupied_date">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md">
                            <label for="building_age" class="form-label">Building Age</label>
                            <input type="number" class="form-control border-success" name="building_age" id="building_age">
                        </div>
                        <div class="col-md">
                            <label for="storeys_no" class="form-label">Number of Storey</label>
                            <input type="number" class="form-control border-success" name="storey_no" id="storey_no">
                        </div>
                    </div>
                    <div class="row">
                        <div class="card bg-success p-2 text-white">
                            <div class="row">
                                <div class="col-md">
                                    <label for="area_first_floor" class="form-label">Area of 1st Floor</label>
                                    <input type="text" class="form-control border-success" name="area_first_floor" id="area_first_floor">
                                </div>
                                <div class="col-md">
                                    <label for="area_second_floor" class="form-label">Area of 2nd Floor</label>
                                    <input type="text" class="form-control border-success" name="area_second_floor" id="area_second_floor">
                                </div>
                                <div class="col-md">
                                    <label for="area_third_floor" class="form-label">Area of 3rd Floor</label>
                                    <input type="text" class="form-control border-success" name="area_third_floor" id="area_third_floor">
                                </div>
                                <div class="col-md">
                                    <label for="area_fourth_floor" class="form-label">Area of 4th Floor</label>
                                    <input type="text" class="form-control border-success" name="area_fourth_floor" id="area_fourth_floor">
                                </div>
                                <div class="col-md">
                                    <label for="total_floor_area" class="form-label">Total Floor Area</label>
                                    <input type="text" class="form-control border-success" name="total_floor_area" id="total_floor_area">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="text-white bg-success p-2 fw-bolder">
                    <i class="bi bi-house-exclamation"></i>RECORD OF SUPERSEDED ASSESSMENT
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col-md">
                            <label for="" class="form-label">PIN</label>
                            <input type="text" class="form-control border-success" name="previous_pin" id="previous_pin">
                        </div>
                        <div class="col-md">
                            <label for="" class="form-label">ARP No.</label>
                            <input type="text" class="form-control border-success" name="previous_arp_no" id="previous_arp_no">
                        </div>
                        <div class="col-md">
                            <label for="" class="form-label">TD No.</label>
                            <input type="text" class="form-control border-success" name="previous_td" id="previous_td">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <label for="" class="form-label">Total Assessed Value</label>
                            <input type="text" class="form-control border-success" name="previous_assessed_value" id="previous_assessed_value">
                        </div>
                        <div class="col-md">
                            <label for="" class="form-label">Previous Owner</label>
                            <input type="text" class="form-control border-success" name="previous_owner" id="previous_owner">
                        </div>
                        <div class="col-md">
                            <label for="" class="form-label">Effectivity of Assessment</label>
                            <input type="text" class="form-control border-success" name="previous_effectivity" id="previous_effectivity">
                        </div>
                    </div>
                    <div class="row">
                        <div class="card text-white bg-success py-2 mt-3">
                            <div class="row">
                                <div class="col-md">
                                    <label for="" class="form-label">Recording Person</label>
                                    <input type="text" class="form-control border-success" name="recording_person" id="recording_person">
                                </div>
                                <div class="col-md">
                                    <label for="" class="form-label">Date</label>
                                    <input type="date" class="form-control" name="recording_date" id="recording_date">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="d-flex justify-content-between align-items-center p-2">
                    <a href="javascript:void(0)" class="nav-link text-success fst-italic"></a>
                    <button class="btn btn-success fst-italic fw-bold" id="building_desc_save_btn">SAVE AND PROCEED</button>
                </div>
            </form>
        </div>

        <!-- STRUCTURAL MATERIALS -->
        <div class="card shadow-lg border-success mb-3 form-step d-none" id="structural_material">
            <form method="POST">
                <div class="text-white bg-success p-2 fw-bolder">
                    <i class="bi bi-list-check"></i> SRUCTURAL MATERIALS (CHECKLIST)
                </div>
                <div class="p-4">
                    <!-- Roof -->
                    <div class="row mb-3">

                        <div class="card border-success shadow-sm">
                            <div class="text-success fw-bold py-2 fs-4">ROOF</div>
                            <div class="row mb-3">
                                <div class="col-md">
                                    <div class="form-check p-2 border rounded mb-3">
                                        <input class="form-check-input ms-0 me-2" type="checkbox" value="Reinforced Concrete" id="rcRoof" name="roof[]" />
                                        <label for="rc" class="form-check-label d-block">Reinforced Concrete</label>
                                    </div>
                                    <div class="form-check p-2 border rounded mb-3">
                                        <input class="form-check-input ms-0 me-2" type="checkbox" value="Asbestos" id="asbestosRoof" name="roof[]" />
                                        <label for="asbestosRoof" class="form-check-label">Asbestos</label>
                                    </div>
                                    <div class="form-check p-2 border rounded mb-3">
                                        <input class="form-check-input ms-0 me-2" type="checkbox" value="Truss Framing: Steel" id="tfSteelRoof" name="roof[]" />
                                        <label for="tfSteelRoof" class="form-check-label">Truss Framing: Steel</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check p-2 border rounded mb-3">
                                        <input class="form-check-input ms-0 me-2" type="checkbox" value="Tiles" id="tilesRoof" name="roof[]" />
                                        <label for="tilesRoof" class="form-check-label">Tiles</label>
                                    </div>
                                    <div class="form-check p-2 border rounder mb-3">
                                        <input class="form-check-input  ms-0 me-2" type="checkbox" value="Long Span" id="longSpanRoof" name="roof[]" />
                                        <label for="longSpanRoof" class="form-check-label">Long Span</label>
                                    </div>
                                    <div class="form-check p-2 border rounded mb-3">
                                        <input class="form-check-input ms-0 me-2" type="checkbox" value="Truss Framing: Wood" id="tfWoodRoof" name="roof[]" />
                                        <label for="tfWoodRoof" class="form-check-label">Truss Framing: Wood</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check p-2 border rounded mb-3">
                                        <input class="form-check-input ms-0 me-2" type="checkbox" value="G.I. Sheet" id="gi_sheet_roof" name="roof[]" />
                                        <label for="gi_sheet_roof" class="form-check-label">G.I. Sheet</label>
                                    </div>
                                    <div class="form-check p-2 border rounded mb-3">
                                        <input class="form-check-input ms-0 me-2" type="checkbox" value="Concrete Desk" id="concrete_desk_roof" name="roof[]" />
                                        <label for="concrete_desk_roof" class="form-check-label">Concrete Desk</label>
                                    </div>
                                    <div class="form-check p-2 border rounded mb-3">
                                        <input class="form-check-input ms-0 me-2" type="checkbox" value="Truss Framing: Bamboo" id="tfBambooRoof" name="roof[]" />
                                        <label for="tfBambooRoof" class="form-check-label">Truss Framing: Bamboo</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check p-2 border rounded mb-3">
                                        <input class="form-check-input ms-0 me-2" type="checkbox" value="Aluminum" id="aluminum_roof" name="roof[]" />

                                        <label for="aluminum_roof" class="form-check-label">Aluminum</label>
                                    </div>
                                    <div class="form-check p-2 border rounded mb-3">
                                        <input class="form-check-input ms-0 me-2" type="checkbox" value="Nipa/Anahaw/Cogon" id="nac_roof" name="roof[]" />
                                        <label for="nac_roof" class="form-check-label">Nipa/Anahaw/Cogon</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="fw-bold text-success fs-4">FLOORS AND WALLS</div>

                        <!-- Navbar for Floors -->
                        <ul class="nav nav-tabs border-bottom-0" id="floorTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold text-uppercase px-4 text-success" id="f1-tab" data-bs-toggle="tab" data-bs-target="#f1" type="button" role="tab">1st Floor</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold text-uppercase px-4 text-success" id="f2-tab" data-bs-toggle="tab" data-bs-target="#f2" type="button" role="tab">2nd Floor</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold text-uppercase px-4 text-success" id="f3-tab" data-bs-toggle="tab" data-bs-target="#f3" type="button" role="tab">3rd Floor</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold text-uppercase px-4 text-success" id="f4-tab" data-bs-toggle="tab" data-bs-target="#f4" type="button" role="tab">4th Floor</button>
                            </li>
                        </ul>

                        <div class="tab-content border p-4 bg-white shadow-sm rounded-bottom" id="floorTabContent">

                            <!-- 1st Floor -->
                            <?php
                            function floorSuffix($n)
                            {
                                if ($n == 1) return "st";
                                if ($n == 2) return "nd";
                                if ($n == 3) return "rd";
                                return "th";
                            }
                            ?>

                            <?php for ($i = 1; $i <= 4; $i++): ?>
                                <div class="tab-pane fade <?= $i == 1 ? 'show active' : '' ?>" id="f<?= $i ?>" role="tabpanel">
                                    <h5 class="text-success border-bottom pb-2 mb-3">
                                        <?= $i . floorSuffix($i) ?> Floor Materials
                                    </h5>

                                    <div class="row g-3">
                                        <div class="col-md-6 border-end">

                                            <!-- FLOORING -->
                                            <label class="fw-bold mb-2 text-success">FLOORING</label>
                                            <div class="row">
                                                <div class="col-md">
                                                    <?php
                                                    $flooring1 = ["RC" => "Reinforced Concrete", "Marble", "Tiles"];
                                                    foreach ($flooring1 as $val => $label):
                                                        if (is_numeric($val)) $val = $label;
                                                    ?>
                                                        <div class="form-check p-2 border rounded mb-3">
                                                            <input class="form-check-input ms-0 me-2"
                                                                type="checkbox"
                                                                value="<?= $val ?>"
                                                                id="<?= strtolower(str_replace(' ', '', $val)) ?>ID<?= $i ?>"
                                                                name="floor<?= $i ?>[]" />
                                                            <label class="form-check-label d-block"><?= $label ?> </label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>

                                                <div class="col-md">
                                                    <?php
                                                    $flooring2 = ["PC" => "Plain Cement", "Wood"];
                                                    foreach ($flooring2 as $val => $label):
                                                        if (is_numeric($val)) $val = $label;
                                                    ?>
                                                        <div class="form-check p-2 border rounded mb-3">
                                                            <input class="form-check-input ms-0 me-2"
                                                                type="checkbox"
                                                                value="<?= $val ?>"
                                                                id="<?= strtolower(str_replace(' ', '', $val)) ?>ID<?= $i ?>"
                                                                name="floor<?= $i ?>[]" />
                                                            <label class="form-check-label d-block"><?= $label ?></label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>

                                            <!-- COLUMNS -->
                                            <label class="fw-bold mb-2 text-success">COLUMNS</label>
                                            <div class="row">
                                                <?php
                                                $columns = ["RC", "Wood", "Steel", "Bamboo"];
                                                foreach ($columns as $col):
                                                ?>
                                                    <div class="col-md">
                                                        <div class="form-check p-2 border rounded mb-3">
                                                            <input class="form-check-input ms-0 me-2"
                                                                type="checkbox"
                                                                value="Columns <?= $col ?>"
                                                                id="columns<?= $col ?>ID<?= $i ?>"
                                                                name="floor<?= $i ?>[]" />
                                                            <label class="form-check-label d-block">Columns: <?= $col ?></label>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>

                                            <!-- BEAMS -->
                                            <label class="fw-bold mb-2 text-success">BEAMS</label>
                                            <div class="row">
                                                <?php
                                                $beams = ["RC", "Wood", "Steel", "Bamboo"];
                                                foreach ($beams as $beam):
                                                ?>
                                                    <div class="col-md">
                                                        <div class="form-check p-2 border rounded mb-3">
                                                            <input class="form-check-input ms-0 me-2"
                                                                type="checkbox"
                                                                value="Beams <?= $beam ?>"
                                                                id="beams<?= $beam ?>ID<?= $i ?>"
                                                                name="floor<?= $i ?>[]" />
                                                            <label class="form-check-label d-block">Beams: <?= $beam ?></label>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>

                                        </div>

                                        <!-- RIGHT SIDE -->
                                        <div class="col-md-6">
                                            <label class="fw-bold mb-2 text-success">WALLS</label>
                                            <div class="row">
                                                <?php
                                                $walls = [
                                                    "RC" => "Reinforced Concrete",
                                                    "Wood",
                                                    "GI Sheet",
                                                    "Plywood",
                                                    "Plain Cement",
                                                    "CHB",
                                                    "Build-a-wall",
                                                    "Bamboo"
                                                ];

                                                foreach ($walls as $val => $label):
                                                    if (is_numeric($val)) $val = $label;
                                                ?>
                                                    <div class="col-md-6">
                                                        <div class="form-check p-2 border rounded mb-3">
                                                            <input class="form-check-input ms-0 me-2"
                                                                type="checkbox"
                                                                value="Walls <?= $val ?>"
                                                                id="walls<?= str_replace(' ', '', $val) ?>ID<?= $i ?>"
                                                                name="floor<?= $i ?>[]" />
                                                            <label class="form-check-label d-block"><?= $label ?></label>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <?php endfor; ?>


                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center p-2">
                    <a href="javascript:void(0)" class="nav-link text-success fst-italic" onclick="to_building_description()">BUILDING DESCRIPTION</a>
                    <button class="btn btn-success fst-italic fw-bold" id="structural_materials_btn">SAVE AND PROCEED</button>
                    <!-- <button class="btn btn-success fst-italic fw-bold" name="structural_materials_btn" onclick="to_property_appraisal()">SAVE AND PROCEED<i class="bi bi-arrow-right-square-fill"></i></button> -->
                </div>
            </form>
        </div>

        <!-- PROPERTY APPRAISAL -->
        <div class="card shadow-lg border-success mb-3 form-step d-none" id="property_appraisal">
            <div class="text-white bg-success p-2 fw-bolder">
                <i class="bi bi-house-exclamation"></i> PROPERTY APPRAISAL
            </div>
            <div class="p-4">
                <div class="row g3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Unit Construction Cost(sq.m.): P</label>
                            <input type="text" class="form-control border-success" name="ucc" id="ucc" value="<?php echo $appr['ucc'] ?? '';  ?>" />
                        </div>
                        <div class="mb-0">
                            <label for="sub_total" class="form-label">Sub-Total: </label>
                            <input type="text" class="form-control border-success" name="sub_total" id="sub_total" value="<?php echo $appr['sub_total'] ?? '' ?>" />
                        </div>
                    </div>
                    <div class="col-md-6 d-flex flex-column">
                        <label class="form-label">Building Core</label>
                        <textarea class="form-control border-success flex-grow-1" id="building_core" name="building_core" style="height: 100px;" value=""><?php echo $appr['building_core'] ?? '' ?></textarea>
                    </div>
                </div>

                <div class="row mt-3 mb-3">
                    <div class="col-12">
                        <div class="card border-success p-3 bg-light shadow-sm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Depreciation Rate</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control border-success" name="depreciation_rate" id="depreciation_rate" value="<?php echo $appr['depreciation_rate'] ?? '' ?>">
                                        <span for="depreciation_rate" class="input-group-text bg-success text-white border-success">%</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="depreciation_cost" class="form-label">Depreciation Cost: </label>
                                    <input type="text" class="form-control border-success" name="depreciation_cost" id="depreciation_cost" value="<?php echo $appr['depreciation_cost'] ?? '' ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="card bg-success text-white p-3">
                        <div class="row g-3">
                            <div class="col-md-6 d-flex flex-column">
                                <label for="cost_additional_items" class="form_label">Cost of Additional Items</label>
                                <textarea name="cost_additional_items" id="cost_additional_items" class="form-control border-success flex-grow-1"><?php echo $appr['cost_additional_items'] ?? '' ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="subtotal" class="form-label">Sub-Total: P</label>
                                    <input type="text" class="form-control border-success" name="subtotal" id="subtotal" value="<?php echo $appr['subtotal'] ?? '' ?>" />
                                </div>
                                <div class="mb-0">
                                    <label for="total_construction_cost" class="form-label">Total Cosntruction Cost: P</label>
                                    <input type="text" class="form-control border-success" name="total_construction_cost" id="total_construction_cost" value="<?php echo $appr['total_construction_cost'] ?? '' ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card border-success p-3 bg-light shadow-sm">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="" class="form-label text-success">Total Depreciation</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control border-success" name="total_depreciation" id="total_depreciation" value="<?php echo $appr['total_depreciation'] ?? '' ?>" />
                                                <span class="input-group-text bg-success text-white border-success">%</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="" class="form-label text-success">Market Value</label>
                                            <input type="text" class="form-control border-success" name="appraisal_market_value" id="appraisal_market_value" value="<?php echo $appr['market_value'] ?? '' ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center p-2">
                <a href="javascript:void(0)" class="nav-link text-success fst-italic" onclick="to_structural_materials()"><<<----Previous< /a>
                        <button class="btn btn-success fst-italic fw-bold" onclick="to_property_assessment()" name="appraisal_btn">PROPERTY ASSESSMENT <i class="bi bi-arrow-right-square-fill"></i></button>
            </div>
        </div>

        <!-- PROPERTY ASSESSMENT -->
        <div class="card shadow-lg border-success mb-3 form-step d-none" id="property_assessment">
            <div class="text-white bg-success p-2 fw-bolder">
                <i class="bi bi-house-exclamation"></i>PROPERTY ASSESSMENT
            </div>
            <div class="p-4">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0" style="min-width: 600px;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 25%;">Actual Use</th>
                                <th>Market Value</th>
                                <th>Assessment Level</th>
                                <th>Assessed Value</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="addRow">
                            <tr>
                                <td>
                                    <input type="text" class="form-control form-control-sm" name="actual_use[]" id="assessment_actual_use" value="<?php echo $assessed['actual_use'] ?? '' ?>">
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" name="assess_market_value[]" id="assess_market_value" value="<?php echo $assessed['market_value'] ?? '' ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control text-end" name="assessment_level[]" id="assessment_level" value="<?php echo $assessed['assessment_level'] ?? '' ?>">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control text-end" name="assessed_value[]" id="assessed_value" value="<?php echo $assessed['assessed_value'] ?? '' ?>">
                                    </div>
                                </td>
                            </tr>

                            <tr class="table-secondary">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control form-control-sm me-2" name="total_actual_use" id="total_actual_use" style="width: 40px;" value="<?php echo $assessed['total_actual_use'] ?? '' ?>">
                                        <span class="fw-bold">Total</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-transparent">₱</span>
                                        <input type="text" class="form-control text-end fw-bold" id="total_market_val" name="total_market_val" value="<?php echo $assessed['total_market_value'] ?? '' ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control text-end fw-bold" name="total_assessment_level" id="total_assessment_level" value="<?php echo $assessed['total_assessment_level'] ?? '' ?>">
                                        <span class="input-group-text bg-transparent">%</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-transparent">₱</span>
                                        <input type="text" class="form-control text-end fw-bold" id="total_assessed_value" name="total_assessed_value" value="<?php echo $assessed['total_assessed_value'] ?? '' ?>">
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <button type="button" class="btn btn-success" onclick="addRow()">Add Row</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-3 border-top bg-light">
                    <div class="row g-3 align-items-center">

                        <div class="col-md-auto">
                            <div class="d-flex gap-4">
                                <div class="form-check mb-0">
                                    <input type="checkbox" name="taxable" id="taxable" value="1" class="form-check-input" <?php echo (isset($assessed['taxable']) && $assessed['taxable'] == 1) ? 'checked' : ''; ?>>
                                    <label for="taxable" class="form-check-label fw-semibold small">Taxable</label>
                                </div>
                                <div class="form-check mb-0">
                                    <input type="checkbox" name="exempt" id="exempt" value="1" class="form-check-input" <?php echo (isset($assessed['exempt']) && $assessed['exempt'] == 1) ? 'checked' : ''; ?>>
                                    <label for="exempt" class="form-check-label fw-semibold small">Exempt</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="d-flex align-items-center gap-2">
                                <label for="effective_assessment" class="text-secondary fw-bold small text-nowrap mb-0">Effectivity of Assessment</label>
                                <input type="text" name="effective_assessment" id="effective_assessment" class="form-control form-control-sm" style="max-width: 1000px;" value="<?php echo $assessed['effectivity_assessment'] ?? '' ?>">
                            </div>
                        </div>

                        <div class="col-md-auto">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white text-secondary small">Qtr</span>
                                <input type="text" name="qtr" id="qtr" class="form-control text-center" style="max-width: 45px;" value="<?php echo $assessed['qtr'] ?? '' ?>">

                                <span class="input-group-text bg-white text-secondary small">Yr</span>
                                <input type="text" name="yr" id="yr" class="form-control text-center" style="max-width: 65px;" value="<?php echo $assessed['yr'] ?? '' ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center p-2">
                <a href="javascript:void(0)" class="nav-link text-success fst-italic" onclick="to_property_appraisal()"><<<----Previous< /a>
                        <a class="btn btn-success fst-italic fw-bold" onclick="to_appraisal_approval()">NEXT <i class="bi bi-arrow-right-square-fill"></i></a>
            </div>
        </div>

        <!-- APPRAISAL AND APPROVAL -->
        <div class="card shadow-lg border-success mb-3 form-step d-none" id="appraisal_approval">
            <div class="text-white bg-success p-2 fw-bolder">
                <i class="bi bi-house-exclamation"></i> APPRAISAL AND APPROVAL
            </div>
            <div class="p-4">
                <div class="row">
                    <div class="text-success fw-bold">APPRAISED / ASSESSED BY</div>
                    <div class="mb-3 col-md">
                        <label for="" class="form-label">Name</label>
                        <input type="text" name="appraiser_name" id="appraiser_name" class="form-control border-success" value="<?php echo $assessed['appraiser_name'] ?? '' ?>">
                    </div>
                    <div class="mb-3 col-md">
                        <label for="" class="form-label">Date</label>
                        <input type="date" name="date_appraiser" id="date_appraiser" class="form-control border-success" value="<?php echo $assessed['appraiser_date'] ?? '' ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="text-success fw-bold">RECOMMENDING APPROVAL</div>
                    <div class="mb-3 col-md">
                        <label for="" class="form-label">Name</label>
                        <input type="text" name="recomending_approval_name" id="recomending_approval_name" class="form-control border-success" value="<?php echo $assessed['recommending_approval_name'] ?? '' ?>">
                    </div>
                    <div class="mb-3 col-md">
                        <label for="" class="form-label">Date</label>
                        <input type="date" name="recomending_approval_date" id="recomending_approval_date" class="form-control border-success" value="<?php echo $assessed['recommending_approval_date'] ?? '' ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="card bg-success text-white py-2">
                        <div class="row">
                            <div class="fw-bold">APPROVED BY</div>
                            <div class="mb-3 col-md">
                                <label for="" class="form-label">Name</label>
                                <input type="text" name="approved_by" id="approved_by" class="form-control border-success" value="ATTY. SILVESTRE C UNTARAN III" disabled aria-describedby="approved_by">
                            </div>
                            <div class="mb-3 col-md">
                                <label for="" class="form-label">Date</label>
                                <input type="date" class="form-control " id="date_approved" name="date_approved" value="<?php echo $assessed['approved_by_date'] ?? '' ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <label for="" class="form-label">MEMORANDA</label>
                        <textarea name="memoranda" id="memoranda" class="form-control border-success flex-grow-1"><?php echo $assessed['memoranda'] ?? '' ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <label for="" class="form-label">Date of Entry in the Record of Assessment</label>
                        <input type="date" name="entry_date" id="entry_date" class="form-control border-success" value="<?php echo $assessed['date_of_entry'] ?? '' ?>">
                    </div>
                    <div class="col-md">
                        <label for="" class="form-label">Name</label>
                        <input type="text" name="recorder_name" id="recorder_name" class="form-control border-success" placeholder="Name" value="<?php echo $assessed['recorder_name'] ?? '' ?>">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center p-2">
                <a href="javascript:void(0)" class="nav-link text-success fst-italic" onclick="to_property_assessment()"><<<----Previous< /a>
                        <a class="btn btn-success fst-italic fw-bold" onclick="to_superseded_record()">NEXT <i class="bi bi-arrow-right-square-fill"></i></a>
            </div>
        </div>

        <!-- SUPERSEDED RECORD -->
        <div class="card shadow-lg border-success mb-3 form-step d-none" id="superseded_record">
            <div class="text-white bg-success p-2 fw-bolder">
                <i class="bi bi-house-exclamation"></i>RECORD OF SUPERSEDED ASSESSMENT
            </div>
            <div class="p-4">
                <div class="row">
                    <div class="col-md">
                        <label for="" class="form-label">PIN</label>
                        <input type="text" class="form-control border-success" name="recorded_pin" id="recorded_pin" value="<?php echo $assessed['recorded_pin'] ?? '' ?>">
                    </div>
                    <div class="col-md">
                        <label for="" class="form-label">ARP No.</label>
                        <input type="number" class="form-control border-success" name="recorded_arp" id="recorded_arp" value="<?php echo $assessed['recorded_arp'] ?? '' ?>">
                    </div>
                    <div class="col-md">
                        <label for="" class="form-label">TD No.</label>
                        <input type="number" class="form-control border-success" name="recorded_td" id="recorded_td" value="<?php echo $assessed['recorded_td'] ?? '' ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <label for="" class="form-label">Total Assessed Value</label>
                        <input type="text" class="form-control border-success" name="recorded_assessed_val" id="recorded_assessed_val" value="<?php echo $assessed['recorded_total_assessed_value'] ?? '' ?>">
                    </div>
                    <div class="col-md">
                        <label for="" class="form-label">Previous Owner</label>
                        <input type="text" class="form-control border-success" name="prev_owner" id="prev_owner" value="<?php echo $assessed['recorded_prev_owner'] ?? '' ?>">
                    </div>
                    <div class="col-md">
                        <label for="" class="form-label">Effectivity of Assessment</label>
                        <input type="text" class="form-control border-success" name="effectivity_assessment" id="recorded_effectivity_assessment" value="<?php echo $assessed['recorded_eao'] ?? '' ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="card text-white bg-success py-2 mt-3">
                        <div class="row">
                            <div class="col-md">
                                <label for="" class="form-label">Recording Person</label>
                                <input type="text" class="form-control border-success" name="recording_person" id="recording_person" value="<?php echo $assessed['recording_person'] ?? '' ?>">
                            </div>
                            <div class="col-md">
                                <label for="" class="form-label">Date</label>
                                <input type="date" class="form-control" name="recording_date" id="recorded_date" value="<?php echo $assessed['recording_date'] ?? '' ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center p-2">
                <a href="javascript:void(0)" class="nav-link text-success fst-italic" onclick="to_appraisal_approval()"><<<----Previous< /a>
                        <button class="btn btn-success fst-italic fw-bold" name="assessment_btn">SUBMIT</button>
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

    <script src="script.js"></script>

    <script>
        // $building_id = $('#building_id').val();
        $building_id = $('#building_id').val();
        $building_id_2022 = $('#building_id_2022').val();
        // getProperty($building_id);
        // alert("Data fetched successfully!");

        if ($building_id_2022 || $building_id) {

            getPropertyRevised($building_id_2022, $building_id);
            loadStructural($building_id);
        }


        function getPropertyRevised(building_id_2022, building_id) {

            $.ajax({
                url: "ajax.php?action=get_property_revised",
                type: "GET",
                data: {
                    building_id: building_id,
                    building_id_2022: building_id_2022
                },
                dataType: "json",
                success: function(data) {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    $.each(data, function(key, value) {
                        // target inputs, selects, textarea
                        let el = $("#" + key);

                        if (el.length) {
                            el.val(value);
                        }
                    });


                    // alert($("#input_new_property_ID").val());
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert("Server Error: " + xhr.status);
                },
            });
        }


        function loadStructural(building_id) {
            $.ajax({
                url: 'ajax.php?action=get_structural_materials',
                type: 'GET',
                data: {
                    building_id: building_id
                },
                dataType: 'json',
                success: function(res) {

                    if (!res.success || !res.data) return;

                    let d = res.data;

                    // helper
                    function checkValues(values, name) {
                        if (!values) return;

                        let arr = values.split(',').map(v => v.trim());

                        arr.forEach(val => {
                            $(`input[name="${name}[]"][value="${val}"]`).prop('checked', true);
                        });
                    }

                    // -------------------
                    // ROOF
                    // -------------------
                    checkValues(d.roof, 'roof');

                    // -------------------
                    // FLOORS
                    // -------------------
                    checkValues(d.first_floor_flooring, 'floor1');
                    checkValues(d.second_floor_flooring, 'floor2');
                    checkValues(d.third_floor_flooring, 'floor3');
                    checkValues(d.fourth_floor_flooring, 'floor4');

                    checkValues(d.first_floor_wall, 'floor1');
                    checkValues(d.second_floor_wall, 'floor2');
                    checkValues(d.third_floor_wall, 'floor3');
                    checkValues(d.fourth_floor_wall, 'floor4');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }


        // --- YOUR ORIGINAL NAVIGATION LOGIC ---
        function navigateTo(stepId) {
            // 1. Hide all form sections
            const sections = document.querySelectorAll('.form-step');
            sections.forEach(s => s.classList.add('d-none'));

            // 2. Show target section
            const target = document.getElementById(stepId);
            if (target) {
                target.classList.remove('d-none');
            }

            // 3. Map Step Section IDs to Stepper Dot IDs
            const stepMapping = {
                'building_description': 'step-dot-building_description',
                'structural_material': 'step-dot-structural_material',
                'property_appraisal': 'step-dot-property_appraisal',
                'property_assessment': 'step-dot-property_assessment',
                'appraisal_approval': 'step-dot-appraisal-and-approval',
                'superseded_record': 'step-dot-superseded-assessment-record'
            };

            const targetDotId = stepMapping[stepId];
            const stepperItems = document.querySelectorAll('.stepper-item');
            let foundActive = false;

            stepperItems.forEach(item => {
                if (item.id === targetDotId) {
                    item.classList.add('active');
                    item.classList.remove('completed');
                    foundActive = true;
                } else {
                    item.classList.remove('active');
                    // Marks ONLY previous steps as completed
                    item.classList.toggle('completed', !foundActive);
                }
            });

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Wrapper functions
        function to_building_description() {
            navigateTo('building_description');
        }

        function to_structural_materials() {
            navigateTo('structural_material');
        }

        function to_property_appraisal() {
            navigateTo('property_appraisal');
        }

        function to_property_assessment() {
            navigateTo('property_assessment');
        }

        function to_appraisal_approval() {
            navigateTo('appraisal_approval');
        }

        function to_superseded_record() {
            navigateTo('superseded_record');
        }


        // --- NEW: AUTO-NAVIGATE AFTER PHP REDIRECT ---
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const msg = urlParams.get('msg');

            // If PHP redirected with success and the description was saved
            if (msg.includes('General Description Saved') || msg.includes('General Description Updated Successfully')) {
                // Move from Step 1 to Step 2
                navigateTo('structural_material');
            } else if (msg.includes('Structural Materials Saved') || msg.includes('Structural Material Updated Successfully')) {
                // Move from Step 2 to Step 3
                navigateTo('property_appraisal');
            } else if (msg.includes('Property Appraisal Saved') || msg.includes('Property Appraisal Updated Successfully')) {
                // Move from Step 3 to Step 4
                navigateTo('property_assessment');
            } else if (msg.includes('Property Assessment Saved Successfully') || msg.includes('Property Assessment Updated Successfully')) {

                navigateTo('building_description');
                alert("Record saved successfully! The form has been cleared for a new entry.");

                window.history.replaceState({}, document.title, window.location.pathname + (hasBuildingId ? '?building_id=' + urlParams.get('building_id') : ''));
            }
        });
    </script>


</body>

</html>