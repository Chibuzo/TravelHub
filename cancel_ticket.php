<?php
require_once "includes/banner.php";
require_once "includes/db_handle.php";

if (isset($_GET['cancel'])) {
	$ticket_no = filter($_GET['ticket_no']);
	$result = $DB_CONNECTION->query("SELECT id FROM booking_details WHERE ticket_no = '$ticket_no'");
	if ($result->num_rows == 1) {
		$id = $result->fetch_object();
		$_POST['ticket_id'] = $id->id;
		require_once("ajax.php");
		if ( cancelTicket() ) {
			$msg = "The ticket with ref number {$ticket_no} has been cancelled";
		} else {
			$msg = "This ticket couldn't be cancelled, please try again";
		}
	} else {
		$msg = "This ticket ref number is not valid.";
	}
	
	
}
?>
<div id="content">
	<p>
		<h1>Cancel Ticket</h1><hr />
		<?php echo isset($msg) ? "<div class='alert'>$msg</div>" : ''; ?>
		<form action="" method="post" role="form">
			<div class="form-group">
				<label for="ticket_no">Ticket Number</label>
				<input type="text" name="ticket_no" class="form-control" />
			</div>
			<input type="submit" name="cancel" class="btn btn-primary btn-block" value=" Cancel Ticket " /></p>
		</form>
	</p>
</div>

<?php require_once "includes/footer.php"; ?>