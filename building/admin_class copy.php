<?php
session_start();
$_SESSION['version'] = 1;

ini_set('display_errors', 1);


class Action
{

	private $db;

	private $generalBuildingFields = [
		'pin',

		'owner_name',
		'owner_address',
		'owner_phone',
		'owner_tin',

		'admin_name',
		'admin_address',
		'admin_phone',
		'admin_tin',

		'street',
		'baranggay',
		'municipality',
		'province',

		'owner_reference_name',
		'arp_no',
		'area',
		'cloa',
		'lot_no',
		'survey_no',
		'block_no',

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
		'recording_person',
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

	private function prepareInsertBuildingDesc($table, $data)
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

	function save_building_desc()
	{

		$building_id = $_POST['building_id'] ?? null;
		$old_building_ID = $_POST['building_id_2022'] ?? null;

		// collect data dynamically
		$data = [];
		foreach ($this->generalBuildingFields as $field) {
			$data[$field] = $_POST[$field] ?? null;
		}

		if ($building_id) {
			// 🔥 UPDATE
			$fields = array_keys($data);
			$set = implode(" = ?, ", $fields) . " = ?";

			$sql = "UPDATE `building_desc` SET $set WHERE building_id = ?";
			$stmt = $this->db->prepare($sql);

			// types: all string except last (building_id = int)
			$types = str_repeat("s", count($data)) . "i";

			$values = array_values($data);
			$values[] = $building_id;

			$stmt->bind_param($types, ...$values);

			if ($stmt->execute()) {
				echo json_encode([
					"success"   => true,
					"message"   => "Property Updated successfully!",
					'building_id' => $building_id

				]);
			} else {
				return $this->respond(['error' => $stmt->error]);
			}
		} else {
			// 🔥 INSERT
			$fields = array_keys($data);
			$placeholders = rtrim(str_repeat("?,", count($fields)), ",");

			$sql = "INSERT INTO `building_desc` (" . implode(",", $fields) . ") VALUES ($placeholders)";
			$stmt = $this->db->prepare($sql);

			$types = str_repeat("s", count($data));
			$values = array_values($data);

			$stmt->bind_param($types, ...$values);

			if ($stmt->execute()) {
				echo json_encode([
					"success"   => true,
					"message"   => "Property Inserted successfully!",
					'building_id' => $stmt->insert_id

				]);
			} else {
				return $this->respond(['error' => $stmt->error]);
			}
		}
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

	function get_property_revised()
	{
		$faas_id = $_GET['faas_id'] ?? null;
		$old_building_ID = $_GET['building_id_2022'] ?? null;
		$new_building_ID = $_GET['building_id'] ?? null;

		// if (!$new_building_ID && !$old_building_ID) {
		// 	return $this->respond(['error' => 'Contact the developer.']);
		// }

		if ($new_building_ID) {

			$stmt = $this->db->prepare("SELECT * FROM `building_desc` WHERE `building_id` = ? LIMIT 1");
			$stmt->bind_param("i", $new_building_ID);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($row = $result->fetch_assoc()) {
				// $allFields = array_merge($this->propertyFields, $this->propertyFieldsMV);
				return $this->respond($row);
			} else {
				return $this->respond(['error1' => 'No record found']);
			}
		} elseif ($old_building_ID) {

			$stmt = $this->db->prepare("SELECT * FROM `building_desc` WHERE `ID_2022` = ?");
			$stmt->bind_param("i", $old_property_ID);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($row = $result->fetch_assoc()) {
				return $this->respond($row);
			} else {

				$stmt = $this->db->prepare("SELECT * FROM `property information` WHERE `property_ID` = ? LIMIT 1");
				$stmt->bind_param("i", $old_building_ID);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($row = $result->fetch_assoc()) {

					// Return mapped fields
					return $this->respond([
						// LOT INFO
						'lot_no'            => $row['CADASTRAL LOT NUMBER'] ?? '',
						'block_no'          => $row['BLOCK NUMBER'] ?? '',
						'survey_no'         => $row['SURVEY NUMBER'] ?? '',

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
						'arp_no'            => $row['TAX DECLARATION NUMBER'] ?? '',
						'area'              => $row['ROAD FRONTAGE'] ?? '',

						// TITLE / LEGAL
						'cloa'              => $row['OCT/TCT/CLOA NUMBER'] ?? '',
						'cct'               => $row['CCT'] ?? '',
						'cct_number'        => $row['CCT Number'] ?? '',
						'cct_date'          => $row['CCT Date'] ?? '',

						// BUILDING INFO
						'storey_no'         => $row['Number of Storeys'] ?? '',

						// EXTRA (if needed)
						'remarks'           => $row['REMARKS'] ?? '',
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

			// helper: convert array to string
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
					'flooring' => !empty($flooring) ? implode(', ', $flooring) : null,
					'walls'    => !empty($walls) ? implode(', ', $walls) : null
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
			// CHECK IF EXISTS
			// -------------------------
			$check = $this->db->prepare("SELECT building_id FROM structural_material WHERE building_id = ? LIMIT 1");
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
                    fourth_floor_wall = ?

                WHERE building_id = ?
            ");

				$stmt->bind_param(
					"sssssssssi",
					$roof,

					$f1['flooring'],
					$f2['flooring'],
					$f3['flooring'],
					$f4['flooring'],

					$f1['walls'],
					$f2['walls'],
					$f3['walls'],
					$f4['walls'],

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
                    fourth_floor_wall
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

				$stmt->bind_param(
					"isssssssss",
					$building_id,
					$roof,

					$f1['flooring'],
					$f2['flooring'],
					$f3['flooring'],
					$f4['flooring'],

					$f1['walls'],
					$f2['walls'],
					$f3['walls'],
					$f4['walls']
				);
			}

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

			$stmt = $this->db->prepare("
            SELECT * FROM structural_material 
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
