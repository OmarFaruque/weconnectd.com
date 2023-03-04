<?php session_start(); ?>
<?php
include 'includes/dbconn.php';
$page = $_GET['file'];
?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>
<?php
$id = $_GET['file_id'];
$file_name = $_GET['file'];

if($file_name === 'admin'){
    $check_admin = $conn->query("SELECT * FROM admin WHERE id='$id'");
    if($check_admin->num_rows == 1){
        $get_admin = $check_admin->fetch_array();
        if($get_admin['admin_type'] === 'admin'){
            echo "<script>
            alert('Admin can not Delete');
            location.href = document.referrer;
            </script>";
        } else {
            $delete_file = "DELETE FROM $file_name WHERE id='$id'";
            $delete_query = $conn->query($delete_file);
        }
    }
} else {
    $delete_file = "DELETE FROM $file_name WHERE id='$id'";
    $delete_query = $conn->query($delete_file);
}

if ($delete_query === TRUE){
    echo "<script>
    location.href = document.referrer;
    </script>";
} else {
    echo "Error deleting record: " . $conn->error;
}

}else{
  header("Location: index.php");
}
?>