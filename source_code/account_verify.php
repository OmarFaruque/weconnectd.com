<?php
if(isset($_GET['username']) && isset($_GET['key'])){
	require("includes/dbconn.php");
	$username = $_GET['username'];
	$key = $_GET['key'];
	$sql = $dbconn->query("SELECT * FROM users WHERE username='$username'");
	if($sql->num_rows == 1){
		$data = $sql->fetch_array();
		if($key === $data['activation_key']){
			$up = $dbconn->query("UPDATE users set user_status='1' WHERE username='$username'");
			if($up){
				$msg = 'Your Account ia Ready to Login. PLease Login...';
			    header('Location: login.php?msg='.$msg);
			} else {
				$msg = 'Server Error...';
			    header('Location: login.php?msg='.$msg);
			}
		} else {
		   echo "Invalid Key";
		}
	}else {
		echo "Email don't exist";
	}
}else{
	echo "Invalid Reques";
}

?>