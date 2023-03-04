<?php session_start(); ?>
<?php
 include 'includes/dbconn.php'; 
 $page = 'faqs';
 ?>
<?php include 'includes/auth_head.php'; ?>
<?php
if($auth === TRUE){
  ?>
<?php
if(isset($_GET['faq_id'])){
    $faq_id = $_GET['faq_id'];
    $edit = $conn->query("SELECT * FROM `faqs` WHERE `id`='$faq_id'");
    if($edit->num_rows == 1){
        $edit_d = $edit->fetch_array();
        $edit_ques = $edit_d['question'];
        $edit_ans = $edit_d['answer'];
        if (isset($_POST['submit'])) {
          $question = htmlspecialchars($_POST['question']);
          $answer = htmlspecialchars($_POST['answer']); 

          $save_data_in_db = "UPDATE `faqs` SET `question`='$question', `answer`='$answer' WHERE id='$faq_id'";
  
          $result = $conn->query($save_data_in_db);
          if ($result === TRUE) {
            echo "<script>
            alert('Updated Successfully');
            location.href = 'faq.php?faq_id=$faq_id';
            </script>";
          } else {
            echo "<script>
            alert('Something Went Wrong!');
            location.href = 'faq.php?faq_id=$faq_id';
            </script>";
          }
        }
    } else {
        echo "<script>
        alert('Invalid Request!');
        location.href = 'faq.php';
        </script>";
    }
} else {
 if (isset($_POST['submit'])) {
  $question = htmlspecialchars($_POST['question']);
  $answer = htmlspecialchars($_POST['answer']); 

  $save_data_in_db = "INSERT INTO `faqs` (`question`, `answer`) VALUES ('$question', '$answer')";
  
  $result = $conn->query($save_data_in_db);
  if ($result === TRUE) {
    echo "<script>
    alert('Added Successfully');
    location.href = 'faq.php';
    </script>";
  } else {
    echo "<script>
    alert('Something Went Wrong!');
    location.href = 'faq.php';
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
  <title>FAQs</title>
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
            <h1 class="m-0">Manage FAQ's</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Manage FAQ's </li>
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
                <h3 class="card-title"><?php if(isset($faq_id)){ echo "Update"; } else { echo "Add"; }?> FAQ's</h3>
                <?php if(isset($faq_id)){?> <a href="faq.php" class="btn btn-warning float-right">Add FAQs</a> <?php }?>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Question</label> 
                    <div class="col-sm-10">
                      <textarea name="question" class="form-control"><?php if(isset($edit_ques)){ echo $edit_ques; } else { echo ''; } ?></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Answer</label> 
                    <div class="col-sm-10">
                       <textarea name="answer" class="form-control"><?php if(isset($edit_ans)){ echo $edit_ans; } else { echo ''; } ?></textarea>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-info float-right"><?php if(isset($faq_id)){ echo "Update"; } else { echo "Add"; }?> Faq</button>
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">View FAQs</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $d = $conn->query('SELECT * FROM faqs');
                    if($d->num_rows > 0){
                      $i=0;
                      while($data = $d->fetch_assoc()){
                        $i++;
                        ?>
                  <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $data['question']; ?></td>
                    <td><?php echo $data['answer']; ?></a></td>
                    <td>
                      <a href="faq.php?faq_id=<?php echo $data['id']; ?>"><i class="fas fa-edit text-warning"></i></a>
                      <a href="delete.php?file_id=<?php echo $data['id'] ?>&file=updatefaqs"><i class="fas fa-trash-alt text-danger"></i></a>
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