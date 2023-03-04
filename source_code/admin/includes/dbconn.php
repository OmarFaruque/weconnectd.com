<?php
$servername = "localhost";
$user = "developer";
$pass = "P6ot2@z4";
$dbname = "lniulpmgc_weconnect";

// Create connection
$conn = new mysqli($servername, $user, $pass, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$site_domain = 'https://beta.alfrik.com';
?>