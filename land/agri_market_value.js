function filledAgri(row) {
  return `
    <tr>
        <td>
            <select class="form-control agri_class" name="agri_class[]" required>
                ${agri_class_options.replace(
                  `value="${row.class}"`,
                  `value="${row.class}" selected`,
                )}
            </select>
        </td>

        <td>
            <select class="form-control sub_class" name="sub_class[]" required>
                <option value="">-- Select Sub --</option>
                <option value="1" ${
                  row.sub_class == 1 ? "selected" : ""
                }>1st</option>
                <option value="2" ${
                  row.sub_class == 2 ? "selected" : ""
                }>2nd</option>
                <option value="3" ${
                  row.sub_class == 3 ? "selected" : ""
                }>3rd</option>
                <option value="4" ${
                  row.sub_class == 4 ? "selected" : ""
                }>4th</option>
            </select>
        </td>

        <td><input type="number" name="area_land[]" class="form-control area" value="${
          row.area_land
        }" step="any"></td>
        <td><input type="number" name="unit_value_land[]" class="form-control unit-value" value="${
          row.unit_value_land
        }" step="any"></td>
        <td><input type="number" name="market_value_land[]" class="form-control bmv" value="${
          row.market_value_land
        }" step="any" readonly></td>

        <td><button class="btn btn-danger btn-sm remove-row">Remove</button></td>
    </tr>`;
}
function loadAgri(land_property_ID) {
  $.ajax({
    url: BASE_URL + "/php/fetch_land.php",
    type: "POST", // <-- change to POST
    data: { land_property_ID: land_property_ID }, // <-- send the ID
    dataType: "json",
    success: function (data) {
      $("#agricultural-table tbody").empty();

      data.forEach(function (row) {
        $("#agricultural-table tbody").append(filledAgri(row));
      });
    },
  });
}

$("#add-row-agri").click(function () {
  $("#agricultural-table tbody").append(createRowAgri());
});

$("#agricultural-table").on("click", ".remove-row", function () {
  $(this).closest("tr").remove();
  recalculateTotals();
});

