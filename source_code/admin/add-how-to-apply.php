<?php session_start(); ?>
<?php
 include 'includes/dbconn.php'; 
 $page = 'how_to_apply';
 ?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>
<?php
if (isset($_POST['submit'])) {
  $availability_of_form = $_POST['availability_of_form'];
  $submission_of_form = $_POST['submission_of_form'];
  $important_documents = $_POST['important_documents'];
  $school = $_POST['school'];
  
  $save_data_in_db = "INSERT INTO `how_to_apply` (`availability_of_form`, `submission_of_form`, `important_dates`, `important_documents`, `school`) VALUES ('$availability_of_form', '$submission_of_form', '$important_documents', '$school')";
  
  $result = $conn->query($save_data_in_db);
  if ($result === TRUE) {
        echo "<script>
        alert('Updated Successfully');
        location.href = 'add-how-to-apply.php';
        </script>";
  } else {
        echo "<script>
        alert('Something Went Wrong!');
        location.href = 'add-how-to-apply.php';
        </script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add How To Apply</title>

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
            <h1 class="m-0">Manage How To Apply</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Add How To Apply</li>
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
                <h3 class="card-title">Add How To Apply</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">School</label>
                    <div class="col-sm-10">
                      <select class="form-control select2" style="width: 100%;" name="school" id="school">
                          <option>Select Schsool</option>
                      <?php 
                      $category = $conn->query("SELECT * FROM `schools`");
                      if($category->num_rows > 0){
                        while($category_d = $category->fetch_assoc()){
                          ?>
                          <option value="<?php echo $category_d['id'] ?>"><?php echo $category_d['name'] ?></option>
                          <?php
                        }
                      } else {
                        ?>
                          <option>No Airline Exists.</option>
                        <?php
                      }
                      ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="availability_of_form" class="col-sm-2 col-form-label">Availability of form</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="availability_of_form" id="availability_of_form"></textarea>
                    </div>
                  </div>  
                  <div class="form-group row">
                    <label for="info" class="col-sm-2 col-form-label">Submission of form</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="submission_of_form" id="submission_of_form"></textarea>
                    </div>
                  </div>  
                  <div class="form-group row">
                    <label for="important_dates" class="col-sm-2 col-form-label">Important dates</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="important_dates" id="important_dates"></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="important_documents" class="col-sm-2 col-form-label">Important documents</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="important_documents" id="important_documents"></textarea>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-info float-right">Add How To Apply</button>
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