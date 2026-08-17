<?php
session_start();
$_SESSION['version'] = 1;

ini_set('display_errors', 1);


class Action
{

	private $db;

	private $generalBuildingFields = [
		'pin',
		'bin',
		'owner_name',
		'owner_address',
		'owner_phone',
		'owner_tin',
		'transaction_code',
		'revision_code',

		'admin_name',
		'admin_address',
		'admin_phone',
		'admin_tin',

		'street',
		'baranggay',
		'municipality',
		'province',

		'ref_owner_name',
		'ref_td_no',
		'ref_area',
		'ref_title_type',
		'ref_lot_no',
		'ref_survey_no',
		'ref_block_no',

		'building_kind',
		'structural_type',
		'cct',

		'building_permit_no',
		'permit_date_issued',

		'cert_completion_date',
		'cert_occupancy_date',
		'constructed_date',
		'occupied_date',

		'building_age',
		'storey_no',

		'area_first_floor',
		'area_second_floor',
		'area_third_floor',
		'area_fourth_floor',
		'total_floor_area',
		'previous_pin',
		'previous_arp_no',
		'previous_td',
		'previous_assessed_value',
		'previous_owner',
		'previous_effectivity',
		'recording_person_ID',
		'recording_date'
	];


	public function __construct()
	{
		ob_start();
		include 'config/db_connect.php';
		$this->db = $conn;
	}

	function __destruct()
	{
		$this->db->close();
		ob_end_flush();
	}


	private function respond($data)
	{
		header('Content-Type: application/json');
		echo json_encode($data);
		exit;
	}

	private function prepareInsert($table, $data)
	{
		$fields = array_keys($data);
		$placeholders = rtrim(str_repeat("?,", count($fields)), ",");
		$sql = "INSERT INTO `$table` (`" . implode("`,`", $fields) . "`) VALUES ($placeholders)";
		$stmt = $this->db->prepare($sql);

		if (!$stmt) {
			die("Prepare failed: " . $this->db->error);
		}

		$types = str_repeat("s", count($fields)); // treat all as strings for safety
		$stmt->bind_param($types, ...array_values($data));

		return $stmt;
	}

	private function prepareUpdate($table, $data, $whereField, $whereValue)
	{
		$fields = array_keys($data);
		$set = implode("=?,", $fields) . "=?";
		$sql = "UPDATE `$table` SET $set WHERE `$whereField` = ?";
		$stmt = $this->db->prepare($sql);

		if (!$stmt) {
			die("Prepare failed: " . $this->db->error);
		}

		$types = str_repeat("s", count($fields)) . "i"; // assume id is int
		$stmt->bind_param($types, ...array_merge(array_values($data), [$whereValue]));

		return $stmt;
	}

	function save_building_desc()
	{
		if (!isset($_SESSION['user_ID'])) {
			return $this->respond(['error' => 'Unauthorized. Please log in.']);
		}
		// $description = $_POST['description'] ?? '';

		$mode = $_POST['mode'] ?? null;
		// $building_id = $_POST['input_property_ID'] ?? null;

		$building_id = filter_input(
			INPUT_POST,
			'input_property_ID',
			FILTER_VALIDATE_INT
		);


		// collect data dynamically
		$data = [];
		foreach ($this->generalBuildingFields as $field) {
			$data[$field] = $_POST[$field] ?? null;
		}

		try {

			$this->db->begin_transaction();
			$data['transaction_code'] = 'GR';

			if ($mode === 'old') {

				$sql = "SELECT ID_2022 FROM building_desc WHERE ID_2022 = ? LIMIT 1";
				$stmtCheck = $this->db->prepare($sql);
				$stmtCheck->bind_param("i", $building_id);
				$stmtCheck->execute();
				$result = $stmtCheck->get_result();

				if ($row = $result->fetch_assoc()) {
					$this->db->rollback();

					return $this->respond([
						'success' => false,
						'message' => 'Building already exists.'
					]);
				} else {


					// 🔥 INSERT
					$data['ID_2022'] = $building_id;
					$data['version'] = $_SESSION['version'] ?? 1;
					$data['recording_person_ID'] = $_SESSION['user_ID'] ?? null;
					$data['recording_date'] = date('Y-m-d H:i:s');
					$stmt = $this->prepareInsert("building_desc", $data);
					$action = "insert";
				}
			} elseif ($mode === 'gr') {

				// 🔥 UPDATE
				unset($data['building_id']);
				unset($data['recording_person_ID']);
				unset($data['recording_date']);


				$stmt = $this->prepareUpdate("building_desc", $data, "building_id", $building_id);
				$action = "update";
			} else if ($mode === 'new') {

				// 🔥 INSERT

				$data['version'] = $_SESSION['version'] ?? 1;
				$data['recording_person_ID'] = $_SESSION['user_ID'] ?? null;
				$data['recording_date'] = date('Y-m-d H:i:s');
				$stmt = $this->prepareInsert("building_desc", $data);
				$action = "insert";
			} else {
				throw new Exception("Invalid mode: $mode");
			}

			if (!$stmt->execute()) {
				throw new Exception($stmt->error);
			}

			// determine record id
			$record_id = $this->db->insert_id;
			if ($action === "update") {
				$record_id = $building_id;
			}

			// optional: link old record
			if ($building_id) {
				$this->update_property_status($building_id, $record_id);
			}

			// history log
			// $this->insert_user_history(
			// 	$action,
			// 	"building_desc",
			// 	$record_id,
			// 	'Sample'
			// );

			$this->db->commit();

			echo json_encode([
				"success"     => true,
				"action"      => $action,
				"building_id" => $record_id,
				"message"     => ($action === "insert")
					? "Building added successfully!"
					: "Building updated successfully!"
			]);
			exit;
		} catch (Exception $e) {

			$this->db->rollback();

			echo json_encode([
				"success" => false,
				"message" => "Error saving building",
				"error"   => $e->getMessage()
			]);
			exit;
		}
	}

