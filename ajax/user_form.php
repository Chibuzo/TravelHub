<?php
session_start();
require_once "../api/models/user.class.php";

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
    if (isset($_POST['user_type']) && $_POST['user_type'] == "travel_admin") {
        if ($user->delete($_POST['id'], 'travel_admins') === true) {
            echo "Done";
        }
    } else {
        if ($user->delete($_POST['id']) === true) {
            echo "Done";
        }
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
elseif ($_REQUEST['op'] == 'edit-travel-admin') {
    try {
        if ($user->updateTravelUser($id, $full_name, $username) === true) {
            echo "Done";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
