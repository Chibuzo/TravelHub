<?php
session_start();
$_SESSION = array();
require_once "api/models/model.class.php";
require_once "api/models/routemodel.class.php";
require_once "api/models/vehiclemodel.class.php";

// check for empty fields, and collect form values
if (empty($_REQUEST['travel_date'])) {
	header("Location: index.php?msg=m_date");
} elseif (empty($_REQUEST['destination'])) {
	header("Location: index.php?msg=destination");
} else {
	/*** Get the route id of the selected route ***/
	$route = new RouteModel();
	$_origin = explode("_", $_POST['origin']);
	$_destination = explode("_", $_POST['destination']);
	$origin_id = $_origin[1];
	$destination_id = $_destination[1];
	$origin = $_origin[0];
	$destination = $_destination[0];
	$travel_date = $_POST['travel_date'];
	$route_id = $route->getRouteId($origin_id, $destination_id);

	/*** Get buses [ types and amenities ] that run the selected route ***/
	$vehicle = new VehicleModel();
	$vehicles = $vehicle->findVehicles($route_id);

	// map all origins for instant destination display
	$routes = $route->getOriginsAndDestinations();
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
}

require_once "includes/banner.php";
?>
<style>
.vehicles {
	padding: 10px;
}

.vehicle {
	cursor: pointer;
	padding: 7px 0px;
	margin: 1px 0;
	font-size: 13px;
	border-top: #e7e7e7 solid thin;
}

.vehicle:hover {
	background-color: #f7f7f7;
}

.vehicle .fa_c {
	color: #999;
}

select[name=boarding_point] {
	display:none
}

select {
	width:150px;
}

.filters {
	float:right;
}

.loading {
	display:inline;
	visibility:hidden;
	margin-left:5px;
}

.seats {
	margin-left:30px;
}

.filter-button {
	margin-bottom:2px;
	margin-left:10px;
}


.alert { font: 15px Tahoma; }

.bold {
	font-weight: 700;;
}

.travel span {
	padding-left: 15px;
}

.paks {
	font: 400 12px 'Open Sans', san-seriff;
}

.parks div {
	width: 60%;
	font-weight: 700;
	/*padding-bottom: 4px;
	margin-bottom: 4px;*/
	margin-left: -3px;
}

.parks span {
	font-weight: 700;
}

.departure-time {
	padding-top: 5px;
	font-weight: 400;
}

.display-seats {
	margin-top: 17px;
}

.show-seat {
	clear: both !important;
	overflow-y: hidden !important;
}

.fare {
	clear: both;
	/*color: #ff3b30;*/
	color: #cc0000;
	font-weight: 400 !important;
	float:right;
	margin-top: 6px;
	margin-right: 15px;
	font-size: 15px;
}


#btn-filter { display: none; padding-top: 8px; }

@media screen and (min-width: 200px) and (max-width: 600px) {
	
	#btn-filter { display: block; }

	.vehicles {
		padding: 10px 0px;
		position: relative;
		overflow-x: auto;
	}

	.vehicle {
		font-size: 11px;
	}

	#find-bus { display: none; }

	.show-seat {
		overflow-y: hidden;
	}
}