	function insert_user_history($action, $target_table, $record_id, $description)
	{
		$ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

		$data = [
			'user_id'      => $_SESSION['user_ID'],
			'action'       => $action,
			'target_table' => $target_table,
			'record_id'    => $record_id,
			'description'  => $description,
			'ip_address'   => $ip_address
		];

		$stmt = $this->prepareInsert("user_history", $data);
		if (!$stmt->execute()) {
			error_log("❌ Failed to insert user history: " . $stmt->error);
		}
	}


	function update_property_status($property_ID, $record_id)
	{
		$sql = "UPDATE `property information`
            SET `revised_property_ID` = ?
            WHERE `property_ID` = ?";

		$stmt = $this->db->prepare($sql);

		if (!$stmt) {
			throw new Exception("SQL Prepare failed: " . $this->db->error);
		}

		$stmt->bind_param("ii", $record_id, $property_ID);

		if (!$stmt->execute()) {
			throw new Exception("Failed to update property_information: " . $stmt->error);
		}

		return true; // ✅ silent success
	}


	function get_building_desc()
	{
		// 'alert("test");';
		$faas_id = $_GET['faas_id'] ?? null;
		$building_id = $_GET['building_id'] ?? null;


		$stmt = $this->db->prepare("SELECT * FROM `building_desc` WHERE `building_id` = ? LIMIT 1");
		$stmt->bind_param("i", $building_id);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($row = $result->fetch_assoc()) {
			// $allFields = array_merge($this->propertyFields, $this->propertyFieldsMV);
			return $this->respond($row);
		} else {
			return $this->respond(['error1' => 'No record found']);
		}
	}

