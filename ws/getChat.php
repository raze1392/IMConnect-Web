<?php

require (dirname(__FILE__).'/db.php');
session_start();

if(!isset($_SESSION['username'])){
    
    echo 'Fail';

} else {
	
	$db = new DBConnect();
	$result = array();
	$result['success'] = 'true';

	if ($_GET['type'] == "ID") {
		
		$result['threads'] = $db->getAllThreads($_SESSION["username"]);	

	} else if ($_GET['type'] == "CHAT") {
		
		$thread = $db->getThread($_GET["thread"]);
		$handle = null;
		if (file_exists(dirname(__FILE__).'/..'.$thread['messages'])) {
			$handle = file(dirname(__FILE__).'/..'.$thread['messages']);
		}

		$msgs = array();
		foreach ($handle as $line) {
			if (substr($line, 0, 1) == "#") {
				continue;
			} else {
				$array = explode("::", $line);
				if ($array[0] == $_SESSION['username'])
					$array[0] = "me";
				$temp = array('from' => $array[0], 'time' => $array[1], 'message' => $array[2]);
				array_push($msgs, $temp);
			}
		}
		$result['messages'] = $msgs;

	}
	
	$db->closeConnection();
	echo json_encode($result);
}

?>