<?php session_start(); ?>
<?php 
include 'includes/dbconn.php'; 
$page = 'more_pages';
?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>

<?php
if(isset($_GET['morepages_id'])){
    $morepages_id = $_GET['morepages_id'];
    $edit = $conn->query("SELECT * FROM `more_pages` WHERE id='$morepages_id'");
    if($edit->num_rows == 1){
        $edit_d = $edit->fetch_array();
?>


<?php
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $text = $_POST['text'];
  $add_on = $_POST['add_on'];
  $status = $_POST['status'];
  $icon = $_POST['icon'];

  $save_data_in_db = "UPDATE `more_pages` SET `name`='$name', `text`='$text', `add_on`='$add_on', `status`='$status', `icon`='$icon' WHERE id='$morepages_id'";
  
    $result = $conn->query($save_data_in_db);
    if ($result === TRUE) {
      echo "<script>
      alert('Updated Successfully');
      location.href = 'edit-morepages.php?morepages_id=$morepages_id';
      </script>";
    } else {
      echo "<script>
      alert('Something Went Wrong!');
      location.href = 'edit-morepages.php?morepages_id=$morepages_id';
      </script>";
    }
  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Update Pages</title>
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
            <h1 class="m-0">Manage Pages</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Manage Pages</li>
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
                <h3 class="card-title">Add Pages</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Name</label> 
                    <div class="col-sm-10">
                      <input type="text" class="form-control" value="<?php echo $edit_d['name']; ?>" id="name" name="name">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Icon</label> 
                    <div class="col-sm-10">
                      <input type="text" class="form-control" value="<?php echo $edit_d['icon']; ?>" id="icon" name="icon">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Page</label> 
                    <div class="col-sm-10">
                      <textarea class="form-control" id="text" name="text"><?php echo $edit_d['text']; ?></textarea>
                      <script>
                          CKEDITOR.replace('text'); 
                      </script>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Add On</label>
                    <div class="col-sm-10">
                      <select class="form-control select2" style="width: 100%;" name="add_on" id="add_on">
                          <option <?php if($edit_d['add_on'] == 'More'){ echo 'selected'; } ?> value="More">More</option>
                          <option <?php if($edit_d['add_on'] == 'Nav'){ echo 'selected'; } ?> value="Nav">Nav</option>
                          <option <?php if($edit_d['add_on'] == 'Footer Quick Links'){ echo 'selected'; } ?> value="Footer Quick Links">Footer-Quick Links</option>
                          <option <?php if($edit_d['add_on'] == 'Footer Service'){ echo 'selected'; } ?> value="Footer Service">Footer-Service</option>
                      </select>
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
                  <button type="submit" name="submit" class="btn btn-info float-right">Update Page</button>
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