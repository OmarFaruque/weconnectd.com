<?php session_start(); ?>
<?php
 include 'includes/dbconn.php'; 
 $page = 'agents_suppliers';
 ?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>

<?php
if(isset($_GET['supplier_id'])){
    $supplier_id = $_GET['supplier_id'];
    $edit = $conn->query("SELECT * FROM `agents_suppliers` WHERE `user_type`='Supplier' AND id='$supplier_id'");
    if($edit->num_rows == 1){
        $edit_d = $edit->fetch_array();
?>        


<?php
if (isset($_POST['submit'])) {
    $status = $_POST['status'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $company_name = $_POST['company_name'];
    $gst_no = $_POST['gst_no'];
    $save_data_in_db = "UPDATE `agents_suppliers` SET `name`='$name', `email`='$email', `mobile`='$mobile', `state`='$state', `city`='$city', `address`='$address', `company_name`='$company_name', `gst_no`='$gst_no', `status`='$status' WHERE id='$supplier_id'";
  
    $result = $conn->query($save_data_in_db);
    if ($result === TRUE) {
      echo "<script>
      alert('Updated Successfully');
      location.href = 'edit-supplier.php?supplier_id=$supplier_id';
      </script>";
    } else {
      echo "<script>
      alert('Something Went Wrong!');
      location.href = 'edit-supplier.php?supplier_id=$supplier_id';
      </script>";
      echo $conn->error;
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
            <h1 class="m-0">Manage Supplier</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Update Supplier</li>
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
                <h3 class="card-title">Update Supplier</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Change Status</label>
                    <div class="col-sm-10">
                      <select class="form-control select2" style="width: 100%;" name="status">
                          <option value="Active" <?php if($edit_d['status'] == 'Active'){ echo 'selected'; } ?>>Active</option>
                          <option value="Inactive" <?php if($edit_d['status'] == 'Inactive'){ echo 'selected'; } ?>>Inactive</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                      <input type="text" value="<?php echo $edit_d['name']; ?>" class="form-control" name="name" id="name">
                    </div>
                  </div> 
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" value="<?php echo $edit_d['email']; ?>" class="form-control" name="email" id="email">
                    </div>
                  </div> 
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Mobile</label>
                    <div class="col-sm-10">
                      <input type="number" value="<?php echo $edit_d['mobile']; ?>" class="form-control" name="mobile" id="mobile">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="company_name" class="col-sm-2 col-form-label">Company Name</label>
                    <div class="col-sm-10">
                      <input type="text" value="<?php echo $edit_d['company_name']; ?>" class="form-control" id="company_name" name="company_name">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="gst_no" class="col-sm-2 col-form-label">GST No.</label>
                    <div class="col-sm-10">
                      <input type="text" value="<?php echo $edit_d['gst_no']; ?>" class="form-control" id="gst_no" name="gst_no">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">State</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="state">
                          <option selected value="<?php  echo $edit_d['state']; ?>"><?php  echo $edit_d['state']; ?></option>
                      <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                      <option value="Andhra Pradesh">Andhra Pradesh</option>
                      <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                      <option value="Assam">Assam</option>
                      <option value="Bihar">Bihar</option>
                      <option value="Chandigarh">Chandigarh</option>
                      <option value="Chattisgarh">Chattisgarh</option>
                      <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                      <option value="Daman and Diu">Daman and Diu</option>
                      <option value="Delhi">Delhi</option>
                      <option value="Goa">Goa</option>
                      <option value="Gujarat">Gujarat</option>
                      <option value="Haryana">Haryana</option>
                      <option value="Himachal Pradesh">Himachal Pradesh</option>
                      <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                      <option value="Jharkhand">Jharkhand</option>
                      <option value="Karnataka">Karnataka</option>
                      <option value="Kerala">Kerala</option>
                      <option value="Lakshadweep">Lakshadweep</option>
                      <option value="Madhya Pradesh">Madhya Pradesh</option>
                      <option value="Maharashtra">Maharashtra</option>
                      <option value="Manipur">Manipur</option>
                      <option value="Meghalaya">Meghalaya</option>
                      <option value="Mizoram">Mizoram</option>
                      <option value="Nagaland">Nagaland</option>
                      <option value="Orissa">Orissa</option>
                      <option value="Pondicherry">Pondicherry</option>
                      <option value="Punjab">Punjab</option>
                      <option value="Rajasthan">Rajasthan</option>
                      <option value="Sikkim">Sikkim</option>
                      <option value="Tamil Nadu">Tamil Nadu</option>
                      <option value="Tripura">Tripura</option>
                      <option value="Uttarakhand">Uttarakhand</option>
                      <option value="Uttaranchal">Uttaranchal</option>
                      <option value="Uttar Pradesh">Uttar Pradesh</option>
                      <option value="West Bengal">West Bengal</option>
    </select>
                    </div>
                  </div> 
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">City</label>
                    <div class="col-sm-10">
                      <input type="text" value="<?php echo $edit_d['city']; ?>" class="form-control" id="city" name="city">
                    </div>
                  </div> 
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="address" style="width:100%; height:80px;"><?php echo $edit_d['address']; ?></textarea>
                    </div>
                  </div> 
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-info float-right">Update Supplier</button>
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