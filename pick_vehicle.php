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

	/*** Get vehicles [ types and amenities ] that run the selected route ***/
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
$page_title = "Pick vehicle";
require_once "includes/banner.php";
?>
<style>
.vehicles {
	padding: 10px;
}

.vehicle, .show-park-details {
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

label {
	font-size: 13px;
	/*font-weight: normal;*/
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

.filter-opt-pane {
	padding: 5px 0;
	background: #f8f8f8;
	border: #e8e8e8 solid thin;
	-webkit-border-radius:;
	-moz-border-radius:;
	border-radius: 4px 4px 0 0;
}


#btn-filter { display: none; padding-top: 8px; }

@media screen and (min-width: 200px) and (max-width: 600px) {
	
	#btn-filter { display: block; }

	.filter-opt-pane {
		position: relative;
	}

	.vehicles {
		padding: 10px 0px;
		position: relative;
		overflow-x: auto;
	}

	.vehicle, .show-park-details {
		font-size: 11px;
	}

	.vehicle .col-xs-4, .show-park-details .col-xs-4 {
		width: 50%;
	}

	#find-bus { display: none; }

	.show-seat {
		overflow-y: hidden;
	}
}

</style>
<link rel="stylesheet" type="text/css" href='css/seats.css' />
<link rel="stylesheet" type="text/css" href="css/jquery.multiselect.css" />
<div class='container'>
	<div class="row vehicles">
		<div class="textinfo col-md-5">
			<?php echo "{$origin} - {$destination} | " . date('D, d M Y', strtotime($travel_date)); ?>
		</div>

		<div class="" id="btn-filter"><button class="btn btn-primary btn-block" id="btn_filter">Change trip info</button></div>
		<div class="col-md-7 text-right" id="find-bus" style="padding-top: 15px">
			<form action="pick_vehicle.php" method="post" role="form">
				<div class="row">
					<div class='col-md-3 col-sm-6'>
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

					<div class='col-md-3 col-sm-6'>
						<div class="form-group">
							<select name="destination" id="destination" class="form-control input-sm">
								<option value="">-- Destination --</option>
							</select>
							<class id='error'></class>
						</div>
					</div>

					<div class='col-md-3 col-sm-6'>
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
					<div class='col-md-3 col-sm-6'>
						<div class="form-group">
							<button type="submit" name="search" class="btn btn-danger btn-submit btn-block btn-round input-sm"><span class="glyphicon glyphicon-search"></span> Find bus</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

    <div class="row vehicles">
		<button type="button" class="btn btn-info btn-block th-mobile" id="show-filter-btn">Filter trip results</button>
		<div class="filter-opt-pane row th-desktop">
			<div class="col-md-3 col-sm-6">
				<label for="travels-opt">Travels</label>
				<select multiple="multiple" id="travels-opt"></select>
			</div>
			<div class="col-md-3 col-sm-6">
				<label for="vehicles-opt">Vehicles</label>
				<select multiple="multiple" id="vehicles-opt"></select>
			</div>
			<div class="col-md-3 col-sm-6">
				<label for="amenities-opt">Amenities</label>
				<select multiple="multiple" id="amenities-opt"></select>
			</div>
			<div class="col-md-3 col-sm-6">
				<label for="boarding-parks-opt">Boarding Parks</label>
				<select multiple="multiple" id="boarding-parks-opt"></select>
			</div>
		</div>
		<?php
			$n = 0; $html = "";
			$_SESSION['travel_date'] = $travel_date;
			$travels = array(); $amenities = array(); $boarding_parks = array(); $vehicle_types = array();
			foreach ($vehicles AS $info) {
				// let's get stuff for filter panel
				$travels[]        = $info['company_name'];
				$boarding_parks[] = $info['origin_park'];
				//$vehicle_types['id'][]  = $info['vehicle_type_id'];
				$vehicle_types[] = $info['name'];
				foreach (explode(">", $info['amenities']) AS $am) {
					$amenities[] = $am;
				}
				$fare = $info['fare'];

				$action_class; // used to determine what to show on row click
				if ($info['online'] == 1) {
					$action_class = 'vehicle';
					$btn = "<button class='display-seats btn btn-primary btn-fill pull-right btn-sm' data-fare='{$fare}' data-departure_order='{$info['departure']}' data-departure_time='{$info['departure_time']}' data-park_map_id='{$info['park_map_id']}' data-travel_date='{$travel_date}' data-num_of_seats='{$info['num_of_seats']}' data-trip_id='{$info['trip_id']}' data-travel_id='{$info['travel_id']}' data-vehicle_type_id='{$info['vehicle_type_id']}'><span class='fa fa-list'></span> Pick a seat</button>";
				} else {
					$action_class = 'show-park-details';
					$btn = "<button class='show-details btn btn-primary btn-fill pull-right btn-sm'><i class='fa fa-eye'></i> Details</button>";
				}
				$html .= "<div class='{$action_class} col-md-12 row' data-vehicle-type-id='{$info['vehicle_type_id']}' data-vehicle-name='{$info['name']}' data-travel='{$info['company_name']}' data-boarding-park='{$info['origin_park']}' data-amenities='{$info['amenities']}' data-park_address='{$info['address']}' data-park_phone='{$info['phone']}'>
							<div class='col-md-4 col-sm-4 col-xs-4'>
								<div class='bold'><i class='fa fa-bus fa_c'></i>&nbsp{$info['company_name']}</div>
								<span>{$info['name']}: {$info['num_of_seats']} - Seater</span><br />
								<span class='th-mobile'>" . implode(", ", explode(">", $info['amenities'])) . "</span>
								<div class='departure-time'><i class='fa fa-clock-o fa_c'></i>&nbsp;{$info['departure_time']}</div>
								<span></span>
							</div>

							<div class='col-md-3 col-sm-3 col-xs-3 amenities th-desktop'>
								<div class='bold'>Amenities</div>
								<span>" . implode(", ", explode(">", $info['amenities'])) . "</span><br>
							</div>

							<div class='col-md-3 col-sm-3 col-xs-3 parks th-desktop'><br>
								<i class='fa fa-map-marker fa_c'></i>&nbsp; {$info['origin_park']} - {$info['destination_park']}
							</div>

							<div class='col-md-2 col-sm-2 col-xs-2 text-right th-desktop'>
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
		// let's build the filter options
		$_travels = '';
		foreach (array_unique($travels) AS $t) {
			$_travels .= "<option value='$t'>$t</option>";
		}
		$_amenities = '';
		foreach (array_unique($amenities) AS $a) {
			$_amenities .= "<option value='$a'>$a</option>";
		}
		$_vehicle_types = '';
		foreach (array_unique($vehicle_types) as $v) {
			$_vehicle_types .= "<option value='$v'>$v</option>";
		}
		$_parks = '';
		foreach (array_unique($boarding_parks) AS $bp) {
			$_parks .= "<option value='$bp'>$bp</option>";
		}
		?>
	</div>
	<div class='hidden' id='picked_seat'></div>
</div>
<div class="clearfix"></div>

<div class="modal fade" id="parkAddressModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Booking Office Contact</h4>
			</div>
			<div class="modal-body">
				<div id="park-address"></div><br>
				<div id="park-phone"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?php require_once "includes/footer.php"; ?>
<script type="text/javascript" src="js/plugins/jquery.multiselect.js"></script>
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


	$("#travels-opt").html("<?php echo $_travels; ?>");
	$("#vehicles-opt").html("<?php echo $_vehicle_types; ?>");
	$("#amenities-opt").html("<?php echo $_amenities; ?>");
	$("#boarding-parks-opt").html("<?php echo $_parks; ?>");

	$('select[multiple]').multiselect({
		onOptionClick: function(elem, opt) {
			var filters = [];
			$(".filter-opt-pane .col-md-3 .ms-options ul li").each(function(i, elem) {
				if ($(elem).attr('class') == 'selected') {
					filters.push($(elem).find(':checkbox').val());
				}
			});
			if (filters.length == 0) {
				$(".vehicle").show();
			} else {
				$(".vehicle").each(function() {
					var travel          = $(this).data('travel');
					var vehicle_name    = $(this).data('vehicle-name');
					var boarding_park   = $(this).data('boarding-park');
					var amenities       = $(this).data('amenities');
					if (($.inArray(travel, filters) > -1) || ($.inArray(vehicle_name, filters) > -1) || ($.inArray(boarding_park, filters) > -1) || ($.inArray(amenities, filters) > -1)) {
						$(this).show();
					} else {
						$(this).hide();
					}
				});
			}
		}
	});

	// show/hide filter controls on mobile
	$("#show-filter-btn").click(function() {
		$(".filter-opt-pane").slideToggle().css('overflow', ''); // removed overflow: hidden to prevent hidding the dropdown
	});
});
</script>
<script type="text/javascript" src="js/pickbus.js"></script>