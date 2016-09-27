<?php

require_once 'model.class.php';

class ReportModel extends Model
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

    function stateGetBooking($travel_id, $state_id, $mode = "MONTH", $start = null, $end = null)
    {
        $where = "";
        $param = array('travel_id' => $travel_id, 'state_id' => $state_id);
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
            ." WHERE tv.id = :travel_id AND tp.state_id = :state_id " . $where . " GROUP BY " . $group_by;
        self::$db->query($sql, $param);
        return self::$db->fetchAll('obj');
    }

    function parkGetBooking($travel_id, $park_id, $mode = "MONTH", $start = null, $end = null)
    {
        $where = "";
        $param = array('travel_id' => $travel_id, 'park_id' => $park_id);
        $mode = strtoupper($mode);
        $sql_fn = ($mode == "MONTH") ? "MONTHNAME" : "YEAR";
        if (!($start == null || $end == null)) {
            $where = " AND date_booked BETWEEN :start AND :end";
            $param['start'] = $start;
            $param['end'] = $end;
        }
        $group_by = $mode . "(date_booked)";
        $sql = "SELECT COUNT(*) AS numb, {$sql_fn}(date_booked) AS sort FROM " . static::$bookings
            . " JOIN boarding_vehicle bv ON bv.id = booking_details.boarding_vehicle_id "
            . " JOIN trips tp ON tp.id = bv.trip_id"
            . " JOIN park_map pm ON pm.id = tp.park_map_id"
            . " JOIN travels tv ON tv.id = tp.travel_id"
            . " WHERE tv.id = :travel_id AND pm.origin = :park_id " . $where . " GROUP BY " . $group_by;
        self::$db->query($sql, $param);

        return self::$db->fetchAll('obj');
    }


    public function saveManifestAccount($boarding_vehicle_id, $feeding, $fuel, $scouters, $expenses, $load)
    {
        self::$db->query("SELECT id FROM manifest_account WHERE boarding_vehicle_id = :id", array('id' => $boarding_vehicle_id));

        $param = array(
            'feeding' => $feeding,
            'fuel' => $fuel,
            'scouters' => $scouters,
            'expenses' => $expenses,
            'load' => $load,
            'boarding_vehicle_id' => $boarding_vehicle_id
        );

        if ($id = self::$db->fetch('obj')) {
            $sql = "UPDATE manifest_account SET
                      feeding = :feeding,
                      fuel = :fuel,
                      scouters_charge = :scouters,
                      expenses = :expenses,
                      load_charge = :load
                    WHERE boarding_vehicle_id = :boarding_vehicle_id";

            self::$db->query($sql, $param);
        } else {
            $sql = "INSERT INTO manifest_account
                    (feeding, fuel, scouters_charge, expenses, load_charge, boarding_vehicle_id)
					VALUES
					(:feeding, :fuel, :scouters, :expenses, :load, :boarding_vehicle_id)";

			self::$db->query($sql, $param);
        }
        return true;
    }


    public function getDailyReport($date)
    {
        $sql = "SELECT bv.booked_seats, seat_status, bv.departure_order, po.park o_park, pd.park d_park, sd.state_name destination, so.state_name origin, vehicle_name bus_type, t.fare, (scouters_charge + feeding + fuel) expenses
				FROM boarding_vehicle bv
				JOIN trips t ON bv.trip_id = t.id
                JOIN park_map pm ON t.park_map_id = pm.id
                JOIN parks pd ON pm.destination = pd.id
                JOIN states sd ON pd.state_id = sd.id
                JOIN parks po ON pm.origin = po.id
                JOIN states so ON po.state_id = so.id
				JOIN travel_vehicle_types vt ON t.vehicle_type_id = vt.vehicle_type_id
				LEFT JOIN manifest_account ma ON bv.id = ma.boarding_vehicle_id
				WHERE bv.travel_date = :travel_date AND seat_status = 'Full' AND booked_seats <> ''
				GROUP BY bv.id
				ORDER BY vehicle_name, bv.departure_order";

        self::$db->query($sql, array('travel_date' => date('Y-m-d', strtotime($date))));
        if ($reports = self::$db->fetchAll()) {
            return $reports;
        } else {
            return array();
        }
    }
}
