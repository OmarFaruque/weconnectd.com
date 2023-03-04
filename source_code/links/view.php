<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/conn.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/lib/profile.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/includes/dbconn.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $config['pr_title']; ?></title>
        <link rel="stylesheet" href="https://weconnectd.com/static/css/required.css"> 
        <script src='https://www.google.com/recaptcha/api.js' async defer></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
        <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
        <script src="/onLogin.js"></script>
		
		<style>
			.group_info{
				padding: 20px 10px;
                display: flex;
			}
			.group_img{
				width: 200px;
				
			}
			.group_img img{
				width: 150px;
				height: 150px;
			}
			.name_group{
				font-size: 18px;
                font-weight: 850;
			}
			.about_group{
				padding: 10px 5px 10px 0px;
                max-width: 400px;
			}
			.owner{
				background: bisque;
                padding: 10px;
			}
			.owner a{
				display:flex;
			}
			.owner a span{
				font-size: 12px;
                font-weight: 600;
                color: #fff;
                background: #bf360c;
                padding: 1px 3px;
				border-radius: 5px;
			}
			.owner a div{
				margin: 10px 5px;
			}
			.owner a img{
				width: 40px;
				height: 40px;
				border-radius: 50%;
			}
			.join-btn{
				margin: 10px 0px
			}
			.join-btn button{
				color: #fff;
    background: #43a047;
    border: 1px solid #fff;
    padding: 5px 20px;
    border-radius: 15px;
    box-shadow: 1px 1px 5px 2px #43a047;
			}
			.join-btn div{
				    padding: 10px 10px;
    color: red;
    font-size: 13px;
    background: bisque;
    font-weight: 600;
				margin:5px 0px
			}
			.all-group-member{
				margin: 0px 0px 20px 0px;
			}
			.memeber{
				display: flex;
			}
			.memeber .mr a{
				color: #fff;
    background: red;
    border: 1px solid #fff;
    padding: 5px 20px;
    border-radius: 15px;
				margin-top:10px
			}
			.memeber .mr-1{
				display:flex;
			}
			.memeber .mr-1 a{
				color: #fff;
    background: red;
    border: 1px solid #fff;
    padding: 5px 20px;
    border-radius: 15px;
				margin-top:10px
			}
			.memeber .ml{
				width: calc(100% - 100px);
			}
			.memeber .ml-1{
				width: calc(100% - 200px);
			}
			.memeber a img{
				width: 40px;
				height: 40px;
				border-radius: 50%;
			}
			.memeber a{
				display: flex;
				border-bottom: 1px solid #d1d1d1;
				margin-bottom: 1.5rem !important;
				padding: 10px;
			}
			.memeber a div{
				margin: 10px 5px;
			}
			.heading-1{
				background: #B45A5A;
                padding: 5px;
                color: #fff;
                font-weight: 700;
			}
		</style>
        <?php 
            if(!isset($_SESSION['siteusername'])) { redirectToLogin(); }
            $user = getUserFromName($_SESSION['siteusername'], $conn); 
		?>
        <?php $group = getGroupFromId((int)$_GET['id'], $conn); 
        if($_SESSION['siteusername'] == $group['owner']) { $ownsGroup = true; } else { $ownsGroup = false; }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['comment']) {
            if(!isset($_SESSION['siteusername'])){ $error = "you are not logged in"; goto skipcomment; }
            if(!$_POST['comment']){ $error = "your comment cannot be blank"; goto skipcomment; }
            if(strlen($_POST['comment']) > 500){ $error = "your comment must be shorter than 500 characters"; goto skipcomment; }
            //if(!isset($_POST['g-recaptcha-response'])){ $error = "captcha validation failed"; goto skipcomment; }
            //if(!validateCaptcha($config['recaptcha_secret'], $_POST['g-recaptcha-response'])) { $error = "captcha validation failed"; goto skipcomment; }

            $stmt = $conn->prepare("INSERT INTO `groupcomments` (toid, comment, author) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $_GET['id'], $text, $_SESSION['siteusername']);
            $text = htmlspecialchars($_POST['comment']);
            $stmt->execute();
            $stmt->close();
            skipcomment: 
        } else if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['announce']) {
            echo "q";
        }
        ?>
        <?php $user = getUserFromName($group['owner'], $conn); ?>
        <meta property="og:title" content="<?php echo $group['name']; ?>" />
        <meta property="og:description" content="<?php echo preg_replace("/\"/", "&quot;", $group['description']); ?>" />
        <meta property="og:image" content="https://weconnectd.com/dynamic/groups/<?php echo $group['pic']; ?>" />
        <style>
            .customtopLeft {
                float: left;
                width: calc( 40% - 20px );
                padding: 10px;
            }

            .customtopRight {
                float: right;
                width: calc( 60% - 20px );
                padding: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/header.php"); ?>
            <br>
            <div class="padding">
                <span id="padding10">
                    <small><a href="/">Weconnectd</a> / <a href="/groups/">Groups</a> / <a href="/groups/view.php?id=<?php echo $_GET['id']?>"><?php echo htmlspecialchars($group['name']); ?></a></small>
                </span><br>
				    <div class="group_info">
						<div class="group_img">
							<img src="/dynamic/groups/<?php echo $group['pic']; ?>"><br>
						</div>
						<div class="group_details">
						   <div class="name_group"> 
							  <?php echo htmlspecialchars($group['name']); ?>
						   </div>
						   <div class="about_group">
							  <?php echo htmlspecialchars($group['description']); ?>
						   </div>
						   <div class="owner">
						     <a href="/profile.php?id=<?php echo getIDFromUser($group['owner'], $conn); ?>">
								 <img src="/dynamic/pfp/<?php echo $dbconn->query("SELECT * FROM users WHERE username='".$group['owner']."'")->fetch_array()['pfp']; ?>"><br>
							     <div><b><?php echo $group['owner']; ?></b><span>Owner</span></div>
						     </a>
							</div>
							<div class="join-btn">
                           <?php if($group['private'] != "p") { ?>
						   
								   <?php
$check = $dbconn->query("SELECT * FROM join_group WHERE groups='".$group['id']."' AND users='".$_SESSION['siteusername']."'");
if($check->num_rows > 0){
	$check_data = $check->fetch_array();
	if($check_data['status'] == 1){
		?>
		<a href="join.php?group_id=<?php echo $group['id']; ?>">
			<button>Leave Group</button>
		</a>
		<?php
	} else {
		?>
		<div> You have sent request to join group. Please wait group owner in add you* </div>
		<a href="join.php?group_id=<?php echo $group['id']; ?>">
			<button>Cancel Request</button>
		</a>
		<?php
	}
} else {
	?>
		<a href="join.php?group_id=<?php echo $group['id']; ?>">
			<button>Join Group</button>
		</a>
	<?php
}			   
		                            ?>
							   
					       <?php } else { ?> 
						   <b>This group is private.</b> 
					      <?php } ?>
							</div>
						</div>		
					</div>
                <div class="customtopLeft"> 
					<div class="all-group-member">
                        <div class="heading-1">Members</div>
                        <?php 
                            $stmt = $conn->prepare("SELECT * FROM join_group WHERE groups = ? AND status='1' ORDER BY id DESC");
                            $stmt->bind_param("i", $_GET['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while($row = $result->fetch_assoc()) { 
								$gu = $conn->prepare("SELECT * FROM users WHERE username = ?");
								$gu->bind_param("s", $row['users']);
                                $gu->execute();
                                $gu_result = $gu->get_result();
								if($gu_result->num_rows > 0){
									$gud = $gu_result->fetch_array();
								}
                        ?>
						<div class="memeber">
                            <a class="ml" href="/profile.php?id=<?php echo getIDFromUser($gud['username'], $conn); ?>">
								<img src="/dynamic/pfp/<?php echo $dbconn->query("SELECT * FROM users WHERE username='".$gud['username']."'")->fetch_array()['pfp']; ?>">
								<div><?php echo $gud['username']; ?></div>
								
							</a> 
							<div class='mr'>
							<?php if($ownsGroup == true) { echo " <a href='exile.php?user=".$row['users']."&group_id=".$_GET['id']."'>exile</a>"; } ?>
							</div>
						</div>
                        <?php } ?>
                    </div>

                    <!--<div class="userInfoBlog">
                        <div class="contacting">
                            <div class="contactingTopbar">
                                Contacting
                            </div>
                            <div class="padding">
                                <ul>
                                    <li><a href="pm.php?id=<?php echo $user['id']; ?>">Message</a></li>
                                    <li><a href="/friends/add.php?id=<?php echo $user['id']; ?>">Friend</a></li>
                                    <li><a href="block.php?id=<?php echo $user['id']; ?>">Block </a></li>
                                    <li><a href="report.php?id=<?php echo $user['id']; ?>">Report</a></li>
                                </ul>
                            </div>
                        </div><br>
                        <center>
                            <small>[<a href="like.php?id=<?php echo $blog['id']; ?>">like</a>] [<a href="dislike.php?id=<?php echo $blog['id']; ?>">dislike</a>]
                            <br>[<?php echo getLikesFromBlog($blog['id'], $conn); ?> likes] [<?php echo getDislikesFromBlog($blog['id'], $conn); ?> dislikes] </small><br>
                        </center>
                    </div>-->
                </div>
                <div class="customtopRight">
                    <?php
                        if($ownsGroup == true) {
                    ?>
                        <div class="splashBlue">
                            <a href="https://www.spacemy.xyz/groups/join.php?id=109">Copy this to invite your friends to your group.</a>
                        </div><br>
					<div class="all-group-member">
                        <div class="heading-1">Group Request</div>
                        <?php 
                            $stmt = $conn->prepare("SELECT * FROM join_group WHERE groups = ? AND status='0' ORDER BY id DESC");
                            $stmt->bind_param("i", $_GET['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
							
                            while($row = $result->fetch_assoc()) { 
								$gu = $conn->prepare("SELECT * FROM users WHERE username = ?");
								$gu->bind_param("s", $row['users']);
                                $gu->execute();
                                $gu_result = $gu->get_result();
								if($gu_result->num_rows > 0){
									$gud = $gu_result->fetch_array();
								}
                        ?>
						<div class="memeber">
                            <a class="ml-1" href="/profile.php?id=<?php echo getIDFromUser($gud['username'], $conn); ?>">
								<img src="/dynamic/pfp/<?php echo $dbconn->query("SELECT * FROM users WHERE username='".$gud['username']."'")->fetch_array()['pfp']; ?>">
								<div><?php echo $gud['username']; ?></div>
								
							</a> 
							<div class='mr-1'>
							  <div><a style="background:green;" href="active-user.php?user=<?php echo $row['users']; ?>&group_id=<?php echo $_GET['id']; ?>">Accept</a></div>
							  <div><a href="exile.php?user=<?php echo $row['users']; ?>&group_id=<?php echo $_GET['id']; ?>">Delete</a></div>
							</div>
						</div>
                        <?php 
							} 
						?>
                    </div>
                    <?php } ?>
					
					<?php
					$user_for_chat = $dbconn->query("SELECT id FROM join_group WHERE users='".$_SESSION['siteusername']."' AND  groups='".$_GET['id']."' AND status='1'");
					if($user_for_chat->num_rows > 0 OR $ownsGroup == true){
						?>
					 <div class="comment">
                        <form method="post" enctype="multipart/form-data" id="submitform">
                            <?php if(isset($error)) { echo $error . "<br>"; } ?>
                            <b>Reply</b><br>
                            <textarea cols="39" placeholder="Comment" id="com" name="comment"></textarea><br><small><a href="https://www.markdownguide.org/basic-syntax">Markdown</a> & Emoticons are allowed.</small><br>
                            <script>
                            var simplemde = new SimpleMDE({ element: document.getElementById("com") });
                            </script>
                            <input type="submit" value="Post" class="g-recaptcha" data-sitekey="<?php echo $config['recaptcha_sitekey']; ?>" data-callback="onLogin">
                        </form>
                    </div>
					<br>
					<table id="userWall">
                        <tbody>
                            <?php
                                $stmt = $conn->prepare("SELECT * FROM groupcomments WHERE toid = ? ORDER BY id DESC");
                                $stmt->bind_param("i", $_GET['id']);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while($row = $result->fetch_assoc()) { 
                            ?>
                            <tr>
                                <td class="tableLeft">
                                    <a href="/profile.php?id=<?php echo getIDFromUser($row['author'], $conn); ?>"><div><b><center><?php echo $row['author']; ?></center></b></div><img src="/dynamic/pfp/<?php echo getPFPFromUser($row['author'], $conn); ?>"></a>
                                </td>
                                <td class="tableRight">
                                    <div><b class="date"><?php echo $row['date']; ?></b></div><div><p><?php echo $row['comment']; ?></p></div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
					<?php
					}
					?>
                </div>
            </div>
        </div>
        <br>
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/footer.php"); ?>
    </body>
</html>