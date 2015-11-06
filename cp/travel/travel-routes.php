<?php
require "includes/head.php";
require "includes/side-bar.php";
require_once "../../includes/db_handle.php";

require_once "../../api/models/travelparkmap.class.php";
require_once "../../api/models/user.class.php";
require_once "../../api/models/travel.class.php";


$travel_model = new Travel();
$travel_park_map = new TravelParkMap();

if (isset($_POST['add_state'])) {
    $user_model = new User();
    $user_model->createStateAdmin($_POST['full_name'], $_POST['username'], $_POST['password'], $_SESSION['travel_id'], $_POST['state']);
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
          States & Routes
		<small>Control panel</small>
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">States & Routes</li>
	  </ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-6 col-xs-12">
				<div class="box box-warning">
					<div class="box-header with-border">
						<h2 style='font-size: 18px' class="box-title"><i class="fa fa-road"></i> &nbsp;States of Operation</h2>
						<div class="box-tools pull-right">
							<button data-toggle="modal" data-target="#stateModal" class="btn bg-olive"><i class="fa fa-plus"></i> New State</button>
						</div>
					</div>
					<div class="box-body">
						<div>
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th width='30'>S/No</th>
										<th>State</th>
										<th>Admin (username)</th>
										<th></th>
									</tr>
								</thead>
								<tbody id="route-tbl">
								<?php
									$html = ""; $n = 0;
									foreach ($travel_model->getTravelStates($_SESSION['travel_id']) AS $row) {
										$n++;
										$html .= "<tr>
													<td class='text-right'>$n</td>
													<td>{$row->state_name}</td>
													<td>{$row->fullname} ({$row->username})</td>
													<td class='opt-icons text-center' id='{$row->id}'>
														<a href='' class='edit-state' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>
														<a href='' class='remove-state' title='Remove' data-toggle='tooltip'><i class='fa fa-trash-o'></i></a>
														<a href='' class='state-detail' title='Detail' data-toggle='tooltip'><i class='fa fa-arrow-right'></i></a>
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
						<h2 style='font-size: 20px' class="box-title"><i class="fa fa-bus"></i> &nbsp; Routes</h2>
					</div>
					<div class="box-body">
                        <div id="detail-div">
                            <?php
                            $travel_park_maps = $travel_park_map->getTravelParkMaps($_SESSION['travel_id']);
                            if (is_array($travel_park_maps) && count($travel_park_maps) > 0):
                                ?>
                                <table class="table tablebordered table-striped">
                                    <thead>
                                    <tr>
                                        <th width='30'>S/No</th>
                                        <th>Origin</th>
                                        <th>Destination</th>
                                        <th class='text-center'>Option</th>
                                    </tr>
                                    </thead>
                                    <tbody id="vehicle">
                                    <?php
                                    $html = ""; $n = 0;
                                    foreach ($travel_park_maps as $row) {
                                        $n++;
                                        $html .= "<tr>
													<td class='text-right'>$n</td>
													<td>{$row->origin_name}</td>
													<td>{$row->destination_name} ($row->destination_state)</td>
													<td class='opt-icons text-center' id='{$row->id}'>
														<a href='' class='edit-vehicle' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>
														<a href='' class='delete' title='Remove' data-toggle='tooltip'><i class='fa fa-trash-o'></i></a>
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
                                        <p>No route has been created for your Travel.</p>
                                    </div>
                                </div>
                                <hr />
                            <?php endif; ?>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!-- Modal -->
<div class="modal fade" id="stateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Travel Manager</h4>
            </div>
            <form action="" method="post" id="addState">
                <div class="modal-body">
                    <div class="form-group">
                        <label>State</label>
                        <select name="state" class="form-control" required>
                            <option value="">-- State --</option>
                            <?php
                            $states = '';
                            foreach ($db->query("SELECT * FROM states ORDER BY state_name") AS $st) {
                                $states .= "<option value='{$st['id']}'>{$st['state_name']}</option>";
                            }
                            echo $states;
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
                    <input type="hidden" name="add_state" value="yes" />
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
    $('#addState').on('submit', function(e) {
        var password = $('#password').val();
        var v_password = $('#v_password').val();

        if (password !== v_password) {
            e.preventDefault();
            alert("Password do not match.");
        }
    });
});
</script>
