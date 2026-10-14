<?php
$property_ID = $_GET['property_ID'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Real Property Field Appraisal & Assessment Sheet</title>
  <style>
    @page {
      size: 8.5in 11in;
      /* short bond paper */
      margin: 0.4in 0.5in;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 10.5px;
      color: #000;
      margin: 0;
      padding: 0;
    }

    .page {
      width: 7.5in;
      min-height: 10.2in;
      margin: 0 auto;
      page-break-after: always;
      position: relative;
      padding-top: 4px;
    }

    .page:last-child {
      page-break-after: auto;
    }

    h1.title {
      text-align: center;
      font-size: 14px;
      letter-spacing: 0.5px;
      margin: 0 0 10px 0;
      text-transform: uppercase;
    }

    .txn-code {
      text-align: right;
      font-size: 11px;
      margin-bottom: 8px;
    }

    .txn-code .fill-line {
      display: inline-block;
      min-width: 140px;
      border-bottom: 1px solid #000;
    }

    table.box {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 8px;
    }

    table.box td,
    table.box th {
      border: 1px solid #000;
      padding: 3px 5px;
      vertical-align: top;
    }

    .section-title {
      font-weight: bold;
      font-size: 11px;
      margin: 8px 0 3px 0;
      text-transform: uppercase;
    }

    .fill {
      border-bottom: 1px solid #000;
      display: inline-block;
      min-width: 60%;
      height: 14px;
    }

    .fill-sm {
      border-bottom: 1px solid #000;
      display: inline-block;
      min-width: 30%;
      height: 14px;
    }

    .label {
      font-weight: bold;
    }

    .val {
      font-weight: normal;
    }

    .info-table td {
      height: 20px;
    }

    .bound-sketch {
      width: 100%;
      border-collapse: collapse;
    }

    .bound-sketch td {
      border: 1px solid #000;
      vertical-align: top;
      padding: 4px 6px;
    }

    .bound-col {
      width: 42%;
    }

    .bound-cell {
      height: 44px;
      display: inline-block;
      width: 100%;
    }

    .sketch-col {
      width: 58%;
    }

    .sketch-box {
      height: 240px;
    }

    table.data {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 10px;
    }

    table.data th,
    table.data td {
      border: 1px solid #000;
      padding: 4px 5px;
      text-align: left;
      font-size: 10px;
    }

    table.data th {
      text-align: center;
      font-weight: bold;
    }

    table.data td.right,
    table.data th.right {
      text-align: right;
    }

    table.data td.num {
      height: 16px;
    }

    table.data tfoot td {
      font-weight: bold;
    }

    .p-prefix {
      font-weight: bold;
    }

    .taxable-row {
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 10px 0;
      font-size: 11px;
    }

    .checkbox {
      display: inline-block;
      width: 16px;
      height: 16px;
      border: 1px solid #000;
      margin-right: 4px;
      vertical-align: middle;
    }

    .taxable-row .spacer {
      flex: 1;
      text-align: right;
    }

    .sign-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-top: 14px;
    }

    .sign-block .cap {
      font-weight: bold;
      text-transform: uppercase;
      margin-bottom: 30px;
      font-size: 11px;
    }

    .sign-line-pair {
      display: flex;
      gap: 6px;
    }

    .sign-line-pair .name-line {
      flex: 2;
      border-bottom: 1px solid #000;
      height: 14px;
    }

    .sign-line-pair .date-line {
      flex: 1;
      border-bottom: 1px solid #000;
      height: 14px;
    }

    .sign-cap-labels {
      display: flex;
      gap: 6px;
      font-size: 9px;
      margin-top: 2px;
    }

    .sign-cap-labels .name-l {
      flex: 2;
      text-align: center;
    }

    .sign-cap-labels .date-l {
      flex: 1;
      text-align: center;
    }

    .approved-block {
      margin-top: 20px;
    }

    .approved-name {
      text-align: center;
      font-weight: bold;
      text-decoration: underline;
      margin-top: 25px;
    }

    .approved-title {
      text-align: center;
      font-weight: bold;
      font-size: 10px;
    }

    .approved-date {
      width: 200px;
      margin-left: auto;
      border-bottom: 1px solid #000;
      height: 14px;
      margin-top: 10px;
    }

    .approved-date-label {
      width: 200px;
      margin-left: auto;
      text-align: center;
      font-size: 9px;
    }

    .memo-row {
      display: flex;
      gap: 6px;
      margin-top: 12px;
      align-items: baseline;
    }

    .memo-label {
      font-weight: bold;
      white-space: nowrap;
    }

    .memo-line {
      flex: 1;
      border-bottom: 1px solid #000;
      height: 14px;
    }

    .entry-row {
      display: flex;
      gap: 6px;
      margin-top: 16px;
      align-items: baseline;
    }

    .entry-row .fill2 {
      flex: 1;
      border-bottom: 1px solid #000;
      height: 14px;
    }

    .entry-row .by-label {
      font-weight: bold;
    }

    .entry-row .by-line {
      width: 180px;
      border-bottom: 1px solid #000;
      height: 14px;
    }

    .name-caption {
      text-align: right;
      font-size: 9px;
      margin-top: 1px;
    }

    table.superseded {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    table.superseded td {
      border: 1px solid #000;
      padding: 4px 6px;
      height: 20px;
      font-size: 10.5px;
    }

    .rec-person-row {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
    }

    @media print {
      .page {
        margin: 0 auto;
      }
    }
  </style>
</head>

<body>

  <!-- hidden field expected by script.js -->
  <input type="hidden" name="property_ID" value="<?php echo $property_ID ?>">

  <!-- ============ PAGE 1 ============ -->
  <div class="page">
    <h1 class="title">Real Property Field Appraisal &amp; Assessment Sheet &ndash; Land/Other Improvements</h1>
    <div class="txn-code">TRANSACTION CODE <span class="fill-line">&nbsp;</span></div>

    <table class="box info-table">
      <tr>
        <td style="width:60%;"><span class="label">ARP NO.</span> <span id="arp_no" class="val"></span></td>
        <td rowspan="2" style="width:40%;"><span class="label">PIN</span> <span id="pin_no" class="val"></span></td>
      </tr>
      <tr>
        <td>
          <span class="label">OCT/TCT/CLOA NO.</span> <span id="title_type" class="val"></span>
          <span class="label" style="margin-left:20px;">Dated:</span> <span class="fill-sm">&nbsp;</span>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          Survey No. <span id="survey" class="val fill-sm"></span>
          &nbsp;&nbsp;Lot No. <span id="lot_no" class="val fill-sm"></span>
          &nbsp;&nbsp;Blk. <span id="blk" class="val fill-sm"></span>
        </td>
      </tr>
      <tr>
        <td>
          <div><span class="label">OWNER:</span> <span id="owner_name" class="val fill"></span></div>
          <div style="margin-top:4px;"><span class="label">ADDRESS:</span> <span id="owner_address" class="val fill"></span></div>
          <div style="margin-top:4px;"><span class="label">Tel. No.</span> <span id="owner_no" class="val fill"></span></div>
        </td>
        <td><span class="label">TIN:</span> <span id="owner_tin" class="val"></span></td>
      </tr>
      <tr>
        <td>
          <div><span class="label">Administrator/Beneficial User:</span> <span id="admin_name" class="val fill"></span></div>
          <div style="margin-top:4px;"><span class="label">ADDRESS:</span> <span id="admin_address" class="val fill"></span></div>
          <div style="margin-top:4px;"><span class="label">Tel. No.</span> <span id="admin_no" class="val fill"></span></div>
        </td>
        <td><span class="label">TIN:</span> <span id="admin_tin" class="val"></span></td>
      </tr>
    </table>

    <div class="section-title">Property Location</div>
    <table class="box">
      <tr>
        <td style="width:50%;"><span class="label">No./Street:</span> <span id="street_no" class="val"></span></td>
        <td style="width:50%;"><span class="label">Brgy./District:</span> <span id="property_brgy" class="val"></span></td>
      </tr>
      <tr>
        <td><span class="label">Municipality</span> <span id="property_municipality" class="val"></span></td>
        <td><span class="label">Province/City:</span> Antique</td>
      </tr>
    </table>

    <table class="bound-sketch">
      <tr>
        <td class="bound-col">
          <div class="section-title" style="margin-top:0;">Property Boundaries</div>
        </td>
        <td class="sketch-col"><span class="label">Land Sketch:</span></td>
      </tr>
      <tr>
        <td class="bound-col" style="padding:0;">
          <table style="width:100%; border-collapse:collapse;">
            <tr>
              <td style="border:1px solid #000; padding:4px 6px;"><span class="label">North:</span><span id="northern" class="val bound-cell"></span></td>
            </tr>
            <tr>
              <td style="border:1px solid #000; padding:4px 6px;"><span class="label">East:</span><span id="eastern" class="val bound-cell"></span></td>
            </tr>
            <tr>
              <td style="border:1px solid #000; padding:4px 6px;"><span class="label">South:</span><span id="southern" class="val bound-cell"></span></td>
            </tr>
            <tr>
              <td style="border:1px solid #000; padding:4px 6px;"><span class="label">West:</span><span id="western" class="val bound-cell"></span></td>
            </tr>
          </table>
        </td>
        <td class="sketch-col">
          <div class="sketch-box"></div>
        </td>
      </tr>
    </table>

    <div class="section-title">Land Appraisal</div>
    <div style="font-weight:bold; margin-bottom:2px;">AGRICULTURAL:</div>
    <table class="data" id="classification-table">
      <thead>
        <tr>
          <th style="width:22%;">Classification</th>
          <th style="width:22%;">Sub-Classification</th>
          <th style="width:14%;">Area</th>
          <th style="width:18%;" class="right">Unit Value</th>
          <th style="width:24%;" class="right">Base Market Value</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="right">&nbsp;</td>
          <td class="right">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="right">&nbsp;</td>
          <td class="right">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="right">&nbsp;</td>
          <td class="right">&nbsp;</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td></td>
          <td style="text-align:right;">Total</td>
          <td id="total_land_area" class="val"></td>
          <td></td>
          <td class="right p-prefix" id="total_land_mv"></td>
        </tr>
      </tfoot>
    </table>

    <div style="font-weight:bold; margin-bottom:2px;">RESIDENTIAL, COMMERCIAL, INDUSTRIAL, SPECIAL</div>
    <table class="data" id="residential-table">
      <thead>
        <tr>
          <th style="width:22%;">Kind</th>
          <th style="width:16%;">Area</th>
          <th style="width:20%;" class="right">Unit Value</th>
          <th style="width:20%;" class="right">Adjustment Factor</th>
          <th style="width:22%;" class="right">Base Market Value</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="right">&nbsp;</td>
          <td class="right">&nbsp;</td>
          <td class="right">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="right">&nbsp;</td>
          <td class="right">&nbsp;</td>
          <td class="right">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="right">&nbsp;</td>
          <td class="right">&nbsp;</td>
          <td class="right">&nbsp;</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td style="text-align:right;">Total</td>
          <td id="total_non_agri_area" class="val"></td>
          <td></td>
          <td style="text-align:right;">Total</td>
          <td class="right p-prefix" id="total_non_agri_mv"></td>
        </tr>
      </tfoot>
    </table>
  </div>

  <!-- ============ PAGE 2 ============ -->
  <div class="page">
    <div class="section-title" style="margin-top:0;">Market Value</div>
    <table class="data">
      <thead>
        <tr>
          <th style="width:20%;" class="right">Base Market Value</th>
          <th style="width:20%;">Adjustment Factors</th>
          <th style="width:18%;">% Adjustment</th>
          <th style="width:20%;" class="right">Value Adjustment</th>
          <th style="width:22%;" class="right">Market Value</th>
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
          <td class="right">&nbsp;</td>
          <td class="right">&nbsp;</td>
        </tr>
        <tr>
          <td></td>
          <td id="factor_third"></td>
          <td id="percent_third"></td>
          <td class="right">&nbsp;</td>
          <td class="right">&nbsp;</td>
        </tr>
      <tfoot>
        <tr>
          <td class="right p-prefix"></td>
          <td> Total</td>
          <td id="percent_total"></td>
          <td class="right p-prefix"></td>
          <td class="right p-prefix"></td>
        </tr>
      </tfoot>
    </table>

    <div class="section-title">Property Assessment</div>
    <table class="data" id="assessment-table">
      <thead>
        <tr>
          <th style="width:22%;">Actual Use</th>
          <th style="width:28%;" class="right">Market Value</th>
          <th style="width:22%;">Assessment Level</th>
          <th style="width:28%;" class="right">Assessed Value</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>&nbsp;</td>
          <td class="right">&nbsp;</td>
          <td>&nbsp;</td>
          <td class="right">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="right">&nbsp;</td>
          <td>&nbsp;</td>
          <td class="right">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="right">&nbsp;</td>
          <td>&nbsp;</td>
          <td class="right">&nbsp;</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td style="text-align:right;">Total</td>
          <td class="right p-prefix" id="total_assessment_mv">&nbsp;</td>
          <td style="text-align:right;">Total</td>
          <td class="right p-prefix" id="total_assessed_value">&nbsp;</td>
        </tr>
      </tfoot>
    </table>

    <div class="taxable-row">
      <span class="label">Taxable</span><input type="checkbox" id="print-taxable" class="checkbox">
      <span class="label">Exempt</span><input type="checkbox" id="print-exempt" class="checkbox">
      <span class="spacer"><span class="label">Effectivity of Assessment/Reassessment:_________</span> Qtr.________</span>
    </div>
    <hr style="border:none; border-top:1px solid #000; margin:6px 0 12px 0;">

    <div class="sign-grid">
      <div class="sign-block">
        <div class="cap">Appraised/Assessed By:</div>
        <div class="sign-line-pair">
          <div class="name-line"></div>
          <div class="date-line"></div>
        </div>
        <div class="sign-cap-labels">
          <div class="name-l">Name</div>
          <div class="date-l">Date</div>
        </div>
      </div>
      <div class="sign-block">
        <div class="cap">Recommending Approval:</div>
        <div class="sign-line-pair">
          <div class="name-line"></div>
          <div class="date-line"></div>
        </div>
        <div class="sign-cap-labels">
          <div class="name-l">Name</div>
          <div class="date-l">Date</div>
        </div>
      </div>
    </div>

    <div class="approved-block">
      <div class="cap" style="margin-bottom:4px;">Approved By:</div>
      <div class="approved-name">ATTY. SILVESTRE C. UNTARAN III</div>
      <div class="approved-title">Provincial Assessor</div>
      <div class="approved-date"></div>
      <div class="approved-date-label">Date</div>
    </div>

    <div class="memo-row"><span class="memo-label">MEMORANDA:</span>
      <div class="memo-line"></div>
    </div>
    <div class="memo-row"><span class="memo-label" style="visibility:hidden;">MEMORANDA:</span>
      <div class="memo-line"></div>
    </div>
    <div class="memo-row"><span class="memo-label" style="visibility:hidden;">MEMORANDA:</span>
      <div class="memo-line"></div>
    </div>

    <div class="entry-row">
      <span class="by-label">Date of entry in the record of Assessment:</span>
      <div class="fill2"></div>
      <span class="by-label">By:</span>
      <div class="by-line"></div>
    </div>
    <div class="name-caption" style="width:180px; margin-left:auto;">Name</div>

    <div class="section-title" style="margin-top:14px;">Records of Superseded Assessment</div>
    <table class="superseded">
      <tr>
        <td style="width:50%;" id="previous_pin" class="val"></td>
        <td style="width:50%;" id="previous_td_no" class="val"></td>
      </tr>
      <tr>
        <td id="previous_ARP_no" class="val"></td>
        <td id="previous_assessed_value" class="val"></td>
      </tr>
      <tr>
        <td id="previous_owner" class="val"></td>
        <td id="previous_effectivity" class="val"></td>
      </tr>
      <tr>
        <td id="ar_page_no" class="val"></td>
        <td id="recording_person" class="val"></td>
      </tr>
      <tr>
        <td id="recording_date" class="val"></td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    $(document).ready(function() {
      let some_id = $('input[name="property_ID"]').val();
      // alert('123132'); // Debugging line to check the value of some_id

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
        url: "land/ajax.php?action=get_property_revised",
        type: "GET",
        data: {
          property_ID: some_id,
          mode: "gr"
        }, // pass the property_ID dynamically
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


          loadLandRows(data.property_ID);
          loadResidential(data.property_ID);
          loadAssessment(data.property_ID);
          $('#factor_first').text($.trim(data.factor_first));
          $('#percent_first').text($.trim(data.percent_first));
          $('#factor_second').text($.trim(data.factor_second));
          $('#percent_second').text($.trim(data.percent_second));
          $('#factor_third').text($.trim(data.factor_third));
          $('#percent_third').text($.trim(data.percent_third));
          $('#total_adjustment').text(formatPeso($.trim(data.total_adjustment)));
          $('#total_market_value').text(formatPeso($.trim(data.total_market_value)));
          $('#total_assessment_mv').text(formatPeso($.trim(data.total_assessment_mv)));
          $('#total_assessed_value').text(formatPeso($.trim(data.total_assessed_value)));
          $('#bmvmv').text('₱ ' + $.trim(data.total_land_mv));
          $('#total_land_area').text($.trim(data.total_land_area));
          $('#total_land_mv').text(formatPeso($.trim(data.total_land_mv)));
          $('#total_non_agri_area').text($.trim(data.total_non_agri_area));
          $('#total_non_agri_mv').text(formatPeso($.trim(data.total_non_agri_mv)));
          $('#pin_no').text($.trim(data.PIN_no));
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
          $('#percent_total').text($.trim(data.percent_total) +
            ' %');
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
          url: "php/fetch_land.php",
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
                <td>${formatPeso(row.unit_value_resid || "")}</td>
                <td class="right">${row.adjustment_factor || ""}</td>
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
          url: "php/fetch_resid.php",
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

      function createAssessment(row) {
        return `<tr>
            <td>${row.actual_use || ""}</td>
            <td>${row.market_value_assessed !== null && row.market_value_assessed !== undefined
                ? formatPeso(Math.round(row.market_value_assessed / 10) * 10)
                : ""}</td>
            <td>${row.assessed_level || ""}</td>
            <td class="right">
                ${row.assessed_value !== null && row.assessed_value !== undefined
                    ? formatPeso(Math.round(row.assessed_value / 10) * 10)
                    : ""}
            </td></tr>`;
      }


      function emptyAssessment() {
        return `<tr><tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="right">&nbsp;</td>
        </tr>`;
      }


      function loadAssessment(land_property_ID) {



        $.ajax({
          url: "php/fetch_assessment_update.php",
          type: "POST",
          data: {
            land_property_ID: land_property_ID
          },
          dataType: "json",

          success: function(data) {

            console.log("Printable Assessment Data:", data);

            const tbody = $("#assessment-table tbody");
            tbody.empty();

            if (!data.success) {
              console.error(
                data.message || "Failed to load assessment data."
              );

              // Keep minimum rows even when no data
              for (let i = 0; i < 3; i++) {
                tbody.append(emptyAssessment());
              }

              return;
            }

            let assessmentRows = [];

            /*
            |--------------------------------------------------------------------------
            | AGRICULTURAL
            |--------------------------------------------------------------------------
            */

            if (
              data.agricultural &&
              data.agricultural.market_value !== null
            ) {

              assessmentRows.push({
                actual_use: data.agricultural.actual_use ?? "",
                taxable: data.agricultural.taxable ?? "",
                market_value_assessed: data.agricultural.market_value ?? "",
                assessed_level: data.agricultural.assessment_level ?? "",
                assessed_value: data.agricultural.assessed_value ?? ""
              });
            }


            /*
            |--------------------------------------------------------------------------
            | NON-AGRICULTURAL
            |--------------------------------------------------------------------------
            */

            if (Array.isArray(data.non_agricultural)) {

              data.non_agricultural.forEach(function(item) {

                assessmentRows.push({
                  actual_use: item.actual_use ?? "",
                  taxable: item.taxable ?? "",
                  market_value_assessed: item.market_value ?? "",
                  assessed_level: item.assessment_level ?? "",
                  assessed_value: item.assessed_value ?? ""
                });

              });
            }


            /*
            |--------------------------------------------------------------------------
            | DISPLAY ASSESSMENT ROWS
            |--------------------------------------------------------------------------
            */

            assessmentRows.forEach(function(row) {
              tbody.append(createAssessment(row));
            });

            // Reset checkboxes
            $("#print-taxable").prop("checked", false);
            $("#print-exempt").prop("checked", false);

            // Check all assessment rows
            let hasTaxable = false;
            let hasExempt = false;

            assessmentRows.forEach(function(row) {

              const taxableStatus = String(row.taxable || "")
                .trim()
                .toUpperCase();

              if (taxableStatus === "TAXABLE") {
                hasTaxable = true;
              }

              if (taxableStatus === "EXEMPT") {
                hasExempt = true;
              }
            });

            // Set checkboxes
            $("#print-taxable").prop("checked", hasTaxable);
            $("#print-exempt").prop("checked", hasExempt);

            /*
            |--------------------------------------------------------------------------
            | ENSURE MINIMUM 3 ROWS
            |--------------------------------------------------------------------------
            */

            let remaining = 3 - assessmentRows.length;

            for (let i = 0; i < remaining; i++) {
              tbody.append(emptyAssessment());
            }

          },

          error: function(xhr, status, error) {

            console.error("Printable Assessment AJAX Error:");
            console.error("Status:", status);
            console.error("Error:", error);
            console.error("Response:", xhr.responseText);

            const tbody = $("#assessment-table tbody");
            tbody.empty();

            for (let i = 0; i < 3; i++) {
              tbody.append(emptyAssessment());
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

</body>

</html>