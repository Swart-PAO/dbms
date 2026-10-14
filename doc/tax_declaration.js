$(document).ready(function () {
  let some_id = $('input[name="property_ID"]').val();
  // alert('123132'); // Debugging line to check the value of some_id

  const municipalityMap = {
    1: "SAN JOSE (Capital)",
    2: "ANINI-Y",
    3: "BARBAZA",
    4: "BELISON",
    5: "BUGASONG",
    6: "CALUYA",
    7: "CULASI",
    8: "TOBIAS FORNIER (DAO)",
    9: "HAMTIC",
    10: "LAUA-AN",
    11: "LIBERTAD",
    12: "PANDAN",
    13: "PATNONGON",
    14: "SAN REMIGIO",
    15: "SEBASTE",
    16: "SIBALOM",
    17: "TIBIAO",
    18: "VALDERRAMA",
  };

  $.ajax({
    url: "../land/ajax.php?action=get_property_revised",
    type: "GET",
    data: {
      property_ID: some_id,
      mode: "gr",
    }, // pass the property_ID dynamically
    dataType: "json",
    success: function (data) {
      if (data.error) {
        alert(data.error);
        return;
      }
      let munCode = $.trim(data.property_municipality);

      $("#property_municipality").text(municipalityMap[munCode] ?? munCode);
      $("#total_adjustment").text("₱ " + $.trim(data.total_adjustment));
      $("#total_market_value").text("₱ " + $.trim(data.total_market_value));
      $("#bmvmv").text("₱ " + $.trim(data.total_land_mv));
      $("#total_land_mv").text(formatPeso($.trim(data.total_land_mv)));
      $("#total_resid_mv").text(formatPeso($.trim(data.total_residential_mv)));
      $("#pin_no").text($.trim(data.PIN_no));
      $("#arp_no").text($.trim(data.previous_ARP_no));
      $("#title_type").text($.trim(data.title_type));
      $("#lot_no").text($.trim(data.lot_no));
      $("#blk").text($.trim(data.BLK));
      $("#survey").text($.trim(data.survey));
      $("#owner_name").text($.trim(data.owner_name));
      $("#owner_address").text($.trim(data.owner_address));
      $("#owner_tin").text($.trim(data.owner_tin));
      $("#owner_no").text($.trim(data.owner_no));
      $("#admin_name").text($.trim(data.admin_name));
      $("#admin_address").text($.trim(data.admin_address));
      $("#admin_no").text($.trim(data.admin_no));
      $("#admin_tin").text($.trim(data.admin_tin));
      $("#property_brgy").text($.trim(data.property_brgy));
      // $('#property_municipality').text($.trim(data.property_municipality));
      $("#northern").text($.trim(data.northern));
      $("#eastern").text($.trim(data.eastern));
      $("#southern").text($.trim(data.southern));
      $("#western").text($.trim(data.western));
      $("#street_no").text($.trim(data.street_no));
      $("#previous_pin").text($.trim("PIN " + data.previous_pin));
      $("#previous_td_no").text($.trim("TD No." + data.previous_td_no));
      $("#previous_ARP_no").text($.trim("ARP no. " + data.previous_ARP_no));
      $("#previous_assessed_value").text(
        $.trim("Previous Assessed Value: " + data.previous_assessed_value),
      );
      $("#previous_owner").text($.trim("Previous Owner: " + data.street_no));
      $("#previous_effectivity").text(
        $.trim("Effectivity of Assessment: " + data.previous_effectivity),
      );
      $("#ar_page_no").text($.trim("AR Page No.: " + data.street_no));
      $("#recording_person").text(
        $.trim("Recording Person: " + data.street_no),
      );
      $("#recording_date").text($.trim("Date: " + data.street_no));
    },
  });

  function formatPeso(value) {
    if (value === null || value === undefined || value === "") return "";

    const number = Number(value);
    if (isNaN(number)) return "";

    return `₱ ${number.toLocaleString("en-PH", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    })}`;
  }
});
