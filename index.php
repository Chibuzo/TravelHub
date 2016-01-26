<?php
require_once "includes/banner.php";
require_once "includes/db_handle.php";
require "api/models/routemodel.class.php";

$route = new RouteModel();
$routes = $route->getOriginsAndDestinations();

// map all origins for instant destination display
$route_maps = $route->mapAllOrigin($routes['origins']);
$destination_ids = array();
$destinations = array();
foreach ($route_maps AS $state_id => $_destinations) {
	$destination_ids[] = $state_id;
	$destinations[] = $_destinations;
}
if (isset($destination_ids)) {
	$str_destination_ids = implode(",", $destination_ids);
}
if (isset($destinations)) {
	$str_destinations = implode("', '", $destinations);
}


// submit bus charter
if (isset($_POST['bus_charter'])) {
	require_once "classes/buscharter.class.php";
	$buscharter = new BusCharter();
	//extract($_POST);
	if ($buscharter->addBusCharter($name, $phone, $traveldate, $departure_location, $destination, $vehicle_type, $num_of_vehicles) === true) {
		$msg = true;
	}
}
?>

<style>
body { background-image:url('../images/bg.png'); background-repeat: repeat;}

header { box-shadow: 2px 0px 6px 2px #cc0000; }

#bus_search {
	float: left;
	width: 50%;
	padding: 10px;
}

h1 { font-size: 40px; color: #ccc; }

label { color: #fff; font-weight: normal; }

.feature { font-size: 17px; color: #bbb; font-weight: 100; }

.white-bg .col-md-4 .inner, .services {
	margin: 8px;
	padding: 8px 25px;
	padding-top: 20px;
	font-size: 17px;
	font-weight: 100;
	color: #666;
	text-align:center;
	background: rgba(255, 255, 255, 0.8);
	box-shadow: 0px 0px 5px 1px #ccc;
}

.services { padding-bottom: 30px; }

.services a { display: none; }

#bg {
  min-height: 100%;
  min-width: 1024px;

  /* Set up proportionate scaling */
  width: 100%;
  height: auto;

  /* Set up positioning */
  position: fixed;
  top: 0;
  left: 0;
}

#book-pane {
	z-index: 100;
	width: 42%;
	padding: 20px 60px;
	margin-left: 60px;
	min-height: 320px;
	border-radius: 5px;
}


@media screen and (min-width: 200px) and (max-width: 600px) {
	#book-pane {
		width: auto;
		margin: auto !important;
		top: 0px !important;
		padding: 5px;
		background: rgb(255, 255, 255) transparent;
		background: rgba(0, 0, 0, 0.8);
	}

	#book-ticket label {display: none; }
}

/* TABLETS PORTRAIT */
@media screen and (min-width: 600px) and (max-width: 768px) {
	#book-pane {
		width: auto;
		margin: auto !important;
		top: 0px !important;
		padding: 5px;
		background: rgb(255, 255, 255) transparent;
		background: rgba(0, 0, 0, 0.8);
	}
}


/* TABLET LANDSCAPE / DESKTOP */
@media only screen and (min-width: 1024px) {


}

.feature-wrap i{
  font-size: 48px;
  margin: auto !important;
  margin-top: 20px !important;
  text-align:center;
  background: none;
  color: #ccc;
}
</style>
<link href="css/datepicker.css" rel="stylesheet" />
<link href="css/datepicker3.css" rel="stylesheet" />

