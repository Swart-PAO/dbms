<?php
require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/db_connect.php';
require_once ROOT_PATH . '/php/php_class.php';
require_once ROOT_PATH . '/link/header_link.php';
$municipalities = getMunicipalities();

function isChecked($code, $saved_string)
{
    if (empty($saved_string)) return "";
    $array = array_map('trim', explode(',', $saved_string));
    return in_array($code, $array) ? "checked" : "";
}
?>

<!doctype html>
<html lang="en">


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

        </div>


        <div class="text-end">TRANSACTION CODE:</div>
        <div class="card shadow-lg border-success mb-3 form-step" id="building_description">
            <form method="POST">
                <div class="row mb-1 mt-2">
                    <div class="col-md-12 text-center">
                        <label class="form-label fw-bold fs-5 mb-2">PROPERTY IDENTIFICATION NUMBER (PIN)</label>

                        <div class="d-flex justify-content-center">
                            <div class="input-group input-group-lg" style="max-width: 750px;">
                                <span class="input-group-text fw-bold" id="pin_prefix">X X X-X X-X X X X</span>
                                <input type="text"
                                    class="form-control text-center fw-bold fs-4"
                                    name="pin"
                                    id="pin"
                                    placeholder="0001-00001">
                                <input type="number"
                                    class="form-control text-center fw-bold fs-4"
                                    name="bin"
                                    id="bin"
                                    placeholder="0001">


                                <select name="revision_code" id="revision_code" class="form-select">
                                    <option value="GR">GR</option>
                                    <option value="New">New</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <div class="col-md">

                        <input
                            id="input_property_ID"
                            name="input_property_ID"
                            value="<?= $_GET['property_ID'] ?? '' ?>">

                        <input
                            id="mode"
                            name="mode"
                            value="<?= $_GET['mode'] ?? '' ?>">
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
                            <select name="baranggay" id="baranggay" class="form-select" required>
                                <option>-- Select Barangay --</option>
                                <!-- Options will load dynamically -->
                            </select>
                        </div>
                        <div class="col-md">
                            <label for="" class="form-label">Municipality</label>
                            <select name="municipality" id="municipality" class="form-select">
                                <option value="">-- Select Municipality --</option>

                                <?php foreach ($municipalities as $mun): ?>
                                    <option value="<?= (int) $mun['mun_code'] ?>">
                                        <?= htmlspecialchars($mun['mun_name']) ?>
                                    </option>
                                <?php endforeach; ?>
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
                <?php if (1 == 1): ?>
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label class="form-label">Owner</label>
                                    <input type="text" class="form-control border-success"
                                        name="ref_owner_name"
                                        id="ref_owner_name">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">TD/ARP No.</label>
                                    <input type="text" class="form-control border-success"
                                        name="ref_td_no"
                                        id="ref_td_no">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Area</label>
                                    <input type="text" class="form-control border-success"
                                        name="ref_area"
                                        id="ref_area">
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">OCT/TCT/CLOA No.</label>
                                            <input type="text" class="form-control border-success"
                                                name="ref_title_type"
                                                id="ref_title_type">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Lot No.</label>
                                            <input type="text" class="form-control border-success"
                                                name="ref_lot_no"
                                                id="ref_lot_no">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Survey No.</label>
                                            <input type="text" class="form-control border-success"
                                                name="ref_survey_no"
                                                id="ref_survey_no">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Blk No.</label>
                                            <input type="text" class="form-control border-success"
                                                name="ref_block_no"
                                                id="ref_block_no">
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

    <script src="building_form.js"></script>
    <script>
        const BASE_URL = <?= json_encode(BASE_URL) ?>;
    </script>


</body>

</html>