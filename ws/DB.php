<?php

class  DBConnect {
	private $con;

	public function __construct() {
		$settings = parse_ini_file(dirname(__FILE__).'/settings/config.ini', true);
		$db = mysqli_connect($settings['db-server']['hostname'], $settings['db-server']['username'], $settings['db-server']['password'], $settings['db-server']['databasename']) or die("Unable to connect to MySQL") ;
		$this->con = $db;
	}

	public function addUser($uname, $email, $pwd, $activation) {
		return mysqli_query($this->con, "INSERT into users (`username`, `email`, `password`, `activated`, `activationkey`) VALUES ('".$uname."', '".$email."', '".$pwd."', 0, '".$activation."')");
	}

	public function updateUserActivation($email, $activation) {
		mysqli_query($this->con, "UPDATE users SET Activation=NULL WHERE(email = '".$email."'' AND activationkey = '".$activation."'') LIMIT 1");
		if (mysqli_affected_rows($this->con) == 1) {
			return true;
		} else {
			return false;	
		}
	}

	public function findUser($uname) {
		$result = mysqli_query($this->con, "SELECT * from users WHERE username = '".$uname."'");
		if (@mysqli_num_rows($result) == 1) {
			return true;
		} else {
			return false;	
		}
	}

	public function findEmail($email) {
		$result = mysqli_query($this->con, "SELECT * from users WHERE email = '".$email."'");
		if (@mysqli_num_rows($result) == 1) {
			return true;
		} else {
			return false;	
		}
	}

	public function isUserActivated($uname) {
		$result = mysqli_query($this->con, "SELECT * from users WHERE username = '".$uname."'");
		if (@mysqli_num_rows($result) == 1) {
			$arr = mysqli_fetch_array($result, MYSQLI_ASSOC);
			if ($arr['activated'] == 1)
				return true;
			else
				return false;
		} else {
			return false;	
		}	
	}

	public function getUserInfo($uname, $pwd) {
		$result = mysqli_query($this->con, "SELECT * from users WHERE username = '".$uname."' AND password = '".$pwd."'");
		if (@mysqli_num_rows($result) == 1) {
			return mysqli_fetch_array($result, MYSQLI_ASSOC);
		} else {
			return null;	
		}
	}

	public function getAllUsers($uname) {
		$result = mysqli_query($this->con, "SELECT * from users where activated = 1 AND username <> '".$uname."'");
		$userlist = array();
		while ( $user = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
			array_push($userlist, $user['username']);
		}
		return json_encode($userlist);
	}

	/**
		THREADS RELATED QUERIES
	*/

	public function getAllThreads($uname) {
		$result = mysqli_query($this->con, "SELECT * from participants where username = '".$uname."'");
		$threadlist = array();
		while ( $thread = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
			$temp = array('thread' => $thread['thread'], 'participants' => $thread['participants']);
			array_push($threadlist, $temp);
		}
		return json_encode($threadlist);
	}

	public function getThread($thread) {
		$result = mysqli_query($this->con, "SELECT * from threads where thread = '".$thread."'");
		if (@mysqli_num_rows($result) == 1) {
			return mysqli_fetch_array($result, MYSQLI_ASSOC);
		} else {
			return null;	
		}
	}

	public function findThread($uname, $participants, $users) {
		$result = mysqli_query($this->con, "SELECT * from participants where username = '".$uname."' AND participants = '".$participants."'");
		if (@mysqli_num_rows($result) < 1) {
			return null;
		} else {
			$userlist = explode("::", $users);

			while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
				$isThread = true;
				$thread = $row['thread'];
				
				for ($i=count($userlist)-1; $i >= 0; $i--) { 
					$res = mysqli_query($this->con, "SELECT * from participants where username = '".$userlist[$i]."' AND thread = '".$thread."' AND participants = '".$participants."'");
					if (@mysqli_num_rows($result) == 1) {
						continue;
					} else {
						$isThread = false;
						break;
					}
				}

				if ($isThread)
					return $thread;
			}
			return null;
		}
	}

	public function createThread($thread, $participants, $message, $users) {
		if (mysqli_query($this->con, "INSERT into threads (`thread`, `participants`, `messages`, `updated`) VALUES ('".$thread."', ".$participants.", '".$message."', 1)")) {
			$userlist = explode("::", $users);
			for ($i=count($userlist)-1; $i >= 0; $i--) { 
				if (mysqli_query($this->con, "INSERT into participants (`username`, `thread`, `participants`) VALUES ('".$userlist[$i]."', '".$thread."', ".$participants.")"))
					continue;
				else
					return 0;
			}
			return 1;
		} else {
			return 0;
		}
	}	

	public function closeConnection() {
		mysqli_close($this->con);
	}
}

?>