// $building_id = $('#building_id').val();
$building_id = $("#input_property_ID").val();
$mode = $("#input_property_ID").val();
// getProperty($building_id);
// alert("Data fetched successfully!");

if ($building_id && $mode) {
  getBuildingInfo($building_id, $mode);
  loadStructural($building_id);
} else if ((mode = "new")) {
  $("#municipality").val(sess_mun_code);
  const mun_code = String(sess_mun_code).padStart(2, "0");
  $("#revision_code").val("New");
  // alert(mun_code);
  // const barangay = String(data.brgy_code).padStart(4, "0");

  $("#pin_prefix").text("040-" + mun_code + "-" + sess_brgy + "-");

  get_barangay_faas_form(mun_code, sess_brgy);
}

function getBuildingInfo(building_id, mode) {
  $.ajax({
    url: "ajax.php?action=get_building_info",
    type: "GET",
    data: {
      building_id: building_id,
      mode: mode,
    },
    dataType: "json",
    success: function (data) {
      if (data.error) {
        alert(data.error);
        return;
      }

      $.each(data, function (key, value) {
        if (typeof value === "string") {
          value = value.trim();
          data[key] = value;
        }

        $("#" + key).val(value);
      });
      // $("#municipality").val(data.municipality);

      get_barangay_faas_form(data.municipality, data.baranggay);
      const municipality = String(data.municipality).padStart(2, "0");
      const baranggay = String(data.baranggay).padStart(4, "0");

      $("#pin_prefix").text("040-" + municipality + "-" + baranggay);

      // alert($("#input_new_property_ID").val());
    },
    error: function (xhr) {
      console.log(xhr.responseText);
      alert("Server Error: " + xhr.status);
    },
  });
}

function loadStructural(building_id) {
  $.ajax({
    url: "ajax.php?action=get_structural_materials",
    type: "GET",
    data: {
      building_id: building_id,
    },
    dataType: "json",
    success: function (res) {
      if (!res.success || !res.data) return;

      let d = res.data;

      // helper
      function checkValues(values, name) {
        if (!values) return;

        let arr = values.split(",").map((v) => v.trim());

        arr.forEach((val) => {
          $(`input[name="${name}[]"][value="${val}"]`).prop("checked", true);
        });
      }

      // -------------------
      // ROOF
      // -------------------
      checkValues(d.roof, "roof");

      // -------------------
      // FLOORS
      // -------------------
      checkValues(d.first_floor_flooring, "floor1");
      checkValues(d.second_floor_flooring, "floor2");
      checkValues(d.third_floor_flooring, "floor3");
      checkValues(d.fourth_floor_flooring, "floor4");

      checkValues(d.first_floor_wall, "floor1");
      checkValues(d.second_floor_wall, "floor2");
      checkValues(d.third_floor_wall, "floor3");
      checkValues(d.fourth_floor_wall, "floor4");
    },
    error: function (xhr) {
      console.error(xhr.responseText);
    },
  });
}

