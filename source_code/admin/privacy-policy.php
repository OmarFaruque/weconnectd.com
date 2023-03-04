<?php session_start(); ?>
<?php
 include 'includes/dbconn.php'; 
 $page = 'privacy_policy';
 ?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>
<?php 
$about = $conn->query("SELECT * FROM `privacy_policy` WHERE id=1")->fetch_array();
?>

<?php
if (isset($_POST['submit'])) {
  $title = $_POST['title']; 
  $text = $_POST['text'];
  
      $save_data_in_db = "UPDATE `privacy_policy` SET `title`='$title', `text`='$text' WHERE id=1;";
  
      $result = $conn->query($save_data_in_db);
      if ($result === TRUE) {
        echo "<script>
        alert('Updated Successfully');
        location.href = 'privacy-policy.php';
        </script>";
      } else {
        echo "<script>
        alert('Something Went Wrong!');
        location.href = 'privacy-policy.php';
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
            <h1 class="m-0">Manage Privacy Policy</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Manage Privacy Policy </li>
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
                <h3 class="card-title">Update Privacy Policy</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Title</label> 
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="title" name="title" value="<?php echo $about['title']; ?>" placeholder="Title">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Text</label>
                    <div class="col-sm-10">
                      <textarea name="text" id="text"><?php echo $about['text']; ?></textarea>
                      <script>
                          CKEDITOR.replace('text');                         
                      </script>
                    </div>
                  </div>  
                  <div class="form-group row">
                    <label for="subtitle" class="col-sm-2 col-form-label">Meta Tag</label>
                    <div class="col-sm-10">
                        <?php
                        $m = $conn->query("SELECT * FROM meta_tag WHERE page='privacy_policy' AND page_row_id='1'");
                        if($m->num_rows > 0){
                            ?>
                            <a href="edit-meta-tag.php?page=privacy_policy&page_row_id=1"><i class="fa fa-edit"></i></a>
                            <?php
                        } else{
                            ?>
                            <a href="add-meta-tag.php?page=privacy_policy&page_row_id=1"><i class="fa fa-plus"></i></a>
                            <?php
                        }
                        ?>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-info float-right">Update Privacy Policy</button>
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