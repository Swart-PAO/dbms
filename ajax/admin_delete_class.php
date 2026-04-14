<?php
session_start();
ini_set('display_errors', 1);


class Action
{

	private $db;


	public function __construct()
	{
		ob_start();
		include '../db_connect.php';
		$this->db = $conn;
	}

	function __destruct()
	{
		$this->db->close();
		ob_end_flush();
	}

	function delete_user()
	{
		$user_id = $_POST['user_id'];
		// First, get the user record
		$sql = "SELECT * FROM user WHERE user_ID = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("i", $user_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$user = $result->fetch_assoc();

		if (!$user) {
			echo "❌ User not found!";
			return;
		}

		// Delete picture file if exists
		if (!empty($user['picture'])) {
			$filePath = "../php/uploads/" . $user['picture'];
			if (file_exists($filePath)) {
				unlink($filePath); // delete the file
			}
		}

		// Delete the user from DB
		$sql = "DELETE FROM user WHERE user_ID = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("i", $user_id);

		if ($stmt->execute()) {
			echo "✅ User deleted successfully!";

			// // Insert into history
			// $action = 'delete';
			// $target_table = 'user';
			// $record_id = $user_id;
			// $description = "Deleted User: " . $user['name'];

			// $this->insert_user_history(
			// 	$action,
			// 	$target_table,
			// 	$record_id,
			// 	$description
			// );
		} else {
			echo "❌ Error deleting user: " . $stmt->error;
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
}
