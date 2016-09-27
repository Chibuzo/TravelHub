<?php
session_start();
require_once("includes/banner.php");
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
			<h3>About us</h3><br>
			Oya.com.ng is a bus ticketing agent that aims at making travel by bus easier and fun across Nigeria.
			We help travellers pre-book and buy bus tickets before the day of travel.
			You can call us to reserve your choice seat for you, alternatively, you can visit our website and pick any seat of your choice,
			from the transport company of your choice, and also the bus you'd prefer to travel with.<br /><br />
			<p>
				We have several payment options on our website; you choose the one most comfortable for you.
				You can also pre-book and pay on the travel day, so far as you are there at the park in time enough before the bus is filled up.
			</p>
		</div>
	</div>
</div>

<?php
require_once "includes/footer.php";
?>