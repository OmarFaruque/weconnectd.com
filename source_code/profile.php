<?php 


require("static/config.inc.php"); 
require("static/conn.php");
require("lib/profile.php");
require("includes/dbconn.php"); 
require_once($_SESSION['ROOT_PATH'] . '/functions/default_functions.php');

/**
 * Redirect if profile are blocked for this user
 */

// Burn Profile 
if (isset($_GET['action']) && $_GET['action'] == 'burn-profile')
{
    burnUserProfile($_GET['bid'], $conn);
}

if(!have_visit_access($conn))
    header("Location: ".ROOT_URL."");


?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $config['pr_title']; ?></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="static/css/required.css">
        <link rel="stylesheet" href="static/css/profile.css">
        <link rel="stylesheet" href="static/css/table3.css">
		<link rel="stylesheet" href="static/css/blink.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
		
        <link rel="stylesheet" href="lib/getCSS.php?id=<?php echo (int)$_GET['id']; ?>"> 
        <script src="onLogin.js"></script>
		<?php
		if(isset($_GET['id'])){
			$gid = $_GET['id'];
		} else if(isset($_GET['furl']) and isset($_GET['lurl'])){
			$seurl = $_GET['furl'].'/'.$_GET['lurl'];
			$for_id = $conn->query("SELECT id FROM users WHERE url='$seurl'");
			if($for_id->num_rows > 0){
				$gid = $for_id->fetch_array()['id'];
			}	
		} ?>
        <?php $user = getUserFromId($gid, $conn); ?>

        <meta property="og:title" content="<?php echo $user['username']; ?>" />
        <meta property="og:description" content="<?php echo preg_replace("/\"/", "&quot;", $user['bio']); ?>" />
        <meta property="og:image" content="https://weconnectd.com/dynamic/pfp/<?php echo $user['pfp']; ?>" />	
		<style>
			.url-box{
				display:flex;
			}
			.url-box #copy{
				border: 1px solid;
				margin-left: 5px;
				background: inherit;
				font-size: 16px;
				cursor: pointer;
			}
			.coinconnect_address{
				border: 1px solid;
				padding: 10px;
				margin: 10px 0px
			}
		</style>
    </head>
    <body>
        <div class="container">
            <?php require("static/header.php"); 
                if($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if(!isset($_SESSION['siteusername'])){ $error = "you are not logged in"; goto skipcomment; }
                    if(!$_POST['comment']){ $error = "your comment cannot be blank"; goto skipcomment; }
                    if(strlen($_POST['comment']) > 1000){ $error = "your comment must be shorter than 1000 characters"; goto skipcomment; }
                    //if(!isset($_POST['g-recaptcha-response'])){ $error = "captcha validation failed"; goto skipcomment; }
                    //if(!validateCaptcha($config['recaptcha_secret'], $_POST['g-recaptcha-response'])) { $error = "captcha validation failed"; goto skipcomment; }
					$comment_image = $_FILES['cimage'];
					if(!empty($comment_image['name'])){
						$cimage_path = "comment_image/".$comment_image['name'];
						move_uploaded_file($comment_image['tmp_name'], $cimage_path);
					}
                    $stmt = $conn->prepare("INSERT INTO `comments` (toid, author, comment, image) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $_GET['id'], $_SESSION['siteusername'], $text, $cimage_name);
					$cimage_name = $_FILES['cimage']['name'];
                    $text = htmlspecialchars($_POST['comment']);
                    $stmt->execute();
                    $stmt->close();
                    logDB($_SESSION['siteusername'] . " has commented a user named " . $user['username'] . " with the content: " . $text, $conn);
                    skipcomment:
                }

                if(isset($_SESSION['siteusername']) && $user['username'] == $_SESSION['siteusername']) {
                    $user['ownAccount'] = true;
                }

                if($user['badges'] != "") {
                    $user['badgesArray'] = explode(";", $user['badges']);
                    $lastElement = array_pop($user['badgesArray']);
                    $user['badgesBuffer'] = "";
                    foreach ($user['badgesArray'] as $explodedVal) {
                        $user['badgesBuffer'] = $user['badgesBuffer'] . " <img src='/static/badges/" . $explodedVal . ".png'>";
                    }
                }

                $user['privacyArray'] = explode("|", $user['privacy']);

               

                $group = getGroupFromId($user['currentgroup'], $conn);
                

                $lastLoginReal = (int)strtotime($user['lastlogin']);
                if(time() - $lastLoginReal < 15 * 60) {
                    $lastLogin = true;
                }
            ?>

			<?php
                if(isset($_POST['coinadd'])){
                    $coinconnect_address = $_POST['coinconnect_address'];
                    $up_coin = $dbconn->query("UPDATE users SET coinconnect_address='$coinconnect_address' WHERE username='".$_SESSION['siteusername']."'");
                    if($up_coin){
                        header("Location: profile.php?id=$gid");
                    } else {
                        $coinadd_error = 'Server_error!';
                    }
                }
                if(isset($_POST['peeltoken'])){
                    $peel_token = $_POST['peel_token'];
                    $up_token = $dbconn->query("UPDATE users SET peel_token='$peel_token' WHERE username='".$_SESSION['siteusername']."'");
                    if($up_token){
                        header("Location: profile.php?id=$gid");
                    } else {
                        $peeltoken_error = 'Server Error!';
                    }
                }
                if(isset($_POST['send_crr'])){
                    $user_id = $_POST['user_id'];
                    $ccr_amount = $_POST['ccr_amount'];
					if($user_id != $_SESSION['siteusername']){
						if($ccr_amount >= 0.001){
							$receiver_checker = $dbconn->query("SELECT points FROM users WHERE username='$user_id'");
							if($receiver_checker->num_rows > 0){
								$var_conn = $dbconn;
								$var_conn->set_charset('utf8mb4');
								$sender_points = $var_conn->prepare("SELECT points FROM users WHERE username='".$_SESSION['siteusername']."'");
								$sender_points->execute();
								$sender_points = $sender_points->get_result();
								$sender_points = $sender_points->fetch_object();
								$sender_points = $sender_points->points;
								$receiver_points = $var_conn->prepare("SELECT points FROM users WHERE username='$user_id'");
								$receiver_points->execute();
								$receiver_points = $receiver_points->get_result();
								$receiver_points = $receiver_points->fetch_object();
								$receiver_points = $receiver_points->points;

								if($ccr_amount < $sender_points){
									$sender_points = $sender_points - $ccr_amount * 1;
									$receiver_points = $receiver_points + $ccr_amount * 1;
									$send_crr_token = $dbconn->query("UPDATE users SET points='$sender_points' WHERE username='".$_SESSION['siteusername']."'");
									$receive_crr_token = $dbconn->query("UPDATE users SET points='$receiver_points' WHERE username='$user_id'");
									if($send_crr_token && $receive_crr_token){
										header("Location: profile.php?id=$gid");
									} else {
										$send_crr_error = 'Server Error!';
									}
								}else{
									$ccr_amount_error = "You don't have enough points";
								}
							}else{
								$receiver_checker_error = 'Wrong User Id. Please insert correct User ID';
							}
						}else{
							$ccr_amount_error = 'Please insert Amount more than 0.001';
						}
					}else{
						$ccr_amount_error = "You can't send points to yourself";
					}
                }
			?>
			 
            <br>
            <div class="padding">
                <span id="padding10">
                    <small><a href="/">WeConnectd</a> / <a href="/users.php">Profiles</a> / <a href="/profile.php?id=<?php echo $_GET['id']?>"><?php echo $user['username']; ?></a></small>
                </span><br>
                <div class="topLeft">  
                    <center class="userInfo">
                        <table id="Table2" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr>
                                    <td class="text" width="75" height="75" bgcolor="#ffffff">
                                    <img id="pfp" src="dynamic/pfp/<?php echo $user['pfp']; ?>" border="0">
                                    <h5 class="text-center mt-5"><strong><?php echo $user['account_type']; ?></strong></h5>
                                </td>
                                <td class="text" width="15" height="75" bgcolor="#ffffff">&nbsp;</td>
                                <td style="vertical-align: top;" class="text" width="193" height="75" bgcolor="#ffffff" align="left">
                                    <p style="margin-top: 0px;">
                                        <?php echo htmlspecialchars($user['gender']); ?><br>
                                        <?php echo htmlspecialchars($user['age']); ?> year(s) old<br>
                                        <?php echo htmlspecialchars($user['location']); ?><br>
										Occupation: <?php echo (isset( $user['occupation'] )) ? htmlspecialchars($user['occupation']) : ''; ?><br>
										Relationship Status: <?php echo isset($user['relationship_status']) ? htmlspecialchars($user['relationship_status']) : ''; ?><br>
                                        <?php if(isset($lastLogin)) { echo "<img id='online' src='/static/online.gif'>"; } ?>
                                    </p>
                                    <p>
                                        Last Login:<br>
                                        <?php echo $user['lastlogin'];?><br>
                                        <br>
                                    </p>
									<?php
						if(isset($_SESSION['siteusername']) && $_SESSION['siteusername'] == $user['username']){
							?>
									<p>
										<a style="background: green; padding: 5px 10px; color:#fff;" href="manage.php">
								          Edit Profile
                                        </a>
									</p>
									<?php
						}
									?>
                                </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding-left:3px;">
                                        </td>
                                        </tr>
                                    <tr valign="middle">
                                        <td colspan="3" style="padding-left:3px;">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php echo isset($user['badgesBuffer']) ? $user['badgesBuffer'] : ''; ?><br><br>
						<?php
						if(isset($_SESSION['siteusername']) && $_SESSION['siteusername'] == $user['username']){
							?>
						<div class="song" style="background:#fff; border:none; width:100%; height:600px;">
							<div style="font-size:22px; font-weight:700;"> Coinconnect Radio</div>
                            <small>
								<iframe style="width:100%; height:500px;" src="https://gcp-embeds.datpiff.com/mixtape/1015418/"></iframe>
                            </small>
                        </div>
						 <div class="song" style="background:#fff; border:none; width:100%; height:400px;">
							<div style="font-size:22px; font-weight:700; width:100%;"> Coinconnect TV</div>
                            <small>
								
                            <iframe style="width:100%; height:350px;"
                               src="https://www.youtube.com/embed/8RbsvgcGPsE?list=PLtLkbqLvv34YPr_0aEQefmpr5d3NQT8uu&loop=1">
                            </iframe>
                            </small>
                        </div>
						    <?php
						}
						?>
                    </center>
                    <br>
                    <center>
                    <table class="contactTable omar" style="width:100%;" cellspacing="0" cellpadding="0" bordercolor="#426BBA" border="1">
                        <tbody>
                          <tr>
                            <td class="text tdborder" style="WORD-WRAP:break-word" width="300" height="15" bgcolor="#426BBA" align="left">&nbsp;&nbsp;&nbsp;<span class="whitetext12">Contacting <?php echo                              $user['username']; ?></span></td>
                          </tr>
                          <tr>
                            <td>
                                <table style="width:100%;" cellspacing="0" cellpadding="0" bordercolor="#000000" border="0">
                            <tbody>
						<tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="text" nowrap="" height="5" bgcolor="#ffffff" align="center">
                               <a href=" pm.php?id=<?php echo $user['id']; ?>">
                                  <img src="static/sendMailIcon.gif" border="0" align="middle">
                               </a>
                            </td>
                            <td width="15" height="5" bgcolor="#ffffff">
                            
                            </td>
                            <td class="text" valign="top" nowrap="" height="5" bgcolor="#ffffff" align="center">
                               <a href=" https://weconnectd.com/files/">
                                  <img src="static/forwardMailIcon.gif" border="0" align="middle">
								</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                        <td class="text" valign="top" nowrap="" height="5" bgcolor="#ffffff" align="center">
                            <a href="friends/add.php?id=<?php echo $user['id']; ?>">
                            <img src="static/addFriendIcon.gif" border="0" align="middle"></a>
                        </td>
                        <td width="15" height="5" bgcolor="#ffffff">

                        </td>
                        <td class="text" valign="middle" nowrap="" height="2" bgcolor="#ffffff" align="center">
                            <a href="favorite/add.php?id=<?php echo $user['id']; ?>">
                            <img src="static/addFavoritesIcon.gif" border="0" align="middle"></a>
                        </td>
                        </tr>
                        <tr>
                        <td colspan="3"></td>
                        </tr>
                        <tr>
                        
                        <td class="text" valign="top" nowrap="" height="5" bgcolor="#ffffff" align="center">
                            <?php if($group): ?>
                                <a href="groups/add.php?id=<?php echo $group['id']; ?>">
                                    <img src="static/icon_add_to_group.gif" border="0" align="middle">
                                </a>
                            <?php endif; ?>
                        </td>
                        
                        <td width="15" height="5" bgcolor="#ffffff"></td>
                        <?php
                        if($user['id'] !== $_SESSION['user_id']){
                            ?>
                        <td class="text" width="150" valign="top" nowrap="" height="5" bgcolor="#ffffff" align="center">
                            <a href="friends/block.php?id=<?php echo $user['id']; ?>">
                                <?php
                                $name = getNameFromUser((int)$user['id'], $conn);
                                $user = getNameFromUser((int)$_SESSION['user_id'], $conn);
                                
                                $block = $dbconn->query("SELECT `status` FROM `friends` WHERE `sender`=$user AND `reciever`=$name");
                                if($block->num_rows > 0){
                                    if($block->fetch_assoc()[0]['status'] == 'b'){
                                    echo "jj";
                                    ?>
                                    <div>Unblock</div>
                                    <?php
                                    } else {
                                    ?>
                                    <img src="static/blockuser.gif" border="0" align="middle">
                                    <?php
                                    }
                                } 
                                ?>
                            </a>
                        </td>
                            <?php
                        }
                        ?>
                       
                      </tr>
					  <tr>
					    <td class="text" width="150" valign="top" nowrap="" height="5" bgcolor="#ffffff" align="center">
                            <a href="ghost_chat.php?recieve=<?php echo $user['username']; ?>"><img src="static/ghost-chat.jpg" border="0" width="150" align="middle"></a>
                        </td>
						  
						<td width="15" height="5" bgcolor="#ffffff">

                        </td>
                        <td class="text" valign="middle" nowrap="" height="2" bgcolor="#ffffff" align="center">
                            <a href="https://video-group-meeting.herokuapp.com/room/<?php echo $user['username']; ?>">
                            <img src="static/video.jpg" width="150" border="0" align="middle"></a>
                        </td>
					  </tr>
								

                            <tr>
                            <td></td>
                            </tr>
                            </tbody></table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    
                    <br>
                    <table id="Table1" class="interestsAndDetails" style="width:100%;" cellspacing="0" cellpadding="0" bordercolor="#426BBA" border="1" bgcolor="#6699cc">
                            <tbody>
                                <tr>
                                    <td class="text tdborder" wrap="" valign="middle" bgcolor="#6699cc" align="left">&nbsp;
                                        <span class="whitetext12">
                                            <big><?php echo $user['username']; ?>'s Interests</big>
                                        </span>
                                    </td>
                                    </tr>
                                        <tr valign="top">
                                            <td class="tdborder">
                                    <table id="Table3" style="width:100%" cellspacing="3" cellpadding="3" bordercolor="#000000" border="0" bgcolor="#ffffff" align="center">
                                            <tbody>
                                        <tr id="GeneralRow">
											<td width="100" valign="top" nowrap="" bgcolor="#97BEEC" align="left"><span class="lightbluetext8">Interests</span></td>
											<td id="ProfileGeneral" width="175" bgcolor="#C9E0FA"><?php echo htmlspecialchars($user['interests']); ?></td>
										</tr>
                                        <tr id="MusicRow">
											<td width="100" valign="top" nowrap="" bgcolor="#97BEEC" align="left"><span class="lightbluetext8">Music</span></td>
											<td id="ProfileMusic" width="175" bgcolor="#C9E0FA"><?php echo htmlspecialchars($user['interestsmusic']); ?></td>
										</tr>
										<tr id="PortfolioRow">
											<td width="100" valign="top" nowrap="" bgcolor="#97BEEC" align="left"><span class="lightbluetext8">Crypto Portfolio</span></td>
											<td id="CryptoPortfolio" width="175" bgcolor="#C9E0FA"><?php echo htmlspecialchars($user['cryptoportfolio']); ?></td>
										</tr>
                                        <tr id="Groups">
											<td width="100" valign="top" nowrap="" bgcolor="#97BEEC" align="left"><span class="lightbluetext8">Groups:</span></td>
											<td id="ProfileHeroes" width="175" bgcolor="#C9E0FA"><?php echo "<a href='/links/view.php?id=" . $group['id'] . "'>" . $group['name'] . "</a>"; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    </center>
					
					<?php
						if($_SESSION['siteusername'] == $user['username']){
							?>
					<div class="coinconnect_address">
                        <b>Coinconnect Address:</b><br>
						 &nbsp;&nbsp;
					   <div class="coinadd-box">
						  <form method="post">
							<span style="color:red;"><?php if(isset($coinadd_error)){ echo $coinadd_error; } ?></span>
							<br><input value="<?php echo $user['coinconnect_address']; ?>" type="text" name="coinconnect_address" required="required" style="width:100%; height:30px;"><br>
                            <input type="submit" value="Set" name="coinadd">
                          </form>
					   </div>
                    </div>
					<div class="coinconnect_address">
                        <b>Peel Token:</b><br>
						 &nbsp;&nbsp;
					   <div class="coinadd-box">
						  <form method="post">
							<span style="color:red;"><?php if(isset($peeltoken_error)){ echo $peeltoken_error; } ?></span>
							<br><input value="<?php echo $user['peel_token']; ?>" type="text" name="peel_token" required="required" style="width:100%; height:30px;"><br>
                            <input type="submit" value="Set" name="peeltoken">
                          </form>
					   </div>
                    </div>
					<?php
						} else {
					?>
					<div class="coinconnect_address">
                        <b>Coinconnect Address:</b><br>
						 &nbsp;&nbsp;
					   <div class="coinadd-box">
						  <div class="coinadd-text" id="coinadd"><?php echo $user['coinconnect_address']; ?></div><button id="coinadd-copy">Copy</button>
					   </div>
                    </div>
					<div class="coinconnect_address">
                        <b>Peel Token:</b><br>
						 &nbsp;&nbsp;
					   <div class="coinadd-box">
						  <div class="coinadd-text" id="peeltoken"><?php echo $user['coinconnect_address']; ?></div><button id="peeltoken-copy">Copy</button>
					   </div>
                    </div>
					<?php
						}
							?>
                    <div class="url">
                    <b>Custom URL:</b><br>
						&nbsp;&nbsp;
					   <div class="url-box">
						<div class="url-text" id="url">https://weconnectd.com/<?php echo $user['url']; ?></div><button id="copy">Copy URL</button>
					   </div>
                    </div>
                </div>
                <div class="topRight">
					<div>
                        <h3 class="about">About <?php echo htmlspecialchars($user['username']); ?></h3>
						<div class="bio">
                           <?php echo $user['bio']; ?>
                        </div><br>
					</div>
                    <div>
                        <h3 class="about"><?php echo htmlspecialchars($user['username']); ?> Top 5 Crypto Currencies</h3>
                        <?php
                        $c_curencies = explode(',', $user['top_10_crypto']);
                        $c_curencies = array_filter($c_curencies);
                        ?>
                        <div class="topcriptoforUser">
                            <ol>
                                <?php foreach ($c_curencies as $k => $sing):
                                    if ($k >= 5)
                                        break;
                                    ?>
                                    <li><?php echo $sing; ?></li>
                                <?php endforeach; ?>
                            </ol>
                        </div>
                    </div>
					<div>
                        <h3 class="about"><?php echo htmlspecialchars($user['username']); ?> CRR Points</h3>
						<div class="bio">
                           Points: <?php echo round($user['points'], 8); ?>
                           <br>
                            <?php if($_SESSION['siteusername']) { ?>
                            <form method="post">
                                <span style="color:red;"><?php if(isset($send_crr_error)){ echo $send_crr_error; } ?></span>
                                <br>User Id: &nbsp;<input type="text" name="user_id" required="required" style="height:20px; margin-bottom: 5px">
                                <br>Amount: <input type="text" name="ccr_amount" required="required" style="height:20px; margin-bottom: 5px"><br>
                                <span style="color:red;"><?php if(isset($receiver_checker_error)){ echo $receiver_checker_error; } ?><?php if(isset($ccr_amount_error)){ echo $ccr_amount_error; } ?></span>
                                <br>
                                <input type="submit" style="background: green; margin-top: 5px; padding: 5px 10px; color:#fff; border: none;" value="Send CRR" name="send_crr">
                                <button style="background: green; padding: 5px 10px; color:#fff; border: none;">Swap CRR/CONT</button>
                            </form>
							<?php } ?>
                           <br>
                        </div><br>
					</div>
                    <?php if($user['privacyArray'][0] == "hide") { } else { ?>
                        <div class="blogSection">
                            <h3 class="about"><?php echo htmlspecialchars($user['username']); ?>'s Latest Blog Entry</h3><br><br>
                            <?php 
                                    $stmt = $conn->prepare("SELECT * FROM blogs WHERE author = ? ORDER BY id DESC");
                                    $stmt->bind_param("s", $user['username']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc()) {
                                    if($row['visiblity'] != "Link Only") {
                            ?>
                                <span id="blogPost"><?php echo htmlspecialchars($row['subject']); ?> [<a href="blogs/view.php?id=<?php echo $row['id']; ?>">view more</a>]</span><br>
                            <?php } } ?>
                        </div>
                    <?php } ?>
                    <?php if($user['privacyArray'][1] == "hide") { } else { ?>
                        <div class="about">
                            <b><?php echo htmlspecialchars($user['username']); ?>'s Coinconnect</b>
                        </div><br>
                        <table id="friends">
                            <tbody>
                                <tr>
                                    <th style="width: 60%">User</th>
                                    <th style="width: 40%;text-align:right">Last Login</th>
                                </tr>
                            <?php 
                                $user['friendsUserArray'] = array();
                                $stmt = $conn->prepare("SELECT * FROM friends WHERE reciever = ? AND status = 'a'");
                                $stmt->bind_param("s", $user['username']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc()) { 
                                    array_push($user['friendsUserArray'], $row['sender']);        
                            ?>
                            <tr>
                                <td>
                                    <a href="/profile.php?id=<?php echo getUserFromName($row['sender'], $conn)['id']?>" style="text-decoration: none">
                                        <img style="vertical-align: middle" width="24" height="24" src="/dynamic/pfp/<?php echo getPFPFromUser($row['sender'], $conn); ?>">
                                        <b style="vertical-align: middle"><?php echo $row['sender']; ?></b>
                                    </a>
                                </td>
                                <td><span style="text-align: right;float: right"><?php echo getUserFromName($row['sender'], $conn)['lastlogin']?></span></td>
                            </tr>
                            <?php } ?>
                            <?php 
                                $stmt = $conn->prepare("SELECT * FROM friends WHERE sender = ? AND status = 'a'");
                                $stmt->bind_param("s", $user['username']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc()) {
                                    array_push($user['friendsUserArray'], $row['reciever']);    
                            ?>
                            <tr>
                                <td>
                                    <a href="/profile.php?id=<?php echo getUserFromName($row['reciever'], $conn)['id']?>" style="text-decoration: none">
                                        <img style="vertical-align: middle" width="24" height="24" src="/dynamic/pfp/<?php echo getPFPFromUser($row['reciever'], $conn); ?>">
                                        <b style="vertical-align: middle"><?php echo $row['reciever']; ?></b>
                                    </a>
                                </td>
                                <td><span style="text-align: right;float: right"><?php echo getUserFromName($row['reciever'], $conn)['lastlogin']?></span></td>
                            </tr>
                            <?php }?>
                            </tbody>
                        </table><br>
                    <?php } ?>
                    <div class="about">
                        <b><?php echo htmlspecialchars($user['username']); ?>'s network comments box</b>
                    </div><br>
                    <div class="comment">
                        <form method="post" enctype="multipart/form-data" id="submitform">
                            <?php if(isset($error)) { echo $error . "<br>"; } ?>
                            <b>Comment</b> <br>
                                <?php if($user['privacyArray'][2] != "friend") { ?> 
							        Upload Image <input type="file" name="cimage">
                                    <textarea cols="32" id="com" placeholder="Comment" name="comment"></textarea><br><small><a href="https://www.markdownguide.org/basic-syntax">Markdown</a> & Emoticons are allowed.</small><br> 
                                    <script src="/js/commd.js"></script>
                                    <input type="submit" value="Post" data-callback="onLogin">
                                <?php } else { ?> This user only allows friends to comment.<?php } ?>
                        </form>
                    </div><br>
                    <table id="userWall">
                        <tbody>
                            <?php
                                $stmt = $conn->prepare("SELECT * FROM comments WHERE toid = ? AND status = 'p' ORDER BY id DESC");
                                $stmt->bind_param("i", $_GET['id']);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while($row = $result->fetch_assoc()) { 
                            ?>
                            <tr>
                                <td class="tableLeft">
                                    <a href="profile.php?id=<?php echo getIDFromUser($row['author'], $conn); ?>"><div><b><center><?php echo $row['author']; ?></center></b></div><img src="/dynamic/pfp/<?php echo getPFPFromUser($row['author'], $conn); ?>"></a>
                                </td>
                                <td class="tableRight">
                                    <div><b class="date"><?php echo $row['date']; ?></b> <img src="/static/silk/award-star-gold-2-icon.png"> <?php if(isset($user['ownAccount'])) { echo "<a href='/lib/unpin.php?id=" . $row['id'] . "'>[unpin]</a> <a href='/lib/deletecomment.php?id=" . $row['id'] . "'><i class='fa-solid fa-trash'></i></a>"; } ?></div>
									<div>
										<?php
									if(!empty($row['image'])){
										?>
										<img style="width: 100%; max-height: 300px; margin-top:20px" src="/comment_image/<?php echo $row['image']; ?>">
										<?php
									}
									?>
									    <p><?php echo $row['comment']; ?></p>
									</div>
                                </td>
                            </tr>
                            <?php } ?>
                            <?php
                                $stmt = $conn->prepare("SELECT * FROM comments WHERE toid = ? AND status = 'n' ORDER BY id DESC LIMIT 100");
                                $stmt->bind_param("i", $_GET['id']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $rows = mysqli_num_rows($result); 
                                
                                echo "<small>[" . $rows . "/100]</small>";
                                while($row = $result->fetch_assoc()) { 
                            ?>
                            <tr>
                                <td class="tableLeft">
                                    <a href="profile.php?id=<?php echo getIDFromUser($row['author'], $conn); ?>"><div><b><center><?php echo $row['author']; ?></center></b></div><img src="/dynamic/pfp/<?php echo getPFPFromUser($row['author'], $conn); ?>"></a>
                                </td>
                                <td class="tableRight">
                                    <div><b class="date"><?php echo $row['date']; ?></b> <?php if($row['author'] == $_SESSION['siteusername'] && !isset($user['ownAccount'])) { echo " <a href='/lib/delcommentfroma.php?id=" . $row['id'] . "'><i class='fa-solid fa-trash'></i></a>"; } ?><?php if(isset($user['ownAccount'])) { echo "<a href='/lib/pin.php?id=" . $row['id'] . "'>[pin]</a> <a href='/lib/deletecomment.php?id=" . $row['id'] . "'><i class='fa-solid fa-trash'></i></a>"; } ?></div>
									<div>
										<?php
									if(!empty($row['image'])){
										?>
										<img style="width: 100%; max-height: 300px; margin-top:20px" src="/comment_image/<?php echo $row['image']; ?>">
										<?php
									}
									?>
										<p><?php echo $row['comment']; ?></p>
									</div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <?php require("static/footer.php"); ?>
        <script src="js/custom.js"></script>
    </body>
</html>