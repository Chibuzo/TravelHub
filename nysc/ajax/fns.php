<?php
require_once "../../api/models/Nysc.php";

$nysc = new Nysc();

if (isset($_REQUEST['op'])) {
    if ($_REQUEST['op'] == 'book-nysc')
    {
        extract($_POST);
        $status = $nysc->book($fullname, $phone, $email, $origin, $camp, $travel_date, $travelers);
        if ($status == true) {
            echo "Done";
        }
    }
}