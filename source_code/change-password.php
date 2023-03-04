<?php if(isset($_GET['username']) && isset($_GET['key'])){ ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/conn.php"); ?>
<?php 
require('includes/dbconn.php');														  
$username = $_GET['username'];
$key = $_GET['key'];
$user = $dbconn->query("SELECT * FROM users WHERE username='$username'");
if($user->num_rows == 1){
	$user_d = $user->fetch_array();
	if($user_d['activation_key'] === $key){
?>
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
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['password'] && $_POST['cpassword']) {
                        $password = $_POST['password'];
						$cpassword = $_POST['cpassword'];
                        $passwordhash = password_hash($password, PASSWORD_DEFAULT);
						if($password === $cpassword){
							 if(strlen($password) < 8) { 
								 $error = "Your password must be at least 8 characters long"; 
							 } else {
								 if(!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password)) { 
									 $error = "Please include both letters and numbers in your password"; 
								 } else {
									 $update_pass = $conn->query("UPDATE users SET password='$passwordhash' WHERE username='$username' AND activation_key='$key'");
							         if($update_pass){
								          header('location: login.php?msg=Password Changed Successfully! Please Login!');
							         } else {
								          $error = "Server Error! Please request again to forgot password...";
							         }
								 }
							 }
						} else {
							$error = "Password didn't match!";
						}
                    }

                    if(isset($error)) { echo "<div class='alert-danger'>".$error."</div>"; } ?>
					<?php	if(isset($_GET['msg'])) { echo "<div class='alert-success'>".$_GET['msg']."</div>"; } ?>
                    <div id="login">
                        <div class="login-header">Change Password</div>
                        <form action="" method="post" id="submitform">
							
						<div class="login-form">
							<div class="form-row">
								<div class="label"><label for="password">New Password:</label></div>
								<div class="input"><input type="password" name="password" id="password"></div>
							</div>
							<div class="form-row">
								<div class="label"><label for="cpassword">Confirm New Password:</label></div>
								<div class="input"><input type="password" name="cpassword" id="cpassword"></div>
							</div>
							<div class="form-row">
								<div class="submit-button">
									<button type="submit" name="login" style="border:none; background:inherit;">Set Your Password</button>
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
                                <b>Create Your Profile!</b><br>
                                Tell us about yourself, upload your pictures, and start adding friends to your network.<br><br><br><br>
                                <span id="splash">» <a href="register.php">Start Now</a></span>		
                            </td>
                            <td>
                                <b>Browse Profiles!</b><br>
                                Read through all of the profiles on SpaceMy! See pix, read blogs, and more!<br><br><br><br>
                                <span id="splash">» <a href="users.php">Browse Now</a></span>
                            </td>
                            <td>
                                <b>Invite Your Friends!</b><br>
                                Invite your friends, and as they invite their friends your network will grow even larger!<br><br><br><br>
                                <span id="splash">» <a href="register.php">Invite Friends Now</a></span>	
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
<?php
		}else {
	      echo "Invalid Request!";
        }
   } else {
	   echo "Invalid Request!";
   }
} else { echo "invalid Request!"; }
?>