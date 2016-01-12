<?php
require "includes/head.php";
require "includes/side-bar.php";
require_once "../../api/models/fare.class.php";
require_once "../../api/models/travelparkmap.class.php";
require_once "../../api/models/travelvehicle.class.php";
require_once "../../api/models/trip.class.php";

$fare = new Fare();
$travel_park_map = new TravelParkMap();
$travel_vehicle_model = new TravelVehicle();
$trip_model = new Trip();

$vehicle_types = $travel_vehicle_model->getAllVehicleTypes($_SESSION['travel_id']);
$park_maps = $travel_park_map->getTravelStateParkMaps($_SESSION['travel_id'], $_SESSION['state_id']);

if (isset($_POST['op'])) {
    if ($_POST['op'] == 'create') {
        extract($_POST);
        $amenities = implode($amenities, ">>>>");
        $_route = $travel_park_map->getRoute($route);

        $rslt = $trip_model->addTrip($route, $departure, $_SESSION['travel_id'], $_SESSION['state_id'], $_route->id, $vehicle_type, $amenities, $departure_time);
    }
}

$travel_trips = $trip_model->getByStateTravel($_SESSION['state_id'], $_SESSION['travel_id']);

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
            <div class="col-md-6">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h2 style='font-size: 18px' class="box-title"><i class="fa fa-car"></i> &nbsp;New Trip</h2>
                    </div>
                    <div class="box-body">
                        <div>
                            <form class="form-horizontal" action="" method="post">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="depature">Departure</label>

                                        <div class="col-sm-5">
                                            <select name="departure" id="departure" class="form-control" required>
                                                <option value="" selected>-- Departure --</option>
                                                <option value="first" selected> First Bus</option>
                                                <option value="second" selected> Second Bus </option>
                                                <option value="third" selected> Third Bus</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" name="departure_time" class="form-control" id="depature_time" placeholder="Departure Time" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="route">Route</label>

                                        <div class="col-sm-10">
                                            <select name="route" id="route" class="form-control" required>
                                                <option value="" selected>-- Route --</option>
                                                <?php
                                                foreach ($park_maps as $park_map) {
                                                    printf("<option value='%s'>%s &#09; to %s (%s)</option>", $park_map->id, $park_map->origin_name, $park_map->destination_state, $park_map->destination_name);
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="vehicle_types">Vehicle Type</label>

                                        <div class="col-sm-10">
                                            <select name="vehicle_type" id="vehicle_types" class="form-control" required>
                                                <option value="" selected>-- Vehicle Type --</option>
                                                <?php
                                                foreach ($vehicle_types as $vehicle) {
                                                    printf("<option value='%s'>%s</option>", $vehicle->id, $vehicle->vehicle_name);
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="inputEmail3">Amenities</label>

                                        <div class="col-sm-10">
                                            <select data-placeholder="-- Select Amenities --" name="amenities[]" id="amenities" multiple="" class="form-control" tabindex="-1" aria-hidden="true">
                                                <option>A/C</option>
                                                <option>Food</option>
                                                <option>TV</option>
                                                <option>Refreshment</option>
                                                <option>Restrooms</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                              <!-- /.box-body -->
                                <div class="box-footer">
                                    <input type="hidden" name="op" value="create">
                                    <button class="btn btn-info" type="submit">Save</button>
                                </div>
                              <!-- /.box-footer -->
                            </form>
                        </div>
                    </div>
                    <!--<div class="box-footer">

                    </div>-->
                </div>
            </div>
            <div class="col-md-6">
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
                                        <th>Order</th>
                                        <th>Amenities</th>
                                        <th class="text-center">Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                foreach ($travel_trips as $trip) {
                                    echo "<tr>";
                                    printf("<td>%s</td>", $i);
                                    printf("<td>%s</td>", $trip->origin_name . " to " . $trip->destination_name);
                                    printf("<td>%s</td>", $trip->departure);
                                    printf("<td>%s</td>", preg_replace("/>>>>/", ", ", $trip->amenities));
                                    printf("<td class='text-center'><a href='#'><i class='fa fa-pencil' data-toggle='tooltip' title='' data-original-title='Edit fare'></i></td>");
                                    echo "</tr>";
                                    $i++;
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

<?php include_once "includes/footer.html"; ?>

<script type="text/javascript">
$(document).ready(function() {
    
});
</script>
