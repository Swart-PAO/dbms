<?php
session_start();
$_SESSION['version'] = 1;

ini_set('display_errors', 1);


class Action
{

	private $db;



	// define all property fields once
	private $propertyFields = [
		"property_ID",
		"transaction_code",
		"revision_code",
		"ARP_no",
		"title_type",
		"title_dated",
		"PIN_no",
		"survey",
		"lot_no",
		"BLK",
		"owner_name",
		"owner_address",
		"owner_no",
		"owner_tin",
		"admin_name",
		"admin_address",
		"admin_no",
		"admin_tin",
		"street_no",
		"property_brgy",
		"property_municipality",
		"property_province",
		"north",
		"east",
		"south",
		"west",
		"northern",
		"eastern",
		"southern",
		"western",
		"previous_pin",
		"previous_ARP_no",
		"previous_td_no",
		"previous_assessed_value",
		"previous_owner",
		"previous_effectivity"
	];

	private $propertyFieldsMV = [
		"factor_first",
		"factor_second",
		"factor_third",
		"percent_first",
		"percent_second",
		"percent_third",
		"total_adjustment",
		"percent_total",
		"total_land_mv",
		"total_market_value",
		"total_land_area",
		"total_non_agri_mv",
		"total_non_agri_area",
		"total_assessment_mv",
		"total_assessed_value"
	];

	public function __construct()
	{
		ob_start();

		require_once __DIR__ . '/../config.php';
		require_once ROOT_PATH . '/db/db_connect.php';
		$this->db = $conn;
	}

	function __destruct()
	{
		$this->db->close();
		ob_end_flush();
	}

	/* ------------------ UTILITIES ------------------ */

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

	private function rowToJson($row, $fields)
	{
		$data = [];
		foreach ($fields as $field) {
			$data[$field] = $row[$field] ?? '';
		}
		return $data;
	}

	// function get_property_previous()
	// {
	// 	if (!isset($_GET['search_pin']) || empty($_GET['search_pin'])) {
	// 		$this->respond(['error' => 'PIN number not provided']);
	// 	}

	// 	$pin_no   = $_GET['search_pin'];
	// 	$mun_code = $_GET['mun_code'];

	// 	$stmt = $this->db->prepare("SELECT * FROM `property information` WHERE `PIN` = ? AND `MUNICIPALITY CODE` = ? AND `revised_property_ID`=0 LIMIT 1");
	// 	$stmt->bind_param("si", $pin_no, $mun_code);
	// 	$stmt->execute();
	// 	$result = $stmt->get_result();

	// 	if ($row = $result->fetch_assoc()) {
	// 		echo json_encode([
	// 			'BLK'     => $row['BLOCK NUMBER'] ?? '',
	// 			'survey'  => $row['SURVEY NUMBER'] ?? '',
	// 			'title_type'      => $row['OCT/TCT/CLOA NUMBER'] ?? '',
	// 			'lot_no'      => $row['CADASTRAL LOT NUMBER'] ?? '',
	// 			'owner_name'     => $row['NAME OF OWNER'] ?? '',
	// 			'owner_address'  => $row['ADDRESS OF OWNER'] ?? '',
	// 			'owner_tin'      => $row['TIN OWNER'] ?? '',
	// 			'owner_no'       => $row['TELNO OWNER'] ?? '',
	// 			'admin_name'     => $row['NAME OF ADMINISTRATOR'] ?? '',
	// 			'admin_address'  => $row['ADDRESS OF ADMINISTRATOR'] ?? '',
	// 			'admin_no'       => $row['TELNO ADMIN'] ?? '',
	// 			'street_no'       => $row['NUMBER STREET'] ?? '',
	// 			'property_brgy'       => $row['LOCATION OF PROPERTY'] ?? '',
	// 			'property_municipality' => $row['LOCATION OF PROPERTY'] ?? '',
	// 			'northern'       => $row['NORTHERN BOUNDARIES'] ?? '',
	// 			'eastern'       => $row['EASTERN BOUNDARIES'] ?? '',
	// 			'southern'       => $row['SOUTHERN BOUNDARIES'] ?? '',
	// 			'western'       => $row['WESTERN BOUNDARIES'] ?? '',
	// 			'admin_tin'      => $row['TIN ADMIN'] ?? '',
	// 			'previous_pin'   => $row['PIN'] ?? '',
	// 			'previous_td_no' => $row['TAX DECLARATION NUMBER'] ?? '',
	// 			'previous_effectivity' => $row['DATE OF EFFECTIVITY'] ?? '',
	// 			'previous_assessed_value' => $row['TAXABLE ASSESSED VALUE'] ?? '',
	// 			'north' => $row['NORTH'] ?? '',
	// 			'east' => $row['EAST'] ?? '',
	// 			'south' => $row['SOUTH'] ?? '',
	// 			'west' => $row['WEST'] ?? '',
	// 			'previous_ARP_no'      => $row['TAX DECLARATION NUMBER'] ?? '',
	// 			'property_ID'      => $row['property_ID'] ?? '',
	// 		]);
	// 	} else {
	// 		$this->respond(['error' => 'No record found for this PIN No.']);
	// 	}
	// }

