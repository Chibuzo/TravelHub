<?php
require "includes/head.php";
require "includes/side-bar.php";
require_once "../../api/models/buscharter.class.php";

$bus = new BusCharter();
?>
<link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<style>
.icons .fa { color: #999; }
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>
		Bus Hire
		<small>Control panel</small>
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Bus Hire</li>
	  </ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-warning">
					<div class="box-header with-border">
						<h2 style='font-size: 18px' class="box-title"><i class="fa fa-bus"></i> &nbsp;Bus Hire</h2>
						<div class="box-tools pull-right">
							<button data-toggle="modal" data-target="#hotelModal" class="btn bg-olive hidden"><i class="fa fa-plus"></i> New Route</button>
						</div>
					</div>
					<div class="box-body">
						<div>
							<table class="table table-bordered table-striped" id="dataTable">
								<thead>
									<tr>
										<th width='40'>S/No</th>
										<th>Pickup Location</th>
										<th>Destination</th>
										<th>Customer</th>
										<th>Phone</th>
										<th>Travel date</th>
										<th>Vehicle</th>
										<th class='text-right'>No of Vehicles</th>
										<th>Date booked</th>
										<th>Status</th>
										<th colspan="2"></th>
									</tr>
								</thead>
								<tbody>
									<?php
										$n = 0;
										foreach ($bus->getBusCharter() AS $_bus) {
											$n++;
											echo "<tr id='$_bus->id'>
													<td class='text-right'>$n</td>
													<td>$_bus->departure_location</td>
													<td>$_bus->destination</td>
													<td>$_bus->name</td>
													<td>$_bus->phone</td>
													<td>" . date('D d/m/Y', strtotime($_bus->travel_date)) . "</td>
													<td>$_bus->bus_type</td>
													<td class='text-right'>$_bus->num_of_vehicles</td>
													<td>" . date('D d/m/Y', strtotime($_bus->date_chartered)) . "</td>
													<td>$_bus->status</td>
													<td class='text-center'>
														<a href='' class='cancel' data-toggle='tooltip' title='Confirm request'><i class='fa fa-check fa-lg'></i></a>
													</td>
													<td class='text-center'>
														<a href='' class='cancel' data-toggle='tooltip' title='Cancel bus hire'><i class='fa fa-times fa-lg'></i></a>
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

<?php include_once "includes/footer.html"; ?>
<script src="../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(".cancel").click(function(e) {
		e.preventDefault();
		var $this = $(this);

		if (confirm("Are you sure you want to cancel this reservation?")) {
			var id = $(this).parent('td').attr('id');

			$.post('../ajax/misc_fns.php', {'op': 'cancel-reservation', 'id': id}, function(d) {
				if (d.trim() == 'Done') {
					$this.parents("tr").fadeOut();
				}
			});
		}
	});
});


	$(function () {
	  $('#dataTable').dataTable({
		"bPaginate": true,
		"bLengthChange": false,
		"bFilter": true,
		"bSort": true,
		"bInfo": false,
		"bAutoWidth": false
	  });
	});
</script>
