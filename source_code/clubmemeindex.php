<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();

$_SESSION['ROOT_PATH'] = dirname($_SERVER['SCRIPT_FILENAME']);
if (!defined('ROOT_PATH'))
    define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME']));

ini_set('display_errors', 1);
require($_SESSION['ROOT_PATH'] . "/static/config.inc.php");
require($_SESSION['ROOT_PATH'] . "/static/conn.php");
require($_SESSION['ROOT_PATH'] . "/lib/profile.php");
require_once($_SESSION['ROOT_PATH'] . "/includes/dbconn.php");


?>

<!DOCTYPE html>
<html>
    <head>
		<meta charset="UTF-8" />
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title><?php echo $config['pr_title']; ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="static/css/required.css"> 
		<link rel="stylesheet" href="OwlCarousel/dist/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="OwlCarousel/dist/assets/owl.theme.default.min.css">
        </head>

<center><img src="https://i.ibb.co/6BF5LCm/clubmeme.png"></center>
 


			
                  <center>  <div class="login">
                        <div class="loginTopbar">
                            <b>Online Users</b>
                        </div>
                        <div class="grid-container2">
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM users");
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {
                                $lastLoginReal = (int) strtotime($row['lastlogin']);
                                if (time() - $lastLoginReal < 15 * 60) { ?>
                                    <div class="item1"><a href="profile.php?id=<?php echo getIDFromUser($row['username'], $conn); ?>"><div><center><?php echo $row['username']; ?></center></div><img src="<?php echo ROOT_URL; ?>dynamic/pfp/<?php echo getPFPFromUser($row['username'], $conn); ?>"></a></div>
                                    <?php }
                            } ?>
                        </div>
                    </div>
				<br>
                    <div class="splashBlue">
                        Always make sure you're visiting the real WeConnectd.com!
                        <ul>
                            <li>Check the URL in your browser.</li>
                            <li>Make sure it begins with http://www.WeConnectd.com/</li>
                            <li>If ANY OTHER PAGE asks for your info, DON'T LOG IN!</li>
                        </ul>
                    </div>

                    <br>
                    
		                    
                    
                        </tbody></table>
                        </div>
                        <div class="clear"></div>
                        
                        </span>
                    </div>
                </div>
	
            </div>

                   <?php 
                   if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['password'] && $_POST['email']) {
                       $email = htmlspecialchars(@$_POST['email']);
                       $password = @$_POST['password'];
                       $passwordhash = password_hash(@$password, PASSWORD_DEFAULT);

                       $stmt = $conn->prepare("SELECT * FROM `users` WHERE (email = ? OR username=?) AND `status`!= 'deleted'");
                       $stmt->bind_param("ss", $email, $email);
                       $stmt->execute();
                       $result = $stmt->get_result();
                       if (!mysqli_num_rows($result)) {
                           $error = "incorrect email or password";
                           goto skip;
                       }
                       $row = $result->fetch_assoc();
                       $hash = $row['password'];

                       if (!password_verify($password, $hash)) {
                           $error = "incorrect email or password";
                           goto skip;
                       }
                       $_SESSION['siteusername'] = $row['username'];
                       $_SESSION['user_id'] = $row['id'];

                       echo "<script>location.href = 'coinmate.php';</script>";
                   }
                   skip:

                   if (isset($error)) {
                       echo "<small style='color:red'>" . $error . "</small>";
                   } ?>
	    <div class="center">
            <?php if (!isset($_SESSION['siteusername'])): ?>
                <div id="login">
					
					<div class="login-header">Weconnectd Login</div>
					<form method="post">
						<div class="login-form">
							<div class="regularLogin">
                                <div class="form-row">
                                    <div class="label"><label for="email">E-Mail / Username:</label></div>
                                    <div class="input"><input type="text" name="email" id="email"></div>
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
                                        <button type="submit" name="login" style="border:none; background:inherit;">
                                            <img src="<?php echo ROOT_URL; ?>static/button_login_main.gif" alt="SIGN UP NOW!"  border="0">
                                        </button>
                                        <a href="register.php">
                                            <img src="<?php echo ROOT_URL; ?>static/button_signup_main.gif" alt="SIGN UP NOW!" name="singup" id="singup" border="0">
                                        </a>
                                    </div>
                                </div>
                                <div class="forgot">
                                    <a href="forgot-password.php">Forgot Password?</a>
                                </div>
                            </div>
                            <div class="facebookLogin">
                                <p>Or</p>
                                <div class="fb-login-button" data-onlogin="fb_login()" data-scope="public_profile,email" id="loginbutton" data-width="" data-size="large" data-button-type="continue_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="true"></div>
                            </div>
						</div>
					</form> 
				</div>
    <?php endif ?> 
			<br>
                <div class="login">
                    <div class="loginTopbar">
                        <b>Cool Crypto People</b><span style="float: right; color: white;"><small><a style="color: white;" href="/users.php">[view more]</a></small></span>
                    </div>
                    <div class="grid-container">
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM users ORDER BY id DESC LIMIT 10");
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <div class="item1"><a href="profile.php?id=<?php echo getIDFromUser($row['username'], $conn); ?>">
                                <div><center><?php echo $row['username']; ?></center></div>
								<img src="<?php echo ROOT_URL; ?>dynamic/pfp/<?php echo getPFPFromUser($row['username'], $conn); ?>"></a></div>
                        <?php } ?>
                    </div>
                </div></center>
			
            <!--
            <div class="padding10">
                <table class="cols" style="margin-top: 800px;">
                    <tbody>
                        <tr>
                            <td>
                                <b>Get Started!</b><br>
                                Join for free, and view profiles, connect with others, blog, customize your profile, and much more!<br><br><br><br>
                                <span id="splash">» <a href="register.php">Learn More</a></span>
                            </td>
                            <td>
                                <b>Create Your Profile!</b><br>
                                Tell us about yourself, upload your pictures, and start adding coinconnects to your network.<br><br><br><br><br>
                                <span id="splash">» <a href="register.php">Start Now</a></span>
                            </td>
                            <td>
                                <b>Browse Profiles!</b><br>
                                Read through all of the profiles on WeConnectd! See pix, read blogs, and more!<br><br><br><br><br>
                                <span id="splash">» <a href="users.php">Browse Now</a></span>
                            </td>
                            <td>
                                <b>Invite Your Coinconnects!</b><br>
                                Invite your Coinconnects, and as they invite their Coinconnects your network will grow even larger!<br><br><br><br><br>
                                <span id="splash">» <a href="register.php">Invite Coinconnects Now</a></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            -->
        </div>
        <br>
        <?php require("static/footer.php"); ?>
        <script src="OwlCarousel/docs/assets/vendors/jquery.min.js"></script>
        <script src="OwlCarousel/dist/owl.carousel.min.js"></script>
         <script src="<?php echo ROOT_URL; ?>static/js/global.js"></script>
    </body>
</html>
