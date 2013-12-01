<?php

require (dirname(__FILE__).'/db.php');
require "./phpmailer/class.phpmailer.php";
require "./phpmailer/class.smtp.php";
require "./phpmailer/class.pop3.php";

$settings = parse_ini_file(dirname(__FILE__).'/settings/config.ini', true);

$smtp = $settings['smtp-server']['smtp'];
$smtp_user = $settings['smtp-server']['user'];
$smtp_pass = $settings['smtp-server']['password'];
$smtp_port = $settings['smtp-server']['port'];

$db = new DBConnect();

$uname = $_POST['username'];
$pwd = $_POST['password'];
$email = $_POST['email'];

$response = array();

if ($db->findUser($uname) || $db->findEmail($email)) {
	$response['success'] = 'error';
	echo json_encode($response);
} else {
	$activation = md5(uniqid(rand(), true));

	$message = "Welcome $uname\n\n";
	$message .= "You have registered at IMConnect Web. You are just a step away from enjoying IMConnect Web.\n\n";
	$message .= " To activate your account, please click on this link:\n\n";
    $message .= $settings['web-server']['address'] . '/activate.php?email=' . urlencode($email) . "&key=$activation";
    $message .= "\n\nRegards,\n Shivam, IMConnect Web";

	$mail = new PHPmailer();
	$mail->IsSMTP();
	$mail->SMTPAuth   = true;
	$mail->SMTPSecure = "ssl"; 
	$mail->From 	  = "activation@imconnectweb.com";
	$mail->FromName   = "Activation IMConnect Web";
	$mail->Host       = $smtp;
	$mail->Mailer     = "smtp";
	$mail->Port       = $smtp_port;
	$mail->Password   = $smtp_pass;
	$mail->Username   = $smtp_user;
	$mail->Subject    = "Activate account at IMConnect Web";
	$mail->SMTPAuth   =  "true";
	$mail->Body 	  = $message;
	$mail->IsHTML(true);
	$mail->AddAddress($email, $email);

	if($mail->Send()) {

		if ($db->addUser($uname, $email, $pwd, $activation)) {
			$response['success'] = 'true';
			echo json_encode($response);
		} else {
			$response['success'] = 'false';
			echo json_encode($response);
		}
	} else {
		$response['success'] = 'false';
		echo json_encode($response);
	}
}

$db->closeConnection();

?>