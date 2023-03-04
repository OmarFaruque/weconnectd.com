<?php 
/**
 * Add to the group
 */

require( "../static/config.inc.php");
require("../static/conn.php");
require("../lib/profile.php");


$name = getNameFromUser((int)$_GET['id'], $conn);

if(!isset($_SESSION['siteusername']) || !isset($_GET['id'])) {
    die("You are not logged in or you did not put in an argument");
}

if($name == $_SESSION['siteusername']) {
    die("stop trying to friend yourself");
}


$stmt = $conn->prepare("SELECT * FROM join_group WHERE groups = ? AND users = ?");
$stmt->bind_param("ss", $_GET['id'], $name);
$stmt->execute();
$result = $stmt->get_result();

// echo 'results <br/><pre>';
// print_r($result);
// echo '</pre>';

if($result->num_rows >= 1) die('User already a member in this group.');
$stmt->close();

$stmt = $conn->prepare("INSERT INTO join_group (groups, users, status) VALUES (?, ?, 1)");
$stmt->bind_param("ss", $_GET['id'], $name);

$stmt->execute();
$stmt->close();

header("Location: ../profile.php?id=" . $_GET['id']);
?>