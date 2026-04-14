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
    <div class="page">
        <h1 class="title">Real Property Field Appraisal & Assessment Sheet – Land / Other Improvements</h1>

        <!-- Existing content from page 1 would be here -->

        <!-- Market Value Section -->
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
                    <td>₱</td>
                    <td></td>
                    <td>%</td>
                    <td>₱</td>
                    <td>₱</td>
                </tr>
                <tr>
                    <td>₱</td>
                    <td></td>
                    <td>%</td>
                    <td>₱</td>
                    <td>₱</td>
                </tr>
            </tbody>
        </table>

        <!-- Property Assessment Section -->
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

        <!-- Appraised By / Recommending Approval -->
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

        <!-- Approved By -->
        <div style="margin-top:20px;">
            <div class="label">Approved By:</div>
            <p style="margin-top:20px; text-align:center;">
                <strong>ATTY. SILVESTRE C. UNTARAN III</strong><br>
                Provincial Assessor
            </p>
            <p>Date: __________</p>
        </div>

        <!-- Memoranda -->
        <div class="section-title">Memoranda</div>
        <p style="height:60px; border:1px solid var(--grid);"></p>

        <p>Date of entry in the record of Assessment: __________ By: __________ Name: __________</p>

        <!-- Records of Superseded Assessment -->
        <div class="section-title">Records of Superseded Assessment</div>
        <table class="grid small">
            <tr>
                <td>PIN</td>
                <td></td>
                <td>TD No.</td>
                <td></td>
            </tr>
            <tr>
                <td>ARP No.</td>
                <td></td>
                <td>Total Assessed Value:</td>
                <td></td>
            </tr>
            <tr>
                <td>Previous Owner:</td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>Effectivity of Assessment:</td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>AR Page No.:</td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>Recording Person:</td>
                <td></td>
                <td>Date:</td>
                <td></td>
            </tr>
        </table>

        <p class="small" style="margin-top: 10px; color:#666">This layout is designed for printing on A4. Use the browser’s Print dialog to save as PDF if needed.</p>
    </div>

    <p style="text-align:center"><a class="print" href="#" onclick="window.print(); return false;">Print / Save as PDF</a></p>
</body>

</html>