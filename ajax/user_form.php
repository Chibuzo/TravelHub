<?php
session_start();
require_once "../classes/user.class.php";

$user = new User();
extract($_POST);
if ($_REQUEST['op'] == 'add-user') {
	if ($user->createUser($fullname, $username, $password, $user_level) === true) {
		echo "Done";
	}
}
elseif ($_REQUEST['op'] == 'edit-user') {
	//extract($_POST);
	if ($user->updateUser($id, $fullname, $username, $user_level) == true) {
		echo "Done";
	}
}
elseif ($_REQUEST['op'] == 'delete-user') {
	if ($user->delete('', $_POST['id']) === true) {
		echo "Done";
	}
}
elseif ($_REQUEST['op'] == 'update-username') {
	if ($user->changeUsername($name, $_SESSION['user_id']) === true) {
		echo "Operation successful";
	}
}
elseif ($_REQUEST['op'] == 'change-password') {
	try {
		if ($user->changePassword($mypswd, $newpswd, $_SESSION['user_id']) === true) {
			echo "Operation successful";
		}
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}
?>
