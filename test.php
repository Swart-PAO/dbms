<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Load the existing Excel file
$inputFile = 'faas.xlsx';
$spreadsheet = IOFactory::load($inputFile);

// Select the sheet named "front"
$sheet = $spreadsheet->getSheetByName('f');

// Check if the sheet exists
if ($sheet === null) {
    die("❌ Sheet named 'front' not found in $inputFile");
}

// Set value in cell B7
$sheet->setCellValue('B7', 'Your PHP Value Here');

// Save changes back to the same file (overwrite)
$writer = new Xlsx($spreadsheet);
$writer->save($inputFile);

echo "✅ Value successfully written to sheet 'front' cell B7!";
