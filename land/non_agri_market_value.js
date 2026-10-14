function loadNonAgri(land_property_ID) {
  $.ajax({
    url: BASE_URL + "/php/fetch_resid.php",
    type: "POST",
    data: {
      land_property_ID: land_property_ID,
    },
    dataType: "json",

    success: function (data) {
      // FIX #8: always clear the table first, even when the property has
      // zero rows — otherwise the previous property's rows stay on screen.
      $("#non_agricultural-table tbody").empty();

      data.forEach(function (row) {
        $("#non_agricultural-table tbody").append(filledNonAgri(row));
      });

      recalculateNonAgri();
    },
  });
}
function filledNonAgri(row) {
  const hasStrips = Number(row.second_strip_area) > 0;

  return `
    <tr>
        <td>
            <select class="form-control kind" name="kind[]">
                ${non_agri_options.replace(
                  `value="${row.kind}"`,
                  `value="${row.kind}" selected`,
                )}
            </select>
        </td>
 
        <td>
            <select
                name="adjustment_factor[]"
                class="form-control adjustment-factor"
                required
            >
                ${getAdjustmentFactors(row.kind).replace(
                  `value="${row.adjustment_factor}"`,
                  `value="${row.adjustment_factor}" selected`,
                )}
            </select>
        </td>
 
        <td>
            <input
                type="number"
                name="unit_value_resid[]"
                class="form-control unit-value-resid"
                value="${row.unit_value_resid ?? ""}"
                placeholder="Unit Value"
                step="any"
                required
            >
        </td>
 
        <td>
            <input
                type="number"
                name="corner_influence[]"
                class="form-control corner-influence"
                value="${row.corner_influence ?? ""}"
                placeholder="Corner Influence"
            >
        </td>
 
        <td>
            <input
                type="number"
                name="first_strip_area[]"
                class="form-control first-strip-area"
                value="${row.first_strip_area ?? ""}"
                placeholder="meter"
                step="any"
                required
            >
        </td>
 
        <td>
            <input
                type="number"
                name="first_strip_percent[]"
                class="form-control first-strip-percent"
                value="${row.first_strip_percent ?? 100}"
                placeholder="Percent"
                step="any"
                required
            >
        </td>
 
        <td>
            <input
                type="number"
                name="first_strip_mv[]"
                class="form-control first-strip-mv"
                value="${row.first_strip_mv ?? ""}"
                placeholder="Strip Market Value"
                step="any"
                readonly
            >
        </td>
 
        <td>
            <input
                type="number"
                name="area_resid[]"
                class="form-control area-resid"
                value="${row.area_resid ?? ""}"
                placeholder="Area"
                step="any"
                required
            >
        </td>
 
        <td>
            <input
                type="text"
                name="market_value_resid[]"
                class="form-control market-value-resid"
                value="${row.market_value_resid ?? ""}"
                placeholder="BMV"
                readonly
            >
        </td>
 
        <td>
            <button
                type="button"
                class="btn btn-sm ${
                  hasStrips ? "btn-warning strip-active" : "btn-info"
                } add-strip"
            >
                ${hasStrips ? "-" : "+"}
            </button>
 
            <button
                type="button"
                class="btn btn-danger btn-sm remove-row-non_agricultural"
            >
                x
            </button>
        </td>
    </tr>
 
    ${hasStrips ? createStripRows(row) : ""}
  `;
}

$("#add-row-non_agricultural").click(function () {
  $("#non_agricultural-table tbody").append(createRowNonAgri());
});

$("#non_agricultural-table").on(
  "click",
  ".remove-row-non_agricultural",
  function () {
    const parentRow = $(this).closest("tr");

    parentRow.nextUntil(":not(.strip-row)").filter(".strip-row").remove();
    parentRow.remove();

    recalculateNonAgri();
  },
);

$("#non_agricultural-table").on(
  "input",
  ".area-resid, .unit-value-resid",
  function () {
    recalculateNonAgri();
  },
);

function createRowNonAgri() {
  // FIX #2: removed the hardcoded id="..." attributes. They produced
  // duplicate DOM ids once more than one row existed, which broke any
  // id-based lookup. The existing .class selectors already do the job.
  return `
    <tr>
        <td>
            <select class="form-control kind" name="kind[]" required>
                ${non_agri_options}
            </select>
        </td>
        <td>
            <select
                name="adjustment_factor[]"
                class="form-control adjustment-factor"
            >
                <option value="">Select Adjustment Factor</option>
            </select>
        </td>
        <td><input type="number" name="unit_value_resid[]" class="form-control unit-value-resid" placeholder="Unit Value" required></td>
        <td><input type="number" name="corner_influence[]" class="form-control corner-influence" placeholder="Corner Influence"></td>
        <td><input type="number" name="first_strip_area[]" class="form-control first-strip-area" placeholder="meter" required></td>
        <td><input type="number" name="first_strip_percent[]" value="100" class="form-control first-strip-percent" placeholder="Percent" required></td>
        <td><input type="number" name="first_strip_mv[]" class="form-control first-strip-mv" placeholder="Strip Market Value" readonly></td>
        <td><input type="number" name="area_resid[]" class="form-control area-resid" placeholder="Area" step="any" required></td>
        <td><input type="text" name="market_value_resid[]" class="form-control market-value-resid" placeholder="BMV" step="any" readonly></td>
        <td>
            <button type="button" class="btn btn-sm btn-info add-strip">+</button>
            <button type="button" class="btn btn-danger btn-sm remove-row-non_agricultural">x</button>
        </td>
    </tr>`;
}

