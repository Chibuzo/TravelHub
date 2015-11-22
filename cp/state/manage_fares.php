<?php
require "includes/head.php";
require "includes/side-bar.php";
require_once "../../api/models/fare.class.php";
require_once "../../api/models/travelparkmap.class.php";
require_once "../../api/models/travelvehicle.class.php";

$fare = new Fare();
$travel_park_map = new TravelParkMap();
$travel_vehicle_model = new TravelVehicle();

// Effect price modification
if (isset($_POST['change_fare'])) {
    $_POST['travel_id'] = $_SESSION['travel_id'];
    $fare->editFare($_POST);
}
?>
<div class="content-wrapper">
  	<section class="content-header">
	  <h1>
		Route/Bus fares
		<small>Control panel</small>
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Route/Bus fares</li>
	  </ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-warning">
					<div class="box-header with-border">
						<h2 style='font-size: 18px' class="box-title"><i class="fa fa-money"></i> &nbsp;Manage Fares</h2>
					</div>
					<div class="box-body">
						<div>
							<table class='table table-striped table-bordered'>
								<thead>
									<tr>
										<th style="width: 10px">S/no</th>
										<th>Route</th>
										<?php
                                            $travel_vehicle_types = $travel_vehicle_model->getAllVehicleTypes($_SESSION['travel_id']);
                                            $vehicle_types = array();
											foreach ($travel_vehicle_types AS $_vehicles) {
												echo "<th class='text-right'>{$_vehicles->vehicle_name} ( ₦ )</th>";
												$vehicle_types['name'][] = $_vehicles->vehicle_name;
												$vehicle_types['id'][] = $_vehicles->id;
											}
										?>
										<th style='text-align:center'>Edit</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$park_maps = $travel_park_map->getTravelStateParkMaps($_SESSION['travel_id'],$_SESSION['state_id']);

									$n = 1;
									foreach ($park_maps AS $park_map) {
										echo "<tr data-park-map-id='{$park_map->id}' data-route-id='{$travel_park_map->getRoute($park_map->id)->id}'><td>$n</td>
												<td>{$park_map->origin_name} - {$park_map->destination_name} &nbsp; ({$park_map->destination_state})</td>";

										$fares = $fare->getFareByParkMapId($park_map->id, $_SESSION['travel_id']);

										if (count($fares) > 0) {
                                            if (count($vehicle_types) > 0) {
                                                for ($i = 0; $i < count($vehicle_types['id']); $i++) {
                                                    $ffare = (is_numeric($fares[$i]->fare) && $fares[$i]->fare > 0) ? number_format($fares[$i]->fare) : '';
                                                    echo "<td class='text-right' data-fare='{$fares[$i]->fare}'>$ffare</td>";
                                                }
                                            }
										} else {
                                            if (count($vehicle_types) > 0) {
                                                for ($l = 0; $l < count($vehicle_types['id']); $l++) {
                                                    echo "<td data-fare=''></td>";
                                                }
                                            }
										}
										echo "<td class='text-center'>
													<a href='' class='edit-route-info' data-toggle='modal' data-target='#myModal' data-fare_id=''>
													<i class='fa fa-pencil' title='Edit fare' data-toggle='tooltip'></i></a>
												</td>
											</tr>";
										$n++;
									}
								?>
								</tbody>
							</table>
						</div>
					</div>
					<!--<div class="box-footer">

					</div>-->
				</div>
			</div>
		</div>
	</section>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Change Fare</h4>
			</div>
			<form method="post" action="" id="form-fare">
			  <div class="modal-body">
				<div id='route' class='small_head'></div>
				<?php
					for ($i = 0; $i < count($vehicle_types['id']); $i = $i + 2) {
						echo "<div class='form-group'>
								<div class='row'>
									<div class='col-md-6'>
										<label>{$vehicle_types['name'][$i]} Fare</label>
										<input type='text' name='{$vehicle_types['id'][$i]}' value='' class='form-control' />
									</div>";

									if (isset($vehicle_types['id'][$i + 1])) {
										echo "<div class='col-md-6'>
												<label>" . $vehicle_types['name'][$i + 1] . " Fare</label>
												<input type='text' name='" . $vehicle_types['id'][$i + 1] . "' value='' class='form-control' />
											</div>";
									}
						echo "</div></div>";
					}
				?>
				</div>
				<input type="hidden" name="park_map_id" id="park_map_id" value="" />
				<input type="hidden" name="route_id" id="route_id" value="" />

				<div class="modal-footer">
				  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				  <input type="submit" class="btn btn-primary" name="change_fare" value="Save changes" />
				</div>
			</form>
		</div>
	</div>
</div>

<?php include_once "includes/footer.html"; ?>

<script type="text/javascript">
$(document).ready(function() {
	$('.edit-route-info').click(function(e) {
		e.preventDefault();
		var $thisTr = $(this).parents('tr');
		var park_map_id = $thisTr.data("park-map-id");
		var route_id = $thisTr.data("route-id");
		$("#park_map_id").val(park_map_id);
		$("#route_id").val(route_id);

		var fare = 0;
		$('#form-fare').find("input[type='text']").each(function(i, input) {
			fare = $thisTr.find("td:nth-child(" + (i + 3) + ")").data("fare");
			input.value = fare;
		});
	});
});
</script>