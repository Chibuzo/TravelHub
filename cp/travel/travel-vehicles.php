<?php
require "includes/head.php";
require "includes/side-bar.php";
require_once "../../includes/db_handle.php";
require_once "../../api/models/vehiclemodel.class.php";
require_once "../../api/models/travelvehicle.class.php";

$vehicle_model = new VehicleModel();
$travel_vehicle_model = new TravelVehicle();

if (isset($_POST['add_travel_vehicle_type'])) {
    $travel_vehicle_model->addVehicleType($_SESSION['travel_id'], $_POST['vehicle_name'], $_POST['vehicle_type_id'], $_POST['num_of_seats']);
}

$all_vehicle_types = $vehicle_model->getAllVehicleTypes();
$travel_vehicle_types = $travel_vehicle_model->getAllVehicleTypes($_SESSION['travel_id']);
?>
<style>
    .opt-icons .fa { color: #666; font-size: 17px; margin-left: 6px; }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage Vehicles
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Vehicles</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-5 col-xs-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h2 style='font-size: 20px' class="box-title"><i class="fa fa-bus"></i> &nbsp; Vehicle types</h2>
                    </div>
                    <div class="box-body">
                        <div>
                            <table class="table tablebordered table-striped">
                                <thead>
                                <tr>
                                    <th width='30'>S/No</th>
                                    <th>Vehicle</th>
                                    <th>No of Seats</th>
                                    <!--<th class='text-center'>Status</th>-->
                                    <!--<th class='text-center'>Option</th>-->
                                </tr>
                                </thead>
                                <tbody id="vehicle">
                                <?php
                                $html = ""; $n = 0;
                                foreach ($all_vehicle_types AS $_bus) {
                                    $n++;
                                    $html .= "<tr>
                                                  <td class='text-right'>$n</td>
                                                  <td>{$_bus->name}</td>
                                                  <td><span>{$_bus->num_of_seats}</span> Seats</td>
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

            <div class="col-md-7 col-xs-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h2 style='font-size: 20px' class="box-title"><i class="fa fa-bus"></i> &nbsp; Travel Vehicle types</h2>
                        <div class="box-tools pull-right">
                            <button data-toggle="modal" data-target="#vehicleModal" class="btn bg-olive"><i class="fa fa-plus"></i> New Vehicle Type</button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div>
                            <table class="table tablebordered table-striped">
                                <thead>
                                <tr>
                                    <th width='30'>S/No</th>
                                    <th>Vehicle</th>
                                    <th>No of Seats</th>
                                    <th>Vehicle Type</th>
                                    <th class='text-center'>Option</th>
                                </tr>
                                </thead>
                                <tbody id="vehicle">
                                <?php
                                $html = ""; $n = 0;
                                foreach ($travel_vehicle_types AS $_bus) {
                                    $n++;
                                    $html .= "<tr>
													<td class='text-right'>$n</td>
													<td>{$_bus->vehicle_name}</td>
													<td><span>{$_bus->num_of_seats}</span> Seats</td>
													<td>{$_bus->type_name}</td>
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
<!-- Modal -->
<div class="modal fade" id="vehicleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Travel Manager</h4>
            </div>
            <form action="" method="post" id="addState">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Vehicle Type</label>
                        <select name="vehicle_type_id" class="form-control" required>
                            <option value="">-- Vehicle Type --</option>
                            <?php
                            foreach ($all_vehicle_types AS $vehicle_type) {
                                $diff = $vehicle_type->num_of_seats . ' seats';
                                if (strstr($vehicle_type->name, 'Hiace')) {
                                    $diff = ($vehicle_type->num_of_seats == 14) ? 'One front seat' : 'Two front seats';
                                }
                                $states .= "<option value='{$vehicle_type->id}' data-num_of_seats='{$vehicle_type->num_of_seats}'>{$vehicle_type->name} ($diff)</option>";
                            }
                            echo $states;
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Vehicle Name</label>
                        <input class="form-control" type="text" placeholder="Vehicle Name" name="vehicle_name" id="vehicle_name" required>
                    </div>
                    <input type="hidden" name="num_of_seats" id="num_of_seats" />
                    <input type="hidden" name="add_travel_vehicle_type" value="yes" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>
<?php include_once "includes/footer.html"; ?>
<script>
$(document).ready(function() {
    $("select[name='vehicle_type_id']").change(function () {
        $("#num_of_seats").val($("select[name='vehicle_type_id'] option:selected").data('num_of_seats'));
    });
});
</script>
