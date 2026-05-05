<?php
session_start();
$_SESSION['version'] = 1;

ini_set('display_errors', 1);


class Action
{

	private $db;



	// define all property fields once
	private $propertyFields = [
		"FAAS_ID",
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
		"total_residential_mv",
		"total_residential_area"
	];

	public function __construct()
	{
		ob_start();
		include 'db_connect.php';
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

	function get_property_previous()
	{
		if (!isset($_GET['search_pin']) || empty($_GET['search_pin'])) {
			$this->respond(['error' => 'PIN number not provided']);
		}

		$pin_no   = $_GET['search_pin'];
		$mun_code = $_GET['mun_code'];

		$stmt = $this->db->prepare("SELECT * FROM `property information` WHERE `PIN` = ? AND `MUNICIPALITY CODE` = ? AND `faas_ID`=0 LIMIT 1");
		$stmt->bind_param("si", $pin_no, $mun_code);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($row = $result->fetch_assoc()) {
			echo json_encode([
				'BLK'     => $row['BLOCK NUMBER'] ?? '',
				'survey'  => $row['SURVEY NUMBER'] ?? '',
				'title_type'      => $row['OCT/TCT/CLOA NUMBER'] ?? '',
				'lot_no'      => $row['CADASTRAL LOT NUMBER'] ?? '',
				'owner_name'     => $row['NAME OF OWNER'] ?? '',
				'owner_address'  => $row['ADDRESS OF OWNER'] ?? '',
				'owner_tin'      => $row['TIN OWNER'] ?? '',
				'owner_no'       => $row['TELNO OWNER'] ?? '',
				'admin_name'     => $row['NAME OF ADMINISTRATOR'] ?? '',
				'admin_address'  => $row['ADDRESS OF ADMINISTRATOR'] ?? '',
				'admin_no'       => $row['TELNO ADMIN'] ?? '',
				'street_no'       => $row['NUMBER STREET'] ?? '',
				'property_brgy'       => $row['LOCATION OF PROPERTY'] ?? '',
				'property_municipality' => $row['LOCATION OF PROPERTY'] ?? '',
				'northern'       => $row['NORTHERN BOUNDARIES'] ?? '',
				'eastern'       => $row['EASTERN BOUNDARIES'] ?? '',
				'southern'       => $row['SOUTHERN BOUNDARIES'] ?? '',
				'western'       => $row['WESTERN BOUNDARIES'] ?? '',
				'admin_tin'      => $row['TIN ADMIN'] ?? '',
				'previous_pin'   => $row['PIN'] ?? '',
				'previous_td_no' => $row['TAX DECLARATION NUMBER'] ?? '',
				'previous_effectivity' => $row['DATE OF EFFECTIVITY'] ?? '',
				'previous_assessed_value' => $row['TAXABLE ASSESSED VALUE'] ?? '',
				'north' => $row['NORTH'] ?? '',
				'east' => $row['EAST'] ?? '',
				'south' => $row['SOUTH'] ?? '',
				'west' => $row['WEST'] ?? '',
				'previous_ARP_no'      => $row['TAX DECLARATION NUMBER'] ?? '',
				'property_ID'      => $row['property_ID'] ?? '',
			]);
		} else {
			$this->respond(['error' => 'No record found for this PIN No.']);
		}
	}

	function insert_property()
	{
		$description = $_POST['description'] ?? '';

		$new_property_ID = $_POST['input_new_property_ID'] ?? '';
		$ID_2022 = $_POST['input_old_property_ID'] ?? '';

		$data = [];
		foreach ($this->propertyFields as $field) {
			$data[$field] = $_POST[$field] ?? null;
		}

		try {

			$this->db->begin_transaction();
			if (empty($new_property_ID)) {


				$data['ID_2022'] = $ID_2022;
				$data['version'] = $_SESSION['version'] ?? null;
				$data['recording_person_ID'] = $_SESSION['user_ID'] ?? null;
				$data['recording_date'] = date('Y-m-d H:i:s');

				$stmt = $this->prepareInsert("faas_property", $data);
				$action = "insert";
			} else {

				unset($data['FAAS_ID']);
				$stmt = $this->prepareUpdate("faas_property", $data, "FAAS_ID", $new_property_ID);
				$action = "update";
				// $data_saved = "✅ Property updated successfully!";
			}

			if (!$stmt->execute()) {
				throw new Exception($stmt->error);
			}
			$record_id = $this->db->insert_id;

			if ($action === "update") {
				$record_id = $new_property_ID;
			}
			if ($ID_2022) {
				$this->update_property_status($ID_2022, $record_id);
			}


			$this->insert_user_history(
				$action,
				"faas_property",
				$record_id,
				$description
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
		$sql = "UPDATE `property information`
            SET `faas_ID` = ?
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
		$faas_id = $_GET['faas_id'] ?? null;
		$old_property_ID = $_GET['old_property_ID'] ?? null;
		$new_property_ID = $_GET['new_property_ID'] ?? null;

		if (!$new_property_ID && !$old_property_ID) {
			return $this->respond(['error' => 'Contact the developer.']);
		}

		if ($new_property_ID) {
			$stmt = $this->db->prepare("SELECT * FROM `faas_property` WHERE `FAAS_ID` = ? LIMIT 1");
			$stmt->bind_param("i", $new_property_ID);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($row = $result->fetch_assoc()) {
				$allFields = array_merge($this->propertyFields, $this->propertyFieldsMV);
				return $this->respond($this->rowToJson($row, $allFields));
			} else {
				return $this->respond(['error' => 'No record found']);
			}
		} elseif ($old_property_ID) {

			// FIRST QUERY
			$stmt = $this->db->prepare("SELECT * FROM `faas_property` WHERE `ID_2022` = ?");
			$stmt->bind_param("i", $old_property_ID);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($row = $result->fetch_assoc()) {

				// Record found in faas_property
				$allFields = array_merge($this->propertyFields, $this->propertyFieldsMV);
				return $this->respond($this->rowToJson($row, $allFields));
			} else {

				// SECOND QUERY
				$stmt = $this->db->prepare("SELECT * FROM `property information` WHERE `property_ID` = ? LIMIT 1");
				$stmt->bind_param("i", $old_property_ID);
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
					]);
				} else {

					return $this->respond(['error' => 'No record found']);
				}
			}
		}
	}

