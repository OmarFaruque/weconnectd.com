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
if(isset($_GET['status'])){
  $status = $_GET['status'];
  $d = $conn->query("SELECT * FROM `agents_suppliers` WHERE `user_type`='Supplier' AND `status`='$status' ORDER BY `id` DESC");
} else {
  $d = $conn->query("SELECT * FROM `agents_suppliers` WHERE `user_type`='Supplier' ORDER BY `id` DESC");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>View Agents</title>

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
              <li class="breadcrumb-item active">View Supplier</li>
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">View Supplier</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th>Company Name</th>
                    <th>Aadhar Card</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($d->num_rows > 0){
                      $i=0;
                      while($data = $d->fetch_assoc()){
                        $i++;
                        ?>
                  <tr>
                    <td><?php echo $i ?></td>
                    <td> <?php echo $data['name']; ?></td>
                    <td><?php echo $data['email']; ?></td>
                    <td><?php echo $data['mobile']; ?></td>
                    <td><?php echo $data['address'].", ".$data['city'].", ".$data['state']; ?></td>
                    <td><?php echo $data['company_name']; ?></td>
                    <td><a href="aadhar_card/<?php echo $data['aadhar_card']; ?>">Aadhar Card</a></td>
                    <td><?php echo $data['status']; ?></a></td>
                    <td>
                      <a href="edit-supplier.php?supplier_id=<?php echo $data['id']; ?>"><i class="fas fa-edit text-warning"></i></a>
                      <a href="delete.php?file_id=<?php echo $data['id'] ?>&file=agents_suppliers"><i class="fas fa-trash-alt text-danger"></i></a>
                    </td>
                  </tr>  
                        <?php
                      }
                    }
                    ?>             
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
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