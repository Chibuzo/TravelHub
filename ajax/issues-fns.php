<?php
require_once "../api/models/bookingissues.class.php";
$bookingIssue = new BookingIssues();

if (isset($_REQUEST['op'])) {
    if ($_REQUEST['op'] == 'change-issue-status')
    {
        $bookingIssue->updateField('booking_issues', 'resolved', '1', $_POST['id']);
        echo "Done";
    }
    elseif ($_REQUEST['op'] == 'fetch-travel-contact')
    {
        require_once "../api/models/parkmodel.class.php";
        $park = new ParkModel();
        $parks = array();
        $parks = $park->getTravelParksByPark($_POST['travel_id'], $_POST['park_id']);
        $parks->status = 'success';
        echo json_encode($parks);
    }
}