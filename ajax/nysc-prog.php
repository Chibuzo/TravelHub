<?php
/**
 * Created by PhpStorm.
 * User: Uzo
 * Date: 1/18/2017
 * Time: 2:47 PM
 */
require_once "../api/models/Nysc.php";
$nysc = new Nysc();

if (isset($_REQUEST['op'])) {
    if ($_REQUEST['op'] == 'add-prog')
    {
        if ($nysc->createProgram($_POST['batch'], $_POST['stream'], $_POST['camp_date'])) {
            echo 'Done';
        }
    }
    elseif ($_REQUEST['op'] == 'add-fares')
    {
        if ($nysc->addFares($_POST['fares'], $_POST['program_id'])) {
            echo "Done";
        }
    }
}