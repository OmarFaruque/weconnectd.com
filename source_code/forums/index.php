<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/conn.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/lib/profile.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $config['pr_title']; ?></title>
        <link rel="stylesheet" href="/static/css/required.css"> 
        <link rel="stylesheet" href="/static/css/table2.css"> 
        <style>
            .customtopLeft {
                float: left;
                width: calc( 22% - 20px );
                padding: 10px;
            }

            .customtopRight {
                float: right;
                width: calc( 78% - 20px );
                padding: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/header.php"); ?>
            <br>
            
            <div class="padding">
                <small><a href="/">WeConnectd</a> / <a href="/forums/">Forums</a></small><br>
                <div class="customtopLeft">  
                    <div class="sideblog">
                        <h3>My Controls</h3>
						
                        <ul>
							<?php
							$fc = $conn->query("SELECT * FROM forum_category");
							if($fc->num_rows>0){
								while($fc_d = $fc->fetch_assoc()){
									?>
							 <li><a href="" class="man"><?php echo $fc_d['name']; ?></a></li>
							        <?php
								}
							}
							?>
                        </ul>
                    </div>
                </div>
							<center><img src="forumpic2.png" alt="Forum Pic"></center>

                <div class="customtopRight">  
                    <div class="splashBlue">
                        <h1 id="noMargin">WeConnectd Forums</h1>These are heavily under construction. Don't expect everything to completely work at this point.
                    </div><br>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Last Modified</th>
                        </tr>
                        <?php 
                            $stmt = $conn->prepare("SELECT * FROM categories");
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while($row = $result->fetch_assoc()) { 
                        ?>
                            <tr>
                                <td><a href="category.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo $row['lastmodified']; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/footer.php"); ?>
    </body>
</html>