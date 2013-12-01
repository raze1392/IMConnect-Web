<?php

require (dirname(__FILE__).'/db.php');
  
session_start();
$db = new DBConnect();

$uname = $_POST['username'];
$pwd = $_POST['password'];

if ($db->findUser($uname)) {
  if ($db->isUserActivated($uname)) {
    $user = $db->getUserInfo($uname, $pwd);
    if ($user == null) {
      $db->closeConnection();
      header("Location: ../index.php?e=2");
    } else {
      $_SESSION = $user;
      $db->closeConnection();
      header("Location: ../chat.php");
    }
  } else {
    $db->closeConnection();
    header("Location: ../index.php?e=1");
  }
} else {
  $db->closeConnection();
  header("Location: ../index.php?e=0");
}
      
?>

