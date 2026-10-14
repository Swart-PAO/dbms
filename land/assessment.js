$(document).ready(function () {
  $("#assessment-table-update").on(
    "click",
    ".remove-row-assessment-update",
    function () {
      $(this).closest("tr").remove();
      recalculateAssessmentUpdate();
    },
  );
  $("#assessment-table-update").on(
    "input",
    ".area, .unit-value, .actual_use",
    function () {
      recalculateAssessmentUpdate();
    },
  );

  function recalculateAssessmentUpdate() {
    let totalAssessedValue = 0;
    let totalBMV = 0;

    $("#assessment-table-update tbody tr").each(function () {
      const area = parseFloat($(this).find(".area").val()) || 0;
      const unitValue = parseFloat($(this).find(".unit-value").val()) || 0;
      const baseMarketValue = area * (unitValue / 100);

      $(this).find(".bmv").val(baseMarketValue);

      totalBMV += area;
      totalAssessedValue += baseMarketValue;
    });

    $("#total-assessed-value").text(totalAssessedValue);
    $("#total-bmv-assessment").text(totalBMV);
    return {
      totalAssessedValue: totalAssessedValue,
      totalBMV: totalBMV,
    };
  }

  $("#assessment-form-update").on("submit", function (e) {
    e.preventDefault();

    const rowCount = $("#assessment-table-update tbody tr").length;

    if (rowCount < 1) {
      alert("Please add at least one assessment row before saving.");
      return;
    }

    const property_ID = $("#input_property_ID").val();

    if (!property_ID) {
      alert("Property ID is missing.");
      return;
    }

    // Make sure assessed values are current
    // recalculateAssessmentUpdate();

    const assessmentTotals = recalculateAssessmentUpdate();

    const totalMarketValue = assessmentTotals.totalBMV || 0;
    const totalAssessedValue = assessmentTotals.totalAssessedValue || 0;

    // alert(
    //   `Submitting assessment update for property ID: ${property_ID}\nTotal Market Value: ${totalMarketValue}\nTotal Assessed Value: ${totalAssessedValue}`,
    // );

    let formData = $(this).serialize();

    formData += "&property_ID=" + encodeURIComponent(property_ID);

    formData += "&total_assessment_mv=" + encodeURIComponent(totalMarketValue);

    formData +=
      "&total_assessed_value=" + encodeURIComponent(totalAssessedValue);

    $.ajax({
      url: BASE_URL + "/php/update_assessment.php",

      type: "POST",

      data: formData,

      success: function (response) {
        // console.log("Update response:", response);

        $("#save-assessment-update").prop("disabled", true);

        $("#add-row-assessment-update").prop("disabled", true);
        location.href =
          "./../faas.php?property_ID=" + encodeURIComponent(property_ID);
      },

      error: function (xhr, status, error) {
        console.error("Update Error:");
        console.error(xhr.responseText);

        alert("Error updating assessment:\n\n" + xhr.responseText);
      },
    });
  });
});

