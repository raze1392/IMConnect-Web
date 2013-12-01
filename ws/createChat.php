<?php

require (dirname(__FILE__).'/db.php');
session_start();

if(!isset($_SESSION['username'])){
    echo 'Fail';
} else {
	$db = new DBConnect();

	$result = array();
	$result['success'] = 'true';

	$thread = $db->findThread($_SESSION['username'], $_GET['participants'], $_GET['userlist']);
	if ($thread != null) {
		$result['new'] = 'false';
		$result['thread'] = $thread;
	} else {
		$msg = '/msgs/'.$_GET['thread'].'.msg';
		$handle = fopen(dirname(__FILE__).'/..'.$msg, 'w') or die($php_errormsg);
		fwrite($handle, "#".$_GET['thread']."\n");
		fclose($handle);

		$userlist = $_GET['userlist']."::".$_SESSION['username'];

		if ($db->createThread($_GET['thread'], $_GET['participants'], $msg, $userlist)) {
			$result['new'] = 'true';
			$result['thread'] = $_GET['thread'];
		} else {
			$result['success'] = 'false';
		}
		
	}
	
	$db->closeConnection();
	echo json_encode($result);
}

?>