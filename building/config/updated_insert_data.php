<?php
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $building_id = !empty($_POST['building_id']) ? intval($_POST['building_id']) : null;
    $msg = "";

    try {
        // --- 1. GENERAL DESCRIPTION ---
        if (isset($_POST['general_desc_btn'])) {
            $params = [
                $_POST['building_pin'],
                $_POST['kind_of_building'],
                $_POST['structural_type'],
                $_POST['building_permit_no'],
                $_POST['permit_date_issued'],
                $_POST['cct'],
                $_POST['cert_completion_date'],
                $_POST['cert_occupancy_date'],
                $_POST['constructed_date'],
                $_POST['occupied_date'],
                $_POST['building_age'],
                $_POST['storeys_no'],
                $_POST['area_first_floor'],
                $_POST['area_second_floor'],
                $_POST['area_third_floor'],
                $_POST['area_fourth_floor'],
                $_POST['floor_total_area']
            ];

            if ($building_id) {
                $stmt = $conn->prepare("UPDATE building_desc SET pin=?, building_kind=?, structural_type=?, building_permit_no=?, permit_date_issued=?, cct=?, cert_completion_date=?, cert_occupancy_date=?, constructed_date=?, occupied_date=?, building_age=?, storey_no=?, area_first_floor=?, area_second_floor=?, area_third_floor=?, area_fourth_floor=?, total_floor_area=? WHERE building_id=?");
                $stmt->bind_param("sssssssssssssssssi", ...[...$params, $building_id]);
                $msg = "General Description Updated Successfully";
            } else {
                $stmt = $conn->prepare("INSERT INTO building_desc (pin, building_kind, structural_type, building_permit_no, permit_date_issued, cct, cert_completion_date, cert_occupancy_date, constructed_date, occupied_date, building_age, storey_no, area_first_floor, area_second_floor, area_third_floor, area_fourth_floor, total_floor_area) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("sssssssssssssssss", ...$params);
                $msg = "General Description Saved";
            }
            $stmt->execute();
            if (!$building_id) $building_id = $conn->insert_id;
        }

        // --- 2. STRUCTURAL MATERIALS ---
        elseif (isset($_POST['structural_materials_btn'])) {
            if (!$building_id) throw new Exception("Please save General Description first.");

            $structural_data = [
                // Roofing
                "R1" => $_POST['reinforced_concrete_roof'] ?? [],
                "R2" => $_POST['tiles_roof'] ?? [],
                "R3" => $_POST['gi_sheet_roof'] ?? [],
                "R4" => $_POST['aluminum_roof'] ?? [],
                "R5" => $_POST['asbestos_roof'] ?? [],
                "R6" => $_POST['long_span_roof'] ?? [],
                "R7" => $_POST['concrete_desk_roof'] ?? [],
                "R8" => $_POST['nac_roof'] ?? [],
                "R9" => $_POST['tf_steel_roof'] ?? [],
                "R10" => $_POST['tf_wood_roof'] ?? [],
                "R11" => $_POST['tf_bamboo_roof'] ?? [],
                // F = Flooring
                "F1"  => $_POST['floor_rc'] ?? [],
                "F2"  => $_POST['floor_pc'] ?? [],
                "F3"  => $_POST['floor_marble'] ?? [],
                "F4"  => $_POST['floor_wood'] ?? [],
                "F5"  => $_POST['floor_tile'] ?? [],
                "F6"  => $_POST['floor_col_rc'] ?? [],
                "F7"  => $_POST['floor_col_steel'] ?? [],
                "F8"  => $_POST['floor_col_wood'] ?? [],
                "F9"  => $_POST['floor_col_bamboo'] ?? [],
                "F10" => $_POST['floor_beam_rc'] ?? [],
                "F11" => $_POST['floor_beam_steel'] ?? [],
                "F12" => $_POST['floor_beam_wood'] ?? [],
                "F13" => $_POST['floor_beam_bamboo'] ?? [],
                // WP = Walls and Partition
                "WP1" => $_POST['walls_rc'] ?? [],
                "WP2" => $_POST['walls_pc'] ?? [],
                "WP3" => $_POST['walls_wood'] ?? [],
                "WP4" => $_POST['walls_chb'] ?? [],
                "WP5" => $_POST['walls_gi_sheet'] ?? [],
                "WP6" => $_POST['walls_baw'] ?? [],
                "WP7" => $_POST['walls_pw'] ?? [],
                "WP8" => $_POST['walls_bamboo'] ?? []
            ];

            function getCodes($floor, $map, $pre) {
                $found = [];
                foreach ($map as $code => $selected) {
                    if (in_array($floor, (array)$selected) && strpos($code, $pre) === 0) $found[] = $code;
                }
                return !empty($found) ? implode(", ", $found) : null;
            }

            $r = getCodes("Roof", $structural_data, "R");
            $f1 = getCodes("1st Floor", $structural_data, "F");
            $f2 = getCodes("2nd Floor", $structural_data, "F");
            $f3 = getCodes("3rd Floor", $structural_data, "F");
            $f4 = getCodes("4th Floor", $structural_data, "F");
            $w1 = getCodes("1st Floor", $structural_data, "WP");
            $w2 = getCodes("2nd Floor", $structural_data, "WP");
            $w3 = getCodes("3rd Floor", $structural_data, "WP");
            $w4 = getCodes("4th Floor", $structural_data, "WP");

            $check = $conn->query("SELECT building_id FROM structural_material WHERE building_id = $building_id");
            if ($check->num_rows > 0) {
                $stmt = $conn->prepare("UPDATE structural_material SET roof=?, first_floor_flooring=?, second_floor_flooring=?, third_floor_flooring=?, fourth_floor_flooring=?, first_floor_wall=?, second_floor_wall=?, third_floor_wall=?, fourth_floor_wall=? WHERE building_id=?");
                $stmt->bind_param("sssssssssi", $r, $f1, $f2, $f3, $f4, $w1, $w2, $w3, $w4, $building_id);
                $msg = "Structural Materials Updated Successfully";
            } else {
                $stmt = $conn->prepare("INSERT INTO structural_material (building_id, roof, first_floor_flooring, second_floor_flooring, third_floor_flooring, fourth_floor_flooring, first_floor_wall, second_floor_wall, third_floor_wall, fourth_floor_wall) VALUES (?,?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("isssssssss", $building_id, $r, $f1, $f2, $f3, $f4, $w1, $w2, $w3, $w4);
                $msg = "Structural Materials Saved";
            }
            $stmt->execute();
            
            header("Location: ../building_form.php?building_id=$building_id&status=success&msg=" . urlencode($msg));
            exit();
        }

        // --- 3. PROPERTY APPRAISAL ---
        elseif (isset($_POST['appraisal_btn'])) {
            if (!$building_id) throw new Exception("Save General Description first.");
            
            $vals = [
                $_POST['ucc'] ?? '',
                $_POST['building_core'] ?? '',
                $_POST['cost_additional_items'], 
                $_POST['sub_total'] ?? '',
                $_POST['depreciation_rate'] ?? '',
                $_POST['depreciation_cost'] ?? '', 
                $_POST['subtotal'] ?? '',
                $_POST['total_construction_cost'] ?? '',
                $_POST['total_depreciation'] ?? '', 
                $_POST['appraisal_market_value'] ?? ''
            ];

            $check = $conn->query("SELECT building_id FROM property_appraisal WHERE building_id = $building_id");
            if ($check->num_rows > 0) {
                $stmt = $conn->prepare("UPDATE property_appraisal SET ucc=?, building_core=?, cost_additional_items=?, sub_total=?, depreciation_rate=?, depreciation_cost=?, subtotal=?, total_construction_cost=?, total_depreciation=?, market_value=? WHERE building_id=?");
                $stmt->bind_param("ssssssssssi", ...[...$vals, $building_id]);
                $msg = "Property Appraisal Updated Successfully";
            } else {
                $stmt = $conn->prepare("INSERT INTO property_appraisal (building_id, ucc, building_core, cost_additional_items, sub_total, depreciation_rate, depreciation_cost, subtotal, total_construction_cost, total_depreciation, market_value) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("issssssssss", ...[...[$building_id], ...$vals]);
                $msg = "Property Appraisal Saved";
            }
            $stmt->execute();
            
        }

        // --- 4. PROPERTY ASSESSMENT ---
        elseif (isset($_POST['assessment_btn'])) {
            if (!$building_id) throw new Exception("Save General Description first.");

            $act_use = implode(", ", $_POST['actual_use'] ?? []);
            $mkt_val = implode(", ", $_POST['assess_market_value'] ?? []);
            $assessed_level = implode(", ", $_POST['assessment_level'] ?? []);
            $assessed_value = implode(", ", $_POST['assessed_value'] ?? []);
            $taxable = isset($_POST['taxable']) ? 1 : 0;
            $exempt = isset($_POST['exempt']) ? 1 : 0;
            
            // Map the rest of your assessment fields from the POST data
            $assessment_params = [
                $act_use, 
                $mkt_val,
                $assessed_level,
                $assessed_value,
                $_POST['total_actual_use'] ?? '',
                $_POST['total_market_val'] ?? '',
                $_POST['total_assessment_level'] ?? '', 
                $_POST['total_assessed_value'] ?? '',
                $taxable,
                $exempt,
                $_POST['effective_assessment'] ?? '', 
                $_POST['qtr'] ?? '',
                $_POST['yr'] ?? '',
                $_POST['appraiser_name'] ?? '',
                $_POST['date_appraiser'] ?? '',
                $_POST['recomending_approval_name'] ?? '',
                $_POST['recomending_approval_date'] ?? '',
                $_POST['approved_by'] ?? '', // Line 536 warning fixed here
                $_POST['date_approved'] ?? '',
                $_POST['memoranda'] ?? '',
                $_POST['entry_date'] ?? '',
                $_POST['recorder_name'] ?? '',
                $_POST['recorded_pin'] ?? '',
                $_POST['recorded_arp'] ?? '',
                $_POST['recorded_td'] ?? '',
                $_POST['recorded_assessed_val'] ?? '',
                $_POST['prev_owner'] ?? '',
                $_POST['effectivity_assessment'] ?? '',
                $_POST['recording_person'] ?? '',
                $_POST['recording_date'] ?? '' // Line 548 warning fixed here
            ];

            $check = $conn->query("SELECT building_id FROM property_assessment WHERE building_id = $building_id");

            if ($check->num_rows > 0) {
                // FIXED: Added =? to recorded_prev_owner
                $sql = "UPDATE property_assessment SET actual_use=?, market_value=?, assessment_level=?, assessed_value=?, total_actual_use=?, total_market_value=?, total_assessment_level=?, total_assessed_value=?, taxable=?, exempt=?, effectivity_assessment=?, qtr=?, yr=?, appraiser_name=?, appraiser_date=?, recommending_approval_name=?, recommending_approval_date=?, approved_by=?, approved_by_date=?, memoranda=?, date_of_entry=?, recorder_name=?, recorded_pin=?, recorded_arp=?, recorded_td=?, recorded_total_assessed_value=?, recorded_prev_owner=?, recorded_eao=?, recording_person=?, recording_date=? WHERE building_id=?";
                $msg = "Property Assessment Updated Successfully";
            } else {
                $sql = "INSERT INTO property_assessment (actual_use, market_value, assessment_level, assessed_value, total_actual_use, total_market_value, total_assessment_level, total_assessed_value, taxable, exempt, effectivity_assessment, qtr, yr, appraiser_name, appraiser_date, recommending_approval_name, recommending_approval_date, approved_by, approved_by_date, memoranda, date_of_entry, recorder_name, recorded_pin, recorded_arp, recorded_td, recorded_total_assessed_value, recorded_prev_owner, recorded_eao, recording_person, recording_date, building_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $msg = "Assessment Saved Successfully. Form Reset for New Entry.";
            }

            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                // This will tell you EXACTLY what is wrong with your SQL string
                die("SQL Prepare Error: " . $conn->error);
            }

            $stmt->bind_param("ssssssssiiisssssssssssssssssssi", ...[...$assessment_params, $building_id]);

            if (!$stmt->execute()) {
                die("Execute Error: " . $stmt->error);
            }

            

            header("Location: ../building_form.php?status=success&msg=" . urlencode($msg));
            
            exit();
        }

        header("Location: ../building_form.php?building_id=$building_id&status=success&msg=" . urlencode($msg));
        exit();

    } catch (Exception $e) {
        header("Location: ../building_form.php?building_id=$building_id&status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
}
?>

