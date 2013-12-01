var openedThread = null;

function addUser() {
	if ($('#passwordsignup').val() != $('#passwordsignup_confirm').val()) {
		$("#err").text("Passwords do not match");
	}
	$.ajax({
		type: "POST",
		url: "./ws/register.php",
		data: { username: $('#usernamesignup').val(), email: $('#emailsignup').val(), password: $('#passwordsignup').val()}
	}).done(function( msg ) {
		msg = JSON.parse(msg);
		if (msg.success == 'true')
			$("#register").html("<h1> Registered </h1><p>Please Check your mail to activate</p>");
		else if (msg.success == 'error')
			$("#err").html("Username and Password Exist");
		else
			$("#err").html("<h1> Registration Error </h1><p>Try Again Later</p>");
	});
};

function getAllUsers() {
	$.ajax({
		type: "POST",
		url: "./ws/getAllUsers.php"
	}).done(function( msg ) {
		msg = JSON.parse(msg);
		if (msg.success == 'true') {
			var userhtml = "";
			var users = JSON.parse(msg.users);

			if (users.length == 0) {
				userhtml += '<p class="userchatselect"><label for="chatwith" class="uname unamechat" >&nbsp;</label></p><p class="userchatselect"><label for="chatwith" class="uname unamechat" >No other User Registered yet T-T</label></p><p class="userchatselect"><label for="chatwith" class="uname unamechat" >&nbsp;</label></p>';
			} else {
				for (var i = users.length - 1; i >= 0; i--) {
					userhtml += '<p class="userchatselect"><input type="checkbox" name="chatwith" value="'+users[i]+'"/><label for="chatwith" class="uname unamechat" data-iconc="u" > '+users[i]+' </label></p>';
				}	
			}
			$("#userselectwindow").html(userhtml);
		} else {
			$("#userselectwindow").html("We have encountered a problem :(");
		}
	});
};

function addMessageClickHandler() {
	$('#messageselectwindow p.message').on('click', function(evt) {
		$('#messageselectwindow p.message.selected').removeClass('selected');
		$(this).addClass('selected');
		init();
		openedThread = $(this).data('thread');
		loadChat($(this).data('thread'));
	});
};

function loadChat(thread) {
	$.ajax({
		type: "GET",
		url: "./ws/getChat.php?type=CHAT&thread=" + thread
	}).done(function( msg ) {
		msg = JSON.parse(msg);
		if (msg.success == 'true') {
			$('#connectbox').html('');
			for (var i = msg.messages.length-1; i >= 0; i--) {
				if (msg.messages[i].from == "me") {
					$('#connectbox').prepend('<li><span class="userchat-me colon"></span><p class="userchat-me userchat">'+msg.messages[i].message+'<span class="from">'+msg.messages[i].from+'</span></p></li>');
				} else {
					$('#connectbox').prepend('<li><p class="userchat-other userchat">'+msg.messages[i].message+'<span class="from">'+msg.messages[i].from+'</span></p><span class="userchat-other colon"></span></li>');
				}
			};
		}
	});
}

function getAllChats() {
	$.ajax({
		type: "GET",
		url: "./ws/getChat.php?type=ID"
	}).done(function( msg ) {
		msg = JSON.parse(msg);
		if (msg.success == 'true') {
			var threadhtml = "";
			var threads = JSON.parse(msg.threads);

			if (threads.length == 0) {
				threadhtml += "<p class='message garbage'>There are no Conversations.</p><p class='message selected'>Start one now</p>";
			} else {
				for (var i = threads.length - 1; i >= 0 ; i--) {
					threadhtml += '<p class="message" data-thread="'+threads[i].thread+'"> Conversation '+i+'</p>';
				}	
			}
			
			$("#messageselectwindow").html(threadhtml);
			addMessageClickHandler();
		} else {
			$("#messageselectwindow").html("We have encountered a problem :(");
		}
	});
};

function startChat() {
	var users = document.getElementsByName('chatwith');
	var selectedusers = [];
	
	$('#onLoad').hide();
	$('#onNewChat').show();
	$('#chatlightbox').slideDown(500);

	for (var i = users.length - 1; i >= 0; i--) {
		if (users[i].checked) {
			selectedusers.push(users[i].value);
		}
	}

	$.ajax({
		type: "GET",
		url: "./ws/createChat.php?userlist=" + selectedusers.join('::') + "&participants=" + (selectedusers.length+1) + "&thread=" + new Date().getTime()
	}).done(function( msg ) {
		msg = JSON.parse(msg);
		if (msg.success == 'true') {
			init();
			if (msg.new == 'false') {
				selectThread(msg.thread);
			} else {
				var html = $("#messageselectwindow").html();
				if ($("#messageselectwindow p.garbage")) 
					html = "";
				html = '<p class="message" data-thread="'+msg.thread+'"> Conversation #</p>' + html;
				$("#messageselectwindow").html(html);
				addMessageClickHandler();
				selectThread(msg.thread);
			}
		}
	});
};

function selectThread(thread) {
	$('#messageselectwindow p.message').each(function() {
		if ($(this).data('thread') == thread) {
			$(this).click();
		}
	});
};

setInterval (function() {
	//if (window.openedThread != null)
		//loadChat(window.openedThread);
}, 1000);

function addChatMessage() {
	var message = document.getElementById('connectmsg').value;
	$.ajax({
		type: "GET",
		url: "./ws/addChat.php?message="+message+"&thread="+window.openedThread+"&time="+new Date().getTime()
	}).done(function( msg ) {
		msg = JSON.parse(msg);
		if (msg.success == 'true') {
			$('#connectbox').append('<li><span class="userchat-me colon"></span><p class="userchat-me userchat">'+message+'<span class="from">me</span></p></li>');
		} 
	});
}

function init() {
	$('#onLoad').hide();
	$('#onNewChat').hide();
	$('#chatlightbox').slideUp(500);
	$('#connectmsg').html();
}

