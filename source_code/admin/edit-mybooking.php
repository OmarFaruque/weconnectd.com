<?php session_start(); ?>
<?php
 include 'includes/dbconn.php'; 
 $page = 'my_bookings';
 ?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>

<?php
if(isset($_GET['booking_id'])){
    $booking_id = $_GET['booking_id'];
    $edit = $conn->query("SELECT * FROM `my_bookings` WHERE id='$booking_id'");
    if($edit->num_rows == 1){
        $edit_d = $edit->fetch_array();
?>        


<?php
if (isset($_POST['submit'])) {
    $status = $_POST['status'];
    $save_data_in_db = "UPDATE `my_bookings` SET `status`='$status' WHERE id='$booking_id'";
  
    $result = $conn->query($save_data_in_db);
    if ($result === TRUE) {
      echo "<script>
      alert('Updated Successfully');
      location.href = 'edit-mybooking.php?booking_id=$booking_id';
      </script>";
    } else {
      echo "<script>
      alert('Something Went Wrong!');
      location.href = 'edit-mybooking.php?booking_id=$booking_id';
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
            <h1 class="m-0">Manage Booking</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Update Booking Status</li>
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
                <h3 class="card-title">Update Booking Status</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Change Status</label>
                    <div class="col-sm-10">
                      <select class="form-control select2" style="width: 100%;" name="status">
                          <option value="Pending" <?php if($edit_d['status'] == 'Pending'){ echo 'selected'; } ?>>Pending</option>
                          <option value="Active" <?php if($edit_d['status'] == 'Active'){ echo 'selected'; } ?>>Active</option>
                          <option value="Inactive" <?php if($edit_d['status'] == 'Inactive'){ echo 'selected'; } ?>>Inactive</option>
                          <option value="Confirmed" <?php if($edit_d['status'] == 'Confirmed'){ echo 'selected'; } ?>>Confirmed</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Ref. Id</label>
                    <div class="col-sm-10">
                      <input type="text" value="<?php echo $edit_d['refid']; ?>" class="form-control" id="title" placeholder="Title" readonly>
                    </div>
                  </div> 
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">User Email</label>
                    <div class="col-sm-10">
                      <input type="text" value="<?php echo $edit_d['user_email']; ?>" class="form-control" id="title" placeholder="Title" readonly>
                    </div>
                  </div> 
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Booking Date/Time</label>
                    <div class="col-sm-10">
                      <input type="text" value="<?php echo $edit_d['date_time']; ?>" class="form-control" id="title" placeholder="Title" readonly>
                    </div>
                  </div>                                                                                  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-info float-right">Update Booking Status</button>
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