$("#agricultural-table").on("input", ".area, .unit-value", function () {
  recalculateTotals();
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

$("#agricultural-form").on("submit", function (e) {
  e.preventDefault();

  const form = $(this);

  // ==========================================
  // CHECK AGRICULTURAL ROWS
  // ==========================================

  const rowCount = $("#agricultural-table tbody tr").length;

  if (rowCount < 1) {
    alert("Please add at least one land agricultural before saving.");

    return;
  }

  // ==========================================
  // PROPERTY ID
  // ==========================================

  const property_ID = $("#input_property_ID").val();

  if (!property_ID) {
    alert("Missing Property ID.");

    return;
  }

  // ==========================================
  // TOTAL AGRICULTURAL VALUES
  // ==========================================

  const rawMVText = $("#total-bmv-agri").text().replace(/,/g, "");

  const totalLandMV = (parseFloat(rawMVText) || 0).toFixed(3);
  const totalArea = parseFloat($("#total-area").text()) || 0;

  // ==========================================
  // SET BASE MARKET VALUE
  // ==========================================

  // If mvbmv should always be the agricultural
  // total BMV, automatically set it here.

  $("#mvbmv").val(totalLandMV);

  // ==========================================
  // SERIALIZE ENTIRE FORM
  // ==========================================

  let formData = form.serialize();

  // ==========================================
  // ADD VALUES THAT ARE NOT FORM INPUTS
  // ==========================================

  formData += "&property_ID=" + encodeURIComponent(property_ID);

  formData += "&total_land_area=" + encodeURIComponent(totalArea);

  formData += "&total_land_mv=" + encodeURIComponent(totalLandMV);

  // ==========================================
  // DEBUG
  // ==========================================

  console.log("Saving land:");
  console.log(formData);

  // ==========================================
  // DISABLE SAVE WHILE PROCESSING
  // ==========================================

  $("#save-land").prop("disabled", true);

  // ==========================================
  // AJAX
  // ==========================================

  $.ajax({
    url: "ajax.php?action=save_land",

    type: "POST",

    data: formData,

    dataType: "json",

    success: function (response) {
      console.log(response);

      if (response.success) {
        alert(response.message);

        // ==================================
        // DISABLE AGRICULTURAL INPUTS
        // ==================================

        $("#agricultural-table tbody select").prop("disabled", true);

        $("#agricultural-table tbody input").prop("disabled", true);

        // ==================================
        // DISABLE REMOVE BUTTONS
        // ==================================

        $("#agricultural-table tbody .remove-row").prop("disabled", true);

        // ==================================
        // DISABLE ADD BUTTON
        // ==================================

        $("#add-row-agri").prop("disabled", true);

        // ==================================
        // DISABLE MARKET VALUE INPUTS
        // ==================================

        $("#factor_first").prop("disabled", true);

        $("#percentage_first").prop("disabled", true);

        $("#factor_second").prop("disabled", true);

        $("#percentage_second").prop("disabled", true);

        $("#factor_third").prop("disabled", true);

        $("#percentage_third").prop("disabled", true);

        // ==================================
        // DISABLE SAVE
        // ==================================

        $("#save-land").prop("disabled", true);
        location.reload();
      } else {
        // Allow saving again if failed

        $("#save-land").prop("disabled", false);

        alert("Save failed: " + (response.message || "Unknown error"));
      }
    },

    error: function (xhr, status, error) {
      console.error("AJAX Error:", xhr.responseText);

      $("#save-land").prop("disabled", false);

      alert("Error saving data:\n" + xhr.responseText);
    },
  });
});

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

/* =========================================================
   Helper
========================================================= */

function setSelectValue($select, value, label = value) {
  if (value === undefined || value === null || value === "") return;

  value = String(value);

  if (!$select.find(`option[value="${value}"]`).length) {
    $select.append(`<option value="${value}">${label}</option>`);
  }

  $select.val(value);
}

/* =========================================================
   1st Adjustment
========================================================= */

let adjustmentLoaded = false;

function loadAdjustments() {
  if (adjustmentLoaded) return;

  $.ajax({
    url: BASE_URL + "/php/fetch_adjustment_factors.php",
    dataType: "json",

    success: function (data) {
      /* ==========================================
               ROAD
            ========================================== */

      let roadFactor = '<option value="">-- Select Factor --</option>';

      let roadPercentage = '<option value="">-- Select Percentage --</option>';

      data.ROAD.forEach((row) => {
        roadFactor += `
                    <option
                        value="${row.description}"
                        data-percent="${row.percentage_A}">
                        ${row.description}
                    </option>
                `;

        roadPercentage += `
                    <option
                        value="${row.percentage_A}"
                        data-desc="${row.description}">
                        ${row.percentage_A}
                    </option>
                `;
      });

      $("#factor_first").html(roadFactor);
      $("#percentage_first").html(roadPercentage);

      /* ==========================================
               LOCATION-W
            ========================================== */

      let weatherFactor = '<option value="">-- Select Factor --</option>';

      let weatherPercentageA =
        '<option value="">-- Select Percentage --</option>';

      data["Location-Weather"].forEach((row) => {
        weatherFactor += `
                    <option
                        value="${row.description}"
                        data-percent="${row.percentage_A}">
                        ${row.description}
                    </option>
                `;

        weatherPercentageA += `
                    <option
                        value="${row.percentage_A}"
                        data-desc="${row.description}">
                        ${row.percentage_A}
                    </option>
                `;
      });

      $("#factor_second").html(weatherFactor);
      $("#percentage_second").html(weatherPercentageA);

      let tradingCenterFactor = '<option value="">-- Select Factor --</option>';
      let treadingCenterPercentageA =
        '<option value="">-- Select Percentage --</option>';

      data["Location-Trading"].forEach((row) => {
        tradingCenterFactor += `
                    <option
                        value="${row.description}"
                        data-percent="${row.percentage_A}">
                        ${row.description}
                    </option>
                `;

        treadingCenterPercentageA += `
                    <option
                        value="${row.percentage_A}"
                        data-desc="${row.description}">
                        ${row.percentage_A}
                    </option>
                `;
      });

      $("#factor_third").html(tradingCenterFactor);
      $("#percentage_third").html(treadingCenterPercentageA);

      adjustmentLoaded = true;
    },

    error: function (xhr, status, error) {
      console.error("Failed to load adjustment factors:", error);
    },
  });
}

$(document).ready(function () {
  loadAdjustments();
});

let load_FMV = false;
let load_SMV = false;

const FMV = { value: false };
const SMV = { value: false };
const TMV = { value: false };

function syncSelect(source, target, flag, data) {
  $(source).on("change", function () {
    if (flag.value) return;

    flag.value = true;

    setSelectValue($(target), $(this).find(":selected").data(data));

    calculateMarketValue();

    flag.value = false;
  });
}

syncSelect("#factor_first", "#percentage_first", FMV, "percent");
syncSelect("#percentage_first", "#factor_first", FMV, "desc");

syncSelect("#factor_second", "#percentage_second", SMV, "percent");
syncSelect("#percentage_second", "#factor_second", SMV, "desc");

syncSelect("#percentage_third", "#factor_third", TMV, "desc");
syncSelect("#factor_third", "#percentage_third", TMV, "percent");

/* =========================================================
   Load Adjustments
========================================================= */

// $(document).ready(function () {
//   load_1st_Adjustment();
//   load_2nd_Adjustment();
// });

function loadAgriUnitValue(row) {
  const agri_class = row.find(".agri_class").val();
  const sub_class = row.find(".sub_class").val();
  const unitValueInput = row.find(".unit-value");

  // Clear if incomplete
  if (!agri_class || !sub_class) {
    unitValueInput.val("");
    row.find(".bmv").val("");
    return;
  }

  $.ajax({
    url: "get_agri_class_value.php",
    type: "GET",
    dataType: "json",
    data: {
      agri_class: agri_class,
      sub_class: sub_class,
    },

    success: function (res) {
      if (res.success && res.unit_value !== null) {
        unitValueInput.val(res.unit_value);
        recalculateTotals();
      } else {
        unitValueInput.val("");
        row.find(".bmv").val("");
      }
    },

    error: function (xhr) {
      console.error("Agricultural unit value error:", xhr.responseText);

      unitValueInput.val("");
      row.find(".bmv").val("");
    },
  });
}

$(document).on("change", ".agri_class, .sub_class", function () {
  const row = $(this).closest("tr");

  loadAgriUnitValue(row);
});
