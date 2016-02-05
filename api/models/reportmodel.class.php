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
}
