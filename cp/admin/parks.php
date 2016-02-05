<?php

$state_id = isset($_GET['ref']) ? (int)$_GET['ref'] : 0;

require "includes/head.php";
require "includes/side-bar.php";

require_once "../../api/models/parkmodel.class.php";

$park_model = new ParkModel();
//Add Park
if (isset($_POST['add_park'])) {
    $park_model->addPark($_POST['park_name'], $state_id);
}

$parks = $park_model->getParksByState($state_id);
$state = $park_model->getState($state_id);
$states = $park_model->getStates();

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
            <li class="active">Parks</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h2 style='font-size: 18px' class="box-title"><i class="fa fa-road"></i> &nbsp; Parks</h2>
                    </div>
                    <div class="box-body" style="overflow: auto;">
                        <div>
                            <?php
                            foreach ($states as $_state) {
                                printf("<a href='?ref=%d' class='btn btn-default btn-block btn-sm'>%s</a>", $_state->id, $_state->state_name);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h2 style='font-size: 18px' class="box-title"><i class="fa fa-road"></i> &nbsp; Parks</h2>
                    </div>
                    <div class="box-body">
                        <div>
                            <?php
                            if ($state_id == 0) {
                                ?>
                                <div>
                                    <div class="callout callout-warning">
                                        <p>To begin, select a state from the left pane.</p>
                                    </div>
                                </div>
                                <hr />
                            <?php
                            } elseif (count($parks) < 1) {
                                ?>
                                <div id="park-div">
                                    <form method="post">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group" id="destination">
                                                    <input class="form-control" name="park_name" id="park_name" placeholder="Park name..." />
                                                </div>
                                            </div>
                                            <input type="hidden" name="add_park" value="yes" />
                                            <input type="hidden" name="state_id" value="<?php echo $state->id; ?>" />

                                            <div class="col-md-2">
                                                <button type="submit" name="addRoute" class="btn bg-olive"><i class='fa fa-plus'></i> Add</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div>
                                    <div class="callout callout-warning">
                                        <p>No park has been created for <?php echo $state->state_name; ?>.</p>
                                    </div>
                                </div>
                                <hr />
                            <?php
                            } else {
                                ?>
                                <div id="park-div">
                                    <form method="post">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group" id="destination">
                                                    <input class="form-control" name="park_name" id="park_name" placeholder="Park name..." />
                                                </div>
                                            </div>
                                            <input type="hidden" name="add_park" value="yes" />
                                            <input type="hidden" name="state_id" value="<?php echo $state->id; ?>" />

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
                                        <th>Park</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody id="parks-tbl">
                                    <?php
                                    $html = ""; $n = 0;
                                    foreach ($parks as $park) {
                                        $n++;
                                        $html .= "<tr>
													<td class='text-right'>$n</td>
													<td>{$park->park}</td>
													<td class='opt-icons text-center' id='{$park->id}'>
														<a href='' class='edit-park' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>
														<a href='' class='remove-route hidden' title='Remove' data-toggle='tooltip'><i class='fa fa-trash-o'></i></a>
													</td>
												</tr>";
                                    }
                                    echo $html;
                                    ?>
                                    </tbody>
                                </table>
                            <?php } ?>
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

                $.post("../../ajax/misc_fns.php", {'op': op, 'id': id}, function(d) {
                    if (d.trim() == 'Done') {
                        $this.parents("tr").fadeOut();
                    }
                });
            }
        });

        // edit park
        $(".box-body").on("click", ".edit-park", function(e) {
            e.preventDefault();
            var parentTr = $(this).parents("tr");

            var name = parentTr.find("td:nth-child(2)").text();
            var nameInput = "<input type='text class='form-control' name='park_name' value='" + name + "' />";
            parentTr.find("td:nth-child(2)").html(nameInput);

            $(this).removeClass('edit-park').html("<i class='fa fa-save'></i>").addClass("save-park");
        });

        // update park
        $(".box-body").on("click", ".save-park", function(e) {
            e.preventDefault();
            var parentTr = $(this).parents("tr");
            var id = $(this).parent("td").attr("id");
            var name = parentTr.find("input[name=park_name]").val();

            $.post("../../ajax/misc_fns.php", {"op": "update-park", "name": name, "id": id}, function(d) {
                console.log(d);
                if (d.trim() == "Done") {
                }
            });
            parentTr.find("td:nth-child(2)").text(name);
            $(this).removeClass('save-park').html("<i class='fa fa-pencil'></i>").addClass("edit-park");
        });

    });
</script>
