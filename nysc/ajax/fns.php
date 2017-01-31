<?php
session_start();
require_once "../../api/models/Nysc.php";

if (isset($_SESSION['token']) && $_POST['token'] != $_SESSION['token']) exit;
$token_age = time() - $_SESSION['token_time'];
if ($token_age > 300) exit;

$nysc = new Nysc();

if (isset($_REQUEST['op'])) {
    if ($_REQUEST['op'] == 'book-nysc')
    {
        extract($_POST);
        $status = $nysc->book($fullname, $phone, $email, $origin, $camp, $travel_date, $travelers, $fare);
        if ($status == true) {
            echo "Done";
        }
    }
}