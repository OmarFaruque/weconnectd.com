<?php require("static/config.inc.php"); ?>
<?php require("static/conn.php"); ?>
<?php require("lib/profile.php"); ?>
<?php require("includes/dbconn.php"); ?>
<?php
if(isset($_SESSION['siteusername']) AND isset($_GET['channel']) AND isset($_GET['receiver'])){
	$cr = $dbconn->query("SELECT * FROM users WHERE username='".$_GET['receiver']."'");
	if($cr->num_rows == 1){
	  if($_SESSION['siteusername'] !== $_GET['receiver']){
		  $ch_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='".$_GET['receiver']."' AND channel='".$_GET['channel']."'");
		  if($ch_emp->num_rows > 0){
			  $ch_emp_d = $ch_emp->fetch_array();
			 $ch_sender = $ch_emp_d['sender'];
			  if($ch_sender == $_SESSION['siteusername']){
				  $chanel_empty = TRUE;
			  } else {
				   $chanel_empty = FALSE;
			  }
		  } else {
			   $chanel_empty = TRUE;
		  }
	  } else {
		   $chanel_empty = TRUE;
	  }
?>
<?php if($chanel_empty == TRUE){ ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $config['pr_title']; ?></title>
        <link rel="stylesheet" href="/static/css/required.css"> 
        <script src='https://www.google.com/recaptcha/api.js' async defer></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
        <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
        <script src="/onLogin.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <style>
//-----GLOBAL
* {
  box-sizing: border-box;
}

.clearfix:after, .messages:after {
  content: "";
  display: table;
  clear: both;
  height: 0;
  visibility: hidden;
}

body {
  background-color: #ddd;
}

.screen {
  background-color: #fff;
  height: 100%;
  width: 100%;
  margin: 0 auto;
  box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);
}

.conversation {
  height: calc(100% - 50px);
  overflow: auto;
  padding: 20px;
  padding-bottom: 0;
  min-height: 500px;
}

.messages {
  margin-bottom: 10px;
}
.messages--received .message {
  float: left;
  background-color: #ddd;
  border-bottom-left-radius: 5px;
  border-top-left-radius: 5px;
}
.messages--received .message:first-child {
  border-top-left-radius: 15px;
}
.messages--received .message:last-child {
  border-bottom-left-radius: 15px;
}
.messages--sent .message {
  float: right;
  background-color: #ffa726;
  color: #fff;
  border-bottom-right-radius: 5px;
  border-top-right-radius: 5px;
}
.messages--sent .message:first-child {
  border-top-right-radius: 15px;
}
.messages--sent .message:last-child {
  border-bottom-right-radius: 15px;
}

.message {
  display: inline-block;
  margin-bottom: 2px;
  clear: both;
  padding: 7px 13px;
  font-size: 12px;
  border-radius: 15px;
  line-height: 1.4;
}
.message--thumb {
  background-color: transparent !important;
  padding: 0;
  margin-top: 5px;
  margin-bottom: 10px;
  width: 20px;
  height: 20px;
  border-radius: 0px !important;
}

.text-bar {
  height: 50px;
  border-top: 1px solid #ccc;
}
.text-bar__field {
  width: calc(100%);
  height: 100%;
  display: flex;
}
.text-bar__field input {
  width: calc(100% - 150px);
  height: 100%;
  padding: 0 20px;
  border: none;
  position: relative;
  vertical-align: middle;
  font-size: 14px;
}
.text-bar__thumb {
  float: left;
  width: 50px;
  height: 100%;
  padding: 10px;
}
.text-bar__thumb:hover {
  opacity: 0.8;
}
.text-bar__thumb .thumb {
  width: 100%;
  height: 100%;
  cursor: pointer;
}

.thumb {
  display: block;
}

.anim-wiggle {
  -webkit-animation: wiggle 0.2s ease infinite;
          animation: wiggle 0.2s ease infinite;
}

.anim-wiggle-2 {
  -webkit-animation: wiggle2 0.2s ease infinite;
          animation: wiggle2 0.2s ease infinite;
}

@-webkit-keyframes wiggle {
  0% {
    transform: rotateZ(5deg);
  }
  50% {
    transform: rotateZ(-5deg);
  }
  100% {
    transform: rotateZ(5deg);
  }
}

@keyframes wiggle {
  0% {
    transform: rotateZ(5deg);
  }
  50% {
    transform: rotateZ(-5deg);
  }
  100% {
    transform: rotateZ(5deg);
  }
}
@-webkit-keyframes wiggle2 {
  0% {
    transform: rotateZ(10deg);
  }
  50% {
    transform: rotateZ(-10deg);
  }
  100% {
    transform: rotateZ(10deg);
  }
}
@keyframes wiggle2 {
  0% {
    transform: rotateZ(10deg);
  }
  50% {
    transform: rotateZ(-10deg);
  }
  100% {
    transform: rotateZ(10deg);
  }
.messages--sent .message img{
	max-width: 300px;
}
        </style>
        <?php $reciever = $_GET['receiver'];
			  $channel = $_GET['channel']; ?>
    </head>
    <body>
        <div class="container">
            <?php require("static/header.php"); ?>
            <br>
<div class="screen">
	<div class="conversation" id="chat-box">
		
	</div>
	<style>
.send-image input {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
}
.send-image img{
	width: 30px;
	height: 30px;
	margin: 10px 0px
		}
		.send-button button{
			margin: 10px;
    background: #ffa726;
    color: #fff;
    border: 1px solid #ffa726;
    padding: 5px 10px;
		}
	</style>
	<div class="text-bar">
		<form class="text-bar__field" id="form-message">
			<input type="text" placeholder="Write your message..." name="" id="ghost_message">
			<div class="send-image">
				<input type="file" name="image" id="sendimage">
				<label for="sendimage"><img src="images/image-gallery.png"></label>
			</div>
			<div class="send-button">
				<button type="submit" id="send" name="send">Send</button>
			</div>
		</form>
	</div>
</div>

        </div>
        <br>
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/footer.php"); ?>
    </body>
	<script>
		"use strict";

//elements
var conversation = $('.conversation');
var lastSentMessages = $('.messages--sent:last-child');
var textbar = $('.text-bar__field input');
var textForm = $('#form-message');
var thumber = $('.text-bar__thumb');

var scrollTop = $(window).scrollTop();

var Message = {
	currentText: "test",
	init: function(){
		var base = this;
		base.send();
	},
	send: function(){
		var base = this;
		textForm.submit(function( event ) {
		  	event.preventDefault();
			base.createGroup();
			base.saveText();
			if(base.currentText != ''){
				base.createMessage();
				base.scrollDown();
			}
		});
	},
	saveText: function(){
		var base = this;
		base.currentText = textbar.val();
		textbar.val('');
	},
	createGroup: function(){
		if($('.messages:last-child').hasClass('messages--received')){
			conversation.append($('<div/>')
							.addClass('messages messages--sent'));
			lastSentMessages = $('.messages--sent:last-child');
		}
	},
	scrollDown: function(){
		var base = this;
		//conversation.scrollTop(conversation[0].scrollHeight);
		conversation.stop().animate({
			scrollTop: conversation[0].scrollHeight
		}, 500);
	}
};

var newMessage = Object.create(Message);
newMessage.init();

	</script>
<script>
    document.getElementById('send').addEventListener('click', function(){
        const ghost_message = document.getElementById('ghost_message').value;
		const send_image = document.getElementsByName('image')[0].files[0];
        const formData = new FormData();
        formData.append('ghost_message', ghost_message);
        formData.append('sender', '<?php echo $_SESSION['siteusername']; ?>');
        formData.append('reciever', '<?php echo $reciever; ?>');
		formData.append('channel', '<?php echo $channel; ?>');
		formData.append('sendimage', send_image);
            
        fetch('https://weconnectd.com/fetch/ghost_chat.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
          if(result.status == "succuss"){
            const commentbox = document.getElementById('chat-box');
            document.getElementById('ghost_message').value = '';  
   
			var newDiv = document.createElement("div");
            newDiv.setAttribute("class", "messages messages--sent");
			if(result.file !== ''){
			    var sentimage = `<div class="image"><img src="https://weconnectd.com/chat_images/${result.file}"></div>`;
			} else {
				var sentimage = '';
			}
				
            const restDiv = `
                <div class="message">
                   ${result.message}
                   ${sentimage}
	            </div>
            `;
            newDiv.innerHTML = restDiv;
            commentbox.appendChild(newDiv);
			
          } else{
            console.log(result.error);
          }
        })
    })
function message(result){
    const commentbox = document.getElementById('chat-box');
    var tRows = result.length;
    if(tRows > 0){
        for (let i = 0; i < tRows; i++) {
			var newDiv = document.createElement("div");
            newDiv.setAttribute("class", "messages messages--received");
			newDiv.setAttribute("id", result[i].id);
			if(result[i].file !== ''){
			    var sentimage = `<div class="image"><img style="max-width:300px;" src="https://weconnectd.com/chat_images/${result[i].file}"></div>`;
			} else {
				var sentimage = '';
			}
            const restDiv = `
                <div class="message">
                     ${result[i].message}
                     ${sentimage}
	            </div>
            `;
			newDiv.innerHTML = restDiv;
			
            commentbox.appendChild(newDiv);
        }
    }
}
function delete_message(result){
    var dRows = result.length;
    if(dRows > 0){
        for (let i = 0; i < dRows; i++) {
			var chatid = result[i].id;
			    const element = document.getElementById(`${result[i].id}`);
			    console.log(`${result[i].id}`);
                element.remove();
        }
    }
}	
   setInterval(function () { 
	    const formData1 = new FormData();
        formData1.append('reciever', '<?php echo $reciever; ?>');
	    formData1.append('channel', '<?php echo $channel; ?>');
            
        fetch('https://weconnectd.com/fetch/get_ghost_chat.php', {
            method: 'POST',
            body: formData1
        })
        .then(response => response.json())
        .then(result => {
		  if(result.status == "succuss"){
            message(result.data);
          }
		})
		fetch('https://weconnectd.com/fetch/delete_ghost_chat.php', {
            method: 'POST',
            body: formData1
        })
        .then(response => response.json())
        .then(result => {
		  if(result.status == "succuss"){
            //delete_message(result.data);
          } 
        })
    }, 1000);

    </script>
</html>

<?php
							   } else {
									echo "This Channel is not empty now!";
								}
		} else {
		   echo "Receiver not exist";
	    }
	} else {
		echo "Invalid Request";
	}
?>