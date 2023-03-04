<?php if (session_status() === PHP_SESSION_NONE) session_start();
if(!isset($_SESSION['siteusername']))  header("Location: index.php");

require($_SESSION['ROOT_PATH'] . "/static/config.inc.php"); 
require($_SESSION['ROOT_PATH'] . "/static/conn.php"); 
require($_SESSION['ROOT_PATH'] . "/lib/profile.php"); 

// LogedIn user details 
$userDetails = getUserFromName($_SESSION['siteusername'], $conn);

// echo 'User Details <pre>';
// print_r($userDetails);
// echo '</pre>';

?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $config['pr_title']; ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="<?php echo ROOT_URL; ?>static/css/required.css"> 
    </head>
    <body>
        <div class="container bootstrap bg-transparent">
            <?php require($_SESSION['ROOT_PATH'] . "/static/header.php"); ?>
            <div class="p-0">
				<div class="d-flex gap-4 mt-3">
                    <div class="flex-1 bg-white d-flex flex-column gap-3 p-4 border-rounded border-radious-4">
                            <h1 class="m-0 text-gray-400">My Coinmate</h1>
                            <button class="btn btn-primary max-auto btn-lg w-100 ">Join Pool</button>
                            <div class="input-group">
                                <input class="form-control border-end-0 border rounded-pill" type="search" value="search" id="example-search-input">
                                <span class="input-group-append">
                                    <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>

                            <div class="personal-info pt-3">
                                <ul class="list list-group m-0 p-0 list-unstyled d-flex flex-column gap-3">
                                    <li><a class="link-secondary text-decoration-none" href="#">Personal Information</a></li>
                                    <li><a class="link-secondary text-decoration-none" href="#">Edit Profile</a></li>
                                    <li><a class="link-secondary text-decoration-none" href="#">My Messages</a></li>
                                    <li><a class="link-secondary text-decoration-none" href="#">Manage Images</a></li>
                                    <li><a class="link-secondary text-decoration-none" href="#">Manage Videos</a></li>
                                </ul>
                            </div>
                    </div>
                    <div class="flex-3 w-100">
                        <div class="d-flex content-items-center">
                            <div class="flex-1">
                                <img src="<?php echo ROOT_URL; ?>/dynamic/pfp/<?php echo $userDetails['pfp']; ?>" class="img-fluid rounded-circle" alt="">
                            </div>
                            <div class="flex-2">
                                <h3><?php echo $userDetails['username']; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        <?php require($_SESSION['ROOT_PATH'] . "/static/footer.php"); ?>
    </body>
</html>