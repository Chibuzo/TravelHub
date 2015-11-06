<?php
require "includes/head.php";
require "includes/side-bar.php";

require_once "../../api/models/bookingmodel.class.php";

$booking = new BookingModel();
?>
<link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<style>
.icons .fa { color: red; }
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>
		Seat Reservations
		<small>Control panel</small>
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Seat Reservations</li>
	  </ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-warning">
					<div class="box-header with-border">
						<h2 style='font-size: 18px' class="box-title"><i class="fa fa-car"></i> &nbsp;Seat Reservations</h2>
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
										<th>Route</th>
										<th>Travel date</th>
										<th>Customer</th>
										<th>Phone</th>
										<th>Ticket Ref</th>
										<th>Vehicle</th>
										<th class='text-right'>Fare ( ₦ )</th>
										<th>Payment</th>
										<th>Date booked</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php
										$n = 0;
										foreach ($booking->getBookings() AS $book) {
											$n++;
											echo "<tr>
													<td class='text-right'>$n</td>
													<td>$book->route</td>
													<td>" . date('D d/m/Y', strtotime($book->travel_date)) . "</td>
													<td>$book->c_name</td>
													<td>$book->phone_no</td>
													<td>$book->ticket_no</td>
													<td>$book->bus_type</td>
													<td class='text-right'>" . number_format($book->fare) . "</td>
													<td>$book->payment_status</td>
													<td>" . date('D d/m/Y', strtotime($book->date_booked)) . "</td>
													<td class='text-center icons' id='$book->id'>
														<a href='' class='cancel' data-toggle='tooltip' title='Cancel ticket'><i class='fa fa-times fa-lg'></i></a>
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

			$.post('../../ajax/misc_fns.php', {'op': 'cancel-reservation', 'id': id}, function(d) {
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
