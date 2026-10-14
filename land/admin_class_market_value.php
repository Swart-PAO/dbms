<?php

class ActionMarketValue
{

	private $db;



	// public function __construct()
	// {
	// 	ob_start();

	// 	require_once __DIR__ . '/../config.php';
	// 	require_once ROOT_PATH . '/db/db_connect.php';
	// 	$this->db = $conn;
	// }

	// function __destruct()
	// {
	// 	$this->db->close();
	// 	ob_end_flush();
	// }

	/* ------------------ UTILITIES ------------------ */

	private function respond($data)
	{
		header('Content-Type: application/json');
		echo json_encode($data);
		exit;
	}


	private function rowToJson($row, $fields)
	{
		$data = [];
		foreach ($fields as $field) {
			$data[$field] = $row[$field] ?? '';
		}
		return $data;
	}
}
