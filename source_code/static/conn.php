<?php
if (session_status() === PHP_SESSION_NONE) session_start();


//$conn = mysqli_connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);


// Create connection
$conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed 1: " . $conn->connect_error);
    return $conn;
}

require_once($_SESSION['ROOT_PATH'] . '/db/create-db.php');
?>


<?php
if (!function_exists('validateCaptcha')) {
	function validateCaptcha($privatekey, $response)
	{
		$responseData = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $privatekey . '&response=' . $response));
		return $responseData->success;
	}
}
?>