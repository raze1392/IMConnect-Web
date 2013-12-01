<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6 lt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7 lt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8 lt8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<?php
require ('./ws/DB.php');
$db = new DBConnect();

if (isset($_GET['email']) && preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $_GET['email'])) {
    $email = $_GET['email'];
}

if (isset($_GET['key']) && (strlen($_GET['key']) == 32)) {
    $key = $_GET['key'];
}

?>
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>Web Messaging</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
		
		<script type="text/javascript" src="scripts/jquery-1.9.0.js"></script>
    </head>
    <body>
        <div class="container">
            <header>
                <h1>Welcome to <span>IMConnect Web</span></h1>
            </header>
            <section>				
                <div id="container" >
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <h1> User Activation </h1>
                            <?php
                                if (isset($email) && isset($key)) {
    							 
    							    if ($db->updateUserActivation($email, $key)) {
    							    	echo '<p style="text-align: center">Your account is now active. You may now login </p><p style="text-align: center"> <a href="./index.php" class="button" style="color: #fff; margin-left: 10px;">Log in</a></p>';
    							    } else {
    							    	
    							        echo '<p style="color: red text-align: center">Oops !Your account could not be activated. Please recheck the link or contact the system administrator.</p>';
    							    }

    							    $db->closeConnection();

    							} else {
                                        echo '<p style="color: red; text-align: center">An Error Occurred</p>';
    							}
							?>
                        </div>
                    </div>
                </div>  
            </section>
        </div>
    </body>
</html>
</head>
<body>