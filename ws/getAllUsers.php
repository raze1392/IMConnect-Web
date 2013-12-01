<?php

require (dirname(__FILE__).'/db.php');
session_start();

if(!isset($_SESSION['username'])){
    echo 'Fail';
} else {
	$db = new DBConnect();
	$result = array();
	$result['success'] = 'true';
	$result['users'] = $db->getAllUsers($_SESSION['username']);
	$db->closeConnection();
	echo json_encode($result);
}

?>