<?php
require_once "model.class.php";

class BookingIssues extends Model
{
    private static $db_tbl = "booking_issues";

    function __construct()
    {
        parent::__construct();
    }


    public function logFailedPush($trip_id, $travel_date, $seat_no, $departure_order, $cust_name, $cust_phone, $next_of_kin_phone, $channel, $terminal, $reason)
    {
        $sql = "INSERT INTO booking_synch
					(trip_id, travel_date, seat_no, departure_order, customer_name, customer_phone, next_of_kin_phone, channel, category, reason)
					VALUES
					(:trip_id, :travel_date, :seat_no, :departure_order, :cust_name, :cust_phone, :next_of_kin_phone, :channel, :category, :reason)";

        $param = array(
            'trip_id' => $trip_id,
            'travel_date' => $travel_date,
            'seat_no' => $seat_no,
            'departure_order' => $departure_order,
            'cust_name' => $cust_name,
            'cust_phone' => $cust_phone,
            'next_of_kin_phone' => $next_of_kin_phone,
            'channel' => $channel,
            'category' => $terminal,
            'reason' => $reason
        );
        self::$db->query($sql, $param);
    }


    public function pushFailedPush($terminal)
    {
        self::$db->query("SELECT * FROM booking_synch WHERE category = :category", array('category' => $terminal));
        foreach (self::$db->stmt AS $row) {
            $result = self::pushData($row, 'booking');
            if ($result != 'Disconnected') {
                self::$db->query("DELETE FROM booking_synch WHERE id = '{$row['id']}'");
            }
        }
    }
}