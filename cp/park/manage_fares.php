<?php
require "includes/head.php";
require "includes/side-bar.php";
require_once "../../api/models/fare.class.php";
require_once "../../api/models/travelparkmap.class.php";
require_once "../../api/models/travelvehicle.class.php";
require_once "../../api/models/trip.class.php";
require_once "../helpers/utils.php";

$fare = new Fare();
$travel_park_map = new TravelParkMap();
$travel_vehicle_model = new TravelVehicle();
$trip_model = new Trip();
$travel_trips = $trip_model->getByStateTravel($_SESSION['state_id'], $_SESSION['travel_id']);

// Effect price modification
/*if (isset($_POST['change_fare'])) {
    $_POST['travel_id'] = $_SESSION['travel_id'];
    $fare->editFare($_POST);
}*/
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
                                        $vehicle_types = array('name' => array(), 'id' => array(), 'order' => array(), 'check' => array());
                                        foreach ($travel_trips as $travel_trip) {
                                            if (!in_array($travel_trip->departure.">".$travel_trip->vehicle_type_id, $vehicle_types['check'])) {
                                                printf("<th class='text-right'>%s %s ( ₦ )</th>", ordinal($travel_trip->departure), $travel_trip->vehicle_name);
                                                $vehicle_types['name'][] = $travel_trip->vehicle_name;
                                                $vehicle_types['id'][] = $travel_trip->vehicle_type_id;
                                                $vehicle_types['order'][] = $travel_trip->departure;
                                                $vehicle_types['check'][] = $travel_trip->departure.">".$travel_trip->vehicle_type_id;
                                            }
                                        }
                                        ?>
                                        <th style='text-align:center'>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $park_maps = $travel_park_map->getTravelParkParkMaps($_SESSION['travel_id'], $_SESSION['park_id']);

                                $_travel_trips = array();
                                foreach ($park_maps as $park_map) {
                                    $_trips = $trip_model->getByParkTravelParkMap($_SESSION['park_id'], $_SESSION['travel_id'], $park_map->id);
                                    for($i = 0; $i < count($vehicle_types['id']); $i++) {
                                        $fare = $ffare = "";
                                        if (count($_trips) > 0) {
                                            for($j = 0; $j < count($_trips); $j++) {
                                                if ($_trips[$j]->departure.">".$_trips[$j]->vehicle_type_id == $vehicle_types['check'][$i]) {
                                                    $ffare = (is_numeric($_trips[$j]->fare) && $_trips[$j]->fare > 0) ? number_format($_trips[$j]->fare) : '';
                                                    $_travel_trips[$park_map->id][$vehicle_types['check'][$i]]['fare'] = $_trips[$j]->fare;
                                                    $_travel_trips[$park_map->id][$vehicle_types['check'][$i]]['trip_id'] = $_trips[$j]->id;
                                                }
                                            }
                                        }
                                    }
                                }

                                $n = 1;
                                foreach ($park_maps as $park_map) {
                                    printf("<tr><td>%d</td>", $n);
                                    printf("<td>%s - %s (%s)</td>", $park_map->origin_name, $park_map->destination_name, $park_map->destination_state);
                                    for($i = 0; $i < count($vehicle_types['id']); $i++) {
                                        if (isset($_travel_trips[$park_map->id][$vehicle_types['check'][$i]])) {
                                            $travel_trip = $_travel_trips[$park_map->id][$vehicle_types['check'][$i]];
                                            printf("<td class='text-right' data-tripid='%d' data-fare='%s'>%s</td>", $travel_trip['trip_id'], $travel_trip['fare'], number_format($travel_trip['fare']));
                                        } else {
                                            echo "<td></td>";
                                        }
                                    }
                                    echo "<td class='text-center'>
                                                <a href='' class='edit-fare'>
                                                    <i class='fa fa-pencil' title='Edit fare' data-toggle='tooltip'></i>
                                                </a>
                                            </td>
                                        </tr>";
                                    echo "</tr>";
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

<?php include_once "includes/footer.html"; ?>

<script type="text/javascript">
$(document).ready(function() {

    $(document.body).on('click', '.edit-fare', function(e) {
        e.preventDefault();
        var $thisTr = $(this).parents('tr');
        var check = false;

        $($thisTr).find('td').each(function() {
            var fare = $(this).data('fare');
            var trip_id = $(this).data('tripid');
            if (undefined != trip_id) {
                check = true;
                $(this).html(
                    $('<input />')
                        .data('trip_id', trip_id)
                        .val(fare)
                        .addClass('form-control')
                )
            }
        });
        if (check) {
            $(this).removeClass("edit-fare").html("<i class='fa fa-save'></i>").addClass('save-fares');
        }
    });

    $(document.body).on("click", ".save-fares", function(e) {
        e.preventDefault();
        var $thisTr = $(this).parents('tr');
        var fares = [];

        $($thisTr).find('td').each(function() {
            $txtBox = $(this).find('input');
            var fare = $txtBox.val();
            var trip_id = $txtBox.data('trip_id');
            if (undefined != trip_id) {
                var _fare = {'fare': fare, 'trip_id': trip_id};
                fares.push(_fare);
            }
        });
        $.post("../../ajax/misc_fns.php", {"op": "update-fare", "trips": fares}, function(d) {
            if (d.trim() == "Done") {
                $($thisTr).find('td').each(function() {
                    $txtBox = $(this).find('input');
                    var fare = $txtBox.val();
                    $txtBox.remove();
                    if (undefined != fare) {
                        $(this).text(parseInt(fare).toLocaleString('en-US'));
                    }
                });
            }
        });
        $(this).removeClass('save-fares').html("<i class='fa fa-pencil'></i>").addClass("edit-fare");
    });
});
</script>
