<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/conn.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/lib/profile.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $config['pr_title']; ?></title>
        <link rel="stylesheet" href="/static/css/required.css"> 
		<style>
			.item1 img{
				border: 1px solid;
				border-radius:50%;
			}
			
			.pagging a{
				padding:5px 10px;
    background: #c78888;
    color: #fff;
			}
			.pagging .active{
    background: #f57c00;
			}
		</style>
    </head>
    <body>
        <div class="container">
			<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/header.php"); ?>
            <?php 
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                
                $total_pages = $conn->query('SELECT COUNT(*) FROM users')->fetch_row()[0]; 
                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                $num_results_on_page = 12;

                $stmt = $conn->prepare("SELECT * FROM users ORDER BY username LIMIT ?,?");
                $calc_page = ($page - 1) * $num_results_on_page;
                $stmt->bind_param('ii', $calc_page, $num_results_on_page);
                $stmt->execute();
                $result = $stmt->get_result();
            ?>
            <br>
                <div class="padding" style="margin-top:25px;">
                    <div class="pagging">
                    <center>
                    <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
						
                        <?php if ($page > 1): ?>
                        <a href="users.php?page=<?php echo $page-1 ?>">Prev</a>
                        <?php endif; ?>

                        <?php if ($page > 3): ?>
                        <a class="<?php if($page == 1){ echo 'active'; } ?>" href="users.php?page=1">1</a>
                        ...
                        <?php endif; ?>

                        <?php  if ($page-2 > 0): ?><a href="users.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a><?php endif; ?>
                        <?php  if ($page-1 > 0): ?><a href="users.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a><?php endif; ?>

                        <a class="active" href="users.php?page=<?php echo $page ?>"><?php echo $page ?></a>

                        <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><a href="users.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a><?php endif; ?>
                        <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><a href="users.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a><?php endif; ?>

                        <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                        ...
                        <a href="users.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a>
                        <?php endif; ?>

                        <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                        <a href="users.php?page=<?php echo $page+1 ?>">Next</a>
                        <?php endif; ?>
                    <?php endif; ?>
                            <br>
                        </center>
                    </div>
                </div>
            <div class="padding">
                <div class="login">
                    <div class="loginTopbar">
                        <b>All Users</b>
                    </div>
                    <div class="grid-container">
                        <?php
                            while($row = $result->fetch_assoc()) { 
                        ?>
                            <div class="item1">
								<a href="profile.php?id=<?php echo getIDFromUser($row['username'], $conn); ?>">
									<div><b><center><?php echo $row['username']; ?></center></b></div>
									<img src="/dynamic/pfp/<?php echo getPFPFromUser($row['username'], $conn); ?>">
								</a>
						    </div>
                        <?php } ?>
                    </div>
                </div>

                <br>
                <table class="cols">
                    <tbody>
                        <tr>
                            <td>
                                <b>Get Started!</b><br>
                                Join for free, and view profiles, connect with others, blog, customize your profile, and much more!<br><br><br>
                                <span id="splash">?? <a href="register.php">Learn More</a></span>	
                            </td>
                            <td>
                                <b>Create Your Connects!</b><br>
                                Tell us about yourself, upload your pictures, and start adding connects to your network.<br><br><br><br>
                                <span id="splash">?? <a href="register.php">Start Now</a></span>		
                            </td>
                            <td>
                                <b>Browse Profiles!</b><br>
                                Read through all of the profiles on WeConnectd! See pix, read blogs, and more!<br><br><br><br>
                                <span id="splash">?? <a href="users.php">Browse Now</a></span>
                            </td>
                            <td>
                                <b>Invite Your Connects!</b><br>
                                Invite your connects, and as they invite their connects your network will grow even larger!<br><br><br><br>
                                <span id="splash">?? <a href="register.php">Invite Connects Now</a></span>	
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/footer.php"); ?>
    </body>
</html>