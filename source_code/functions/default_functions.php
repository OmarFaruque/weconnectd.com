<?php
/**
 * All default functons
 */

function get_user_by_status($status = 'deleted', $conn = false)
{
   /**
    * Active and deletded user query
    */
   if(!$conn)
      return;

   $active_user = $conn->prepare("SELECT COUNT(*) as `total` FROM `users` WHERE `status`=?");
   $active_user->bind_param('s', $status);
   $active_user->execute();
   $active_user = $active_user->get_result();
   $active_user = $active_user->fetch_assoc();
   return $active_user['total'];
}



/**
 * Check is visitor allow to visit profile or not
 */
function have_visit_access($conn)
{
   if (!isset($_SESSION['siteusername'])) return false;

   if (isset($_GET['id'])) {
      $this_username = $_SESSION['siteusername'];
      $target_user_name = getUserFromId($_GET['id'], $conn);

      $block_user = $conn->prepare("SELECT COUNT(*) as `total` FROM `friends` WHERE `status`='block' AND `sender`=? AND `reciever`=?");
      $block_user->bind_param('ss', $target_user_name['username'], $this_username);
      $block_user->execute();
      $block_user = $block_user->get_result();
      $block_user = $block_user->fetch_assoc();

      return $block_user['total'] <= 0;
   }

   return true;
}

function getUserFromUsername($username, $connection)
{
    $stmt = $connection->prepare("SELECT * FROM `users` WHERE `username` = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($result->num_rows === 0)
        return ('That user does not exist.');
    $stmt->close();

    return $user;
}

function burnUserProfile($id, $conn)
{
    $qry = $conn->prepare("UPDATE `users` SET `status` = 'deleted' WHERE `id` = ?");
    $qry->bind_param('i', $id);
    $execute = $qry->execute();
    $qry->close();

    $_SESSION = array();

    header("Location: ../index.php");
    if($execute){
      echo 'yes it execute <br/>';
    }
}



/**
 * Create Fake Data to DB 
 */
function create_fake_data($count = 5)
{
   require_once $_SESSION['ROOT_PATH'] . '/vendor/autoload.php';
   require($_SESSION['ROOT_PATH'] . "/static/config.inc.php");
   require($_SESSION['ROOT_PATH'] . "/static/conn.php");
   require($_SESSION['ROOT_PATH'] . "/lib/register.php");


   for ($i = 1; $i <= $count; $i++) {
      $faker = Faker\Factory::create();

      $username = str_replace(' ', '', strtolower($faker->name));
      $email = $faker->email;
      $passwordhash = password_hash($faker->password, PASSWORD_DEFAULT);
      $account_type = 'Basic Account';

      register($username, $email, $passwordhash, $account_type, $conn);
   }
}