<?php
session_start();
require "../api/models/user.class.php";
require_once '../api/models/travel.class.php';

$msg = $username = "";
if (isset($_POST['login'])) {
	$user = new User();
	extract($_POST);
	$status = $user->login($username, $password, $inst_code);
	if ($status === true) {
        if ($_SESSION['user_type'] == 'travel_admin') {
            $travel = (new Travel())->getTravelByUser($_SESSION['user_id']);
            $_SESSION['travel_id'] = $travel->id;
            header("Location: travel/dashboard.php");
        } elseif ($_SESSION['user_type'] == 'state_admin') {
            $travel = (new Travel())->getTravelStateByUser($_SESSION['user_id']);
            $_SESSION['travel_id'] = $travel->travel_id;
            $_SESSION['state_id'] = $travel->state_id;
            header("Location: state/dashboard.php");
        } elseif ($_SESSION['user_type'] == "park_admin") {
            $travel = (new Travel())->getTravelParkByUser($_SESSION['user_id']);
            $_SESSION['travel_id'] = $travel->travel_id;
            $_SESSION['state_id'] = $travel->state_id;
            $_SESSION['park_id'] = $travel->park_id;
            header("Location: park/dashboard.php");
        } elseif ($_SESSION['user_type'] == 'admin') {
            header("Location: admin/dashboard.php");
        }
		exit;
	} else {
        $msg = "Login failed. Please, check credentials";
        $username = empty($_POST['username']) ? "" : $_POST['username'];
	}
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>TravelHub | Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]-->
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>

  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href=""><b>TravelHub</b>Admin</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg text-red"><?=$msg?></p>
        <form action="" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="username" class="form-control" placeholder="Username" value="<?=$username?>" required />
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Password" required />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
              <input type="hidden" name="inst_code" value="operator" />
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="">

              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

        <!--<a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a>-->

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
  </body>
</html>
