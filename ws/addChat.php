<?php

require (dirname(__FILE__).'/db.php');
session_start();

if(!isset($_SESSION['username'])){
    echo 'Fail';
} else {
	$db = new DBConnect();

	$result = array();
	$result['success'] = 'true';

	$thread = $db->getThread($_GET["thread"]);
	$handle = null;

	if (file_exists(dirname(__FILE__).'/..'.$thread['messages'])) {
		$handle = fopen(dirname(__FILE__).'/..'.$thread['messages'], 'a') or die($php_errormsg);
	}

	$line = $_SESSION['username'] . "::" . $_GET['time'] . "::" . $_GET['message'];
	fwrite($handle, $line."\n");
	fclose($handle);
	
	$db->closeConnection();
	echo json_encode($result);
}

?>