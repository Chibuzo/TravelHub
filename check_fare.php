<?php
session_start();
require_once("includes/general_functions.php");

docType();
printBanner();

if (isset($_POST['submit'])) {
	/*** Get the route_code of the selected route ***/
	$destination = filter($_POST['destination']);
	$origin      = filter($_POST['origin']);
	
	$route_code = getRouteCode($origin, $destination);
	
	/*** Select the the fare for the route_code ***/
	$sql = "SELECT f.*, bus_type, seats, company_name FROM buses AS b
			JOIN fares as f ON b.travel_id = f.travel_id AND f.route_code = '$route_code'
			JOIN travels AS t ON b.travel_id = t.id
			WHERE b.route_code = '$route_code'";
	$result = $DB_CONNECTION->query($sql);
	if ($result) {
		$amount = "<p><b>From {$origin} to {$destination}:</b></p><blockquote><dl class='dl-horizontal' style='font: 11px verdana'>";
		$temp_company_name = '';
		while ($row = $result->fetch_assoc()) {
			extract($row);
			if ($company_name != $temp_company_name) $amount .= "<div style='font: 11px verdana; color:#000'><b>{$company_name}</b></div>";
			if ($seats == 11) {
					$fare = $executive_fare;
			} elseif ($seats < 20) {
				$fare = $hiace_fare;
			} else {
				$fare = $luxury_fare;
			}
			$amount .= "<dt>{$bus_type}</dt><dd>{$fare} NGN</dd>";
			$temp_company_name = $company_name;
		}
	}
	
	if (!isset($amount)) {
		$amount = "Not available at this moment";
	}
	$amount .= "</dl></blockquote>";
}
?>
<script src="javascript/index.js" type="text/javascript"></script>
<script src="javascript/jquery.autocomplete.pack.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css" media="all" />
<div id="content">
	<div id='pane'>
		<div class='head'>Check Fare</div><hr style='margin:6px 0px' /><br />
	
		<form action="" method="post">
			<div style='float:left; width:200px;'><label>From</label>
			<input type="text" name="origin" value="Lagos" readonly="readonly" style='width:160px' /></div>
				
			<div style='float:left; width:200px'><label>To</label>
			<input type="text" id="destination" name="destination" style='width:160px' /><br />
			</div>
			<p style="clear:both; position:relative; top:20px;"><input type="submit" name="submit" class="btn btn-info btn-large" value="Check Fare" /></p>
			<br /><br />
		</form>
		<?php echo isset($amount) ? "<div class='alert alert-success'>$amount</div>" : ''; ?>
	</div>
</div>
<?php printFooter(); ?>