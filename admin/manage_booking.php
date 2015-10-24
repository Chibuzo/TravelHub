<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once("../includes/db_handle.php");

require_once "../includes/banner.php";
?>

<style>
th, td {font: 11px Verdana}

th { font-weight: bold; }

.form-ctrl {
	width: 200px;
	float: left;
	margin-bottom: 20px;
}
</style>

<?php
echo "<div class='container'><br />
	<a href='logout.php' class='pull-right'>[ Logout ]</a>
	<a href='buscharter.php' class='pull-right'>[ Bus charter ]</a><br />";

// Check for authenticated user
if (@$_SESSION['page'] != 'manage_booking.php') {
	echo "<div class='alert alert-error'>You are not authorized to use this page, so leave.</div>";
	require_once "../includes/footer.php";
	exit;
}

if (isset($_GET['op'], $_GET['id'])) {
	$op = urldecode($_GET['op']);
	$db->query("UPDATE booking_details SET payment_status = 'Paid' WHERE id = :id", array('id' => $_GET['id']));
	#if ($DB_CONNECTION->affected_rows == 1 && $_GET['op'] == 'Bank payment') {
	#	// Send sms
	#} 
}

$travel_date = isset($_REQUEST['submit']) ? $_REQUEST['travel_date'] : date('Y-m-d');
$booking_date = isset($_REQUEST['submit']) ? $_REQUEST['booking_date'] : date('Y-m-d');

echo "<form method='post' role='form'>
	<div class='form-ctrl'>
		<label for='travel_name'>Travel date</label>
		<div class='input-group pull-left'>
			<input name='travel_date' id='t_date' class='form-control' value='$travel_date' type='text' />
			<span class='input-group-btn'>
				<input type='submit' class='btn btn-primary' name='submit' value='Go' />
			</span>
		</div>
	</div>
	
	<div class='form-ctrl' style='margin-left:15px;'>
		<label>Booking date</label>
		<div class='input-group'>
			<input name='booking_date' id='b_date' class='form-control' stle='width:120px' value='$booking_date' type='text' />
			<span class='input-group-btn'>
				<input type='submit' name='submit' value='Go' class='btn btn-primary' />
			</span>
		</div>
	</div>
	<pre class='pull-right'><b>Today's date: " . date('jS M') . "</b></pre>
</form>
<table class='table table-striped table-bordered'>
<thead>
<tr>
	<th>Operator</th>
	<th>Route</th>
	<th>Date booked</th>
	<th>Travel date</th>
	<th>Name</th>
	<th>Phone no</th>
	<!--<th>Delivery Address</th>-->
	<th>Channel</th>
	<!--<th>Status</th>-->
	<th>Transaction</th>
	<!--<th>Ref no</th>-->
	<th>Amount</th>
	<th colspan='2'>Action</th>
</thead>
<tbody>";

$sql = "SELECT bd.id AS bk_id, c_name, phone_no, payment_opt, payment_status, travel_date, date_booked, route, fare, company_name, terminal
		FROM booking_details AS bd 
		JOIN routes r ON r.id = bd.route_id 
		JOIN travels t ON t.id = bd.travel_id
		WHERE travel_date >= :travel_date AND DATE_FORMAT(date_booked, '%X-%m-%d') >= :booking_date AND status = '1' ORDER BY date_booked DESC";
		
$param = array('travel_date' => $travel_date, 'booking_date' => $booking_date);
$db->query($sql, $param);

foreach ($db->stmt AS $row) {
	$row_class ='';
	if ($row['payment_status'] == 'Paid') $row_class = 'success';
	elseif ($row['payment_status'] == 'failed') $row_class = 'error';
	
	echo "<tr class='$row_class'><td>{$row['company_name']}<br /><b>[ {$row['terminal']} ]</b></td>
			  <td class='route'>{$row['route']}</td>
			  <td>" . date('M, d D', strtotime($row['date_booked'])) . "</td>
			  <td>" . date('M, d D', strtotime($row['travel_date'])) . "</td>
			  <td>{$row['c_name']}</td>
			  <td>{$row['phone_no']}</td>
			  <td>{$row['payment_opt']}</td>
			  <!--<td>{$row['payment_status']}</td>-->
			  <td>{$row['payment_status']}</td>
			  <!--<td>{$row['bk_id']}</td>-->
			  <td>₦ " . round($row['fare']) . "</td>
			  <td class='activate'>
				<a title='confirm ticket' href='?op=" . urlencode($row['payment_opt']) . "&id={$row['bk_id']}'><span class='glyphicon glyphicon-ok btn-sm'></span></a><br />
			  </td>
			  <td class='remove'>
				<a href='' title='remove' class='remove' id='{$row['bk_id']}'><span class='glyphicon glyphicon-remove btn-sm'></span></a>
			  </td>
		  </tr>";
}

echo "</tbody></table></div>";
?>
<script type="text/javascript" src="<?php echo BASE_URL; ?>js/dhtmlxcalendar.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/dhtmlxcalendar.css" />
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/dhtmlxcalendar_dhx_skyblue.css" />
<script type="text/javascript">
$(document).ready(function() {
	var calendar = new dhtmlXCalendarObject(["t_date", "b_date"]);
	
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