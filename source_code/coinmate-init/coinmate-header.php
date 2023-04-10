<?php

require($_SESSION['ROOT_PATH'] . "/static/config.inc.php"); 
require($_SESSION['ROOT_PATH'] . "/static/conn.php"); 
require($_SESSION['ROOT_PATH'] . "/lib/profile.php"); 
require($_SESSION['ROOT_PATH'] . "/coinmate-init/coinmate-country-lists.php"); 
require($_SESSION['ROOT_PATH'] . "/classes/class-coinmate.php"); 

// LogedIn user details 
$userDetails = getUserFromName($_SESSION['siteusername'], $conn);

?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $config['pr_title']; ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <link rel="stylesheet" href="<?php echo ROOT_URL; ?>static/css/required.css"> 
        <script>
            var global = {
                root_url: "<?php echo ROOT_URL; ?>"
            }
        </script>
    </head>
    <body>
        <div class="container bootstrap bg-transparent">
            <?php require($_SESSION['ROOT_PATH'] . "/static/header.php"); ?>
            <div class="p-0">
				<div class="d-flex gap-4 mt-3">
                    <div class="flex-1 bg-white d-flex flex-column gap-3 p-4 border-rounded rounded border-radious-4">
                            <h1 class="m-0 text-gray-400">My Coinmate</h1>
                            <button class="btn btn-primary max-auto btn-lg w-100 ">Join Pool</button>
                            <div class="input-group">
                                <input data-bs-toggle="tooltip" data-bs-placement="top" title="Type minimum 3 characters" class="form-control border-end-0 border rounded-pill" type="search"  placeholder="Search" id="searchuser">
                                <span class="input-group-append">
                                    <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>

                            <div class="personal-info pt-3">
                                <ul class="list list-group m-0 p-0 list-unstyled d-flex flex-column gap-3">
                                    <li><a class="link-secondary text-decoration-none <?php echo !isset($_GET['action']) ? 'active' : ''; ?>" href="<?php echo ROOT_URL; ?>/coinmate.php">Personal Information</a></li>
                                    <li><a class="link-secondary text-decoration-none <?php echo isset($_GET['action']) && $_GET['action'] == 'edit' ? 'active' : ''; ?>" href="<?php echo ROOT_URL; ?>/coinmate.php?action=edit">Edit Profile</a></li>
                                    <li><a class="link-secondary text-decoration-none <?php echo isset($_GET['action']) && $_GET['action'] == 'my-messages' ? 'active' : ''; ?>" href="<?php echo ROOT_URL; ?>/coinmate.php?action=my-messages">My Messages</a></li>
                                    <li><a class="link-secondary text-decoration-none" href="#">Manage Images</a></li>
                                    <li><a class="link-secondary text-decoration-none" href="#">Manage Videos</a></li>
                                </ul>
                            </div>
                    </div>
                    <div class="flex-3 w-100 bg-white rounded">
                        
