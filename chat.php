<?php
	ob_start();
	session_start();
	if(!isset($_SESSION['username'])){
	    header("Location: index.php");
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
                <h1><span><?php echo $_SESSION['username'] ?></span>, Welcome to <span>IMConnect Web</span></h1>
            </header>
            <section>				
                <div id="container" >
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper" class="wrapper-chat">
                    	<div class="form" id="users" onload="getAllUsers();">
                            <h1 style="font-size: 24px; padding-bottom: 15px;">Users</h1> 
                            <div id="userselectwindow">
                                <p class=""> 
                                    <label for="chatwith" class="uname unamechat" >&nbsp;</label>
                                </p>
                                <p class=""> 
                                    <label for="chatwith" class="uname unamechat" > Loading... <img src="./images/ajax-loader.gif"></label>
                                </p>
                                <p class=""> 
                                    <label for="chatwith" class="uname unamechat" >&nbsp;</label>
                                </p>
                            </div>
                            <p class="button" style="text-align: center">
                                <button onclick="javascript: startChat();">Chat!</button>
							</p>
                        </div>

                        <script type="text/javascript">getAllUsers();</script>
                        
                        <div class="form" id="chatwindow">
                            <h1>ConnectBox</h1>
                            <div id="chatlightbox">
                                <div class="chatlight" id="onLoad">
                                    <h1 style="padding-bottom: 10px;">It's chatting time!</h1>
                                    <p style="color: #36aeea; font-size: 18px">Select a previous conversation to begin with</p>
                                    <p style="color: #111;">OR</p>
                                    <p style="color: #e0448b; font-size: 18px">Select Users and hit CHAT to start Chatting</p>
                                </div>
                                <div class="chatlight" id="onNewChat" style="display: none">
                                    <h1 style="padding-bottom: 10px;">Just a few moments!</h1>
                                    <p style="color: #36aeea; font-size: 18px">We are setting up the chat...</p>
                                    <p style="color: #111;"><img src="./images/ajax-loader.gif"></p>
                                    <p style="color: #e0448b; font-size: 18px">:)</p>
                                </div>
                            </div>
                            <div id="connectbox">
                                <li>
                                    <p class="userchat-other userchat"> 
                                        Hello buddy :) <span class="from">Vivek</span>
                                    </p>
                                    <span class="userchat-other colon"></span>
                                </li>
                                <li>
                                    <span class="userchat-me colon"></span>
                                    <p class="userchat-me userchat"> 
                                        Hey! Is everyone here? <span class="from">Me</span>
                                    </p>
                                </li>
                                <li>
                                    <p class="userchat-other userchat"> 
                                        I am ;) <span class="from">Rachit</span>
                                    </p>
                                    <span class="userchat-other colon"></span>
                                </li>
                                <li>
                                    <p class="userchat-other userchat"> 
                                        How can you forget me <span class="from">Shivank</span>
                                    </p>
                                    <span class="userchat-other colon"></span>
                                </li>
                                 <li>
                                    <p class="userchat-other userchat"> 
                                        Me 2 <span class="from">Vineet</span>
                                    </p>
                                    <span class="userchat-other colon"></span>
                                </li>
                                 <li>
                                    <p class="userchat-other userchat"> 
                                        I am always here :D <span class="from">Ranjeet</span>
                                    </p>
                                    <span class="userchat-other colon"></span>
                                </li>
                                <li>
                                    <span class="userchat-me colon"></span>
                                    <p class="userchat-me userchat"> 
                                        That's great guys! <span class="from">Me</span>
                                    </p>
                                </li>
                            </div> 
                            
                            <div id="connecttypebox">
                                <p> 
                                    <input id="connectmsg" name="username" required="required" type="text" placeholder="Type a message to send"/>
                                    <button id="connectmsgsend" onclick="javascript: addChatMessage();">Send</button>
                                </p>
                            </div>

                            <div id="connectmessages">
                                <h1 style="font-size: 20px; padding-bottom: 10px;">Messages</h1>
                                <div id="messageselectwindow">
                                    <p class="">&nbsp;</p>
                                    <p class="" style="float: right; margin-right: 25px;"> Loading <img src="./images/ajax-loader.gif"></p>
                                    <!--
                                    <p class="message">Message1</p>
                                    <p class="message selected">Message1</p>
                                    <p class="message">Message1</p>
                                    -->
                                </div> 
                            </div>
                            <script type="text/javascript">getAllChats();</script>

                            <div id="logout-div">
                                <p><a href="./ws/logout.php" class="button" style="color: #fff"> Log Out </a></p>
                            </div>
                        </div>
                    </div>
                </div>  
            </section>
        </div>
    </body>
</html>
