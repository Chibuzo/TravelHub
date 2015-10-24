<?php
require_once "../includes/db_handle.php";
require_once "../classes/PHPExcel.php";

$db->query("SELECT filename FROM reports WHERE report_date = :report_date", array('report_date' => date('Y-m-d', strtotime($_POST['travel_date']))));
if ($filename = $db->fetch('obj')->filename) {
	$inputFileName = $filename;
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
	$objPHPExcel->getProperties()
	   ->setCreator("Autostar Webmaster")
	   ->setTitle('Autostar Report')
	   ->setDescription('Autostar Transport Reports')
	   ->setSubject('Daily Reports');

	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Daily-report-for-' . $_POST['travel_date'] .'.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
} else {
	echo "No report was uploaded for this date: " . $_POST['travel_date'] . " <a href='../cp/view_reports.php'>Click here</a> to go back.";
}