	function get_building_info()
	{
		$faas_id = $_GET['faas_id'] ?? null;
		$building_id = $_GET['building_id'] ?? null;
		$mode = $_GET['mode'] ?? null;



		if ($mode === 'gr') {
			$stmt = $this->db->prepare("SELECT * FROM `building_desc` WHERE `building_id` = ? LIMIT 1");
			$stmt->bind_param("i", $building_id);
			$stmt->execute();
			$result = $stmt->get_result();




			if ($row = $result->fetch_assoc()) {
				$response = $row;

				// $stmtforlandreference = $this->db->prepare("SELECT owner_name, title_type, survey, ARP_no, lot_no, BLK  FROM `faas_property` WHERE `PIN_no` = ? AND `property_municipality` = ? AND property_brgy = ?");
				// $stmtforlandreference->bind_param("sss", $row['pin'], $row['municipality'], $row['baranggay']);
				// $stmtforlandreference->execute();
				// $resultforlandreference = $stmtforlandreference->get_result();
				// if ($rowforlandreference = $resultforlandreference->fetch_assoc()) {

				// 	$response['ref_owner_name'] = $rowforlandreference['owner_name'] ?? '';
				// 	$response['ref_title_type'] = $rowforlandreference['title_type'] ?? '';
				// 	$response['ref_survey_no'] = $rowforlandreference['survey'] ?? '';
				// 	$response['ref_arp_no'] = $rowforlandreference['ARP_no'] ?? '';
				// 	$response['ref_lot_no'] = $rowforlandreference['lot_no'] ?? '';
				// 	$response['ref_block_no'] = $rowforlandreference['BLK'] ?? '';
				// } else {

				// 	$response['land_reference_error'] = 'No land reference found';
				// }
				// $allFields = array_merge($this->propertyFields, $this->propertyFieldsMV);
				return $this->respond($response);
			} else {
				return $this->respond(['error1' => 'No record found']);
			}
		} elseif ($mode === 'old') {



			$stmt = $this->db->prepare("SELECT * FROM `building_desc` WHERE `building_id` = ?");
			$stmt->bind_param("i", $building_id);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($row = $result->fetch_assoc()) {
				return $this->respond($row);
			} else {

				$stmt = $this->db->prepare("SELECT * FROM `property information` WHERE `property_ID` = ? LIMIT 1");
				$stmt->bind_param("i", $building_id);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($row = $result->fetch_assoc()) {



					// Return mapped fields
					return $this->respond([
						// LOT INFO
						// 'lot_no'            => $row['CADASTRAL LOT NUMBER'] ?? '',
						// 'block_no'          => $row['BLOCK NUMBER'] ?? '',
						// 'survey_no'         => $row['SURVEY NUMBER'] ?? '',

						// OWNER
						'owner_name'        => $row['NAME OF OWNER'] ?? '',
						'owner_address'     => $row['ADDRESS OF OWNER'] ?? '',
						'owner_phone'       => $row['TELNO OWNER'] ?? '',
						'owner_tin'         => $row['TIN OWNER'] ?? '',

						// ADMIN
						'admin_name'        => $row['NAME OF ADMINISTRATOR'] ?? '',
						'admin_address'     => $row['ADDRESS OF ADMINISTRATOR'] ?? '',
						'admin_phone'       => $row['TELNO ADMIN'] ?? '',
						'admin_tin'         => $row['TIN ADMIN'] ?? '',

						// LOCATION
						'street'            => $row['NUMBER STREET'] ?? '',
						'baranggay'          => $row['LOCATION OF PROPERTY'] ?? '',
						'municipality'      => $row['MUNICIPALITY CODE'] ?? '',
						// 'province'          => $row['PROVINCE CODE'] ?? '',

						// PROPERTY DETAILS
						// 'arp_no'            => $row['TAX DECLARATION NUMBER'] ?? '',
						// 'area'              => $row['ROAD FRONTAGE'] ?? '',

						// TITLE / LEGAL
						'ref_lot_no'            => $row['CADASTRAL LOT NUMBER'] ?? '',
						'ref_block_no'          => $row['BLOCK NUMBER'] ?? '',
						'ref_survey_no'         => $row['SURVEY NUMBER'] ?? '',
						'ref_owner_name'        => $row['NAME OF OWNER'] ?? '',
						'ref_title_type'              => $row['OCT/TCT/CLOA NUMBER'] ?? '',
						'cct'               => $row['CCT'] ?? '',
						'cct_number'        => $row['CCT Number'] ?? '',
						'cct_date'          => $row['CCT Date'] ?? '',

						// BUILDING INFO
						'storey_no'         => $row['Number of Storeys'] ?? '',

						// EXTRA (if needed)
						'previous_pin'           => $row['PIN'] ?? '',
						'previous_arp_no'           => $row['TAX DECLARATION NUMBER'] ?? '',
						'previous_owner'           => $row['NAME OF OWNER'] ?? '',
						'previous_td'           => $row['TAX DECLARATION NUMBER'] ?? ''
					]);
				} else {

					return $this->respond(['error' => 'No record found']);
				}
			}

			// }
		}
	}

	// ==============================
	// HELPER: Extract Codes
	// ==============================
	private function getCodes($floor, $map, $prefix)
	{
		$found = [];

		foreach ($map as $code => $selected) {
			if (in_array($floor, (array)$selected) && strpos($code, $prefix) === 0) {
				$found[] = $code;
			}
		}

		return !empty($found) ? implode(", ", $found) : null;
	}


	// ==============================
	// HELPER: Prepare Insert / Update
	// ==============================
	private function prepareStructuralStmt($table, $data, $where = null)
	{
		$fields = array_keys($data);

		if ($where) {
			// UPDATE
			$set = implode("=?, ", $fields) . "=?";
			$sql = "UPDATE `$table` SET $set WHERE $where";
		} else {
			// INSERT
			$placeholders = rtrim(str_repeat("?,", count($fields)), ",");
			$sql = "INSERT INTO `$table` (`" . implode("`,`", $fields) . "`) VALUES ($placeholders)";
		}

		$stmt = $this->db->prepare($sql);

		if (!$stmt) {
			die("Prepare failed: " . $this->db->error);
		}

		$types = str_repeat("s", count($fields)); // default string

		return [$stmt, $types];
	}

