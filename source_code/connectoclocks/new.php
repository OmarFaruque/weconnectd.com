<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/conn.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/lib/profile.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $config['pr_title']; ?></title>
        <link rel="stylesheet" href="/static/css/required.css"> 
        <script src='https://www.google.com/recaptcha/api.js' async defer></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
        <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
        <script src="/onLogin.js"></script>
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
        </style>
    </head>
    <body>
        <div class="container">
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/header.php"); 

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if(!isset($_SESSION['siteusername'])){ $error = "you are not logged in"; goto skipcomment; }
				$video = $_FILES['video'];
				
				$video_name = $video['name'];
				$video_tmp_name = $video['tmp_name'];
				$video_size = $video['size'];
				$video_type = $video['type'];
				
				$video_valid_ext = array('mp4', 'mov', 'wmv', 'avi', 'mkv');
				$video_ext = strtolower(pathinfo($video_name, PATHINFO_EXTENSION));
				
				if(in_array($video_ext, $video_valid_ext)){
					
					if ($video_size < (40000*1024*5)) // Max File Size: 40000KB
					{
                    $uploaddir = '../uploads/videos/'; //assigns upload directory
                    $uploadfile = $uploaddir . $video_name; //assigns upload directory and file name
                   
                    if (move_uploaded_file($video_tmp_name, $uploadfile)) { //checks file tmp_name for successful upload
						
                //if(!$_POST['video']){ $error = "your blog body cannot be blank"; goto skipcomment; }
                //if(strlen($_POST['comment']) > 10000){ $error = "your comment must be shorter than 10000 characters"; goto skipcomment; }
                //if(!isset($_POST['g-recaptcha-response'])){ $error = "captcha validation failed"; goto skipcomment; }
                //if(!validateCaptcha($config['recaptcha_secret'], $_POST['g-recaptcha-response'])) { $error = "captcha validation failed"; goto skipcomment; }
                if($_POST['allowcomments'] == "true") {
                    $stmt = $conn->prepare("INSERT INTO `videos` (author, filename, title) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $_SESSION['siteusername'], $video_name, $title);
                    $title = htmlspecialchars($_POST['subject']);
                    $stmt->execute();
                    $stmt->close();
                    logDB($_SESSION['siteusername'] . " has made a blog named " . $text, $conn);
                } else {
                    $stmt = $conn->prepare("INSERT INTO `videos` (author, filename, title, comment) VALUES (?, ?, ?, 'n')");
                    $stmt->bind_param("sss", $_SESSION['siteusername'], $video_name, $title);
                    $title = htmlspecialchars($_POST['subject']);
                    $stmt->execute();
                    $stmt->close();
                    logDB($_SESSION['siteusername'] . " has Uploaded a video named " . $title, $conn);
                }
						} else {
                          $error =  "File upload failed";
                        }
				    } else {
						$error = "Video should be less than 40MB";
					}
			  } else {
				$error = "only mp4, mov, wmv, avi, mkv file are valid"; 
			  }
                skipcomment:
            }
            ?>
            <br>
            <div class="padding">
                <span id="padding10">
                    <small>WeConnectd / ConnectO'Clocks / New</small>
                </span><br>
                <div class="customtopLeft">  
                    <div class="splashBlue">
                        Remember to make sure that your ConnectO'Clock post is not inapropriate or harrases a person or a group of people! Have fun.
                    </div><br>
                </div>
                <div class="customtopRight">
                    <div class="comment">
                        <form method="post" enctype="multipart/form-data" id="submitform">
                            <?php if(isset($error)) { echo $error . "<br>"; } ?>
                            <b>ConnectO'Clock Post</b> <br>
                            <br><input placeholder="Subject" type="text" name="subject" required="required" size="63"><br>
                            <input name="video" type="file" >
						    <br>
                            <input type="checkbox" id="allow" name="allowcomments" value="true"> <small>Allow Comments</small><br>
                            <script>
                            var simplemde = new SimpleMDE({ element: document.getElementById("desc") });
                            </script>
                            <input type="submit" value="Post" data-callback="onLogin">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/footer.php"); ?>
    </body>
</html>