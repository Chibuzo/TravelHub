<?php
require "includes/head.php";
require "includes/side-bar.php";
require_once "../../api/models/bookingmodel.class.php";
require_once "../../api/models/parkmodel.class.php";

$booking = new BookingModel();
$park_model = new ParkModel();

if (!isset($_GET['m'])) {
    $mode = $_state = "all";
    $_class = "hidden";
} else {
    $mode = $_GET['m'];
    $_class = ($mode == "all") ? "hidden" : "";
    $_state = (isset($_GET['s'])) ? $_GET['s'] : "all";
}
$states = $park_model->getStates();
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
                        <form class="form-inline pull-right">
                            <select id="mode" class="form-control">
                                <option value="all">All</option>
                                <option value="state">State</option>
                            </select>
                            <select id="state" class="form-control <?php echo $_class; ?>">
                                <option value="all">-- Select State --</option>
                                <?php
                                foreach ($states as $state) {
                                    printf("<option value='%d'>%s</option>", $state->id, $state->state_name);
                                }
                                ?>
                            </select>
                        </form>

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
                                        if (isset($_state) && $_state != "all") {
                                            $bookings = $booking->getByTravelState($_SESSION['travel_id'], $_state);
                                        } else {
                                            $bookings = $booking->getByTravel($_SESSION['travel_id']);
                                        }
										foreach ($bookings AS $book) {
											$n++;
											echo "<tr>
													<td class='text-right'>$n</td>
													<td>$book->route</td>
													<td>" . date('D d/m/Y', strtotime($book->travel_date)) . "</td>
													<td>$book->c_name</td>
													<td>$book->phone_no</td>
													<td>$book->ticket_no</td>
													<td>$book->vehicle_type</td>
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

			$.post('../ajax/misc_fns.php', {'op': 'cancel-reservation', 'id': id}, function(d) {
				if (d.trim() == 'Done') {
					$this.parents("tr").fadeOut();
				}
			});
		}
	});

    $("#mode")
        .val("<?php echo $mode; ?>")
        .on("change", function(e) {
            if ($(this).val() == "state") {
                $("#state").removeClass("hidden");
            } else {
                window.location = window.location.pathname;
            }
        });

    $("#state")
        .val("<?php echo $_state; ?>")
        .on("change", function(e) {
            if ($(this).val() == "all") {
                window.location = window.location.pathname;
            } else {
                var query = "&m=" + $("#mode").val();
                window.location.search = query + "&s=" + $(this).val();
            }
    });

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
