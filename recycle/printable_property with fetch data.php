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
            /* A4 width */
            min-height: 297mm;
            /* A4 height */
            margin: 12mm auto;
            background: #fff;
            padding: 12mm;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .08);
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

        .grid .nol {
            border-left: none !important;
        }

        .grid .nor {
            border-right: none !important;
        }

        .label {
            font-weight: bold;
        }

        .muted {
            color: #666;
            font-weight: normal;
        }

        .right {
            text-align: right;
        }

        .line {
            border-bottom: 1px solid #888;
            display: inline-block;
            min-width: 110px;
            height: 14px;
        }

        .w-60 {
            min-width: 60px;
        }

        .w-90 {
            min-width: 90px;
        }

        .w-140 {
            min-width: 140px;
        }

        .w-220 {
            min-width: 220px;
        }

        .sketch {
            height: 150px;
            background: repeating-linear-gradient(45deg, #fafafa, #fafafa 8px, #f0f0f0 8px, #f0f0f0 16px);
            border: 1px solid var(--grid);
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

        .topbar {
            display: grid;
            grid-template-columns: 1fr 180px;
            gap: 6px;
            margin-bottom: 6px;
            font-size: 12px;
        }

        .box {
            border: 1px solid var(--grid);
            padding: 6px 8px;
        }
    </style>
</head>

<?php
$faas_id = $_GET['faas_id'];



?>

<body>
    <div class="page">
        <h1 class="title">Real Property Field Appraisal & Assessment Sheet – Land / Other Improvements</h1>

        <!-- Transaction Code Row -->
        <div class="topbar">
            <input type="text" class="form-control" name="faas_id" id="faas_id" value="<?= $faas_id ?>" hidden>
            <div class="box"><span class="label">&nbsp;</span></div>
            <div class="box"><span class="label">Transaction Code:</span> <span id="transaction_code" class="line w-140"></span></div>
        </div>

        <!-- Header Grid (ARP/PIN/etc.) -->
        <table class="grid small">
            <tr>
                <td style="width:35%"><span class="label">ARP No.</span> <span id="arp_no" class="line w-140"></span></td>
                <td style="width:30%"><span class="label">PIN</span> <span id="pin_no" class="line w-140"></span></td>
                <td style="width:35%">
                    <span class="label">OCT/TCT/CLOA No.</span> <span id="title_type" class="line w-140"></span>
                    <span class="label" style="margin-left:8px">Dated:</span> <span id="title_date" class="line w-90"></span>
                </td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Owner:</span> <span id="owner_name" class="line w-220"></span></td>
                <td>
                    <span class="label">Survey No.</span> <span id="survey" class="line w-90"></span>
                    <span class="label" style="margin-left:8px">Lot No.</span> <span id="lot_no" class="line w-60"></span>
                    <span class="label" style="margin-left:8px">Blk.</span> <span id="blk" class="line w-60"></span>
                </td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Address:</span> <span id="owner_address" class="line w-220"></span></td>
                <td><span class="label">TIN:</span> <span id="owner_tin" class="line w-140"></span></td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Tel. No.:</span> <span id="owner_no" class="line w-140"></span></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Administrator/Beneficial User:</span> <span id="admin_name" class="line w-220"></span></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Address:</span> <span id="admin_address" class="line w-220"></span></td>
                <td><span class="label">TIN:</span> <span id="admin_tin" class="line w-140"></span></td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Tel. No.:</span> <span id="admin_no" class="line w-140"></span></td>
                <td></td>
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

        <!-- Land Appraisal: Agricultural -->
        <div class="section-title">Land Appraisal – Agricultural</div>
        <table class="grid small" id="agri_table">
            <thead>
                <tr>
                    <th style="width:25%">Classification</th>
                    <th style="width:25%">Sub-Classification</th>
                    <th style="width:15%">Area</th>
                    <th style="width:15%">Unit Value</th>
                    <th style="width:20%">Base Market Value</th>
                </tr>
            </thead>
            <tbody id="agri_rows">
                <!-- Rows will be inserted dynamically -->
            </tbody>
            <tfoot>
                <tr class="totals">
                    <td colspan="3">Total</td>
                    <td class="right" id="agri_total_area">Total</td>
                    <td class="right" id="agri_total_value">₱</td>
                </tr>
            </tfoot>
        </table>

        <!-- Land Appraisal: R/C/I/S -->
        <div class="section-title">Residential, Commercial, Industrial, Special</div>
        <table class="grid small" id="rcis_table">
            <thead>
                <tr>
                    <th style="width:30%">Kind</th>
                    <th style="width:15%">Area</th>
                    <th style="width:15%">Unit Value</th>
                    <th style="width:20%">Adjustment Factor</th>
                    <th style="width:20%">Base Market Value</th>
                </tr>
            </thead>
            <tbody id="rcis_rows">
                <!-- Rows will be inserted dynamically -->
            </tbody>
            <tfoot>
                <tr class="totals">
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td class="right" id="rcis_total_area">Total</td>
                    <td class="right" id="rcis_total_value">₱</td>
                </tr>
            </tfoot>
        </table>

        <p class="small" style="margin-top: 10px; color:#666">This layout is designed for printing on A4. Use the browser’s Print dialog to save as PDF if needed.</p>
    </div>

    <p style="text-align:center"><a class="print" href="#" onclick="window.print(); return false;">Print / Save as PDF</a></p>
</body>


</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
                $('#property_municipality').text($.trim(data.property_municipality));

                $('#northern').text($.trim(data.northern));
                $('#eastern').text($.trim(data.eastern));
                $('#southern').text($.trim(data.southern));
                $('#western').text($.trim(data.western));

                $('#street_no').text($.trim(data.street_no));


            }
        });


    });
</script>