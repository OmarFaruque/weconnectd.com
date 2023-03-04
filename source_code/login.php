
<?php
if (!isset($_SESSION)){
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
    
// Root path $_SESSION['ROOT_PATH']


?>
<?php require("static/config.inc.php"); ?>
<?php require("static/conn.php"); ?>
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
            <?php require($_SESSION['ROOT_PATH'] . "/static/header.php"); ?>
            <br>
            <div class="padding">
                <div class="padding">
                    <center>
                    <?php 
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['password'] && $_POST['username']) {
                            $email = htmlspecialchars(@$_POST['email']);
                            $username = htmlspecialchars(@$_POST['username']);
                            $password = @$_POST['password'];
                            $passwordhash = password_hash(@$password, PASSWORD_DEFAULT);

                        // echo 'check post <br/><pre>';
                        // print_R($_POST);
                        // echo '</pre>';

                        $stmt = $conn->prepare("SELECT `password`, `id` FROM users WHERE username = ? AND user_status = 1");
                        echo $stmt->error;
                        $stmt->bind_param('s', $username);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if(!mysqli_num_rows($result)){ { $error = "incorrect username or password"; goto skip; } }                 
                            $row = $result->fetch_assoc();
                            $hash = $row['password'];
                        
                        if(!password_verify($password, $hash)){ $error = "incorrect username or password"; goto skip; }
                        $_SESSION['siteusername'] = $username;
                        $_SESSION['user_id'] = $row['id'];
                        
                        // header("Location: manage.php");
                    }
                    skip:

                    if(isset($error)) { echo "<div class='alert-danger'>".$error."</div>"; } ?>
					<?php	if(isset($_GET['msg'])) { echo "<div class='alert-success'>".$_GET['msg']."</div>"; } ?>
                    <div id="login">
                        <div class="login-header">Member Login</div>
                        <form action="" method="post" id="submitform">
							
						<div class="login-form">
							<div class="form-row">
								<div class="label"><label for="email">User Name:</label></div>
								<div class="input"><input type="text" name="username" id="email"></div>
							</div>
							<div class="form-row">
								<div class="label"><label for="password">Password:</label></div>
								<div class="input"><input name="password" type="password" id="password"></div>
							</div>
							<div class="form-row">
								<td colspan="2"><input type="checkbox" name="Remember" value="Remember" id="checkbox">
								<label for="checkbox">Remember my E-mail</label></td>
							</div>
							<div class="form-row">
								<div>
									<button type="submit" name="login" style="border:none; background:inherit;"><img src="static/button_login_main.gif" alt="SIGN UP NOW!"  border="0"></button>
								    <a href="register.php"><img src="static/button_signup_main.gif" alt="SIGN UP NOW!" name="singup" id="singup" border="0"></a>
							    </div>
							</div>
							<div class="forgot">
								<a href="forgot-password.php">Forgot Password?</a>
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
        <?php require($_SESSION['ROOT_PATH'] . "/static/footer.php"); ?>
    </body>
</html>