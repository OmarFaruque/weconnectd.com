<?php
$servername1 = "localhost";
$user1 = "developer";
$pass1 = "P6ot2@z4";
$dbname1 = "lniulpmgc_weconnect";
$post_id =$_GET['postid'];
// Create connection
$dbconn = new mysqli($servername1, $user1, $pass1, $dbname1);
// Check connection
if ($dbconn->connect_error) {
  die("Connection failed: " . $dbconn->connect_error);
}

$sql = "SELECT * FROM forum_post WHERE id='$post_id'";
$result = $dbconn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo $oldView = $row["views"] ;
  }
} else {
  echo "Uknown";
}


$newView = ($oldView+1);

$sql2 = "UPDATE forum_post SET views='$newView' WHERE id='$post_id'";

if ($dbconn->query($sql2) === TRUE) {
  echo "";
} else {
  echo "";
}






?>