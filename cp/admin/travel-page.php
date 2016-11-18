<?php
require "includes/head.php";
require "includes/side-bar.php";
require_once "../../includes/db_handle.php";

require_once "../../api/models/travel.class.php";
//require_once "../../api/models/travelparkmap.class.php";

$travel = new Travel();

$travel_id = $_GET['travel_id'];
$travel_details = $travel->getTravel($travel_id);

// in case someone needs to add states for travels
$states = '';
foreach ($db->query("SELECT * FROM states ORDER BY state_name") AS $st) {
    $states .= "<option value='{$st['id']}'>{$st['state_name']}</option>";
}
?>
<link rel="stylesheet" href="../bootstrap/css/multi-select.css" type="text/css" />
<link href="../plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
<style>
    .opt-icons .fa { color: #666; font-size: 17px; margin-left: 6px; }

    .dropdown-menu {
        left: -144px;
        top: 29px;
    }

    .accordion-link {
        padding: 10px;
        text-align: left;
        font-weight: bold;
        border: #ccc solid thin;
        cursor: pointer;
        border-bottom: none;
        background-color: #f8f8f8;
    }

    .accordion-content {
        display: none;
        padding-top: 20px;
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $travel_details->abbr; ?>
            <small>Details and Settings</small>
        </h1>
        <ol class="breadcrumb">
            <a href="travels.php" class="btn btn-danger"><i class="fa fa-caret-left"></i> Go Back</a>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-5 col-xs-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h2 style='font-size: 18px' class="box-title"><i class="fa fa-map-marker"></i> &nbsp;States</h2>
                        <div class="box-tools pull-right">
                            <button data-toggle="modal" data-target="#stateModal" class="btn bg-olive btn-sm"><i class="fa fa-plus"></i> New State</button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div>
                            <?php
                            $travel_states = $travel->getTravelStates($travel_id);
                            if (is_array($travel_states) && count($travel_states) > 0):
                                ?>
                                <table class="table tabl-bordered table-striped">
                                    <thead>
                                    <tr>
<!--                                        <th width='30'>S/No</th>-->
                                        <th>State</th>
                                        <th>Parks</th>
                                        <th>Status</th>
                                        <th>Online</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody id="states-tbl">
                                    <?php
                                    $html = ""; $n = 0;
                                    foreach ($travel_states AS $row) {
                                        $n++;
                                        $status = $row->status == 1 ? 'Checked' : '';
                                        $online = $row->online == 1 ? 'Checked' : '';
                                        $html .= "<tr id='{$row->state_id}'>
													<td>{$row->state_name}</td>
													<td class='text-right'>" . $travel->getNumOfParksByState($travel_id, $row->state_id) . "</td>
													<td class='text-center'>
													    <div class='onoffswitch'>
                                                            <input type='checkbox' data-toggle='modal' data-target='#confirmModal' class='onoffswitch-checkbox' id='{$row->state_name}-status' data-level='state' data-field='status' $status>
                                                        </div>
													</td>
													<td class='text-center'>
													    <div class='onoffswitch'>
                                                            <input type='checkbox' data-toggle='modal' data-target='#confirmModal' class='onoffswitch-checkbox' id='{$row->state_name}-online-status' data-level='state' data-field='online' $online>
                                                        </div>
													</td>
													<td class='opt-icons text-center'>
													    <a href='' class='view-parks'><i class='fa fa-arrow-right'></i></a>
													</td>
												</tr>";
                                    }
                                    echo $html;
                                    ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div>
                                    <div class="callout callout-warning">
                                        <p>No state has been added for this travel.</p>
                                    </div>
                                </div>
                                <hr />
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7 col-xs-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h2 style='font-size: 20px' class="box-title"><i class="fa fa-map-marker"></i> &nbsp;<span id='selected-state'></span> Parks</h2>
                        <div class="box-tools pull-right">
                            <button data-toggle="modal" data-target="#parkModal" id="add-park-btn" class="btn bg-olive btn-sm hidden"><i class="fa fa-plus"></i> New Park</button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="detail-div">
                            <table class="table tablebordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Park</th>
                                        <th style="width: 50px">Routes</th>
                                        <th style="width: 70px">Status</th>
                                        <th style="width: 70px">Online</th>
                                        <th>Contact</th>
                                        <th style="width: 30px"></th>
                                    </tr>
                                </thead>
                                <tbody id="state-parks">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<!-- State Modal -->
<div class="modal fade" id="stateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add State Manager</h4>
            </div>
            <form action="" method="post" id="addState">
                <div class="modal-body">
                    <div class="form-group">
                        <label>State</label>
                        <select name="state_id" id="state_id" class="form-control" required>
                            <option value="">-- State --</option>
                            <?php
                            echo $states;
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input class="form-control" type="text" placeholder="Full Name" name="full_name" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" type="text" placeholder="Username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" placeholder="Password" name="password" id="password" required>
                    </div>
                    <div class="form-group">
                        <label>Verify Password</label>
                        <input class="form-control" type="password" placeholder="Verify Password" name="v_password" id="v_password" required>
                    </div>
                    <input type="hidden" name="op" value="add-new-travel-state" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default modal-close" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="parkModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Park Manager</h4>
            </div>
            <form action="" method="post" id="addPark">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Park</label>
                        <select name="park_id" class="form-control" id="park_id" required>
                            <option value="">-- Parks --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Park Address</label>
                        <textarea class="form-control" placeholder="Enter park address" name="address" id="address"></textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Telephone</label>
                            <input class="form-control" type="text" placeholder="Phone number" name="telephone" id="telephone">
                        </div>
                        <div class="col-md-6">
                            <label>Mobile</label>
                            <input class="form-control" type="text" placeholder="Mobile number" name="mobile" id="mobile">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Full Name</label>
                            <input class="form-control" type="text" placeholder="Full Name" name="full_name" id="full_name" required>
                        </div>

                        <div class="col-md-6">
                            <label>Username</label>
                            <input class="form-control" type="text" placeholder="Username" name="username" id="username" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Password</label>
                            <input class="form-control" type="password" placeholder="Password" name="password" id="password" required>
                        </div>
                        <div class="col-md-6">
                            <label>Verify Password</label>
                            <input class="form-control" type="password" placeholder="Verify Password" name="v_password" id="v_password" required>
                        </div>
                    </div>
                    <input type="hidden" name="op" value="add-new-park" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default modal-close" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="editPark" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Park Manager</h4>
            </div>
            <form action="" method="post" id="update_park">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input class="form-control" type="text" placeholder="Full Name" name="full_name" id="u_full_name" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" type="text" placeholder="Username" name="username" id="u_username" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" placeholder="Password" name="password" id="u_password" required>
                    </div>
                    <div class="form-group">
                        <label>Verify Password</label>
                        <input class="form-control" type="password" placeholder="Verify Password" name="v_password" id="u_v_password" required>
                    </div>
                    <input type="hidden" name="update_park" value="yes" />
                </div>
                <input type="hidden" id="user_id" name="user_id" value="" />
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirmation Alert</h4>
            </div>
            <div class="modal-body text-center">
                Are you sure you want to alter this setting?
            </div>
            <div id="settings-data"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirm-setting" data-dismiss="modal">Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- manage route modal -->
<div class="modal fade" id="manageRouteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Manage Routes</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="new_park_map">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="origin" id="origin-park" class="form-control" required>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="destination" id="destination-state" class="form-control" required>
                                    <option value="" selected>Destination State</option>
                                    <?php
                                    $db->query("SELECT * FROM states ORDER BY state_name");
                                    $_states = $db->fetchAll('obj');
                                    foreach ($_states AS $st) {
                                        printf("<option value='%d'>%s</option>", $st->id, $st->state_name);
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="destination_park" id="destination-park" class="form-control" required>
                                    <option value="">Destination Park</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="op" value="add-park-route" />

                        <div class="col-md-1">
                            <button type="submit" name="addParkMap" class="btn bg-olive"><i class='fa fa-plus'></i> Add</button>
                        </div>
                    </div>
                </form>

                <div id="detail-div">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th width='30'>S/No</th>
                            <th>Origin</th>
                            <th>Destination</th>
                            <th class='text-center'>Option</th>
                        </tr>
                        </thead>
                        <tbody id="tbody-routes">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default modal-close hidden" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<!-- manage trips modal -->
<div class="modal fade" id="manageTripsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Manage Trips</h4>
            </div>
            <div class="modal-body">
                <div class="accordion-link" id="trip-form">Add New Trips</div>
                <div id="trip-form-div" class="accordion-content">
                    <form class="form-horizontal" action="" method="post" id="form-trip">
                        <div class="">
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <select name="park_map_id" id="park_map_id" class="form-control" required>
                                        <option value="" selected>-- Select Route --</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select name="vehicle_type_id" id="vehicle_types" class="form-control" required>
                                        <option value="" selected>-- Vehicle Type --</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <input class="form-control" type="number" min="100" step="100" max="100000" name="fare" id="fare" placeholder="Fare" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <input class="form-control" type="number" name="departure_order" id="departure_order" placeholder="Departure Order" required/>
                                </div>

                                <div class="col-sm-6">
                                    <div class="input-group bootstrap-timepicker timepicker col-sm-12">
                                        <input id="departure_time" name="departure_time" readonly type="text" placeholder="Departure time" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div style="margin-left:16px">
                                    <label class="" for="amenities">Vehicle Amenities</label>
                                    <select name="amenities[]" id="amenities" multiple="multiple" class="form-control">
                                        <option value="A/C">A/C</option>
                                        <option value="Food">Food</option>
                                        <option value="TV">TV</option>
                                        <option value="Refreshment">Refreshment</option>
                                        <option value="Restrooms">Restrooms</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="trip_id" id="trip_id" />
                            <input type="hidden" name="op" id="op" value="add-trip">
                            <button class="btn btn-primary" type="submit"><i class='fa fa-save'></i> &nbsp;Save Trip</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>

                <div class="accordion-link" id="trip-table">Display Trips</div>
                <div id="trip-table-div" class="accordion-content">
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <th>Route</th>
                                <th>Order</th>
                                <th>Amenities</th>
                                <th>Time</th>
                                <th>Fare</th>
                                <th class="text-center">Edit</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-trips">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default modal-close hidden" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<?php include_once "includes/footer.html"; ?>
<script type="text/javascript" src="../bootstrap/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="../plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script>
$(document).ready(function() {
    var travel_id = <?php echo $travel_id; ?>;

    // add new travel state
    $('#addState').on('submit', function(e) {
        e.preventDefault();
        var password = $('#password').val();
        var v_password = $('#v_password').val();

        if (password !== v_password) {
            alert("Password do not match.");
        }

        $.post('../../ajax/misc_fns.php', $(this).serialize() + '&travel_id=' + travel_id, function(d) {
            if ($.isNumeric(d)) {
                var state_name = $("#state_id option:selected").text();
                var state_id = $("#state_id option:selected").val();
                var tr = "<tr id='" + state_id + "'>"
                    +"<td>" + state_name + "</td>"
                    +"<td class='text-right'>0</td>"
                    +"<td class='text-center'>"
                        +"<div class='onoffswitch'>"
                            +"<input type='checkbox' data-toggle='modal' data-target='#confirmModal' class='onoffswitch-checkbox' id='" + state_name + "-status' data-level='state' data-field='status' checked>"
                        +"</div>"
                    +"</td>"
                    +"<td class='text-center'>"
                        +"<div class='onoffswitch'>"
                            +"<input type='checkbox' data-toggle='modal' data-target='#confirmModal' class='onoffswitch-checkbox' id='" + state_name + "-online-status' data-level='state' data-field='online'>"
                        +"</div>"
                    +"</td>"
                    +"<td class='opt-icons text-center'>"
                        +"<a href='' class='view-parks'><i class='fa fa-arrow-right'></i></a>"
                    +"</td>"
                +"</tr>";
                $("#states-tbl").append(tr);
            }
            $('#addState')[0].reset();
        });
        $(".modal-close").click();
    });


    // add new park
    $('#addPark').on('submit', function(e) {
        e.preventDefault();
        var password = $('#password').val();
        var v_password = $('#v_password').val();

        if (password !== v_password) {
            alert("Password do not match.");
        }

        $.post('../../ajax/misc_fns.php', $(this).serialize() + '&travel_id=' + travel_id, function(d) {
            if ($.isNumeric(d)) {
                var park = $('#park_id option:selected').text();
                var park_id = $("#park_id option:selected").val();
                var tr = "<tr id='" + park_id + "' data-park='" + park + "'>"
                    +"<td>" + park + "</td>"
                    +"<td class='text-right'>0</td>"
                    +"<td class='text-center'>"
                        +"<div class='onoffswitch'>"
                            +"<input type='checkbox' data-toggle='modal' data-target='#confirmModal' class='onoffswitch-checkbox' id='" + park + "-status' data-level='park' data-field='status' checked>"
                        +"</div>"
                    +"</td>"
                    +"<td class='text-center'>"
                        +"<div class='onoffswitch'>"
                            +"<input type='checkbox' data-toggle='modal' data-target='#confirmModal' class='onoffswitch-checkbox' id='" + park + "-online' data-level='park' data-field='online'>"
                        +"</div>"
                    +"</td>"
                    +"<td>" + $('#address').val() + " <br> " + $('#telephone').val() + ", " + $('#mobile').val() + "</td>"
                    +"<td class='dropdown'>"
                        +"<a href='' class='btn btn-default btn-xs' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true' title='Configuration'><i class='fa fa-cogs fa-lg'></i></a>"
                        +"<ul class='dropdown-menu'>"
                        +"<li class='dropdown-header'>" + park + " Configuration Settings</li>"
                    +"<li><a href='#' class='manage-route' data-toggle='modal' data-target='#manageRouteModal'>Manage Routes</a></li>"
                    +"<li><a href='#' class='manage-trips' data-toggle='modal' data-target='#manageTripsModal'>Manage Trips</a></li>"
                    +"</ul>"
                    +"</td>"
                    +"</tr>";
                $("#state-parks").append(tr);
            }
            $('#addPark')[0].reset();
        });
        $(".modal-close").click();
    });

    /*$('#destination').on('change', function() {
        var id = $(this).val();
        $.post("../../ajax/misc_fns.php", {"op": "get-state-parks", "state_id": id}, function(d) {
            var parks = JSON.parse(d);
            var _select = $("#destination_park");
            _select.html('<option value="">-- Destination (Park) --</option>');
            $.each(parks, function(i, val) {
                _select.append($('<option />', { value: val.id, text: val.park }));
            });
        });
    });*/


    /*$('#update_park').on('submit', function(e) {
        var password = $('#u_password').val();
        var v_password = $('#u_v_password').val();

        if (password !== v_password) {
            e.preventDefault();
            alert("Password do not match.");
        }
    });

    $('.edit-park').on('click', function() {
        var $thisTr = $(this).parents('td');
        $('#user_id').val($thisTr.data('userid'));
        $('#u_full_name').val($thisTr.data('fullname'));
        $('#u_username').val($thisTr.data('username'));
    });
*/
    // view state parks
    $('#states-tbl').on('click', '.view-parks', function(e) {
        e.preventDefault();
        var state_id = $(this).parents('tr').attr('id');
        var state_name = $(this).parents('tr').find("td:nth-child(1)").text();

        $.ajax({
            url: '../../ajax/travel-page.php',
            type: 'POST',
            data: {'op': 'get-travel-state-parks', 'travel_id': travel_id, 'state_id': state_id},
            success: function(d) {
                $("#state-parks").html(d);
            }
        });
        $('#selected-state').text(state_name);
        var opts = "<option value=''>-- Parks in " + state_name + " --</option>";
        opts += getStateParks(state_id, function(_opts) {
            opts += _opts;
            $("#park_id").html(opts);
        });
        $("#add-park-btn").removeClass("hidden");
    });

    // flip switch settings
    var clickedCheckbox;
    $(".box-body").on('click', '.onoffswitch-checkbox', function(e) {
        e.preventDefault(); // prevent the flip switch from changing
        clickedCheckbox = $(this);
    });


    // confirm settings
    $("#confirm-setting").on('click', function() {
        var value = '';
        if ($(clickedCheckbox).prop('checked') == true) {
            $(clickedCheckbox).prop('checked', false);
            value = 0;
        } else {
            $(clickedCheckbox).prop('checked', true);
            value = 1;
        }
        var field = $(clickedCheckbox).data('field');
        var level = $(clickedCheckbox).data('level');

        if (level == 'state') {
            var state_id = $(clickedCheckbox).parents('tr').attr('id');
            $.post('../../ajax/travel-page.php', {
                'op': 'alter-state-setting',
                'travel_id': travel_id,
                'state_id': state_id,
                'field': field,
                'value': value
            });
        } else if (level == 'park') {
            var park_id = $(clickedCheckbox).parents('tr').attr('id');
            $.post('../../ajax/travel-page.php', {
                'op': 'alter-park-setting',
                'travel_id': travel_id,
                'park_id': park_id,
                'field': field,
                'value': value
            });
        }
    });


    // manage routes
    $('#state-parks').on('click', '.manage-route', function(e) {
        var $parentTr = $(this).parents('tr');
        var park_id = $parentTr.attr('id');
        var park = $parentTr.data('park');

        $.ajax({
            url: '../../ajax/misc_fns.php',
            type: 'POST',
            dataType: 'json',
            data: {'op': 'get-park-routes', 'park_id': park_id, 'travel_id': travel_id},
            success: function(d) {
                var routes = '';
                $.each(d, function(i, val) {
                    var n = i + 1;
                    routes += "<tr data-route_id='" + val.id + "'>"
                            +"<td>" + n + "</td>"
                            +"<td>" + val.origin_name + "</td>"
                            +"<td>" + val.destination_state + " (" + val.destination_name + ")</td>"
                            +"<td class='opt-icons text-center'>"
                                +"<a href='' class='edit-vehicle' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>"
                                +"<a href='' class='delete' title='Remove' data-toggle='tooltip'><i class='fa fa-trash-o'></i></a>"
                            +"</td></tr>";
                });
                $("#tbody-routes").html(routes);
            }
        });
        $("#origin-park").html("<option value='" + park_id + "'>" + park + "</option>");
    });


    // fetch destination park on add route form
    $("#destination-state").change(function() {
        var state_id = $(this).val();
        var opts = "<option value=''>Destination Park</option>";
        getStateParks(state_id, function(_opts) {
            opts += _opts;
            $("#destination-park").html(opts);
        });
    });


    // Add route for park
    $("#new_park_map").submit(function(e) {
        e.preventDefault();
        if ($('#destination_park option:selected').text() == $('#origin-park').text()) {
            alert("Destination must be different from origin");
        }

        $.post('../../ajax/misc_fns.php', $(this).serialize() + '&travel_id=' + travel_id);
        $("#new_park_map")[0].reset();
        $('.modal-close').click();
    });


    // manage trips
    $("#state-parks").on('click', '.manage-trips', function() {
        var $parentTr = $(this).parents('tr');
        var park_id = $parentTr.attr('id');
        $("#trip-table").data("park_id", park_id);
        $(".accordion-content").hide();
        $("#tbody-trips").html('');

        // load trip form
        $.post('../../ajax/travel-page.php', {'op': 'get-travel-vehicles-routes', 'travel_id': travel_id, 'park_id': park_id}, function(d) {
            var vehicles = "<option value=''>Vehicle types</option>";
            var park_maps = "<option value=''>Routes</option>";
            var dataObj = JSON.parse(d);

            $.each(dataObj.park_maps, function(i, val) {
               park_maps += "<option value='" + val.id + "'>" + val.origin_name + " - " + val.destination_state + "(" + val.destination_name + ")</option>";
            });
            $("#park_map_id").html(park_maps);

            $.each(dataObj.vehicles, function(i, val) {
                vehicles += "<option value='" + val.vehicle_type_id + "'>" + val.vehicle_name + "</option>";
            });
            $("#vehicle_types").html(vehicles);
        })
        getTrips(park_id, travel_id);
    });


    // accordion effect for trip
    $(".accordion-link").click(function() {
        var id = $(this).attr("id");
        $(".accordion-content").slideUp();
        if (id == 'trip-table') {
            var park_id = $(this).data("park_id")
            getTrips(park_id, travel_id);
        } else {
            $("#" + id + "-div").slideDown();
        }
    });


    // add new trip
    $("#form-trip").submit(function(e) {
        e.preventDefault();

        $.post('../../ajax/travel-page.php', $(this).serialize() + '&travel_id=' + travel_id);
        if ($('#op').val() == 'update-trip') {
            $("#trip-form").text("Add New Trip");
            $("#trip-form-div").slideUp();
            $("#op").val('add-trip')
        }
        $("#amenities").multiSelect('deselect_all');
        $("#form-trip")[0].reset();
    });


    // edit trip
    $("#tbody-trips").on('click', '.edit-trip', function(e) {
        e.preventDefault();
        var trip_id = $(this).parents("tr").data('trip_id');
        var amenities = $(this).data('amenities');
        var fare = $(this).data('fare');
        var departure_order = $(this).data('departure_order');
        var departure_time = $(this).data('departure_time');
        var vehicle_name = $(this).data('vehicle');

        $("#park_map_id").prop("disabled", true);
        $("#vehicle_types option").text(vehicle_name).val('f');
        $("#fare").val(fare);
        $("#departure_order").val(departure_order);
        $("#departure_time").val(departure_time);
        var data_amenities = amenities.split(",");
        $("#amenities").val(data_amenities);
        $("#amenities").multiSelect('refresh');

        $("#op").val("update-trip");
        $("#trip_id").val(trip_id);
        $("#trip-form").text("Editing Selected Trip");
        $("#trip-table-div").slideUp();
        $("#trip-form-div").slideDown();
    });



    $('#amenities').multiSelect();
    //$('#edit_amenities').multiSelect();
    $('#departure_time').timepicker();
});

function getStateParks(state_id, callback) {
    $.ajax({
        url: '../../ajax/misc_fns.php',
        type: 'POST',
        dataType: 'json',
        data: {'op': 'get-state-parks', 'state_id': state_id},
        success: function(d) {
            var opts = "";
            $.each(d, function(i, val) {
                opts += "<option value='" + val.id + "'>" + val.park + "</option>";
            });
            callback(opts);
        }
    });
}


function getTrips(park_id, travel_id) {
    $.ajax({
        url: '../../ajax/travel-page.php',
        type: 'POST',
        dataType: 'json',
        data: {'op': 'get-park-trips', 'park_id': park_id, 'travel_id': travel_id},
        success: function(d) {
            var tbody = "";
            $.each(d, function(i, val) {
                tbody += "<tr data-trip_id='" + val.id + "'>"
                    +"<td>" + val.origin_name + " - " + val.destination_name + "</td>"
                    +"<td>" + val.vehicle_name + " " + val.departure + "</td>"
                    +"<td>" + replaceAll(val.amenities, '>', ', ') + "</td>"
                    +"<td>" + val.departure_time + "</td>"
                    +"<td class='text-right'>" + val.fare + "</td>"
                    +"<td class='text-center'>"
                        +"<a href='' class='edit-trip' data-amenities='" + replaceAll(val.amenities, '>', ',') + "' data-fare='" + val.fare + "' data-vehicle='" + val.vehicle_name + "' data-departure_time='" + val.departure_time + "' data-departure_order='" + val.departure + "'>"
                            +"<i class='fa fa-pencil' title='Edit trip'></i>"
                        +"</a>"
                        +"&nbsp; &nbsp;<a href='' title='Diasble trip' class='disable-trip'><i class='fa fa-ban'></i></a>"
                    +"</td></tr>";
            });
            $("#tbody-trips").html(tbody);
            $("#trip-table-div").slideDown();
        }
    });
}


function escapeRegExp(str) {
    return str.replace(/([.*+?^=!:${}()|\|\]\/\\])/g, "\\$1");
}


function replaceAll(str, find, replace) {
    return str.replace(new RegExp(escapeRegExp(find), 'g'), replace)
}
</script>
