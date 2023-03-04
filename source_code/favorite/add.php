<?php 
/**
 * Add to favorit
 */

require( "../static/config.inc.php");
require("../static/conn.php");
require("../lib/profile.php");


$name = getNameFromUser((int)$_GET['id'], $conn);


if( !isset($_SESSION['user_id']) ) {
    die("You are not logged in or you did not put in an argument");
}

if( !isset($_SESSION['siteusername'])) {
    die("You are not logged in or you did not put in an argument");
}

if(!isset($_GET['id']))
    die("You have no access to visit this page.");

if($name == $_SESSION['siteusername']) {
    die("stop trying to friend yourself");
}


$stmt = $conn->prepare("SELECT f.`id` FROM my_favorite f LEFT JOIN users u ON f.`user_id` = u.`id` WHERE u.`username` = ? AND f.`favorit_id`=?");
$stmt->bind_param("si", $_SESSION['siteusername'], $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();


if($result->num_rows >= 1) die('User already is in your favorite.');
$stmt->close();

$stmt = $conn->prepare("INSERT INTO my_favorite (`user_id`, `favorit_id`) VALUES (?, ?)");
$stmt->bind_param("ii", $_SESSION['user_id'], $_GET['id']);

$stmt->execute();
$stmt->close();

header("Location: ../profile.php?id=" . $_GET['id']);
?>