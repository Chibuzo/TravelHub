<?php
require_once "travel.class.php";

class User extends Travel {

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

    function createTravelAdmin($fullname, $username, $password, $travel_id)
    {
        self::$db->beginDbTransaction();
        $user_id = $this->createUser($fullname, $username, $password, 'travel_admin');
        if ($user_id != false) {
            $this->linkUserToTravel($travel_id, $user_id);
            self::$db->commitTransaction();
        } else {
            self::$db->rollBackTransaction();
        }
    }

    function createStateAdmin($fullname, $username, $password, $travel_id, $state_id)
    {
        self::$db->beginDbTransaction();
        $user_id = $this->createUser($fullname, $username, $password, 'state_admin');
        if ($user_id !== false) {
            if (($this->linkUserToTravel($travel_id, $user_id) !== false) && ($this->addTravelState($travel_id, $state_id, $user_id) !== false)) {
                self::$db->commitTransaction();
                return true;
            } else {
                //TODO: roll-back isn't working!!!
                self::$db->rollBackTransaction();
                return false;
            }
        }
    }

    function createParkAdmin($fullname, $username, $password, $travel_id, $park_id)
    {
        self::$db->beginDbTransaction();
        $user_id = $this->createUser($fullname, $username, $password, 'park_admin');
        if ($user_id !== false) {
            if (($this->linkUserToTravel($travel_id, $user_id) !== false) && ($this->addTravelPark($travel_id, $park_id, $user_id) !== false)) {
                self::$db->commitTransaction();
                return true;
            } else {
                //TODO: roll-back isn't working!!!
                self::$db->rollBackTransaction();
                return false;
            }
        }
    }

	function login($username, $password)
	{
		if (!isset($username, $password)) {
			return "01"; // Empty username or password field
		}

		$sql = "SELECT salt FROM users WHERE username = :username AND deleted = '0'";
        self::$db->query($sql, array('username' => $username));
		$obj = self::$db->fetch("obj");
		if (!isset($obj->salt)) {
			return "02"; // User not found
		}

		$salt = $obj->salt;
		$password = hash('sha256', $password . $salt);
		$param = array('username' => $username, 'password' => $password);

		$sql = "SELECT username, id, user_type FROM users WHERE username = :username AND password = :password";

        self::$db->query($sql, $param);
		$obj = self::$db->fetch("obj");
		if (isset($obj->id)) {
			$_SESSION['user_type'] = $obj->user_type;
			$_SESSION['username'] = $obj->username;
			$_SESSION['user_id']     = $obj->id;
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


	public function changePassword($old_pswd, $new_pswd, $id) {
		$sql = "SELECT salt, password FROM users WHERE id = :id";
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
		$sql = "UPDATE users SET password = :password WHERE id = :id";

		$param = array(
			'password' => $new_password,
			'id'       => $id
		);

		if (self::$db->query($sql, $param)) {
			return true;
		}
	}


	public function delete($tbl, $id)
	{
		if (self::$db->query("UPDATE users SET deleted = '1' WHERE id = :id", array('id' => $id))) {
			return true;
		}
	}


	function getUserById($id)
	{
		self::$db->query("SELECT * FROM users WHERE id = :id AND deleted = '0'", array('id' => $id));
        return self::$db->fetch('obj');
	}


	function getAllUsers()
	{
		return self::$db->query("SELECT * FROM users WHERE deleted = '0' ORDER BY date_created");
	}

    function linkUserToTravel($travel_id, $user_id)
    {
        return self::$db->query("INSERT INTO travel_admins (travel_id, user_id) VALUES (:travel_id, :user_id)", array('travel_id' => $travel_id, 'user_id' => $user_id));
    }

    function getUserByTravel($travel_id)
    {
        $sql = "SELECT users.* FROM users INNER JOIN travel_admins ON users.id = travel_admins.user_id WHERE travel_admins.travel_id = :travel_id";
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

    function addTravelPark($travel_id, $park_id, $user_id)
    {
        try {
            $sql = "INSERT INTO travel_park (travel_id, park_id, user_id) VALUES (:travel_id, :park_id, :user_id)";
            $result = self::$db->query($sql, array('travel_id' => $travel_id, 'park_id' => $park_id, 'user_id' => $user_id));
            if ($result !== false) {
                $params['id'] = self::$db->getLastInsertId();
                return $params;
            }
            return false;
        } catch (\PDOException $e) {
            return false;
        }
    }
}
?>
