<?php session_start(); ?>
<?php 
include 'includes/dbconn.php';
$page = 'banner';
?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>
<?php
if(isset($_GET['banner_id'])){
    $banner_id = $_GET['banner_id'];
    $edit = $conn->query("SELECT * FROM banner WHERE id='$banner_id'");
    if($edit->num_rows > 0){
        $edit_d = $edit->fetch_array();
    } else {
         echo "<script>
        alert('Invalid Request');
        location.href = 'manage-banner.php';
        </script>";
    }
    if (isset($_POST['submit'])) {
      $image = $_FILES['image'];
      $imagename = $image['name'];
      $imagetype = $image['type'];
      $imagetmp_name = $image['tmp_name'];
      $imageerror = $image['error'];
      $imagesize = $image['size'];

      $image_ext = explode('.',$imagename);
      $for_image = strtolower(end($image_ext));
      $image_in = array('jpg', 'png', 'jpeg');

      $image_path = 'upload/banner_img/' . $imagename;
      move_uploaded_file($imagetmp_name, $image_path);
  
      $save_data_in_db = "UPDATE `banner` SET `banner`='$imagename' WHERE id='$banner_id'";
  
      $result = $conn->query($save_data_in_db);
      if ($result === TRUE) {
        echo "<script>
        alert('Updated Successfully');
        location.href = 'manage-banner.php?banner_id=$banner_id';
        </script>";
      } else {
        echo "<script>
        alert('Something Went Wrong!');
        location.href = 'manage-banner.php?banner_id=$banner_id';
        </script>";
      }
    }
} else {
    if (isset($_POST['submit'])) {
      $image = $_FILES['image'];
      $imagename = $image['name'];
      $imagetype = $image['type'];
      $imagetmp_name = $image['tmp_name'];
      $imageerror = $image['error'];
      $imagesize = $image['size'];

      $image_ext = explode('.',$imagename);
      $for_image = strtolower(end($image_ext));
      $image_in = array('jpg', 'png', 'jpeg');

      $image_path = 'upload/banner_img/' . $imagename;
      move_uploaded_file($imagetmp_name, $image_path);
  
      $save_data_in_db = "INSERT INTO `banner` SET `banner`='$imagename'";
  
      $result = $conn->query($save_data_in_db);
      if ($result === TRUE) {
        echo "<script>
        alert('Added Successfully');
        location.href = 'manage-banner.php';
        </script>";
      } else {
        echo "<script>
        alert('Something Went Wrong!');
        location.href = 'manage-banner.php';
        </script>";
      }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Banner</title>
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
            <h1 class="m-0">Manage Banner</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Manage Banner</li>
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
                <h3 class="card-title"><?php if(isset($banner_id)){ echo "Update"; }else { echo "Add"; } ?> Banner</h3>
                
                <?php if(isset($banner_id)){ ?> <a href="manage-banner.php" class="btn btn-warning float-right">Add Banner</a> <?php } ?>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="card-body"> 
                <?php
                if(isset($_GET['banner_id'])){
                    ?>
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Banner</label>
                    <div class="col-sm-10">
                      <img style="width:100%; height:400px;" src="upload/banner_img/<?php echo $edit_d['banner']; ?>">
                    </div>
                  </div>
                    <?php
                }
                ?>
                  
                  <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Upload Banner</label>
                    <div class="col-sm-10">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image" id="exampleInputFile" required>
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>                                                                                    
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-info float-right"><?php if(isset($banner_id)){ echo "Update"; }else { echo "Add"; } ?> Banner</button>
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">View Team</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
<?php
  $d = $conn->query("SELECT * FROM banner ORDER BY `id` DESC");
?>
                    <?php
                    if($d->num_rows > 0){
                      $i=0;
                      while($data = $d->fetch_assoc()){
                        $i++;
                        ?>
                  <tr>
                    <td><?php echo $i ?></td>
                    <td> <img src="upload/banner_img/<?php echo $data['banner']; ?>" alt="" height="50" width="50">  </td>
                    <td>
                      <a href="manage-banner.php?banner_id=<?php echo $data['id']; ?>"><i class="fas fa-edit text-warning"></i></a>
                      <a href="delete.php?file_id=<?php echo $data['id'] ?>&file=banner"><i class="fas fa-trash-alt text-danger"></i></a>
                    </td>
                  </tr>  
                        <?php
                      }
                    }
                    ?>             
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
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
<script>
$(document).ready(function() {

$('#continent').on('change', function() {
  var continent_id = $(this).val();
  $.ajax({
    url: "files/ajax.php",
    method: "POST",
    data: {
      continent_id: continent_id
    },
    dataType: "html",
    cache: false,
    success: function(data){
    $("#country").html(data);
    }
  });
});    
});
</script>
</body>
</html>
<?php
} else {
  header("Location: index.php");
}
?>