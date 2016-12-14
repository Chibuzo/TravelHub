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


    public function getBookingIssues()
    {
        $sql = "SELECT bi.*, c_name, phone_no, vt.name vehicle_name, route, park origin_park, p.id park_id,  bd.channel, abbr, t.id travel_id FROM booking_issues bi
                JOIN trips tr ON bi.trip_id = tr.id
                JOIN vehicle_types vt ON tr.vehicle_type_id = vt.id
                JOIN routes r ON tr.route_id = r.id
                JOIN boarding_vehicle bv ON bi.trip_id = bv.trip_id AND bi.departure_order = bv.departure_order AND bi.travel_date = bv.travel_date
                JOIN booking_details bd ON bv.id = bd.boarding_vehicle_id AND bi.seat_no = bd.seat_no
                JOIN customers c ON bd.customer_id = c.id
                JOIN park_map pm ON tr.park_map_id = pm.id
                JOIN parks p ON pm.origin = p.id
                JOIN travels t ON tr.travel_id = t.id
                WHERE resolved = '0'
                ORDER BY logged_at DESC";

        self::$db->query($sql);
        if ($issues = self::$db->fetchAll('obj')) {
            return $issues;
        }
        return array();
    }


    public function getNumOfIssues()
    {
        $issues = array('synch' => 0, 'booking' => 0);
        self::$db->query("SELECT COUNT(*) num FROM booking_synch");
        if ($num = self::$db->fetch('obj')) {
            $issues['synch'] = $num->num;
        }
        self::$db->query("SELECT COUNT(*) num FROM booking_issues WHERE resolved = '0'");
        if ($num = self::$db->fetch('obj')) {
            $issues['booking'] = $num->num;
        }
        return $issues;
    }
}