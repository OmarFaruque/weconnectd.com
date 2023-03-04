<?php
$auth_email = $_SESSION['auth_email'];
$admin = $conn->query("SELECT * FROM `admin` WHERE `email`='$auth_email'");
if($admin->num_rows == 1){
    $admin_data = $admin->fetch_array();
    $admin_name = $admin_data['name'];
    $admin_email = $admin_data['email'];
    $admin_photo = $admin_data['photo'];
    $admin_type = $admin_data['admin_type'];
    if($admin_type == 'admin'){
        $auth = TRUE;
    } else if($admin_type == 'subadmin') {
        $permission = explode(',', $admin_data['permission']);
        if(in_array($page, $permission)){
            $auth = TRUE;
        } elseif($page == 'dashboard'){
            $auth = TRUE;
        } else{
            $auth = FALSE;
        }
    } else {
        echo "<script>location.href='index.php';</script>";
    }
} else{
    echo "<script>location.href='index.php';</script>";
}
?>
