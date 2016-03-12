<?php
require_once "includes/banner.php";
?>

<style>
@media screen and (min-width: 320px) and (max-width: 600px) {
	footer {
		position: absolute;
		bottom: 0;
	}
</style>
<div class="container">
<?php
$title = "Thank you";

if ($_REQUEST['q'] == '1') {
	$msg = "Your mTicket will be sent to your mobile phone once your bank payment is confirmed.<br />
	You can also use your ticket number to SMS our mTicket to your mobile number.";
} elseif ($_REQUEST['q'] == '2') {
	$msg = "Your mTicket will be sent to your mobile number shortly. Remember to pay for your reservation early enough.";
}

echo "<div id='content'><br />
		<h2>$title</h2><br />
		<blockquote>
			<p>$msg</p>
		</blockquote>
	</div>";

echo "</div>";
include_once "includes/footer.php";
?>
