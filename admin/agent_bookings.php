<?php
session_start();
require_once("../includes/banner.php");
?>

<style>
th, td {font: 11px Verdana}

td.remove {
	text-align: center !important;
}

.form-ctrl {
	width: 180px;
	float: left;
	margin-bottom: 20px;
}
</style>

<?php
echo "<div class='container'>
	<a href='logout.php' class='pull-right'>[ Logout ]</a><br />";
	
// Check for authenticated user
if (@$_SESSION['page'] != 'agent_bookings.php') {
	echo "<div class='alert alert-error'>You are not authorized to use this page, so leave.</div>";
	printFooter();
	exit;
}

$from = isset($_REQUEST['from']) ? $_REQUEST['from'] : date('Y-m-d');
$to   = isset($_REQUEST['to']) ? $_REQUEST['to'] : date('Y-m-d');
$agent_username = isset($_REQUEST['agent']) ? $_REQUEST['agent'] : '';

require_once "../classes/agent.class.php";
$agent = new Agent($agent_username);

if ($agent_username != '') {
	$agent_field_style = "hide";
	$off = ""; // for percentage display
	$colspan = 10;
} else {
	$agent_field_style = "";
	$off = "hide";
	$colspan = 9;
}

echo "<form method='get' role='form'>
	<div class='form-ctrl'>
		<label for='agent'>Select agent</label>
		<div class='input-group'>
			<select name='agent' class='form-control'>
				<option value=''>All agents</option>" . $agent->agentFormSelectListing($agent_username) . "
			</select>
			<span class='input-group-btn'>
				<input type='submit' class='btn btn-primary' name='agent_form' value='Go' />
			</span>
		</div>
	</div>
	
	<div class='form-ctrl' style='margin-left:15px'>
		<label for='from'>From</label>
		<div class='controls'>
			<input name='from' id='from_date' class='form-control' value='$from' type='text' />
		</div>
	</div>
	
	<div class='form-ctrl' style='margin-left:15px'>
		<label for='to'>To</label>
		<div class='input-group'>
			<input name='to' id='to_date' class='form-control' value='$to' type='text' />
			<span class='input-group-btn'>
				<input type='submit' class='btn btn-primary' name='submit' value='Go' />
			</span>
		</div>
	</div>
	
	<pre class='pull-right'><b>Today's date: " . date('jS M') . "</b></pre>
</form>
<table class='table table-striped table-bordered'>
<thead>
<tr>
	<th class='$agent_field_style'>Agent name</th>
	<th>Operator</th>
	<th>Route</th>
	<th>Date booked</th>
	<th>Travel date</th>
	<th>Name</th>
	<th>Phone no</th>
	<th>Channel</th>
	<th>Status</th>
	<th>Fare</th>
	<th class='$off'>Oya 10%</th>
	<th class='$off'>60% off</th>
</thead>
<tbody>";

$total_percentage = '0';
foreach ($agent->getTicketSales($from, $to) AS $row) {
	$row_class ='';
	if ($row['payment_status'] == 'successful') $row_class = 'success';
	elseif ($row['payment_status'] == 'failed') $row_class = 'error';
	
	$oya_percentage = 0.1 * $row['fare'];
	$percentage = $oya_percentage * (60 / 100);
	$total_percentage += $percentage;
	
	echo "<tr class='$row_class'>
			  <td class='$agent_field_style'>{$row['agent_name']}</td>
			  <td>{$row['company_name']}<br /><b>[ {$row['terminal']} ]</b></td>
			  <td>{$row['route']}</td>
			  <td>" . date('M, d D', strtotime($row['date_booked'])) . "</td>
			  <td>" . date('M, d D', strtotime($row['travel_date'])) . "</td>
			  <td>{$row['c_name']}</td>
			  <td>{$row['phone_no']}</td>
			  <td>{$row['payment_opt']}</td>
			  <td>{$row['payment_status']}</td>
			  <td>₦" . round($row['fare']) . "</td>
			  <td class='$off'>₦" . round($oya_percentage) . "</td>
			  <td class='$off'>₦" . round($percentage) . "</td>
		  </tr>";
}

echo "<tr><td style='border-bottom: none; border-left: none; text-align: right' colspan='$colspan'><b>Total percentage off:</b></td><td>₦ $total_percentage</td></tr>";
echo "</tbody></table></div>";
?>
<script type="text/javascript" src="<?php echo BASE_URL; ?>js/dhtmlxcalendar.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/dhtmlxcalendar.css" />
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/dhtmlxcalendar_dhx_skyblue.css" />
<script type="text/javascript">
$(document).ready(function() {
	var calendar = new dhtmlXCalendarObject(["from_date", "to_date"]);
	
	$('a.remove').click(function(e) {
		e.preventDefault();
		var $this = $(this);
		var id = $this.attr('id');
		
		if (confirm("Are you sure you want to remove this booking?")) {
			$.post('ajax.php', {'op': 'remove_booking', 'id': id}, function(d) {
				$this.parents('tr').fadeOut();
			});
		}
	});
});
</script>