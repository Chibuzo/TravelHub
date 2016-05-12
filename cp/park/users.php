<?php
require "includes/head.php";
require "includes/side-bar.php";

require_once "../../api/models/user.class.php";

$user = new User();

$user_types = array('admin' => "Administrator",
    "user" => "User",
    "travel_admin" => "Travel Administrator",
    "account" => "Account",
    "state_admin" => "State Manager",
    "park_admin" => "Park Manager"
);
?>
<div class="content-wrapper">
  	<section class="content-header">
		<h1>
			Users
			<small>Manage Users</small>
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div id='main_bus_search' class="col-md-12">
				<div class="box box-warning">
					<div class="box-header with-border">
						<h2 style='font-size: 18px' class="box-title"><i class="fa fa-group"></i> &nbsp;Manage Users</h2>
						<button class="btn btn-warning pull-right" data-toggle="modal" data-target="#userModal"><i class="fa fa-plus"></i> New User</button>
					</div>
					<div class="box-body">
						<div>
							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th style="width:120px">Date Added</th>
										<th>User fullname</th>
										<th>Username</th>
										<th class="hidden">User Type</th>
										<th style="width:100px">Option</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$users = $user->getTravelUsersByPark($_SESSION['travel_id'], $_SESSION['park_id']);
										foreach ($users AS $_user) {
											echo "<tr id='{$_user->id}'>
													<td>" . date('jS M Y', strtotime($_user->date_created)) . "</td>
													<td>{$_user->fullname}</td>
													<td>{$_user->username}</td>
													<td class='hidden'>{$user_types[$_user->user_type]}</td>
													<td>
														<a data-toggle='modal' href='#edit-userModal' class='btn btn-xs btn-info edit' title='Edit user'><i class='fa fa-edit fa-lg'></i></a>&nbsp;&nbsp
														<a href='#' title='Remove user' class='delete btn btn-xs btn-danger'><i class='fa fa-trash-o fa-lg'></i></a>
													</td>
												</tr>";
										}
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


<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Add New User</h4>
			</div>
			<form action="" id="add-user-form">
				<div class="modal-body">
					<div class="row form-group">
						<section class="col-md-12">
							<label>Fullname</label>
							<input type="text" name="fullname" id="fullname" placeholder="Name" class="form-control">
						</section>
					</div>

					<div class="row form-group">
						<section class="col-md-6">
							<label>Username</label>
							<input type="text" name="username" id="username" placeholder="Username" class="form-control">
						</section>

						<section class="col-md-6">
							<label>Password</label>
							<input type="password" name="password" id="password" placeholder="Password" class="form-control">
						</section>
					</div>
				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="adduser"> Add User </button>
					<button type="button" class="btn btn-default" id="canreq" data-dismiss="modal">	Cancel </button>
				</div>
			</form>
		</div>
	</div>
</div>


<div class="modal fade" id="edit-userModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Edit User</h4>
			</div>
			<form action="" id="edit-user-form">
				<div class="modal-body">
					<div class="row form-group">
						<section class="col-md-6">
							<label>Fullname</label>
							<input type="text" name="fullname" id="_fullname" placeholder="Name" class="form-control">
						</section>

						<section class="col-md-6">
							<label>Username</label>
							<input type="text" name="username" id="_username" placeholder="Username" class="form-control">
						</section>
					</div>
				</div>
				<input type="hidden" name="id" id="user-id" />

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="adduser"> Update User </button>
					<button type="button" class="btn btn-default" id="canreq" data-dismiss="modal">	Cancel </button>
				</div>
			</form>
		</div>
	</div>
</div>


<?php include_once "includes/footer.html"; ?>

<!--<script src="/js/plugin/jquery-form/jquery-form.min.js"></script>-->
<script type="text/javascript">

	// add user
	$("#add-user-form").submit(function(e) {
		e.preventDefault();

		$.post("../../ajax/user_form.php", $(this).serialize() + "&op=add-user", function(d) {
			if (d.trim() == "Done") {
				location.reload(true);
			}
		});
	});


	// update user info
	$("#edit-user-form").submit(function(e) {
		e.preventDefault();

		$.post("../../ajax/user_form.php", $(this).serialize() + "&op=edit-user", function(d) {
			if (d.trim() == "Done") {
				location.reload(true);
			}
		});
	});


	$(".edit").click(function(e) {
		e.preventDefault();
        var $parentTr = $(this).parents("tr");
		$("#_fullname").val($parentTr.find("td:nth-child(2)").text());
		$("#_username").val($parentTr.find("td:nth-child(3)").text());
		$("#user-id").val($parentTr.attr("id"));
	});


	$(".delete").click(function(e) {
		e.preventDefault();
		var $parentTr = $(this).parents("tr");
		var id = $parentTr.attr("id");

		if (confirm("Are you sure you want to remove this user?")) {
			$.post("../../ajax/user_form.php", {"op": "delete-user", "id": id}, function(d) {
				if (d.trim() == "Done") {
					$parentTr.fadeOut();
				}
			});
		}
	});


	$('#myModal').on('hidden.bs.modal', function(){
		$(this).find('form')[0].reset();
		$('#add-user-form footer').html('<button type="submit" class="btn btn-primary" id="adduser"> Add User </button><button type="button" class="btn btn-primary" id="canreq" data-dismiss="modal"> Cancel </button>');
		$("#add-user-form").removeClass('submited');
		//vcal.resetForm();
	});

</script>
