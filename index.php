<?php
require_once "includes/banner.php";
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
#search-wrap {
	background: url('images/header-bg.jpg') no-repeat center top;
	background-position: center center;
	min-height: 450px;
	width: 100%;
	-webkit-background-size: 100%;
	-moz-background-size: 100%;
	-o-background-size: 100%;
	background-size: 100%;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	backgroundcolor: #f0f0f0;
	margin-top: -20px;
}

#bus_search {
	padding: 10px;
}

#phone-div {
	margin-top: 20px;
	text-align: center;
	font: 400 28px 'Open Sans', San-serif, Helvetica Neue, Tahoma;
	color: #fff;
}

#feature-tagline-bg {
	position: relative;
	background-color: rgba(0,0,0,0.5);
	width: 530px;
	border: #ccc solid thin;
	padding: 10px 25px;
	top: 40px;
	height: 80px;
	overflow: auto;
	border-radius: 3px;
	opacity: 0.7;
	margin: auto;
}

#feature-tagline-text {
	text-align: center;
	padding-left: 17px;
	width: 530px;
	margin: auto;
	position: relative;
	top: -35px;
	color: #fff;
}

#feature-tagline-text h4 {
	margin-bottom: 1px !important;
	margin-top: 9px;
	font: 700 20px 'Lato', 'Open Sans', San-serif;
	color: #FF3B30;
}

h1 {
	clear: both;
	font: 300 38px 'Open Sans', San-serif, Helvetica Neue, Tahoma;
	margin: 30px 0;
	margin-bottom: 30px;
	text-align: center;
	color: #fff;
}

#services {
	text-align: center;
	margin-top: 60px;
}

#services .row div {
	padding: 10px 12px;
	font-weight: 400;
	font-size: 15px;
	line-height: 25px;
}

#services h3 {
	margin-top: 8px;
	margin-bottom: 20px;
	font-size: 25px;
	font-weight: 400;
	color: #3c3c3c;
}

#services .fa {
	font-size: 31px;
	color: #27E1CE;
	border: #27E1CE solid;
	padding: 19px;
	width: 80px;
	height: 78px;
	border-radius: 50%;
	margin-bottom: 15px;
}

#services .fa {
	font-size: 36px;
}

.operators {
	background-color: #f0f0f0;
	margin: 70px 0;
	padding: 30px;
}

.operators h2 {
	colr: #999;
	margin-bottom: 16px;
}

.operators img {
	margin: 20px 15px;
	height: 25px;
}


@media screen and (min-width: 200px) and (max-width: 600px) {
	#bus_search h1 {
		font-size: 28px;
	}

	#services .row div {
		padding: 10px 5px;
		font-weight: 300;
		font-size:15px;
		line-height: 22px;
	}

	#feature-tagline-bg, #feature-tagline-text {
		width: auto;
	}
}

/* TABLETS PORTRAIT */
@media screen and (min-width: 600px) and (max-width: 768px) {

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
<link href="cp/plugins/datepicker/datepicker3.css" rel="stylesheet" />

<div class="container-fluid" id="search-wrap">
	<div class="container">
	<div class="row">
		<div id="bus_search">
			<h1>Where are you going?</h1>
			<?php echo isset($_GET['msg']) ? "<div class='alert alert-error'>You must select travel destination to continue.</div>" : ''; ?>
			<form action="pick_vehicle.php" method="post" role="form" id="form-book">
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
							<input type="text" name="travel_date" id="t_date" class="hidden form-control calendar input-lg" value="<?php echo date('Y-m-d'); ?>" />
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
							<button type="submit" name="search" class="btn btn-danger btn-fill btn-block btnsubmit btn-round btn-lg"><span class="glyphicon glyphicon-search"></span> Find bus</button>
						</div>
					</div>
				</div>
			</form>
			<div class="row">
				<div class="col-md-12" id="phone-div">
					<span class="glyphicon glyphicon-phone-alt"></span><br>
					0703 000 0000
				</div>
			</div>

			<div id="feature-tagline-bg">
			</div>
			<div id="feature-tagline-text">
<!--				<img src="images/travelhub-emblem.png" style="float: left; margin-right: 25px; margin-top: -6px; width: 50px" />-->
				<h4>CHECK FARES</h4>
				Find over 500+ travel fares from different operators.
			</div>
		</div>
	</div>
	</div>
</div>

<div class="container" id="services">
	<div class="row">
		<div class="col-md-4">
			<div>
				<i class="fa fa-road"></i>
				<h3>Travel Inventory</h3>
				You no longer need to visit different parks to get travel details like fare, departure time, vehicle types etc.
				TravelHub provides these details at the comfort of your home or office.
				Now you can make better decisions about your trips.
			</div>
		</div>

		<div class="col-md-4 right-border">
			<div>
				<i class="fa fa-gift"></i>
				<h3>Loyalty & Gifts</h3>
				Receive discounts on tickets purchased from our platform and get surprising gift items from the respective departure parks.
				Your favourite bus operators will often offer loyalities and discounts on this platform. Don't miss out.
			</div>
		</div>

		<div class="col-md-4">
			<div class="">
				<i class="fa fa-briefcase"></i>
				<h3>Travel Easy</h3>
				Travelhub provides you more trip options than you can get in the park. Here you can see boarding vehicles and avaliable seats,
				amenities and different vehicle fares without having to ask. Traveling hasn't been that easy.
			</div>
		</div>
	</div>
</div>

<div class="container-fluid operators">
	<div class="container">
		<div class="row text-center">
			<h3>Available transport operators</h3>
			<img src="images/ekerson-logo.png" alt="Ekeson Tranport logo" />
			<img src="images/ifesinachi-logo.png" alt="Ifesinachi Transport logo" />
			<img src="images/guo-logo.png" alt="GUO transport logo" />
		</div>
	</div>
</div>

<?php require_once "includes/footer.php"; ?>
<script type="text/javascript" src="cp/plugins/datepicker/bootstrap-datepicker.js"></script><script>
$(document).ready(function() {
	$('.calendar').datepicker({
		format: 'yyyy-mm-dd',
		keyboardNavigation: false,
		forceParse: true,
		todayHighlight: true,
		autoclose: true
	});

	// reset booking form
	$("#origin, #destination").val("");

	destination_ids = [<?php echo $str_destination_ids; ?>];
	destinations = ['<?php echo $str_destinations; ?>'];
	destination = [];

	$.each(destination_ids, function(i, val) {
		destination[val] = destinations[i];
	});

	$("#origin").change(function() {
		getDestination($(this));
	});
});

function getDestination(obj) {
	var origin = obj.val().split("_")[1];
	var opt = '<option value="">-- Pick destination --</option>';
	var dests = [];
	dests = destination[origin].split(",");
	$.each(dests, function(i, val) {
		opt += "<option value='" + val.split("-")[1] + "_" + val.split("-")[0] + "'>" + val.split("-")[1] + "</option>\n";
	});
	$("#destination").html(opt);
}
</script>