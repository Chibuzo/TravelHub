<?php
session_start();
require_once "includes/banner.php";
require_once "includes/db_handle.php";
require_once "api/models/bookingmodel.class.php";

/*** Get ticket booking details ***/
$fare_id      = $_SESSION['trip_id'];
$travel_date = $_SESSION['travel_date'];
$travel_date = date('D d M Y', strtotime($travel_date));

$booking = new BookingModel();
$vehicle = $booking->getBookingDetails($fare_id);
?>
<style>
.ticket-details {
	position: relative;
	padding: 15px;
	line-height: 25px;
	margin: auto 15px;
	margin-top: 70px;
	margin-bottom: 70px;
	border: #e0e0e0 solid thin;
	background-color: #f8f8f8;
	border-radius: 5px;
}

#details {
	float: left;
	width: 55%;
	margin-left: 40px;
}

.form-group {
	margin-left: 15px;
}

#payment-btn {
	margin-left: 10px;
}

@media screen and (min-width: 320px) and (max-width: 600px) {
	.form-group, #payment-btn { margin-left: 0; }
}

</style>

<div class="container"><br />
	<div class="row">
	<div class="col-md-6">
		<h1>&nbsp;Personal Details</h1><hr />
		<form method="post" id="customer_info" action="" role="form">
			<div class="alert alert-error" style="display: none"></div>
			<div class="form-group">
				<label for="customer_name">Name</label>
				<input type="text" name="customer_name" id="customer_names" class="form-control" placeholder="Customer's name" />
			</div>

			<div class="form-group">
				<label for="customer_phone">Phone number</label>
				<input type="text" name="customer_phone" id="phone-number" class="form-control" placeholder="Customer's phone number" />
			</div>

			<div class="form-group">
				<label for="next_of_kin_num">Next of kin phone</label>
				<input type="text" name="next_of_kin_num" id="next_of_kin_num" class="form-control" placeholder="Next of kin phone number" />
			</div>

			<!--<div class="form-group">
				<label for="email">Email</label>
				<input type="text" name="email" id="email-address" class="form-control" placeholder="Email address" />
			</div>-->

			<div class="form-group">
				<label class="payment-opt">
					<input type="radio" name="payment_opt" value="offline" checked="checked">
					&nbsp;Pay offline
				</label>

				<label class="payment-opt">
					<input type="radio" name="payment_opt" value="online" style="margin-left:15px">
					&nbsp;Pay online
				</label>
			</div>

			<input type="submit" class="btn btn-primary btn-block btn-lg" id="payment-btn" value="Proceed to payment" />
		</form>
	</div>

	<div class="col-md-2"></div>

	<div class="col-md-3 ticket-details">
		<div><b>Ticket Details</b></div><hr style='margin:5px 0px' />
		&nbsp;<span class='glyphicon glyphicon-hand-right'></span>&nbsp;&nbsp; <?php echo $vehicle->company_name; ?><br />
		&nbsp;<span class='glyphicon glyphicon-hand-right'></span>&nbsp;&nbsp; <?php echo " {$vehicle->route}<br />
		&nbsp;<span class='glyphicon glyphicon-hand-right'></span>&nbsp;&nbsp; {$vehicle->park} park<br />
		&nbsp;<span class='glyphicon glyphicon-hand-right'></span>&nbsp;&nbsp; {$travel_date}<br />
		&nbsp;<span class='glyphicon glyphicon-hand-right'></span>&nbsp;&nbsp; $vehicle->vehicle_type<br />";
		echo ($_SESSION['seat_no'] != 0) ? "&nbsp;<span class='glyphicon glyphicon-hand-right'></span>&nbsp;&nbsp; Seat no: {$_SESSION['seat_no']}<br />" : '';
		//echo "&nbsp;<span class='glyphicon glyphicon-hand-right'></span>&nbsp;&nbsp; Departure: $bus->departure_time<br />
		echo "&nbsp;<span class='glyphicon glyphicon-hand-right'></span>&nbsp;&nbsp; Fare: $vehicle->fare NGN<br />
		<hr style='margin:5px 0px' />
		<b>Total amount: $vehicle->fare NGN</b>
	</div>";
	?>

	<form id="payment-gateway" action="https://voguepay.com/pay/" method="post">
		<input type="hidden" id="total" name="total" value="<?php echo $vehicle->fare; ?>" />
		<input type="hidden" id="merchant_ref" name="merchant_ref" />
		<input type="hidden" id="v_merchant_id" name="v_merchant_id" value="1447-16254" />
		<input type='hidden' name='memo' value='Bus ticket booking from oya.com.ng' />
	</form>

	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$('#customer_info').submit(function(e) {
		e.preventDefault();
		//var $this_form = $(this);

		/*** validate customer's form ***/
		var bln_validate = true;
		$.each($('#customer_info').serializeArray(), function(i, val) {
			if (val.value.length == 0) {
				bln_validate = false;
				$("input[name='" + val.name + "']").focus();
				$('.alert').html("Form not completely filled out").fadeIn().fadeOut(9000);
				return false;
			}
		});

		if (bln_validate == false) return false;

		if (!$.isNumeric($('#phone-number').val()) || ($('#phone-number').val().length < 7)) {
			bln_validate = false;
			$('.alert').html('Enter a valid phone number to continue').fadeIn().fadeOut(9000);
			$('#phone-number').focus();
			if (bln_validate == false) return false;
		}

		if (!$.isNumeric($('#next_of_kin_num').val()) || ($('#next_of_kin_num').val().length < 7)) {
			bln_validate = false;
			$('.alert').html('Enter a valid next of kin phone number to continue').fadeIn().fadeOut(9000);
			$('#next_of_kin_num').focus();
			if (bln_validate == false) return false;
		}

		$('#names').val($('#customer_names').val());
		$('#phone_number').val($('#phone-number').val());
		//$('#email_address').val($('#email-address').val());

		var boarding_vehicle_id = "<?php echo $_SESSION['boarding_vehicle_id']; ?>";
		var seat_no = "<?php echo $_SESSION['seat_no']; ?>";

		$.ajax({
			type: "POST",
			url : 'ajax/save_booking_details.php',
			data: 'seat_no=' + seat_no
				+ '&boarding_vehicle_id=' + boarding_vehicle_id
				+ '&payment_opt=' + $('input[name=payment_opt]:checked').val()
				+ '&customer_name=' + $('#customer_names').val()
				+ '&customer_phone=' + $('#phone-number').val()
				+ '&next_of_kin_phone=' + $('#next_of_kin_num').val(),

			success: function(d) {
				if ($.trim(d) == "02") {
					$(".alert").html("Sorry, <b>seat " + seat_no + "</b> is no longer available, please go back and select a different seat.<br />Thank you").fadeIn();
				} else if ($.trim(d) == "03") {
					$(".alert").html("We are sorry, your seat booking wasn't successful, please try again later").fadeIn();
				} else if ($.trim(d) == "04") {
					$(".alert").html("Please fill out all the form completely to continue").fadeIn();
				} else {
					var payment_opt = $('input[name=payment_opt]:checked').val();
					if (payment_opt == 'online') {
						//$('#merchant_ref').val(d);
						//$('#payment-gateway').submit();
						$("#payment-btn").prop("disabled", true);
					} else if (payment_opt == 'offline') {
						location.href = "payment.php";
					} else {
						$(".alert").html("Select a payment option to continue").fadeIn();
					}
				}
			}
		});
		$('#customer_names').val('');
	});
});
</script>
<?php require_once "includes/footer.php"; ?>
