<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/travelhub/config/config.php";

class DBConnection {
	private static $instance;
	private $dsn;
	private static $db_name;

	private function __clone() {}

	public static function getInstance($db_name) {
		if (!self::$instance || $db_name != self::$db_name) {
			$dsn = "mysql:host=localhost;dbname=$db_name";
			$options = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			);

			try {
				self::$instance = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
				self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				echo $e->getMessage();
				exit;
			}
		}
		return self::$instance;
	}
}


class db extends DBConnection {

	public function __construct($db_name) {
		$this->dbh = DBConnection::getInstance($db_name);
	}

	/**
	 * All queries are prepared!
	 * Parameters -
	 * 	@$sql - The SQL query
	 * 	@$param - Associative array, the associative index must bear the same name(s) as the placeholder(s)
	 * 	and their positions must correspond with their placeholder position in the query
	 */
	public function query($sql, $param=null)
	{
		try {
			$this->prepare($sql);
			$this->execute($param);
			return $this->stmt; 	// Return PDO result statment
		} catch (PDOException $e) {
			echo "Something bad happened - " . $e->getMessage();
			return false;
		}
	}

	function prepare($sql)
	{
		$this->stmt = $this->dbh->prepare($sql);
	}


	function execute($param)
	{
		$this->stmt->execute($param);
	}


	function fetch($mode = null)
	{
		if ($mode == 'obj')
			return $this->stmt->fetch(PDO::FETCH_OBJ);
		else
			return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}


	function fetchAll($mode = null)
	{
		if ($mode == 'obj')
			return $this->stmt->fetchAll(PDO::FETCH_OBJ);
		else
			return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}


	function escapeString($val)
	{
		if (!$this->dbh) {
			return null;
		}
		return $this->dbh->quote($val);
	}


	function getLastInsertId()
	{
		if (!$this->dbh) {
			return null;
		}
		return $this->dbh->lastInsertId();
	}


	function beginDbTransaction()
	{
		if (!$this->dbh) {
			return null;
		}
		$this->dbh->beginTransaction();
	}

	function commitTransaction()
	{
		if (!$this->dbh) {
			return null;
		}
		$this->dbh->commit();
	}

	function rollBackTransaction()
	{
		if (!$this->dbh) {
			return null;
		}
		$this->dbh->rollBack();
	}
}

?>
