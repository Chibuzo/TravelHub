<?php
require_once "includes/banner.php";
echo '<div class="container">';

// store bus charter details
if (isset($_POST['submit'])) {
	require_once "api/models/model.class.php";
	require_once "api/models/busmodel.class.php";
	
	$bus = new BusModel();
	if ($bus->charterBus() === true) {
		echo "<br /><br /><div class='alert alert-info'><div class='big-font'>Bus Charter</div><hr />Thank you. We have received your bus charter details. We will contact you soon.</div>";
	}
} else {
?>
<style>
.row {
	margin-bottom: 100px;
}
</style>
<div class="row">
	<br />
	<h1>&nbsp;Please fill out the form</h1><hr />
	<form action="" method="post" class="form-horizontal" role="form">
		<div class="form-group">
			<label for="customer_name" class="col-sm-2 control-label">Customer's name</label>
			<div class="col-sm-5">
				<input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Customer's name" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="customer_phone" class="col-sm-2 control-label">Contact number</label>
			<div class="col-sm-5">
				<input type="text" name="customer_phone" id="customer_number" class="form-control" placeholder="Customer's phone number" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="email" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-5">
				<input type="text" name="email" id="email" class="form-control" placeholder="Email address" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="next_of_kin_num" class="col-sm-2 control-label">Next of kin phone</label>
			<div class="col-sm-5">
				<input type="text" name="next_of_kin_num" id="next_of_kin_num" class="form-control" placeholder="Next of kin phone number" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="departure_location" class="col-sm-2 control-label">Departure location</label>
			<div class="col-sm-5">
				<input type="text" name="departure_location" class="form-control" placeholder="Departure location" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="destination" class="col-sm-2 control-label">Destination</label>
			<div class="col-sm-5">
				<input type="text" name="destination" class="form-control" placeholder="Destination" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="travel_date" class="col-sm-2 control-label">Date of travel</label>
			<div class="col-sm-5">
				<select name="travel_date" class="form-control">
					<?php
						for ($i = 1; $i < 60; $i++) {
							$date = mktime(0, 0, 0, date("m")  , date("d") + $i, date("Y"));
							echo "\t<option value=\"" . date('Y-m-d', $date) . "\">" . date('D, d M Y', $date) . "</option>\n";
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-5">
				<input type="submit" class="btn btn-primary" name="submit" class="form-control" value="Submit request" />
			</div>
		</div>
	</form>
</div>
<?php } ?>

</div>

<?php require_once "includes/footer.php"; ?>