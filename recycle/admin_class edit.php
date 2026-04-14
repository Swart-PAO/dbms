<?php
session_start();
ini_set('display_errors', 1);

class Action
{
	private $db;

	// define all property fields once
	private $propertyFields = [
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
		"previous_effectivity",
		"status",
		"version"
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

	/* ------------------ METHODS ------------------ */

	function get_property_previous()
	{
		if (!isset($_GET['pin_no']) || empty($_GET['pin_no'])) {
			$this->respond(['error' => 'PIN number not provided']);
		}

		$pin_no   = $_GET['pin_no'];
		$mun_code = $_GET['mun_code'];

		$stmt = $this->db->prepare("SELECT * FROM `property information` WHERE `PIN` = ? AND `MUNICIPALITY CODE` = ? LIMIT 1");
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
			]);
		} else {
			$this->respond(['error' => 'No record found for this PIN No.']);
		}
	}

	function insert_property()
	{
		$data = [];
		foreach ($this->propertyFields as $field) {
			$data[$field] = $_POST[$field] ?? '';
		}
		$data['status'] = "active";
		$data['version'] = 1;

		$stmt = $this->prepareInsert("faas_property", $data);

		if ($stmt->execute()) {
			echo "✅ FAAS Property inserted successfully!";
		} else {
			echo "❌ Error: " . $stmt->error;
		}
	}

	function edit_property()
	{
		$faas_id = $_POST['faas_id'] ?? null;
		if (!$faas_id) {
			echo "❌ FAAS_ID required";
			return;
		}

		$data = [];
		foreach ($this->propertyFields as $field) {
			if ($field != "status" && $field != "version") {
				$data[$field] = $_POST[$field] ?? '';
			}
		}
		$data['status'] = "active";
		$data['version'] = 1;

		$stmt = $this->prepareUpdate("faas_property", $data, "FAAS_ID", $faas_id);

		if ($stmt->execute()) {
			echo "✅ Property updated successfully!";
		} else {
			echo "❌ Error: " . $stmt->error;
		}
	}

	function get_property_revised()
	{
		$faas_id = $_GET['faas_id'] ?? null;

		if (!$faas_id) {
			$this->respond(['error' => 'No FAAS_ID provided']);
		}

		$stmt = $this->db->prepare("SELECT * FROM `faas_property` WHERE `FAAS_ID` = ? LIMIT 1");
		$stmt->bind_param("i", $faas_id);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($row = $result->fetch_assoc()) {
			$this->respond($this->rowToJson($row, $this->propertyFields));
		} else {
			$this->respond(['error' => 'No record found']);
		}
	}
}
