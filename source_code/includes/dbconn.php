<?php
$servername1 = "localhost";
$user1 = "weconnec_omar";
$pass1 = "Mahmud123698";
$dbname1 = "weconnec_main";



// Remove after developer
// Use only for local development
$dbname1 = "lniulpmgc_weconnect2";
$user1 = "root";
$pass1 = "";

// Create connection
$dbconn = new mysqli($servername1, $user1, $pass1, $dbname1);
// Check connection
if ($dbconn->connect_error) {
  die("Connection failed 2: " . $dbconn->connect_error);
}
?>