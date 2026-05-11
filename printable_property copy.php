<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Real Property Field Appraisal & Assessment Sheet</title>
    <style>
        :root {
            --ink: #111;
            --grid: #7f7f7f;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--ink);
            background: #f6f6f6;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 12mm auto;
            background: #fff;
            padding: 12mm;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .08);
            page-break-after: always;
        }

        h1.title {
            font-size: 13px;
            text-align: center;
            margin: 0 0 8px;
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        .small {
            font-size: 11px;
        }

        .grid {
            width: 100%;
            border-collapse: collapse;
        }

        .grid th,
        .grid td {
            border: 1px solid var(--grid);
            padding: 6px 8px;
            vertical-align: top;
            font-size: 12px;
        }

        .label {
            font-weight: bold;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .line {
            border-bottom: 1px solid #888;
            display: inline-block;
            min-width: 110px;
            height: 14px;
        }

        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            padding: 6px 8px;
            border: 1px solid var(--grid);
            border-bottom: none;
            margin-top: 10px;
            background: #fafafa;
        }

        .totals td {
            font-weight: bold;
        }

        @media print {
            body {
                background: #fff;
            }

            .page {
                margin: 0;
                box-shadow: none;
            }

            a.print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <?php
    $faas_id = $_GET['faas_id'];



    ?>

    <!-- Page 1 -->
    <div class="page">
        <h1 class="title">Real Property Field Appraisal & Assessment Sheet – Land / Other Improvements</h1>
        <!-- Page 1 content (first form) -->
        <!-- Transaction Code Row -->
        <!-- <div class="topbar">
            <div class="box"><span class="label">&nbsp;</span></div>
            <div class="box"><span class="label">Transaction Code:</span> <span class="line w-140"></span></div>
        </div> -->

        <!-- Header Grid (ARP/PIN/etc.) -->
        <table class="grid small">
            <tr>
                <input type="hidden" name="faas_id" value="<?php echo $faas_id ?>">
                <td style="width:35%"><span class="label">ARP No.</span> <span id="arp_no" class="line w-140"></span></td>
                <td style="width:30%"><span class="label">PIN</span> <span id="pin_no" class="line w-140"></span></td>
                <td style="width:35%"><span class="label">Transaction Code</span> <span id="pin_no" class="line w-140"> GR</span></td>

            </tr>
            <tr>
                <td colspan="2">
                    <span class="label">Survey No.</span> <span id="survey" class="line w-90"></span>
                    <span class="label" style="margin-left:8px">Lot No.</span> <span id="lot_no" class="line w-60"></span>
                    <div style="margin-top:6px">
                        <span class="label">Blk.</span> <span id="blk" class="line w-60"></span>
                    </div>
                </td>
                <td>
                    <span class="label">Title No.</span> <span id="title_type" class="line w-140"></span>
                    <div style="margin-top:6px">
                        <span class="label">Dated:</span> <span id="title_date" class="line w-90"></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="label">Owner:</span> <span id="owner_name" class="line w-220"></span>
                    <div style="margin-top:6px">
                        <span class="label">Address:</span> <span id="owner_address" class="line w-220"></span>
                    </div>
                    <div style="margin-top:6px">
                        <span class="label">Tel. No.:</span> <span id="owner_no" class="line w-140"></span>
                    </div>
                </td>

                <td><span class="label">TIN:</span> <span id="owner_tin" class="line w-140"></span></td>
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    <span class="label">Administrator:</span> <span id="admin_name" class="line w-220"></span>
                    <div style="margin-top:6px">
                        <span class="label">Address:</span> <span id="admin_address" class="line w-220"></span>
                    </div>
                    <div style="margin-top:6px">
                        <span class="label">Tel. No.:</span> <span id="admin_no" class="line w-140"></span>
                    </div>
                </td>
                <td>
                    <span class="label">TIN:</span> <span id="admin_tin" class="line w-140"></span>
                </td>
            </tr>

        </table>

        <!-- Property Location -->
        <div class="section-title">Property Location</div>
        <table class="grid small">
            <tr>
                <td style="width:50%"><span class="label">No./Street:</span> <span id="street_no" class="line w-220"></span></td>
                <td><span class="label">Brgy./District:</span> <span id="property_brgy" class="line w-220"></span></td>
            </tr>
            <tr>
                <td><span class="label">Municipality:</span> <span id="property_municipality" class="line w-220"></span></td>
                <td><span class="label">Province/City:</span> Antique</td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="grid" style="border: none; border-collapse: separate; border-spacing: 0; width: 100%">
                        <tr>
                            <td style="width:50%; border-right: none;">
                                <div class="label">Property Boundaries</div>
                                <div style="margin-top:6px"><span class="label">North:</span> <span id="northern" class="line w-220"></span></div>
                                <div style="margin-top:10px"><span class="label">East:</span> <span id="eastern" class="line w-220"></span></div>
                                <div style="margin-top:10px"><span class="label">South:</span> <span id="southern" class="line w-220"></span></div>
                                <div style="margin-top:10px"><span class="label">West:</span> <span id="western" class="line w-220"></span></div>
                            </td>
                            <td style="border-left: none;">
                                <div class="label">Land Sketch</div>
                                <div class="sketch"></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


        <div class="section-title">Land Appraisal – Agricultural</div>
        <table class="grid small" id="classification-table">
            <thead>
                <tr>
                    <th>Classification</th>
                    <th>Sub-Classification</th>
                    <th>Area</th>
                    <th>Unit Value</th>
                    <th>Base Market Value</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr class="totals">
                    <td>Total</td>
                    <td></td>
                    <td class="right" id="total_land_area"></td>
                    <td class="right" id="total_land_unit_value"></td>
                    <td class="right" id="total_land_mv"></td>
                </tr>
            </tfoot>
        </table>

        <div class="section-title">Residential, Commercial, Industrial, Special</div>
        <table class="grid small" id="residential-table">
            <thead>
                <tr>
                    <th>Kind</th>
                    <th>Area</th>
                    <th>Unit Value</th>
                    <th>Adjustment Factor</th>
                    <th>Base Market Value</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr class="totals">
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td class="right">Total</td>
                    <td class="right" id="total_resid_mv">₱</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Page 2 -->
    <div class="page">
        <h1 class="title">Real Property Field Appraisal & Assessment Sheet – Continuation</h1>

        <div class="section-title">Market Value</div>
        <table class="grid small">
            <thead>
                <tr>
                    <th>Base Market Value</th>
                    <th>Adjustment Factors</th>
                    <th>% Adjustment</th>
                    <th>Value Adjustment</th>
                    <th>Market Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="bmvmv">₱</td>
                    <td id="factor_first"></td>
                    <td id="percent_first"></td>
                    <td id="total_adjustment"></td>
                    <td id="total_market_value"></td>
                </tr>
                <tr>
                    <td></td>
                    <td id="factor_second"></td>
                    <td id="percent_second"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td id="factor_third"></td>
                    <td id="percent_third"></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">Property Assessment</div>
        <table class="grid small">
            <thead>
                <tr>
                    <th>Actual Use</th>
                    <th>Market Value</th>
                    <th>Assessment Level</th>
                    <th>Assessed Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td>₱</td>
                    <td></td>
                    <td>₱</td>
                </tr>
                <tr>
                    <td></td>
                    <td>₱</td>
                    <td></td>
                    <td>₱</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="totals">
                    <td>Total</td>
                    <td>₱</td>
                    <td>Total</td>
                    <td>₱</td>
                </tr>
            </tfoot>
        </table>

        <p class="small">Taxable <input type="checkbox"> &nbsp; Exempt <input type="checkbox"> &nbsp; Effectivity of Assessment/Reassessment: ________ Qtr. ________</p>

        <table class="grid small">
            <tr>
                <td style="width:50%">
                    <div class="label">Appraised/Assessed By:</div>
                    <div style="margin-top:20px">Name: __________________________ Date: __________</div>
                </td>
                <td>
                    <div class="label">Recommending Approval:</div>
                    <div style="margin-top:20px">Name: __________________________ Date: __________</div>
                </td>
            </tr>
        </table>

        <div style="margin-top:20px;">
            <div class="label">Approved By:</div>
            <p style="margin-top:20px; text-align:center;">
                <strong>ATTY. SILVESTRE C. UNTARAN III</strong><br>
                Provincial Assessor
            </p>
            <p>Date: __________</p>
        </div>

        <div class="section-title">Memoranda</div>
        <p style="height:60px; border:1px solid var(--grid);"></p>

        <p>Date of entry in the record of Assessment: __________ By: __________ Name: __________</p>

        <div class="section-title">Records of Superseded Assessment</div>
        <table class="grid small">
            <tr>
                <td id="previous_pin"></td>
                <td></td>
                <td id="previous_td_no">TD No.</td>
                <td></td>
            </tr>
            <tr>
                <td id="previous_ARP_no"></td>
                <td></td>
                <td id="previous_assessed_value"></td>
                <td></td>
            </tr>
            <tr>
                <td id="previous_owner"></td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td id="previous_effectivity"></td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td id="ar_page_no"></td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td id="recording_person"></td>
                <td></td>
                <td id="recording_date"></td>
                <td></td>
            </tr>
        </table>
    </div>

    <!-- <p style="text-align:center"><a class="print" href="#" onclick="window.print(); return false;">Print / Save as PDF</a></p> -->
</body>

</html>

<?php
include 'footer_script.php';
?>
<script>
    $(document).ready(function() {
        let some_id = $('input[name="faas_id"]').val();

        const municipalityMap = {
            1: 'SAN JOSE (Capital)',
            2: 'ANINI-Y',
            3: 'BARBAZA',
            4: 'BELISON',
            5: 'BUGASONG',
            6: 'CALUYA',
            7: 'CULASI',
            8: 'TOBIAS FORNIER (DAO)',
            9: 'HAMTIC',
            10: 'LAUA-AN',
            11: 'LIBERTAD',
            12: 'PANDAN',
            13: 'PATNONGON',
            14: 'SAN REMIGIO',
            15: 'SEBASTE',
            16: 'SIBALOM',
            17: 'TIBIAO',
            18: 'VALDERRAMA'
        };

        $.ajax({
            url: "ajax.php?action=get_property_revised",
            type: "GET",
            data: {
                new_property_ID: some_id
            }, // pass the FAAS_ID dynamically
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                    return;
                }
                let munCode = $.trim(data.property_municipality);

                $('#property_municipality').text(
                    municipalityMap[munCode] ?? munCode
                );


                loadLandRows(data.FAAS_ID);
                loadResidential(data.FAAS_ID);
                $('#factor_first').text($.trim(data.factor_first));
                $('#percent_first').text($.trim(data.percent_first));
                $('#factor_second').text($.trim(data.factor_second));
                $('#percent_second').text($.trim(data.percent_second));
                $('#factor_third').text($.trim(data.factor_third));
                $('#percent_third').text($.trim(data.percent_third));
                $('#total_adjustment').text('₱ ' + $.trim(data.total_adjustment));
                $('#total_market_value').text('₱ ' + $.trim(data.total_market_value));
                $('#bmvmv').text('₱ ' + $.trim(data.total_land_mv));
                $('#total_land_mv').text(formatPeso($.trim(data.total_land_mv)));
                $('#total_resid_mv').text(formatPeso($.trim(data.total_residential_mv)));
                $('#pin_no').text($.trim(data.previous_pin));
                $('#arp_no').text($.trim(data.previous_ARP_no));
                $('#title_type').text($.trim(data.title_type));
                $('#lot_no').text($.trim(data.lot_no));
                $('#blk').text($.trim(data.BLK));
                $('#survey').text($.trim(data.survey));
                $('#owner_name').text($.trim(data.owner_name));
                $('#owner_address').text($.trim(data.owner_address));
                $('#owner_tin').text($.trim(data.owner_tin));
                $('#owner_no').text($.trim(data.owner_no));
                $('#admin_name').text($.trim(data.admin_name));
                $('#admin_address').text($.trim(data.admin_address));
                $('#admin_no').text($.trim(data.admin_no));
                $('#admin_tin').text($.trim(data.admin_tin));
                $('#property_brgy').text($.trim(data.property_brgy));
                // $('#property_municipality').text($.trim(data.property_municipality));
                $('#northern').text($.trim(data.northern));
                $('#eastern').text($.trim(data.eastern));
                $('#southern').text($.trim(data.southern));
                $('#western').text($.trim(data.western));
                $('#street_no').text($.trim(data.street_no));
                $('#previous_pin').text($.trim('PIN ' + data.previous_pin));
                $('#previous_td_no').text($.trim('TD No.' + data.previous_td_no));
                $('#previous_ARP_no').text($.trim('ARP no. ' + data.previous_ARP_no));
                $('#previous_assessed_value').text($.trim('Previous Assessed Value: ' + data.previous_assessed_value));
                $('#previous_owner').text($.trim('Previous Owner: ' + data.street_no));
                $('#previous_effectivity').text($.trim('Effectivity of Assessment: ' + data.previous_effectivity));
                $('#ar_page_no').text($.trim('AR Page No.: ' + data.street_no));
                $('#recording_person').text($.trim('Recording Person: ' +
                    data.street_no));
                $('#recording_date').text($.trim('Date: ' + data.street_no));

            }

        });

        function createFilledRow(row) {
            return `<tr>
                <td>${row.class || ""}</td>
                <td>${row.sub_class || ""}</td>
                <td>${row.area_land || ""}</td>
                 <td class="right">${formatPeso(row.unit_value_land)}</td>
                <td class="right">${formatPeso(row.market_value_land)}</td>
            </tr>`;
        }

        function createEmptyRow() {
            return `<tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="right">&nbsp;</td>
                <td class="right">&nbsp;</td>
            </tr>`;
        }

        function loadLandRows(land_property_ID) {
            $.ajax({
                url: "php/fetch/fetch_land.php",
                type: "POST",
                data: {
                    land_property_ID: land_property_ID
                },
                dataType: "json",
                success: function(data) {

                    const tbody = $("#classification-table tbody");
                    tbody.empty();

                    // Load actual rows
                    data.forEach(row => {
                        tbody.append(createFilledRow(row));
                    });

                    // Ensure minimum 3 rows
                    let remaining = 3 - data.length;
                    for (let i = 0; i < remaining; i++) {
                        tbody.append(createEmptyRow());
                    }
                }
            });
        }

        function createResidential(row) {
            return `<tr>
                <td>${row.kind || ""}</td>
                <td>${row.area_resid || ""}</td>
                <td>${row.unit_value_resid || ""}</td>
                <td class="right">${formatPeso(row.adjustment_factor)}</td>
                <td class="right">${formatPeso(row.market_value_resid)}</td>
            </tr>`;
        }

        function emptyResidential() {
            return `<tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="right">&nbsp;</td>
                <td class="right">&nbsp;</td>
            </tr>`;
        }

        function loadResidential(land_property_ID) {
            $.ajax({
                url: "php/fetch/fetch_resid.php",
                type: "POST",
                data: {
                    land_property_ID: land_property_ID
                },
                dataType: "json",
                success: function(data) {

                    const tbody = $("#residential-table tbody");
                    tbody.empty();

                    // Load actual rows
                    data.forEach(row => {
                        tbody.append(createResidential(row));
                    });

                    // Ensure minimum 3 rows
                    let remaining = 3 - data.length;
                    for (let i = 0; i < remaining; i++) {
                        tbody.append(createEmptyRow());
                    }
                }
            });
        }

        function formatPeso(value) {
            if (value === null || value === undefined || value === '') return '';

            const number = Number(value);
            if (isNaN(number)) return '';

            return `₱ ${number.toLocaleString('en-PH', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    })}`;
        }



    });
</script>