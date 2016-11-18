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
			Travelhub is a registered travel agency concerned with road transportation and related services in Nigeria.
		</div>
	</div>
</div>

<?php
require_once "includes/footer.php";
?>