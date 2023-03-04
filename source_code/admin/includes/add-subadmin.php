<?php
define('HOST', 'localhost');  
define('USER', 'root');  
define('PASS', 'Satendra');  
define('DB', 'pflight'); 

class SubAdmin {
    public
    function __construct() {  
      $conn  = new mysqli(HOST, USER, PASS, DB);
      $error = '';
      $this->conn = $conn;
      $this->error = $error;
    }  

    public
    function addSubadmin($name, $email, $photo, $admin_type, $password, $cpassword){
        $check_email = $conn->query("SELECT * FROM `admin` WHERE `email`='$email'");
        if($check_email->num_rows > 0){
            $this->error = 'This Email is already Exist';
        } else {
            if($password == $cpassword){
                $add = $conn->query("INSERT INTO `admin` (`name`, `email`, `photo`, `admin_type`, `permission`, `password`) VALUES ('$name', '$email', '$photo', '$admin_type', '$permission', '$password')");
                if($add === TRUE){
                    return TRUE;
                }
            } else{
                $this->error = "Password didn't mathch";
            }
        }
    }
  
}

?>