<?php

require_once 'model.class.php';

class Report extends Model
{

    protected static $payment = 'payments';
    protected static $bookings = 'booking_details';

    function __construct() {
        parent::__construct();
    }

    function adminGetPayment()
    {

    }

    function adminGetBooking($mode = "MONTH", $start = null, $end = null)
    {
        $where = "";
        $param = null;
        $mode = strtoupper($mode);
        $sql_fn = ($mode == "MONTH")? "MONTHNAME" : "YEAR";
        if (!($start == null || $end == null)) {
            $where = " WHERE date_booked BETWEEN :start AND :end";
            $param = array('start' => $start, 'end' => $end);
        }
        $group_by = $mode . "(date_booked)";
        $sql = "SELECT COUNT(*) AS numb, {$sql_fn}(date_booked) AS sort FROM " . static::$bookings . $where . " GROUP BY " . $group_by;
        self::$db->query($sql, $param);
        return self::$db->fetchAll('obj');
    }

    function travelGetBooking($travel_id, $mode = "MONTH", $start = null, $end = null)
    {
        $where = "";
        $param = array('travel_id' => $travel_id);
        $mode = strtoupper($mode);
        $sql_fn = ($mode == "MONTH")? "MONTHNAME" : "YEAR";
        if (!($start == null || $end == null)) {
            $where = " AND date_booked BETWEEN :start AND :end";
            $param['start'] = $start;
            $param['end'] = $end;
        }
        $group_by = $mode . "(date_booked)";
        $sql = "SELECT COUNT(*) AS numb, {$sql_fn}(date_booked) AS sort FROM " . static::$bookings
                ." JOIN boarding_vehicle bv ON bv.id = booking_details.boarding_vehicle_id "
                ." JOIN trips tp ON tp.id = bv.trip_id"
                ." JOIN travels tv ON tv.id = tp.travel_id"
                ." WHERE tv.id = :travel_id " . $where . " GROUP BY " . $group_by;
        self::$db->query($sql, $param);
        return self::$db->fetchAll('obj');
    }

    function stateGetBooking($state_id, $mode = "MONTH", $start = null, $end = null)
    {
        $where = "";
        $param = array('state_id' => $state_id);
        $mode = strtoupper($mode);
        $sql_fn = ($mode == "MONTH")? "MONTHNAME" : "YEAR";
        if (!($start == null || $end == null)) {
            $where = " AND date_booked BETWEEN :start AND :end";
            $param['start'] = $start;
            $param['end'] = $end;
        }
        $group_by = $mode . "(date_booked)";
        $sql = "SELECT COUNT(*) AS numb, {$sql_fn}(date_booked) AS sort FROM " . static::$bookings
            ." JOIN boarding_vehicle bv ON bv.id = booking_details.boarding_vehicle_id "
            ." JOIN trips tp ON tp.id = bv.trip_id"
            ." JOIN travels tv ON tv.id = tp.travel_id"
            ." WHERE tp.state_id = :state_id " . $where . " GROUP BY " . $group_by;
        self::$db->query($sql, $param);
        return self::$db->fetchAll('obj');
    }
}
