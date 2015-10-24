<?php
require_once "../includes/config.php";
require_once "../api/models/db.class.php";

class Agent {
	private $username;
	private $dbh;
	public $id;
	
	public function __construct($agent_username=null)
	{
		$this->dbh = new db(DB_NAME);
		
		if (!empty($agent_username) && $agent_username != null) {
			$this->username = $agent_username;
			$this->id = $this->getId();
		} 
		return true;
	}
	
	
	#function createAgent()
	#{
	#	
	#}
	#
	#
	#function login()
	#{
	#	
	#}
	
	
	function getId()
	{
		$sql = "SELECT id FROM agents WHERE username = :username";
		$param = array('username' => $this->username);
		
		$this->dbh->query($sql, $param);
		$id = $this->dbh->fetch("obj");
		if (isset($id->id))
			return $id->id;
		return '0';
	}
	
	
	function getTicketSales($from, $to)
	{
		if ($this->id == 0)
			$where1 = "WHERE agent_id <> '0' AND ";
		else
			$where1 = "WHERE agent_id = '$this->id' AND ";
			
		$sql = "SELECT bd.id AS bk_id, c_name, phone_no, payment_opt, payment_status, travel_date, date_booked, route, fare, company_name, terminal, agent_name
				FROM booking_details AS bd 
				JOIN routes r ON r.id = bd.route_id 
				JOIN travels t ON t.id = bd.travel_id
				JOIN agents a ON a.id = bd.agent_id
				$where1";
		
		if ($from != $to) {
			$where = "(DATE_FORMAT(date_booked, '%X-%m-%d') BETWEEN '{$from}' AND '{$to}') AND bd.status = '1' ORDER BY agent_name";
		} else {
			$date = date('Y-m-d');
			$where = "DATE_FORMAT(date_booked, '%X-%m-%d') = '$date' AND bd.status = '1' ORDER BY agent_name";
		}
				
		$this->dbh->query($sql.$where);
		return $this->dbh->stmt;
	}
	
	
	function getPercentage($fare, $percentage)
	{
		return ((0.1 * $fare) * ($percentage / 100));
	}
	
	
	function agentFormSelectListing($username)
	{
		$this->dbh->query("SELECT username, agent_name FROM agents");
		$options = '';
		foreach ($this->dbh->stmt AS $agent) {
			if ($username == $agent['username'])
				$options .= "<option value='{$agent['username']}' selected=selected>{$agent['agent_name']}</option>";
			else
				$options .= "<option value='{$agent['username']}'>{$agent['agent_name']}</option>";
		}
		return $options;
	}
	
	
	function displayAgentsDetails()
	{
		$this->dbh->query("SELECT * FROM agents");
		$tr = ''; $n = 0;
		foreach ($this->dbh->stmt AS $agent) {
			++$n;
			$tr .= "<tr>
						<td>{$agent['agent_name']}</td>
						<td><a href='{$agent['web_addresss']}'>{$agent['web_addresss']}</a></td>
						<td>{$agent['email']}</td>
						<td>" . date('Y-m-d', strtotime($agent['date_registered'])) . "</td>
					</tr>";
		}
		return $tr;
	}
}

?>