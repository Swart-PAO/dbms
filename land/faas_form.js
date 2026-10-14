$(document).ready(function () {
  const property_ID = $.trim($("#input_property_ID").val());
  const mode = $("#mode").val();

  const allowedModes = ["gr", "old", "new"];

  if (!allowedModes.includes(mode)) {
    alert("Invalid property mode.");
    return;
  }

  const municipality = String(sess_mun_code).padStart(2, "0");
  const barangay = String(sess_brgy_code).padStart(4, "0");

  $("#pin_prefix").text("040-" + municipality + "-" + barangay + "-");

  if (mode === "new") {
    $("#revision_code").val("New");
    $("#property_municipality").val(sess_mun_code);

    get_barangay_faas_form(sess_mun_code, sess_brgy);
  } else if (property_ID && mode) {
    getProperty(property_ID, mode);
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

          loadAgri(data.property_ID);
          loadNonAgri(data.property_ID);

          loadAssessmentUpdate(data.property_ID);
          $("#search_pin").prop("disabled", true);
          $("#mun_code").prop("disabled", true);
          $("#search_pin").val(data.previous_pin);
          $("#mun_code").val(data.property_municipality);

          fields.forEach((field) => {
            $("#" + field).val($.trim(data[field] ?? ""));
          });

          $("#previous_owner").val($.trim(data.owner_name));

          ["north", "east", "west", "south"].forEach((field) => {
            setSelectValue($("#" + field), $.trim(data[field] ?? ""));
          });

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
          $("#factor_third").val(data.factor_third);
          $("#percentage_first").val(data.percent_first);
          $("#percentage_second").val(data.percent_second);
          $("#percentage_third").val(data.percent_third);
          $("#percent_total").val(data.percent_total);
          $("#value_adjustment").val(data.total_adjustment);
          $("#memoranda").val(data.memoranda);
          // alert($("#input_new_property_ID").val());
        },
        error: function (xhr, status, error) {
          console.error("get_property_revised failed:", {
            status: xhr.status,
            statusText: xhr.statusText,
            error: error,
            response: xhr.responseText,
          });

          if (xhr.status === 401) {
            alert("Your session has expired. Please log in again.");
          } else if (xhr.status === 403) {
            alert("You are not authorized to access this property.");
          } else if (xhr.status === 404) {
            alert("Property not found.");
          } else {
            alert("Unable to retrieve property.");
          }
        },
      });
    } else {
      alert("No property ID or mode provided. Redirecting to land page.");
      location.href = BASE_URL + "/index.php?page=land";
    }
  }

  $("#mun_code").on("change", function () {
    $("#property_municipality").val($(this).val());
  });

  let isSaving = false;
  let savingInterval = null;

  $("#faasSaveBtn").on("click", function (e) {
    e.preventDefault();

    // Prevent multiple submissions
    if (isSaving) {
      return;
    }

    let form = $(this).closest("form")[0];

    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    const $btn = $(this);

    // Lock immediately
    isSaving = true;
    $btn.prop("disabled", true);

    // Animate "Saving..."
    let dots = 0;

    savingInterval = setInterval(function () {
      dots = (dots + 1) % 4;

      $btn.text("Saving" + ".".repeat(dots));
    }, 400);

    // Show initial state immediately
    $btn.text("Saving");

    $.ajax({
      url: "ajax.php?action=save_property",
      type: "POST",
      data: $(form).serialize(),
      dataType: "json",

      success: function (res) {
        if (res.success) {
          // Stop Saving... animation
          clearInterval(savingInterval);

          $btn.text("Saved ✓");

          let modalEl = document.getElementById("form_success_saved");
          let modal = new bootstrap.Modal(modalEl);

          $("#loadingState").show();
          $("#successState").hide();

          modal.show();

          setTimeout(() => {
            $("#loadingState").hide();
            $("#successState").show();

            $("#successMessage").text(res.message);

            setTimeout(() => {
              if (res.mode === "gr") {
                window.location.href =
                  "faas_form.php?property_ID=" +
                  encodeURIComponent(res.record_id) +
                  "&mode=gr";
              } else {
                location.reload();
              }
            }, 500);
          }, 1000);
        } else {
          // Saving failed — allow user to try again
          clearInterval(savingInterval);

          isSaving = false;

          $btn.prop("disabled", false);
          $btn.text("Save");

          alert("❌ " + res.message + "\n" + (res.error ?? ""));
        }
      },

      error: function (xhr) {
        console.log(xhr.responseText);

        // Stop animation
        clearInterval(savingInterval);

        // Allow retry
        isSaving = false;

        $btn.prop("disabled", false);
        $btn.text("Save");

        alert("Server Error: " + xhr.status);
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