	// Function to insert into user_history
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

	function insert_user()
	{
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
			$targetDir = "php/uploads/";
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
				$action = 'update';
				$target_table = "user";
				$description = 'Updated User';

				$this->insert_user_history(
					$action,
					$target_table,
					$user_ID,
					$description
				);
			} else {
				echo "Error: " . $stmt->error;
			}
		} else {
			// ✅ Insert new user
			$sql = "INSERT INTO user (name, team, department, role, picture, status, username, password, date_created, assigned_municipal) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

			$stmt = $this->db->prepare($sql);
			$stmt->bind_param("ssssssssss", $name, $team, $department, $role, $picture, $status, $username, $password, $date_created, $assigned_municipal);

			if ($stmt->execute()) {
				echo 'User added successfully!';
				$record_id = $stmt->insert_id;
				$action = 'add';
				$target_table = "user";
				$description = 'New User';

				$this->insert_user_history(
					$action,
					$target_table,
					$record_id,
					$description
				);
			} else {
				echo "Error: " . $stmt->error;
			}
		}
	}

	function delete_property()
	{
		$id = $_POST['id'] ?? null;

		if (!$id) {
			echo "❌ Invalid ID";
			return;
		}

		try {
			// Check if FAAS_ID exists FIRST
			$check = $this->db->prepare("SELECT FAAS_ID FROM faas_property WHERE FAAS_ID = ? LIMIT 1");
			$check->bind_param("i", $id);
			$check->execute();
			$result = $check->get_result();

			if ($result->num_rows === 0) {
				echo "❌ Property does not exist";
				return;
			}

			// Start transaction
			$this->db->begin_transaction();

			// Delete from faas_property
			$stmt = $this->db->prepare("DELETE FROM faas_property WHERE FAAS_ID = ?");
			$stmt->bind_param("i", $id);
			$stmt->execute();

			// Optional: ensure delete really happened
			if ($stmt->affected_rows === 0) {
				throw new Exception("Delete failed or already removed.");
			}

			// Delete related history
			$stmt2 = $this->db->prepare("DELETE FROM user_history WHERE record_id = ? AND target_table = 'faas_property'");
			$stmt2->bind_param("i", $id);
			$stmt2->execute();

			// Only update if actually referenced
			$stmt3 = $this->db->prepare("
            UPDATE `property information`
            SET `faas_ID` = NULL
            WHERE `faas_ID` = ?
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

	// 	function edit_property()
	// {
	// 	$description = $_POST['description'] ?? '';
	// 	$faas_id = $_POST['faas_id'] ?? null;
	// 	if (!$faas_id) {
	// 		echo "❌ FAAS_ID required";
	// 		return;
	// 	}

	// 	$data = [];
	// 	foreach ($this->propertyFields as $field) {

	// 		$data[$field] = $_POST[$field] ?? '';
	// 	}
	// 	// $data['status'] = "active";
	// 	// $data['version'] = 1;

	// 	$stmt = $this->prepareUpdate("faas_property", $data, "FAAS_ID", $faas_id);

	// 	if ($stmt->execute()) {
	// 		$record_id = $faas_id;
	// 		$action = 'update';
	// 		$target_table = "faas_property";
	// 		$description;

	// 		echo "✅ Property updated successfully!";

	// 		// Insert into history
	// 		$this->insert_user_history(
	// 			$action,
	// 			$target_table,
	// 			$record_id,
	// 			$description
	// 		);
	// 	} else {
	// 		echo "❌ Error: " . $stmt->error;
	// 	}
	// }

	function save_land()
	{

		try {
			$this->db->begin_transaction();

			$property_ID = $_POST['property_ID'] ?? '';
			$total_land_area = $_POST['total_land_area'] ?? 0;

			if (!$property_ID) {
				throw new Exception("Missing property_ID");
			}

			$classifications = $_POST['classification'] ?? [];
			$sub_classes     = $_POST['sub_class'] ?? [];
			$areas           = $_POST['area_land'] ?? [];
			$unit_values     = $_POST['unit_value_land'] ?? [];
			$bmvs            = $_POST['market_value_land'] ?? [];

			// 1️⃣ CHECK IF PROPERTY ALREADY EXISTS
			$check = $this->db->prepare("SELECT COUNT(*) FROM land WHERE property_ID = ?");
			$check->bind_param("i", $property_ID);
			$check->execute();
			$check->bind_result($count);
			$check->fetch();
			$check->close();

			if ($count > 0) {
				// 2️⃣ DELETE OLD ROWS
				$delete = $this->db->prepare("DELETE FROM land WHERE property_ID = ?");
				$delete->bind_param("i", $property_ID);
				$delete->execute();
				$delete->close();

				$mode = "Updated";
			} else {
				$mode = "Inserted";
			}

			// 3️⃣ INSERT LAND RECORDS
			$stmt = $this->db->prepare("
            INSERT INTO land
            (property_ID, class, sub_class, area_land, unit_value_land, market_value_land)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

			$inserted = 0;

			for ($i = 0; $i < count($classifications); $i++) {
				$stmt->bind_param(
					"issddd",
					$property_ID,
					$classifications[$i],
					$sub_classes[$i],
					$areas[$i],
					$unit_values[$i],
					$bmvs[$i]
				);

				$stmt->execute();
				$inserted++;
			}
			$stmt->close();

			// 4️⃣ UPDATE TOTAL LAND AREA
			$update = $this->db->prepare("
            UPDATE faas_property
            SET total_land_area = ?
            WHERE FAAS_ID = ?
        ");
			$update->bind_param("di", $total_land_area, $property_ID);
			$update->execute();
			$update->close();

			// 5️⃣ COMMIT IF ALL SUCCESS
			$this->db->commit();

			echo "$mode $inserted land record(s). Total Area: $total_land_area";
		} catch (Throwable $e) {
			// ❌ ROLLBACK ON ANY ERROR
			$this->db->rollback();

			http_response_code(500);
			echo "Database Error: " . $e->getMessage();
		}
	}
}
