<?php
require_once "model.class.php";

class Customer extends Model {
	public $customer_name, $phone_no, $next_of_kin_phone, $id;

	public function __construct()
	{
		parent::__construct();
	}


	function addNew(Customer $customer)
	{
		$sql = "INSERT INTO customers
				(c_name, phone_no, next_of_kin_phone) VALUES (:c_name, :phone_no, :next_of_kin_phone)";

		$param = array(
				'c_name' => $customer->customer_name,
				'phone_no' => $customer->phone_no,
				'next_of_kin_phone' => $customer->phone_no
		);

		if (self::$db->query($sql, $param)) {
			return self::$db->getLastInsertId();
		} else {
			return false;
		}
	}


	function update($c_name, $phone, $next_of_kin, $id)
	{
		$sql = "UPDATE customers SET
					c_name = :c_name,
					phone_no = :phone_no,
					next_of_kin_phone = :next_of_kin_phone
				WHERE id = :id";

		$param = array(
				'c_name' => $c_name,
				'phone_no' => $phone,
				'next_of_kin_phone' => $next_of_kin,
				'id' => $id
		);
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


	function getCustomer($field, $value)
	{
		$sql = "SELECT * FROM customers WHERE {$field} = '$value'";
		self::$db->query($sql, array('value' => $value));
		if ($customer = self::$db->fetch()) {
			return $customer;
		} else {
			return false;
		}
	}
}

?>
