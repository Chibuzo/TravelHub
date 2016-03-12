<?php
require "includes/head.php";
require "includes/side-bar.php";
require_once "../../includes/db_handle.php";
require_once "../../api/models/travel.class.php";

$travel_model = new Travel();

if (isset($_POST['add_travel'])) {
    $params['company_name'] = $_POST['company_name'];
    $params['online_charge'] = $_POST['online_charge'];
    $params['offline_charge'] = $_POST['offline_charge'];
    $params['account_number'] = $_POST['account_number'];
    try {
        $result = $travel_model->saveTravel($params);
        if ($result == false) {
            $msg = "There was an error, travel was not added.";
        }
    } catch (\Exception $e) {

    }
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
            <div class="col-md-6 col-xs-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h2 style='font-size: 18px' class="box-title"><i class="fa fa-bus"></i> &nbsp;Manage Travels</h2>
                    </div>
                    <div class="box-body">
                        <div>
                            <div id="route-div">
                                <form method="post">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="form-group" id="origin">
                                                <input type="text" class="form-control" placeholder="Company Name" name="company_name" id="company_name" required="required" />
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group" id="destination">
                                                <input type="text" class="form-control" placeholder="Account Number" name="account_number" id="account_number" required="required" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group" id="destination">
                                                <input type="text" class="form-control" placeholder="Online Charge" name="online_charge" id="online_charge" required="required" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group" id="destination">
                                                <input type="text" class="form-control" placeholder="Offline Charge" name="offline_charge" id="offline_charge" required="required" />
                                            </div>
                                        </div>

                                        <input type="hidden" name="add_travel" value="yes" />

                                        <div class="col-md-1">
                                            <button type="submit" name="addTravel" class="btn bg-olive"><i class='fa fa-plus'></i> Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width='30'>S/No</th>
                                    <th>Company Name</th>
                                    <th>Online Charge</th>
                                    <th>Offline Charge</th>
                                    <th>Account Number</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="travel-tbl">
                                <?php
                                $html = ""; $n = 0;
                                foreach ($travel_model->getTravels() as $travel) {
                                    $n++;
                                    $html .= "<tr>
													<td class='text-right'>$n</td>
													<td>{$travel->company_name}</td>
													<td>{$travel->online_charge}</td>
													<td>{$travel->offline_charge}</td>
													<td>{$travel->account_number}</td>
													<td class='opt-icons text-center' id='{$travel->id}'>
														<a href='' class='edit-travel' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>
														<a href='' class='remove-travel hidden' title='Remove' data-toggle='tooltip'><i class='fa fa-trash-o'></i></a>
														<a href='' class='travel-details' title='Details' data-toggle='tooltip'><i class='fa fa-arrow-right'></i></a>
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
                        <h2 style='font-size: 20px' class="box-title"><i class="fa fa-binoculars"></i> &nbsp; Travel Details</h2>
                    </div>
                    <div class="box-body">
                        <div>
                            <div id="detail-div">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Travel Manager</h4>
            </div>
            <form action="" method="post" id="addUser">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input class="form-control" type="text" placeholder="Full Name" name="full_name" id="full_name">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" type="text" placeholder="Username" name="username" id="username">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" placeholder="Password" name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label>Verify Password</label>
                        <input class="form-control" type="password" placeholder="Verify Password" name="v_password" id="v_password">
                    </div>
                    <input type="hidden" name="travel_id" id="travel_id" value="" />
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

        // edit travel
        $("#travel-tbl").on("click", ".edit-travel", function(e) {
            e.preventDefault();
            var parentTr = $(this).parents("tr");
            var id = $(this).parent("td").attr("id");

            var comapny_name = parentTr.find("td:nth-child(2)").text();
            var online_charge = parentTr.find("td:nth-child(3)").text();
            var offline_charge = parentTr.find("td:nth-child(4)").text();
            var account_number = parentTr.find("td:nth-child(5)").text();

            var nameInput = "<input type='text class='form-control' name='company_name' value='" + comapny_name + "' />";
            var onlineInput = "<input type='text class='form-control' name='online_charge' value='" + online_charge + "' style='width: 35px' />";
            var offlineInput = "<input type='text class='form-control' name='offline_charge' value='" + offline_charge + "' style='width: 35px' />";
            var accountNumber = "<input type='text class='form-control' name='account_number' value='" + account_number + "' />";

            parentTr.find("td:nth-child(2)").html(nameInput);
            parentTr.find("td:nth-child(3)").html(onlineInput);
            parentTr.find("td:nth-child(4)").html(offlineInput);
            parentTr.find("td:nth-child(5)").html(accountNumber);

             $(this).removeClass('edit-travel').html("<i class='fa fa-save'></i>").addClass("save-travel");
        });

        // update travel (and table)
        $("#travel-tbl").on("click", ".save-travel", function(e) {
            e.preventDefault();
            var parentTr = $(this).parents("tr");
            var id = $(this).parent("td").attr("id");
            var company_name = parentTr.find("input[name=company_name]").val();
            var online_charge = parentTr.find("input[name=online_charge]").val();
            var offline_charge = parentTr.find("input[name=offline_charge]").val();
            var account_number = parentTr.find("input[name=account_number]").val();

            $.post("../../ajax/misc_fns.php", {"op": "update-travel", "company_name": company_name, "online_charge": online_charge, "offline_charge": offline_charge, "account_number": account_number, "id": id}, function(d) {
                if (d.trim() == "Done") {
                }
            });
            parentTr.find("td:nth-child(2)").text(company_name);
            parentTr.find("td:nth-child(3)").text(online_charge);
            parentTr.find("td:nth-child(4)").text(offline_charge);
            parentTr.find("td:nth-child(5)").text(account_number);
            $(this).removeClass('save-travel').html("<i class='fa fa-pencil'></i>").addClass("edit-travel");
        });

        //display travel details
        $("#travel-tbl").on("click", ".travel-details", function(e) {
            e.preventDefault();
            var id = $(this).parent("td").attr("id");

            $.post("../../ajax/misc_fns.php", {"op": "travel-details", "id": id}, function(d) {
                $("#detail-div").html(d);
            });
        });

        //set travel_id for adding user
        $('#userModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var travel_id = button.data('travel-id');
            var modal = $(this);
            modal.find('.modal-body #travel_id').val(travel_id);
        });

        $('#addUser').on('submit', function(e) {
            e.preventDefault();
            var full_name = $('#full_name').val();
            var username = $('#username').val();
            var password = $('#password').val();
            var v_password = $('#v_password').val();
            var travel_id = $('#travel_id').val();

            if (password !== v_password) {
                alert("Password do not match.");
            } else {
                $.post("../../ajax/misc_fns.php", {"op": "add-travel-admin", "full_name": full_name, "username": username, "password": password, "travel_id": travel_id}, function(d) {
                    if (d.trim() == "Done") {
                        $.post("../../ajax/misc_fns.php", {"op": "travel-details", "id": travel_id}, function(_data) {
                            $("#detail-div").html(_data);
                        });
                    }
                });
                $('#userModal').modal('hide');
            }
        })

    });
</script>