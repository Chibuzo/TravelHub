<?php
/**
 * Created by PhpStorm.
 * User: Uzo
 * Date: 12/5/2016
 * Time: 10:43 AM
 */

require_once "model.class.php";

class Nysc extends Model
{
    public static $db_tbl = "nysc_travelers";

    public function __construct()
    {
        parent::__construct();
    }


    public function book($fullname, $phone, $email, $origin, $destination, $travel_date, $passengers)
    {
        $ref = $this->generateRefNo();

        $sql = "INSERT INTO " . self::$db_tbl . "
                (fullname, phone, email, origin, destination, travel_date, passengers, ref_code)
                    VALUES
                (:fullname, :phone, :email, :origin, :destination, :travel_date, :passengers, '$ref')";

        $param = array(
            'fullname' => $fullname,
            'phone' => $phone,
            'email' => $email,
            'origin' => $origin,
            'destination' => $destination,
            'travel_date' => $travel_date,
            'passengers' => $passengers
        );

        if (self::$db->query($sql, $param)) {
            return $ref;
        }
    }


    public function update($id, $fullname, $phone, $email, $origin, $destination, $travel_date, $passengers, $fare)
    {
        self::$db->query("SELECT * FROM " . self::$db_tbl . " WHERE id = :id", array('id' => $id));
        if ($book = self::$db->fetch('obj')) {

        }
    }


    private function generateRefNo() {
        $find    = array('/', '+', '=', "\\", '|', '-');
        $replace = array('X', 'Y', 'Z', 'U', 'O', '4');
        return strtoupper(str_replace($find, $replace, base64_encode(mcrypt_create_iv(6, MCRYPT_RAND))));
    }


    //public function fetchBooking()
}