function loadAssessmentUpdate(land_property_ID) {
  $.ajax({
    url: BASE_URL + "/php/fetch_assessment_update.php",
    type: "POST",
    data: {
      land_property_ID: land_property_ID,
    },
    dataType: "json",

    success: function (data) {
      console.log("Assessment Update Data:", data);

      const tbody = $("#assessment-table-update tbody");

      tbody.empty();

      if (!data.success) {
        alert(data.message || "Failed to load assessment data.");
        return;
      }

      /*
            |--------------------------------------------------------------------------
            | AGRICULTURAL - ONLY 1 ROW
            |--------------------------------------------------------------------------
            */
      if (data.agricultural && data.agricultural.market_value !== null) {
        const agriculturalRow = {
          assessment_ID: data.agricultural.summary_id ?? "",
          kind: data.agricultural.kind ?? "Agricultural",
          actual_use: data.agricultural.actual_use ?? "",
          taxable: data.agricultural.taxable ?? "",
          market_value_assessed: data.agricultural.market_value ?? "",
          assessed_level: data.agricultural.assessment_level ?? "",
          assessed_value: data.agricultural.assessed_value ?? "",
        };

        tbody.append(filledAssessmentUpdate(agriculturalRow));
      }

      /*
            |--------------------------------------------------------------------------
            | NON-AGRICULTURAL - MULTIPLE ROWS
            |--------------------------------------------------------------------------
            */
      if (Array.isArray(data.non_agricultural)) {
        data.non_agricultural.forEach(function (item) {
          const nonAgriculturalRow = {
            assessment_ID: item.non_agri_ID ?? "",
            kind: item.kind ?? "",
            actual_use: item.actual_use ?? "AC",
            taxable: item.taxable ?? "",
            market_value_assessed: item.market_value ?? "",
            assessed_level: item.assessment_level ?? "",
            assessed_value: item.assessed_value ?? "",
          };

          tbody.append(filledAssessmentUpdate(nonAgriculturalRow));
        });
      }

      /*
            |--------------------------------------------------------------------------
            | RECALCULATE AFTER LOADING
            |--------------------------------------------------------------------------
            */
      recalculateAssessmentUpdate();
    },

    error: function (xhr, status, error) {
      console.error("Assessment Update AJAX Error:");
      console.error("Status:", status);
      console.error("Error:", error);
      console.error("Response:", xhr.responseText);

      alert("Failed to load assessment data.\n\n" + xhr.responseText);
    },
  });
}

function filledAssessmentUpdate(row) {
  const html = `
    <tr>
    
    <td>        <input
            type="hidden"

            name="assessment_ID[]"
            value="${row.assessment_ID ?? ""}"
        >
            <select class="form-control kind" name="kind[]" id="kind" required>
                ${non_agri_options.replace(
                  `value="${row.kind}"`,
                  `value="${row.kind}" selected`,
                )}
            </select>
        </td>  

        <td>
            <select class="form-control actual_use" name="actual_use[]" required>
                ${au_options.replace(
                  `value="${row.actual_use}"`,
                  `value="${row.actual_use}" selected`,
                )}
            </select>
        </td>

        <td>
            <select class="form-control taxable"
                    name="taxable[]"
                    required>

                <option value="">-- Select Sub --</option>

                <option value="TAXABLE">
                    TAXABLE
                </option>

                <option value="EXEMPT">
                    EXEMPT
                </option>

            </select>
        </td>

        <td>
    <input
        type="number"
        name="market_value_assessed[]"
        class="form-control area"
        value="${
          row.market_value_assessed != null
            ? Math.round(row.market_value_assessed / 10) * 10
            : ""
        }"
        placeholder="Market Value"
        
        required
    >
</td>

        <td>
            <input
                type="number"
                name="assessed_level[]"
                class="form-control unit-value"
                value="${row.assessed_level ?? ""}"
                placeholder="Assessment Level (%)"
        
                required
            >
        </td>

        <td>
            <input
                type="text"
                name="assessed_value[]"
                class="form-control bmv"
                value="${row.assessed_value ?? ""}"
                placeholder="Assessed Value"
                readonly
            >
        </td>
    </tr>`;

  const newRow = $(html);

  // Set Actual Use
  newRow.find(".actual_use").val(row.actual_use ?? "");

  // Set Taxable
  newRow.find(".taxable").val(row.taxable ?? "");

  return newRow;
}

$(document).on("change", ".actual_use", function () {
  const selectedOption = $(this).find("option:selected");
  const taxability = selectedOption.data("taxability");
  const assessmentLevel = selectedOption.data("assessment_lvl");

  const row = $(this).closest("tr");
  // Fill taxable dropdown
  row.find(".taxable").val(taxability || "");

  // Fill assessed_value input
  row.find(".unit-value").val(assessmentLevel || "");
});
