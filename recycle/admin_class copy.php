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
			$data[$field] = $_POST[$field] ?? '';
		}
		$data['ID_2022'] = $ID_2022;
		$data['version'] = $_SESSION['version'];
		$data['recording_person'] = $_SESSION['name'];
		$data['recording_date'] = date('Y-m-d H:i:s');

		if (!$new_property_ID) {
			$stmt = $this->prepareInsert("faas_property", $data);
		} {
			$stmt = $this->prepareInsert("faas_property", $data);
		}



		if ($stmt->execute()) {
			$record_id = $stmt->insert_id;
			$action = 'insert';
			$target_table = "faas_property";
			$description;

			echo "✅ FAAS Property inserted successfully!";

			// Insert into history
			$this->insert_user_history(
				$action,
				$target_table,
				$record_id,
				$description
			);

			if (!empty($_POST['property_ID'])) {
				$this->update_property_status($_POST['property_ID'], $record_id);
			}
		} else {
			echo "❌ Error: " . $stmt->error;
		}
	}

	function update_property_status($property_ID, $record_id)
	{
		$sql = "UPDATE `property information` 
            SET `faas_ID` = ?
            WHERE `property_ID` = ?";
		$stmt = $this->db->prepare($sql);

		if ($stmt) {
			$stmt->bind_param("ii", $record_id, $property_ID);
			if ($stmt->execute()) {
				echo "✅ property_information updated" . $record_id;
			} else {
				echo "❌ Failed to update property_information: " . $stmt->error;
			}
		} else {
			echo "❌ SQL Prepare failed: " . $this->db->error;
		}
	}

	function edit_property()
	{
		$description = $_POST['description'] ?? '';
		$faas_id = $_POST['faas_id'] ?? null;
		if (!$faas_id) {
			echo "❌ FAAS_ID required";
			return;
		}

		$data = [];
		foreach ($this->propertyFields as $field) {

			$data[$field] = $_POST[$field] ?? '';
		}
		// $data['status'] = "active";
		// $data['version'] = 1;

		$stmt = $this->prepareUpdate("faas_property", $data, "FAAS_ID", $faas_id);

		if ($stmt->execute()) {
			$record_id = $faas_id;
			$action = 'update';
			$target_table = "faas_property";
			$description;

			echo "✅ Property updated successfully!";

			// Insert into history
			$this->insert_user_history(
				$action,
				$target_table,
				$record_id,
				$description
			);
		} else {
			echo "❌ Error: " . $stmt->error;
		}
	}

	function get_property_revised()
	{
		$faas_id = $_GET['faas_id'] ?? null;
		$old_property_ID = $_GET['old_property_ID'] ?? null;

		if (!$faas_id && !$old_property_ID) {
			return $this->respond(['error' => 'Contact the developer.']);
		}

		if ($faas_id) {
			$stmt = $this->db->prepare("SELECT * FROM `faas_property` WHERE `FAAS_ID` = ? LIMIT 1");
			$stmt->bind_param("i", $faas_id);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($row = $result->fetch_assoc()) {
				return $this->respond($this->rowToJson($row, $this->propertyFields));
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
				return $this->respond($this->rowToJson($row, $this->propertyFields));
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
		$id = $_POST['id'];

		if (!$id) {
			echo "❌ Invalid ID";
			return;
		}

		// Start transaction (so both deletes succeed or fail together)
		$this->db->begin_transaction();

		try {
			// Delete from faas_property
			$stmt = $this->db->prepare("DELETE FROM faas_property WHERE FAAS_ID = ?");
			$stmt->bind_param("i", $id);
			$stmt->execute();

			// Delete related user_history records
			$stmt2 = $this->db->prepare("DELETE FROM user_history WHERE record_id = ? AND target_table = 'faas_property'");
			$stmt2->bind_param("i", $id);
			$stmt2->execute();

			// Commit
			$this->db->commit();

			echo "✅ Property and history deleted successfully!";
		} catch (Exception $e) {
			// Rollback if error
			$this->db->rollback();
			echo "❌ Error: " . $e->getMessage();
		}
	}

	function save_land()
	{
		$property_ID = 1232;
		$rows = json_decode($_POST['rows'], true);

		if (!is_array($rows) || empty($rows)) {
			echo "No valid data received.";
			exit;
		}

		$stmt = $this->db->prepare("INSERT INTO land (property_ID, class, sub_class, unit_value_land, market_value_land) VALUES (?, ?, ?, ?, ?)");

		$inserted = 0;
		foreach ($rows as $r) {
			$class = $r['classification'];
			$sub_class = $r['sub_class'];
			$unit_value = floatval($r['unit_value']);
			$market_value = floatval($r['bmv']);
			$stmt->bind_param("issdd", $property_ID, $class, $sub_class, $unit_value, $market_value);
			if ($stmt->execute()) {
				$inserted++;
			}
		}

		$stmt->close();
		$this->db->close();

		echo "Successfully inserted $inserted record(s).";
	}
}
