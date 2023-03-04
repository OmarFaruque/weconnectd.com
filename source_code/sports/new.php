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
        .dis-img input{
    width: 0.1px;
	height: 0.1px;
	opacity: 0;
	overflow: hidden;
	position: absolute;
	z-index: -1;

} 
.dis-img label{
        width: 100%;
    padding: 5px 10px;
    background: #8B0000;
    color: #fff;
    text-align: center;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    border-top: 2px solid #fff;
}
#preview-image{
	width:100%;
}
				.dis-img{
					margin: 10px 0px;
				}
				.subject{
					margin:10px 0px;
					
				}
				.subject input{
					margin:0px;
					padding: 0px;
					width: 100%;
					height: 30px;
                    border: none;
				}
    </style>
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
                if(!$_POST['comment']){ $error = "your blog body cannot be blank"; goto skipcomment; }
                if(strlen($_POST['comment']) > 10000){ $error = "your comment must be shorter than 10000 characters"; goto skipcomment; }
                //if(!isset($_POST['g-recaptcha-response'])){ $error = "captcha validation failed"; goto skipcomment; }
                //if(!validateCaptcha($config['recaptcha_secret'], $_POST['g-recaptcha-response'])) { $error = "captcha validation failed"; goto skipcomment; }
				$author = $_SESSION['siteusername'];
  $datex = date('YmdHis');
				
  $image = $_FILES['image'];
				
  $imagename = $image['name'];
  $imagetype = $image['type'];
  $imagetmp_name = $image['tmp_name'];
  $imageerror = $image['error'];
  $imagesize = $image['size'];

  $image_ext = explode('.', $imagename);
  $for_image = strtolower(end($image_ext));
  $image_in = array('jpg', 'png', 'jpeg', 'jfif', 'gif');
  $extension = pathinfo($imagename, PATHINFO_EXTENSION);
  $newimagename = $author.'_blog_'.$datex.'.'.$extension;
				
  if(in_array($for_image,$image_in)) {
      $image_path = 'images/' . $newimagename;
      move_uploaded_file($imagetmp_name, $image_path);
  } else {
	  $error = "Image Should be JPG, PNG, JPEF, JFIF, GIF Only!"; goto skipcomment;
  }
                if($_POST['allowcomments'] == "true") {
                    $stmt = $conn->prepare("INSERT INTO `sports` (author, message, subject, image) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $_SESSION['siteusername'], $text, $subject, $newimagename);
                    $text = htmlspecialchars($_POST['comment']);
                    $subject = htmlspecialchars($_POST['subject']);
                    $stmt->execute();
                    $stmt->close();
                    logDB($_SESSION['siteusername'] . " has made a blog named " . $text, $conn);
                } else {
                    $stmt = $conn->prepare("INSERT INTO `sports` (author, message, subject, comment, image) VALUES (?, ?, ?, 'n', ?)");
                    $stmt->bind_param("ssss", $_SESSION['siteusername'], $text, $subject, $newimagename);
                    $text = htmlspecialchars($_POST['comment']);
                    $subject = htmlspecialchars($_POST['subject']);
                    $stmt->execute();
                    $stmt->close();
                    logDB($_SESSION['siteusername'] . " has made a blog named " . $text, $conn);
                }
                skipcomment:
            }
            ?>
            <br>
            <div class="padding">
                <span id="padding10">
                    <small>Weconnectd / Sports / New</small>
                </span><br>
                <div class="customtopLeft">  
                    <div class="splashBlue">
                        Remember to make sure that your blog post is not innapropriate or harrases a person or a group of people! Have fun.
                    </div><br>
                </div>
                <div class="customtopRight">
                    <div class="comment">
                        <form method="post" enctype="multipart/form-data" id="submitform">
                            <?php if(isset($error)) { echo $error . "<br>"; } ?>
                            <b>Blog Post</b> <br>
                            <div class="subject">
							   <input placeholder="Subject" type="text" name="subject" required>
							</div>
							<div class="dis-img">
								<div class="blog-post-image" style="padding:0px 0px;">
                                   <img id="preview-image" class="img-fluid" src="#" alt="">
                                </div>
                                <input type="file" class="form-control" name="image" id="image" onchange="PreviewImage();" required>
                                <label for="image">Upload Image</label>
							</div>
							<div class="text">
                                <textarea cols="48" id="desc" placeholder="Body" name="comment"><?php if(isset($_GET['text'])) { echo $_GET['text']; } ?></textarea>
							</div>	
								<br><small><a href="https://www.markdownguide.org/basic-syntax">Markdown</a> & Emoticons are allowed.</small><br>
                            <input type="checkbox" id="allow" name="allowcomments" value="true"> <small>Allow Comments</small><br>
                            <script>
                            var simplemde = new SimpleMDE({ element: document.getElementById("desc") });
                            </script>
                            <script src="/js/bloglimit.js"></script>
                            <input type="submit" value="Post" data-callback="onLogin">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/footer.php"); ?>
<script type="text/javascript">

    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("image").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("preview-image").src = oFREvent.target.result;
        };
    };

</script>
    </body>
</html>