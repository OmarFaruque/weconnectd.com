<?php session_start(); ?>
<?php
include 'includes/dbconn.php';
$page = 'admin';
?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>
  <?php
if(isset($_GET['admin_id'])){
    $admin_id = $_GET['admin_id'];
    $edit = $conn->query("SELECT * FROM `admin` WHERE id='$admin_id'");
    if($edit->num_rows == 1){
        $edit_d = $edit->fetch_array();
?>
<?php

$firstname_error = $lastname_error = $email_error = $mobile_error = $password1_error = $password2_error = "";
// Create registration.....
if (isset($_POST['submit'])) {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $photo = $_FILES['photo']['name'];
    $password1 = $_POST["password"];
    $password2 = $_POST["cpassword"];

    if(isset($_POST['permission'])){
        $permission_all = $_POST['permission'];
        $permission = implode(",",$permission_all);
    }else{
        $permission = '';
    }
    

    if(!empty($photo)){
        $photo_tmp = $_FILES['photo']['tmp_name'];
        $image_path = 'upload/admin_img/' . $photo;
        move_uploaded_file($photo_tmp, $image_path);
        $save_photo = $photo;
    } else{
        $save_photo = $edit_d['photo'];
    }

    // for username
    if (empty($name)) {
        $name_error = "Name is required";
        header("Location: add-admin.php?error=$name_error");
    } elseif (empty($email)) {
        $email_error = "Email is required";
        header("Location: add-admin.php?error=$email_error");
    } else {
        if(!empty($password1)){
            if ($password1 != $password2) {
                $password2_error = "Password didn't match!";
                header("Location: add-admin.php?error=$password2_error");
            } else {
              $sqluser = "SELECT * FROM `admin` WHERE email = '$email'";
              if ($conn->query($sqluser) === True) {
                $email_error = "This email is already exist!";
                header("Location: add-admin.php?error=$email_error");
              } else {
                $hash_password = password_hash("$password1", PASSWORD_DEFAULT);  
                $sql = "UPDATE `admin` SET `name`='$name', `email`='$email', `photo`='$save_photo', `password`='$hash_password', `permission`='$permission' WHERE id='$admin_id'";
                
                if ($conn->query($sql) === TRUE) {
                    echo "<script>
                    alert('Added Successfully');
                    location.href = 'edit-admin.php?admin_id=$admin_id';
                    </script>";
                } else {
                  echo $error = "Error: " . $sql . "<br>" . $conn->error;
                }
              }
            }
        }else{
            $sqluser = "SELECT * FROM `admin` WHERE email = '$email'";
            if ($conn->query($sqluser) === True) {
              $email_error = "This email is already exist!";
              header("Location: add-admin.php?error=$email_error");
            } else {
              $hash_password = password_hash("$password1", PASSWORD_DEFAULT);  
              $sql = "UPDATE `admin` SET `name`='$name', `email`='$email', `photo`='$save_photo', `permission`='$permission'  WHERE id='$admin_id'";
              
              if ($conn->query($sql) === TRUE) {
                  echo "<script>
                  alert('Added Successfully');
                  location.href = 'edit-admin.php?admin_id=$admin_id';
                  </script>";
              } else {
                echo $error = "Error: " . $sql . "<br>" . $conn->error;
              }
            }
        }
    }    
}  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ALN | Salons</title>

  <?php include 'includes/filescripts.php'; ?>
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- header -->
  <?php include 'includes/header.php'; ?>
  <!-- header -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Admin</h1>
            <?php if(isset($_GET['error'])){ echo $_GET['error']; } ?>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Add Sub-Admin</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Sub-Admin</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="name" id="name" value="<?php echo $edit_d['name']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" name="email" id="email" value="<?php echo $edit_d['email']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Photo</label>
                    <div class="col-sm-10">
                        <img src="upload/admin_img/<?php echo $edit_d['photo']; ?>" width="100" height="100">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Change Photo</label>
                    <div class="col-sm-10">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="photo">
                        <label class="custom-file-label" for="image">Choose file</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
                        <h4 style="font-size: 18px;
    font-weight: 700;
    color: red;
    border-left: 2px solid;
    border-bottom: 2px solid;
    border-top: 1px solid;
    border-right: 1px solid;
    padding: 10px;">Add Permission...</h4>
                    </div>
                  </div>
                  <div class="form-group row">
                    <?php
                    $ser = $conn->query("SHOW TABLES FROM $dbname");
                    if($ser){
                      $i=0;
                      while($ser_d = $ser->fetch_array()){
                        $i++;
                        ?>
                        
                    <div class="col-md-6">
                      <div class="custom-control custom-checkbox">
                        <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="checkbox" <?php $permission_all = explode(',', $edit_d['permission']);
                                                                                                                                            if(in_array($ser_d[0], $permission_all)){
                                                                                                                                                echo 'checked';
                                                                                                                                            }?> value="<?php echo $ser_d[0]; ?>" name="permission[]" id="customCheckbox<?php echo $i; ?>">
                        <label for="customCheckbox<?php echo $i; ?>" class="custom-control-label">Manage <?php $table = str_replace('_', ' ', $ser_d[0]);
                                                                                                        echo ucwords($table); ?></label>
                      </div>
                    </div>
                        <?php
                      }
                    }
                    ?> 
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
                        <h4 style="font-size: 18px;
    font-weight: 700;
    color: red;
    border-left: 2px solid;
    border-bottom: 2px solid;
    border-top: 1px solid;
    border-right: 1px solid;
    padding: 10px;">Change Password...</h4>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" name="password" id="password">
                    </div>
                  </div>    
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Confirm Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" name="cpassword" id="cpassword">
                    </div>
                  </div>
                                                                                              
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-info float-right">Submit</button>
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
        </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php include 'includes/footer.php' ?>
  <!-- /Main Footer -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php include 'includes/js.php' ?>
<!-- /REQUIRED SCRIPTS -->
</body>
</html>
<?php
    }else{
        header("Location: $_SERVER[HTTP_REFERER]");
    }
}else{
    header("Location: $_SERVER[HTTP_REFERER]");
}
?>
<?php
} else {
  header("Location: index.php");
}
?>