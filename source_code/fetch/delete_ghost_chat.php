<?php require("../static/config.inc.php"); ?>
<?php require("../static/conn.php"); ?>
<?php require("../lib/profile.php"); ?>
<?php require("../includes/dbconn.php"); ?>
<?php
if(isset($_SESSION['siteusername'])){
 if(isset($_POST['reciever']) AND isset($_POST['channel'])){
    $reciever = $_POST['reciever'];
    $self = $_SESSION['siteusername'];
	$channel = $_POST['channel'];
    
   $seen_c = $dbconn->query("SELECT * FROM ghost_chat WHERE `reciever`='$reciever' AND `channel`='$channel' AND `status`=1");
	if($seen_c->num_rows > 0){
		$array = array();
        while($blog_d = $seen_c->fetch_assoc()){
			$chatid = $blog_d['chatid'];
            $message = $blog_d['message']; 
            $blog_data = array(
                              "id"=>$chatid, 
                              "message"=>$message
                            );
            array_push($array, $blog_data);
			$set_seen = $dbconn->query("DELETE FROM ghost_chat WHERE `chatid`='$chatid'");
        }
            $result = array("status"=>"succuss", "data"=>$array);
            echo json_encode($result);
		   
    }else {
        $result = array(
                "status"=>"error",
                "error"=>"There is more results"
                );
        echo json_encode($result);
    }
    
 } else {
    $results = array("status"=>"error", "error"=>"Sorry! Server Error.");
    echo json_encode($results);
 }
}

?>