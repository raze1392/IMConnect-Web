<?php
	ob_start();
	session_start();
	if(isset($_SESSION['username'])){
	    header("Location: chat.php");
	} 
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6 lt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7 lt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8 lt8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
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
		<script type="text/javascript" src="scripts/userprocess.js"></script>
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
                            <form  action="./ws/login.php" autocomplete="on" method="POST"> 
                                <h1>Log in</h1>
                                <?php
                                	if (isset($_GET['e'])) {
                                		$x = $_GET['e'];
                                		if ($x == 0) {
                                			echo '<p style="color:red; font-size: 13px">No user with this username</p>';
                                		} else if ($x == 1) {
                                			echo '<p style="color:red; font-size: 13px">Your account is not activated</p>';
                                		} else if ($x == 2) {
                                			echo '<p style="color:red; font-size: 13px">Username password do not match</p>';
                                		} 
                                	}
                                ?> 
                                <p> 
                                    <label for="username" class="uname" data-icon="u" > Username</label>
                                    <input id="username" name="username" required="required" type="text" placeholder="Enter your username"/>
                                </p>
                                <p> 
                                    <label for="password" class="youpasswd" data-icon="p"> Password </label>
                                    <input id="password" name="password" required="required" type="password" placeholder="Enter your password" /> 
                                </p>
                                <p class="keeplogin"> 
									<input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" /> 
									<label for="loginkeeping">Keep me logged in</label>
								</p>
                                <p class="login button"> 
                                    <input type="submit" value="Login" /> 
								</p>
                                <p class="change_link">
									Not a member yet ?
									<a href="#toregister" class="to_register">Sign Up</a>
								</p>
                            </form>
                        </div>

                        <div id="register" class="animate form">
                            <form autocomplete="on"> 
                                <h1> Sign up </h1> 
                                <p id="err" style="color: red; font-size: 14px"></p>
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="u">Your username</label>
                                    <input id="usernamesignup" name="usernamesignup" required="required" type="text" placeholder="Enter Username" />
                                </p>
                                <p> 
                                    <label for="emailsignup" class="youmail" data-icon="e" > Your email</label>
                                    <input id="emailsignup" name="emailsignup" required="required" type="email" placeholder="Enter Email"/> 
                                </p>
                                <p> 
                                    <label for="passwordsignup" class="youpasswd" data-icon="p">Your password </label>
                                    <input id="passwordsignup" name="passwordsignup" required="required" type="password" placeholder="Enter password"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
                                    <input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required" type="password" placeholder="Confirm you password"/>
                                </p>
                                <p class="signin button"> 
									<input type="button" id="register-btn" onclick="addUser(); return true;" value="Sign up"/> 
								</p>
                                <p class="change_link">  
									Already a member ?
									<a href="#tologin" class="to_register"> Log in </a>
								</p>
                            </form>
                        </div>
						
                    </div>
                </div>  
            </section>
        </div>
    </body>
</html>