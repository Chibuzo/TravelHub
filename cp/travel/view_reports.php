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
								<form action="../../reports/download_report.php" method="post" class="form-horizontal">
									<div class="row">
										<div class="col-md-3">
											<select class="form-control" name="report_type">
												<!--<option value="">-- Report Type --</option>-->
												<option value="Daily">Daily Report</option>
												<!--<option value="Monthly">Monthly Report</option>-->
											</select>
										</div>

										<div class="col-md-5">
											<div class="input-groupform-group">
												<div class="col-sm-5">
													<input name="travel_date" class="form-control date" id="tdate" type="text" value="<?php echo isset($_POST['travel_date']) ? $_POST['travel_date'] : ''; ?>" placeholder="Pick date..." />
												</div>
												<span class="input-group-btn">
													<button type="submit" class="btn btn-primary" name="submit"><i class="fa fa-download"></i> Download Report Sheet</button>
												</span>
											</div>
										</div>

									</div>
								</form>
							</div>
						<?php

						?>
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
