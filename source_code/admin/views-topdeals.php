<?php session_start(); ?>
<?php 
include 'includes/dbconn.php'; 
$page = 'top_deals';
?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>
<?php
if(isset($_GET['status'])){
  $status = $_GET['status'];
  $d = $conn->query("SELECT * FROM `top_deals` WHERE `status`='$status' ORDER BY id DESC");
} else {
  $d = $conn->query("SELECT * FROM `top_deals` ORDER BY `id` DESC");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>View Top Deals</title>

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
            <h1 class="m-0">Manage Top Deals</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">View Top Deals</li>
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
                <h3 class="card-title">View Top Deals</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Location</th>
                    <th>Price Rate</th>
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
                    <td><img width="30" height="30" src="upload/topdeals_img/<?php echo $data['image']; ?>" ></td>
                    <td> <?php echo $data['location']; ?></td>
                    <td><?php echo $data['price_rate']; ?></td>
                    <td><?php echo $data['status']; ?></a></td>
                    <td>
                      <a href="edit-topdeals.php?deal_id=<?php echo $data['id']; ?>"><i class="fas fa-edit text-warning"></i></a>
                      <a href="delete.php?file_id=<?php echo $data['id'] ?>&file=top_deals"><i class="fas fa-trash-alt text-danger"></i></a>
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