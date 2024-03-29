<?php 
    if (session_status() === PHP_SESSION_NONE) session_start();
    if(!isset($_SESSION['siteusername']))  header("Location: index.php");

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once($_SESSION['ROOT_PATH'] . '/coinmate-init/coinmate-header.php'); 
    $filename = !isset($_GET['action']) ? 'personal' : $_GET['action'];
    ?>
    <div id="commitmentWrap">
        <?php require_once($_SESSION['ROOT_PATH'] . '/coinmate-init/coinmate-'.$filename.'.php');  ?>
    </div>
    <?php
    require_once($_SESSION['ROOT_PATH'] . '/coinmate-init/coinmate-footer.php'); 
    ?>
