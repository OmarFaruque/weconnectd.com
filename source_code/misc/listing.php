<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/conn.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/lib/profile.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $config['pr_title']; ?></title>
        <link rel="stylesheet" href="/static/css/required.css"> 
    </head>
    <body>
        <div class="container">
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/header.php"); ?>
            <br>
            <div class="padding">
                <h1 and id="noMargin">Listing and Advertising</h1><br>
                <b>This feature is not yet available.</b> To list on Coin Blast only <b>Goldencoin</b> and <b>BEAM</b> coins will be accepted. To advertise on front page only <b>Coinconnect</b>,  <b>Litecoin,</b> and <b>Tron</b> will be accepted. Coin Blast Listing will last two weeks and front page advertising will last one week. Click "Contact WeConnectd" at bottom of page to request to be Listed or Advertised. </h2>
            </div>
        </div>
        <br>
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/footer.php"); ?>
    </body>
</html>