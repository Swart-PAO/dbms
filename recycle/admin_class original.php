<?php
session_start();
ini_set('display_errors', 1);
class Action
{
	private $db;

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

	function get_property_previous()
	{

		if (isset($_GET['pin_no']) && !empty($_GET['pin_no'])) {
			$pin_no   = $_GET['pin_no'];
			$mun_code = $_GET['mun_code'];

			// if ($this->db->connect_error) {
			// 	echo json_encode(['error' => 'Connection failed: ' . $this->db>connect_error]);
			// 	exit;
			// }
			$stmt = $this->db->prepare("SELECT * FROM `property information` WHERE `PIN` = ? AND `MUNICIPALITY CODE` = ? LIMIT 1");

			$stmt->bind_param("si", $pin_no, $mun_code); // "s" = string, "i" = integer

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
				echo json_encode(['error' => 'No record found for this PIN No.']);
			}
		} else {
			echo json_encode(['error' => 'PIN number not provided']);
		}
	}

	function insert_property()
	{
		// Collect POST safely
		$transaction_code      = $_POST['transaction_code'] ?? '';
		$ARP_no                = $_POST['ARP_no'] ?? '';
		$title_type            = $_POST['title_type'] ?? '';
		$title_dated           = $_POST['title_dated'] ?? '';
		$PIN_no                = $_POST['input_pin_no'] ?? '';
		$survey                = $_POST['survey'] ?? '';
		$lot_no                = $_POST['lot_no'] ?? '';
		$BLK                   = $_POST['BLK'] ?? '';
		$owner_name            = $_POST['owner_name'] ?? '';
		$owner_address         = $_POST['owner_address'] ?? '';
		$owner_no              = $_POST['owner_no'] ?? '';
		$owner_tin             = $_POST['owner_tin'] ?? '';
		$admin_name            = $_POST['admin_name'] ?? '';
		$admin_address         = $_POST['admin_address'] ?? '';
		$admin_no              = $_POST['admin_no'] ?? '';
		$admin_tin             = $_POST['admin_tin'] ?? '';
		$street_no             = $_POST['street_no'] ?? '';
		$property_brgy         = $_POST['property_brgy'] ?? '';
		$property_municipality = $_POST['property_municipality'] ?? '';
		$property_province     = $_POST['property_province'] ?? '';
		$north                 = $_POST['north'] ?? '';
		$east                  = $_POST['east'] ?? '';
		$south                 = $_POST['south'] ?? '';
		$west                  = $_POST['west'] ?? '';
		$northern              = $_POST['northern'] ?? '';
		$eastern               = $_POST['eastern'] ?? '';
		$southern              = $_POST['southern'] ?? '';
		$western               = $_POST['western'] ?? '';
		$previous_pin          = $_POST['previous_pin'] ?? '';
		$previous_ARP_no       = $_POST['previous_ARP_no'] ?? '';
		$previous_td_no        = $_POST['previous_td_no'] ?? '';
		$previous_assessed_value = $_POST['previous_assessed_value'] ?? '';
		$previous_owner        = $_POST['previous_owner'] ?? '';
		$previous_effectivity  = $_POST['previous_effectivity'] ?? '';

		// Defaults
		$status = "active";
		$version = 1;

		// Insert query
		$sql = "INSERT INTO `faas_property` (
            `transaction_code`, `ARP_no`, `title_type`, `title_dated`, `PIN_no`, `survey`, `lot_no`, `BLK`,
            `owner_name`, `owner_address`, `owner_no`, `owner_tin`,
            `admin_name`, `admin_address`, `admin_no`, `admin_tin`,
            `street_no`, `property_brgy`, `property_municipality`, `property_province`,
            `north`, `east`, `south`, `west`, `northern`, `eastern`, `southern`, `western`,
            `previous_pin`, `previous_ARP_no`, `previous_td_no`, `previous_assessed_value`,
            `previous_owner`, `previous_effectivity`, `status`, `version`
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

		$stmt = $this->db->prepare($sql);
		if (!$stmt) {
			die("Prepare failed: " . $this->db->error);
		}

		$stmt->bind_param(
			"sssssssssssssssssssssssssssssssssssi",
			$transaction_code,
			$ARP_no,
			$title_type,
			$title_dated,
			$PIN_no,
			$survey,
			$lot_no,
			$BLK,
			$owner_name,
			$owner_address,
			$owner_no,
			$owner_tin,
			$admin_name,
			$admin_address,
			$admin_no,
			$admin_tin,
			$street_no,
			$property_brgy,
			$property_municipality,
			$property_province,
			$north,
			$east,
			$south,
			$west,
			$northern,
			$eastern,
			$southern,
			$western,
			$previous_pin,
			$previous_ARP_no,
			$previous_td_no,
			$previous_assessed_value,
			$previous_owner,
			$previous_effectivity,
			$status,
			$version
		);

		if ($stmt->execute()) {
			echo "✅ FAAS Property inserted successfully!";
		} else {
			echo "❌ Error: " . $stmt->error;
		}
	}

	function edit_property()
	{
		$faas_id             = $_POST['faas_id'] ?? null;
		$transaction_code      = $_POST['transaction_code'] ?? '';
		$ARP_no                = $_POST['ARP_no'] ?? '';
		$title_type            = $_POST['title_type'] ?? '';
		$title_dated           = $_POST['title_dated'] ?? '';
		$PIN_no                = $_POST['input_pin_no'] ?? '';
		$survey                = $_POST['survey'] ?? '';
		$lot_no                = $_POST['lot_no'] ?? '';
		$BLK                   = $_POST['BLK'] ?? '';
		$owner_name            = $_POST['owner_name'] ?? '';
		$owner_address         = $_POST['owner_address'] ?? '';
		$owner_no              = $_POST['owner_no'] ?? '';
		$owner_tin             = $_POST['owner_tin'] ?? '';
		$admin_name            = $_POST['admin_name'] ?? '';
		$admin_address         = $_POST['admin_address'] ?? '';
		$admin_no              = $_POST['admin_no'] ?? '';
		$admin_tin             = $_POST['admin_tin'] ?? '';
		$street_no             = $_POST['street_no'] ?? '';
		$property_brgy         = $_POST['property_brgy'] ?? '';
		$property_municipality = $_POST['property_municipality'] ?? '';
		$property_province     = $_POST['property_province'] ?? '';
		$north                 = $_POST['north'] ?? '';
		$east                  = $_POST['east'] ?? '';
		$south                 = $_POST['south'] ?? '';
		$west                  = $_POST['west'] ?? '';
		$northern              = $_POST['northern'] ?? '';
		$eastern               = $_POST['eastern'] ?? '';
		$southern              = $_POST['southern'] ?? '';
		$western               = $_POST['western'] ?? '';
		$previous_pin          = $_POST['previous_pin'] ?? '';
		$previous_ARP_no       = $_POST['previous_ARP_no'] ?? '';
		$previous_td_no        = $_POST['previous_td_no'] ?? '';
		$previous_assessed_value = $_POST['previous_assessed_value'] ?? '';
		$previous_owner        = $_POST['previous_owner'] ?? '';
		$previous_effectivity  = $_POST['previous_effectivity'] ?? '';

		// Defaults
		$status = "active";
		$version = 1;

		// Insert query
		$sql = "UPDATE `faas_property`  SET 
            `transaction_code` = ?, 
            `ARP_no` = ?, 
            `title_type` = ?, 
            `title_dated` = ?, 
            `PIN_no` = ?, 
            `survey` = ?, 
            `lot_no` = ?, 
            `BLK` = ?, 
            `owner_name` = ?, 
            `owner_address` = ?, 
            `owner_no` = ?, 
            `owner_tin` = ?, 
            `admin_name` = ?, 
            `admin_address` = ?, 
            `admin_no` = ?, 
            `admin_tin` = ?, 
            `street_no` = ?, 
            `property_brgy` = ?, 
            `property_municipality` = ?, 
            `property_province` = ?, 
            `north` = ?, 
            `east` = ?, 
            `south` = ?, 
            `west` = ?, 
            `northern` = ?, 
            `eastern` = ?, 
            `southern` = ?, 
            `western` = ?, 
            `previous_pin` = ?, 
            `previous_ARP_no` = ?, 
            `previous_td_no` = ?, 
            `previous_assessed_value` = ?, 
            `previous_owner` = ?, 
            `previous_effectivity` = ?, 
            `status` = ?, 
            `version` = ?
        WHERE `FAAS_ID` = ?;";

		$stmt = $this->db->prepare($sql);
		if (!$stmt) {
			die("Prepare failed: " . $this->db->error);
		}

		$stmt->bind_param(
			"sssssssssssssssssssssssssssssssssssii",
			$transaction_code,
			$ARP_no,
			$title_type,
			$title_dated,
			$PIN_no,
			$survey,
			$lot_no,
			$BLK,
			$owner_name,
			$owner_address,
			$owner_no,
			$owner_tin,
			$admin_name,
			$admin_address,
			$admin_no,
			$admin_tin,
			$street_no,
			$property_brgy,
			$property_municipality,
			$property_province,
			$north,
			$east,
			$south,
			$west,
			$northern,
			$eastern,
			$southern,
			$western,
			$previous_pin,
			$previous_ARP_no,
			$previous_td_no,
			$previous_assessed_value,
			$previous_owner,
			$previous_effectivity,
			$status,
			$version,
			$faas_id
		);

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
			echo json_encode(['error' => 'No FAAS_ID provided']);
			exit;
		}

		$stmt = $this->db->prepare("SELECT * FROM `faas_property` WHERE `FAAS_ID` = ? LIMIT 1");
		$stmt->bind_param("i", $faas_id);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($row = $result->fetch_assoc()) {
			echo json_encode([
				'BLK'     => $row['BLK'] ?? '',
				'survey'  => $row['survey'] ?? '',
				'title_type' => $row['title_type'] ?? '',
				'lot_no'  => $row['lot_no'] ?? '',
				'owner_name' => $row['owner_name'] ?? '',
				'owner_address' => $row['owner_address'] ?? '',
				'owner_tin' => $row['owner_tin'] ?? '',
				'owner_no' => $row['owner_no'] ?? '',
				'admin_name' => $row['admin_name'] ?? '',
				'admin_address' => $row['admin_address'] ?? '',
				'admin_no' => $row['admin_no'] ?? '',
				'street_no' => $row['street_no'] ?? '',
				'property_brgy' => $row['property_brgy'] ?? '',
				'property_municipality' => $row['property_municipality'] ?? '', // maybe split later
				'northern' => $row['northern'] ?? '',
				'eastern' => $row['eastern'] ?? '',
				'southern' => $row['southern'] ?? '',
				'western' => $row['western'] ?? '',
				'admin_tin' => $row['admin_tin'] ?? '',
				'previous_pin' => $row['previous_pin'] ?? '',
				'previous_td_no' => $row['previous_td_no'] ?? '',
				'previous_effectivity' => $row['previous_effectivity'] ?? '',
				'previous_assessed_value' => $row['previous_assessed_value'] ?? '',
				'north' => $row['north'] ?? '',
				'east' => $row['east'] ?? '',
				'south' => $row['south'] ?? '',
				'west' => $row['west'] ?? '',
				'previous_ARP_no' => $row['previous_ARP_no'] ?? ''
			]);
		} else {
			echo json_encode(['error' => 'No record found']);
		}
	}
}
