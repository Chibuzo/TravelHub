<?php
require "includes/head.php";
require "includes/side-bar.php";

//if (isset($_REQUEST['travel_date'])) {
//	require_once "../classes/PHPExcel.php";
//
//	$inputFileName = '../reports/report.xlsx';
//	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
//
//	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
//	$objWriter->save('report.html');
//}

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
						<h2 style='font-size: 18px' class="box-title"><i class="fa fa-book"></i> &nbsp;Reports</h2>
						<a href="generate_report.php?date=<?php echo isset($_POST['travel_date']) ? $_POST['travel_date'] : date('Y-m-d'); ?>" class="hidden btn btn-primary pull-right"><i class="fa fa-download"></i> Download Report Sheet</a>
					</div>

					<div class="box-body">
						<div>
							<div style="margin-bottom: 8px">
                                <form action="" id="generate-form" method="post" class="form-horizontal">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <select class="form-control" name="report_type" id="report_type">
                                                <option value="">-- Report Type --</option>
                                                <option value="payments">Payments</option>
                                                <option value="bookings" selected>Bookings</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-control" name="report_mode" id="report_mode">
                                                <option value="month" selected> Monthly </option>
                                                <option value="year"> Yearly </option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-groupform-group">
                                                <input name="start_date" class="form-control date" id="start_date" type="text" value="" placeholder="State date..." required/>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-groupform-group">
                                                <input name="end_date" class="form-control date" id="end_date" type="text" value="" placeholder="End date..." required/>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="input-groupform-group">
												<span class="input-group-btn">
													<button type="submit" id="get-reports" class="btn btn-primary" name="submit"><i class="fa fa-download"></i> Generate Report</button>
												</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
							</div>
                            <div>
                                <table class="table table-hover report-data">
                                    <thead></thead>
                                    <tbody>
                                    <tr>
                                        <td>To generate report submit form.</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
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
    $('.date').datepicker({
        format: 'dd-M-yyyy',
        keyboardNavigation: false,
        forceParse: false,
        todayHighlight: true,
        autoclose: true
    });

    $('#generate-form').on('submit', function(e) {
        e.preventDefault();
        var mode = $('select#report_mode').val();
        var type = $('select#report_type').val();
        var type_text = $('select#report_type option:selected').text();
        var start_date = $('input#start_date').val();
        var end_date = $('input#end_date').val();

        var mode_name = capitalizeFirstLetter(mode);

        if (start_date == "" || end_date == "") {
            alert("please complete form");
        }

        $.post('../../ajax/misc_fns.php', {'op': 'park-bookings-report', 'mode' : mode, 'type' : type, 'start_date' : start_date, 'end_date' : end_date}, function(d) {
            var data = jQuery.parseJSON(d);
            $('.report-data > thead')
                .html($('<tr />')
                    .html($('<th />').text('S/N'))
                    .append($('<th />').text(mode_name))
                    .append($('<th />').text('Number of ' + type_text))
            );
            var q = 1;
            $('.report-data > tbody').html('');
            $.each(data, function(k, v) {
                $('.report-data > tbody')
                    .append($('<tr />')
                        .html($('<th />').text(q))
                        .append($('<th />').text(v.sort))
                        .append($('<th />').text(v.numb))
                );
                q++;
            });
        });
    });

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
});
</script>
