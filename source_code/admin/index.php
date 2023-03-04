<?php 
session_start();
require('includes/dbconn.php'); 

$error = '';
if(isset($_POST['submit'])){
    $username = $_POST['admin'];
    $password = $_POST['password'];
    $user = $conn->query("SELECT * FROM `admin` WHERE `email`='$username'");
    if($user->num_rows == 1){
        $user_d = $user->fetch_array();
        $hash_password = $user_d['password'];
        if (password_verify($password, $hash_password)) {
          $_SESSION['auth_email'] = $user_d['email'];
          header("Location: dashboard.php");
        } else {
          $error = "Incorrect Password";
        }
    } else {
        $error = "Invalid Username";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Admin-Login</title>

  <?php include 'includes/filescripts.php'; ?>
  <style>
      .login{
        margin: 100px auto;
      }
      .input-group{
          padding:25px;
      }
  </style>
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-11 col-11 login">
            <div class="card card-info">
              
                <div class="card-header mb-3">
                  <h3 class="card-title">MIANDA</h3>
                </div>
              <form action="" method="POST">
                <p style="text-align:center;">
                  <?php echo $error;?>
                </p>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  </div>
                  <input type="email" class="form-control" placeholder="Email" name="admin" required>
                </div>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                  </div>
                  <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>
                <div class="input-group">
                    <button type="submit" style="width:100%;" name="submit" class="btn btn-primary float-right">Login</button>
                </div>
              </form>
            </div>
      </div>
  </div>

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php include 'includes/js.php'; ?>
<!-- /REQUIRED SCRIPTS -->
</body>
</html>
