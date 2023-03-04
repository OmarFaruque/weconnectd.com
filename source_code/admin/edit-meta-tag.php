<?php session_start(); ?>
<?php
 include 'includes/dbconn.php'; 
 $page = 'meta_tag';
 ?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>
    <?php
  if(isset($_GET['page']) AND isset($_GET['page_row_id'])){
    $page = $_GET['page'];
    $page_row_id = $_GET['page_row_id'];
    
    $edit = $conn->query("SELECT * FROM meta_tag WHERE page='$page' AND page_row_id='$page_row_id'");
    if($edit->num_rows == 1){
        $edit_d = $edit->fetch_array();
    }
    ?>
<?php
if (isset($_POST['submit'])) {
  $title= $_POST['title'];
  $description = $_POST['description'];
  $author = $_POST['author'];
  $keywords = $_POST['keywords'];
  $robots = $_POST['robots'];
  $canonical = $_POST['canonical'];
  $search = $_POST['search'];
  
      $save_data_in_db = "UPDATE `meta_tag` SET `title`='$title', `description`='$description', `author`='$author', `keywords`='$keywords', `robots`='$robots', `canonical`='$canonical', search='$search' WHERE page='$page' AND page_row_id='$page_row_id'";
  
      $result = $conn->query($save_data_in_db);
      if ($result === TRUE) {
        echo "<script>
        alert('Added Successfully');
        location.href = 'edit-meta-tag.php?page=$page&page_row_id=$page_row_id';
        </script>";
      } else {
        echo "<script>
        alert('Something Went Wrong!');
        location.href = 'edit-meta-tag.php?page=$page&page_row_id=$page_row_id';
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
            <h1 class="m-0">Manage Meta Tag</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Manage Meta Tag</li>
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
                <h3 class="card-title">Add Meta Tag</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                      <textarea name="title" id="title" style="width:100%; height:100px;"><?php echo $edit_d['title'] ?></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                      <textarea name="description" id="description" style="width:100%; height:100px;"><?php echo $edit_d['description'] ?></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Author</label>
                    <div class="col-sm-10">
                      <textarea name="author" id="author" style="width:100%; height:100px;"><?php echo $edit_d['author'] ?></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Keywords</label>
                    <div class="col-sm-10">
                      <textarea name="keywords" id="keywords" style="width:100%; height:100px;"><?php echo $edit_d['keywords'] ?></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Robots</label>
                    <div class="col-sm-10">
                      <textarea name="robots" id="robots" style="width:100%; height:100px;"><?php echo $edit_d['robots'] ?></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Canonocal</label>
                    <div class="col-sm-10">
                      <textarea name="canonical" id="canonical" style="width:100%; height:100px;"><?php echo $edit_d['canonical'] ?></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="status" class="col-sm-2 col-form-label">Search</label> 
                    <div class="col-sm-10" style="display: flex; padding-top: 10px;">
                        <div class="custom-control custom-radio mr-5">
                          <input class="custom-control-input" type="radio" id="customRadio1" name="search" value="1" <?php if($edit_d['search'] == "1"){ echo 'checked'; } ?>>
                          <label for="customRadio1" class="custom-control-label">Yes</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="customRadio2" value="0" name="search" <?php if($edit_d['search'] == "0"){ echo 'checked'; } ?>>
                          <label for="customRadio2" class="custom-control-label">No</label>
                        </div>
                    </div>
                  </div>   
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-info float-right">Update Meta Tags</button>
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
  }else {
      header("Location: dashboard.php");
  }
  ?>
<?php
} else {
  header("Location: index.php");
}
?>