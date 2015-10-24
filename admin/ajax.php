<?php
require_once("../includes/db_handle.php");

if ($_REQUEST['op'] == 'mapped') {
	$state = $db->escapeString($_GET['state']);
	$sql = "SELECT id, route_code FROM routes WHERE route LIKE '$state%'";
	$db->query($sql);
	$html = "";
	foreach ($db->stmt AS $row) {
		$route = splitRouteMap($row['route_code']);
				
		# Continue...
		$html .= "<div id='{$row['route_code']}'> >> {$route['destination']}<span>
		<input type='text' id='travel_{$row['id']}' class='add_route' style='margin-top:-5px' /> <input type='button' class='add_travel btn btn-small' value='Ok' style='margin-top:-12px' />
		<a class='remove_state' id='{$row['id']}' href='#'>X</a></span></div>\n";
	}
	echo $html;
}
elseif ($_REQUEST['op'] == 'add_route') echo addRoute();

elseif ($_REQUEST['op'] == 'remove_map')
{
	$id = $_REQUEST['map_id'];
	$db->query("DELETE FROM routes WHERE id = '$id'");
}
elseif ($_REQUEST['op'] == "add_route_to_travel")
{
	$route = $_POST['route_code'];
	$travel = $_POST['travel_id'];
	$route = $route . " ";
	$sql = "UPDATE travels SET route_code = CONCAT(route_code, '$route') WHERE id = '$travel'";
	$db->query($sql);
}
elseif ($_REQUEST['op'] == 'add_bus')
{
	$sql = "INSERT INTO buses (travel_id, bus_type, amenities, route_id, seats, departure_time, terminal_id, period, fare, child_fare) VALUES
	('{$_POST['travel']}', '{$_POST['bus_type']}', '{$_POST['amenities']}', '{$_POST['route']}', '{$_POST['seats']}', '{$_POST['departure_time']}', '{$_POST['terminal_id']}', '{$_POST['period']}', '{$_POST['fare']}', '{$_POST['child_fare']}')";
	if ($db->query($sql))
		echo "done";
}
elseif ($_REQUEST['op'] == 'edit-buses')
{
	echo displayBuses();
}
elseif ($_REQUEST['op'] == 'remove-bus')
{
	removeBus();
}
elseif ($_REQUEST['op'] == 'remove_booking')
{
	removeBooking();
}
elseif ($_REQUEST['op'] == 'add_special_route')
{
	addSpecialRoute();
}
elseif ($_REQUEST['op'] == 'remove_charter')
{
	removeCharter();
}



function displayBuses() {
	global $db;
	
	$sql = "SELECT b.*, company_name, route FROM buses AS b
			JOIN travels AS t ON t.id = b.travel_id
			JOIN routes AS r ON r.route_code = b.route_code
			ORDER BY travel_id";
	$db->query($sql);
	$html_tbl = "<table class='table table-striped table-bordered' style='wdth:75%; padding:0px'>
			<thead>
				<tr>
					<th>Travel</th>
					<th>Route</th>
					<th>Bus type</th>
					<th>Amenities</th>
					<th>Seats</th>
					<th>Terminal</th>
					<th>Time</th>
					<th>Fare</th>
					<th colspan='2'>Action</th>
				</tr>
			</thead>
			<tbody>";
	foreach ($db->stmt AS $row) {
		extract($row);
		
		$html_tbl .= "<tr>
						<td>{$company_name}</td>
						<td>{$route}</td>
						<td>{$bus_type}</td>
						<td class='editable'>{$amenities}</td>
						<td>{$seats}</td>
						<td>Jibowu</td>
						<td>{$departure_time} {$period}</td>
						<td>{$fare}</td>
						<td><a href='#' class='edit' id='{$id}'>Edit</a></td>
						<td><a href='?op=del&id=$id' class='delete' id='{$id}'>Del</a></td>
					</tr>";
	}
	return $html_tbl;
}


function removeBus() {
	global $db;
	
	if ($db->query("DELETE FROM buses WHERE id = :id", array('id' => $_POST['id'])))
		echo "Done";
}


function removeBooking() {
	global $db;
	
	if ($db->query("UPDATE booking_details SET status = '0' WHERE id = :id", array('id' => $_POST['id'])))
		echo "Done";
}


function removeCharter() {
	global $db;
	
	if ($db->query("DELETE FROM bus_charter WHERE id = :id", array('id' => $_POST['id'])))
		echo "Done";
}


function addSpecialRoute() {
	global $db;
	
	$sql = "INSERT INTO special_routes
				(source, destination, departure, town, fare, category, date_added)
			VALUES
				('{$_POST['source']}', '{$_POST['destination']}', '{$_POST['departure']}', '{$_POST['town']}', '{$_POST['fare']}', '{$_POST['category']}', NOW())";
	
	if ($db->query($sql)) echo "Saved";
}
?>