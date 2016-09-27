<?php
require "includes/head.php";
require "includes/side-bar.php";
require_once "../../api/models/bookingmodel.class.php";
require_once "../../api/models/reportmodel.class.php";

if (!isset($_SESSION['user_id'])) header("Location: index.php");
$travel_id = $_SESSION['travel_id'];

$db = new Db(DB_NAME);
// bus hire count
$stmt = $db->query("SELECT COUNT(*) num FROM bus_charter");
$result = $stmt->fetch();
$bushire = $result['num'];

// reservation count
$stmt = $db->query("SELECT COUNT(*) num FROM booking_details bd JOIN boarding_vehicle bv ON bd.boarding_vehicle_id = bv.id JOIN trips ON trips.id = bv.trip_id WHERE trips.travel_id = '$travel_id' AND status = '1'");
$result = $stmt->fetch();
$books = $result['num'];

// active routes
$stmt = $db->query("SELECT COUNT(*) num FROM routes WHERE status = '1'");
$result = $stmt->fetch();
$routes = $result['num'];

// vehicle types
$stmt = $db->query("SELECT COUNT(*) num FROM travel_vehicle_types WHERE travel_id = '$travel_id'");
$result = $stmt->fetch();
$bustypes = $result['num'];

$booking = new BookingModel();
$bookings = $booking->getByTravelState($_SESSION['travel_id'], $_SESSION['state_id']);

// data for chart
$report_model = new ReportModel();
$reports = $report_model->stateGetBooking($_SESSION['travel_id'], $_SESSION['state_id'], "MONTH", date('Y-01-01'), date('Y-m-d'));
$chart_data = json_encode($reports, true);

?>
      <!-- Right side column. Contains the navbar and content of the page -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $books; ?></h3>
                  <p>All Reservations</p>
                </div>
                <div class="icon">
                  <i class="fa fa-credit-card"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
			<div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $bushire; ?></h3>
                  <p>Bus Hires</p>
                </div>
                <div class="icon">
                  <i class="fa fa-bus"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $routes; ?></h3>
                  <p>Active Routes</p>
                </div>
                <div class="icon">
                  <i class="fa fa-road"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $bustypes; ?></h3>
                  <p>Vehicle Types</p>
                </div>
                <div class="icon">
                  <i class="fa fa-car"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->

		  <div class="row">
			<div class="col-md-7">
				<div class="box box-warning">
					<div class="box-header with-border">
						<h2 style='font-size: 18px' class="box-title"><i class="fa fa-car"></i> &nbsp;Recent Reservations</h2>
						<div class="box-tools pull-right">
							<a href='bookings.php' class="btn btn-danger"><i class="fa fa-eye"></i> View all</a>
						</div>
					</div>
					<div class="box-body">
						<div>
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Route</th>
										<th>Travel date</th>
										<th>Customer</th>
										<th>Payment</th>
										<th>Date booked</th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach ($bookings AS $book) {
											echo "<tr>
													<td>$book->route</td>
													<td>" . date('D d/m/Y', strtotime($book->travel_date)) . "</td>
													<td>$book->c_name</td>
													<td>$book->payment_status</td>
													<td>" . date('D d/m/Y', strtotime($book->date_booked)) . "</td>
												</tr>";
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-5">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Bookings</h3>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="chart" id="line-chart" style="height: 300px;"></div>
                    </div>
                </div>
		    </div>

          <!-- Main row -->
          <div class="row">


            </section><!-- right col -->
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <strong>Autostar Admin Dashboard
      </footer>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.3 -->
    <script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- jQuery UI 1.11.2 -->
    <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Morris.js charts -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="../plugins/morris/morris.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="../plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="../plugins/knob/jquery.knob.js" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="../plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <!-- datepicker -->
    <script src="../plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="../plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- Slimscroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='../plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js" type="text/javascript"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!--<script src="../dist/js/pages/dashboard.js" type="text/javascript"></script>-->

    <!-- AdminLTE for demo purposes -->
    <!--<script src="../dist/js/demo.js" type="text/javascript"></script>-->

    <script type="text/javascript">
        $(document).ready(function() {
            "use strict";

            // LINE CHART
            var line = new Morris.Line({
                element: "line-chart",
                resize: true,
                data: <?php echo $chart_data; ?>,
                xkey: 'sort',
                ykeys: ['numb'],
                labels: ['value'],
                parseTime: false
            });
        });
    </script>
  </body>
</html>
