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
if(isset($_GET['category_id'])){
  $category_id = $_GET['category_id'];
  $category = $conn->query("SELECT * FROM blog_category WHERE id='$category_id'")->fetch_array()['name'];

  $d = $conn->query("SELECT * FROM blog WHERE category_id='$category_id' ORDER BY `date` DESC");
} else if(isset($_GET['author'])){
  $author = $_GET['author'];

  $d = $conn->query("SELECT * FROM blog WHERE author='$author' ORDER BY `date` DESC");
} else {
  $d = $conn->query("SELECT * FROM blog ORDER BY `date` DESC");
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
            <h1 class="m-0">Manage Blog</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">View <?php if(isset($category)){ echo $category; } ?> Blog</li>
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
                <h3 class="card-title">View <?php if(isset($category)){ echo $category; } ?> Blog</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Image</th>
                     <th>Title</th>
                    <th>Author</th>
                    <th>Date</th>
                   
                    <th>Status</th>
                    <th>Meta Tag</th>
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
                    <td> <img src="upload/blog_img/<?php echo $data['image']; ?>" alt="" height="50" width="50">  </td>
                    <td><?php echo $data['title']; ?></td>
                    <td><?php echo $data['author']; ?></td>
                    <td><?php echo $data['date']; ?></td>
                    <td><?php echo $data['status']; ?></td>
                    <td>
                    <?php
                        $m = $conn->query("SELECT * FROM meta_tag WHERE page='blog' AND page_row_id='".$data['id']."'");
                        if($m->num_rows > 0){
                            ?>
                            <a href="edit-meta-tag.php?page=blog&page_row_id=<?php echo $data['id'] ?>"><i class="fa fa-edit"></i></a>
                            <?php
                        } else{
                            ?>
                            <a href="add-meta-tag.php?page=blog&page_row_id=<?php echo $data['id'] ?>"><i class="fa fa-plus"></i></a>
                            <?php
                        }
                        ?>
                    </td>
                    <td>
                      <a href="edit-blog.php?blog_id=<?php echo $data['id']; ?>"><i class="fas fa-edit text-warning"></i></a>
                      <a href="delete.php?file_id=<?php echo $data['id'] ?>&file=blog"><i class="fas fa-trash-alt text-danger"></i></a>
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