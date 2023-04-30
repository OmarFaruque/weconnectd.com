<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();

$_SESSION['ROOT_PATH'] = dirname($_SERVER['SCRIPT_FILENAME']);
if (!defined('ROOT_PATH'))
    define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME']));

ini_set('display_errors', 1);
require($_SESSION['ROOT_PATH'] . "/static/config.inc.php");
require($_SESSION['ROOT_PATH'] . "/static/conn.php");
require($_SESSION['ROOT_PATH'] . "/lib/profile.php");
require_once($_SESSION['ROOT_PATH'] . "/includes/dbconn.php");


?>

<!DOCTYPE html>
<html>
    <head>
		<meta charset="UTF-8" />
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title><?php echo $config['pr_title']; ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="static/css/required.css"> 
		<link rel="stylesheet" href="OwlCarousel/dist/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="OwlCarousel/dist/assets/owl.theme.default.min.css">
        <style>
			.vlog{
				border: 1px solid #ffc107;
                padding: 20px 10px;
                background: #ffe4c9;
			}
			.vlog .vlog-header{
				background: #f57c00;
                padding: 5px 10px;
                margin: 0px 0px 10px 0px;
                border-radius: 5px;
			}
			.vlog .item{
				background: #12192C;
                color: #fff;
				margin: 10px 0px 20px 0px;
			}
			.vlog .item .title{
				padding: 10px 15px;
                font-size: 14px;
                font-weight: 500;
				border-top: 1px solid #918989;
			}
			.vlog .item .vauthor a{
				font-size:15px;
				font-weight:550;
				color:#fb8c00;
				padding: 5px 10px;
				display: flex;
			}
			.vlog .item .vauthor .author-name{
				padding: 8px;
			}
			.vlog .item .vauthor a img{
				width: 32px;
                height: 32px;
				border-radius:50px;
				border: 1px solid #f57c00;
			}
            .customtopLeft {
                float: left;
                width: calc( 60% - 20px );
                padding: 10px;
            }

            .customtopRight {
                float: right;
                width: calc( 40% - 20px );
                padding: 10px;
            }

            #login {
                text-align: center;
                border: 1px solid #039;
                margin: 0 0 10px 0;
                padding: 20px 10px;
                background: rgb(245 124 0 / 50%);
                box-shadow: 0px 2px 5px 2px;
            }
			
			#login .login-header{
				padding: 0px 0px 5px 0px;
    margin: 0px 0px 20px 0px;
    font-size: 16px;
    font-weight: 600;
    border-bottom: 3px solid #12192C;
			}
			#login .form-row{
				width: 100%;
    display: flex;
    padding: 5px 2px;
    font-size: 14px;
    font-weight: 550;
			}
			#login .form-row .label{
				width: 100px;
				text-align: left;
			}
			#login .form-row .input{
				width: calc(100% - 100px);
			}
            .grid-container {
                display: grid;
                grid-template-columns: auto auto auto;
                grid-gap: 3px;
                padding: 3px;
            }
            
            .grid-container > div {
                text-align: center;
            }

            .grid-container2 > div img {
                    width: 49px;
                    height: 49px;
            }

            .grid-container2 {
                display: grid;
                grid-template-columns: auto auto auto auto;
                grid-gap: 3px;
                padding: 3px;
            }
            
            .grid-container2 > div {
                text-align: center;
            }

            .grid-container > div img {
                width: 49px;
                height: 49px;
                border-radius: 50%;
                border: 1px solid #fb8c00;
            }

            ul {
                list-style-type: square;
                padding-left: 20px;
                margin: 0px;
            }
			.header_img{
				display:flex;
				width:100%;
				height: 240px;
			}
			.header_img .img-left{
				width: 50%;
			}
			.header_img .img-right{
				width:50%;
			}

/*	
	Table Responsive
	===================
	Author: https://github.com/pablorgarcia
 */

@charset "UTF-8";
@import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,700);

.coin-token-blast h1 {
  font-size:3em; 
  font-weight: 300;
  line-height:1em;
  text-align: center;
  color: #4DC3FA;
}