	function save_property()
	{
		if (!isset($_SESSION['user_ID'])) {
			return $this->respond(['error' => 'Unauthorized. Please log in.']);
		}
		$description = $_POST['description'] ?? '';

		$property_ID = $_POST['input_property_ID'] ?? '';
		$mode = $_POST['mode'] ?? '';

		if (!$property_ID) {
			throw new Exception("Missing property ID.");
		}

		$data = [];
		foreach ($this->propertyFields as $field) {
			$data[$field] = $_POST[$field] ?? null;
		}

		try {

			$this->db->begin_transaction();
			if ($mode === "old") {


				$data['old_property_ID'] = $property_ID;
				$data['version'] = $_SESSION['version'] ?? null;
				$data['recording_person_ID'] = $_SESSION['user_ID'] ?? null;
				$data['recording_date'] = date('Y-m-d H:i:s');

				$stmt = $this->prepareInsert("property_info", $data);
				$action = "insert";
				$db_update = '';
			} elseif ($mode === "gr") {
				// Get current record before update
				$oldData = [];
				$result = $this->db->query("SELECT * FROM property_info WHERE property_ID = " . (int)$property_ID);

				if ($result && $result->num_rows > 0) {
					$oldData = $result->fetch_assoc();
				}

				$db_changes = [];

				foreach ($data as $field => $newValue) {

					// Skip property_ID
					if ($field == 'property_ID') {
						continue;
					}

					$oldValue = $oldData[$field] ?? null;

					// Compare as strings to avoid int/string differences
					if ((string)$oldValue !== (string)$newValue) {

						$db_changes[$field] = [
							"old" => $oldValue,
							"new" => $newValue
						];
					}
				}

				$db_update = json_encode(
					$db_changes,
					JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
				);

				unset($data['property_ID']);
				$stmt = $this->prepareUpdate("property_info", $data, "property_ID", $property_ID);
				$action = "update";


				// $data_saved = "✅ Property updated successfully!";
			} else {
				throw new Exception("Invalid property_ID or mode");
			}

			if (!$stmt->execute()) {
				throw new Exception($stmt->error);
			}
			$record_id = $this->db->insert_id;

			if ($action === "update" && $mode === "gr") {
				$record_id = $property_ID; // For updates, the record_id is the existing property_ID
			} elseif ($action === "insert" && $mode === "old") {
				$this->update_property_status($property_ID, $record_id);
			}


			$this->insert_property_history(
				$action,
				"property_info",
				$record_id,
				$description,
				$db_update
			);
			$this->db->commit();
			echo json_encode([
				"success"   => true,
				"action"    => $action,
				"record_id" => $record_id,
				"message"   => ($action === "insert")
					? "Property added successfully!"
					: "Property updated successfully!"
			]);
			exit;
		} catch (Exception $e) {
			$this->db->rollback();
			echo json_encode([
				"success" => false,
				"message" => "Error saving property",
				"error"   => $e->getMessage()
			]);
			exit;
		}
	}

