<!DOCTYPE html>
<html lang="en">
<?php ?>

<head>
    <meta charset="UTF-8">
    <title>FAAS Property Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php
$faas_id = $_GET['faas_id'];

echo $faas_id;

?>

<body class="bg-light">

    <div class="container my-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center py-3">
                <h3 class="mb-0">FAAS Property Form</h3>
            </div>
            <div class="card-body p-4">

                <form>

                    <!-- Basic Property Information -->
                    <div class="card border-success mb-4">
                        <div class="card-header bg-light fw-bold" data-bs-toggle="collapse" data-bs-target="#prop_info_section" style="cursor:pointer;">
                            Administrator Information
                        </div>
                        <div class="card-body collapse show" id="prop_info_section">

                            <h5> Title
                            </h5>
                            <div class="row mb-3 justify-content-end">
                                <div class="col-md-4 d-flex align-items-center">
                                    <label class="form-label me-2 mb-0" for="transaction_code">Transaction Code:</label>
                                    <input type="text" class="form-control" name="transaction_code" id="transaction_code" value="GR"
                                        style="width: auto;">
                                    <input type="text" class="form-control" name="faas_id" id="faas_id" value="<?= $faas_id ?>">
                                </div>
                            </div>

                            <div class="row g-5">
                                <!-- Left Column -->
                                <div class="col-md-6">

                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">ARP No:</label>
                                            <input type="text" class="form-control" name="ARP_no">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">OCT/TCT/CLOA:</label>
                                            <input type="text" class="form-control" name="title_type">
                                        </div>

                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Title Dated:</label>
                                            <input type="text" class="form-control" name="title_dated">
                                        </div>
                                    </div>

                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6 border-start">

                                    <div class="row mb-3">
                                        <div class="col-md-4 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">PIN:</label>
                                            <input type="text" class="form-control" name="PIN_no">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Survey:</label>
                                            <input type="text" class="form-control" name="survey">
                                        </div>
                                        <div class="col-md-4 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Lot No:</label>
                                            <input type="text" class="form-control" name="lot_no">
                                        </div>
                                        <div class="col-md-4 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Block (BLK):</label>
                                            <input type="text" class="form-control" name="BLK">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <hr>
                            <h5> Owner Information
                            </h5>
                            <div class="row g-5">

                                <div class="col-md-6">
                                    <div class="row mb-1">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0">Owner</label>
                                            <input type="text" class="form-control" name="owner_name">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0">Address</label>
                                            <input type="text" class="form-control" name="owner_address">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0">Tel No</label>
                                            <input type="text" class="form-control" name="owner_no">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 border-start">
                                    <div class="col-md-4">
                                        <label class="form-label">Owner TIN</label>
                                        <input type="text" class="form-control" name="owner_tin">
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
                                            <input type="text" class="form-control" name="admin_name">
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0">Admin Address:</label>
                                            <input type="text" class="form-control" name="admin_address">
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0">Admin No:</label>
                                            <input type="text" class="form-control" name="admin_no">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">

                                    <div class="row mb-1">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0">Admin TIN:</label>
                                            <input type="text" class="form-control" name="admin_tin">
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>


                    <div class="card border-success mb-4">
                        <div class="card-header bg-light fw-bold" data-bs-toggle="collapse" data-bs-target="#prop-loc-section" style="cursor:pointer;">
                            Property Location
                        </div>
                        <div class="card-body collapse show" id="prop-loc-section">


                            <h5> Location
                            </h5>
                            <div class="row g-5">
                                <div class="col-md-6">


                                    <div class="row mb-1">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0">Street No:</label>
                                            <input type="text" class="form-control" name="street_no">
                                        </div>

                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0">Barangay:</label>
                                            <input type="text" class="form-control" name="property_brgy">
                                        </div>
                                    </div>



                                    <div class="row mb-1">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label Municipality="form-label me-2 mb-0">Municipality:</label>
                                            <select name="property_municipality" id="property_municipality" class="form-select">
                                                <option value="">-- Select Municipality --</option>
                                                <?php
                                                include 'db_connect.php'; // make sure you have mysqli connection here


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

                                        <div class="col-md-6 d-flex align-items-center">
                                            <label Municipality="form-label me-2 mb-0">Province:</label>
                                            <input type="text" class="form-control" name="property_province" value="Antique" readonly>
                                        </div>
                                    </div>



                                    <h5>Property Boundaries</h5>

                                    <div class="row">

                                        <div class="col-md-12 d-flex align-items-center mb-2">
                                            <select class="form-select me-2" name="north" style="min-width: 100px;">
                                                <option selected disabled value="">North</option>
                                                <option value="North">North</option>
                                                <option value="North East">North East</option>
                                                <option value="North West">North West</option>
                                            </select>
                                            <input type="text" class="form-control" name="northern">
                                        </div>

                                        <div class="col-md-12 d-flex align-items-center mb-2">
                                            <select class="form-select me-2" name="east" style="min-width: 100px;">
                                                <option selected disabled value="">East</option>
                                                <option value="East">East</option>
                                                <option value="North East">North East</option>
                                                <option value="South East">South East</option>
                                            </select>
                                            <input type="text" class="form-control" name="eastern">
                                        </div>

                                        <div class="col-md-12 d-flex align-items-center mb-2">
                                            <select class="form-select me-2" name="south" style="min-width: 100px;">
                                                <option selected disabled value="">South</option>
                                                <option value="South">South</option>
                                                <option value="South East">South East</option>
                                                <option value="South West">South West</option>
                                            </select>
                                            <input type="text" class="form-control" name="southern">
                                        </div>

                                        <div class="col-md-12 d-flex align-items-center mb-2">
                                            <select class="form-select me-2" name="west" style="min-width: 100px;">
                                                <option selected disabled value="">West</option>
                                                <option value="West">West</option>
                                                <option value="North West">North West</option>
                                                <option value="South West">South West</option>
                                            </select>
                                            <input type="text" class="form-control" name="western">
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

                            <h5> Previous Tax Dec
                            </h5>

                            <div class="row g-5">
                                <!-- Left Column -->
                                <div class="col-md-6 border-end">

                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Previous PIN:</label>
                                            <input type="text" class="form-control" name="previous_pin">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Previous ARP No:</label>
                                            <input type="text" class="form-control" name="previous_ARP_no">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Total Assessed Value:</label>
                                            <input type="text" class="form-control" name="previous_assessed_value">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Previous Owner:</label>
                                            <input type="text" class="form-control" name="previous_owner">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">Effectivity:</label>
                                            <input type="text" class="form-control" name="previous_effectivity">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <label class="form-label me-2 mb-0" style="white-space: nowrap;">TD No:</label>
                                            <input type="text" class="form-control" name="previous_td_no">
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column -->

                            </div>

                        </div>
                    </div>



                    <hr>

                    <div class="row mt-4">
                        <div class="col-md-8 offset-md-2">
                            <label class="form-label">Remarks:</label>
                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter remarks here..."></textarea>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-5">Submit Form</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script>
    $(document).ready(function() {
        let some_id = $('input[name="faas_id"]').val();
        $.ajax({
            url: "ajax.php?action=get_property_revised",
            type: "GET",
            data: {
                faas_id: some_id
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


        // $('#prop_info_section').collapse('hide');
        // $('#prop-loc-section').collapse('hide');
        // let $sel_north = $('select[name="north"]');
        // let $sel_east = $('select[name="east"]');
        // let $sel_west = $('select[name="west"]');
        // let $sel_south = $('select[name="south"]');
        // $('#rec-seded-section').collapse('hide');

        $("form").on("submit", function(e) {
            e.preventDefault(); // prevent normal form submit

            $.ajax({
                url: "ajax.php?action=edit_property",
                type: "POST",
                data: $(this).serialize(), // send all input names/values
                success: function(response) {
                    alert(response); // show success or error message
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
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
</script>