.coin-token-blast h2 {
  font-size:1em; 
  font-weight: 300;
  text-align: center;
  display: block;
  line-height:1em;
  padding-bottom: 2em;
  color: #FB667A;
}

.coin-token-blast h2 a {
  font-weight: 700;
  text-transform: uppercase;
  color: #FB667A;
  text-decoration: none;
}

.coin-token-blast .blue { color: #185875; }
.yellow { color: #FFF842; }

.coin-token-blast .container th h1 {
	  font-weight: bold;
	  font-size: 1em;
  text-align: left;
  color: #ffa726;
}

.coin-token-blast .container td {
	  font-weight: normal;
	  font-size: 1em;
  -webkit-box-shadow: 0 2px 2px -2px #0E1119;
	   -moz-box-shadow: 0 2px 2px -2px #0E1119;
	        box-shadow: 0 2px 2px -2px #0E1119;
}

.coin-token-blast .container {
	  text-align: left;
	  overflow: hidden;
	  width: 100%;
	  margin: 0 auto;
  display: table;
  padding: 0 0 8em 0;
}

.coin-token-blast .container td, .container th {
	  padding-bottom: 2%;
	  padding-top: 2%;
  padding-left:2%;  
}

/* Background-color of the odd rows */
.coin-token-blast .container tr:nth-child(odd) {
	  background-color: #323C50;
}

/* Background-color of the even rows */
.coin-token-blast .container tr:nth-child(even) {
	  background-color: #2C3446;
}
.coin-token-blast table a:hover{
	color: #ffe4c9;
			}
			.coin-token-blast table a{
	color: #ffe4c9;
	font-weight: 600;
			}
.coin-token-blast .container th {
	  background-color: #1F2739;
}

.coin-token-blast .container td:first-child { color: #fff; }

.coin-token-blast .container tr:hover {
   background-color: #464A52;
-webkit-box-shadow: 0 6px 6px -6px #0E1119;
	   -moz-box-shadow: 0 6px 6px -6px #0E1119;
	        box-shadow: 0 6px 6px -6px #0E1119;
}

.coin-token-blast .container td:hover {
  font-weight: bold;
  
  box-shadow: #7F7C21 -1px 1px, #7F7C21 -2px 2px, #7F7C21 -3px 3px, #7F7C21 -4px 4px, #7F7C21 -5px 5px, #7F7C21 -6px 6px;
  transform: translate3d(6px, -6px, 0);
  
  transition-delay: 0s;
	  transition-duration: 0.4s;
	  transition-property: all;
  transition-timing-function: line;
}
           .ctb-img{
	            width: 100%;
	            height: auto;
			   text-align: center;
               background: #fff;
			   margin: 0px 0px -4px 0px;
			}
			.ctb-img img{
				width: 100%;
				height: auto;
			}
			.header_img_left{
				width:50%;
			}
			
        </style>
		 <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
         <script>
            var local = {
                root_url: "<?php echo ROOT_URL; ?>", 
                login_status: <?php echo isset($_SESSION['siteusername']) && isset($_SESSION['user_id']) ? 'true' : 'false'; ?>
            }
         </script>
    </head>
    <body>
    
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v15.0&appId=630777155515309&autoLogAppEvents=1" nonce="jvjpeaPi"></script>
        <div class="container p-0">
            <?php require("static/header.php"); ?>
			<div class="header_img">
				<div class="header_img_left">
					<div class="header_img_up">
						<div class="owl-carousel owl-carousel2 owl-theme owl-loaded">
    <div class="owl-stage-outer">
        <div class="owl-stage">
            <div class="owl-item">
				<img src="images/photo_2022-08-01_19-05-31.jpg">
		    </div>
			<div class="owl-item">
				<img src="images/photo_2022-08-01_19-05-22.jpg">
		    </div>
        </div>
    </div>
</div>
					</div>
					<img style="width:110%;" src="images/IMG_20221006_093353_714.jpg">
				</div>
				<img class="img-right" src="template.png">
			</div>


			
			<!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/markets/cryptocurrencies/prices-all/" rel="noopener" target="_blank"><span class="blue-text">Cryptocurrency Markets</span></a> The Weconnectd Viewer</div>
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-screener.js" async>
  {
  "width": "100%",
  "height": "300",
  "defaultColumn": "overview",
  "screener_type": "crypto_mkt",
  "displayCurrency": "USD",
  "colorTheme": "light",
  "locale": "en"
}
  </script>
</div>
<!-- TradingView Widget END -->
            <br>

			<!--- ctb -->
<div class="ctb">			
			<div class="ctb-img">
                <?php
                $blastImg = $dbconn->query("SELECT coin_token_blast FROM `logos` WHERE `id` = 1");
                ?>
                <?php if ($blastImg && isset($blastImg->num_rows) && $blastImg->num_rows > 0): ?>
				    <img src="admin/upload/logo_img/<?php echo $blastImg->fetch_array()['coin_token_blast']; ?>" alt="coin token blast">
                <?php endif; ?>
			</div>
<div class="owl-carousel owl-theme owl-loaded owl-carousel1">
    <div class="owl-stage-outer">
        <div class="owl-stage">
			
			<?php
            $totel_coin_blast = $dbconn->query("SELECT id FROM coin_token_blast")->num_rows;
            $num_results_on_page = 5;
            $num_of_slides = ceil($totel_coin_blast / $num_results_on_page);
            for ($y = 1; $y <= $num_of_slides; $y++) {
            ?>
            <div class="owl-item">
				<div class="coin-token-blast">
<table class="container" style="color:#fff">
	<thead>
		<tr>
			<th style="width:100px;"><h1>Icon</h1></th>
			<th><h1>Name</h1></th>
			<th><h1>Website</h1></th>
			<th><h1>Market(s)</h1></th>
		</tr>
	</thead>
	<tbody>
		<?php
                $calc_page = ($y - 1) * $num_results_on_page;
                $coin_blast = $dbconn->query("SELECT * FROM coin_token_blast ORDER BY id DESC LIMIT $calc_page,$num_results_on_page");
                if ($coin_blast->num_rows > 0) {
                    while ($coin_blast_data = $coin_blast->fetch_assoc()) {
            ?>
		<tr>
			<td><img style="width: 30px;" src="admin/upload/coin_token_img/<?php echo $coin_blast_data['icon']; ?>" alt="coin blast"></td>
			<td><?php echo $coin_blast_data['name'] ?></td>
			<td><a href="<?php echo $coin_blast_data['website']; ?>"><?php echo $coin_blast_data['website']; ?></a></td>
			<td>
				<?php
                        $mar = explode(",", $coin_blast_data['market']);
                        for ($mi = 0; $mi < count($mar); $mi++) {
                ?>
				<a href="<?php echo $mar[$mi]; ?>"><?php echo $mar[$mi]; ?></a><br>
				<?php
                        }
                ?>
				
			</td>
		</tr>
		        <?php
                    }
                }
                ?>
	</tbody>
</table>
				</div>
		    </div>
			<?php
            }
            ?>
        </div>
    </div>
</div>
			</div>
			<!---- ctb --->
			
            <div class="customtopLeft">
                <div class="padding p-0">
                    <div class="hero">
                        <h1 id="noMargin">WeConnectd.com</h1><a href="https://imgbb.com/"><img style="border-radius:50%;" src="https://i.ibb.co/7Nk7FFq/IMG-20220606-150514-305-5.jpg" alt="IMG-20220606-150514-305-5" border="0"></a>

                        <p>First and foremost investing in <b>cryptocurrency is very risky and dangerous</b>. This is not a get rich quick scheme. Only use money you are willing to lose if you do venture into crypto. Protect your passwords and private keys. Please beware of hackers and scammers contacting you. Try to keep it street and community based. May the fortune be with you and your Coinconnects.</p> 
						
						<b>Weconnectd.com</b>
(Myspace clone) was created to help people with small finance become financially stable. Most people want to get rich quick but this is not the message. This is for long term investors who want to build things in their community. Businesses that plan to incorporate and or integrate crypto into them. Music and movies have gone digital more than ever now. Money looks like its going further in that direction  too. This is a platform for you to discover new crypto and other things like music, movies, sports, and videogames. Its a place to meet people in crypto and make it real. It seems like alot of things in society are scams so lets change that. Time for the urban community to learn about the blockchain and secure their financial future. <p>You should refrain from sending any type of money, reward points, or cryptocurrencies to any unknown users for any reasons. You will probably be scammed and lose your custody for nothing in return. <b>WECONNECTD.COM IS NOT RESPONSIBLE FOR YOUR LOSES OFF SITE!!!</b> You may probably be frustrated but that is your responsibility. Cryptocurrencies allow everyday people the ability to turn pennies and dollars into hundred or more. But can also turn thousands into less than a penny over a short period of time or long depending on your timing. It is similar to the stock markets but is more accelerated and volatile. You can go from $100 dollars to $.009 cents before you see it.</p><p>The blockchain is away for the middle person to be removed. Its about exposing data and making it difficult for bad government officials to move  and hide money from the people.  So to help power <b>WeConnectd</b>, the crypto blockchain <b>Coinconnect</b> will be used to support. Coinconnect is a Proof of Work and Proof of Stake coin that has its own blockchain. You can start mining immedialty but you have to hold your coins for 30 days to start earning from staking. This site is great for anybody trying to join a social gathering in cryptocurrency. We encorage developers of coins/tokens to register and gain coinconnects. The site is still in development and there will be new features added to boost the experience. Stay tuned, build and be alert. "YOU ARE THE GREATEST ROI." <b>Powered By</b><br><img src="template3.png"></P></br><br><?php if (!isset($_SESSION['siteusername'])): ?><br>
                            <a href="<?php echo ROOT_URL; ?>register.php"><button>Join</button></a><?php endif ?>
                    </div>
                    <div class="login">
                        <div class="loginTopbar">
                            <b>Online Users</b>
                        </div>
                        <div class="grid-container2">
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM users");
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {
                                $lastLoginReal = (int) strtotime($row['lastlogin']);
                                if (time() - $lastLoginReal < 15 * 60) { ?>
                                    <div class="item1"><a href="profile.php?id=<?php echo getIDFromUser($row['username'], $conn); ?>"><div><center><?php echo $row['username']; ?></center></div><img src="<?php echo ROOT_URL; ?>dynamic/pfp/<?php echo getPFPFromUser($row['username'], $conn); ?>"></a></div>
                                    <?php }
                            } ?>
                        </div>
                    </div>
				<br>
                    <div class="splashBlue">
                        Always make sure you're visiting the real WeConnectd.com!
                        <ul>
                            <li>Check the URL in your browser.</li>
                            <li>Make sure it begins with http://www.WeConnectd.com/</li>
                            <li>If ANY OTHER PAGE asks for your info, DON'T LOG IN!</li>
                        </ul>
                    </div>

                    <br>
                    <div class="blogs">
                        <div class="blog-header">
                            <b>WeConnected Member Blogs</b><span style="float: right; color: white;"><small><a style="color: white;" href="/blogs/">[view more]</a></small></span>
                        </div>
                        <ul>
                        <?php


                        $stmt = $conn->prepare("SELECT * FROM blogs WHERE visiblity = 'Visible' ORDER BY id DESC LIMIT 10");
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <li><span id="blogPost"><?php echo $row['subject']; ?> by <b><a href="/profile.php?id=<?php echo getIDFromUser($row['author'], $conn); ?>"><?php echo htmlspecialchars($row['author']); ?></a></b> [<a href="/blogs/view.php?id=<?php echo $row['id']; ?>">+</a>]</span></li>
                        <?php } ?>
                        </ul>
                    </div><br>
		                    
                    <div class="section" id="splash_greybox">
                        <span id="ctl00_Main_SplashDisplay_Splash">
                            <!--<script type="text/javascript">
                                MySpaceRes.Header = {"Cancel":"Cancel / Cancelación","Continue":"Continue / Continuar"};
                            </script>--->
                        <style>
                            #splash_greybox {height: auto;border:none;background-color:transparent;}
                            #splash_graybox {background-color:#F2F5F7; border:1px solid #D0E4FD; padding-bottom:1px;}
                            #splash_graybox {width:496px;}
                            #splash_graybox .grayboxtable a {height:16px;padding-left:2px;font-family: Arial;font-weight:normal; font-size:12px;cursor:hand;}
                            #splash_graybox .grayboxtable a span {height:18px;vertical-align:middle;}
                            #splash_graybox {padding-top:4px;padding-bottom:2px;}
                            #splash_graybox .grayboxtable col {width:110px;}
                            #splash_graybox .grayboxtable td {padding-bottom:2px; _padding-bottom:0px;}

                            .gbicon
                            {
                                background:transparent url(/static/graybox006.gif) no-repeat scroll 0%;
                                float:left;
                                height:16px;
                                margin:0;
                                padding:0;
                                vertical-align:middle;
                                width:24px;
                            }

                            #gbitem { position: relative; width: 98%; background:none !important; padding:2px !important; clear:both; }
                            #gbitem a { font-family: Arial, Verdana; color: #1f1f7a; font-size: 11px; }
                            .gbicon { position: relative; }

                            #imgbicon {background-position:0px -5px;}
                            #profileeditorgbicon {background-position:0pt -23px;}
                            #blogsgbicon {background-position:0pt -42px;}
                            #chatroomsgbicon {background-position:0pt -61px;}
                            #classifiedsgbicon {background-position:0pt -79px;}
                            #eventsgbicon {background-position:0pt -97px;}
                            #forumsgbicon {background-position:0pt -116px;}
                            #groupsgbicon {background-position:0pt -134px;}
                            #impactgbicon {background-position:0pt -152px;}
                            #jobsgbicon {background-position:0pt -170px;}
                            #newsgbicon {background-position:0pt -188px;}
                            #pollsgbicon {background-position:0pt -568px;}
                            #weathergbicon {background-position:0pt -205px;}
                            #booksgbicon {background-position:0pt -221px;}
                            #comedygbicon {background-position:0pt -240px;}
                            #downloadsgbicon {background-position:0pt -258px;}
                            #filmmakersgbicon {background-position:0pt -277px;}
                            #horoscopesgbicon {background-position:0pt -295px;}
                            #moviesgbicon {background-position:0pt -313px;}
                            #musicgbicon {background-position:0pt -334px;}
                            #musicvideosgbicon {background-position:0pt -353px;}
                            #myspacetvgbicon {background-position:0pt -371px;}
                            #sportsgbicon {background-position:0pt -387px;}
                            #tvondemandgbicon {background-position:0pt -404px;}
                            #mobilegbicon {background-position:0pt -424px;}
                            #ringtonesgbicon {background-position:0pt -442px;}
                            #textalertsgbicon {background-position:0pt -459px;}
                            #findclassmatesgbicon {background-position:0pt -479px;}
                            #grademyprofgbicon {background-position:0pt -497px;}
                            #latinogbicon {background-position:0pt -517px;}
                            #mobilegamegbicon {background-position:0pt -534px;}
                            #celebritygbicon {background-position:0pt -590px;}
                            </style>



                        <div id="splash_graybox">

                        <table class="grayboxtable" cellspacing="0" cellpadding="0" border="0">
                        <colgroup>
                        <col><col><col><col>
                        </colgroup>
                            <tbody><tr>
                            <td><a href="forum">
                                <div class="gbicon" id="forumsgbicon"></div>
                                <span>Forum</span></a></td>
                            <td><a href="http://goldenaddress.org">
                                <div class="gbicon" id="impactgbicon"></div>
                                <span>Generate Address</span></a></td>
                            <td><a href="links">
                                <div class="gbicon" id="findclassmatesgbicon"></div>
                                <span>WeLinks</span></a></td>
                            <td><a href="blogs">
                                <div class="gbicon" id="chatroomsgbicon"></div>
                                <span>Blogs</span></a></td>
                            </tr>
                            <tr>

                            <td style="DISPLAY: none"><a href="files">
                                <div class="gbicon" id="groupsgbicon"></div>
                                <span>Files</span></a></td>
                            <td><a href="pms.php">
                                <div class="gbicon" id="comedygbicon"></div>
                                <span>PMs</span></a></td>
                            <td><a href="connects">
                                <div class="gbicon" id="impactgbicon"></div>
                                <span>Coinconnects</span></a></td>
                            <td><a href="<?php echo ROOT_URL; ?>users.php">
                                <div class="gbicon" id="imgbicon"></div>
                                <span>Users</span></a></td>
                            </tr>
                        </tbody></table>
                        </div>
                        <div class="clear"></div>
                        
                        </span>
                    </div>
                </div>
	
            </div>

                   <?php 
                   if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['password'] && $_POST['email']) {
                       $email = htmlspecialchars(@$_POST['email']);
                       $password = @$_POST['password'];
                       $passwordhash = password_hash(@$password, PASSWORD_DEFAULT);

                       $stmt = $conn->prepare("SELECT * FROM `users` WHERE (email = ? OR username=?) AND `status`!= 'deleted'");
                       $stmt->bind_param("ss", $email, $email);
                       $stmt->execute();
                       $result = $stmt->get_result();
                       if (!mysqli_num_rows($result)) {
                           $error = "incorrect email or password";
                           goto skip;
                       }
                       $row = $result->fetch_assoc();
                       $hash = $row['password'];

                       if (!password_verify($password, $hash)) {
                           $error = "incorrect email or password";
                           goto skip;
                       }
                       $_SESSION['siteusername'] = $row['username'];
                       $_SESSION['user_id'] = $row['id'];

                       echo "<script>location.href = 'manage.php';</script>";
                   }
                   skip:

                   if (isset($error)) {
                       echo "<small style='color:red'>" . $error . "</small>";
                   } ?>
	    <div class="customtopRight">
            <?php if (!isset($_SESSION['siteusername'])): ?>
                <div id="login">
					
					<div class="login-header">Weconnectd Login</div>
					<form method="post">
						<div class="login-form">
							<div class="regularLogin">
                                <div class="form-row">
                                    <div class="label"><label for="email">E-Mail / Username:</label></div>
                                    <div class="input"><input type="text" name="email" id="email"></div>
                                </div>
                                <div class="form-row">
                                    <div class="label"><label for="password">Password:</label></div>
                                    <div class="input"><input name="password" type="password" id="password"></div>
                                </div>
                                <div class="form-row">
                                    <td colspan="2"><input type="checkbox" name="Remember" value="Remember" id="checkbox">
                                    <label for="checkbox">Remember my E-mail</label></td>
                                </div>
                            
                            
                                <div class="form-row">
                                    <div>
                                        <button type="submit" name="login" style="border:none; background:inherit;">
                                            <img src="<?php echo ROOT_URL; ?>static/button_login_main.gif" alt="SIGN UP NOW!"  border="0">
                                        </button>
                                        <a href="register.php">
                                            <img src="<?php echo ROOT_URL; ?>static/button_signup_main.gif" alt="SIGN UP NOW!" name="singup" id="singup" border="0">
                                        </a>
                                    </div>
                                </div>
                                <div class="forgot">
                                    <a href="forgot-password.php">Forgot Password?</a>
                                </div>
                            </div>
                            <div class="facebookLogin">
                                <p>Or</p>
                                <div class="fb-login-button" data-onlogin="fb_login()" data-scope="public_profile,email" id="loginbutton" data-width="" data-size="large" data-button-type="continue_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="true"></div>
                            </div>
						</div>
					</form> 
				</div>
    <?php endif ?> 
			<div class="blogs">
                        <div class="blog-header">
                            <b>WeConnected Member Bulletin</b><span style="float: right; color: white;"><small><a style="color: white;" href="/bulletin/">[view more]</a></small></span>
                        </div>
                        <ul>
                        <?php

                        $stmtbu = $conn->prepare("SELECT * FROM bulletin WHERE visiblity = 'Visible' ORDER BY id DESC LIMIT 10");
                        $stmtbu->execute();
                        $resultbu = $stmtbu->get_result();

                        while ($rowbu = $resultbu->fetch_assoc()) {
                        ?>
                            <li>
								<span id="blogPost"><?php echo $rowbu['subject']; ?> by <b><a href="/profile.php?id=<?php echo getIDFromUser($rowbu['author'], $conn); ?>"><?php echo htmlspecialchars($rowbu['author']); ?></a></b> [<a href="/bulletin/view.php?id=<?php echo $rowbu['id']; ?>">+</a>]</span>
							</li>
                        <?php } ?>
                        </ul>
                    </div><br>
                <div class="login">
                    <div class="loginTopbar">
                        <b>Cool Crypto People</b><span style="float: right; color: white;"><small><a style="color: white;" href="/users.php">[view more]</a></small></span>
                    </div>
                    <div class="grid-container">
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM users ORDER BY id DESC LIMIT 3");
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <div class="item1"><a href="profile.php?id=<?php echo getIDFromUser($row['username'], $conn); ?>">
                                <div><center><?php echo $row['username']; ?></center></div>
								<img src="<?php echo ROOT_URL; ?>dynamic/pfp/<?php echo getPFPFromUser($row['username'], $conn); ?>"></a></div>
                        <?php } ?>
                    </div>
                </div><br>
			<center><img src="coc.gif" alt="ConnectO' Clock" width="260" height="70"></center>
			    <div class="vlog">
					<div class="vlog-header">
						<b>Member ConnectO'Clock</b><span style="float: right; color: white;"><small><a style="color: white;"href="/vlogs/">[View more]</a></small></span>
					</div>
					<div class="vlog-container">
						<?php
                        $stmtv = $conn->prepare("SELECT * FROM videos ORDER BY id DESC LIMIT 3");
                        $stmtv->execute();
                        $resultv = $stmtv->get_result();

                        while ($rowv = $resultv->fetch_assoc()) {
                        ?>
                            <div class="item">
								   
								<video style="width:100%;"
                       controls
                       preload="auto">
                    <source src=
"https://weconnectd.com/uploads/videos/<?php echo $rowv['filename']; ?>"
                       type="video/mp4">
                </video>
								<div class="vauthor">
									<a href="profile.php?id=<?php echo getIDFromUser($rowv['author'], $conn); ?>">
										<img src="<?php echo ROOT_URL; ?>dynamic/pfp/<?php echo getPFPFromUser($rowv['author'], $conn); ?>">
										<div class="author-name"><?php echo $rowv['author']; ?></div>
									</a>
								</div>
								<div class="title">
									<a href="/vlog/view.php?id=<?php echo $rowv['id']; ?>" style="color: #ffe082"><?php echo $rowv['title']; ?></a>
								</div>
						    </div>
                        <?php
                        }
                        ?>
					</div>
			    </div>
            </div>
            <!--
            <div class="padding10">
                <table class="cols" style="margin-top: 800px;">
                    <tbody>
                        <tr>
                            <td>
                                <b>Get Started!</b><br>
                                Join for free, and view profiles, connect with others, blog, customize your profile, and much more!<br><br><br><br>
                                <span id="splash">» <a href="register.php">Learn More</a></span>
                            </td>
                            <td>
                                <b>Create Your Profile!</b><br>
                                Tell us about yourself, upload your pictures, and start adding coinconnects to your network.<br><br><br><br><br>
                                <span id="splash">» <a href="register.php">Start Now</a></span>
                            </td>
                            <td>
                                <b>Browse Profiles!</b><br>
                                Read through all of the profiles on WeConnectd! See pix, read blogs, and more!<br><br><br><br><br>
                                <span id="splash">» <a href="users.php">Browse Now</a></span>
                            </td>
                            <td>
                                <b>Invite Your Coinconnects!</b><br>
                                Invite your Coinconnects, and as they invite their Coinconnects your network will grow even larger!<br><br><br><br><br>
                                <span id="splash">» <a href="register.php">Invite Coinconnects Now</a></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            -->
        </div>
        <br>
        <?php require("static/footer.php"); ?>
        <script src="OwlCarousel/docs/assets/vendors/jquery.min.js"></script>
        <script src="OwlCarousel/dist/owl.carousel.min.js"></script>
         <script src="<?php echo ROOT_URL; ?>static/js/global.js"></script>
    </body>
</html>
