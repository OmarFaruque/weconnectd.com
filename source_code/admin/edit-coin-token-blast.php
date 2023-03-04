<?php session_start(); ?>
<?php 
include 'includes/dbconn.php'; 
$page = 'coin_token_blast';
?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>

<?php
if(isset($_GET['coin_id'])){
    $coin_id = $_GET['coin_id'];
    $edit = $conn->query("SELECT * FROM coin_token_blast WHERE id='$coin_id'");
    if($edit->num_rows == 1){
        $edit_d = $edit->fetch_array();
?>


<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
	$website = $_POST['website'];
    $market = $_POST['market'];
    $image = $_FILES['image'];
  
    $imagename = $image['name'];
    $imagetype = $image['type'];
    $imagetmp_name = $image['tmp_name'];
    $imageerror = $image['error'];
    $imagesize = $image['size'];

    $image_ext = explode('.',$imagename);
    $for_image = strtolower(end($image_ext));
    $image_in = array('jpg', 'png', 'jpeg');

  

  if(!empty($imagename)){
    $image_path = 'upload/coin_token_img/' . $imagename;
    move_uploaded_file($imagetmp_name, $image_path);
    $save_data_in_db = "UPDATE `coin_token_blast` SET `name`='$name', `website`='$website', `icon`='$imagename', `market`='$market' WHERE id='$coin_id'";
  } else{
    $save_data_in_db = "UPDATE `coin_token_blast` SET `name`='$name', `website`='$website', `market`='$market' WHERE id='$coin_id'";
  }

  
    $result = $conn->query($save_data_in_db);
    if ($result === TRUE) {
      echo "<script>
      alert('Updated Successfully');
      location.href = 'edit-coin-token-blast.php?coin_id=$coin_id';
      </script>";
    } else {
      echo "<script>
      alert('Something Went Wrong!');
      location.href = 'edit-coin-token-blast.php?coin_id=$coin_id';
      </script>";
    }
  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Update Coin Token Blast</title>
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
            <h1 class="m-0">Manage Coin Token Blast</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Manage Coin Token Blast</li>
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
                <h3 class="card-title">Update Coin Token Blast</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Name</label> 
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="name" name="name" value="<?php echo $edit_d['name']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Website</label> 
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="website" name="website" value="<?php echo $edit_d['website']; ?>" required>
                    </div>
				  </div>
					<div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Market</label> 
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="market" name="market" value="<?php echo $edit_d['market']; ?>" required>
                    </div>
				  </div>
                  <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Icon</label>
                    <div class="col-sm-10">
                        <img style="width:400px; height:200px;" src="upload/coin_token_img/<?php echo $edit_d['icon']; ?>" />
                    </div>
                  </div> 
                  
                  <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Upload Icon</label>
                    <div class="col-sm-10">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>                                     
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-info float-right">Add Coin Token Blast</button>
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
        echo "<script>location.href='dashboard.php'</script>";
    }
}else{
    echo "<script>location.href='dashboard.php'</script>";
}
?>
<?php
} else {
  echo "<script>location.href='dashboard.php'</script>";
}
?>