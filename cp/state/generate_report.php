<?php
ini_set('max_execution_time', 300);
session_start();
require "../../classes/PHPExcel.php";
require_once "../../classes/utility.class.php";
require_once "../../api/models/report.class.php";

// fetch report data
$report = new Report();

$report_data = array();
$n = 1;
$total_revenue = $total_expenses = $total_profit = 0;
foreach ($report->getDailyReport($_GET['date']) AS $rep) {
	$data = array();
	$data[] = $n++;
	$data[] = $rep['origin_state'] . " - " . $rep['dest_state'];
	$data[] = $rep['vehicle_name'] . ' ( ' . $departure_order = Utility::ordinal($rep['departure_order']) . ' )';
	$data[] = $num_of_tickets = count(explode(",", $rep['booked_seats']));
	$data[] = number_format($rep['fare']);
	$data[] = number_format($num_of_tickets * $rep['fare']);
	$data[] = number_format($rep['expenses']);
	$data[] = number_format(($num_of_tickets * $rep['fare']) - $rep['expenses']);

	$total_expenses += $rep['expenses'];
	$total_revenue += $num_of_tickets * $rep['fare'];
	$total_profit += ($num_of_tickets * $rep['fare']) - $rep['expenses'];
	$report_data[] = $data;
}

if ($n < 2) die("There is nothing to report for " . date('D, d M Y', strtotime($_GET['date'])));

$ex = new PHPExcel();

$ex->getProperties()
   ->setCreator('Travelhub')
   ->setTitle('Title')
   ->setDescription('Booking Reports')
   ->setSubject('Daily Reports');

$sheet = $ex->getSheet(0);
$sheet->setTitle("Booking Report");

$fdate = date('D, d M Y', strtotime($_GET['date']));
$sheet->setCellValue('A1', 'DAILY REPORT FOR ' . $fdate);
$sheet->mergeCells("A1:H1");

$sheet->setCellValue('a3', 'S/No');
$sheet->setCellValue('b3', 'Route');
$sheet->setCellValue('c3', 'Vehicle Type');
$sheet->setCellValue('d3', 'Tickets Sold');
$sheet->setCellValue('e3', 'Fare ( ₦ )');
$sheet->setCellValue('f3', 'Revenue ( ₦ )');
$sheet->setCellValue('g3', 'Expenses ( ₦ )');
$sheet->setCellValue('h3', 'Profit ( ₦ )');

$sheet->fromArray($report_data, '', 'A4');

// insert summary
$row = $ex->getActiveSheet()->getHighestRow()+2;
$sheet->setCellValue("A{$row}", 'Totals');
$sheet->mergeCells("A{$row}:E{$row}");
$sheet->setCellValue("F{$row}", number_format($total_revenue));
$sheet->setCellValue("G{$row}", number_format($total_expenses));
$sheet->setCellValue("H{$row}", number_format($total_profit));

// header formatting
$header = 'a1:h3';
$style = array(
		'font' => array('bold' => true,)
    );
$sheet->getStyle($header)->applyFromArray($style);

// summary formatting
$last_row = 'a'.$row.':h'.$row;
$style = array(
		'font' => array('bold' => true,)
    );
$sheet->getStyle($last_row)->applyFromArray($style);

for ($col = ord('a'); $col <= ord('h'); $col++)
{
    $sheet->getColumnDimension(chr($col))->setAutoSize(true);
}

$ex->getActiveSheet()
    ->getStyle('D1:D256')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$ex->setActiveSheetIndex(0);

if (isset($_REQUEST['op']) && $_REQUEST['op'] == 'upload-report') {
	/*$writer = PHPExcel_IOFactory::createWriter($ex, 'Excel2007');
	$writer->save('report.xlsx');

	$target_url = 'http://autostartravelsandtourism.com/reports/report.php';
	$file_name_with_full_path = realpath('./report.xlsx');
	
	$post = array('report_date' => $_GET['date'], 'file_contents'=>'@'.$file_name_with_full_path);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$target_url);
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	$result = curl_exec ($ch);
	curl_close ($ch);
	echo $result;*/
} else {
	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Daily Report for ' . $_GET['date'] . '.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	$writer = PHPExcel_IOFactory::createWriter($ex, 'Excel2007');
	$writer->save("php://output");
}
?>
