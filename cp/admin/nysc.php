<?php
require "includes/head.php";
require "includes/side-bar.php";
require_once "../../api/models/Nysc.php";
//require_once "../../classes/utility.class.php";

$nysc = new Nysc();

$date = isset($_POST['travel_date']) ? $_POST['travel_date'] : date('Y-m-d');
//$reports = $report->getReportBooks($date);

$html = ''; $n = 0; $total_revenue = $total_expenses = $total_profit = 0;
foreach ($nysc->getAll('nysc_travelers', 'date_booked') AS $rep) {
    // vars for filter/search
    $n++;
    $html .= "<tr>
				<td class='text-right'>$n</td>
				<td>{$rep->fullname}</td>
				<td>{$rep->phone}</td>
				<td>{$rep->origin}</td>
				<td>{$rep->destination}</td>
				<td class='text-right'>" . number_format($rep->fare) . "</td>
				<td class='text-right'>{$rep->passengers}</td>
				<td>{$rep->payment_status}</td>
				<td>" . date('d-m-Y', strtotime($rep->travel_date)) . "</td>
				<td>" . date('d-m-Y', strtotime($rep->date_booked)) . "</td>
			</tr>";
}
/*$html .= "<tr style='font-size:16px; font-weight: bold; text-align: right'><td colspan='5'>Totals:</td>
		<td>".number_format($total_revenue)."</td><td>".number_format($total_expenses)."</td><td>".number_format($total_profit)."</td></tr>";*/
?>
<link href="../../css/datepicker.css" rel="stylesheet" />
<link href="../../css/datepicker3.css" rel="stylesheet" />

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Reports
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Reports</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h2 style='font-size: 18px' class="box-title"><i class="fa fa-book"></i> &nbsp;NYSC Bookings</h2>
                    </div>

                    <div class="box-body">
                        <div>
                            <div style="margin-bottom: 8px">
                                <form action="" method="post" class="form-horizontal">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <select class="form-control" name="report_type">
                                                <option value="">-- Departure State --</option>
                                                <option value="Enugu">Enugu</option>
                                                <option value="Lagos">Lagos</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-control" name="report_type">
                                                <option value="Daily">Daily Report</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="input-group form-group">
                                                <input name="travel_date" class="form-control date" id="tdate" type="text" value="<?php echo isset($_POST['travel_date']) ? $_POST['travel_date'] : ''; ?>" placeholder="Pick date..." />
												<span class="input-group-btn">
													<input type="submit" class="btn btn-primary" name="submit" value="Display" />
												</span>
                                            </div>
                                        </div>

                                        <!--<div class="col-md-5">
                                            <input type="submit" name="submit" value="Get Report" class="btn btn"
                                        </div>-->
                                    </div>
                                </form>
                            </div>

                            <table class='table table-striped table-bordered'>
                                <thead>
                                    <tr>
                                        <th style="width: 10px">S/no</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Departure</th>
                                        <th>Camp</th>
                                        <th>Fare ( ₦ )</th>
                                        <th>Tickets</th>
                                        <th>Payment Status</th>
                                        <th>Travel Date</th>
                                        <th>Date Booked</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
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

<?php include_once "includes/footer.html"; ?>
<script type="text/javascript" src="../../js/bootstrap-datepicker.js"></script>
<script>
    $(document).ready(function() {
        $('#tdate').datepicker({
            format: 'dd-M-yyyy',
            keyboardNavigation: false,
            forceParse: false,
            todayHighlight: true,
            autoclose: true
        });
    });
</script>
