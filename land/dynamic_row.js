$(document).ready(function () {
  // alert(BASE_URL + "/php/insert/insert_resid.php");
  // $("#agricultural-table tbody").append(createRowAgri());
  // $("#non_agricultural-table tbody").append(createRowResidential());
  // // $("#market-value-table tbody").append(createRowMarketValue());
  // $("#assessment-table tbody").append(createRowAssessment());

  $("#add-row-agri").click(function () {
    $("#agricultural-table tbody").append(createRowAgri());
  });
  $("#add-row-non_agricultural").click(function () {
    $("#non_agricultural-table tbody").append(createRowResidential());
  });
  // $("#add-row-market-value").click(function () {
  //   $("#market-value-table tbody").append(createRowMarketValue());
  // });
  $("#add-row-assessment").click(function () {
    $("#assessment-table tbody").append(createRowAssessment());
  });

  $("#non_agricultural-table").on(
    "click",
    ".remove-row-non_agricultural",
    function () {
      $(this).closest("tr").remove();
      recalculateResidential();
    },
  );

  $("#assessment-table").on("click", ".remove-row-assessment", function () {
    $(this).closest("tr").remove();
    recalculateAssessment();
  });

  $("#agricultural-table").on("click", ".remove-row", function () {
    $(this).closest("tr").remove();
    recalculateTotals();
  });

  $("#agricultural-table").on("input", ".area, .unit-value", function () {
    recalculateTotals();
  });
  $("#non_agricultural-table").on(
    "input",
    ".area-resid, .unit-value-resid",
    function () {
      recalculateResidential();
    },
  );

  $("#assessment-table").on("input", ".area, .unit-value", function () {
    recalculateAssessment();
  });

  function createRowAgri() {
    return `
    <tr>
        <td>
            <select class="form-control agri_class" name="agri_class[]" required>
                ${agri_class_options}
            </select>
        </td>
        <td>
            <select class="form-control sub_class" name="sub_class[]" required>
                <option value="">-- Select Sub --</option>
                <option value="1">1st</option>
                <option value="2">2nd</option>
                <option value="3">3rd</option>
                <option value="4">4th</option>
            </select>
        </td>
        <td><input type="number" name="area_land[]" class="form-control area" placeholder="Area"  step="any" required></td>
        <td><input type="number" name="unit_value_land[]" class="form-control unit-value" step="any" placeholder="Unit Value" required></td>
        <td><input type="number" name="market_value_land[]" class="form-control bmv" step="any" placeholder="BMV" readonly></td>
        <td><button class="btn btn-danger btn-sm remove-row">Remove</button></td>
    </tr>`;
  }

  function createRowResidential() {
    return `
    <tr>
        <td>
            <select class="form-control kind" name="kind[]" id="kind" required>
                ${non_agri_options}
            </select>
        </td>  
         <td><input type="number" name="area_resid[]" id="area_resid" class="form-control area-resid" placeholder="Area" step="any" required></td>
        <td><input type="number" name="unit_value_resid[]" id="unit_value_resid" class="form-control unit-value-resid" placeholder="Unit Value" required></td>
         <td><input type="tex" name="adjustment_factor[]" id="adjustment_factor" class="form-control adjustment-factor" placeholder="Adjustment Factor" required></td>
        <td><input type="text" name="market_value_resid[]" id="market_value_resid" class="form-control market-value-resid" placeholder="BMV" step="any"readonly></td>
        <td><button class="btn btn-danger btn-sm remove-row-non_agricultural">Remove</button></td>
    </tr>`;
  }

  function createRowAssessment() {
    return `
    <tr>
        <td>
            <select class="form-control actual_use" name="actual_use[]" required>
                ${au_options}
            </select>
        </td>
        <td>
            <select class="form-control taxable" name="taxable[]" required>
                <option value="">-- Select Sub --</option>
                <option value="TAXABLE">TAXABLE</option>
                <option value="EXEMPT">EXEMPT</option>
            </select>
        </td>       
        <td><input type="number" name="market_value_assessed[]" class="form-control area" placeholder="Market Value" step="any" required></td>
        <td><input type="number" name="assessed_level[]" class="form-control unit-value" placeholder="Unit Value" required></td>
        <td><input type="text" name="assessed_value[]" class="form-control bmv" placeholder="BMV" step="any" readonly></td>
        <td><button class="btn btn-danger btn-sm remove-row-assessment">Remove</button></td>
    </tr>`;
  }

  function recalculateTotals() {
    let totalArea = 0;
    let totalBMV = 0;

    $("#agricultural-table tbody tr").each(function () {
      const area = parseFloat($(this).find(".area").val()) || 0;
      const unitValue = parseFloat($(this).find(".unit-value").val()) || 0;
      const baseMarketValue = area * unitValue;

      $(this).find(".bmv").val(baseMarketValue);

      totalArea += area;
      totalBMV += baseMarketValue;
    });

    $("#mvbmv").val(totalBMV);

    $("#total-area").text(totalArea);
    $("#total-bmv-agri").text(totalBMV);
    calculateMarketValue();
  }

  function calculateMarketValue() {
    // Get values
    let mvbmv = parseFloat($("#mvbmv").val()) || 0;
    let p1 = parseFloat($("#percentage_first").val()) || 0;
    let p2 = parseFloat($("#percentage_second").val()) || 0;
    let p3 = parseFloat($("#percentage_third").val()) || 0;

    // Total percentage
    let totalPercent = p1 + p2 + p3;
    $("#percent_total").val(totalPercent);

    // Convert percentage to decimal
    let percentDecimal = totalPercent / 100;

    // Value adjustment (always positive magnitude)
    let valueAdjustment = Math.abs(mvbmv * percentDecimal);
    $("#value_adjustment").val(valueAdjustment);

    // Market value logic
    let marketValue;

    if (totalPercent < 0) {
      // Negative percentage → subtract adjustment
      marketValue = mvbmv - valueAdjustment;
    } else {
      // Positive percentage → add adjustment
      marketValue = mvbmv + valueAdjustment;
    }

    $("#market_value").val(marketValue);
  }

  // Trigger calculation on any input change
  // $("#mvbmv, #percent_first, #percent_second, #percent_third").on(
  //   "input",
  //   function () {
  //     calculateMarketValue();
  //   }
  // );

  function recalculateResidential() {
    let totalArea = 0;
    let totalBMV = 0;

    $("#non_agricultural-table tbody tr").each(function () {
      const area = parseFloat($(this).find(".area-resid").val()) || 0;
      const unitValue =
        parseFloat($(this).find(".unit-value-resid").val()) || 0;
      const baseMarketValue = area * unitValue;

      $(this).find(".market-value-resid").val(baseMarketValue);

      totalArea += area;
      totalBMV += baseMarketValue;
    });

    $("#total-area-non_agricultural").text(totalArea);
    $("#total-bmv-non_agricultural").text(totalBMV);
  }

  function recalculateAssessment() {
    let totalArea = 0;
    let totalBMV = 0;

    $("#assessment-table tbody tr").each(function () {
      const area = parseFloat($(this).find(".area").val()) || 0;
      const unitValue = parseFloat($(this).find(".unit-value").val()) || 0;
      const baseMarketValue = area * (unitValue / 100);

      $(this).find(".bmv").val(baseMarketValue);

      totalArea += area;
      totalBMV += baseMarketValue;
    });

    $("#total-assessed-value").text(totalArea);
    $("#total-bmv-assessment").text(totalBMV);
  }

  $("#agricultural-form").on("submit", function (e) {
    e.preventDefault();

    let rowCount = $("#agricultural-table tbody tr").length;

    if (rowCount < 1) {
      alert("Please add at least one land agricultural before saving.");
      return;
    }

    let land_property_ID = $("#input_property_ID").val();
    let totalArea = parseFloat($("#total-area").text()) || 0;
    let totalLandMV = parseFloat($("#total-bmv-agri").text()) || 0;
    // alert(totalArea);

    // alert(land_property_ID);

    // This will automatically collect all fields including arrays
    let formData = $(this).serialize();
    formData += "&property_ID=" + encodeURIComponent(land_property_ID);
    formData += "&total_land_area=" + encodeURIComponent(totalArea); // ✅ ADD THIS
    formData += "&total_land_mv=" + encodeURIComponent(totalLandMV); // ✅ ADD THIS
    $.ajax({
      url: "ajax.php?action=save_land",
      type: "POST",
      data: formData, // send raw form data
      success: function (response) {
        alert(response);
        // Disable all inputs so the inserted values remain visible
        $("#agricultural-table tbody select").prop("disabled", true);
        $("#agricultural-table tbody input").prop("disabled", true);

        // Disable remove button
        $("#agricultural-table tbody .remove-row").prop("disabled", true);

        // Disable Add button
        $("#add-row-agri").prop("disabled", true);

        // Disable Save button
        $("#save-land").prop("disabled", true);
      },
      error: function (xhr, status, error) {
        alert("Error: " + error);
      },
    });
  });

  $("#non_agricultural-form").on("submit", function (e) {
    e.preventDefault();

    let rowCount = $("#non_agricultural-table tbody tr").length;

    if (rowCount < 1) {
      alert("Please add at least one land agricultural before saving.");
      return;
    }

    let land_property_ID = $("#input_property_ID").val();
    let totalAreaResid =
      parseFloat($("#total-area-non_agricultural").text()) || 0;
    let totalBMWResid =
      parseFloat($("#total-bmv-non_agricultural").text()) || 0;

    // This will automatically collect all fields including arrays
    let formData = $(this).serialize();
    formData += "&property_ID=" + encodeURIComponent(land_property_ID);
    formData += "&total_non_agri_area=" + encodeURIComponent(totalAreaResid); // ✅ ADD THIS
    formData += "&total_non_agri_mv=" + encodeURIComponent(totalBMWResid); // ✅ ADD THIS

    $.ajax({
      url: BASE_URL + "/php/insert/insert_resid.php",
      type: "POST",
      data: formData, // send raw form data
      success: function (response) {
        alert(response);
        // Disable all inputs so the inserted values remain visible
        $("#non_agricultural-table tbody select").prop("disabled", true);
        $("#non_agricultural-table tbody input").prop("disabled", true);

        // Disable remove button
        $("#non_agricultural-table tbody .remove-row").prop("disabled", true);

        // Disable Add button
        $("#add-row-non_agricultural").prop("disabled", true);

        // Disable Save button
        $("#save-non_agricultural").prop("disabled", true);
      },
      error: function (xhr, status, error) {
        alert("Error: " + error);
      },
    });
  });

  $("#market-value-form").on("submit", function (e) {
    e.preventDefault();

    let land_property_ID = $("#input_property_ID").val();

    // This will automatically collect all fields including arrays
    let formData = $(this).serialize();
    formData += "&property_ID=" + encodeURIComponent(land_property_ID);

    $.ajax({
      url: BASE_URL + "/php/insert_mv.php",
      type: "POST",
      data: formData, // send raw form data
      success: function (response) {
        alert(response);
        $("#save-market-value").prop("disabled", true);

        // Disable all inputs so the inserted values remain visible
      },
      error: function (xhr, status, error) {
        alert("Error: " + error);
      },
    });
  });

  $("#assessment-form").on("submit", function (e) {
    e.preventDefault();

    let rowCount = $("#assessment-table tbody tr").length;

    if (rowCount < 1) {
      alert("Please add at least one land agricultural before saving.");
      return;
    }

    let land_property_ID = $("#input_property_ID").val();
    let totalMarketValue = $("#total-bmv-assessment").text();
    let totalAssessedValue = $("#total-assessed-value").text();

    // This will automatically collect all fields including arrays
    let formData = $(this).serialize();
    formData += "&property_ID=" + encodeURIComponent(land_property_ID);
    formData += "&total_assessment_mv=" + encodeURIComponent(totalMarketValue); // ✅ ADD THIS
    formData +=
      "&total_assessed_value=" + encodeURIComponent(totalAssessedValue); // ✅ ADD THIS

    $.ajax({
      url: BASE_URL + "/php/insert/insert_assessment.php",
      type: "POST",
      data: formData, // send raw form data
      success: function (response) {
        alert(response);
        $("#save-assessment").prop("disabled", true);

        // Disable Save button
        $("#add-row-assessment").prop("disabled", true);
        // Disable all inputs so the inserted values remain visible
      },
      error: function (xhr, status, error) {
        alert("Error: " + error);
      },
    });
  });

  let load_FMV = false;
  let sync_FMV = false;
  let load_SMV = false;
  let sync_SMV = false;

  function setSelectValue($select, value, label = value) {
    if (value === undefined || value === null || value === "") return;

    value = value.toString();

    if ($select.find(`option[value="${value}"]`).length === 0) {
      $select.append(`<option value="${value}">${label}</option>`);
    }

    $select.val(value);
  }

  function load_1st_Adjusment() {
    if (load_FMV) return;

    $.ajax({
      url: BASE_URL + "/php/fetch_adjustment_factors.php",
      dataType: "json",
      success: function (data) {
        let factorOpt = '<option value="">-- Select Factor --</option>';
        let percentOpt = '<option value="">-- Select Percentage --</option>';

        data.forEach((row) => {
          factorOpt += `
          <option value="${row.description}" data-percent="${row.percentage_A}">
            ${row.description}
          </option>`;

          percentOpt += `
          <option value="${row.percentage_A}" data-desc="${row.description}">
            ${row.percentage_A}
          </option>`;
        });

        $("#factor_first").html(factorOpt);
        $("#percentage_first").html(percentOpt);

        load_FMV = true;
      },
    });
  }

  $(document).ready(load_1st_Adjusment);
  $("#factor_first").on("change", function () {
    if (sync_FMV) return;
    sync_FMV = true;

    let percent = $(this).find(":selected").data("percent");
    setSelectValue($("#percentage_first"), percent);

    calculateMarketValue();
    sync_FMV = false;
  });

  /* Percentage → Factor */
  $("#percentage_first").on("change", function () {
    if (sync_FMV) return;
    sync_FMV = true;

    let desc = $(this).find(":selected").data("desc");
    setSelectValue($("#factor_first"), desc, desc);

    sync_FMV = false;
  });

  $("#factor_first").on("change", function () {
    if (sync_FMV) return;
    sync_FMV = true;

    let percent = $(this).find(":selected").data("percent");
    setSelectValue($("#percentage_first"), percent);

    calculateMarketValue();
    sync_FMV = false;
  });

  /* Percentage → Factor */
  $("#percentage_first").on("change", function () {
    if (sync_FMV) return;
    sync_FMV = true;

    let desc = $(this).find(":selected").data("desc");
    setSelectValue($("#factor_first"), desc, desc);

    sync_FMV = false;
  });

  function load_2nd_Adjusment() {
    if (load_SMV) return;

    $.ajax({
      url: BASE_URL + "/php/fetch_adjustment_factors_2nd.php",
      dataType: "json",
      success: function (data) {
        let factorOpt = '<option value="">-- Select Factor --</option>';
        let percentOpt2 = '<option value="">-- Select Percentage --</option>';
        let percentOpt3 = '<option value="">-- Select Percentage --</option>';

        data.forEach((row) => {
          factorOpt += `
          <option value="${row.description}"
            data-percent="${row.percentage_A}"
            data-sec_percent="${row.percentage_B}">
            ${row.description}
          </option>`;

          percentOpt2 += `
          <option value="${row.percentage_A}"
            data-desc="${row.description}"
            data-sec_percent="${row.percentage_B}">
            ${row.percentage_A}
          </option>`;

          percentOpt3 += `
          <option value="${row.percentage_B}"
            data-desc="${row.description}"
            data-percent="${row.percentage_A}">
            ${row.percentage_B}
          </option>`;
        });

        $("#factor_second").html(factorOpt);
        $("#percentage_second").html(percentOpt2);
        $("#percentage_third").html(percentOpt3);

        load_SMV = true;
      },
    });
  }

  /* Load immediately */
  $(document).ready(load_2nd_Adjusment);

  /* Factor → Percentages */
  $("#factor_second").on("change", function () {
    if (sync_SMV) return;
    sync_SMV = true;

    let $opt = $(this).find(":selected");

    setSelectValue($("#percentage_second"), $opt.data("percent"));
    setSelectValue($("#percentage_third"), $opt.data("sec_percent"));

    calculateMarketValue();
    sync_SMV = false;
  });

  /* Percentage Second → Others */
  $("#percentage_second").on("change", function () {
    if (sync_SMV) return;
    sync_SMV = true;

    let $opt = $(this).find(":selected");

    setSelectValue($("#factor_second"), $opt.data("desc"), $opt.data("desc"));
    setSelectValue($("#percentage_third"), $opt.data("sec_percent"));

    calculateMarketValue();
    sync_SMV = false;
  });

  /* Percentage Third → Others */
  $("#percentage_third").on("change", function () {
    if (sync_SMV) return;
    sync_SMV = true;

    let $opt = $(this).find(":selected");

    setSelectValue($("#factor_second"), $opt.data("desc"), $opt.data("desc"));
    setSelectValue($("#percentage_second"), $opt.data("percent"));

    calculateMarketValue();
    sync_SMV = false;
  });
});

// Helpers
// function setSelectValue($select, value) {
//   if ($select.find(`option[value="${value}"]`).length === 0) {
//     $select.append(new Option(value, value, true, true));
//   } else {
//     $select.val(value);
//   }
// }
