<?php
session_start();
$page_title = "How it Works";
require_once "includes/banner.php";
?>
<style>
.col-md-12 {
	padding: 20px 40px;
	font: 300 17px 'Open Sans', San-seriff, Helvetica Neue, Tahoma;
}

strong {
	font-weight: 400;
}

@media screen and (min-width: 200px) and (max-width: 600px) {
	.col-md-12 {
		padding: 10px 20px;
		font-size:15px;
		line-height: 22px;
	}
}
</style>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h3>How it Works</h3><br>
			Travelhub attempts to bring online all the available road travel options in Nigeria, and also enable travelers to reserve and pay for
			seats online without leaving the comfort of their home or office.

			<p><br>
				<b>NB:</b> Travelhub is connected to the various transport companies enabled to offer online ticket sales on this hub.
				That means you are buying from your company of choice directly. We just offer the medium.
			</p>
			<h4>To use our travel service:</h4>
			<ul>
				<li><strong>First step:</strong><br>
					Pick your route and date of travel then click on find bus. Travelhub will display travel options from various transport companies
					 plying that route.
				</li>
				<li><strong>Step two:</strong><br>
					Click on the transport company and vehicle of choice and view avaliable seats, then take your prefered seat.
				</li>
				<li><strong>Step three:</strong><br>
					Continue to the next page, enter your details and proceed to make payment.
				</li>
				<li><strong>Step four:</strong><br>
					Currrently we support Master and Visa cards, enter your card details to make payment. On successful payment, your mticket will be sent
					to the mobile number your entered in <strong>step three</strong>.
				</li>
			</ul>
			<p>
				That is it! On your day of travel proceed to the ticketing office and get your boarding pass, or simply board the vehicle (depending
				on how your transport company of choice operates).
			</p>
			<p>
				If that is stressful for you, call us to fix your travel at no extra cost or hidden charges:<br />
				Call - <span style="font:bold 16px Tahoma">0906 3369 208</span>
			</p>
		</div>
	</div>
</div>

<?php
require_once "includes/footer.php";
?>