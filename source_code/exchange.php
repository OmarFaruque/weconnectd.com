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
				<center><u><b>WANT TO EXCHANGE?</b></u></center>
				
					<p><br><b>COINCONNECT</b></br>
		<img src="coinconnect.png" alt="Coinconnect" style="width:50px;height:50px;>
															<img src="coinconnect.png" alt="Coinconnect"></p> <a href="http://cratex.io" TARGET="_blank">http://cratex.io</a>

			<p><br><b>GOLDENCOIN</b></br>
										  <img src="goldencoin.png" alt="Goldencoin" style="width:50px;height:50px;>
			<img src="exbitron.png" alt="Exbitron"></p>
				<a href="http://exbitron.com" TARGET="_blank">http://exbitron.com</a>

        </div>
        <br>
		
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/footer.php"); ?>
    </body>
</html>