<?php
session_start();
require_once "includes/banner.php";
?>
<style>
.content {
	padding: 0 70px;
}

footer {
	position: absolute;
	bottom: 0;
}

@media screen and (min-width: 200px) and (max-width: 600px) {
	.content { padding: 5px;  margin-bottom: 80px;}
}
</style>
<div class="content">
<p><br />
	<h1>&nbsp;How it Works</h1><hr />
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
		 On - <span style="font:bold 16px Tahoma">070 0400 0000</span>
	</p>
</p>
</div>

<?php
require_once "includes/footer.php";
?>