<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/conn.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/lib/profile.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $config['pr_title']; ?></title>
        <?php $blog = getInfoFromSportsBlog((int)$_GET['id'], $conn); ?>
        <link rel="stylesheet" href="/static/css/required.css"> 
        <link rel="stylesheet" href="/lib/getCSS.php?id=<?php echo getIDFromUser($blog['author'], $conn); ?>"> 
        <?php $user = getUserFromName($blog['author'], $conn); ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
        <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
        <script src="/onLogin.js"></script>
        <meta property="og:title" content="<?php echo $blog['subject'] . " by " . $blog['author']; ?>" />
        <meta property="og:description" content="<?php echo preg_replace("/\"/", "&quot;", $blog['message']); ?>" />
        <style>
            .customtopLeft {
                float: left;
                width: calc( 30% - 20px );
                padding: 10px;
            }

            .customtopRight {
                float: right;
                width: calc( 70% - 20px );
                padding: 10px;
            }
			.image img{
				width: 100%;
			}
			.coinconnect_address{
				background: #faddc0;
                padding: 5px 10px;
                margin: 0px 0px 10px 0px;
			}
			#coinadd-copy{
				    margin: 0px 0px 0px 10px;
                    background: green;
                    color: #fff;
			}
			.coinadd-box{
				display:flex;
			}
			.coinconnect_address h3{
				background: #8B0000;
                color: #fff;
                padding: 2px 5px;
			}
        </style>
    </head>
    <body>
        <div class="container">
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/header.php"); 

            $lastLoginReal = (int)strtotime($user['lastlogin']);
            if(time() - $lastLoginReal < 15 * 60) {
                $lastLogin = true;
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if(!isset($_SESSION['siteusername'])){ $error = "you are not logged in"; goto skipcomment; }
                if(!$_POST['comment']){ $error = "your comment cannot be blank"; goto skipcomment; }
                if(strlen($_POST['comment']) > 500){ $error = "your comment must be shorter than 500 characters"; goto skipcomment; }
                //if(!isset($_POST['g-recaptcha-response'])){ $error = "captcha validation failed"; goto skipcomment; }
                //if(!validateCaptcha($config['recaptcha_secret'], $_POST['g-recaptcha-response'])) { $error = "captcha validation failed"; goto skipcomment; }

                $stmt = $conn->prepare("INSERT INTO `sports_blogcomments` (toid, comment, author) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $_GET['id'], $text, $_SESSION['siteusername']);
                $text = htmlspecialchars($_POST['comment']);
                $stmt->execute();
                $stmt->close();
                skipcomment:
            }
            ?>
            <br>
            <div class="padding">
                <span id="padding10">
                    <small><a href="/">WeConnectd</a> / <a href="/blogs/">Blogs</a> / <a href="/blogs/view.php?id=<?php echo $_GET['id']?>"><?php echo $blog['subject']; ?></a></small>
                </span><br>
                <div class="customtopLeft">  
                    <div class="splashBlue">
                        Remember to make sure that your reply does not break the terms of service!
                    </div><br>
                    <center>Written by <b><a href="/profile.php?id=<?php echo getIDFromUser($blog['author'], $conn); ?>"><?php echo htmlspecialchars($blog['author']); ?></a></b>
                        <br><img id="pfp" style="width: 10em;" src="/dynamic/pfp/<?php echo getPFPFromUser($blog['author'], $conn) ?>"><br><?php if(isset($lastLogin)) { echo "<img id='online' src='/static/online.gif'>"; } ?><br>
                    </center>
                    <div class="userInfoBlog">
                        <?php echo $user['bio']; ?><br>
                        <b>Gender: </b><?php echo $user['gender']; ?><br>
                        <b>Age: </b><?php echo $user['age']; ?><br>
                        <b>Location: </b><?php echo $user['location']; ?><br>
                        <b>Last Login: </b><?php echo $user['lastlogin']; ?><br><br>
                        <div class="contacting">
                            <div class="contactingTopbar">
                                Contacting <?php echo $user['username']; ?>
                            </div>
                            <div class="padding-contacts">
                                <ul>
                                    <li><a href="pm.php?id=<?php echo $user['id']; ?>">Message</a></li>
                                    <li><a href="/friends/add.php?id=<?php echo $user['id']; ?>">Friend</a></li>
                                    <li><a href="block.php?id=<?php echo $user['id']; ?>">Block </a></li>
                                    <li><a href="report.php?id=<?php echo $user['id']; ?>">Report</a></li>
                                </ul>
                            </div>
                        </div><br>
                        <center>
                            <?php $likes = (int)getLikesFromSportsBlog($blog['id'], $conn); ?>
                            <?php $dislikes = (int)getDislikesFromSportsBlog($blog['id'], $conn); ?>
                            <?php
                                $total = $likes + $dislikes;
                                if($total > 0)
                                    $percent = round(($likes / $total) * 100);
                                else 
                                    $percent = 100;
                            ?>
                            <div id="rating_score" class="rating" style="display: inline-block;">Rating:<strong><?php echo $percent; ?>%</strong></div>
                            <div id="rate_btns" style="display: inline-block;">
                                <div id="rate_yes"><a href="like.php?id=<?php echo (int)$_GET['id']; ?>">Booyah !</a></div>
                                <div id="rate_no"><a href="dislike.php?id=<?php echo (int)$_GET['id']; ?>">No Way !</a></div>
                            </div>
                        </center><br>
                        <b>All Blogs</b>
                        <ul class="blogsList">
                        <?php 
                            $stmt = $conn->prepare("SELECT * FROM sports WHERE author = ? ORDER BY id DESC");
                            $stmt->bind_param("s", $blog['author']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while($row = $result->fetch_assoc()) { 
                        ?>
                            <li><a href="view.php?id=<?php echo $row['id']; ?>"><?php echo $row['subject']; ?></a></li>
                        <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="customtopRight">
                    <div class="blogCont">
                        <a href="view.php?id=<?php echo $blog['id']; ?>"><h1 id="noMargin"><?php echo $blog['subject']; ?></h1></a>
						<div class="image">
							<img src="images/<?php echo $blog['image']; ?>" alt="<?php echo $blog['subject']; ?>">
						</div>
                        <?php echo $blog['message']; ?>
                    </div><br>
					<div class="coinconnect_address">
						<h3>Tip Me!</h3>
                        <b>Coinconnect Address:</b><br>
						 &nbsp;&nbsp;
					   <div class="coinadd-box">
						  <div class="coinadd-text" id="coinadd"><?php echo $user['coinconnect_address']; ?></div><button id="coinadd-copy">Copy</button>
					   </div>
                    </div>
                    <div class="comment">
                        <ul id="do_links">
                            <li><a href="javascript:LoginAlert(Resources.login_alert);" class="bulletin_this">Bulletin This</a></li>
                            <li><a href="/blogs/new.php?text=check out this blog! https://www.spacemy.xyz/blogs/view.php?id=<?php echo $blog['id']; ?>" class="blog_this">Blog This</a></li>
                            <li><a href="mailto:example@example.com?body=Check out this blog: /blogs/view.php?id=<?php echo $blog['id']; ?>" class="email_this">Email This</a></li>
                            <li id="profile"><a href="javascript:LoginAlert(Resources.login_alert);" class="add_to_profile">Add to Profile</a></li>
                            <li id="favorite"><a href="javascript:LoginAlert(Resources.login_alert);" class="favorite_this">Save to favorites</a></li>
                            <li id="inappropriate"></li>
                        </ul>
                        <br><br><br>
                    </div>
                    <br><br>
                    <div class="comment">
                        <form method="post" enctype="multipart/form-data" id="submitform">
                            <?php if($blog['comment'] == "a") {?>
                                <?php if(isset($error)) { echo $error . "<br>"; } ?>
                                <b>Comment</b><br>
                                <textarea rows="4" cols="48" placeholder="Comment" id="com" name="comment"></textarea><br><small><a href="https://www.markdownguide.org/basic-syntax">Markdown</a> & Emoticons are allowed.</small><br>
                                <script src="/js/commd.js"></script>
                                <input type="submit" value="Reply" class="g-recaptcha" data-sitekey="<?php echo $config['recaptcha_sitekey']; ?>" data-callback="onLogin">
                            <?php } else {?>
                                This user has disabled comments.
                            <?php } ?>
                        </form>
                    </div><br>
                    <table id="userWall">
                        <tbody>
                            <?php
                                $stmt = $conn->prepare("SELECT * FROM sports_blogcomments WHERE toid = ? ORDER BY id DESC");
                                $stmt->bind_param("i", $_GET['id']);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while($row = $result->fetch_assoc()) { 
                            ?>
                            <tr>
                                <td class="tableLeft">
                                    <a href="/profile.php?id=<?php echo getIDFromUser($row['author'], $conn); ?>"><div><b><center><?php echo $row['author']; ?></center></b></div><img src="/dynamic/pfp/<?php echo getPFPFromUser($row['author'], $conn); ?>"></a><br>
                                </td>
                                <td class="tableRight">
                                    <div><b class="date"><?php echo $row['date']; ?></b></div><div><p><?php echo $row['comment']; ?></p></div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/footer.php"); ?>
		<script>
document.addEventListener('DOMContentLoaded', function(){
 async function copyTargetText(e) {
  try {
    await navigator.clipboard.writeText(e.innerText);
  } catch (err) {
    console.error("Failed to copy: ", err);
  }
}
document.querySelector("#coinadd-copy").addEventListener("click", () => {
  const e = document.getElementById('coinadd');
  copyTargetText(e);
  /*document.getElementById('copy-alert').style.display = 'block';
  setTimeout(() => {
    document.getElementById('copy-alert').style.display = 'none';
  }, 1500);*/
});	
	
})
		</script>
    </body>
</html>
