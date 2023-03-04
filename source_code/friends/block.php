<?php 

require( "../static/config.inc.php"); 
require("../static/conn.php");
require("../lib/profile.php");


$name = getNameFromUser((int)$_GET['id'], $conn);
$user = getNameFromUser((int)$_SESSION['user_id'], $conn);

if(!isset($_SESSION['siteusername']) || !isset($_GET['id'])) {
    die("You are not logged in or you did not put in an argument");
}

if($name == $_SESSION['siteusername']) {
    die("stop trying to block yourself");
}

$check = $conn->query("SELECT `status` FROM `friends` WHERE sender=$user AND reciever=$name");
if($check->num_rows > 0){
    $check_data = $check->fetch_assoc();
    $check_data_status = $check_data['status'];
    if($check_data_status == 'b'){
        $edit = $conn->prepare("UPDATE friends SET status='b' WHERE sender=$user AND reciever=$name");
    } else {
        $edit = $conn->prepare("UPDATE friends SET status='p' WHERE sender=$user AND reciever=$name");
    }
} else {
    echo 'Invalid Request';
}

header("Location: $_SERVER[HTTP_REFERER]");