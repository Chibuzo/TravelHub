<?php
/**
 * Created by PhpStorm.
 * User: Uzo
 * Date: 1/20/2017
 * Time: 7:57 AM
 */
extract($_POST);
if (sendSMS($name, $phone, $camp, $travel_date, $tickets, $fare)) {
    echo "Done";
}


function sendSMS($name, $phone, $destination, $travel_date, $tickets, $fare)
{
    $fare *= (int) $tickets;
    $message = urlencode("$name\n$destination camp\n$travel_date\nN$fare\n\nPay at\nIfesinachi Park: 2 Jibowu Str\nIkorodu Rd\nOR at\nDiamond bank\n0086410673\nTravelhub Transport Services LTD\n\nHelp: 09063369208");

    $url = sprintf("http://www.smslive247.com/http/index.aspx?cmd=sendquickmsg&owneremail=kiddthekid@yahoo.com&subacct=TravelHub&subacctpwd=travelhub&message=%s&sender=TravelHub&sendto=%s&msgtype=0", $message, $phone);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    curl_close($ch);
    return true;
}