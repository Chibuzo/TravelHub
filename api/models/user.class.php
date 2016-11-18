<?php
require_once "travel.class.php";

class User extends Travel {

    private $tables = array('operator' => 'travel_admins', 'travelhub' => 'users');

	function __construct()
	{
		parent::__construct();
	}


	function createUser($fullname, $username, $password, $usertype)
	{
		$sql = "SELECT username FROM users WHERE username = :username";
        self::$db->query($sql, array('username' => $username));
		$result = self::$db->fetch();
		if (isset($result->username)) {
			return "02"; // username already taken
		} else {
			$salt     = base64_encode(mcrypt_create_iv(24, MCRYPT_DEV_URANDOM));
			$password = hash('sha256', $password . $salt);

			$param = array(
				'fullname' => $fullname,
				'username' => $username,
				'password' => $password,
				'usertype' => $usertype
			);

			$sql = "INSERT INTO users
						(fullname, username, password, user_type, salt)
					VALUES
						(:fullname, :username, :password, :usertype, '$salt')";

			if (self::$db->query($sql, $param)) {
				return self::$db->getLastInsertId();
			}
		}
		return false;
	}

    function createTravelAdmin($fullname, $username, $password, $user_type, $travel_id)
    {
        $sql = "SELECT username FROM travel_admins WHERE username = :username";
        self::$db->query($sql, array('username' => $username));
        $result = self::$db->fetch();
        if (isset($result->username)) {
            return "02"; // username already taken
        } else {
            $salt     = base64_encode(mcrypt_create_iv(24, MCRYPT_DEV_URANDOM));
            $password = hash('sha256', $password . $salt);

            $param = array(
                'fullname'  => $fullname,
                'username'  => $username,
                'password'  => $password,
                'user_type'  => $user_type,
                'salt'      => $salt,
                'travel_id' => $travel_id
            );

            $sql = "INSERT INTO travel_admins
						(fullname, username, password, user_type, salt, travel_id)
					VALUES
						(:fullname, :username, :password, :user_type, :salt, :travel_id)";

            if (self::$db->query($sql, $param)) {
                return self::$db->getLastInsertId();
            }
        }
        return false;
    }

    function createStateAdmin($fullname, $username, $password, $travel_id, $state_id)
    {
        self::$db->beginDbTransaction();
        $user_id = $this->createTravelAdmin($fullname, $username, $password, 'state_admin', $travel_id);
        if ($user_id !== false) {
            if ($this->addTravelState($travel_id, $state_id, $user_id) !== false) {
                self::$db->commitTransaction();
                return $user_id;
            } else {
                //TODO: roll-back isn't working!!!
                self::$db->rollBackTransaction();
                return false;
            }
        }
    }

    function createParkAdmin($address, $phone, $fullname, $username, $password, $travel_id, $park_id)
    {
        self::$db->beginDbTransaction();
        $user_id = $this->createTravelAdmin($fullname, $username, $password, 'park_admin', $travel_id);
        if ($user_id !== false) {
            if ($this->addTravelPark($address, $phone, $travel_id, $park_id, $user_id) !== false) {
                self::$db->commitTransaction();
                return $user_id;
            } else {
                //TODO: roll-back isn't working!!!
                self::$db->rollBackTransaction();
                return false;
            }
        }
    }

	function login($username, $password, $inst_code)
	{
		if (empty($username) || empty($password) || empty($inst_code)) {
			return "01"; // Empty username or password or institution code field
		}

        $tbl = $this->tables[$inst_code];

		$sql = "SELECT salt FROM ".$tbl." WHERE username = :username AND deleted = '0'";
        self::$db->query($sql, array('username' => $username));
		$obj = self::$db->fetch("obj");
		if (!isset($obj->salt)) {
			return "02"; // User not found
		}

		$salt = $obj->salt;
		$password = hash('sha256', $password . $salt);
		$param = array('username' => $username, 'password' => $password);

		$sql = "SELECT username, id, user_type FROM ".$tbl." WHERE username = :username AND password = :password";

        self::$db->query($sql, $param);
		if ($obj = self::$db->fetch("obj")) {
			$_SESSION['user_type'] = $obj->user_type;
			$_SESSION['username']  = $obj->username;
			$_SESSION['user_id']   = $obj->id;

			// get travel details
			$sql = "SELECT company_name, abbr, t.id
                    FROM travels t
					JOIN travel_admins ta ON ta.travel_id = t.id
					WHERE ta.id = '$obj->id'";

			self::$db->query($sql);
			if ($travel = self::$db->fetch('obj')) {
				$_SESSION['company_name'] = $travel->company_name;
				$_SESSION['abbr']         = $travel->abbr;
				$_SESSION['travel_id']    = $travel->id;
			}

			// get state details for state admins
			if ($obj->user_type == 'state_admin') {
				$state = $this->getStateDetails($obj->id);
				$_SESSION['state_id']   = $state->id;
				$_SESSION['state_name'] = $state->state_name;
			}

			// lets get park id for park admins
			if ($obj->user_type == 'park_admin') {
				$park = $this->getParkDetails($obj->id);
				$_SESSION['park_id'] = $park->id;
				$_SESSION['park']    = $park->park;
			}
			return true;
		}
		return "Couldn't logn";
	}


	public function updateUser($id, $fullname, $username, $user_type, $password = null)
	{
        $param = array(
            'fullname' => $fullname,
            'username' => $username,
            'user_type' => $user_type,
            'id'       => $id
        );
        $password_sql = "";
        if ($password !== null) {
            $salt     = base64_encode(mcrypt_create_iv(24, MCRYPT_DEV_URANDOM));
            $password = hash('sha256', $password . $salt);
            $param['password'] = $password;
            $param['salt'] = $salt;
            $password_sql = ", password = :password, salt = :salt";
        }
		$sql = "UPDATE users SET
					fullname = :fullname,
					username = :username,
					user_type = :user_type {$password_sql}
				WHERE id = :id";

		if (self::$db->query($sql, $param)) {
			return true;
		}
	}

