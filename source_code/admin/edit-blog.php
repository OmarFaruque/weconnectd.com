<?php
session_start();
?>
<?php
include 'includes/dbconn.php'; 
$page = 'blog';
?>

<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>
<?php
if(isset($_GET['blog_id'])){
    $blog_id = $_GET['blog_id'];
    $edit = $conn->query("SELECT * FROM blog WHERE id='$blog_id'");
    if($edit->num_rows == 1){
        $edit_d = $edit->fetch_array();
?>


<?php
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $brief = $_POST['brief'];
    $text = $_POST['text'];
    $image = $_FILES['image'];
    $author = $_POST['author'];
    $status = $_POST['status'];

  $imagename = $image['name'];
  $imagetype = $image['type'];
  $imagetmp_name = $image['tmp_name'];
  $imageerror = $image['error'];
  $imagesize = $image['size'];

  if($imagename == ""){
    $save_data_in_db = "UPDATE `blog` SET `title`='$title', `text`='$text', `brief`='$brief', `author`='$author', `status`='$status' WHERE id='$blog_id'";
  
    $result = $conn->query($save_data_in_db);
    if ($result === TRUE) {
      echo "<script>
      alert('Updated Successfully');
      location.href = 'edit-blog.php?blog_id=$blog_id';
      </script>";
    } else {
      echo "<script>
      alert('Something Went Wrong!');
      location.href = 'edit-blog.php?blog_id=$blog_id';
      </script>";
    }
  }else{
      
  $image_ext = explode('.',$imagename);
  $for_image = strtolower(end($image_ext));
  $image_in = array('jpg', 'png', 'jpeg');
    if(in_array($for_image,$image_in)) {
        $image_path = 'upload/blog_img/' . $imagename;
        move_uploaded_file($imagetmp_name, $image_path);
    
        $save_data_in_db = "UPDATE `blog` SET `title`='$title', `text`='$text', `brief`='$brief', `image`='$imagename', `author`='$author', `status`='$status' WHERE id='$blog_id'";
    
        $result = $conn->query($save_data_in_db);
        if ($result === TRUE) {
          echo "<script>
          alert('Updated Successfully');
          location.href = 'edit-blog.php?blog_id=$blog_id';
          </script>";
        } else {
          echo "<script>
          alert('Something Went Wrong!');
          location.href = 'edit-blog.php?blog_id=$blog_id';
          </script>";
        }
      } else {
          echo "<script>
          alert('File Should ne JPEG PNG JPG!');
          location.href = 'edit-blog.php?blog_id=$blog_id';
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
            <h1 class="m-0">Manage blog</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Manage blog </li>
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
                <h3 class="card-title">Update blog</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Title</label> 
                    <div class="col-sm-10">
                      <input type="text" value="<?php echo $edit_d['title']; ?>" class="form-control" id="title" name="title">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Author</label> 
                    <div class="col-sm-10">
                      <input type="text" value="<?php echo $edit_d['author']; ?>" class="form-control" id="author" name="author">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                      <img src="upload/blog_img/<?php echo $edit_d['image']; ?>" width="120" height="120" class="img" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Update Image</label>
                    <div class="col-sm-10">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="brief" class="col-sm-2 col-form-label">Brief Description</label>
                    <div class="col-sm-10">
                      <textarea style="width:100%; height:200px;" name="brief" id="brief"><?php echo $edit_d['brief']; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                      <textarea name="text" id="text"><?php echo $edit_d['text']; ?></textarea>
                      <script>
                          CKEDITOR.replace('text');                         

                      </script>
                    </div>
                  </div> 
                  <div class="form-group row">
                    <label for="status" class="col-sm-2 col-form-label">Status</label> 
                    <div class="col-sm-10" style="display: flex; padding-top: 10px;">
                        <div class="custom-control custom-radio mr-5">
                          <input class="custom-control-input" type="radio" id="customRadio1" name="status" value="Active" <?php if($edit_d['status'] == 'Active'){ echo 'checked'; } ?>>
                          <label for="customRadio1" class="custom-control-label">Active</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="customRadio2" value="Deactive" name="status" <?php if($edit_d['status'] == 'Deactive'){ echo 'checked'; } ?>>
                          <label for="customRadio2" class="custom-control-label">Deactive</label>
                        </div>
                    </div>
                  </div>                                  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-info float-right">Add blog</button>
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
<script>
$(document).ready(function() {

$('#category').on('change', function() {
  var category_id = $(this).val();
  $.ajax({
    url: "files/ajax.php",
    method: "POST",
    data: {
        category_id: category_id
    },
    dataType: "html",
    cache: false,
    success: function(data){
    $("#subcategory").html(data);
    }
  });
});    
});
</script>
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