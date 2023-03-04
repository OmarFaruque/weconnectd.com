<?php session_start(); ?>
<?php 
include 'includes/dbconn.php'; 
$page = 'exam';
?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>

<?php
if(isset($_GET['exam_id'])){
    $exam_id = $_GET['exam_id'];
    $edit = $conn->query("SELECT * FROM exam WHERE id='$exam_id'");
    if($edit->num_rows == 1){
        $edit_d = $edit->fetch_array();
?>


<?php
if (isset($_POST['submit'])) {
    $school = $_POST['school'];
    $number_of_subjects = $_POST['number_of_subjects'];
    $types_of_paper = $_POST['types_of_paper'];
    $class = $_POST['class'];
    $duration = $_POST['duration'];
    $info = $_POST['info'];
    
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
    $image_path = 'upload/exam_img/' . $imagename;
    move_uploaded_file($imagetmp_name, $image_path);
    $save_data_in_db = "UPDATE `exam` SET `number_of_subjects`='$number_of_subjects', `types_of_paper`='$types_of_paper', `class`='$class', `duration`='$duration', `info`='$info', `image`='$imagename', `school`='$school' WHERE id='$exam_id'";
  } else{
    $save_data_in_db = "UPDATE `exam` SET `number_of_subjects`='$number_of_subjects', `types_of_paper`='$types_of_paper', `class`='$class', `duration`='$duration', `info`='$info', `school`='$school' WHERE id='$exam_id'";
  }

  
    $result = $conn->query($save_data_in_db);
    if ($result === TRUE) {
      echo "<script>
      alert('Updated Successfully');
      location.href = 'edit-exam.php?exam_id=$exam_id';
      </script>";
    } else {
      echo "<script>
      alert('Something Went Wrong!');
      location.href = 'edit-exam.php?exam_id=$exam_id';
      </script>";
    }
  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Update School</title>
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
            <h1 class="m-0">Manage Exam</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Manage Exam</li>
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
                <h3 class="card-title">Update Exam</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Select Course</label>
                    <div class="col-sm-10">
                      <select class="form-control select2" style="width: 100%;" name="school" id="school">
                      <?php 
                      $category = $conn->query("SELECT * FROM `schools`");
                      if($category->num_rows > 0){
                        while($category_d = $category->fetch_assoc()){
                          ?>
                          <option <?php if($edit_d['school'] == $category_d['id']){ echo 'selected'; } ?> value="<?php echo $category_d['id'] ?>"><?php echo $category_d['name'] ?></option>
                          <?php
                        }
                      } else {
                        ?>
                          <option>No School Exists.</option>
                        <?php
                      }
                      ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="number_of_subjects" class="col-sm-2 col-form-label">Number of subjects</label> 
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="number_of_subjects" name="number_of_subjects" value="<?php echo $edit_d['number_of_subjects']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="types_of_paper" class="col-sm-2 col-form-label">Types of paper</label> 
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="types_of_paper" name="types_of_paper" value="<?php echo $edit_d['types_of_paper']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="duration" class="col-sm-2 col-form-label">Duration</label> 
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="duration" name="duration" value="<?php echo $edit_d['duration']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="class" class="col-sm-2 col-form-label">Class</label> 
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="class" name="class" value="<?php echo $edit_d['class']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">About Exam</label>
                    <div class="col-sm-10">
                      <textarea name="info" id="text" required><?php echo $edit_d['info']; ?></textarea>
                      <script>
                          CKEDITOR.replace('text');                         
                      </script>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                      <img style="width:600px; height:400px;" src="upload/exam_img/<?php echo $edit_d['image']; ?>">
                    </div>
                  </div> 
                  <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Upload Image</label>
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
                  <button type="submit" name="submit" class="btn btn-info float-right">Add Exam</button>
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