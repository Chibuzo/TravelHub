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
/*body { background-image:url('../images/bg.png'); background-repeat: repeat;}*/

#bus_search {
	margin-top: 10px;
	padding: 10px;
}

h1 {
	font: 300 38px 'Open Sans', San-serif, Helvetica Neue, Tahoma;
	margin-bottom: 20px;
	text-align: center;
}

.feature { font-size: 17px; color: #bbb; font-weight: 100; }


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

#services {
	text-align: center;
	margin-top: 40px;
}

#services .row div {
	padding: 10px 30px;
	font-weight: 300;
	font-size: 17px;
	line-height: 25px;
}

#services h3 {
	margin-top: 8px;
	margin-bottom: 15px;
	font-size: 25px;
}

#services .glyphicon, #services .fa {
	font-size: 21px;
	color: #666;
}

#services .fa {
	font-size: 24px;
}

.right-border {
	box-shadow: 4px 0px 5px -4px #ccc;
}


@media screen and (min-width: 200px) and (max-width: 600px) {
	#bussearch {
		width: auto;
		margin: auto !important;
		top: 0px !important;
		padding: 5px;
	}
}

/* TABLETS PORTRAIT */
@media screen and (min-width: 600px) and (max-width: 768px) {
	#bussearch {
		width: auto;
		margin: auto !important;
		top: 0px !important;
		padding: 5px;
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

<div class="container">
	<div class="row">
		<div id="bus_search">
			<h1>Where are you going?</h1>
			<?php echo isset($_GET['msg']) ? "<div class='alert alert-error'>You must select travel destination to continue.</div>" : ''; ?>
			<form action="pick_vehicle.php" method="post" role="form">
				<div class="row">
					<div class='col-md-3'>
						<div class="form-group">
							<select id="origin" name="origin" class="form-control input-lg">
								<option value="">-- Pick travel origin --</option>
								<?php
									foreach ($routes['origins'] AS $origin) {
										echo "<option value='{$origin->state_name}_{$origin->origin_id}'>{$origin->state_name}</option>\n";
									}
								?>
							</select>
						</div>
					</div>

					<div class='col-md-3'>
						<div class="form-group">
							<select name="destination" id="destination" class="form-control input-lg">
								<option value="">-- Pick destination --</option>
							</select>
							<class id='error'></class>
						</div>
					</div>

					<div class='col-md-3'>
						<div class="form-group">
							<select name="travel_date" class="form-control input-lg">
							<?php
								for ($i = 1; $i < 30; $i++) {
									$date = mktime(0, 0, 0, date("m")  , date("d") + $i, date("Y"));
									echo "\t<option value=\"" . date('Y-m-d', $date) . "\">" . date('D, d M Y', $date) . "</option>\n";
								}
							?>
							</select>
						</div>
					</div>

					<div class='col-md-3'>
						<div class="form-group">
							<button type="submit" name="search" class="btn btn-danger btn-block btnsubmit btn-round btn-lg"><span class="glyphicon glyphicon-search"></span> Find bus</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="container" id="services">
	<div class="row">
		<div class="col-md-4 hidden">
			<div>
				You don't like queuing at the ticketing office?
				TravelHub provides a better alternative for buying tickets for your travels
			</div>
		</div>

		<div class="col-md-6 right-border">
			<div>
				<h3><i class="fa fa-ticket"></i> &nbsp;Ticket Easy</h3>
				You no longer need to visit different parks to get travel details like fare, departure time, vehicle type available etc,
				TravelHub provides these details at the comfort of your home or office.
				Now you can easily make better decisions about your trips
			</div>
		</div>

		<div class="col-md-6">
			<div class="">
				<h3><span class="glyphicon glyphicon-phone-alt"></span> &nbsp;Call Us Now</h3>
				TravelHub has a caring and friendly crew that are willing to receive your calls and answer all your questions concerning
				intra-city travels in Nigeria. We can also help you make reservations without any service charge.
			</div>
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