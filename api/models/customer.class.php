<?php
require_once "model.class.php";

class Customer extends Model {

	public function __construct()
	{
		parent::__construct();
	}


	function addNew($param)
	{
		#$name = mysqli_real_escape_string($this->dbh, $_POST['customer_name']);
		#$address         = isset($_POST['address']) ? $_POST['address'] : '';
		#$next_of_kin     = $_POST['next_of_kin_phone'];
		#$traveler_phone  = isset($_POST['traveler_phone']) ? $_POST['traveler_phone'] : '';

		$sql = "INSERT INTO customers
				(c_name, phone_no, next_of_kin_phone)
				VALUES
				(:c_name, :phone_no, :next_of_kin_phone)";

		if (self::$db->query($sql, $param)) {
			return self::$db->getLastInsertId();
		} else {
			return false;
		}
	}


	function update($param)
	{
		$sql = "UPDATE customers SET
					c_name = :c_name,
					phone_no = :phone_no,
					next_of_kin_phone = :next_of_kin_phone,
					email = :email
				WHERE id = :id";

		if (self::$db->query($sql, $param)) {
			return true;
		} else {
			return false;
		}
	}


	function findCustomer($field, $value)
	{
		$sql = "SELECT id FROM customers WHERE {$field} = :value";
		self::$db->query($sql, array('value' => $value));
		if ($customer = self::$db->fetch('obj')) {
			return $customer->id;
		} else {
			return false;
		}
	}


	function getCustomer($field, $id)
	{
		$sql = "SELECT * FROM customers WHERE {$field} = '$id'";
		if (self::$db->query($sql)) {
			return self::$db->fetch();
		} else {
			return false;
		}
	}
}

?>
