<?php session_start(); ?>
<?php
include 'includes/dbconn.php'; 
$page = 'contactus';
?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>
<?php 
$contact = $conn->query("SELECT * FROM `contactus` WHERE id=1")->fetch_array();
?>

<?php
if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $mobile = $_POST['mobile']; 
  $landline = $_POST['landline'];
  $address = $_POST['address'];

  
      $save_data_in_db = "UPDATE `contactus` SET `address`='$address', `email`='$email', `mobile`='$mobile', `landline`='$landline' WHERE id=1;";
  
      $result = $conn->query($save_data_in_db);
      if ($result === TRUE) {
        echo "<script>
        alert('Updated Successfully');
        location.href = 'manage-contact.php';
        </script>";
      } else {
        echo "<script>
        alert('Something Went Wrong!');
        location.href = 'manage-contact.php';
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
            <h1 class="m-0">Manage Contact Us</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Manage Contact Us </li>
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
                <h3 class="card-title">Update Contact Us</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" name="email" value="<?php echo $contact['email']; ?>" id="title" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="subtitle" class="col-sm-2 col-form-label">Mobile</label>
                    <div class="col-sm-10">
                      <input type="tel" class="form-control" id="subtitle" name="mobile" value="<?php echo $contact['mobile']; ?>" placeholder="Mobile">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="Landline" class="col-sm-2 col-form-label">Landline</label>
                    <div class="col-sm-10">
                      <input type="tel" class="form-control" id="Landline" name="landline" value="<?php echo $contact['landline']; ?>" placeholder="Landline">
                    </div>
                  </div>                           
                  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="address" id="text"><?php echo $contact['address']; ?></textarea>
                    </div>
                  </div> 
                  <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Meta Tag</label>
                    <div class="col-sm-10">
                        <?php
                        $m = $conn->query("SELECT * FROM meta_tag WHERE page='contactus' AND page_row_id='1'");
                        if($m->num_rows > 0){
                            ?>
                            <a href="edit-meta-tag.php?page=contactus&page_row_id=1"><i class="fa fa-edit"></i></a>
                            <?php
                        } else{
                            ?>
                            <a href="add-meta-tag.php?page=contactus&page_row_id=1"><i class="fa fa-plus"></i></a>
                            <?php
                        }
                        ?>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-info float-right">Update Contact Us</button>
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
  echo "
  <script>
  alert('Sorry! you are not authorized for this page...');
  location.href = document.referrer;
  </script>
  ";
}
?>