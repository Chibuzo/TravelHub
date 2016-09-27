<?php
//require_once "../includes/config.php";
require_once "db.class.php";

class Model {

	protected static $db;

	protected function __construct()
	{
		require_once $_SERVER['DOCUMENT_ROOT'] . "/travelhub/config/config.php";

		self::$db = new db(DB_NAME);
	}


	public function getOneById($tbl, $id)
	{
		$sql = "SELECT * FROM {$tbl} WHERE id = :id";
		self::$db->query($sql, array('id' => $id));
		return self::$db->fetch('obj');
	}


	public function getAll($tbl, $orderby = null)
	{
		if ($orderby != null) {
			$orderby = "ORDER BY " . $orderby;
		}
		$sql = "SELECT * FROM {$tbl} {$orderby}";
		self::$db->query($sql);
		return self::$db->fetchAll('obj');
	}


	public function getManyById($tbl, $id_field, $id, $orderby = null)
	{
		if ($orderby != null) {
			$orderby = "ORDER BY " . $orderby;
		}
		$sql = "SELECT * FROM {$tbl} WHERE {$id_field} = :id {$orderby}";
		self::$db->query($sql, array('id' => $id));
		return self::$db->fetchAll('obj');
	}


	public function getNumRows($tbl_name, $where = null)
	{
		if ($where === null) $where = "";

		self::$db->query("SELECT COUNT(*) AS num_rows FROM {$tbl_name} {$where}");
		$result = self::$db->fetch('obj');
		return $result->num_rows;
	}


	public static function pushData($data, $push_type)
	{
		$data['push_type'] = $push_type;
		$context = new ZMQContext();
		$requester = new ZMQSocket($context, ZMQ::SOCKET_REQ);
		$requester->connect("tcp://localhost:5555");
		$requester->send(json_encode($data));
		return $requester->recv();
	}
}

?>