</style>
<link rel="stylesheet" type="text/css" href='css/seats.css' />
<div class='container'>
	<div class="row">
		<div class="textinfo col-md-5">
			<?php echo "{$origin} - {$destination} | " . date('D, d M Y', strtotime($travel_date)); ?>
		</div>

		<div class="col-md-6" id="btn-filter"><button class="btn btn-primary btn-block" id="btn_filter">Change search info</button></div>
		<div class="col-md-7 text-right" id="find-bus" style="padding-top: 15px">
			<form action="pick_vehicle.php" method="post" role="form">
				<div class="row">
					<div class='col-md-3'>
						<div class="form-group">
							<select id="origin" name="origin" class="form-control input-sm">
								<option value="">-- Origin --</option>
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
							<select name="destination" id="destination" class="form-control input-sm">
								<option value="">-- Destination --</option>
							</select>
							<class id='error'></class>
						</div>
					</div>

					<div class='col-md-3'>
						<div class="form-group">
							<select name="travel_date" class="form-control input-sm">
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
							<button type="submit" name="search" class="btn btn-danger btn-submit btn-block btn-round input-sm"><span class="glyphicon glyphicon-search"></span> Find bus</button>
						</div>
					</div>
				</div>
			</form>
		</div>

	</div>

    <div class="row vehicles">
		<?php
			$n = 0; $html = "";
			$_SESSION['travel_date'] = $travel_date;
			foreach ($vehicles AS $info) {
				$fare = $info['fare'];

				$btn = "<button class='display-seats btn btn-primary btn-fill pull-right btn-sm' data-fare='{$fare}' data-departure_order='{$info['departure']}' data-park_map_id='{$info['park_map_id']}' data-travel_date='{$travel_date}' data-num_of_seats='{$info['num_of_seats']}' data-trip_id='{$info['trip_id']}' data-travel_id='{$info['travel_id']}' data-vehicle_type_id='{$info['vehicle_type_id']}'><span class='fa fa-list'></span> Pick a seat</button>";

				$html .= "<div class='vehicle col-md-12 row' data-vehicle-type-id='{$info['vehicle_type_id']}'>
							<div class='col-md-4 col-xs-6'>
								<div class='bold'><i class='fa fa-bus fa_c'></i>&nbsp{$info['company_name']}</div>
								<span>{$info['name']}: {$info['num_of_seats']} - Seater</span><br />
								<span class='th-mobile'>" . implode(", ", explode(">", $info['amenities'])) . "</span>
								<div class='departure-time'><i class='fa fa-clock-o fa_c'></i>&nbsp;{$info['departure_time']}</div>
								<span></span>
							</div>

							<div class='col-md-3 col-xs-6 amenities th-desktop'><br>
								<div class='bold'>Amenities</div>
								<span>" . implode(", ", explode(">", $info['amenities'])) . "</span>
							</div>

							<div class='col-md-3 parks th-desktop'><br>
								<i class='fa fa-map-marker fa_c'></i>&nbsp; {$info['origin_park']} - {$info['destination_park']}
							</div>

							<div class='col-md-2 text-right th-desktop'>
								$btn<br>
								<div class='fare'>₦" . number_format($fare) . " </div>
							</div>

							<div class='col-xs-6 parks th-mobile text-right'><br>
								<i class='fa fa-map-marker fa_c'></i>&nbsp; {$info['origin_park']} - {$info['destination_park']}<br>
								<div class='fare'>₦" . number_format($fare) . " </div>
							</div>
					</div>
					<div data-vehicle_type_id='{$info['vehicle_type_id']}' class='show-seat nice clearfix' id='show-seat_{$info['trip_id']}'></div>";
				++$n;
			}
		if ($n > 0) {
			echo $html;
		} else {
			echo "<br><div class='alert alert-info'><i class='fa fa-exclamation-circle fa-lg'></i> &nbsp;Sorry!!! No vehicle was found for the selected route.</div>";
		}

		?>
	</div>
	<div class='hidden' id='picked_seat'></div>
</div>
<div class="clearfix"></div>
<?php require_once "includes/footer.php"; ?>
<script type="text/javascript" src="js/plugins/jquery.nicescroll.min.js"></script>
<script>
$(document).ready(function() {

	$(".nice").niceScroll({
		cursorcolor: "#ddd",
		autohidemode: false,
		cursorwidth: "10px"
	});

	var destination_ids = [<?php echo $str_destination_ids; ?>];
	var destinations = ['<?php echo $str_destinations; ?>'];
	var destination = [];

	$.each(destination_ids, function(i, val) {
		destination[val] = destinations[i];
	});

	$("#origin").change(function() {
		var origin = $(this).val().split("_")[1];
		var opt = '<option value="">-- Destination --</option>';
		var dests = [];
		dests = destination[origin].split(",");
		$.each(dests, function(i, val) {
			opt += "<option value='" + val.split("-")[1] + "_" + val.split("-")[0] + "'>" + val.split("-")[1] + "</option>\n";
		});
		$("#destination").html(opt);
	});


	// show change route form on mobile
	$("#btn_filter").click(function() {
		$("#find-bus").slideToggle();
	});
});
</script>
<script type="text/javascript" src="js/pickbus.js"></script>