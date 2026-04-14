<?php
header('Content-Type: application/json');

if (isset($_GET['pin_no']) && !empty($_GET['pin_no'])) {
    $pin_no = $_GET['pin_no'];
    $mun_code = $_GET['mun_code'];


    $db_path = realpath("C:/xampp/htdocs/antres/009040.accdb");

    if (!$db_path) {
        echo json_encode(['error' => 'Database file not found.']);
        exit;
    }

    $connStr = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$db_path;";

    try {
        $pdo = new PDO($connStr);


        if (!$pdo) {
            echo json_encode(['error' => 'Connection failed.']);
            exit;
        }

        // Query: use square brackets for MS Access fields and table
        $stmt = $pdo->prepare("
            SELECT 
                 *
            FROM [PROPERTY INFORMATION]
            WHERE [PIN] = ? 
        ");
        $stmt->execute([$pin_no]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
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
                'property_municipality'       => $row['LOCATION OF PROPERTY'] ?? '',
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
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'PIN number not provided']);
}


// [PIN], [NAME OF OWNER], [ADDRESS OF OWNER], [TIN OWNER], [TELNO OWNER],
//                 [NAME OF ADMINISTRATOR], [ADDRESS OF ADMINISTRATOR], [TELNO ADMIN], [TIN ADMIN], [LOCATION OF PROPERTY],
//                 [NORTHERN BOUNDARIES], [EASTERN BOUNDARIES], [SOUTHERN BOUNDARIES], [WESTERN BOUNDARIES], [NUMBER STREET],
//                 [BLOCK NUMBER], [CADASTRAL LOT NUMBER], [SURVEY NUMBER],
//                 [TAX DECLARATION NUMBER], [TAXABLE ASSESSED VALUE]