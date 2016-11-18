<?php
require "includes/head.php";
require "includes/side-bar.php";
require_once "../../includes/db_handle.php";
require_once "../../api/models/travel.class.php";
require_once "../../api/models/vehiclemodel.class.php";

$travel_model = new Travel();
$vehicle_model = new VehicleModel();

$all_vehicle_types = $vehicle_model->getAllVehicleTypes();
?>
<style>
    .opt-icons .fa { color: #666; font-size: 17px; margin-left: 6px; }

    #admin-form-div { display: none; }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Travels
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Travels</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h2 style='font-size: 18px' class="box-title"><i class="fa fa-bus"></i> &nbsp;Manage Travels</h2>
                    </div>
                    <div class="box-body">
                        <div>
                            <div id="route-div">
                                <form method="post" id="form-add-travel">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group" id="origin">
                                                <input type="text" class="form-control" placeholder="Company Name" name="company_name" id="company_name" required="required" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group" id="abbr">
                                                <input type="text" class="form-control" placeholder="Abbreviation" name="abbr" id="abbr" required="required" />
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="form-group" id="">
                                                <input type="text" class="form-control" placeholder="Online (%)" name="online_charge" id="online_charge" required="required" />
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="form-group" id="">
                                                <input type="text" class="form-control" placeholder="Offline (%)" name="offline_charge" id="offline_charge" required="required" />
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="form-group" id="">
                                                <input type="text" class="form-control" placeholder="API (%)" name="api_charge" id="api_charge" required="required" />
                                            </div>
                                        </div>

                                        <input type="hidden" name="add_travel" value="yes" />

                                        <div class="col-md-1">
                                            <button type="submit" name="addTravel" class="btn bg-olive btn-block"><i class='fa fa-plus'></i> Add</button>
                                        </div>

                                    </div>

                                </form>
                            </div>

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th width='40'>ID</th>
                                    <th>Company Name</th>
                                    <th>Abbr</th>
                                    <th style="width: 120px">Online Charge</th>
                                    <th style="width: 120px">Offline Charge</th>
                                    <th style="width: 100px">API Charge</th>
                                    <th style="width: 60px">States</th>
                                    <th style="width: 50px">Parks</th>
                                    <th class="text-center">Option</th>
                                </tr>
                                </thead>
                                <tbody id="travel-tbl">
                                <?php
                                $html = ""; $n = 0;
                                foreach ($travel_model->getTravels() as $travel) {
                                    $n++;
                                    $html .= "<tr data-travel_id='$travel->id'>
                                        <td class='text-right'>{$travel->id}</td>
                                        <td><a href='travel-page.php?travel_id={$travel->id}'>{$travel->company_name}</a></td>
                                        <td>{$travel->abbr}</td>
                                        <td class='text-right'>{$travel->online_charge}</td>
                                        <td class='text-right'>{$travel->offline_charge}</td>
                                        <td class='text-right'>{$travel->api_charge}</td>
                                        <td class='text-right'>
                                            <a href='#miscModal' data-toggle='modal' class='get-travel-states'>{$travel->states}</a>
                                        </td>
                                        <td class='text-right'>
                                            <a href='#miscModal' data-toggle='modal' class='get-travel-parks'>{$travel->parks}</a>
                                        </td>
                                        <td class='opt-icons text-center' data-company-name='{$travel->company_name}'>
                                            <a href='' class='edit-travel' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>
                                            <a href='' class='remove-travel hidden' title='Remove' data-toggle='tooltip'><i class='fa fa-trash-o'></i></a>
                                            <a href='' class='hidden travel-' data-toggle='modal' data-target='#addRouteModal' title='Add Route' data-toggle='tooltip'><i class='fa fa-road'></i></a>
                                            <a href='#vehicleModal' class='travel-vehicles' data-toggle='modal'><i class='fa fa-car' title='Add Vehicle Types' data-toggle='tooltip'></i></a>
                                            <a href='#adminModal' data-toggle='modal' class='hidden travel-admins'><i class='fa fa-user' title='Add Admin' data-toggle='tooltip'></i></a>
                                            <a href='' class='travel-details' title='Setting' data-toggle='tooltip'><i class='fa fa-cog'></i></a>
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

           <!--<div class="col-md-6 col-xs-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h2 style='font-size: 18px' class="box-title"><i class="fa fa-binoculars"></i> &nbsp; <span id="travel-name">Travel Details</span></h2>
                    </div>
                    <div class="box-body">
                        <div>
                            <div id="detail-div">

                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="vehicleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Vehicle Type</h4>
            </div>

            <div class="modal-body">
                <table class="table tablebordered table-striped">
                    <thead>
                    <form action="" method="post" id="form-add-vehicle-type">
                        <tr>
                            <td colspan="2">
                                <select name="vehicle_type_id" id="vehicle_type_id" class="form-control" required>
                                    <option value="">-- Vehicle Type --</option>
                                    <?php
                                    foreach ($all_vehicle_types AS $vehicle_type) {
                                        $diff = $vehicle_type->num_of_seats . ' seats';
                                        if (strstr($vehicle_type->name, 'Hiace')) {
                                            $diff = ($vehicle_type->num_of_seats == 14) ? 'One front seat' : 'Two front seats';
                                        }
                                        $vehicles .= "<option value='{$vehicle_type->id}' data-num_of_seats='{$vehicle_type->num_of_seats}'>{$vehicle_type->name} ($diff)</option>";
                                    }
                                    echo $vehicles;
                                    ?>
                                </select>
                            </td>
                            <td colspan="2">
                                <input class="form-control" type="text" placeholder="Vehicle Name" name="vehicle_name" id="vehicle_name" required>
                            </td>
                            <input type="hidden" name="num_of_seats" id="num_of_seats" />
                            <input type="hidden" name="op" value="add_travel_vehicle_type" />
                            <input type="hidden" name="travel_id" id="travel_id" />
                            <td><input type="submit" class="btn btn-default" value="Add" /></td>
                        </tr>
                    </form>
                    <tr>
                        <th width='30'>S/No</th>
                        <th>Vehicle</th>
                        <th>No of Seats</th>
                        <th>Vehicle Type</th>
                        <th class='text-center'>Option</th>
                    </tr>
                    </thead>
                    <tbody id="tbody-vehicle-types">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="adminModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Travel Manager</h4>
            </div>

            <div class="modal-body">
                <div id="admin-form-div">
                    <form action="" method="post" id="addAdmin">
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
                        <input type="hidden" name="op" id="op" value="add-travel-admin" />
                        <input type="hidden" name="travel_id" id="travel_id" value="" />
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>

                <div id="admin-table">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th width='30'>S/No</th>
                            <th>Fullname</th>
                            <th>Username</th>
                            <th>Level</th>
                            <th class='text-center'>Option</th>
                        </tr>
                        </thead>
                        <tbody id="tbody-admin">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="miscModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Travel </h4>
            </div>
<!--            <form action="" method="post" id="addUser">-->
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
<!--            </form>-->

        </div>
    </div>
</div>
<?php include_once "includes/footer.html"; ?>
<script>
$(document).ready(function() {
    // add new travel
    $("#form-add-travel").submit(function(e) {
        e.preventDefault();

        $.post("../../ajax/misc_fns.php", $(this).serialize() + "&op=add-travel", function(d) {
            if (d.trim() == "Done") {
                location.reload();
            }
        });
    });


    // edit travel
    $("#travel-tbl").on("click", ".edit-travel", function(e) {
        e.preventDefault();
        var parentTr = $(this).parents("tr");
        var id = $(this).parent("td").data("travel_id");

        var comapny_name = parentTr.find("td:nth-child(2)").text();
        var abbr = parentTr.find("td:nth-child(3)").text();
        var online_charge = parentTr.find("td:nth-child(4)").text();
        var offline_charge = parentTr.find("td:nth-child(5)").text();
        var api_charge = parentTr.find("td:nth-child(6)").text();

        var nameInput = "<input type='text class='form-control' name='company_name' value='" + comapny_name + "' />";
        var abbrInput = "<input type='text class='form-control' name='abbr' value='" + abbr + "' />";
        var onlineInput = "<input type='text class='form-control' name='online_charge' value='" + online_charge + "' style='width: 35px' />";
        var offlineInput = "<input type='text class='form-control' name='offline_charge' value='" + offline_charge + "' style='width: 35px' />";
        var apiInput = "<input type='text class='form-control' name='api_charge' value='" + api_charge + "' style='width: 35px' />";

        parentTr.find("td:nth-child(2)").html(nameInput);
        parentTr.find("td:nth-child(3)").html(abbrInput);
        parentTr.find("td:nth-child(4)").html(onlineInput);
        parentTr.find("td:nth-child(5)").html(offlineInput);
        parentTr.find("td:nth-child(6)").html(apiInput);

        $(this).removeClass('edit-travel').html("<i class='fa fa-save'></i>").addClass("save-travel");
    });

    $("body").on('click', ".edit-travel-admin", function(e) {
        e.preventDefault();
        var parentTr = $(this).parents("tr");
        var id = parentTr.data("id");

        var full_name = parentTr.find("td:nth-child(2)").text();
        var username = parentTr.find("td:nth-child(3)").text();

        var nameInput = "<input type='text class='form-control' name='full_name' value='" + full_name + "' />";
        var usernameInput = "<input type='text class='form-control' name='username' value='" + username + "' />";

        parentTr.find("td:nth-child(2)").html(nameInput);
        parentTr.find("td:nth-child(3)").html(usernameInput);

        $(this).removeClass('edit-travel-admin').html("<i class='fa fa-save'></i>").addClass("save-travel-admin");
    });

    /*$("body").on('click', ".save-travel-admin", function(e) {
        e.preventDefault();
        var _link = $(this);
        var parentTr = $(this).parents("tr");
        var data = {};
        data.id = parentTr.data("id");

        data.full_name = parentTr.find("input[name=full_name]").val();
        data.username = parentTr.find("input[name=username]").val();
        data.op = "edit-travel-admin";

        $.post("../../ajax/user_form.php", data, function(d) {
            console.log(d);
            if (d.trim() == "Done") {
                parentTr.find("td:nth-child(2)").html(data.full_name);
                parentTr.find("td:nth-child(3)").html(data.username);
                _link.removeClass('save-travel-admin').html("<i class='fa fa-pencil'></i>").addClass("edit-travel-admin");
            }
        });
    });*/

    //show delete user modal
    $('body').on('click', '.delete-travel-admin', function(e) {
        e.preventDefault();
        var parentTr = $(this).parents("tr");
        var full_name = parentTr.find("td:nth-child(2)").text();
        var id = parentTr.data("id");
        $('#deleteUser').find("span[id=name]").text(full_name);
        $('#deleteUser').find("input[name=id]").val(id);
    });

    //delete user operation
    $("#deleteUser").on('submit', function(e) {
        e.preventDefault();
        var data = {};
        data.id = $('#deleteUser').find("input[name=id]").val();
        data.op = "delete-user";
        data.user_type = "travel_admin";
        $.post("../../ajax/user_form.php", data, function(d) {
            console.log(d);
            if (d.trim() == "Done") {
                $('#deleteUser').find("input[name=id]").val("");
                $("#travel_admin_rows").find("tr[data-id="+data.id+"]").fadeOut();
                $("#deleteTravelAdmin").modal("hide");
            }
        });
    });

    // update travel (and table)
    $("#travel-tbl").on("click", ".save-travel", function(e) {
        e.preventDefault();
        var _link = $(this);
        var parentTr = $(this).parents("tr");
        var id = parentTr.data("travel_id");
        var company_name = parentTr.find("input[name=company_name]").val();
        var abbr = parentTr.find("input[name=abbr]").val();
        var online_charge = parentTr.find("input[name=online_charge]").val();
        var offline_charge = parentTr.find("input[name=offline_charge]").val();
        var api_charge = parentTr.find("input[name=api_charge]").val();

        $.post("../../ajax/misc_fns.php", {
            "op": "update-travel",
            "company_name": company_name,
            "abbr": abbr,
            "online_charge": online_charge,
            "offline_charge": offline_charge,
            "api_charge": api_charge,
            "id": id
        }, function (d) {
            if (d.trim() == "Done") {
                parentTr.find("td:nth-child(2)").html("<a href='travel-page.php?travel_id=" + id + "'>" + company_name + "</a>");
                parentTr.find("td:nth-child(3)").text(abbr);
                parentTr.find("td:nth-child(4)").text(online_charge);
                parentTr.find("td:nth-child(5)").text(offline_charge);
                parentTr.find("td:nth-child(6)").text(api_charge);
                _link.parent("td").data("company-name", company_name);
                _link.removeClass('save-travel').html("<i class='fa fa-pencil'></i>").addClass("edit-travel");
            }
        });
    });


    //set travel_id for adding user
    $('#userModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var travel_id = button.data('travel-id');
        var modal = $(this);
        modal.find('.modal-body #travel_id').val(travel_id);
    });

    /*$('#addAdmin').on('submit', function(e) {
        e.preventDefault();
        var password = $('#password').val();
        var v_password = $('#v_password').val();
        if (password !== v_password) {
            alert("Password do not match.");
        } else {
            $.post("../../ajax/travel-page.php", $(this).serialize() function(d) {
                if (d.trim() == "Done") {
                    $.post("../../ajax/misc_fns.php", {"op": "travel-details", "id": travel_id}, function(_data) {
                        //$("#detail-div").html(_data);
                    });
                }
            });
            $('#adminModal').modal('hide');
        }
    });


    $(".travel-admins").click(function(e) {
        e.preventDefault();
        var travel_id = $(this).parents('tr').data('travel_id');
        $.post('../../ajax/user_form.php', {'op': 'get-travel-admins', 'travel_id': travel_id}, function(d) {
            var tbody = '';
            $.each(d, function(i, admin) {
                tbody += "<tr data-user_id='" + admin.id + "'>"
                            +"<td>" + i + 1 + "</td>"
                            +"<td>" + admin.fullname + "</td>"
                            +"<td>" + admin.username + "</td>"
                            +"<td>" + admin.user_type + "</td>";
                // abandoned
            });
        }, JSON);
    });*/

    $("select[name='vehicle_type_id']").change(function () {
        $("#num_of_seats").val($("select[name='vehicle_type_id'] option:selected").data('num_of_seats'));
    });


    $("#form-add-vehicle-type").submit(function(e) {
        e.preventDefault();

        $.post('../../ajax/travel-page.php', $(this).serialize(), function(d) {
            var tr = "<tr data-vehicle_id='" + d + "'>"
                +"<td></td>"
                +"<td>" + $('#vehicle_type_id option:selected').text() + "</td>"
                +"<td class='text-center'>" + $('#num_of_seats').val() + "</td>"
                +"<td>" + $('#vehicle_name').val()
                +"<td class='opt-icons text-center'><a href='' class='edit-vehicle-type'><i class='fa fa-pencil'></i></a>"
                +"<a href='' class='disable-vehicle-type'><i class='fa fa-ban'></i></a>"
                +"</td></tr>";
            $('#tbody-vehicle-types').append(tr);
            $(this)[0].reset();
        });
    });


    $(".travel-vehicles").click(function(e) {
        e.preventDefault();
        var travel_id = $(this).parents('tr').data('travel_id');
        var travel_abbr = $(this).parents('tr').find('td:nth-child(3)').text();
        $("#vehicleModal .modal-title").text(travel_abbr + ' Vehicle Types');
        $("#vehicleModal #travel_id").val(travel_id);


        $.ajax({
            url: '../../ajax/travel-page.php',
            type: 'POST',
            dataType: 'json',
            data: {'op': 'get-travel-vehicle-types', 'travel_id': travel_id},
            success: function (d) {
                var tbody = '';
                $.each(d, function (i, val) {
                    tbody += "<tr data-vehicle_id='" + val.id + "'>"
                        + "<td class='text-right'>" + (i + 1) + "</td>"
                        + "<td>" + val.vehicle_name + "</td>"
                        + "<td class='text-center'>" + val.num_of_seats + "</td>"
                        + "<td>" + val.type_name + "</td>"
                        + "<td class='opt-icons text-center'><a href='' class='edit-vehicle-type'><i class='fa fa-pencil'></i></a>"
                        + "<a href='' class='disable-vehicle-type'><i class='fa fa-ban'></i></a>"
                        + "</td></tr>";
                });
                $('#tbody-vehicle-types').html(tbody);
            }
        });
    });

});
</script>