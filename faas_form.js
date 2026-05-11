$(document).ready(function () {
  let input_old_property_ID = $('input[name="input_old_property_ID"]').val();
  let input_new_property_ID = $('input[name="input_new_property_ID"]').val();

  getProperty(input_old_property_ID, input_new_property_ID);

  function getProperty(input_old_property_ID, input_new_property_ID) {
    if (input_old_property_ID || input_new_property_ID) {
      $.ajax({
        url: "ajax.php?action=get_property_revised",
        type: "GET",
        data: {
          old_property_ID: input_old_property_ID,
          new_property_ID: input_new_property_ID,
        },
        dataType: "json",
        success: function (data) {
          if (data.error) {
            alert(data.error);
            return;
          }

          $('input[name="input_new_property_ID"]').val($.trim(data.FAAS_ID));
          // alert(data.FAAS_ID);
          loadLandRows(data.FAAS_ID);
          loadResidentialRows(data.FAAS_ID);
          loadAssessmentRows(data.FAAS_ID);
          $("#search_pin").prop("disabled", true);
          $("#mun_code").prop("disabled", true);
          $("#search_pin").val(data.previous_pin);
          $("#mun_code").val(data.property_municipality);
          $('input[name="PIN_no"]').val($.trim(data.PIN_no));
          $('input[name="revision_code"]').val($.trim(data.revision_code));
          $('input[name="BLK"]').val($.trim(data.BLK));
          $('input[name="title_type"]').val($.trim(data.title_type));
          $('input[name="lot_no"]').val($.trim(data.lot_no));
          $('input[name="survey"]').val($.trim(data.survey));
          $('input[name="owner_name"]').val($.trim(data.owner_name));
          $('input[name="owner_address"]').val($.trim(data.owner_address));
          $('input[name="owner_no"]').val($.trim(data.owner_no));
          $('input[name="owner_tin"]').val($.trim(data.owner_tin));
          $('input[name="admin_name"]').val($.trim(data.admin_name));
          $('input[name="admin_address"]').val($.trim(data.admin_address));
          $('input[name="admin_no"]').val($.trim(data.admin_no));
          $('input[name="admin_tin"]').val($.trim(data.admin_tin));
          $('input[name="property_brgy"]').val($.trim(data.property_brgy));
          $("#property_municipality").val($.trim(data.property_municipality));
          $('input[name="northern"]').val($.trim(data.northern));
          $('input[name="eastern"]').val($.trim(data.eastern));
          $('input[name="southern"]').val($.trim(data.southern));
          $('input[name="western"]').val($.trim(data.western));
          $('input[name="previous_pin"]').val($.trim(data.previous_pin));
          $('input[name="previous_td_no"]').val($.trim(data.previous_td_no));
          $('input[name="previous_assessed_value"]').val(
            $.trim(data.previous_assessed_value),
          );
          // $('input[name="mvbmv"]').val(50000);
          $('input[name="previous_ARP_no"]').val($.trim(data.previous_ARP_no));
          $('input[name="previous_owner"]').val($.trim(data.owner_name));
          $('input[name="previous_effectivity"]').val(
            $.trim(data.previous_effectivity),
          );
          $('input[name="street_no"]').val($.trim(data.street_no));

          setSelectValue($('select[name="north"]'), $.trim(data.north));
          setSelectValue($('select[name="east"]'), $.trim(data.east));
          setSelectValue($('select[name="west"]'), $.trim(data.west));
          setSelectValue($('select[name="south"]'), $.trim(data.south));

          // $('input[name="market_value"]').val($.trim(data.total_market_value));
          // $('input[name="mvbmv"]').val($.trim(data.total_land_mv));
          $("#total-bmv").text(data.total_land_mv);
          $("#total-area").text(data.total_land_area);
          $("#total-bmv-residential").text(data.total_residential_mv);
          $("#total-area-residential").text(data.total_residential_area);
          $("#mvbmv").val(data.total_land_mv);
          $("#market_value").val(data.total_market_value);
          $("#factor_first").val(data.factor_first);
          $("#factor_second").val(data.factor_second);
          $("#factor_third").val(data.factor_third);
          $("#percentage_first").val(data.percent_first);
          $("#percentage_second").val(data.percent_second);
          $("#percentage_third").val(data.percent_third);
          $("#percent_total").val(data.percent_total);
          $("#value_adjustment").val(data.total_adjustment);
          // alert($("#input_new_property_ID").val());
        },
      });
    }
  }

  // loadLandRows(land_property_ID);
  function createFilledRow(row) {
    return `
    <tr>
        <td>
            <select class="form-control classification" name="classification[]" required>
                ${municipalityOptions.replace(
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
  function loadLandRows(land_property_ID) {
    $.ajax({
      url: "php/fetch/fetch_land.php",
      type: "POST", // <-- change to POST
      data: { land_property_ID: land_property_ID }, // <-- send the ID
      dataType: "json",
      success: function (data) {
        $("#classification-table tbody").empty();

        data.forEach(function (row) {
          $("#classification-table tbody").append(createFilledRow(row));
        });
      },
    });
  }

  function loadResidentialRows(land_property_ID) {
    $.ajax({
      url: "php/fetch/fetch_resid.php",
      type: "POST", // <-- change to POST
      data: { land_property_ID: land_property_ID }, // <-- send the ID
      dataType: "json",
      success: function (data) {
        $("#residential-table tbody").empty();

        data.forEach(function (row) {
          $("#residential-table tbody").append(createFilledRowResidential(row));
        });
      },
    });
  }

  function createFilledRowResidential(row) {
    return `
    <tr>
       <td>
            <select class="form-control kind" name="kind[]" required>
                ${non_agri_options.replace(
                  `value="${row.kind}"`,
                  `value="${row.kind}" selected`,
                )}
            </select>
        </td>

        <td><input type="number" name="area_resid[]" class="form-control area-resid" value="${
          row.area_resid
        }" step="any" required></td>

        <td><input type="number" name="unit_value_resid[]" class="form-control unit-value-resid" value="${
          row.unit_value_resid
        }" step="any" required></td>

        <td><input type="text" name="adjustment_factor[]" class="form-control adjustment-factor" value="${
          row.adjustment_factor
        }" required></td>

        <td><input type="text" name="market_value_resid[]" class="form-control market-value-resid" value="${
          row.market_value_resid
        }" step="any" readonly></td>

        <td><button class="btn btn-danger btn-sm remove-row-residential">Remove</button></td>
    </tr>`;
  }

  function loadAssessmentRows(land_property_ID) {
    $.ajax({
      url: "php/fetch/fetch_assessment.php",
      type: "POST", // <-- change to POST
      data: { land_property_ID: land_property_ID }, // <-- send the ID
      dataType: "json",
      success: function (data) {
        $("#assessment-table tbody").empty();

        data.forEach(function (row) {
          $("#assessment-table tbody").append(createFilledRowAssessment(row));
        });
      },
    });
  }

  function createFilledRowAssessment(row) {
    return `
    <tr>
        <td>
            <select class="form-control actual_use" name="actual_use[]" required>
                ${au_options.replace(
                  `value="${row.actual_use}"`,
                  `value="${row.actual_use}" selected`,
                )}
            </select>
        </td>
        <td>
            <select class="form-control sub_class" name="taxable[]" required>
                <option value="">-- Select Sub --</option>
                <option value="TAXABLE" ${
                  row.taxable == "TAXABLE" ? "selected" : ""
                }>TAXABLE</option>
                <option value="EXEMPT" ${
                  row.taxable == "EXEMPT" ? "selected" : ""
                }>EXEMPT</option>
            </select>
        </td>
        <td><input type="number" name="market_value_assessed[]" class="form-control area" value="${
          row.market_value_assessed
        }" step="any" required></td>
        <td><input type="number" name="assessed_level[]" class="form-control unit-value" value="${
          row.assessed_level
        }" required></td>
        <td><input type="text" name="assessed_value[]" class="form-control bmv" value="${
          row.assessed_value
        }" readonly></td>
        <td><button class="btn btn-danger btn-sm remove-row-assessment">Remove</button></td>
    </tr>`;
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

  $("#mun_code").on("change", function () {
    $("#property_municipality").val($(this).val());
  });
  $("#property_municipality").on("change", function () {
    $("#mun_code").val($(this).val());
  });

  // Collapse sections
  // $(
  //   "#prop_info_section, #prop-loc-section, #general-description-section, #structural-material-section, #rec-seded-section,  #residential-section, #market-value-section"
  // ).collapse("hide");

  // Save form
  $("#faasSaveBtn").on("click", function (e) {
    e.preventDefault();

    let form = $(this).closest("form")[0];

    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    $.ajax({
      url: "ajax.php?action=insert_property",
      type: "POST",
      data: $(form).serialize(),
      dataType: "json",
      success: function (res) {
        if (res.success) {
          let modalEl = document.getElementById("form_success_saved");
          let modal = new bootstrap.Modal(modalEl);

          // Reset states
          $("#loadingState").show();
          $("#successState").hide();

          modal.show();

          $("#faasSaveBtn").prop("disabled", true);

          // Simulate slight delay for better UX (optional)
          setTimeout(() => {
            // Switch to success UI
            $("#loadingState").hide();
            $("#successState").show();
            $("#successMessage").text(res.message);

            // Redirect after 1.5 seconds
            setTimeout(() => {
              window.location.href = "index.php?page=land";
            }, 500);
          }, 1000);
        } else {
          alert("❌ " + res.message + "\n" + (res.error ?? ""));
        }
      },
      error: function (xhr) {
        console.log(xhr.responseText);
        alert("Server Error: " + xhr.status);
      },
    });
  });

  // Fetch property
  $("#searchPinBtn").click(function () {
    const pin = $("#search_pin").val();
    const mun_code = $("#mun_code").val();

    localStorage.setItem("pin_code", pin);
    localStorage.setItem("mun_code", mun_code);

    if (!pin) {
      alert("Please enter a PIN No");
      return;
    }
    if (!mun_code) {
      alert("Please enter a Municipality Code");
      return;
    }

    $.ajax({
      url: "ajax.php?action=get_property_previous",
      type: "GET",
      data: { search_pin: pin, mun_code: mun_code },
      dataType: "json",
      success: function (data) {
        if (data.error) {
          alert("Error: " + data.error);
        } else {
          const getpin = localStorage.getItem("pin_code");
          const get_code = localStorage.getItem("mun_code");

          $('input[name="PIN_no"]').val(data.previous_pin);
          $('input[name="BLK"]').val(data.BLK);
          $('input[name="title_type"]').val(data.title_type);
          $('input[name="lot_no"]').val(data.lot_no);
          $('input[name="survey"]').val(data.survey);
          $('input[name="owner_name"]').val(data.owner_name);
          $('input[name="owner_address"]').val(data.owner_address);
          $('input[name="owner_no"]').val(data.owner_no);
          $('input[name="owner_tin"]').val(data.owner_tin);
          $('input[name="admin_name"]').val(data.admin_name);
          $('input[name="admin_address"]').val(data.admin_address);
          $('input[name="admin_no"]').val(data.admin_no);
          $('input[name="admin_tin"]').val(data.admin_tin);
          $('input[name="property_brgy"]').val(data.property_brgy);
          $('input[name="property_municipality"]').val(
            data.property_municipality,
          );
          $('input[name="northern"]').val(data.northern);
          $('input[name="eastern"]').val(data.eastern);
          $('input[name="southern"]').val(data.southern);
          $('input[name="western"]').val(data.western);
          $('input[name="previous_pin"]').val(data.previous_pin);
          $('input[name="previous_td_no"]').val(data.previous_td_no);
          $('input[name="previous_assessed_value"]').val(
            data.previous_assessed_value,
          );
          $('input[name="previous_ARP_no"]').val(data.previous_ARP_no);
          $('input[name="previous_owner"]').val(data.owner_name);
          $('input[name="previous_effectivity"]').val(
            data.previous_effectivity,
          );
          $('input[name="street_no"]').val(data.street_no);
          $('input[name="property_ID"]').val(data.property_ID);

          setSelectValue($('select[name="north"]'), data.north);
          setSelectValue($('select[name="east"]'), data.east);
          setSelectValue($('select[name="west"]'), data.west);
          setSelectValue($('select[name="south"]'), data.south);
        }
      },
      error: function (xhr, status, error) {
        alert("AJAX error: " + error);
      },
    });
  });
});

// Helpers
function setSelectValue($select, value) {
  if ($select.find(`option[value="${value}"]`).length === 0) {
    $select.append(new Option(value, value, true, true));
  } else {
    $select.val(value);
  }
}
