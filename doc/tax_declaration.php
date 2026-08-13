<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Tax Declaration of Real Property</title>
  <style>
    @page {
      size: A4;
      margin: 12mm 14mm;
    }

    body {
      font-family: 'Arial', sans-serif;
      background: #e8e8e8;
      margin: 0;
      padding: 20px;
    }

    .sheet {
      max-width: 900px;
      margin: 0 auto;
      background: #fff;
      padding: 40px 50px;
      border: 1px solid #999;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
      position: relative;
    }

    @media print {
      body {
        background: #fff;
        padding: 0;
        margin: 0;
      }

      .sheet {
        max-width: 100%;
        width: 100%;
        height: 273mm;
        margin: 0;
        padding: 8mm 10mm;
        border: none;
        box-shadow: none;
        box-sizing: border-box;
        font-size: 12px;
        page-break-after: avoid;
        page-break-inside: avoid;
      }

      h1 {
        font-size: 18px;
        margin: 5px 0 15px 0;
      }

      .row {
        margin-bottom: 6px;
      }

      .label {
        font-size: 11px;
      }

      .field-value {
        font-size: 12px;
      }

      table {
        font-size: 11px;
        margin: 8px 0;
      }

      table th,
      table td {
        padding: 3px 4px;
      }

      .section-title {
        font-size: 13px;
        margin-top: 6px;
        margin-bottom: 4px;
      }

      .signature-block {
        margin-top: 10px;
      }

      .sig-line {
        margin-top: 25px;
      }

      .note-box {
        margin-top: 15px;
        font-size: 9.5px;
      }

      .checkbox {
        width: 18px;
        height: 18px;
      }

      @page {
        size: A4;
        margin: 10mm 12mm;
      }
    }

    .attachment {
      position: absolute;
      top: 15px;
      right: 25px;
      font-weight: bold;
      font-size: 13px;
    }

    h1 {
      text-align: center;
      font-size: 22px;
      letter-spacing: 1px;
      margin: 10px 0 25px 0;
    }

    .row {
      display: flex;
      gap: 20px;
      margin-bottom: 10px;
    }

    .field {
      flex: 1;
      border-bottom: 1px solid #333;
      padding-bottom: 2px;
      min-height: 20px;
    }

    .label {
      font-weight: bold;
      font-size: 13px;
      white-space: nowrap;
      margin-right: 8px;
    }

    .field-value {
      font-size: 14px;
    }

    .field-row {
      display: flex;
      align-items: flex-end;
      flex: 1;
    }

    .sub-label {
      text-align: center;
      font-size: 11px;
      color: #444;
      margin-top: 2px;
    }

    .checkbox {
      width: 22px;
      height: 22px;
      border: 1px solid #333;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      margin-right: 8px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 15px 0;
      font-size: 13px;
    }

    table th,
    table td {
      /* border-bottom: 1px solid #333; */
      padding: 6px 4px;
      text-align: left;
    }

    table th {
      font-weight: bold;
      /* border-bottom: 2px solid #333; */
    }

    .num {
      text-align: right;
    }

    .section-title {
      font-weight: bold;
      font-size: 15px;
      margin-top: 10px;
      margin-bottom: 8px;
    }

    .totals {
      display: flex;
      justify-content: space-between;
      margin-top: 5px;
    }

    .total-block {
      font-size: 13px;
    }

    .amount-words {
      text-align: center;
      font-weight: bold;
      margin: 10px 0;
      letter-spacing: 0.5px;
    }

    .amount-label {
      text-align: center;
      font-size: 10px;
      color: #444;
    }

    .signature-block {
      text-align: center;
      margin-top: 20px;
      width: 45%;
    }

    .sig-line {
      border-top: 1px solid #333;
      margin-top: 40px;
      padding-top: 4px;
      font-weight: bold;
      font-size: 13px;
    }

    .sig-title {
      font-size: 12px;
    }

    .note-box {
      margin-top: 40px;
      font-size: 11px;
      color: #333;
      border-top: 1px solid #999;
      padding-top: 10px;
    }

    .hr-thin {
      border: none;
      border-top: 1px solid #333;
      margin: 15px 0;
    }
  </style>
</head>

