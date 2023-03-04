<?php
    $config = array();

    $config['pr_title'] = "WeConnectd";
    $config['db_user'] = "weconnec_omar";
    $config['db_pass'] = "Mahmud123698";
    $config['db_name'] = "weconnec_main";
    $config['db_host'] = "localhost";

    $config['recaptcha_secret'] = "";
    $config['recaptcha_sitekey'] = "";

    $config['steam_web_id'] = "";




    //For locaho host (should be remove after development in local computer)
    $config['db_name'] = "lniulpmgc_weconnect2";
    $config['db_user'] = "root";
    $config['db_pass'] = "";


    // echo 'serveR host <br/><pre>';
    // print_r($_SERVER);
    // echo '</pre>';
    
    $root_url = 'https://weconnectd.com/';
    if(isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == '192.168.64.2')
        $root_url = 'http://192.168.64.2/weconnectd.com/';

    if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost')
        $root_url = 'http://localhost:'.$_SERVER['SERVER_PORT']. '/www/app/';
    
    if(!defined('ROOT_URL')) define('ROOT_URL', $root_url);
    
    // echo 'server name: ' . $_SERVER['SERVER_NAME'] . '<br/>';
    // echo 'server port: ' . $_SERVER['SERVER_PORT'] . '<br/>';
    // echo 'server request URL: ' . $_SERVER['REQUEST_URI'] . '<br/>';
    //require($_SERVER['DOCUMENT_ROOT'] . '/vendor/smith197/steamauthentication/steamauth/steamauth.php');
?>
