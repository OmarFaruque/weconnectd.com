<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/conn.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/lib/profile.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/includes/dbconn.php"); ?>
<?php 
if(isset($_SESSION['siteusername'])) { 

    if(isset($_GET['group_id'])){
       $groups = $_GET['group_id'];
       $check = $dbconn->query("SELECT * FROM join_group WHERE groups='$groups' AND users='".$_SESSION['siteusername']."'");
       if($check->num_rows > 0){
	      $dg = $dbconn->query("DELETE FROM join_group WHERE groups='$groups' AND users='".$_SESSION['siteusername']."'");
	      if($dg){
		     header('Location: ' . $_SERVER['HTTP_REFERER']);
	      } else {
		     echo "Something Went Wrong!";
	      }
       } else {
	      $ag = $dbconn->query("INSERT INTO join_group (`groups`, `users`) VALUES ('$groups', '".$_SESSION['siteusername']."')");
	      if($ag){
		     header('Location: ' . $_SERVER['HTTP_REFERER']);
	      } else {
		     echo "Something Went Wrong!";
	      }
       }
    } else {
	   echo "Invalid Request";
    }
} else {
	header("Location: ../login.php"); 
}
?>