<body>
  <div class="sheet">
    <div class="attachment">ATTACHMENT 4</div>
    <h1>TAX DECLARATION OF REAL PROPERTY</h1>

    <!-- ===================== HEADER ===================== -->
    <div class="row">
      <div style="flex:1.3" class="field-row">
        <span class="label">TD. No.</span>
        <div class="field field-value" id="ARP_no" name="ARP_no"></div>
      </div>

      <div style="flex:1.7" class="field-row">
        <span class="label">Property Identification No.</span>
        <div class="field field-value" id="PIN_no" name="PIN_no"></div>
      </div>
    </div>

    <!-- ===================== OWNER ===================== -->
    <div class="row">
      <div style="flex:2" class="field-row">
        <input type="hidden" name="property_ID" value="<?= $_GET['property_ID'] ?>">
        <span class="label">Owner</span>
        <div class="field field-value" id="owner_name" name="owner_name"></div>
      </div>

      <div style="flex:1" class="field-row">
        <span class="label">TIN</span>
        <div class="field field-value" id="owner_tin" name="owner_tin"></div>
      </div>
    </div>

    <div class="row">
      <div style="flex:2" class="field-row">
        <span class="label">Address</span>
        <div class="field field-value" id="owner_address" name="owner_address"></div>
      </div>

      <div style="flex:1" class="field-row">
        <span class="label">Telephone No.</span>
        <div class="field field-value" id="owner_no" name="owner_no"></div>
      </div>
    </div>

    <!-- ===================== ADMINISTRATOR ===================== -->
    <div class="row">
      <div style="flex:2" class="field-row">
        <span class="label">Administrator/Beneficial User</span>
        <div class="field field-value" id="admin_name" name="admin_name"></div>
      </div>

      <div style="flex:1" class="field-row">
        <span class="label">TIN</span>
        <div class="field field-value" id="admin_tin" name="admin_tin"></div>
      </div>
    </div>

    <div class="row">
      <div style="flex:2" class="field-row">
        <span class="label">Address</span>
        <div class="field field-value" id="admin_address" name="admin_address"></div>
      </div>

      <div style="flex:1" class="field-row">
        <span class="label">Telephone No.</span>
        <div class="field field-value" id="admin_no" name="admin_no"></div>
      </div>
    </div>

    <!-- ===================== LOCATION ===================== -->
    <div class="row" style="margin-top:15px;">
      <span class="label" style="flex:0 0 auto;">Location of Property</span>

      <div class="field field-value" id="street_no" name="street_no" style="flex:0.7;"></div>

      <div class="field field-value" id="property_brgy" name="property_brgy" style="flex:1;text-align:center;"></div>

      <div class="field field-value" id="property_municipality" name="property_municipality"
        style="flex:1;text-align:center;"></div>
    </div>

    <div class="row" style="margin-top:-6px;">
      <div style="flex:0 0 auto; width:150px;"></div>

      <div class="sub-label" style="flex:0.7;">
        (Number and Street)
      </div>

      <div class="sub-label" style="flex:1;">
        (Barangay/District)
      </div>

      <div class="sub-label" style="flex:1;">
        (Municipality, Province/City)
      </div>
    </div>

    <!-- ===================== PROPERTY INFO ===================== -->
    <div class="row" style="margin-top:15px;">
      <div style="flex:1" class="field-row">
        <span class="label">OCT/TCT/CLOA No.</span>
        <div class="field field-value" id="title_type" name="title_type"></div>
      </div>

      <div style="flex:1" class="field-row">
        <span class="label">Survey No.</span>
        <div class="field field-value" id="survey" name="survey"></div>
      </div>
    </div>

    <div class="row">
      <div style="flex:1" class="field-row">
        <span class="label">CCT</span>
        <div class="field field-value"></div>
      </div>

      <div style="flex:1" class="field-row">
        <span class="label">Lot No.</span>
        <div class="field field-value" id="lot_no" name="lot_no"></div>
      </div>
    </div>

    <div class="row">
      <div style="flex:1" class="field-row">
        <span class="label">Dated</span>
        <div class="field field-value" id="title_dated" name="title_dated"></div>
      </div>

      <div style="flex:1" class="field-row">
        <span class="label">Blk. No.</span>
        <div class="field field-value" id="BLK" name="BLK"></div>
      </div>
    </div>

    <div class="row" style="margin-top:15px;">
      <span class="label" style="flex:0 0 auto;">Boundaries</span>
    </div>
    <div class="row" style="margin-left:50px; margin-top:-5px;">
      <div style="flex:1" class="field-row">
        <span class="label">North</span>
        <div class="field field-value">BRGY. ROAD</div>
      </div>
      <div style="flex:1" class="field-row">
        <span class="label">SouthW</span>
        <div class="field field-value">ENCARNANCION SOLIS, JUAN SUMOG-OY</div>
      </div>
    </div>
    <div class="row" style="margin-left:50px; margin-top:-5px;">
      <div style="flex:1" class="field-row">
        <span class="label">East</span>
        <div class="field field-value">BRGY. ROAD</div>
      </div>
      <div style="flex:1" class="field-row">
        <span class="label">NWest</span>
        <div class="field field-value">AGAPITO SUMOG-OY, EDGARDO BANGOY, TEOPISTO ESTARIS</div>
      </div>
    </div>

    <hr class="hr-thin">
    <div class="section-title" style="margin-top: -12px;">KIND OF PROPERTY ASSESSED</div>

    <div class="row" style="align-items:center;">
      <div style="flex:1; display:flex; align-items:center;">
        <span class="checkbox">X</span>
        <span class="label" style="margin-right:20px;">LAND</span>
        <div class="field field-value" style="flex:0 0 60px; text-align:center;">97</div>
        <span class="label" style="margin-left:8px;">% Adjustment Factor</span>
      </div>
      <div style="flex:1; display:flex; align-items:center;">
        <span class="checkbox"></span>
        <span class="label">MACHINERY<br>Brief Description</span>
        <div class="field field-value" style="flex:1;"></div>
      </div>
    </div>

    <div class="row" style="align-items:center; margin-top:15px;">
      <div style="flex:1; display:flex; align-items:center;">
        <span class="checkbox"></span>
        <span class="label">BUILDING<br>No. of Storeys</span>
        <div class="field field-value" style="flex:1;"></div>
      </div>
      <div style="flex:1; display:flex; align-items:center;">
        <span class="checkbox"></span>
        <span class="label">OTHERS<br>Specify</span>
        <div class="field field-value" style="flex:1;"></div>
      </div>
    </div>

    <div class="row" style="margin-top:10px;">
      <span class="label" style="flex:0 0 auto;">Brief Description</span>
      <div class="field field-value" style="flex:1;"></div>
    </div>

    <table>
      <thead>
        <tr>
          <th style="border-bottom: 1px solid #333; text-align: center; width: 10%;">Classification</th>
          <th style="width: 1px;"></th>
          <th style="border-bottom: 1px solid #333; text-align: center; width: 10%;">Area</th>
          <th style="width: 1px;"></th>
          <th style="border-bottom: 1px solid #333; text-align: center; width: 15%;">Market Value</th>
          <th style="width: 1px;"></th>
          <th style="border-bottom: 1px solid #333; text-align: center; width: 10%;">Actual Use</th>
          <th style="width: 1px;"></th>
          <th style="border-bottom: 1px solid #333; text-align: center; width: 15%;">Assessment Level</th>
          <th style="width: 1px;"></th>
          <th style="border-bottom: 1px solid #333; text-align: center; width: 15%;">Assessed Value</th>
          <th style="width: 1px;"></th>
          <th style="border-bottom: 1px solid #333; text-align: center; width: 10%;">Taxability</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Residential</td>
          <th></th>
          <td class="num">184</td>
          <th></th>
          <td class="num">92,000.00</td>
          <th></th>
          <td style="text-align: center;">AR</td>
          <th></th>
          <td style="text-align: center;">20 %</td>
          <th></th>
          <td class="num">18,400.00</td>
          <th></th>
          <td style="text-align: center;">T</td>
        </tr>
        <tr>
          <td>Agricultural</td>
          <th></th>
          <td class="num">2.8000</td>
          <th></th>
          <td class="num">360,840.00</td>
          <th></th>
          <td style="text-align: center;">AA</td>
          <th></th>
          <td style="text-align: center;">40 %</td>
          <th></th>
          <td class="num">144,340.00</td>
          <th></th>
          <td style="text-align: center;">T</td>
        </tr>
        <!-- <tr>
          <td></td>
          <td></td>
          <td>Total</td>
          <th></th>
          <td class="num">PHP 360,840.00</td>
          <th></th>
          <td style="text-align: center;">AA</td>
          <th></th>
          <td style="text-align: center;">40 %</td>
          <th></th>
          <td class="num">144,340.00</td>
          <th></th>
          <td style="text-align: center;">T</td>
        </tr> -->
        <!-- <tr>
          <td>&nbsp;</td>
          <td></td>
          <td></td>
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
          <td></td>
          <td></td>
        </tr> -->
      </tbody>
    </table>

    <div class="totals">
      <div class="total-block" style="margin-left:113px;">
        <b>
          <span style="display:inline-block; width:63px;">Total</span>
          <span style="display:inline-block; width:111px;">Php</span>
          <span style="width: 10%; border-bottom: #333;"> 452,840.00</span>
        </b>
      </div>

      <div class="total-block">
        Exempted Assessed Value
        <span style="display:inline-block; width:30px;"></span>
        <b>0.00</b>
      </div>
    </div>
    <div class="totals">
      <div class="total-block"></div>
      <div class="total-block">Taxable Assessed Value &nbsp; <b>162,740.00</b></div>
    </div>

    <div class="row" style="margin-top:15px; align-items:center;">
      <span class="label" style="flex:0 0 auto;">Total Assessed Value</span>
      <div class="field field-value" style="flex:1; text-align:center; font-weight:bold;">ONE HUNDRED SIXTY TWO THOUSAND
        SEVEN HUNDRED FORTY PESOS</div>
    </div>
    <div class="amount-label">(Amount in words)</div>

    <div class="row" style="margin-top:15px; align-items:center;">
      <span class="label">Taxable</span>
      <span class="checkbox">X</span>
      <span class="label" style="margin-left:20px;">Exempt</span>
      <span class="checkbox"></span>
      <span class="label" style="margin-left:30px;">Effectivity of Assessment/Reassessment</span>
      <div class="field field-value" style="flex:0 0 60px; text-align:center;">1<br><span
          style="font-size:10px;">Qtr</span></div>
      <div class="field field-value" style="flex:0 0 80px; text-align:center;">2022<br><span
          style="font-size:10px;">Year</span></div>
    </div>
    <div class="row" style="justify-content: flex-start; margin-top:10px;">
      <span class="label" style="width:100px;">Prepared</span>
      <span class="label" style="margin-left:280px;">Approved</span>
    </div>

    <div class="row" style="margin-top:-40px; justify-content:space-between;">
      <div class="signature-block">
        <div class="sig-line">CESAR Q. TAGLE, JR.</div>
        <div class="sig-title">Deputy</div>
      </div>
      <div class="signature-block">
        <div class="sig-line">ATTY. SILVESTRE C. UNTARAN III</div>
        <div class="sig-title">Provincial Assessor</div>
      </div>
    </div>


    <hr class="hr-thin">

    <div class="row">
      <div style="flex:1.5" class="field-row">
        <span class="label">This declaration cancels TD No.</span>
        <div class="field field-value">13-0013-00431</div>
      </div>
      <div style="flex:1" class="field-row">
        <span class="label">Prev. Owner</span>
        <div class="field field-value">Ramona Dalumpines</div>
      </div>
      <div style="flex:1" class="field-row">
        <span class="label">Previous A.V.</span>
        <div class="field field-value">109,210.00</div>
      </div>
    </div>

    <div class="row">
      <div style="flex:1.5" class="field-row">
        <span class="label">Previous Property Index No.</span>
        <div class="field field-value">040-13-0013-001-01</div>
      </div>
      <div style="flex:1" class="field-row">
        <span class="label">Transaction Code:</span>
        <div class="field field-value">GR</div>
      </div>
    </div>

    <div class="row">
      <span class="label" style="flex:0 0 auto;">Memoranda</span>
      <div class="field field-value" style="flex:1;"></div>
    </div>

    <div class="note-box">
      <b>Note</b> This declaration is for real property taxation purposes only and the valuation indicated herein are
      based on the schedule of unit market values
      prepared for the purpose and duly enacted into an Ordinance by the SANGGUNIANG PANLALAWIGAN NG ANTIQUE under
      Ordinance No. 2019-189 dated
      October 14, 2019. It does not and cannot by itself alone confer any ownership or legal title to the property.
    </div>

  </div>
</body>

</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
      url: "../land/ajax.php?action=get_property_revised",
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