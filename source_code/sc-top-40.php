<?php require("static/config.inc.php"); ?>
<?php require("static/conn.php"); ?>
<?php require("lib/profile.php"); ?>
<?php require("includes/dbconn.php"); ?>
<!DOCTYPE html>
<html>
    <head>
		<meta charset="UTF-8" />
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title><?php echo $config['pr_title']; ?></title>
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
.coin-token-blast{
  margin:-4px 0px 20px 0px;
}

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
			}
			.ctb-img img{
				width: 100%;
				height: 100%;
			}
        </style>
		
    </head>
    <body>
        <div class="container">
			<?php require("static/header.php"); ?>
			<!--- ctb -->
<div class="ctb">			
			<div class="ctb-img">
				<img src="admin/upload/logo_img/<?php echo $dbconn->query("SELECT sc_top_40 FROM logos WHERE id=1")->fetch_array()['sc_top_40']; ?>" alt="sc_top_40">
			</div>

				<div class="coin-token-blast">
<table class="container" style="color:#fff">
	<thead>
		<tr>
			<th></th>
			<th style="width:100px;"><h1>Icon</h1></th>
			<th><h1>Name</h1></th>
			<th><h1>Website</h1></th>
			<th><h1>Ticker</h1></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$calc_page = ($y - 1) * $num_results_on_page;
		$coin_blast = $dbconn->query("SELECT * FROM sc_top_40 ORDER BY id DESC LIMIT 40");
		if($coin_blast->num_rows > 0){ 
			$sno = 0;
			while($coin_blast_data = $coin_blast->fetch_assoc()){
				$sno++;
				?>
		<tr>
			<td><?php echo $sno."."; ?></td>
			<td><img style="width: 30px;" src="admin/upload/coin_token_img/<?php echo $coin_blast_data['icon']; ?>" alt="coin blast"></td>
			<td><?php echo $coin_blast_data['name'] ?></td>
			<td><a href="<?php echo $coin_blast_data['website']; ?>"><?php echo $coin_blast_data['website']; ?></a></td>
			<td><?php echo $coin_blast_data['ticker']; ?></td>
		</tr>
		        <?php
			}
		}
		?>
	</tbody>
</table>
				</div>
		
			</div>
			<?php require("static/footer1.php"); ?>
		</div>			
			
			<!---- ctb --->
        <script src="OwlCarousel/docs/assets/vendors/jquery.min.js"></script>
        <script src="OwlCarousel/dist/owl.carousel.min.js"></script>
<script>
var owl = $('.owl-carousel');
owl.owlCarousel({
    items:1,
    loop:true,
    margin:10,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true
});
$('.play').on('click',function(){
    owl.trigger('play.owl.autoplay',[3000])
})
$('.stop').on('click',function(){
    owl.trigger('stop.owl.autoplay')
})
	
</script>
		
    </body>
</html>
