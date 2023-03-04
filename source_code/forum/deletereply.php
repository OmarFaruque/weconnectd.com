<?php
$servername1 = "localhost";
$user1 = "developer";
$pass1 = "P6ot2@z4";
$dbname1 = "lniulpmgc_weconnect";

// Create connection
$dbconn = new mysqli($servername1, $user1, $pass1, $dbname1);
// Check connection
if ($dbconn->connect_error) {
  die("Connection failed: " . $dbconn->connect_error);
}
$id = $_GET['replyid'];
$sql = "DELETE FROM forum_post_reply WHERE id='$id'";

if (mysqli_query($dbconn, $sql)) {
  header("location:javascript://history.go(-1)");
} else {
 header("location:javascript://history.go(-1)");
}

mysqli_close($conn);
?>