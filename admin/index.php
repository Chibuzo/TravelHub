<?php
session_start();
require_once("../includes/db_handle.php");

if (isset($_REQUEST['staff'])) {
	extract($_REQUEST);	
	$db->query("SELECT salt FROM staff WHERE username = :username", array('username' => $username));
	$result = $db->fetch('obj');
	if (!empty($result->salt)) {
		$password = hash('sha256', $password . $result->salt);
		
		$sql = "SELECT id, page, status FROM staff WHERE username = :username AND password = :password";
		$param = array('username' => $username, 'password' => $password);
		$db->query($sql, $param);
		$staff = $db->fetch('obj');
		if (!empty($staff->id)) {
			if ($staff->status == '1') {
				$_SESSION['page'] = $staff->page;
				if (isset($staff->page)) {
					header("Location: {$staff->page}");
					exit;
				} 
			} else {
				$msg = "<div class='alert alert-warning'>This account has not been activated, yet.</div>";
			}
		} else {
			$msg = "<div class='alert alert-error'>Are you trying to use someone else's account? We won't let you.</div>";
		}
	} else {
		$msg = "<div class='alert alert-danger'>Leave here, we don't know you.</div>";
	}
} 

require_once "../includes/banner.php";
?>
<div class="content">
	<br />
	<h1>&nbsp;Staff Login</h1>
	<hr />
	<?php echo isset($msg) ? $msg : null; ?>
	<br />
	<form method="post" class="form-horizontal" role="form">
		<div class="form-group">
			<label for="username" class="col-sm-2 control-label">Username</label>
			<div class="col-sm-4">
				<input type='text' name='username' class="form-control" placeholder='Username' />
			</div>
		</div>
		
		<div class="form-group">
			<label for ="password" class="col-sm-2 control-label">Password</label>
			<div class="col-sm-4">
				<input type='password' name='password' class="form-control" placeholder='Password' />
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-5">
				<input type="submit" name="staff" value=" Login " class="btn btn-primary" />
			</div>
		</div>
	</form>
	
</div>

<?php require_once "../includes/footer.php"; ?>