	function update_property_status($property_ID, $record_id)
	{
		if (!isset($_SESSION['user_ID'])) {
			return $this->respond(['error' => 'Unauthorized. Please log in.']);
		}
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

	function get_property_revised()

	{

		$property_ID = $_GET['property_ID'] ?? null;
		$mode = $_GET['mode'] ?? null;

		$property_ID = filter_input(
			INPUT_GET,
			'property_ID',
			FILTER_VALIDATE_INT
		);
		if (!isset($_SESSION['user_ID'])) {
			return $this->respond(['error' => 'Unauthorized. Please log in.']);
		}

		if (!in_array($mode, ['gr', 'old'], true)) {
			return $this->respond(['error' => 'Invalid mode.']);
		}

		if ($property_ID === false || $property_ID <= 0) {
			return $this->respond(['error' => 'Invalid property ID.']);
		}

		if ($mode === 'gr') {
			$stmt = $this->db->prepare("SELECT p.*, brgy.brgy_code,
        pvs.total_land_area,
        pvs.total_land_mv,
        pvs.total_non_agri_area,
        pvs.total_non_agri_mv,
        pvs.total_market_value,
        pvs.total_assessment_mv,
        pvs.total_assessed_value,
        pvs.factor_first,
        pvs.factor_second,
        pvs.factor_third,
        pvs.percent_first,
        pvs.percent_second,
        pvs.percent_third,
        pvs.percent_total,
        pvs.total_adjustment
    FROM property_info AS p
    LEFT JOIN barangay_list AS brgy
        ON p.`property_brgy` = brgy.brgy_name
        AND p.`property_municipality` = brgy.mun_code
    LEFT JOIN property_valuation_summary AS pvs
        ON p.property_ID = pvs.property_ID
    WHERE p.property_ID = ?
    LIMIT 1");
			$stmt->bind_param("i", $property_ID);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($row = $result->fetch_assoc()) {

				$allFields = array_merge($this->propertyFields, $this->propertyFieldsMV);

				$data = $this->rowToJson($row, $allFields);

				$data['brgy_code'] = $row['brgy_code'];

				return $this->respond($data);
			} else {
				return $this->respond(['error' => 'No record found. Please Contact the Administrator.']);
			}
		} elseif ($mode === 'old') {

			// SECOND QUERY
			$stmt = $this->db->prepare("SELECT pi.*, brgy.brgy_code  FROM `property information` AS pi LEFT JOIN barangay_list AS brgy
        ON pi.`LOCATION OF PROPERTY` = brgy.brgy_name
        AND pi.`MUNICIPALITY CODE` = brgy.mun_code WHERE pi.`property_ID` = ? LIMIT 1");
			$stmt->bind_param("i", $property_ID);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($row = $result->fetch_assoc()) {

				// Return mapped fields
				return $this->respond([
					'BLK'                     => $row['BLOCK NUMBER'] ?? '',
					'survey'                  => $row['SURVEY NUMBER'] ?? '',
					'title_type'              => $row['OCT/TCT/CLOA NUMBER'] ?? '',
					'lot_no'                  => $row['CADASTRAL LOT NUMBER'] ?? '',
					'owner_name'              => $row['NAME OF OWNER'] ?? '',
					'owner_address'           => $row['ADDRESS OF OWNER'] ?? '',
					'owner_tin'               => $row['TIN OWNER'] ?? '',
					'owner_no'                => $row['TELNO OWNER'] ?? '',
					'admin_name'              => $row['NAME OF ADMINISTRATOR'] ?? '',
					'admin_address'           => $row['ADDRESS OF ADMINISTRATOR'] ?? '',
					'admin_no'                => $row['TELNO ADMIN'] ?? '',
					'street_no'               => $row['NUMBER STREET'] ?? '',
					'property_brgy'           => $row['LOCATION OF PROPERTY'] ?? '',
					'property_municipality'   => $row['MUNICIPALITY CODE'] ?? '',
					'northern'                => $row['NORTHERN BOUNDARIES'] ?? '',
					'eastern'                 => $row['EASTERN BOUNDARIES'] ?? '',
					'southern'                => $row['SOUTHERN BOUNDARIES'] ?? '',
					'western'                 => $row['WESTERN BOUNDARIES'] ?? '',
					'admin_tin'               => $row['TIN ADMIN'] ?? '',
					'previous_pin'            => $row['PIN'] ?? '',
					'previous_td_no'          => $row['TAX DECLARATION NUMBER'] ?? '',
					'previous_effectivity'    => $row['DATE OF EFFECTIVITY'] ?? '',
					'previous_assessed_value' => $row['TAXABLE ASSESSED VALUE'] ?? '',
					'north'                   => $row['NORTH'] ?? '',
					'east'                    => $row['EAST'] ?? '',
					'south'                   => $row['SOUTH'] ?? '',
					'west'                    => $row['WEST'] ?? '',
					'previous_ARP_no'         => $row['TAX DECLARATION NUMBER'] ?? '', // duplicate column, check if correct
					'property_ID'             => $row['property_ID'] ?? '',
					'brgy_code'             => $row['brgy_code'] ?? '',
					'revision_code'             => 'GR',
				]);
			} else {

				return $this->respond(['error' => 'No record found. Please Contact the Administrator.']);
			}
		}
	}

	// Function to insert into property_history
	function insert_property_history($action, $target_table, $record_id, $description, $db_update)
	{
		if (!isset($_SESSION['user_ID'])) {
			return $this->respond(['error' => 'Unauthorized. Please log in.']);
		}
		$ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

		$data = [
			'user_id'      => $_SESSION['user_ID'],
			'action'       => $action,
			'target_table' => $target_table,
			'record_id'    => $record_id,
			'description'  => $description,
			'db_update'    => $db_update,
			'ip_address'   => $ip_address
		];

		$stmt = $this->prepareInsert("property_history", $data);

		if (!$stmt->execute()) {
			error_log("Failed to insert user history: " . $stmt->error);
		}
	}

	function insert_user()
	{
		if (!isset($_SESSION['user_ID'])) {
			return $this->respond(['error' => 'Unauthorized. Please log in.']);
		}
		$name = $_POST['name'];
		$team = $_POST['team'];
		$department = $_POST['department'];
		$role = $_POST['role'];
		$username = $_POST['username'];
		$password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
		$date_created = date('Y-m-d H:i:s');
		$status = 0;
		$user_ID = $_POST['user_ID'] ?? null;
		$assigned_municipal = "";

		if (!empty($_POST['municipalities'])) {
			$assigned_municipal = implode(",", $_POST['municipalities']);
		}

		// Handle file upload
		$picture = "";
		if (!empty($_FILES["picture"]["name"])) {
			$targetDir = "../php/uploads/";
			if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

			$fileName = time() . "_" . basename($_FILES["picture"]["name"]);
			$targetFilePath = $targetDir . $fileName;

			if (move_uploaded_file($_FILES["picture"]["tmp_name"], $targetFilePath)) {
				$picture = $fileName;
			}
		}

		if ($user_ID) {
			// ✅ Update existing user
			$sql = "UPDATE user 
                SET name=?, team=?, department=?, role=?, 
                    username=?, assigned_municipal=?";

			// only update password if provided
			if ($password) {
				$sql .= ", password=?";
			}

			// only update picture if uploaded
			if ($picture) {
				$sql .= ", picture=?";
			}

			$sql .= " WHERE user_ID=?";

			$stmt = $this->db->prepare($sql);

			if ($password && $picture) {
				$stmt->bind_param("ssssssssi", $name, $team, $department, $role, $username, $assigned_municipal, $password, $picture, $user_ID);
			} elseif ($password) {
				$stmt->bind_param("sssssssi", $name, $team, $department, $role, $username, $assigned_municipal, $password, $user_ID);
			} elseif ($picture) {
				$stmt->bind_param("sssssssi", $name, $team, $department, $role, $username, $assigned_municipal, $picture, $user_ID);
			} else {
				$stmt->bind_param("ssssssi", $name, $team, $department, $role, $username, $assigned_municipal, $user_ID);
			}

			if ($stmt->execute()) {
				echo 'User updated successfully!';
			}
		} else {
			// ✅ Insert new user
			$sql = "INSERT INTO user (name, team, department, role, picture, status, username, password, date_created, assigned_municipal) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

			$stmt = $this->db->prepare($sql);
			$stmt->bind_param("ssssssssss", $name, $team, $department, $role, $picture, $status, $username, $password, $date_created, $assigned_municipal);

			if ($stmt->execute()) {
				echo 'User added successfully!';
			}
		}
	}

	function delete_property()
	{
		if (!isset($_SESSION['user_ID'])) {
			return $this->respond(['error' => 'Unauthorized. Please log in.']);
		}
		$id = $_POST['id'] ?? null;

		if (!$id) {
			echo "❌ Invalid ID";
			return;
		}

		try {
			// Check if property_ID exists FIRST
			$check = $this->db->prepare("SELECT property_ID FROM property_info WHERE property_ID = ? LIMIT 1");
			$check->bind_param("i", $id);
			$check->execute();
			$result = $check->get_result();

			if ($result->num_rows === 0) {
				echo "❌ Property does not exist";
				return;
			}

			// Start transaction
			$this->db->begin_transaction();

			// Delete from property_info
			$stmt = $this->db->prepare("DELETE FROM property_info WHERE property_ID = ?");
			$stmt->bind_param("i", $id);
			$stmt->execute();

			// Optional: ensure delete really happened
			if ($stmt->affected_rows === 0) {
				throw new Exception("Delete failed or already removed.");
			}

			// Delete related history
			$stmt2 = $this->db->prepare("DELETE FROM property_history WHERE record_id = ? AND target_table = 'property_info'");
			$stmt2->bind_param("i", $id);
			$stmt2->execute();

			// Only update if actually referenced
			$stmt3 = $this->db->prepare("
            UPDATE `property information`
            SET `revised_property_ID` = NULL
            WHERE `revised_property_ID` = ?
        ");
			$stmt3->bind_param("i", $id);
			$stmt3->execute();

			// Commit everything
			$this->db->commit();

			echo "✅ Property and history deleted successfully!";
		} catch (Exception $e) {
			$this->db->rollback();
			echo "❌ Error: " . $e->getMessage();
		}
	}


	function save_land()
	{
		if (!isset($_SESSION['user_ID'])) {
			return $this->respond(['error' => 'Unauthorized. Please log in.']);
		}
		try {
			$this->db->begin_transaction();

			$property_ID     = $_POST['property_ID'] ?? '';
			$total_land_area = $_POST['total_land_area'] ?? 0;
			$total_land_mv   = $_POST['total_land_mv'] ?? 0;

			if (!$property_ID) {
				throw new Exception("Missing property_ID");
			}

			$agri_class   = $_POST['agri_class'] ?? [];
			$sub_classes  = $_POST['sub_class'] ?? [];
			$areas        = $_POST['area_land'] ?? [];
			$unit_values  = $_POST['unit_value_land'] ?? [];
			$bmvs         = $_POST['market_value_land'] ?? [];

			/*
        |--------------------------------------------------------------------------
        | Get existing records (for history)
        |--------------------------------------------------------------------------
        */
			$oldRows = [];

			$stmtOld = $this->db->prepare("
            SELECT
                class,
                sub_class,
                area_land,
                unit_value_land,
                market_value_land
            FROM agricultural_info
            WHERE property_ID = ?
            ORDER BY agri_ID
        ");

			$stmtOld->bind_param("i", $property_ID);
			$stmtOld->execute();

			$result = $stmtOld->get_result();

			while ($row = $result->fetch_assoc()) {
				$oldRows[] = $row;
			}

			$stmtOld->close();

			$count  = count($oldRows);
			$action = ($count > 0) ? "update" : "insert";
			$mode   = ($count > 0) ? "Updated" : "Inserted";

			/*
        |--------------------------------------------------------------------------
        | Delete old rows if updating
        |--------------------------------------------------------------------------
        */
			if ($count > 0) {
				$delete = $this->db->prepare("
                DELETE FROM agricultural_info
                WHERE property_ID = ?
            ");

				$delete->bind_param("i", $property_ID);
				$delete->execute();
				$delete->close();
			}

			/*
        |--------------------------------------------------------------------------
        | Insert new rows
        |--------------------------------------------------------------------------
        */
			$stmt = $this->db->prepare("
            INSERT INTO agricultural_info
            (
                property_ID,
                class,
                sub_class,
                area_land,
                unit_value_land,
                market_value_land
            )
            VALUES (?, ?, ?, ?, ?, ?)
        ");

			$inserted = 0;
			$newRows  = [];

			for ($i = 0; $i < count($agri_class); $i++) {

				$stmt->bind_param(
					"issddd",
					$property_ID,
					$agri_class[$i],
					$sub_classes[$i],
					$areas[$i],
					$unit_values[$i],
					$bmvs[$i]
				);

				if (!$stmt->execute()) {
					throw new Exception($stmt->error);
				}

				$inserted++;

				$newRows[] = [
					'class'             => $agri_class[$i],
					'sub_class'         => $sub_classes[$i],
					'area_land'         => $areas[$i],
					'unit_value_land'   => $unit_values[$i],
					'market_value_land' => $bmvs[$i]
				];
			}

			$stmt->close();

			/*
        |--------------------------------------------------------------------------
        | Update valuation summary
        |--------------------------------------------------------------------------
        */
			$summary = $this->db->prepare("
            INSERT INTO property_valuation_summary
            (
                property_ID,
                total_land_area,
                total_land_mv
            )
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE
                total_land_area = VALUES(total_land_area),
                total_land_mv   = VALUES(total_land_mv)
        ");

			$summary->bind_param(
				"idd",
				$property_ID,
				$total_land_area,
				$total_land_mv
			);

			if (!$summary->execute()) {
				throw new Exception($summary->error);
			}

			$summary->close();

			/*
        |--------------------------------------------------------------------------
        | Create history JSON
        |--------------------------------------------------------------------------
        */
			$db_update = json_encode([
				'old' => $oldRows,
				'new' => $newRows,
				'summary' => [
					'total_land_area' => $total_land_area,
					'total_land_mv'   => $total_land_mv
				]
			], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

			/*
        |--------------------------------------------------------------------------
        | Save Property History
        |--------------------------------------------------------------------------
        */
			$this->insert_property_history(
				$action,

				$property_ID,
				"agricultural_info",
				'',
				$db_update
			);

			/*
        |--------------------------------------------------------------------------
        | Commit
        |--------------------------------------------------------------------------
        */
			$this->db->commit();

			echo json_encode([
				"success"  => true,
				"action"   => $action,
				"inserted" => $inserted,
				"message"  => "$mode $inserted land record(s)."
			]);
		} catch (Throwable $e) {

			$this->db->rollback();

			echo json_encode([
				"success" => false,
				"message" => $e->getMessage()
			]);
		}
	}
}
