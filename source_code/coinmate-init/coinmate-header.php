<?php

require($_SESSION['ROOT_PATH'] . "/static/config.inc.php"); 
require($_SESSION['ROOT_PATH'] . "/static/conn.php"); 
require($_SESSION['ROOT_PATH'] . "/lib/profile.php"); 
require($_SESSION['ROOT_PATH'] . "/coinmate-init/coinmate-country-lists.php"); 
require($_SESSION['ROOT_PATH'] . "/classes/class-coinmate.php"); 


$coinmate = new Coinmate($conn);
$coinmate->user_id = $_SESSION['user_id'];

//UPdate process
$msg = false;
if(isset($_POST['name'])){
    $msg = $coinmate->update_coinbase_profile($_POST);
}

// Update pool status
if(isset($_POST['action']) && $_POST['action'] == 'update_pool_status'){
    $coinmate->update_pool_status();
}
$userDetails = $coinmate->get_user();

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
                root_url: "<?php echo ROOT_URL; ?>", 
                user_id: <?php echo $userDetails['id']; ?>
            }
        </script>
    </head>
    <body>
        <div class="container bootstrap bg-transparent">
            <?php require($_SESSION['ROOT_PATH'] . "/static/header.php"); ?>
            <div class="p-0">
				<div class="d-flex gap-4 mt-3 position-relative">
                    <!-- Loader -->
                    <div id="loader" style="background-color: #ffffff99" class="position-absolute start-0 top-0 w-100 h-100 zindex-fixed">
                        <div class="d-flex justify-content-center position-absolute top-50 start-50 translate-middle">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 bg-white d-flex flex-column gap-3 p-4 border-rounded rounded border-radious-4">
                            <h1 class="m-0 text-gray-400">My Coinmate</h1>
                            <form action="" method="post">
                                <input type="hidden" name="action" value="update_pool_status">
                                <button type="submit" class="btn max-auto btn-lg w-100 <?php echo $userDetails['pool_status'] ? 'btn-primary' : 'btn-danger'; ?> "><?php echo $userDetails['pool_status'] ? 'Remove Pool': 'Join Pool'; ?></button>
                            </form>                            
                            
                            <!-- <div class="input-group">
                                <input data-bs-toggle="tooltip" data-bs-placement="top" title="Type minimum 3 characters" class="form-control border-end-0 border rounded-pill" type="search"  placeholder="Search" id="searchuser">
                                <span class="input-group-append">
                                    <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div> -->
                            <hr>
                            <form id="searchForm">
                                <div class="mb-3 row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <select data-bs-toggle="tooltip" data-bs-placement="top" title="Select Age Range" class="form-control" name="age" id="ageRange">
                                                <option value="">Select age range...</option>
                                                <option value="18-35">18-35</option>
                                                <option value="36-45">36-45</option>
                                                <option value="46-65">46-65</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="d-grid">
                                        <select class="form-select" name="sex" id="ssex" data-bs-toggle="tooltip" data-bs-placement="top" title="Gender">
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="d-grid">
                                        <input type="text" data-bs-toggle="tooltip" data-bs-placement="top" title="Zip code" class="form-control" name="zipcode" id="szipcode" placeholder="ZipCode">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <div class="d-grid">
                                        <input type="text" data-bs-toggle="tooltip" data-bs-placement="top" title="City" class="form-control" name="city" id="scity" placeholder="City...">
                                    </div>
                                </div>

                                <div class="mb-3 row" data-bs-toggle="tooltip" data-bs-placement="top" title="Country">
                                    <select class="form-select select2" name="country" id="scountry">
                                        <option value="">Country...</option>
                                        <?php foreach($countries as $k => $country): ?>
                                        <option value="<?php echo $k; ?>"><?php echo $country; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                            
                                <div class="mb-3 row">
                                    <div class="d-grid">
                                        <button type="submit" id="searchuser" class="btn btn-primary btn-block">Action</button>
                                    </div>
                                </div>
                            </form>
                            

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
                        