$("#building_desc_save_btn").on("click", function (e) {
  e.preventDefault();

  let form = $(this).closest("form")[0];

  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }

  $.ajax({
    url: "ajax.php?action=save_building_desc",
    type: "POST",
    data: $(form).serialize(),
    dataType: "json",
    success: function (res) {
      // alert("Saving... Please wait.");
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
            $("#building_id").val(res.building_id); // Set the building_id for future updates

            // window.location.href = "building_form.php";
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

$("#structural_materials_btn").on("click", function (e) {
  e.preventDefault();

  let form = $(this).closest("form")[0];

  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }

  // 👉 get building_id from another form/input
  let building_id = $("#input_property_ID").val();
  alert("Building ID: " + building_id);
  // OR: let building_id = $("#other_form input[name='building_id']").val();

  let formData = $(form).serializeArray();

  // append building_id
  formData.push({
    name: "building_id",
    value: building_id,
  });
  $.ajax({
    url: "ajax.php?action=save_structural_materials",
    type: "POST",
    data: $.param(formData), // convert to query string
    dataType: "json",
    success: function (res) {
      // alert("Saving... Please wait.");
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
            window.location.href = "building_form.php";
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

$("#municipality").change(function () {
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
        $("#baranggay").html(data);

        if (selected_brgy) {
          $("#baranggay").val(selected_brgy);
        }
      },
    });
  }
}

// --- YOUR ORIGINAL NAVIGATION LOGIC ---
function navigateTo(stepId) {
  // 1. Hide all form sections
  const sections = document.querySelectorAll(".form-step");
  sections.forEach((s) => s.classList.add("d-none"));

  // 2. Show target section
  const target = document.getElementById(stepId);
  if (target) {
    target.classList.remove("d-none");
  }

  // 3. Map Step Section IDs to Stepper Dot IDs
  const stepMapping = {
    building_description: "step-dot-building_description",
    structural_material: "step-dot-structural_material",
    property_appraisal: "step-dot-property_appraisal",
    property_assessment: "step-dot-property_assessment",
    appraisal_approval: "step-dot-appraisal-and-approval",
    superseded_record: "step-dot-superseded-assessment-record",
  };

  const targetDotId = stepMapping[stepId];
  const stepperItems = document.querySelectorAll(".stepper-item");
  let foundActive = false;

  stepperItems.forEach((item) => {
    if (item.id === targetDotId) {
      item.classList.add("active");
      item.classList.remove("completed");
      foundActive = true;
    } else {
      item.classList.remove("active");
      // Marks ONLY previous steps as completed
      item.classList.toggle("completed", !foundActive);
    }
  });

  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}

// Wrapper functions
function to_building_description() {
  navigateTo("building_description");
}

function to_structural_materials() {
  navigateTo("structural_material");
}
// --- NEW: AUTO-NAVIGATE AFTER PHP REDIRECT ---
document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get("status");
  const msg = urlParams.get("msg");

  // If PHP redirected with success and the description was saved
  if (
    msg.includes("General Description Saved") ||
    msg.includes("General Description Updated Successfully")
  ) {
    // Move from Step 1 to Step 2
    navigateTo("structural_material");
  } else if (
    msg.includes("Structural Materials Saved") ||
    msg.includes("Structural Material Updated Successfully")
  ) {
    // Move from Step 2 to Step 3
    navigateTo("property_appraisal");
  } else if (
    msg.includes("Property Appraisal Saved") ||
    msg.includes("Property Appraisal Updated Successfully")
  ) {
    // Move from Step 3 to Step 4
    navigateTo("property_assessment");
  } else if (
    msg.includes("Property Assessment Saved Successfully") ||
    msg.includes("Property Assessment Updated Successfully")
  ) {
    navigateTo("building_description");
    alert(
      "Record saved successfully! The form has been cleared for a new entry.",
    );

    window.history.replaceState(
      {},
      document.title,
      window.location.pathname +
        (hasBuildingId ? "?building_id=" + urlParams.get("building_id") : ""),
    );
  }
});
// Mapping for Materials Checkboxes

// const codeToNameMap = {
//   R1: "reinforced_concrete_roof[]",
//   R2: "tiles_roof[]",
//   R3: "gi_sheet_roof[]",
//   R4: "aluminum_roof[]",
//   R5: "asbestos_roof[]",
//   R6: "long_span_roof[]",
//   R7: "concrete_desk_roof[]",
//   R8: "nac_roof[]",
//   R9: "tf_steel_roof[]",
//   R10: "tf_wood_roof[]",
//   R11: "tf_bamboo_roof[]",
//   F1: "floor_rc[]",
//   F2: "floor_pc[]",
//   F3: "floor_marble[]",
//   F4: "floor_wood[]",
//   F5: "floor_tile[]",
//   F6: "floor_col_rc[]",
//   F7: "floor_col_steel[]",
//   F8: "floor_col_wood[]",
//   F9: "floor_col_bamboo[]",
//   F10: "floor_beam_rc[]",
//   F11: "floor_beam_steel[]",
//   F12: "floor_beam_wood[]",
//   F13: "floor_beam_bamboo[]",
//   WP1: "walls_rc[]",
//   WP2: "walls_pc[]",
//   WP3: "walls_wood[]",
//   WP4: "walls_chb[]",
//   WP5: "walls_gi_sheet[]",
//   WP6: "walls_baw[]",
//   WP7: "walls_pw[]",
//   WP8: "walls_bamboo[]",
// };

// function checkBoxesByCodeAndFloor(dataString, floorValue) {
//   if (!dataString || typeof dataString !== "string") return;
//   const codes = dataString.split(",").map((item) => item.trim());
//   codes.forEach((code) => {
//     const inputName = codeToNameMap[code];
//     if (inputName) {
//       const checkboxes = document.getElementsByName(inputName);
//       checkboxes.forEach((cb) => {
//         if (cb.value.trim() === floorValue.trim()) {
//           cb.checked = true;
//         }
//       });
//     }
//   });
// }
