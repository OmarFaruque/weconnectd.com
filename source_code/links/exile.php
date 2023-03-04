<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/conn.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/lib/profile.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/includes/dbconn.php"); ?>
<?php
$user = $_GET['user'];
$group_id = $_GET['group_id']; 

$group = $dbconn->query("SELECT * FROM groups WHERE id='$group_id'");
if($group->num_rows > 0){
	$group_data = $group->fetch_array();
	$group_owner = $group_data['owner'];
	if($group_owner == $_SESSION['siteusername']){
		$du = $dbconn->query("DELETE FROM join_group WHERE users='$user' AND groups='$group_id'");
		if($du){
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}else{
			echo "Something Went Wrong";
		}
	} else {
		echo "Only Owner can do it";
	}
} else {
	echo "Invalid Request";
}
?>