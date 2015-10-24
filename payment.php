<?php
session_start();
require_once "includes/banner.php";
require_once "includes/db_handle.php";

// get ticket ref number
$sql = "SELECT ticket_no FROM booking_details WHERE id = :ticket_id";
$db->query($sql, array('ticket_id' => $_SESSION['ticket_id']));
$details = $db->fetch('obj');
?>

<style>
.row {
	width: 80%;
	margin: auto;
}

.payment-opt {
	padding: 10px;
}

#pay-later { display: none; }

@media screen and (min-width: 200px) and (max-width: 600px) {
	.row { width: auto; }

	#btn-checkout a {
		width: 100%;
	}
}
</style>

<div class='container'><br />
	<div class="row">
		<h1>Offline Payment Options</h1>
		<br />

		<div class="alert alert-info">
			Your ticket has been booked with booking number <b><?php echo $details->ticket_no; ?></b>.<br />
			To confirm your seat and receive your mobile ticket, pay through one of the following options.
		</div>

		<p>&nbsp;&nbsp;<input type="radio" class="payment" name="method" id="bank_payment" checked="checked" /> <span style="margin-left: 8px; position:relative; top:4px">Bank deposit</span></p>
		<p>&nbsp;&nbsp;<input type="radio" class="payment" name="method" id="pay_later" value="Pay later" /> <span style="margin-left: 8px; position:relative; top:4px">Pay later</span></p>
			</form>
		<div id="bank-payment-opt" class="payment-opt"><br />
			After checkout, please deposit the total amount into the following account with your ticket number as a reference.
			Your mobile ticket will be sent through SMS, as soon as your transaction reflects in our account.
			<br /><br />
			<p>
			<b>Bank:</b> Fidelity Bank<br />
			<b>Account Name:</b> Autostar travels and tourism Ltd<br />
			<b>Account Number:</b> 4010934844<br />
			<b>Type of Account:</b> Current Account
			</p>

			<p>
			<b>Bank:</b> Diamond Bank<br />
			<b>Account Name:</b> Autostar travels and tourism Ltd<br />
			<b>Account Number:</b> 0022534018<br />
			<b>Type of Account:</b> Current Account
			</p>
		</div>


		<div id="pay-later" class='payment-opt'><br />
			After checkout, an mTicket will be sent to your mobile number, proceed to the park, show your mTicket, pay for your reservation and get your boarding ticket.<br />
			<b>Note:</b> If you are not in the park in time on the travel date, your reservation will be given out to another passenger.
		</div>

		<div id='btn-checkout'><br />
			<a href='#' class='btn btn-primary pull-right btn-lg' id='checkout'>Check out</a>
		</div>
		<br />
	</div>

	<div style='margin-top: 15px' id="error" class="alert alert-error hidden"></div>
</div>

</div>
<script type="text/javascript">
$(document).ready(function() {
	var q; // For messaging on the next page

	$("input[name='method']:radio").click(function() {
		$('.payment-opt').fadeOut('fast');

		if ($(this).attr('id') == "bank_payment") {
			$('#bank-payment-opt').fadeIn('slow');
			q = 1;
		} else if ($(this).attr('id') == "pay_later") {
			$('#pay-later').fadeIn('slow');
			q = 2;
		}
	});

/*** Check out, get traveler's personal details and payment option ***/
	$('a#checkout').click(function(e) {
		e.preventDefault();

		var payment_opt = $('input[name=method]:checked').attr('id');
		var ticket_id = "<?php echo $_SESSION['ticket_id']; ?>";

		$.post('ajax/data_submission.php', {
			'payment_opt': payment_opt,
			'ticket_id': ticket_id,
			'op'   : 'checkout_details'
		},
		function(d) {
			if (payment_opt == "bank_payment") {
				q = 1;
			} else {
				q = 2;
			}
			location.href = "check_out.php?q=" + q;
		});
	});
});
</script>
<?php require_once "includes/footer.php"; ?>