function createStripRows(row = {}) {
  return `
    <tr class="strip-row">
        <td colspan="4">
            <strong>Strip 1</strong>
        </td>
 
        <td>
            <label class="small text-muted">
                Area (Strip)
            </label>
            <input
                type="number"
                class="form-control strip-area"
                name="second_strip_area[]"
                value="${row.second_strip_area ?? ""}"
                step="0.01"
                min="0"
            >
        </td>
 
        <td>
            <label class="small text-muted">
                Percent (Strip)
            </label>
            <input
                type="number"
                class="form-control strip-percent"
                name="second_strip_percent[]"
                value="${row.second_strip_percent ?? 80}"
                step="0.01"
                min="0"
                max="100"
            >
        </td>
 
        <td>
            <label class="small text-muted">
                Strip Market Value
            </label>
            <input
                type="number"
                class="form-control strip-market-value"
                name="second_strip_mv[]"
                value="${row.second_strip_mv ?? ""}"
                step="0.01"
                readonly
            >
        </td>
 
        <td></td>
    </tr>
 
    <tr class="strip-row">
        <td colspan="4">
            <strong>Strip 2</strong>
        </td>
 
        <td>
            <label class="small text-muted">
                Area (Strip)
            </label>
            <input
                type="number"
                class="form-control strip-area"
                name="third_strip_area[]"
                value="${row.third_strip_area ?? ""}"
                step="0.01"
                min="0"
            >
        </td>
 
        <td>
            <label class="small text-muted">
                Percent (Strip)
            </label>
            <input
                type="number"
                class="form-control strip-percent"
                name="third_strip_percent[]"
                value="${row.third_strip_percent ?? 60}"
                step="0.01"
                min="0"
                max="100"
            >
        </td>
 
        <td>
            <label class="small text-muted">
                Strip Market Value
            </label>
            <input
                type="number"
                class="form-control strip-market-value"
                name="third_strip_mv[]"
                value="${row.third_strip_mv ?? ""}"
                step="0.01"
                readonly
            >
        </td>
 
        <td></td>
    </tr>
  `;
}

$(document).on("click", ".add-strip", function () {
  const button = $(this);
  const parentRow = button.closest("tr");

  // If strips already exist, remove them
  if (button.hasClass("strip-active")) {
    parentRow.nextAll(".strip-row").remove();

    button
      .removeClass("strip-active btn-warning")
      .addClass("btn-info")
      .text("+");

    calculateNonAgriRow(parentRow);
    return;
  }

  // Create the two fixed strip rows
  const stripRows = createStripRows();

  // Insert both rows after parent row
  parentRow.after(stripRows);

  // Change button to Remove Strip
  button.addClass("strip-active btn-warning").removeClass("btn-info").text("-");
});

function calculateNonAgriRow(parentRow) {
  const unitValue = parseFloat(parentRow.find(".unit-value-resid").val()) || 0;
  const cornerInfluence =
    parseFloat(parentRow.find(".corner-influence").val()) || 0;
  // =====================================
  // FIRST STRIP
  // =====================================
  const firstArea = parseFloat(parentRow.find(".first-strip-area").val()) || 0;

  const firstPercent =
    parseFloat(parentRow.find(".first-strip-percent").val()) || 0;

  let firstMV = 0;

  if (firstArea > 0 && unitValue > 0) {
    firstMV = firstArea * unitValue - unitValue * ((100 - firstPercent) / 100);
  }

  parentRow.find(".first-strip-mv").val(firstMV.toFixed(2));

  // =====================================
  // SECOND STRIP
  // =====================================
  const secondRow = parentRow.next(".strip-row");

  let secondArea = 0;
  let secondMV = 0;

  if (secondRow.length) {
    secondArea = parseFloat(secondRow.find(".strip-area").val()) || 0;

    const secondPercent =
      parseFloat(secondRow.find(".strip-percent").val()) || 0;

    if (secondArea > 0 && unitValue > 0) {
      secondMV =
        secondArea * unitValue - unitValue * ((100 - secondPercent) / 100);
    }

    secondRow.find(".strip-market-value").val(secondMV.toFixed(2));
  }

  // =====================================
  // THIRD STRIP
  // =====================================
  const thirdRow = secondRow.next(".strip-row");

  let thirdArea = 0;
  let thirdMV = 0;

  if (thirdRow.length) {
    thirdArea = parseFloat(thirdRow.find(".strip-area").val()) || 0;

    const thirdPercent = parseFloat(thirdRow.find(".strip-percent").val()) || 0;

    if (thirdArea > 0 && unitValue > 0) {
      thirdMV =
        thirdArea * unitValue - unitValue * ((100 - thirdPercent) / 100);
    }

    thirdRow.find(".strip-market-value").val(thirdMV.toFixed(2));
  }

  // =====================================
  // TOTAL AREA
  // =====================================
  const totalArea = firstArea + secondArea + thirdArea;

  parentRow.find(".area-resid").val(totalArea);

  // =====================================
  // TOTAL MARKET VALUE
  // =====================================
  const totalMarketValue = firstMV + secondMV + thirdMV;
  const cornerDeduction = totalMarketValue * (cornerInfluence / 100);
  const finalMV = totalMarketValue - cornerDeduction;

  parentRow.find(".market-value-resid").val(finalMV.toFixed(2));

  recalculateNonAgri();
}

