<?php
require "includes/head.php";
require "includes/side-bar.php";
require_once "../../includes/db_handle.php";
require_once "../../api/models/Nysc.php";

$nysc = new Nysc();
?>
<style>
    .opt-icons .fa { color: #666; font-size: 17px; margin-left: 6px; }

    #admin-form-div { display: none; }

    .state-row .row:nth-child(even) {
        background-color: #fff;
    }

    .state-row .row:nth-child(odd) {
        background-color: #f0f0f0;
    }
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
            <li class="active">Nysc Program</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h2 style='font-size: 18px' class="box-title"><i class="fa fa-bus"></i> &nbsp;Manage Programs</h2>
                    </div>
                    <div class="box-body">
                        <div>
                            <div id="route-div">
                                <form method="post" id="form-add-program">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group" id="origin">
                                                <select class="form-control" name="batch" id="batch" required>
                                                    <option value="">Select batch</option>
                                                    <option value="A">Batch A</option>
                                                    <option value="B">Batch B</option>
                                                    <option value="C">Batch C</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group" id="">
                                                <select class="form-control" name="stream" required>
                                                    <option value="">-- Select Stream --</option>
                                                    <option value="1">Stream 1</option>
                                                    <option value="2">Stream 2</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group" id="">
                                                <select class="form-control" name="camp_date" required>
                                                    <option value="">-- Select Month --</option>
                                                    <?php
                                                        for ($i = 1; $i < 13; $i++) {
                                                            $date = date('Y') . "-" . $i . "-01";
                                                            echo "<option value='$date'>" . date('F', strtotime($date)) . "</option>";
                                                        }
                                                    ?>
                                                    <!--<option value="1">January</option>
                                                    <option value="2">Febuary</option>
                                                    <option value="3">March</option>
                                                    <option value="4">April</option>
                                                    <option value="5">May</option>
                                                    <option value="6">June</option>-->
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <button type="submit" name="addProg" class="btn bg-olive btn-block"><i class='fa fa-plus'></i> Add Program</button>
                                        </div>

                                    </div>

                                </form>
                            </div>

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th width='40'>S/No</th>
                                    <th>Program</th>
                                    <th>States</th>
                                    <th>Corps</th>
                                    <th>Commission (%)</th>
                                    <th>Revenue</th>
                                    <th>Expenses</th>
                                    <th>Profit</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="tbl-progs">
                                <?php
                                $html = ""; $n = 0;
                                foreach ($nysc->getAll('nysc_programs', 'date_created') AS $prog) {
                                    $n++;
                                    $html .= "<tr data-prog_id='$prog->id'>
                                        <td>$n</td>
                                        <td>Batch {$prog->batch}, stream {$prog->stream}, " . date('M Y', strtotime($prog->camp_date)) . "</td>
                                        <td class='text-right'>1</td>
                                        <td class='text-right'>0</td>
                                        <td class='text-right'>10</td>
                                        <td class='text-right'>0</td>
                                        <td class='text-right'>0</td>
                                        <td class='text-right'>0</td>
                                        <td class='opt-icons text-center'>
                                            <a href='' class='edit-travel' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>
                                            <a href='#' class='manage-camp-fare' data-toggle='modal' data-target='#manageRouteModal' title='Add Route Fares'><i class='fa fa-road'></i></a>
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
        </div>
    </section>
</div>


<!-- manage route modal -->
<div class="modal fade" id="manageRouteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Manage Routes & Fares</h4>
            </div>

            <form method="post" id="form-route-fares">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select name="origin" id="origin-state" class="form-control" required>
                                    <option value="" selected>Destination State</option>
                                    <option value="Lagos">Lagos</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="state-row">
                    <?php
                        $db->query("SELECT * FROM states ORDER BY state_name");
                        $_states = $db->fetchAll('obj');
                        foreach ($_states AS $st) {
                            echo "<div class='row'><div class='col-md-7' style='padding-top: 8px'>{$st->state_name}</div>
                                <div class='col-md-5'><input type='number' name='states[]' data-state_id='{$st->id}' class='form-control' /></div></div>";
                        }
                    ?>
                    </div>
                    <input type="hidden" name="prog_id" id="prog_id" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default modal-close" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" name="addParkMap" class="btn bg-olive"><i class='fa fa-plus'></i> Save Fares</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once "includes/footer.html"; ?>
<script>
    $(document).ready(function() {
        // add new travel
        $("#form-add-program").submit(function(e) {
            e.preventDefault();

            $.post("../../ajax/nysc-fns.php", $(this).serialize() + "&op=add-prog", function(d) {
                if (d.trim() == "Done") {
                    location.reload();
                }
            });
        });


        $(".manage-camp-fare").click(function() {
            var prog_id = $(this).parents('tr').data('prog_id');
            $("#prog_id").val(prog_id);
        });


        $("#form-route-fares").submit(function(e) {
            e.preventDefault();
            var fares = [];
            $("#form-route-fares input[type='number']").each(function(i, v) {
                fares.push(this.value + "-" + $(this).data('state_id'));
            });
            $.post('../../ajax/nysc-fns.php', {'op': 'add-fares', 'fares': fares, 'program_id': $("#prog_id").val()}, function(d) {
                if (d.trim() == "Done") {
                    location.reload();
                }
            });
        });
    });
</script>