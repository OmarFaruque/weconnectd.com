<?php session_start(); ?>
<?php 
include 'includes/dbconn.php'; 
$page = 'top_packages';
?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>
<?php
if (isset($_POST['submit'])) {
    $location = $_POST['location'];
    $price_rate = $_POST['price_rate'];
    $status = $_POST['status'];
    $image = $_FILES['image'];
  
    $imagename = $image['name'];
    $imagetype = $image['type'];
    $imagetmp_name = $image['tmp_name'];
    $imageerror = $image['error'];
    $imagesize = $image['size'];
  
    $image_ext = explode('.',$imagename);
    $for_image = strtolower(end($image_ext));
    $image_in = array('jpg', 'png', 'jpeg');

    $image_path = 'upload/toppackages_img/' . $imagename;
    move_uploaded_file($imagetmp_name, $image_path);
  
      $save_data_in_db = "INSERT INTO `top_packages` (`location`, `image`, `price_rate`, `status`) VALUES ('$location', '$imagename', '$price_rate', '$status')";
  
      $result = $conn->query($save_data_in_db);
      if ($result === TRUE) {
        echo "<script>
        alert('Updated Successfully');
        location.href = 'add-toppackages.php';
        </script>";
      } else {
        echo "<script>
        alert('Something Went Wrong!');
        location.href = 'add-toppackages.php';
        </script>";
        //echo $conn->error;
      }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Top Packages</title>
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
            <h1 class="m-0">Manage Top Packages</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Add Top Packages</li>
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
                <h3 class="card-title">Add Top Packages</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Upload Image</label>
                    <div class="col-sm-10">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div> 
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Location</label> 
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="Location" name="location">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Price Rate</label> 
                    <div class="col-sm-10">
                      <input type="number" class="form-control" id="Price" name="price_rate">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="status" class="col-sm-2 col-form-label">Status</label> 
                    <div class="col-sm-10" style="display: flex; padding-top: 10px;">
                        <div class="custom-control custom-radio mr-5">
                          <input class="custom-control-input" type="radio" id="customRadio1" name="status" value="Active" checked>
                          <label for="customRadio1" class="custom-control-label">Active</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="customRadio2" value="status" name="front_page">
                          <label for="customRadio2" class="custom-control-label">Inactive</label>
                        </div>
                    </div>
                  </div>                                    
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-info float-right">Add Package</button>
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
} else {
  header("Location: index.php");
}
?>