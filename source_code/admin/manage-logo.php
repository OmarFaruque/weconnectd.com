<?php session_start(); ?>
<?php
 include 'includes/dbconn.php';
 $page = 'logos'
 ?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>
<?php 
$logo = $conn->query("SELECT * FROM `logos` WHERE id=1")->fetch_array();
?>

<?php
if (isset($_POST['submit'])) {
  $header_logo = $_FILES['header_logo'];
  $footer_logo = $_FILES['footer_logo'];
  $other_logo = $_FILES['other_logo']; 
  $coin_token_blast_logo = $_FILES['coin_token_blast'];
  $sc_top_40_logo = $_FILES['sc_top_40'];

  $header_logo_name = $header_logo['name'];
  $header_logo_type = $header_logo['type'];
  $header_logo_tmp_name = $header_logo['tmp_name'];
  $header_logo_error = $header_logo['error'];
  $header_logo_size = $header_logo['size'];

  $footer_logo_name = $footer_logo['name'];
  $footer_logo_type = $footer_logo['type'];
  $footer_logo_tmp_name = $footer_logo['tmp_name'];
  $footer_logo_error = $footer_logo['error'];
  $footer_logo_size = $footer_logo['size'];

  $other_logo_name = $other_logo['name'];
  $other_logo_type = $other_logo['type'];
  $other_logo_tmp_name = $other_logo['tmp_name'];
  $other_logo_error = $other_logo['error'];
  $other_logo_size = $other_logo['size'];
	
  $sc_top_40_logo_name = $sc_top_40_logo['name'];
  $sc_top_40_logo_type = $sc_top_40_logo['type'];
  $sc_top_40_logo_tmp_name = $sc_top_40_logo['tmp_name'];
  $sc_top_40_logo_error = $sc_top_40_logo['error'];
  $sc_top_40_logo_size = $sc_top_40_logo['size'];
	
  $coin_token_blast_logo_name = $coin_token_blast_logo['name'];
  $coin_token_blast_logo_type = $coin_token_blast_logo['type'];
  $coin_token_blast_logo_tmp_name = $coin_token_blast_logo['tmp_name'];
  $coin_token_blast_logo_error = $coin_token_blast_logo['error'];
  $coin_token_blast_logo_size = $coin_token_blast_logo['size'];

  if($other_logo_name == ""){
    $other_logo_name = $logo['other_logo'];
  }else{
    $image_path3 = 'upload/logo_img/' . $other_logo_name;
    move_uploaded_file($other_logo_tmp_name, $image_path3);
  }

  if($footer_logo_name == ""){
    $footer_logo_name = $logo['footer_logo'];
  }else{
    $image_path2 = 'upload/logo_img/' . $footer_logo_name;
    move_uploaded_file($footer_logo_tmp_name, $image_path2);
  }

  if($header_logo_name == ""){
    $header_logo_name = $logo['header_logo'];
  }else{
    $image_path1 = 'upload/logo_img/' . $header_logo_name;
    move_uploaded_file($header_logo_tmp_name, $image_path1);
  }
	
  if($sc_top_40_logo_name == ""){
    $sc_top_40_logo_name = $logo['sc_top_40'];
  }else{
    $image_path4 = 'upload/logo_img/' . $sc_top_40_logo_name;
    move_uploaded_file($sc_top_40_logo_tmp_name, $image_path4);
  }
	
  if($coin_token_blast_logo_name == ""){
    $coin_token_blast_logo_name = $logo['coin_token_blast'];
  }else{
    $image_path5 = 'upload/logo_img/' . $coin_token_blast_logo_name;
    move_uploaded_file($coin_token_blast_logo_tmp_name, $image_path5);
  }
  
      $save_data_in_db = "UPDATE `logos` SET `header_logo`='$header_logo_name', `footer_logo`='$footer_logo_name', `other_logo`='$other_logo_name', `sc_top_40`='$sc_top_40_logo_name', `coin_token_blast`='$coin_token_blast_logo_name' WHERE id=1;";
  
      $result = $conn->query($save_data_in_db);
      if ($result === TRUE) {
        echo "<script>
        alert('Updated Successfully');
        location.href = 'manage-logo.php';
        </script>";
      } else {
        echo "<script>
        alert('Something Went Wrong!');
        location.href = 'manage-logo.php';
        </script>";
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
            <h1 class="m-0">Manage logos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Manage logos </li>
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
                <h3 class="card-title">Update logos</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Header Logo</label>
                    <div class="col-sm-10">
                      <img src="upload/logo_img/<?php echo $logo['header_logo']; ?>" width="120" height="120" class="img" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Update Header Logo</label>
                    <div class="col-sm-10">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="header_lodo" name="header_logo">
                        <label class="custom-file-label" for="image">Choose file</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Footer Logo</label>
                    <div class="col-sm-10">
                      <img src="upload/logo_img/<?php echo $logo['footer_logo']; ?>" width="120" height="120" class="img" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Update Footer Logo</label>
                    <div class="col-sm-10">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="footer_logo" name="footer_logo">
                        <label class="custom-file-label" for="image">Choose file</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Other Logo</label>
                    <div class="col-sm-10">
                      <img src="upload/logo_img/<?php echo $logo['other_logo']; ?>" width="120" height="120" class="img" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Update Other Logo</label>
                    <div class="col-sm-10">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="other_logo" name="other_logo">
                        <label class="custom-file-label" for="image">Choose file</label>
                      </div>
                    </div>
                  </div> 
				  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">SC Top 40 Logo</label>
                    <div class="col-sm-10">
                      <img src="upload/logo_img/<?php echo $logo['sc_top_40']; ?>" width="200" class="img" />
                    </div>
                  </div>
				  <div class="form-group row">
                    <label for="sc_top_40_logo" class="col-sm-2 col-form-label">Update SC Top 40 Logo</label>
                    <div class="col-sm-10">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="sc_top_40_logo" name="sc_top_40">
                        <label class="custom-file-label" for="image">Choose file</label>
                      </div>
                    </div>
                  </div> 
				  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Coin Token Blast Logo</label>
                    <div class="col-sm-10">
                      <img src="upload/logo_img/<?php echo $logo['coin_token_blast']; ?>" width="200" class="img" />
                    </div>
                  </div>
				  <div class="form-group row">
                    <label for="coin_token_blast_logo" class="col-sm-2 col-form-label">Update Coin Token Blast Logo</label>
                    <div class="col-sm-10">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="coin_token_blast_logo" name="coin_token_blast">
                        <label class="custom-file-label" for="image">Choose file</label>
                      </div>
                    </div>
                  </div> 
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-info float-right">Update logo</button>
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