	function save_structural_materials()
	{
		try {

			$building_id = $_POST['building_id'] ?? null;

			if (!$building_id) {
				throw new Exception("Missing building ID");
			}

			// -------------------------
			// HELPER: ARRAY TO STRING
			// -------------------------
			function arrToStr($arr)
			{
				return !empty($arr) ? implode(', ', $arr) : null;
			}

			// -------------------------
			// ROOF
			// -------------------------
			$roof = arrToStr($_POST['roof'] ?? []);

			// -------------------------
			// FLOOR FUNCTION
			// -------------------------
			function parseFloor($data)
			{
				$flooring = [];
				$walls = [];

				foreach ($data as $val) {

					if (stripos($val, 'Walls') !== false) {
						$walls[] = $val;
					} else {
						$flooring[] = $val;
					}
				}

				return [
					'flooring' => !empty($flooring)
						? implode(', ', $flooring)
						: null,

					'walls' => !empty($walls)
						? implode(', ', $walls)
						: null
				];
			}

			// -------------------------
			// FLOORS
			// -------------------------
			$f1 = parseFloor($_POST['floor1'] ?? []);
			$f2 = parseFloor($_POST['floor2'] ?? []);
			$f3 = parseFloor($_POST['floor3'] ?? []);
			$f4 = parseFloor($_POST['floor4'] ?? []);

			// -------------------------
			// OTHERS PER FLOOR
			// -------------------------
			$floor1_others = trim($_POST['floor1_others'] ?? '');
			$floor2_others = trim($_POST['floor2_others'] ?? '');
			$floor3_others = trim($_POST['floor3_others'] ?? '');
			$floor4_others = trim($_POST['floor4_others'] ?? '');

			// -------------------------
			// CHECK IF EXISTS
			// -------------------------
			$check = $this->db->prepare("
            SELECT building_id
            FROM structural_material
            WHERE building_id = ?
            LIMIT 1
        ");

			$check->bind_param("i", $building_id);
			$check->execute();

			$result = $check->get_result();

			// -------------------------
			// UPDATE IF EXISTS
			// -------------------------
			if ($result->num_rows > 0) {

				$stmt = $this->db->prepare("
                UPDATE structural_material SET

                    roof = ?,

                    first_floor_flooring = ?,
                    second_floor_flooring = ?,
                    third_floor_flooring = ?,
                    fourth_floor_flooring = ?,

                    first_floor_wall = ?,
                    second_floor_wall = ?,
                    third_floor_wall = ?,
                    fourth_floor_wall = ?,

                    floor1_others = ?,
                    floor2_others = ?,
                    floor3_others = ?,
                    floor4_others = ?

                WHERE building_id = ?
            ");

				if (!$stmt) {
					throw new Exception($this->db->error);
				}

				$stmt->bind_param(
					"sssssssssssssi",

					$roof,

					$f1['flooring'],
					$f2['flooring'],
					$f3['flooring'],
					$f4['flooring'],

					$f1['walls'],
					$f2['walls'],
					$f3['walls'],
					$f4['walls'],

					$floor1_others,
					$floor2_others,
					$floor3_others,
					$floor4_others,

					$building_id
				);
			} else {

				// -------------------------
				// INSERT IF NOT EXISTS
				// -------------------------
				$stmt = $this->db->prepare("
                INSERT INTO structural_material (

                    building_id,
                    roof,

                    first_floor_flooring,
                    second_floor_flooring,
                    third_floor_flooring,
                    fourth_floor_flooring,

                    first_floor_wall,
                    second_floor_wall,
                    third_floor_wall,
                    fourth_floor_wall,

                    floor1_others,
                    floor2_others,
                    floor3_others,
                    floor4_others

                ) VALUES (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                )
            ");

				if (!$stmt) {
					throw new Exception($this->db->error);
				}

				$stmt->bind_param(
					"isssssssssssss",

					$building_id,
					$roof,

					$f1['flooring'],
					$f2['flooring'],
					$f3['flooring'],
					$f4['flooring'],

					$f1['walls'],
					$f2['walls'],
					$f3['walls'],
					$f4['walls'],

					$floor1_others,
					$floor2_others,
					$floor3_others,
					$floor4_others
				);
			}

			// -------------------------
			// EXECUTE
			// -------------------------
			if (!$stmt->execute()) {
				throw new Exception($stmt->error);
			}

			echo json_encode([
				"success" => true,
				"message" => "Structural materials saved successfully!"
			]);
		} catch (Exception $e) {

			echo json_encode([
				"success" => false,
				"message" => "Failed to save",
				"error" => $e->getMessage()
			]);
		}
	}

	function get_structural_materials()
	{
		try {
			$building_id = $_GET['building_id'] ?? null;
			if (!$building_id) {
				throw new Exception("Missing building ID");
			}

			$stmt = $this->db->prepare("SELECT * FROM structural_material 
            WHERE building_id = ? LIMIT 1
        ");
			$stmt->bind_param("i", $building_id);
			$stmt->execute();

			$result = $stmt->get_result()->fetch_assoc();

			echo json_encode([
				"success" => true,
				"data" => $result
			]);
		} catch (Exception $e) {
			echo json_encode([
				"success" => false,
				"error" => $e->getMessage()
			]);
		}
	}
}
