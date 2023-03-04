<?php require("static/config.inc.php"); ?>
<?php require("static/conn.php"); ?>
<?php require("lib/profile.php"); ?>
<?php require("includes/dbconn.php"); ?>
<?php
if(isset($_GET['recieve'])){
$reciever = $_GET['recieve'];
$receiver = $_GET['recieve'];
	$cr = $dbconn->query("SELECT * FROM users WHERE username='$reciever'");
	if($cr->num_rows == 1){
	  if($_SESSION['siteusername'] !== $receiver){
		  
		  $ch1_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='1'");
		  if($ch1_emp->num_rows > 0){
			  $ch1_emp_d = $ch1_emp->fetch_array();
			  $ch1_sender = $ch1_emp_d['sender'];
			  if($ch1_sender == $_SESSION['siteusername']){
				  $chanel1_empty = TRUE;
			  } else {
				   $chanel1_empty = FALSE; 
			  }
		  } else {
			   $chanel1_empty = TRUE;
		  }
		  
		  $ch2_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='2'");
		  if($ch2_emp->num_rows > 0){
			  $ch2_emp_d = $ch2_emp->fetch_array();
			  $ch2_sender = $ch2_emp_d['sender'];
			  if($ch2_sender == $_SESSION['siteusername']){
				  $chanel2_empty = TRUE;
			  } else {
				   $chanel2_empty = FALSE;
			  }
		  } else {
			   $chanel2_empty = TRUE;
		  }
		  
		  $ch3_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='3'");
		  if($ch3_emp->num_rows > 0){
			  $ch3_emp_d = $ch3_emp->fetch_array();
			  $ch3_sender = $ch3_emp_d['sender'];
			  if($ch3_sender == $_SESSION['siteusername']){
				  $chanel3_empty = TRUE;
			  } else {
				   $chanel3_empty = FALSE;
			  }
		  } else {
			   $chanel3_empty = TRUE;
		  }
		  
		  	$ch_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='4'");
		  if($ch4_emp->num_rows > 0){
			  $ch4_emp_d = $ch4_emp->fetch_array();
			  $ch4_sender = $ch4_emp_d['sender'];
			  if($ch4_sender == $_SESSION['siteusername']){
				  $chanel4_empty = TRUE;
			  } else {
				   $chanel4_empty = FALSE;
			  }
		  } else {
			   $chanel4_empty = TRUE;
		  }
		  
		  	$ch5_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='5'");
		  if($ch5_emp->num_rows > 0){
			  $ch5_emp_d = $ch5_emp->fetch_array();
			  $ch5_sender = $ch5_emp_d['sender'];
			  if($ch5_sender == $_SESSION['siteusername']){
				  $chanel5_empty = TRUE;
			  } else {
				   $chanel5_empty = FALSE;
			  }
		  } else {
			   $chanel5_empty = TRUE;
		  }
		  
		  	$ch6_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='6'");
		  if($ch6_emp->num_rows > 0){
			  $ch6_emp_d = $ch6_emp->fetch_array();
			  $ch6_sender = $ch6_emp_d['sender'];
			  if($ch6_sender == $_SESSION['siteusername']){
				  $chanel6_empty = TRUE;
			  } else {
				   $chanel6_empty = FALSE;
			  }
		  } else {
			   $chanel6_empty = TRUE;
		  }
		  
		  	$ch7_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='7'");
		  if($ch7_emp->num_rows > 0){
			  $ch7_emp_d = $ch7_emp->fetch_array();
			  $ch7_sender = $ch7_emp_d['sender'];
			  if($ch7_sender == $_SESSION['siteusername']){
				  $chanel7_empty = TRUE;
			  } else {
				   $chanel7_empty = FALSE;
			  }
		  } else {
			   $chanel7_empty = TRUE;
		  }
		  
		  $ch8_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='8'");
		  if($ch8_emp->num_rows > 0){
			  $ch8_emp_d = $ch8_emp->fetch_array();
			  $ch8_sender = $ch8_emp_d['sender'];
			  if($ch8_sender == $_SESSION['siteusername']){
				  $chanel8_empty = TRUE;
			  } else {
				   $chanel8_empty = FALSE;
			  }
		  } else {
			   $chanel8_empty = TRUE;
		  }
		
		$ch9_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='9'");
		  if($ch9_emp->num_rows > 0){
			  $ch9_emp_d = $ch9_emp->fetch_array();
			  $ch9_sender = $ch9_emp_d['sender'];
			  if($ch9_sender == $_SESSION['siteusername']){
				  $chanel9_empty = TRUE;
			  } else {
				   $chanel9_empty = FALSE;
			  }
		  } else {
			   $chanel9_empty = TRUE;
		  }
		
				  $ch10_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='10'");
		  if($ch10_emp->num_rows > 0){
			  $ch10_emp_d = $ch10_emp->fetch_array();
			  $ch10_sender = $ch10_emp_d['sender'];
			  if($ch10_sender == $_SESSION['siteusername']){
				  $chanel10_empty = TRUE;
			  } else {
				   $chanel10_empty = FALSE;
			  }
		  } else {
			   $chanel10_empty = TRUE;
		  }
		  
	 } else {
		   $my_channel = TRUE;
		  $ch1_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='1'");

		  
		  $ch2_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='2'");

		  
		  $ch3_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='3'");

		  
		  	$ch_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='4'");

		  
		  	$ch5_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='5'");

		  
		  	$ch6_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='6'");

		  
		  	$ch7_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='7'");

		  
		  $ch8_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='8'");
		 
		
		$ch9_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='9'");
		
		$ch10_emp = $dbconn->query("SELECT * FROM ghost_chat WHERE reciever='$reciever' AND channel='10'");
	  }
?>
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
        <?php $reciever = getUserFromId((int)$_GET['reciever_id'], $conn)['username']; ?>
		<style>
			.crow{
display: flex;
    width: 100%;
    height: 100px;
    background: #8B0000;
			}
			.ccol-6{
width: 50%;
    background: #B45A5A;
    margin: 10px;
    font-size: 20px;
    text-align: center;
    padding: 25px 0px 0px 0px;
    font-weight: 600;
			}
			.ccol-6 a {
				color:#fff;
			}
			.ctitle{
    width: 100%;
    height: 100px;
    background: rgb(255 183 77 / 100%);
    text-align: center;
    font-size: 60px;
    font-weight: 700;
    color: #fff;
    text-shadow: 2px 2px #b70404;
    margin: 20px 0px 0px 0px;
    padding: 20px 0px 0px 0px;
			}
		</style>
    </head>
    <body>
        <div class="container">
            <?php require("static/header.php"); ?>
            <br>
			<div class="channels">
				<div class="ctitle">
					Ghost Messages
				</div>
				<div class="crow">
					<div class="ccol-6" <?php if($chanel1_empty == TRUE){ echo 'style="background:green"'; } ?>>
						<a href="messanger.php?receiver=<?php echo $receiver ?>&channel=1">Channel 1 <?php if($my_channel AND $ch1_emp->num_rows>0){ echo "(".$ch1_emp->num_rows.")"; } ?></a>
					</div>
					<div class="ccol-6" <?php if($chanel2_empty == TRUE){ echo 'style="background:green"'; } ?>>
						<a href="messanger.php?receiver=<?php echo $receiver ?>&channel=2">Channel 2 <?php if($my_channel AND $ch2_emp->num_rows>0){ echo "(".$ch2_emp->num_rows.")"; } ?></a>
					</div>
				</div>
				<div class="crow">
					<div class="ccol-6" <?php if($chanel3_empty == TRUE){ echo 'style="background:green"'; } ?>>
						<a href="messanger.php?receiver=<?php echo $receiver ?>&channel=3">Channel 3 <?php if($my_channel AND $ch3_emp->num_rows>0){ echo "(".$ch3_emp->num_rows.")"; } ?></a>
					</div>
					<div class="ccol-6" <?php if($chanel4_empty == TRUE){ echo 'style="background:green"'; } ?>>
						<a href="messanger.php?receiver=<?php echo $receiver ?>&channel=4">Channel 4 <?php if($my_channel AND $ch4_emp->num_rows>0){ echo "(".$ch4_emp->num_rows.")"; } ?></a>
					</div>
				</div>
				<div class="crow">
					<div class="ccol-6" <?php if($chanel5_empty == TRUE){ echo 'style="background:green"'; } ?>>
						<a href="messanger.php?receiver=<?php echo $receiver ?>&channel=5">Channel 5 <?php if($my_channel AND $ch5_emp->num_rows>0){ echo "(".$ch5_emp->num_rows.")"; } ?></a>
					</div>
					<div class="ccol-6" <?php if($chanel6_empty == TRUE){ echo 'style="background:green"'; } ?>>
						<a href="messanger.php?receiver=<?php echo $receiver ?>&channel=6">Channel 6 <?php if($my_channel AND $ch6_emp->num_rows>0){ echo "(".$ch6_emp->num_rows.")"; } ?></a>
					</div>
				</div>
				<div class="crow">
					<div class="ccol-6" <?php if($chanel7_empty == TRUE){ echo 'style="background:green"'; } ?>>
						<a href="messanger.php?receiver=<?php echo $receiver ?>&channel=7">Channel 7 <?php if($my_channel AND $ch7_emp->num_rows>0){ echo "(".$ch7_emp->num_rows.")"; } ?></a>
					</div>
					<div class="ccol-6" <?php if($chanel8_empty == TRUE){ echo 'style="background:green"'; } ?>>
						<a href="messanger.php?receiver=<?php echo $receiver ?>&channel=8">Channel 8 <?php if($my_channel AND $ch8_emp->num_rows>0){ echo "(".$ch8_emp->num_rows.")"; } ?></a>
					</div>
				</div>
				<div class="crow">
					<div class="ccol-6" <?php if($chanel9_empty == TRUE){ echo 'style="background:green"'; } ?>>
						<a href="messanger.php?receiver=<?php echo $receiver ?>&channel=9">Channel 9 <?php if($my_channel AND $ch9_emp->num_rows>0){ echo "(".$ch9_emp->num_rows.")"; } ?></a>
					</div>
					<div class="ccol-6" <?php if($chanel10_empty == TRUE){ echo 'style="background:green"'; } ?>>
						<a href="messanger.php?receiver=<?php echo $receiver ?>&channel=10">Channel 10 <?php if($my_channel AND $ch10_emp->num_rows>0){ echo "(".$ch10_emp->num_rows.")"; } ?></a>
					</div>
				</div>
			</div>
        </div>
        <br>
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/footer.php"); ?>
    </body>
</html>
<?php
	} else {
		echo "Receiver not exist";
	}
	} else {
	echo "invalid request";
}						
?>