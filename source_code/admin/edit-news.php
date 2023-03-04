<?php session_start(); ?>
<?php 
include 'includes/dbconn.php'; 
$page = 'news';
?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>

<?php
if(isset($_GET['news_id'])){
    $news_id = $_GET['news_id'];
    $edit = $conn->query("SELECT * FROM `news` WHERE id='$news_id'");
    if($edit->num_rows == 1){
        $edit_d = $edit->fetch_array();
?>


<?php
if (isset($_POST['submit'])) {
    $news = $_POST['news'];
    $status = $_POST['status'];

    $save_data_in_db = "UPDATE `news` SET `news`='$news', `status`='$status' WHERE id='$news_id'";
  
    $result = $conn->query($save_data_in_db);
    if ($result === TRUE) {
      echo "<script>
      alert('Updated Successfully');
      location.href = 'edit-news.php?news_id=$news_id';
      </script>";
    } else {
      echo "<script>
      alert('Something Went Wrong!');
      location.href = 'edit-news.php?news_id=$news_id';
      </script>";
    }
  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Update News</title>
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
            <h1 class="m-0">Manage News</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Manage News</li>
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
                <h3 class="card-title">Add News</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">News</label> 
                    <div class="col-sm-10">
                      <textarea class="form-control" id="text" name="news"><?php echo $edit_d['news']; ?></textarea>
                    </div>
                  </div> 
                  <div class="form-group row">
                    <label for="status" class="col-sm-2 col-form-label">Status</label> 
                    <div class="col-sm-10" style="display: flex; padding-top: 10px;">
                        <div class="custom-control custom-radio mr-5">
                          <input class="custom-control-input" type="radio" id="customRadio1" <?php if($edit_d['status'] == 'Active'){ echo 'checked'; } ?> name="status" value="Active">
                          <label for="customRadio1" class="custom-control-label">Active</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="customRadio2" <?php if($edit_d['status'] == 'Inactive'){ echo 'checked'; } ?> value="Inactive" name="status">
                          <label for="customRadio2" class="custom-control-label">Inactive</label>
                        </div>
                    </div>
                  </div>                                                             
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-info float-right">Update News</button>
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