$(document).on(
  "input",
  ".unit-value-resid, .first-strip-area, .first-strip-percent, .strip-area, .strip-percent, .corner-influence",
  function () {
    const row = $(this).closest("tr");

    // If input is inside a strip row,
    // find the original/main row.
    let parentRow;

    if (row.hasClass("strip-row")) {
      parentRow = row.prevAll("tr:not(.strip-row)").first();
    } else {
      parentRow = row;
    }

    calculateNonAgriRow(parentRow);
  },
);

function recalculateNonAgri() {
  let totalArea = 0;
  let totalBMV = 0;

  $("#non_agricultural-table tbody tr:not(.strip-row)").each(function () {
    const area = parseFloat($(this).find(".area-resid").val()) || 0;
    const marketValue =
      parseFloat($(this).find(".market-value-resid").val()) || 0;

    totalArea += area;
    totalBMV += marketValue;
  });

  $("#total-area-non_agricultural").text(totalArea);
  $("#total-bmv-non_agricultural").text(totalBMV.toFixed(2));
}

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
  let totalBMWResid = parseFloat($("#total-bmv-non_agricultural").text()) || 0;

  // This will automatically collect all fields including arrays
  let formData = $(this).serialize();
  formData += "&property_ID=" + encodeURIComponent(land_property_ID);
  formData += "&total_non_agri_area=" + encodeURIComponent(totalAreaResid);
  formData += "&total_non_agri_mv=" + encodeURIComponent(totalBMWResid);

  $.ajax({
    url: "ajax.php?action=save_non_agri",

    type: "POST",

    data: formData,

    dataType: "json",

    success: function (response) {
      console.log(response);

      if (response.success) {
        alert(response.message);
        // Disable all inputs so the inserted values remain visible
        $("#non_agricultural-table tbody select").prop("disabled", true);
        $("#non_agricultural-table tbody input").prop("disabled", true);

        // FIX #5: this selector was ".remove-row" but the buttons use
        // class "remove-row-non_agricultural" — it never matched anything.
        $("#non_agricultural-table tbody .remove-row-non_agricultural").prop(
          "disabled",
          true,
        );

        // Disable Add button
        $("#add-row-non_agricultural").prop("disabled", true);

        // Disable Save button
        $("#save-non_agricultural").prop("disabled", true);
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

function getAdjustmentFactors(kind) {
  let prefix = "";

  switch (kind) {
    case "Residential":
      prefix = "R";
      break;

    case "Commercial":
      prefix = "C";
      break;

    case "Industrial":
      prefix = "I";
      break;

    default:
      return `<option value="">Select Class</option>`;
  }

  let options = `<option value="">Select Class</option>`;

  for (let i = 1; i <= 5; i++) {
    options += `<option value="${i}">${prefix}-${i}</option>`;
  }

  return options;
}

// Change Kind
$(document).on("change", ".kind", function () {
  const kind = $(this).val();
  const row = $(this).closest("tr");

  const adjustmentFactor = row.find(".adjustment-factor");
  const unitValueInput = row.find(".unit-value-resid");

  // Load R-1 to R-5, C-1 to C-5, or I-1 to I-5
  adjustmentFactor.html(getAdjustmentFactors(kind));

  // Reset Unit Value
  unitValueInput.val("");
});

// Change Class
$(document).on("change", ".adjustment-factor", function () {
  const selectedClass = $(this).val();
  const row = $(this).closest("tr");

  const kind = row.find(".kind").val();
  const unitValueInput = row.find(".unit-value-resid");

  // Nothing selected
  if (!selectedClass || !kind) {
    unitValueInput.val("");
    return;
  }

  $.ajax({
    url: "get_non_agri_kind_value.php",
    type: "GET",
    dataType: "json",

    data: {
      mun_code: sess_mun_code,
      kind: kind,
      class: selectedClass,
    },

    success: function (res) {
      if (res.success && res.data) {
        unitValueInput.val(res.data.unit_value);
      } else {
        unitValueInput.val("");

        console.warn(res.message);
      }

      calculateNonAgriRow(row);
    },

    error: function (xhr, status, error) {
      alert("AJAX ERROR!");

      console.error("Status:", status);
      console.error("Error:", error);
      console.error("Response:", xhr.responseText);

      unitValueInput.val("");
    },
  });
});
