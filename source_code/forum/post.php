<?php 
ini_set('display_errors', 1);
if (session_status() === PHP_SESSION_NONE)
    session_start();

require($_SESSION['ROOT_PATH'] . "/static/config.inc.php"); 
require($_SESSION['ROOT_PATH'] . "/static/conn.php"); 
require($_SESSION['ROOT_PATH'] . "/includes/dbconn.php"); 
require($_SESSION['ROOT_PATH'] . "/lib/profile.php");


if(isset($_GET['id'])){
	$post_id = $_GET['id'];
	$post = $dbconn->query("SELECT * FROM forum_post WHERE id='$post_id'");
	if($post->num_rows > 0){
		$post_data = $post->fetch_array();
?>	
		
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $config['pr_title']; ?></title>
        <link rel="stylesheet" href="<?php echo ROOT_URL; ?>static/css/required.css"> 
        <link rel="stylesheet" href="<?php echo ROOT_URL; ?>static/css/table2.css"> 
		<link rel="stylesheet" href="<?php echo ROOT_URL; ?>forum/assets/css/posts.css"> 

    </head>
	<body>
        <div class="container">
            <?php require($_SESSION['ROOT_PATH'] . "/static/header.php"); ?>
<?php
if(isset ($_SESSION['siteusername'])){
	if(isset($_POST['reply'])){
		$comment = $_POST['comment'];
		$forum_id = $post_id;
		$creator = getIDFromUser($_SESSION['siteusername'], $conn);
		
    $date = date('YmdHis');
if(isset($_FILES['sendimage']) AND !empty($_FILES['sendimage']['name'])){
    $photo_name = $_FILES['sendimage']['name'];
    $photo_tmpname = $_FILES['sendimage']['tmp_name'];
    $photo_size = $_FILES['sendimage']['size'];
		
    function compressImage($source, $destination, $quality) {
        list($width,$height) = getimagesize($source);

        $nwidth = $width;
        $nheight = $height;
        $newimage = imagecreatetruecolor($nwidth, $nheight);
        $info = getimagesize($source);
       if ($info['mime'] == 'image/jpeg'){ 
         $image = imagecreatefromjpeg($source);
       } elseif ($info['mime'] == 'image/gif') {
         $image = imagecreatefromgif($source);
       } elseif ($info['mime'] == 'image/png'){ 
         $image = imagecreatefrompng($source);
       }
       imagecopyresized($newimage, $image, 0, 0, 0, 0, $nwidth, $nheight, $width, $height);
       imagejpeg($newimage, $destination, $quality);
    }
		
	$extension = pathinfo($photo_name, PATHINFO_EXTENSION);
    $new_photo_name = $creator.'_sender_'.$date.'.'.$extension;
    $image_path = 'images/'. $new_photo_name;
    
     // Compress Image
  if($imagesize <= 1024){
      $quality = '100';
  } else if($imagesize > 1024 AND $imagesize <= 1024*1024*2){
      $quality = '70';
  }else if($imagesize > 1024*2 AND $imagesize <= 1024*1024*2){
      $quality = '60';
  }else if($imagesize > 1024*3 AND $imagesize <= 1024*1024*4){
      $quality = '50';
  }else if($imagesize > 1024*4 AND $imagesize <= 1024*1024*5){
      $quality = '40';
  }else if($imagesize > 1024*5 AND $imagesize <= 1024*1024*6){
      $quality = '30';
  }else if($imagesize > 1024*6 AND $imagesize <= 1024*1024*7){
      $quality = '20';
  }else{
      $quality = '10';
  }
    compressImage($photo_tmpname,$image_path,$quality);
} else {
		$new_photo_name = '';
}
		$insert = $dbconn->query("INSERT INTO forum_post_reply(`comment`, `gallery`, `creator`, `forum_id`) VALUES('$comment', '$new_photo_name', '$creator', '$forum_id')");
		if($insert){
			echo "<script>
			location.href = 'post.php?id=$post_id';
			</script>";
		}else{
			echo "<script>
			location.href = 'post.php?id=$post_id&error=Server Error';
			</script>";
		}
	}
}
?>	
            <br>
             <div class="padding">
                <small><a href="/">SpaceMy</a> / <a href="/forums/">Forums</a></small><br>
                <div class="customtopLeft">  
                    <div class="sideblog">
						<h3><a href="https://weconnectd.com/forum/">Forum</a></h3>
                        <ul>
                            <ul>
							<?php
							$fc = $conn->query("SELECT * FROM forum_category");
							if($fc->num_rows>0){
								while($fc_d = $fc->fetch_assoc()){
									?>
							 <li><a href="https://weconnectd.com/forum/?category=<?php echo str_replace(' ', '_', $fc_d['name']); ?>" class="man"><?php echo $fc_d['name']; ?></a></li>
							        <?php
								}
							}
							?>
                        </ul>
                        </ul>
                    </div>
                </div>
                <div class="customtopRight">  
                    <div class="splashBlue">
                        <h1 id="noMargin">WeConnectd Forums</h1>
                    </div>
					<a href="add-post.php">
						<div class="add-btn">
							+ Add Post
						</div>
					</a>
					<br>
    <div id="posts">
		<div class="forum-post">
			<div class="title">
				<span><?php echo $post_data['title']; ?></span>
				<span><small><i><?php echo date('jS M y', strtotime($post_data['update_on'])); ?></i></small></span>
			</div>
			<div class="cate-cret">
				<div class="cate">
					<a href="https://weconnectd.com/forum/?category=<?php echo str_replace(' ','_',$post_data['category']); ?>"><?php echo $post_data['category']; ?></a>
				</div>
				<div class="cret">
					<a href="https://weconnectd.com/profile.php?id=<?php echo $post_data['creator']; ?>"><?php echo $dbconn->query("SELECT * FROM users WHERE id='".$post_data['creator']."'")->fetch_array()['username']; ?></a>
				</div>
			</div>
			<div class="content">
				<?php echo $post_data['content']; ?>
			</div>
			<div class="send-reply">
				<form method="POST" enctype="multipart/form-data">
					<div class="reply-input">
						<textarea name="comment" required></textarea>
						<input name="sendimage" type="file">
					</div>
					<button type="submit" name="reply">Reply</button>
				</form>
			</div>
			<div class="replies">
				<div class="title">Reply</div>
				<small>Viewed By <span><?php echo $post_data['views'];?></span> People</small>
				<?php
		            $replies = $dbconn->query("SELECT * FROM forum_post_reply WHERE forum_id='$post_id'");
		            if($replies->num_rows > 0){
						while($fetch_replies = $replies->fetch_assoc()){
							// echo 'comments <br/><pre>';
							// print_r($fetch_replies);
							// echo '</pre>';
							?>
								<div class="item">
									<div class="creator">
										<img src="">
										<div class="username"></div>
									</div>
									<?php
										if(!empty($fetch_replies['gallery'])){
										?>
									<div class="images">
										<img src="images/<?php echo $fetch_replies['gallery']; ?>">
									</div>
										<?php
										}
									?>
									<div class="comment">
										<div class="date-time">
											<span><small><i><?php echo date('jS M y h:i A', strtotime($fetch_replies['update_on'])); ?></i></small></span>
										</div>
										<?php echo $fetch_replies['comment']; $replyid= $fetch_replies['id']; $creatorId=$fetch_replies['creator'];  ?> <br>

										<?php
											$creator = isset($_SESSION['siteusername']) ? getIDFromUser($_SESSION['siteusername'], $conn) : false;
											if ($creator==$creatorId){
												echo "<a href='deletereply.php?replyid=$replyid;' class='btnr'><button class='btnr'>Delete Comment</button></a>";
											}
											
									
										?>
									</div>
									
								</div>
				            <?php
						}
					} else {
					}	
		         ?>
			</div>
		</div>
    </div>
                </div>
            </div>
        </div>
        <br>
        <?php require($_SESSION['ROOT_PATH'] . "/static/footer.php"); ?>
		<script>setTimeout(
    function() {
		id = <?php echo $post_id ;?>;
	    url = "<?php echo ROOT_URL; ?>forum/view.php?postid="+id;
		fetch(url);
    }, 4000);</script>
    </body>
</html>

<?php
    } else {
		echo 'Invalid Request!';
	}
} else {
	echo 'Invalid Request!';
}
		
?>


