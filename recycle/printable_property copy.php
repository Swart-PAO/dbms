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

<body>
    <div class="page">
        <h1 class="title">Real Property Field Appraisal & Assessment Sheet – Land / Other Improvements</h1>

        <!-- Transaction Code Row -->
        <div class="topbar">
            <div class="box"><span class="label">&nbsp;</span></div>
            <div class="box"><span class="label">Transaction Code:</span> <span class="line w-140"></span></div>
        </div>

        <!-- Header Grid (ARP/PIN/etc.) -->
        <table class="grid small">
            <tr>
                <td style="width:35%"><span class="label">ARP No.</span> <span class="line w-140"></span></td>
                <td style="width:30%"><span class="label">PIN</span> <span class="line w-140"></span></td>
                <td style="width:35%"><span class="label">OCT/TCT/CLOA No.</span> <span class="line w-140"></span> <span class="label" style="margin-left:8px">Dated:</span> <span class="line w-90"></span></td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Owner:</span> <span class="line w-220"></span></td>
                <td>
                    <span class="label">Survey No.</span> <span class="line w-90"></span>
                    <span class="label" style="margin-left:8px">Lot No.</span> <span class="line w-60"></span>
                    <span class="label" style="margin-left:8px">Blk.</span> <span class="line w-60"></span>
                </td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Address:</span> <span class="line w-220"></span></td>
                <td><span class="label">TIN:</span> <span class="line w-140"></span></td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Tel. No.:</span> <span class="line w-140"></span></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Administrator/Beneficial User:</span> <span class="line w-220"></span></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Address:</span> <span class="line w-220"></span></td>
                <td><span class="label">TIN:</span> <span class="line w-140"></span></td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Tel. No.:</span> <span class="line w-140"></span></td>
                <td></td>
            </tr>
        </table>

        <!-- Property Location -->
        <div class="section-title">Property Location</div>
        <table class="grid small">
            <tr>
                <td style="width:50%"><span class="label">No./Street:</span> <span class="line w-220"></span></td>
                <td><span class="label">Brgy./District:</span> <span class="line w-220"></span></td>
            </tr>
            <tr>
                <td><span class="label">Municipality:</span> <span class="line w-220"></span></td>
                <td><span class="label">Province/City:</span> Antique</td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="grid" style="border: none; border-collapse: separate; border-spacing: 0; width: 100%">
                        <tr>
                            <td style="width:50%; border-right: none;">
                                <div class="label">Property Boundaries</div>
                                <div style="margin-top:6px"><span class="label">North:</span> <span class="line w-220"></span></div>
                                <div style="margin-top:10px"><span class="label">East:</span> <span class="line w-220"></span></div>
                                <div style="margin-top:10px"><span class="label">South:</span> <span class="line w-220"></span></div>
                                <div style="margin-top:10px"><span class="label">West:</span> <span class="line w-220"></span></div>
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
        <table class="grid small">
            <thead>
                <tr>
                    <th style="width:25%">Classification</th>
                    <th style="width:25%">Sub-Classification</th>
                    <th style="width:15%">Area</th>
                    <th style="width:15%">Unit Value</th>
                    <th style="width:20%">Base Market Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="totals">
                    <td colspan="3">Total</td>
                    <td class="right">Total</td>
                    <td class="right">₱</td>
                </tr>
            </tfoot>
        </table>

        <!-- Land Appraisal: R/C/I/S -->
        <div class="section-title">Residential, Commercial, Industrial, Special</div>
        <table class="grid small">
            <thead>
                <tr>
                    <th style="width:30%">Kind</th>
                    <th style="width:15%">Area</th>
                    <th style="width:15%">Unit Value</th>
                    <th style="width:20%">Adjustment Factor</th>
                    <th style="width:20%">Base Market Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="totals">
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td class="right">Total</td>
                    <td class="right">₱</td>
                </tr>
            </tfoot>
        </table>

        <p class="small" style="margin-top: 10px; color:#666">This layout is designed for printing on A4. Use the browser’s Print dialog to save as PDF if needed.</p>
    </div>

    <p style="text-align:center"><a class="print" href="#" onclick="window.print(); return false;">Print / Save as PDF</a></p>
</body>

</html>