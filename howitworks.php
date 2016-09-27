<?php
session_start();
require_once "includes/banner.php";
?>
<style>
.col-md-12 {
	padding: 20px 40px;
	font: 300 17px 'Open Sans', San-seriff, Helvetica Neue, Tahoma;
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
			Visit our website and tell us where you are, and where you are travelling to<br />
			We'll use the data you entered and find buses going your route<br />
			You'll be required to pick any bus of your choice<br />
			After that, you give us your details (eg phone number)<br />
			Then you proceed and choose a payment option<br />
			When you are done booking, we'll send your mTicket to the phone number you entered on our website<br />
			On the day of travel, just present the mTicket to us at the park and we'll issue you the ticket you can board the bus with<br />
			Next, we do it again and you tell your friends about us.<br /><br />
			<p>
				You can also call us and make your reservations:<br />
				On - <span style="font:bold 16px Tahoma">070 xxxx xxxx</span>
			</p>
		</div>
	</div>
</div>

<?php
require_once "includes/footer.php";
?>