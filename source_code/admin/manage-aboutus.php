<?php session_start(); ?>
<?php 
include 'includes/dbconn.php';
$page = 'aboutus';
 ?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>
<?php 
$about = $conn->query("SELECT * FROM `aboutus` WHERE id=1")->fetch_array();
?>

<?php
if (isset($_POST['submit'])) {
  $title = $_POST['title'];
  $subtitle = $_POST['subtitle'];
  $frontpage = $_POST['frontpage']; 
  $text = $_POST['text'];
  $image = $_FILES['image'];

  $imagename = $image['name'];
  $imagetype = $image['type'];
  $imagetmp_name = $image['tmp_name'];
  $imageerror = $image['error'];
  $imagesize = $image['size'];

  $image_ext = explode('.',$imagename);
  $for_image = strtolower(end($image_ext));
  $image_in = array('jpg', 'png', 'jpeg');

  if($imagename == ""){
      $save_data_in_db = "UPDATE `aboutus` SET `title`='$title', `subtitle`='$subtitle', `text`='$text', `frontpage`='$frontpage' WHERE id=1;";
  
      $result = $conn->query($save_data_in_db);
      if ($result === TRUE) {
        echo "<script>
        alert('Updated Successfully');
        location.href = 'manage-aboutus.php';
        </script>";
      } else {
        echo "<script>
        alert('Something Went Wrong!');
        location.href = 'manage-aboutus.php';
        </script>";
      }
  }else{
    if(in_array($for_image,$image_in)) {
      $image_path = 'upload/about_img/' . $imagename;
      move_uploaded_file($imagetmp_name, $image_path);
  
      $save_data_in_db = "UPDATE `aboutus` SET `title`='$title', `subtitle`='$subtitle', `image`='$imagename', `text`='$text', `frontpage`='$frontpage' WHERE id=1;";
  
      $result = $conn->query($save_data_in_db);
      if ($result === TRUE) {
        echo "<script>
        alert('Updated Successfully');
        location.href = 'manage-aboutus.php';
        </script>";
      } else {
        echo "<script>
        alert('Something Went Wrong!');
        location.href = 'manage-aboutus.php';
        </script>";
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
            <h1 class="m-0">Manage About Us</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Manage About Us </li>
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
                <h3 class="card-title">Update About Us</h3>
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
                    <label for="subtitle" class="col-sm-2 col-form-label">Sub Title</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?php echo $about['subtitle']; ?>" placeholder="Sub Title">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                      <img src="upload/about_img/<?php echo $about['image']; ?>" width="120" height="120" class="img" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Upload Image</label>
                    <div class="col-sm-10">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Front Page About</label>
                    <div class="col-sm-10">
                      <textarea name="frontpage" id="frontpage"><?php echo $about['frontpage']; ?></textarea>
                      <script>
                          CKEDITOR.replace('frontpage');                         
                      </script>
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
                        $m = $conn->query("SELECT * FROM meta_tag WHERE page='aboutus' AND page_row_id='1'");
                        if($m->num_rows > 0){
                            ?>
                            <a href="edit-meta-tag.php?page=aboutus&page_row_id=1"><i class="fa fa-edit"></i></a>
                            <?php
                        } else{
                            ?>
                            <a href="add-meta-tag.php?page=aboutus&page_row_id=1"><i class="fa fa-plus"></i></a>
                            <?php
                        }
                        ?>
                    </div>
                  </div>
                  <!--<div class="form-group row">
                    <label for="subtitle" class="col-sm-2 col-form-label">Gallery</label>
                    <div class="col-sm-10">
                         <a href="add-gallery.php?page=aboutus&page_row_id=1"><i class="fa fa-plus"></i></a>
                        <a href="view-gallery.php?page=aboutus&page_row_id=1"><i class="fa fa-edit"></i></a> 
                    </div>
                  </div>-->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-info float-right">Update About</button>
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