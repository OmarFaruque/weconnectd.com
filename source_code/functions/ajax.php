<?php 
require("../static/config.inc.php");
require("../static/conn.php");
require("../lib/register.php");

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'fb_login'){
    $data = array();
    try{
        $needRegistration = false;

        $username = $email = $_REQUEST['fb_data']['email'];
        $username = explode('@', $username);
        $username = $username[0];
        $passwordhash = password_hash(@$email, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if( !$result->num_rows ) $needRegistration = true;
        
        $stmt_email = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt_email->bind_param("s", $email);
        $stmt_email->execute();
        $result_email = $stmt_email->get_result();
        if(!$result_email->num_rows) $needRegistration = true;

        if($needRegistration){
            if(register($username, $email, $passwordhash, $account_type = 'Basic Account', 'fb', $conn)) {
                $data['signup'] = 'success';
                $needRegistration = false;     
            }	
        }

        if(!$needRegistration){
            $stmt = $conn->prepare("SELECT * FROM `users` WHERE email = ? OR username=?");
            $stmt->bind_param("ss", $email, $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if (mysqli_num_rows($result)) {
                $row = $result->fetch_assoc();
                $_SESSION['siteusername'] = $row['username'];
                $_SESSION['user_id'] = $row['id'];
                $data['login'] = 'success';
            }
        }
    }
    catch (\Error $e) {
        http_response_code(500);
        $data['error'] = $e->getMessage();
    }
    echo json_encode($data);
}



// Coinmate search ajax callback
if(isset($_POST['coinmate_search']) && !empty($_POST['coinmate_search'])){
    $data = array();
    try{
        $args = "SELECT * FROM `users` WHERE email LIKE '%".$_POST['coinmate_search']."%' OR username LIKE '%".$_POST['coinmate_search']."%' OR name LIKE '%".$_POST['coinmate_search']."%'";
        $stmt = $conn->prepare($args);
        // $stmt->bind_param("ss", $_POST['coinmate_search'], $_POST['coinmate_search']);
        // $data['qry'] = $args;
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result)) {
            $users = array();
            while($row = $result->fetch_assoc()){
                array_push($users, $row);
            }
            $data['users'] = $users;
        }
        
    }
    catch(\Error $e){
        $data['error'] = $e->getMessage();
    }
    echo json_encode($data);
}