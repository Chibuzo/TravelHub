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


    public function createProgram($batch, $stream, $date)
    {
        $sql = "INSERT INTO nysc_programs (batch, stream, camp_date) VALUES (:batch, :stream, :camp_date)";
        $param = array(
            'batch' => $batch,
            'stream' => $stream,
            'camp_date' => $date
        );
        if (self::$db->query($sql, $param)) {
            return self::$db->getLastInsertId();
        } else {
            return false;
        }
    }


    public function addFares($fares, $program_id)
    {
        $sql = "INSERT INTO nysc_fares (nysc_program_id, state_id, fare) VALUES (:program_id, :state_id, :fare)";
        self::$db->prepare($sql);

        foreach ($fares AS $fare) {
            $vals = explode("-", $fare);
            $param = array(
                'program_id' => $program_id,
                'state_id' => $vals[1],
                'fare' => $vals[0]
            );
            self::$db->execute($param);
        }
        return true;
    }


    public function getCampFares()
    {
        $sql = "SELECT cf.*, state_name FROM nysc_fares cf
                JOIN nysc_programs np ON cf.nysc_program_id = np.id
                JOIN states s ON cf.state_id = s.id
                WHERE np.status = '1'";

        self::$db->query($sql);
        if ($fares = self::$db->fetchAll('obj')) {
            return $fares;
        }
    }


    public function book($fullname, $phone, $email, $origin, $destination, $travel_date, $passengers, $fare)
    {
        $ref = $this->generateRefNo();

        $sql = "INSERT INTO " . self::$db_tbl . "
                (fullname, phone, email, origin, destination, travel_date, passengers, ref_code, fare)
                    VALUES
                (:fullname, :phone, :email, :origin, :destination, :travel_date, :passengers, '$ref', :fare)";

        $param = array(
            'fullname' => $fullname,
            'phone' => $phone,
            'email' => $email,
            'origin' => $origin,
            'destination' => $destination,
            'travel_date' => $travel_date,
            'passengers' => $passengers,
            'fare' => $fare
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