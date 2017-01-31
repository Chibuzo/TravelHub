<?php
session_start();
$page_title = "Check Out";
require_once "includes/banner.php";
require_once "includes/db_handle.php";

$json = file_get_contents('https://voguepay.com/?v_transaction_id='.$_REQUEST['transaction_id'].'&type=json');
//create new array to store our transaction detail
$transaction = json_decode($json, true);

$sql = "SELECT date_booked, fare FROM booking_details WHERE id = :txnref";
$_param = array('txnref' => $transaction['merchant_ref']);
$db->query($sql, $_param);

if ($db->stmt) {
	$data = $db->fetch('obj');
	$date = $data->date_booked;
} else {
	die ("Invalid transaction ID!");
}

echo "<div class='container'><br />";
echo "<h1>Transaction status</h1><hr />";
extract($transaction);
displayStatus($status, $transaction_id, $method, $total);
echo "</div>";

updatePayment($merchant_ref, $status, $method, $total);

require_once "includes/footer.php";


function displayStatus($status, $txnref, $channel, $amount) {
	
	echo "<div class='alert'><dl class='dl-horizontal'>
		<dt>Transaction status:</dt>
		<dd>$status</dd>
	
		<dt>Transaction Ref no:</dt>
		<dd>{$txnref}</dd>
		
		<dt>Transaction date:</dt>
		<dd>" . date('D, d M Y') . "</dd>
		
		<dt>Payment method:</dt>
		<dd>{$channel}</dd>
		
		<dt>Transaction amount:</dt>
		<dd>{$amount}</dd>
		
		<dt>Transaction currency:</dt>
		<dd>NGN</dd>
	</dl></div>";
}


function updatePayment($ref, $response, $channel, $amount_paid) {
	global $db;
	
	if (isset($_SESSION['nysc'])) $tbl = 'special_booking';
	else $tbl = 'booking_details';
	
	$status = ($response == 'Approved') ? 'Paid' : 'Not paid';
	
	$sql = "UPDATE {$tbl} SET
				payment_status = '$status',
				response       = :response,
				payment_opt    = :channel,
				fare           = :amount
			WHERE id = :id";
			
	$param = array(
		'response' => $response,
		'channel'  => $channel,
		'amount'   => $amount_paid,
		'id'       => $ref
	);
	
	$db->query($sql, $param);
}
?>