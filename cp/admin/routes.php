<?php
require "includes/head.php";
require "includes/side-bar.php";
require_once "../../includes/db_handle.php";
require_once "../../api/models/vehiclemodel.class.php";
require_once "../../api/models/routemodel.class.php";

$bus = new VehicleModel();
$route = new RouteModel();

if (isset($_POST['add_vehicle'])) {
	$bus->addVehicleType($_POST['vehicle_name'], $_POST['num_of_seats']);
}
elseif (isset($_POST['add_route'])) {
	$route->addRoute($_POST['origin'], $_POST['destination']);
}

?>
<style>
.opt-icons .fa { color: #666; font-size: 17px; margin-left: 6px; }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>
		Routes & Vehicles
		<small>Control panel</small>
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Routes & Vehicles</li>
	  </ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-6 col-xs-12">
				<div class="box box-warning">
					<div class="box-header with-border">
						<h2 style='font-size: 18px' class="box-title"><i class="fa fa-road"></i> &nbsp;Manage Routes</h2>
						<div class="box-tools pull-right">
							<button data-toggle="modal" data-target="#hotelModal" class="btn bg-olive hidden"><i class="fa fa-plus"></i> New Route</button>
						</div>
					</div>
					<div class="box-body">
						<div>
							<div id="route-div">
								<form method="post">
									<div class="row">
										<div class="col-md-5">
											<div class="form-group" id="origin">
												<select name="origin" class="form-control" required>
													<option value="">-- Origin ( From ) --</option>
													<?php
														$states = '';
														foreach ($db->query("SELECT * FROM states ORDER BY state_name") AS $st) {
															$states .= "<option value='{$st['state_name']}'>{$st['state_name']}</option>";
														}
														echo $states;
													?>
												</select>
											</div>
										</div>

										<div class="col-md-5">
											<div class="form-group" id="destination">
												<select name="destination" class="form-control" required>
													<option value="">-- Destination ( To ) --</option>
													<?php
														echo $states;
													?>
												</select>
											</div>
										</div>
										<input type="hidden" name="add_route" value="yes" />

										<div class="col-md-2">
											<button type="submit" name="addRoute" class="btn bg-olive"><i class='fa fa-plus'></i> Add</button>
										</div>
									</div>
								</form>
							</div>

							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th width='30'>S/No</th>
										<th>Origin</th>
										<th>Destination</th>
										<th></th>
									</tr>
								</thead>
								<tbody id="route-tbl">
								<?php
									$html = ""; $n = 0;
									foreach ($route->getAllRoutes() AS $rout) {
										$n++;
										$html .= "<tr>
													<td class='text-right'>$n</td>
													<td>{$rout->origin}</td>
													<td>{$rout->destination}</td>
													<td class='opt-icons text-center' id='{$rout->id}'>
														<a href='' class='edit-route' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>
														<a href='' class='remove-route' title='Remove' data-toggle='tooltip'><i class='fa fa-trash-o'></i></a>
													</td>
												</tr>";
									}
									echo $html;
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-xs-12">
				<div class="box box-danger">
					<div class="box-header with-border">
						<h2 style='font-size: 20px' class="box-title"><i class="fa fa-bus"></i> &nbsp; Manage vehicle types</h2>
						<div class="box-tools pull-right">
							<button data-toggle="modal" data-target="#hotelModal" class="btn btn-warning hidden"><i class="fa fa-plus"></i> New Vehicle</button>
						</div>
					</div>
					<div class="box-body">
						<div>
							<div id="vehicle-div">
								<form method="post">
									<div class="row">
										<div class="col-md-7">
											<div class="form-group">
												<input type="text" name="vehicle_name" class="form-control" placeholder="Vehicle type" required />
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<input type="text" name="num_of_seats" class="form-control" placeholder="No of seats" required />
											</div>
										</div>
										<input type="hidden" name="add_vehicle" value="yes" />

										<div class="col-md-2">
											<button type="submit" name="addVehicle" class="btn btn-warning"><i class='fa fa-plus'></i> Add</button>
										</div>
									</div>
								</form>
							</div>
							<table class="table tablebordered table-striped">
								<thead>
									<tr>
										<th width='30'>S/No</th>
										<th>Vehicle</th>
										<th>No of Seats</th>
										<!--<th class='text-center'>Status</th>-->
										<th class='text-center'>Option</th>
									</tr>
								</thead>
								<tbody id="vehicle">
								<?php
									$html = ""; $n = 0;
									foreach ($bus->getAllVehicleTypes() AS $_bus) {
										$n++;
										$html .= "<tr>
													<td class='text-right'>$n</td>
													<td>{$_bus->name}</td>
													<td><span>{$_bus->num_of_seats}</span> Seats</td>
													<td class='opt-icons text-center' id='{$_bus->id}'>
														<a href='' class='edit-vehicle' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>
														<a href='' class='delete' title='Remove' data-toggle='tooltip'><i class='fa fa-trash-o'></i></a>
													</td>
												</tr>";
									}
									echo $html;
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<?php include_once "includes/footer.html"; ?>
<script>
$(document).ready(function() {
	$(".delete, .remove-route").click(function(e) {
		e.preventDefault();
		var $this = $(this);
		var msg = "Are you sure you want to delete this vehicle type?";
		var op = 'delete-vehicle_type';
		if ($this.attr("class") == "remove-route") {
			msg = "Are you sure you want to delete this route? The fares associated with it will also be removed.";
			op = 'remove-route';
		}

		if (confirm(msg)) {
			var id = $this.parent('td').attr("id");

			$.post("../ajax/misc_fns.php", {'op': op, 'id': id}, function(d) {
				if (d.trim() == 'Done') {
					$this.parents("tr").fadeOut();
				}
			});
		}
	});

	// edit vehicle
	$("#vehicle").on("click", ".edit-vehicle", function(e) {
		e.preventDefault();
		var parentTr = $(this).parents("tr");

		var name = parentTr.find("td:nth-child(2)").text();
		var num = parentTr.find("td:nth-child(3) span").text();

		var nameInput = "<input type='text class='form-control' name='bus_type' value='" + name + "' />";
		var seatInput = "<input type='text class='form-control' name='num_of_seats' value='" + num + "' style='width: 35px' /> Seats";

		parentTr.find("td:nth-child(2)").html(nameInput);
		parentTr.find("td:nth-child(3)").html(seatInput);

		$(this).removeClass('edit-vehicle').html("<i class='fa fa-save'></i>").addClass("save-vehicle");
	});

	// update vehicle
	$("#vehicle").on("click", ".save-vehicle", function(e) {
		e.preventDefault();
		var parentTr = $(this).parents("tr");
		var id = $(this).parent("td").attr("id");
		var name = parentTr.find("input[name=bus_type]").val();
		var num = parentTr.find("input[name=num_of_seats]").val();

		$.post("../../ajax/misc_fns.php", {"op": "update-bus", "name": name, "num_of_seat": num, "id": id}, function(d) {
			if (d.trim() == "Done") {
			}
		});
		parentTr.find("td:nth-child(2)").text(name);
		parentTr.find("td:nth-child(3)").html("<span>" + num + "</span> Seats");
		$(this).removeClass('save-vehicle').html("<i class='fa fa-pencil'></i>").addClass("edit-vehicle");
	});

	// edit route
	$("#route-tbl").on("click", ".edit-route", function(e) {
		e.preventDefault();
		var parentTr = $(this).parents("tr");
		var id = $(this).parent("td").attr("id");

		var origin = parentTr.find("td:nth-child(2)").text();
		var destination = parentTr.find("td:nth-child(3)").text();

		parentTr.find("td:nth-child(2)").html($("#origin").html());
		parentTr.find("td:nth-child(3)").html($("#destination").html());

		parentTr.find("td:nth-child(2)").find('select[name=origin]').find("option").filter(function(i) {
			return $.trim(origin) === $(this).text().trim();
		}).attr("selected", "selected");

		parentTr.find("td:nth-child(3)").find('select[name=destination]').find("option").filter(function(i) {
			return $.trim(destination) === $(this).text().trim();
		}).attr("selected", "selected");

		$(this).removeClass('edit-route').html("<i class='fa fa-save'></i>").addClass("save-route");
	});

	// update route
	$("#route-tbl").on("click", ".save-route", function(e) {
		e.preventDefault();
		var parentTr = $(this).parents("tr");
		var id = $(this).parent("td").attr("id");
		var origin = parentTr.find("select[name=origin]").val();
		var destination = parentTr.find("select[name=destination]").val();

		$.post("../../ajax/misc_fns.php", {"op": "update-route", "origin": origin, "destination": destination, "id": id}, function(d) {
			if (d.trim() == "Done") {
			}
		});
		parentTr.find("td:nth-child(2)").text(origin);
		parentTr.find("td:nth-child(3)").text(destination);
		$(this).removeClass('save-route').html("<i class='fa fa-pencil'></i>").addClass("edit-route");
	});

});
</script>
