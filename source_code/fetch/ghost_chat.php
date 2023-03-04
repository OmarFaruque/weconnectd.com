<?php require("../static/config.inc.php"); ?>
<?php require("../static/conn.php"); ?>
<?php require("../lib/profile.php"); ?>
<?php require("../includes/dbconn.php"); ?>
<?php
if(isset($_SESSION['siteusername'])){
 if(isset($_POST['ghost_message']) and isset($_POST['reciever']) and isset($_POST['channel'])){
    $ghost_message = str_replace("'", "&apos;", htmlspecialchars($_POST['ghost_message']));
    $reciever = htmlspecialchars($_POST['reciever']);
    $sender = $_SESSION['siteusername'];
	$channel = $_POST['channel'];
	$date = date('YmdHis');
	if(isset($_FILES['sendimage'])){
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
    $new_photo_name = $reciever.'_channel_'.$channel.'_'.$date.'.'.$extension;
    $image_path = '../chat_images/'. $new_photo_name;
    
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
	 
	 // insert data
    $add_comment = $conn->query("INSERT INTO `ghost_chat` (`sender`, `reciever`, `message`, `channel`, `file`) VALUES ('$sender', '$reciever', '$ghost_message', '$channel', '$new_photo_name')");
    if($add_comment === TRUE){
        $results = array("status"=>"succuss", "sender"=>$sender, "reciever"=>$reciever, "message"=>$ghost_message, "file"=>$new_photo_name);
        echo json_encode($results);
    } else {
        $results = array("status"=>"error", "error"=>"Something Went Wrong!");
        echo json_encode($results);
    }
    
 } else {
    $results = array("status"=>"error", "error"=>"Sorry! Server Error.");
    echo json_encode($results);
 }
}

?>