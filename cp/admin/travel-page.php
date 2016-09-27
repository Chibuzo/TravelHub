<?php
require "includes/head.php";
require "includes/side-bar.php";

require_once "../../api/models/travel.class.php";

$travel = new Travel();

$travel_id = $_GET['travel_id'];
$travel_details = $travel->getTravel($travel_id);
?>
<link rel="stylesheet" href="../../css/flip-switch.css" type="text/css" />
<style>
    .opt-icons .fa { color: #666; font-size: 17px; margin-left: 6px; }
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
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Details & Settings</li>
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
                            <button data-toggle="modal" data-target="#parkModal" class="btn bg-olive btn-sm"><i class="fa fa-plus"></i> New State</button>
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
                                    <tbody id="park-tbl">
                                    <?php
                                    $html = ""; $n = 0;
                                    foreach ($travel_states AS $row) {
                                        $n++;
                                        $status = $row->status == 1 ? 'Checked' : '';
                                        $online = $row->online == 1 ? 'Checked' : '';
                                        $html .= "<tr id='{$row->state_id}'>
													<td>{$row->state_name}</td>
													<td>" . $travel->getNumOfParksByState($travel_id, $row->state_id) . "</td>
													<td class='textcenter'>
													    <div class='onoffswitch'>
                                                            <input type='checkbox' data-toggle='modal' data-target='#confirmModal' class='onoffswitch-checkbox' id='{$row->state_name}-status' data-level='state' data-field='status' $status>
                                                            <label class='onoffswitch-label' for='{$row->state_name}-status'>
                                                                <span class='onoffswitch-inner'></span>
                                                                <span class='onoffswitch-switch'></span>
                                                            </label>
                                                        </div>
													</td>
													<td>
													    <div class='onoffswitch'>
                                                            <input type='checkbox' data-toggle='modal' data-target='#confirmModal' class='onoffswitch-checkbox' id='{$row->state_name}-online-status' data-level='state' data-field='online' $online>
                                                            <label class='onoffswitch-label' for='{$row->state_name}-online-status'>
                                                                <span class='onoffswitch-inner'></span>
                                                                <span class='onoffswitch-switch'></span>
                                                            </label>
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
                        <select name="park" class="form-control" required>
                            <option value="">-- Parks --</option>
                            <?php
                            echo $parks;
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input class="form-control" type="text" placeholder="Full Name" name="full_name" id="full_name" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" type="text" placeholder="Username" name="username" id="username" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" placeholder="Password" name="password" id="password" required>
                    </div>
                    <div class="form-group">
                        <label>Verify Password</label>
                        <input class="form-control" type="password" placeholder="Verify Password" name="v_password" id="v_password" required>
                    </div>
                    <input type="hidden" name="add_park" value="yes" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                Are you want to alter this setting?
            </div>
            <div id="settings-data"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirm-setting" data-dismiss="modal">Yes</button>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.html"; ?>
<script>
$(document).ready(function() {
    var travel_id = <?php echo $travel_id; ?>;

    $('#addPark').on('submit', function(e) {
        var password = $('#password').val();
        var v_password = $('#v_password').val();

        if (password !== v_password) {
            e.preventDefault();
            alert("Password do not match.");
        }
    });

    $('#destination').on('change', function() {
        var id = $(this).val();
        $.post("../../ajax/misc_fns.php", {"op": "get-state-parks", "state_id": id}, function(d) {
            var parks = JSON.parse(d);
            var _select = $("#destination_park");
            _select.html('<option value="">-- Destination (Park) --</option>');
            $.each(parks, function(i, val) {
                _select.append($('<option />', { value: val.id, text: val.park }));
            });
        });
    });

    $('#new_park_map').on('submit', function(e) {
        if ($('#destination_park').val() == $('#origin').val()) {
            e.preventDefault();
            alert("Destination must be different from origin");
        }
    });

    $('#update_park').on('submit', function(e) {
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

    // view state parks
    $('.view-parks').on('click', function(e) {
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

});
</script>
