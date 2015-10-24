<?php
session_start();
require_once("includes/banner.php");
?>
<style>
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
	<h1>&nbsp;About us</h1><hr />
	<div style="padding:15px">
		Oya.com.ng is a bus ticketing agent that aims at making travel by bus easier and fun across Nigeria.
		We help travellers pre-book and buy bus tickets before the day of travel.
		You can call us to reserve your choice seat for you, alternatively, you can visit our website and pick any seat of your choice,
		from the transport company of your choice, and also the bus you'd prefer to travel with.<br /><br />
		<p>
			We have several payment options on our website; you choose the one most comfortable for you.
			You can also pre-book and pay on the travel day, so far as you are there at the park in time enough before the bus is filled up.
		</p>
	</div>
</p>
</div>

<?php
require_once "includes/footer.php";
?>