    public function updateTravelUser($id, $fullname, $username, $user_type = null, $password = null)
    {
        $param = array(
            'fullname' => $fullname,
            'username' => $username,
            'id'       => $id
        );
        $user_type_sql = "";
        if ($user_type !== null) {
            $user_type_sql = ", user_type = :user_type";
            $param['user_type'] = $user_type;
        }
        $password_sql = "";
        if ($password !== null) {
            $salt     = base64_encode(mcrypt_create_iv(24, MCRYPT_DEV_URANDOM));
            $password = hash('sha256', $password . $salt);
            $param['password'] = $password;
            $param['salt'] = $salt;
            $password_sql = ", password = :password, salt = :salt";
        }
        $sql = "UPDATE travel_admins SET
					fullname = :fullname,
					username = :username
					{$user_type_sql} {$password_sql}
				WHERE id = :id";

        if (self::$db->query($sql, $param)) {
            return true;
        }
    }

	public function changeUsername($username, $id) {
		$sql = "UPDATE users SET username = :username WHERE id = :id";

		$param = array(
			'username' => $username,
			'id'       => $id
		);

		if (self::$db->query($sql, $param)) {
			$_SESSION['username'] = $username;
			return true;
		}
	}


	public function changePassword($old_pswd, $new_pswd, $id, $tbl = "users") {
		$sql = "SELECT salt, password FROM {$tbl} WHERE id = :id";
        self::$db->query($sql, array('id' => $id));
		$obj = self::$db->fetch("obj");
		if (!isset($obj->salt)) {
			throw new Exception ("User not found");
		}

		$salt = $obj->salt;
		$password = hash('sha256', $old_pswd . $salt);
		if ($obj->password != $password) {
			throw new Exception("Wrong password!");
		}
		$new_password = hash('sha256', $new_pswd . $salt);
		$param = array('password' => $new_password, 'id' => $id);
		$sql = "UPDATE {$tbl} SET password = :password WHERE id = :id";

		$param = array(
			'password' => $new_password,
			'id'       => $id
		);

		if (self::$db->query($sql, $param)) {
			return true;
		}
	}


	public function delete($id, $tbl = "users")
	{
		if (self::$db->query("UPDATE {$tbl} SET deleted = '1' WHERE id = :id", array('id' => $id))) {
			return true;
		}
	}


	function getUserById($id)
	{
		self::$db->query("SELECT * FROM users WHERE id = :id AND deleted = '0'", array('id' => $id));
        return self::$db->fetch('obj');
	}


	function getTravelUsersByPark($travel_id, $park_id)
	{
		$sql = "SELECT ta.*
                FROM travel_admins ta
		  		JOIN travel_park tp ON ta.id = tp.user_id
		  		WHERE ta.travel_id = :travel_id AND tp.park_id = :park_id";

		self::$db->query($sql, array('travel_id' => $travel_id, 'park_id' => $park_id));
		return self::$db->fetchAll('obj');
	}


	function getAllUsers()
	{
		return self::$db->query("SELECT * FROM users WHERE deleted = '0' ORDER BY date_created");
	}

    function getTravelAdmins()
    {
        return self::$db->query("SELECT * FROM travel_admins WHERE deleted = '0' ORDER BY date_created");
    }

    function getUsersByTravel($travel_id)
    {
        $sql = "SELECT * FROM travel_admins WHERE travel_admins.travel_id = :travel_id AND deleted = 0";
        self::$db->query($sql, array('travel_id' => $travel_id));
        return self::$db->fetchAll('obj');
    }

    function addTravelState($travel_id, $state_id, $user_id)
    {
        try {
            $sql = "INSERT INTO travel_state (travel_id, state_id, user_id) VALUES (:travel_id, :state_id, :user_id)";
            $result = self::$db->query($sql, array('travel_id' => $travel_id, 'state_id' => $state_id, 'user_id' => $user_id));
            if ($result !== false) {
                $params['id'] = self::$db->getLastInsertId();
                return $params;
            }
            return false;
        } catch (\PDOException $e) {
            return false;
        }
    }

    function addTravelPark($address, $phone, $travel_id, $park_id, $user_id)
    {
        try {
            $sql = "INSERT INTO travel_park (travel_id, park_id, user_id, address, phone) VALUES
					(:travel_id, :park_id, :user_id, :address, :phone)";

            $result = self::$db->query($sql, array(
					'travel_id' => $travel_id,
					'park_id' => $park_id,
					'user_id' => $user_id,
					'address' => $address,
					'phone' => $phone
			));
            if ($result !== false) {
                $params['id'] = self::$db->getLastInsertId();
                return $params;
            }
            return false;
        } catch (\PDOException $e) {
            return false;
        }
    }

	function getParkDetails($user_id)
	{
		$sql = "SELECT p.id, park, address, phone FROM travel_park tp JOIN parks p ON tp.park_id = p.id WHERE user_id = :user_id";
		self::$db->query($sql, array('user_id' => $user_id));
		if ($park = self::$db->fetch('obj')) {
			return $park;
		}
	}


	function getStateDetails($user_id)
	{
		$sql = "SELECT state_id, state_name FROM travel_state ts JOIN states s ON ts.state_id = s.id WHERE ts.user_id = :user_id";
		self::$db->query($sql, array('user_id' => $user_id));
		if ($state = self::$db->fetch('obj')) {
			return $state;
		}
	}
}