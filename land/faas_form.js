$(document).ready(function () {
  const property_ID = $("#input_property_ID").val();
  const mode = $("#mode").val();

  const municipality = String(sess_mun_code).padStart(2, "0");
  const barangay = String(sess_brgy_code).padStart(4, "0");

  $("#pin_prefix").text("040-" + municipality + "-" + barangay + "-");

  if (property_ID && mode) {
    getProperty(property_ID, mode);
  } else if (mode === "new") {
    $("#property_municipality").val(sess_mun_code);
    // const mun_code = String(sess_mun_code).padStart(2, "0");
    $("#revision_code").val("New");
    // alert(mun_code);
    // const barangay = String(data.brgy_code).padStart(4, "0");

    // $("#pin_prefix").text("040-" + mun_code + "-" + sess_brgy_code + "-");

    get_barangay_faas_form(mun_code, sess_brgy);
  } else {
    alert("No property ID or mode provided. Redirecting to land page.");
    location.href = BASE_URL + "/index.php?page=land";
  }

  function getProperty(property_ID, mode) {
    if (property_ID && mode) {
      $.ajax({
        url: "ajax.php?action=get_property_revised",
        type: "GET",
        data: {
          property_ID: property_ID,
          mode: mode,
        },
        dataType: "json",
        success: function (data) {
          if (data.error) {
            alert(data.error);
            return;
          }

          $("#property_municipality").val(data.property_municipality);

          get_barangay_faas_form(
            data.property_municipality,
            data.property_brgy,
          );

          const fields = [
            "PIN_no",
            "revision_code",
            "BLK",
            "title_type",
            "lot_no",
            "survey",
            "owner_name",
            "owner_address",
            "owner_no",
            "owner_tin",
            "admin_name",
            "admin_address",
            "admin_no",
            "admin_tin",
            "property_municipality",
            "property_brgy",

            "northern",
            "eastern",
            "southern",
            "western",
            "previous_pin",
            "previous_td_no",
            "previous_assessed_value",
            "previous_ARP_no",
            "previous_effectivity",
            "street_no",
          ];

          // $('input[name="input_property_ID"]').val($.trim(data.property_ID));
          // alert(data.FAAS_ID);
          loadAgri(data.property_ID);
          loadNonAgri(data.property_ID);
          loadAssessment(data.property_ID);
          $("#search_pin").prop("disabled", true);
          $("#mun_code").prop("disabled", true);
          $("#search_pin").val(data.previous_pin);
          $("#mun_code").val(data.property_municipality);

          $("#previous_owner").val($.trim(data.owner_name));

          setSelectValue($("#north"), $.trim(data.north));
          setSelectValue($("#east"), $.trim(data.east));
          setSelectValue($("#west"), $.trim(data.west));
          setSelectValue($("#south"), $.trim(data.south));

          // $('input[name="market_value"]').val($.trim(data.total_market_value));
          // $('input[name="mvbmv"]').val($.trim(data.total_land_mv));
          $("#total-bmv-agri").text(data.total_land_mv);
          $("#total-area").text(data.total_land_area);
          $("#total-bmv-non_agricultural").text(data.total_non_agri_mv);
          $("#total-area-non_agricultural").text(data.total_non_agri_area);
          $("#mvbmv").val(data.total_land_mv);
          $("#market_value").val(data.total_market_value);
          $("#total-bmv-assessment").text(data.total_assessment_mv);
          $("#total-assessed-value").text(data.total_assessed_value);
          $("#factor_first").val(data.factor_first);
          $("#factor_second").val(data.factor_second);
          // $("#factor_third").val(data.factor_third);
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

  function loadNonAgri(land_property_ID) {
    $.ajax({
      url: BASE_URL + "/php/fetch_resid.php",
      type: "POST", // <-- change to POST
      data: { land_property_ID: land_property_ID }, // <-- send the ID
      dataType: "json",
      success: function (data) {
        $("#non_agricultural-table tbody").empty();

        data.forEach(function (row) {
          $("#non_agricultural-table tbody").append(filledNonAgri(row));
        });
      },
    });
  }

  function filledNonAgri(row) {
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

        <td><button class="btn btn-danger btn-sm remove-row-non_agricultural">Remove</button></td>
    </tr>`;
  }

  function loadAssessment(land_property_ID) {
    $.ajax({
      url: BASE_URL + "/php/fetch/fetch_assessment.php",
      type: "POST", // <-- change to POST
      data: { land_property_ID: land_property_ID }, // <-- send the ID
      dataType: "json",
      success: function (data) {
        $("#assessment-table tbody").empty();

        data.forEach(function (row) {
          $("#assessment-table tbody").append(filledAssessment(row));
        });
      },
    });
  }

  function filledAssessment(row) {
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
  //   "#prop_info_section, #prop-loc-section, #general-description-section, #structural-material-section, #rec-seded-section,  #non_agricultural-section, #market-value-section"
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
      url: "ajax.php?action=save_property",
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
              window.location.href = BASE_URL + "/index.php?page=land";
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
  $("#property_municipality").change(function () {
    var mun_code = $(this).val();
    get_barangay_faas_form(mun_code);
  });

  function get_barangay_faas_form(mun_code, selected_brgy = "") {
    if (mun_code !== "") {
      $.ajax({
        url: BASE_URL + "/php/get_barangay.php",
        type: "POST",
        data: {
          mun_code: mun_code,
        },
        success: function (data) {
          $("#property_brgy").html(data);

          if (selected_brgy) {
            $("#property_brgy").val(selected_brgy);
          }
        },
      });
    }
  }
});

// Helpers
function setSelectValue($select, value) {
  if ($select.find(`option[value="${value}"]`).length === 0) {
    $select.append(new Option(value, value, true, true));
  } else {
    $select.val(value);
  }
}
