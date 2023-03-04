<?php require("static/config.inc.php"); ?>
<?php require("static/conn.php"); ?>
<?php require("lib/register.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $config['pr_title']; ?></title>
        <link rel="stylesheet" href="/static/css/required.css"> 
        <script src='https://www.google.com/recaptcha/api.js' async defer></script>
        <script>function onLogin(token){ document.getElementById('submitform').submit(); }</script>
		<style>
			#register {
				max-width: 500px;
				border: 1px solid #000;
                padding: 30px 10px;
                background: rgb(245 124 0 / 50%);
                box-shadow: 0px 2px 5px 2px;
			}
			.alert-success{
				max-width: 500px;
    margin: 20px auto;
    background: #14e714;
    padding: 20px 10px;
    box-shadow: 0px 2px 5px 2px #000;
    color: #1b5e20;
}
			.alert-danger{
				max-width: 500px;
    margin: 20px auto;
    background: red;
    padding: 20px 10px;
    box-shadow: 0px 2px 5px 2px #000;
    color: #fff;
}
			#register .register-header{
				padding: 0px 0px 5px 0px;
                margin: 0px 0px 20px 0px;
                font-size: 16px;
                font-weight: 600;
                border-bottom: 3px solid #12192C;
			}
			#register .form-control .form-row{
				width: 100%;
                display: flex;
                padding: 5px 2px;
                font-size: 14px;
                font-weight: 550;
			}
			#register .form-row .label{
				width: 100px;
				text-align: left;
			}
			#register .form-row .input{
				width: calc(100% - 100px);
			}
		</style>
    </head>
    <body>
        <div class="container">
            <?php require("static/header.php"); ?>
            <br>
            <div class="padding">
                <div class="padding">
                    <?php 
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['password'] && $_POST['username']) {
                        if(strpos($_POST['username'], "debian") == true) {
                            header("Location: https://youareanidiot.org/");
                            goto skip;
                        }

                        if(strpos($_POST['username'], "nigga") == true) {
                            header("Location: https://youareanidiot.org/");
                            goto skip;
                        }

                        if(strpos($_POST['username'], "WrongIP") == true) {
                            header("Location: https://youareanidiot.org/");
                            goto skip;
                        }

                        $email = htmlspecialchars(@$_POST['email']);
                        $username = htmlspecialchars(@$_POST['username']);
                        $password = @$_POST['password'];
						$account_type = $_POST['account_type']; 
                        $passwordhash = password_hash(@$password, PASSWORD_DEFAULT);
                        
                        if($_POST['password'] !== $_POST['confirm']){ $error = "password and confirmation password do not match"; goto skip; }
    
                        if(strlen($username) > 21) { $error = "your username must be shorter than 21 characters"; goto skip; }
                        if(strlen($password) < 8) { $error = "your password must be at least 8 characters long"; goto skip; }
                        if(!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password)) { $error = "please include both letters and numbers in your password"; goto skip; }
                        //if(!isset($_POST['g-recaptcha-response'])){ $error = "captcha validation failed"; goto skip; }
                        //if(!validateCaptcha($config['recaptcha_secret'], $_POST['g-recaptcha-response'])) { $error = "captcha validation failed"; goto skip; }
    
                        $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
                        $stmt->bind_param("s", $username);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if($result->num_rows) { $error = "There's already a user with that same name!"; goto skip; }
						
						$stmt_email = $conn->prepare("SELECT email FROM users WHERE email = ?");
                        $stmt_email->bind_param("s", $email);
                        $stmt_email->execute();
                        $result_email = $stmt_email->get_result();
                        if($result_email->num_rows) { $error = "This Email already exist!"; goto skip; }
                        
                        if(register($username, $email, $passwordhash, $account_type, $signup_type='', $conn)) {
                            echo "<div class='alert-success'>We sent a verification mail on your email id <b>$email</b>. Please verify your account... </div>";
                        } else {
                            $error = "There was an unknown error making your account.";
                        }	
                    }
                    skip:
                    ?>
                    <?php if(isset($error)) { echo "<div class='alert-danger'>".$error."</div>"; } ?>
                    <center>
                    <div id="register">
                        <div class="register-header">Member Account</div>
                        <form action="" method="post" id="submitform">
							<div class="form-control">
								<div class="form-row">
                                    <div class="label"><label for="email">E-Mail:</label></div>
                                    <div class="input"><input type="email" name="email" id="email"></div>
                                </div>
								<div class="form-row">
                                    <div class="label"><label for="username">Username:</label></div>
                                    <div class="input"><input name="username" type="text" id="username"></div>
                                </div>
								<div class="form-row">
                                    <div class="label"><label for="username">Account Type:</label></div>
                                    <div class="input">
										<select name="account_type" id="account_type">
											<option value="Crypto Investor Account">Crypto Investor Account</option>
											<option value="Collegiate account">Collegiate account</option>
											<option value="Teen Account">Teen Account</option>
											<option value="Basic Account">Basic Account</option>
											<option value="Moderator Account">Moderator Account</option>
											<option value="Dating Account">Dating Account</option>
										</select>
									</div>
                                </div>
                                <div class="form-row">
                                    <div class="label"><label for="password">Password:</label></div>
                                    <div class="input"><input name="password" type="password" id="password"></div>
                                </div>
                                <div class="form-row">
                                    <div class="label"><label for="confirm">Confirm Password:</label></div>
                                    <div class="input"><input name="confirm" type="password" id="confirm"></div>
                                </div>
       
                                <div class="form-row">
                                </div>
                                <div class="form-row">
                                    <div><input type="submit" value="Register" class="g-recaptcha" data-sitekey="<?php echo $config['recaptcha_sitekey']; ?>" data-callback="onLogin"></div>
                                </div>
                                <div class="forgot">

                                </div>
							</div>
                        </form>
                        </center>
                    </div>
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
        <?php require("static/footer.php"); ?>
    </body>
</html>
