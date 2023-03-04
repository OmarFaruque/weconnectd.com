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
if(isset($_GET['status'])){
  $status = $_GET['status'];
  $d = $conn->query("SELECT * FROM `my_bookings` WHERE `status`='$status' ORDER BY `date_time` DESC");
} else {
  $d = $conn->query("SELECT * FROM `my_bookings` ORDER BY `date_time` DESC");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>View Booking</title>

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
            <h1 class="m-0">Manage Bookings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">View Bookings</li>
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
                <h3 class="card-title">View Bookings</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Ref. Id</th>
                    <th>User Email</th>
                    <th>Date/Time</th>
                    <th>Flight</th>
                    <th>Airline</th>
                    <th>Flight Date</th>
                    <th>Flight Time</th>
                    <th>Audults</th>
                    <th>Total Price</th>
                    <th>Promocode</th>
                    <th>Discount</th>
                    <th>Grand Total</th>
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
                        $flight = $conn->query("SELECT * FROM inventory WHERE id='".$data['flight_id']."'")->fetch_array();
                        
                        if(!empty($data['promocode'])){
                          $discount = $conn->query("SELECT * FROM `promocode` WHERE `promocode`='".$data['promocode']."'");
                          if($discount->num_rows > 0){
                            $discount_d = $discount->fetch_array()['discount'];
                          } else {
                            $discount_d = 0;
                          }
                        } else {
                          $discount_d = 0;
                        }
                        ?>
                  <tr>
                    <td><?php echo $i ?></td>
                    <td> <?php echo $data['refid'] ?></td>
                    <td><?php echo $data['user_email']; ?></td>
                    <td><?php echo $data['date_time']; ?></td>
                    <td><?php echo $flight['airports']; ?></td>
                    <td><?php echo $conn->query("SELECT `name` FROM airlines WHERE id='".$flight['airlines']."'")->fetch_array()['name']; ?></td>
                    <td><?php echo $flight['date']; ?></td>
                    <td><?php echo $flight['de_time']."-".$flight['ar_time']; ?></td>
                    <td><?php echo $data['adults']; ?></td>
                    <td><?php echo $data['total_price']; ?></td>
                    <td><?php echo $data['promocode'] ?></td>
                    <td><?php echo $data['total_price']*( $discount_d/100); ?></td>
                    <td><?php echo $data['total_price'] - ($data['total_price']*( $discount_d/100)); ?></td>
                    <td><?php echo $data['status']; ?></td>
                    <td>
                      <a href="edit-mybooking.php?booking_id=<?php echo $data['id']; ?>"><i class="fas fa-edit text-warning"></i></a>
                      <a href="delete.php?file_id=<?php echo $data['id'] ?>&file=my_bookings"><i class="fas fa-trash-alt text-danger"></i></a>
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