<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FAAS Property Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-4">
        <h2 class="mb-4">FAAS Property Form</h2>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


        <!-- <div class="container">
            <h3 class="mb-4">Classification Table</h3>

            <table class="table table-bordered" id="classification-table">
                <thead class="table-light">
                    <tr>
                        <th>Classification</th>
                        <th>Sub-classification</th>
                        <th>Area</th>
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
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <button class="btn btn-primary" id="add-row">Add Row</button>
        </div> -->

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
                    return `
      <tr>
        <td><input type="text" class="form-control classification" placeholder="Classification"></td>
        <td><input type="text" class="form-control sub-classification" placeholder="Sub-classification"></td>
        <td><input type="number" class="form-control area" placeholder="Area"></td>
        <td><input type="number" class="form-control unit-value" placeholder="Unit Value"></td>
        <td><input type="text" class="form-control bmv" placeholder="BMV" readonly></td>
        <td><button class="btn btn-danger btn-sm remove-row">Remove</button></td>
      </tr>
    `;
                }

                // Add first row on load
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
        </script>
        <!-- Your form (no change needed) -->
        <form>
            <div class="row mb-3">
                <div class="col-md-6 d-flex align-items-center">
                    <label class="form-label me-2 mb-0">PIN</label>
                    <input type="text" class="form-control" id="pin_no">
                    <select name="mun_code" id="mun_code" class="form-select">
                        <option value="">-- Select Municipality --</option>
                        <option value="1">SAN JOSE (Capital)</option>
                        <option value="2">ANINI-Y</option>
                        <option value="3">BARBAZA</option>
                        <option value="4">BELISON</option>
                        <option value="5">BUGASONG</option>
                        <option value="6">CALUYA</option>
                        <option value="7">CULASI</option>
                        <option value="8">TOBIAS FORNIER (DAO)</option>
                        <option value="9">HAMTIC</option>
                        <option value="10">LAUA-AN</option>
                        <option value="11">LIBERTAD</option>
                        <option value="12">PANDAN</option>
                        <option value="13">PATNONGON</option>

                        <option value="14">SAN REMIGIO</option>
                        <option value="15">SEBASTE</option>
                        <option value="16">SIBALOM</option>
                        <option value="17">TIBIAO</option>

                        <option value="18">VALDERRAMA</option>
                    </select>

                    <button type="button" class="btn btn-primary ms-2" id="fetchBtn">Fetch</button>
                </div>
            </div>
        </form>
        <form>


            <!-- Basic Property Information -->
            <div class="border border-success p-4 mb-4">

                <h4 data-bs-toggle="collapse" data-bs-target="#prop_info_section" style="cursor: pointer;">Administrator Information</h4>
                <div id="prop_info_section" class="collapse show">
                    <hr>
                    <h5> Title
                    </h5>
                    <div class="row mb-3 justify-content-end" hidden>
                        <div class="col-md-4 d-flex align-items-center">
                            <label class="form-label me-2 mb-0" for="transaction_code">Transaction Code:</label>
                            <input type="text" class="form-control" name="transaction_code" id="transaction_code" value="GR"
                                style="width: auto;">
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
                                    <input type="text" class="form-control" name="input_pin_no">
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


            <div class="border border-success p-4 mb-4">
                <h4 data-bs-toggle="collapse" data-bs-target="#prop-loc-section" style="cursor: pointer;">Property Location</h4>

                <div id="prop-loc-section" class="collapse show">

                    <hr>
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
                                    <label Municipality="form-label me-2 mb-0">Municipal:</label>
                                    <input type="text" class="form-control" name="property_municipality">
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

            <div class="border border-success p-4 mb-4">

                <h4 data-bs-toggle="collapse" data-bs-target="#rec-seded-section" style="cursor: pointer;">Record of Superseded</h4>
                <div id="rec-seded-section" class="collapse show">
                    <hr>
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

            <div class="border border-success p-4 mb-4">
                <h5>Valuation</h5>
                <div class="row g-3">
                    <div class="col-md-3 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 160px;">Agricultural Area:</label>
                        <input type="number" step="0.01" class="form-control" name="agricultural_area">
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 160px;">Agri. Market Value:</label>
                        <input type="number" step="0.01" class="form-control" name="agricultural_market_value">
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 160px;">Residential Unit Value:</label>
                        <input type="number" step="0.01" class="form-control" name="residential_unit_value">
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 160px;">Residential Market Value:</label>
                        <input type="number" step="0.01" class="form-control" name="residential_market_value">
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 160px;">Market Value Adjustment:</label>
                        <input type="number" step="0.01" class="form-control" name="market_value_adjustment">
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 160px;">Market Value Total:</label>
                        <input type="number" step="0.01" class="form-control" name="market_value_total">
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 160px;">Assessment Market Value:</label>
                        <input type="number" step="0.01" class="form-control" name="assessment_market_value">
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 160px;">Assessed Value Total:</label>
                        <input type="number" step="0.01" class="form-control" name="assessed_value_total">
                    </div>
                </div>

                <hr>


                <!-- Effectivity -->
                <h5>Effectivity</h5>
                <div class="row g-3">
                    <div class="col-md-3 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 70px;">Quarter:</label>
                        <input type="number" class="form-control" name="effectivity_quarter" min="1" max="4">
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 50px;">Year:</label>
                        <input type="text" class="form-control" name="effectivity_year">
                    </div>
                </div>

                <hr>

                <!-- Appraisal and Approval -->
                <h5>Appraisal and Approval</h5>
                <div class="row g-3">
                    <div class="col-md-4 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 130px;">Appraised Name 1:</label>
                        <input type="text" class="form-control" name="appraised_name1">
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 80px;">Date 1:</label>
                        <input type="text" class="form-control" name="appraised_date1">
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 130px;">Appraised Name 2:</label>
                        <input type="text" class="form-control" name="appraised_name2">
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 80px;">Date 2:</label>
                        <input type="text" class="form-control" name="appraised_date2">
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 100px;">Approved By:</label>
                        <input type="text" class="form-control" name="approved_by">
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 100px;">Date:</label>
                        <input type="text" class="form-control" name="approved_date">
                    </div>
                </div>

                <hr>

                <!-- Other Info -->
                <h5>Other Information</h5>
                <div class="mb-3 d-flex align-items-center">
                    <label class="form-label me-2 mb-0" style="min-width: 100px;">Memoranda:</label>
                    <textarea class="form-control" name="memoranda" rows="2"></textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-3 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 100px;">Encoded Date:</label>
                        <input type="text" class="form-control" name="encoded_date">
                    </div>
                    <div class="col-md-5 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 100px;">Encoded Name:</label>
                        <input type="text" class="form-control" name="encoded_name">
                    </div>
                </div>

                <hr>

                <!-- Previous Property Info -->


                <hr>

                <!-- Recording Info -->
                <h5>Recording Information</h5>
                <div class="row g-3">
                    <div class="col-md-3 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 100px;">ARP Page No:</label>
                        <input type="text" class="form-control" name="ARP_page_no">
                    </div>
                    <div class="col-md-5 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 130px;">Recording Person:</label>
                        <input type="text" class="form-control" name="recording_person">
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <label class="form-label me-2 mb-0" style="min-width: 130px;">Recording Date:</label>
                        <input type="text" class="form-control" name="recording_date">
                    </div>
                </div>

                <hr>

                <!-- Submit -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit Form</button>
                </div>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script>
    $(document).ready(function() {


        $('#prop_info_section').collapse('hide');
        $('#prop-loc-section').collapse('hide');
        // let $sel_north = $('select[name="north"]');
        // let $sel_east = $('select[name="east"]');
        // let $sel_west = $('select[name="west"]');
        // let $sel_south = $('select[name="south"]');
        // $('#rec-seded-section').collapse('hide');
    });
    $('#fetchBtn').click(function() {
        const pin = $('#pin_no').val();
        const mun_code = $('#mun_code').val();

        if (pin === '') {
            alert('Please enter a PIN No');
            return;
        }

        $.ajax({
            url: 'get_property.php', // your PHP filename
            type: 'GET',
            data: {
                pin_no: pin,
                mun_code: mun_code
            },
            dataType: 'json',
            success: function(data) {
                if (data.error) {
                    alert('Error: ' + data.error);
                } else {
                    $('input[name="input_pin_no"]').val(data.previous_pin);
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
</script>