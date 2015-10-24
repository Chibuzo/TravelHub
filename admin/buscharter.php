<?php
session_start();
require_once "../includes/db_handle.php";

require_once "../includes/banner.php";

$p_class = $c_class = $where = '';
$param = array();
if (isset($_GET['q'])) {
	$where = "WHERE status = :status";
	if ($_GET['q'] == 'p') {
		$p_class = 'btn-primary';
		$param = array('status' => 'Pending');
	} else {
		$c_class = 'btn-primary';
		$param = array('status' => 'Confirmed');
	}
}
?>

<style>
th, td {font: 11px Verdana}

</style>

<div id='content'>
	<div class="big-font full-left" style="width: 70%">Manage Bus Charter</div>
	
	<a href='logout.php' class='pull-right'>[ Logout ]</a>
	<a href='manage_booking.php' class="pull-right">[ View Ticket Booking ]</a><br />
	
	<div class="btn-group" style="margin-bottom: 5px">
		<a href='?q=p' class="btn <?php echo $p_class; ?>">Pending</a>
		<a href='?q=c' class="btn <?php echo $c_class; ?>">Confirmed</a>
	</div>

<?php
// Check for authenticated user
if (@$_SESSION['page'] != 'manage_booking.php') {
	echo "<div class='alert alert-error'>You are not authorized to use this page, so leave.</div>";
	printFooter();
	exit;
}

if (isset($_GET['op'], $_GET['id'])) {
	$db->query("UPDATE bus_charter SET status = 'Confirmed' WHERE id = :id", array('id' => $_GET['id']));
}

$sql = "SELECT * FROM bus_charter {$where}";

?>
<table class='table table-striped table-bordered'>
<thead>
<tr>
	<th>Name</th>
	<th>Phone no</th>
	<th>Origin</th>
	<th>Destination</th>
	<th>Requested date</th>
	<th>Travel date</th>
	<!--<th>Ref no</th>-->
	<th>Status</th>
	<th colspan="2">Action</th>
</thead>
<tbody>
	
<?php

foreach ($db->query($sql, $param) AS $bus) {
	echo "<tr>
			<td>{$bus['customer_name']}</td>
			<td>{$bus['customer_phone']}</td>
			<td>{$bus['departure_location']}</td>
			<td>{$bus['destination']}</td>
			<td>" . date('M, d D, H:i', strtotime($bus['date_chartered'])) . "</td>
			<td>" . date('M, d D', strtotime($bus['date_of_travel'])) . "</td>
			<td>{$bus['status']}</td>
			<td class='activate'>
				<a title='confirm ticket' href='?op=" . urlencode($row['payment_opt']) . "&id={$row['id']}'><span class='glyphicon glyphicon-ok btn-sm'></span></a><br />
			  </td>
			  <td class='remove'>
				<a href='' title='remove' class='remove' id='{$row['id']}'><span class='glyphicon glyphicon-remove btn-sm'></span></a>
			  </td>
		</tr>";
}
?>
</tbody></table></div>

<script type="text/javascript">
$(document).ready(function() {
	//var calendar = new dhtmlXCalendarObject(["t_date", "b_date"]);
	
	$('a.remove').click(function(e) {
		e.preventDefault();
		var $this = $(this);
		var id = $this.attr('id');
		
		if (confirm("Are you sure you want to remove this booking?")) {
			$.post('ajax.php', {'op': 'remove_charter', 'id': id}, function(d) {
				$this.parents('tr').fadeOut();
			});
		}
	});
});
</script>