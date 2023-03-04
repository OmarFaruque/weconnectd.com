<?php if (session_status() === PHP_SESSION_NONE) session_start();

if(isset($_SESSION['siteusername'])) {
	$_SESSION = [];
	session_destroy();
}
header("Location: /");
die();