<div class="containerfluid">
	<div id="book-pane">
		<div role="tabpanel">

			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="book-ticket">
					<?php echo isset($_GET['msg']) ? "<div class='alert alert-error'>You must select travel destination to continue.</div>" : ''; ?>
					<form action="pick_vehicle.php" method="post" role="form">
						<div class="row" style="clear: both !important">
							<div class='col-md-6 clearfix'>
								<div class="form-group">
									<label for="origin">From</label>
									<select id="origin" name="origin" class="form-control">
										<option value="">-- Pick travel origin --</option>
										<?php
											foreach ($routes['origins'] AS $origin) {
												echo "<option value='{$origin->state_name}_{$origin->origin_id}'>{$origin->state_name}</option>\n";
											}
										?>
									</select>
								</div>
							</div>

							<div class='col-md-6'>
								<div class="form-group">
									<label for="destination">To</label>
									<select name="destination" id="destination" class="form-control">
										<option value="">-- Pick destination --</option>
									</select>
									<class id='error'></class>
								</div>
							</div>
						</div>

						<div class="row">
							<div class='col-md-6'>
								<div class="form-group">
									<label for="travel_date">Date of travel</label>
									<select name="travel_date" class="form-control">
									<?php
										for ($i = 1; $i < 30; $i++) {
											$date = mktime(0, 0, 0, date("m")  , date("d") + $i, date("Y"));
											echo "\t<option value=\"" . date('Y-m-d', $date) . "\">" . date('D, d M Y', $date) . "</option>\n";
										}
									?>
									</select>
								</div>
							</div>
							<div class='col-md-6'>
								<div class="form-group">
									<label>&nbsp;</label>
									<button type="submit" name="search" type="submit" class="btn btn-danger btn-block btn-submit"><span class="glyphicon glyphicon-search"></span> Find bus</button>
								</div>
							</div>
						</div>
					</form>
				</div>

				<div role="tabpanel" class="tab-pane" id="profile">
					<form action="" method="post" role="form">
						<div class="row" style="clear: both !important">
							<div class="col-md-6">
								<div class="form-group">
									<label for="travel_date">Your name</label>
									<input type="text" name="name" id="customer_name" class="form-control" placeholder="Your name" />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="travel_date">Contact number</label>
									<input type="text" name="phone" id="customer_number" class="form-control" placeholder="Contact number" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="travel_date">Pick location</label>
									<input type="text" name="departure_location" class="form-control" placeholder="Pickup location" />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="travel_date">Destination</label>
									<input type="text" name="destination" class="form-control" placeholder="Destination" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="travel_date">Vehicle type</label>
									<select name="vehicle_type" class="form-control">
										<option value="">-- Vehicle types --</option>
										<?php
											foreach ($db->query("SELECT * FROM bus_types") AS $bus) {
												echo "<option value='{$bus['id']}'>{$bus['name']} ({$bus['num_of_seats']} Seats)</opition>";
											}
										?>
									</select>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="travel_date">No of Vehicles</label>
									<input type="text" name="num_of_vehicles" class="form-control" placeholder="Number of Vehicles" />
								</div>
							</div>
						</div>


						<div class="row">
							<div class="col-md-6">
								<label for="travel_date">Date of travel</label>
								<div class="input-group">
									<input type="text" name="traveldate" class="form-control date" placeholder="Travel date" />
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>&nbsp;</label>
									<input type="submit" class="btn btn-danger btn-block" name="bus_charter" id="bus_charter" class="form-control" value="Submit request" />
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>

<div class="container" id="services">
	<div class="row">
		<div class="col-md-4">

		</div>

		<div class="col-md-4">

		</div>

		<div class="col-md-4">

		</div>
	</div>
</div>

<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<script>
$(document).ready(function() {
	var destination_ids = [<?php echo $str_destination_ids; ?>];
	var destinations = ['<?php echo $str_destinations; ?>'];
	var destination = [];

	$.each(destination_ids, function(i, val) {
		destination[val] = destinations[i];
	});

	$("#origin").change(function() {
		var origin = $(this).val().split("_")[1];
		var opt = '<option value="">-- Pick destination --</option>';
		var dests = [];
		dests = destination[origin].split(",");
		$.each(dests, function(i, val) {
			opt += "<option value='" + val.split("-")[1] + "_" + val.split("-")[0] + "'>" + val.split("-")[1] + "</option>\n";
		});
		$("#destination").html(opt);
	});


	$('.date').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		todayHighlight: true,
		autoclose: true
	});

});
</script>
<?php require_once "includes/footer.php"; ?>