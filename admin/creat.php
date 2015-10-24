<?php 
session_start();
require_once("../includes/general_functions.php");

docType();
printBanner();
echo "<div id='content'>";

if (isset($_POST['submit'])) {
	$fullname = filter($_POST['fullname']);
	$uname = filter($_POST['username']);
	$pswd  = filter($_POST['password']);
	$office = filter($_POST['office']);
	
	$result = $DB_CONNECTION->query("SELECT username FROM staff WHERE username = '$uname'");
	if (($result->num_rows) > 0) {
		echo "<div class='alert alert-notice'>This username is already taken, choose something else.</div>";
	} else {
		$salt     = base64_encode(mcrypt_create_iv(24, MCRYPT_DEV_URANDOM));
		$password = hash('sha256', $pswd . $salt);
		$sql = "INSERT INTO staff
					(fullname, username, password, office, salt, date_created)
				VALUES
					('$fullname', '$uname', '$password', '$office', '$salt', NOW())";
					
		$DB_CONNECTION->query($sql);
		echo "<div class='alert alert-success'>
				Your account has been created, you can now chill and wait a lifetime for activation.
			 </div>";
	}
	
} else {
?>
	<br />
	<div class="head">&nbsp;Create Account</div><hr /><br />
	<div>
		<form action="" method="post" class="form-horizontal">
			<div class="control-group">
				<label class="control-label">Full name</label>
				<div class='controls'>
					<input type="text" name="fullname" placeholder="Your full name" />
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label">Office</label>
				<div class='controls'>
					<input type="text" name="office" placeholder="Your office designation" />
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label">Username</label>
				<div class='controls'>
					<input type='text' name='username' placeholder='Choose a username' />
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label">Password</label>
				<div class='controls'>
					<input type='password' name='password' placeholder='Tell me your password' />
				</div>
			
			</div>
			<div class='controls'><input type="submit" class="btn btn-primary" name="submit" value="  Create account  " /></div>
		</form>
	</div>
	<br /><br />
	<?php
}
printFooter();
?>