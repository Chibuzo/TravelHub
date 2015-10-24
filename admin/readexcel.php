<?php
if (!isset($_POST['submit_inventory']) && empty($_FILES['inventory_xls']))
	die ("I hope you like what you see, punk! Go upload a file and submit the form.");
	
ini_set('max_execution_time', 500);
require_once "../classes/PHPExcel/IOFactory.php";

$file = $_FILES['inventory_xls']['tmp_name'];

try {
    $inputFileType = PHPExcel_IOFactory::identify($file);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($file);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage());
}

$objWorksheet = $objPHPExcel->getActiveSheet();
require_once "../includes/db_handle.php";

echo "<table>";
//  Loop through each row of the worksheet in turn
$n = 0; $datarow = '';
$err = false;
foreach ($objWorksheet->getRowIterator() AS $row) {
	$field = array();
	++$n;
	if ($n == 1) continue;
	$cellIterator = $row->getCellIterator();
	
	$field = array();
	$fields = array();
	foreach($cellIterator AS $cell) {
		$field[] = $db->escapeString($cell);
	}
	
	// get the route id
	$route = trim($field[4], "'") . " - " . trim($field[5], "'");
	$db->query("SELECT id FROM routes WHERE route = '$route'");
	$data = $db->fetch('obj');
	if (empty($data->id)) {
		echo "The route $route is invalid. Correct any typo or add the route and continue.";
		$err = true;
		break;
	}	
	
	$fields[] = trim($field[0], "'"); // transport ID
	$fields[] = trim($field[2], "'"); // bus type
	$fields[] = trim($field[3], "'"); // number of seat
	$fields[] = substr($field[1], 1, -3); // get departure time
	$fields[] = strtoupper(substr($field[1], -3, 2)); // period
	$fields[] = $data->id; // route id
	$fields[] = trim($field[6], "'"); // terminal id
	$fields[] = trim($field[7], "'"); // fare
	
	$datarow .= "('{$fields[0]}', '{$fields[1]}', '{$fields[2]}', '{$fields[3]}', '{$fields[4]}', '{$fields[5]}', '{$fields[6]}', '{$fields[7]}'),";
}
$datarow = trim($datarow, ',');
$sql = "INSERT INTO buses 
		(travel_id, bus_type, seats, departure_time, period, route_id, terminal_id, fare)
		VALUES $datarow";

if ($err === false) {		
	if ($db->query($sql)) echo "Upload operation successful. Click <a href='inventory.php'>here</a> to go back";
} else {
	echo "Error occured";
}

?>