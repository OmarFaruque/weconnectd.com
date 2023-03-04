<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/conn.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $config['pr_title']; ?></title>
        <link rel="stylesheet" href="/static/css/required.css"> 
		<style>
			.alert-success{
				max-width: 400px;
    margin: 20px auto;
    background: #14e714;
    padding: 20px 10px;
    box-shadow: 0px 2px 5px 2px #000;
    color: #1b5e20;
}
			.alert-danger{
				max-width: 400px;
    margin: 20px auto;
    background: red;
    padding: 20px 10px;
    box-shadow: 0px 2px 5px 2px #000;
    color: #fff;
}
			.submit-button button{
				    border: 1px solid #000;
    padding: 2px 5px;
    background: #e65100;
    border-radius: 5px;
			}
			 #login {
                text-align: center;
    border: 1px solid #039;
    margin: 0 0 10px 0;
    padding: 20px 10px;
    background: rgb(245 124 0 / 50%);
    box-shadow: 0px 2px 5px 2px;
				 max-width: 400px;
            }
			
			#login .login-header{
				padding: 0px 0px 5px 0px;
    margin: 0px 0px 20px 0px;
    font-size: 16px;
    font-weight: 600;
    border-bottom: 3px solid #12192C;
			}
			#login .form-row{
				width: 100%;
    display: flex;
    padding: 5px 2px;
    font-size: 14px;
    font-weight: 550;
			}
			#login .form-row .label{
				width: 100px;
				text-align: left;
			}
			#login .form-row .input{
				width: calc(100% - 100px);
			}
		</style>
    </head>
    <body>
        <div class="container">
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/header.php"); ?>
            <br>
            <div class="padding">
                <div class="padding">
                    <center>
                    <?php 
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['username']) {
                            $username = htmlspecialchars(@$_POST['username']);
                            $stmt = $conn->prepare("SELECT * FROM `users` WHERE username = ? AND user_status='1'");
                            $stmt->bind_param("s", $username);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if(!mysqli_num_rows($result)){
								$error = "Invalid Username";
							} else {
								$row = $result->fetch_assoc();
                                $email = $row['email'];
								$otp = sprintf("%06d", mt_rand(1, 999999));
                                $otp_token = $otp.$email;
                                $hash_otp = password_hash("$otp_token", PASSWORD_DEFAULT); 
								$stmt_up = $conn->prepare("UPDATE `users` SET activation_key = ? WHERE username = ? AND user_status='1'");
                                $stmt_up->bind_param("ss", $hash_otp, $username);
                                $stmt_up->execute();
								$to = $email;
			$subject = 'Forgot Password - WeConnectd';
            $from = 'contact@weconnectd.com';
	
$body = '
<div class="body">
    <div class="header" style="width: 100%;
                               height: 80px;
                               display: table;
                               position: relative;
                               font-size: 14px;
                               background:#000000;
                               display:flex;">
        <a href="http://alfrik.com/" style="width: 40%;">
            <img style="height:50px; margin-top:15px; margin-left: 20px;" src="https://weconnectd.com/static/spacemy.png" class="logo" alt="WeConnectd">
        </a>
    </div>
    <div style="width:100%; 
                                text-align: center; 
                                min-height: 200px;
                                background: #f6f6f6;
                                padding-top: 30px;
                                font-size: 20px;">
        There is a request for forgot password:<br>
        <a href="https://weconnectd.com/change-password.php?username='.$username.'&key='.$hash_otp.'">Click Here</a><br>
        to chnage your password.<br>
    </div>
</div>

';

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <contact@weconnectd.com>' . "\r\n";
$headers .= 'Cc: contact@weconnectd.com' . "\r\n";

$mailsent = mail($to,$subject,$body,$headers);
								if($mailsent){
									$msg = "We sent an mail to your email id <b>$email</b>. To change password vefiry your email";
								} else {
									$error = "Server Error!";
								}             
					        }
                    }
                    skip:

                    if(isset($error)) { echo "<div class='alert-danger'>".$error."</div>"; } ?>
					<?php	if(isset($msg)) { echo "<div class='alert-success'>".$msg."</div>"; } ?>
                    <div id="login">
                        <div class="login-header">Forgot Password</div>
                        <form action="" method="post" id="submitform">
							
						<div class="login-form">
							<div class="form-row">
								<div class="label"><label for="email">User Name:</label></div>
								<div class="input"><input type="text" name="username" id="email"></div>
							</div>
							<div class="form-row">
								<div class="submit-button">
									<button type="submit" name="login">Send Request</button>
							    </div>
							</div>
						</div>
                        </form>
                    </div>
                    </center>
                </div><br>
                <table class="cols">
                    <tbody>
                        <tr>
                            <td>
                                <b>Get Started!</b><br>
                                Join for free, and view profiles, connect with others, blog, customize your profile, and much more!<br><br><br>
                                <span id="splash">» <a href="register.php">Learn More</a></span>	
                            </td>
                            <td>
                                <b>Create Your Account!</b><br>
                                Tell us about yourself, upload your pictures, and start adding connects to your network.<br><br><br><br>
                                <span id="splash">» <a href="register.php">Start Now</a></span>		
                            </td>
                            <td>
                                <b>Browse Profiles!</b><br>
                                Read through all of the profiles on WeConnectd! See pix, read blogs, and more!<br><br><br><br>
                                <span id="splash">» <a href="users.php">Browse Now</a></span>
                            </td>
                            <td>
                                <b>Invite Your Connects!</b><br>
                                Invite your connects, and as they invite their connects your network will grow even larger!<br><br><br><br>
                                <span id="splash">» <a href="register.php">Invite Connects Now</a></span>	
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/footer.php"); ?>
    </body>
</html>