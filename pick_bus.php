<?php
session_start();
$_SESSION = array();
require_once "api/models/model.class.php";
require_once "api/models/routemodel.class.php";
require_once "api/models/busmodel.class.php";

// check for empty fields, and collect form values
if (empty($_REQUEST['travel_date'])) {
	header("Location: index.php?msg=m_date");
} elseif (empty($_REQUEST['destination'])) {
	header("Location: index.php?msg=destination");
} else {
	/*** Get the route id of the selected route ***/
	extract($_REQUEST);
	$route = new RouteModel();
	$route_id = $route->getRouteId($origin . ' - ' . $destination);

	// query part
	$where = "WHERE f.route_id = :route_id AND fare > 0";

	/*** Get buses [ types and amenities ] that run the selected route ***/
	$bus = new BusModel();
	$bus_stmt = $bus->findBuses($where, $route_id);
}

require_once "includes/banner.php";
?>
<style>
.buses {
	padding: 10px;
	marginbottom: 120px;
}

.bus {
	/*border: #e0e0e0 solid thin;*/
	padding: 14px;
	margin: 5px 0;
	background: #f3f3f3;
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

.oya-popup {
	position:absolute;
	border:#ccc solid thin;
	padding:6px 14px;
	border-radius: 4px;
	min-width:180px;
	z-index: 10px;
	background-color: #fff;
	display: none;
}

label {
	position: relative;
	font: normal 11px Verdana;
	top:3px;
	display: inline;
	margin-left: 4px;
}

.alert { font: 15px Tahoma; }

.bg {
	background-color: #f9f9f9;
}

.show-seat {
	border-top-color: #ff000;
	display: block;
	border: #fff solid thin;
}

.fare {
	color: #cc0000;
	font-weight: 400;
}

#btn-filter { display: none; padding-top: 8px; }

@media screen and (min-width: 200px) and (max-width: 600px) {
	#btn-filter { display: block; }

	#find-bus { display: none; }

	.seat_arrangement {
		-webkit-transform: rotate(90deg);
		-moz-transform: rotate(90deg);
		-o-transform: rotate(90deg);
		-ms-transform: rotate(90deg);
		transform: rotate(90deg);
	}
}

</style>
<link rel="stylesheet" type="text/css" href='css/seats.css' />
<div class='container'><br />
	<div class="row">
		<div class="text-info col-md-5">
			<br />
			<?php echo "{$origin} - {$destination} | " . date('D, d M Y', strtotime($travel_date)); ?>
		</div>

		<div class="col-md-6" id="btn-filter"><button class="btn btn-danger btn-block" id="btn_filter">Change search info</button></div>
		<div class="col-md-7 text-right" id="find-bus" style="padding-top: 15px">
			<form action="pick_bus.php" method="post" role="form">
				<div class="row">
					<div class='col-md-3'>
						<div class="form-group">
							<select id="origin" name="origin" class="form-control input-sm">
								<option value="">-- Origin --</option>
								<option value="Lagos">Lagos</option>
								<option value="Enugu">Enugu</option>
								<option value="PortHarcourt">Port Harcout</option>
								<option value="Abuja">Abuja</option>
								<option value="Delta">Delta</option>
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
							<button type="submit" name="search" type="submit" class="btn btn-danger btn-submit btn-block input-sm"><span class="glyphicon glyphicon-search"></span> Find bus</button>
						</div>
					</div>
				</div>
			</form>
		</div>

	</div>

    <div class="row buses">
		<?php
			$n = 0; $html = "";
			$_SESSION['travel_date'] = $travel_date;
			foreach ($bus_stmt AS $info) {
				$_SESSION['fare_id'] = $info['fare_id'];
				$fare = $info['fare'];

				$btn = "<a class='display-seats btn btn-primary pull-right' href='details.php' data-fare='{$fare}' data-route_id='$route_id' data-travel_date='{$_REQUEST['travel_date']}' data-num_of_seats='{$info['num_of_seats']}' data-fare_id='{$info['fare_id']}' data-bus_type_id='{$info['bus_type_id']}'><span class='glyphicon glyphicon-list'></span> Pick a seat</a>";

				$html .= "<div class='bus col-md-12' data-bus-type-id='{$info['bus_type_id']}'>
							<div class='pull-right text-right'>
								<br />$btn
								<div class='loading'><img src='images/progress-dots.gif' /></div>
							</div>

							Jibowu park<br />
							{$info['name']}: {$info['num_of_seats']} - Seater<br />
							<span class='fare'>$fare NGN</span>
					</div>
					<div data-bus_type_id='{$info['bus_type_id']}' class='show-seat clearfix' id='show-seat_{$info['bus_type_id']}'></div>";
				++$n;
			}
			echo $html;
		?>
	</div>
	<div class='hidden' id='picked_seat'></div>
</div>
<div class="clearfix"></div>
<?php require_once "includes/footer.php"; ?>
<script>
$(document).ready(function() {
	var destination = [];
	destination['Lagos'] = ["Enugu", "Abuja", "Delta", "PortHarcourt"];
	destination['Enugu'] = ["Abuja", "Lagos"];
	destination['PortHarcourt'] = ["Lagos", "Abuja"];
	destination['Abuja'] = ["Lagos", "Enugu"];
	destination['Delta'] = ["Lagos", "Abuja"];

	$("#origin").change(function() {
		var origin = $(this).val();
		var opt = '<option value="">-- Destination --</option>';
		$.each(destination[origin], function(i, val) {
			opt += "<option value='" + val + "'>" + val + "</option>\n";
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
