<?php require("static/config.inc.php"); ?>
<?php require("static/conn.php"); ?>
<?php require("lib/profile.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $config['pr_title']; ?></title>
        <link rel="stylesheet" href="/static/css/required.css"> 
        <script src='https://www.google.com/recaptcha/api.js' async defer></script>
        <link rel="stylesheet" href="/static/css/table2.css"> 
        <script src="/onLogin.js"></script>
        <style>
            .customtopLeft {
                float: left;
                width: calc( 30% - 20px );
                padding: 10px;
            }

            .customtopRight {
                float: right;
                width: calc( 70% - 20px );
                padding: 10px;
            }
        </style>
        <?php if(!isset($_SESSION['siteusername'])) { header("Location: login.php"); } ?>
        <?php $user = getUserFromName($_SESSION['siteusername'], $conn); ?>
    </head>
    <body>
        <div class="container">
            <?php
                $stmt = $conn->prepare("SELECT * FROM `pms` WHERE `sto` = ? AND `isRead` = 0");
                $stmt->bind_param("s", $_SESSION['siteusername']);
                $stmt->execute();
                $result = $stmt->get_result();

                while($row = $result->fetch_assoc()) {
                    $substmt = $conn->prepare("UPDATE `pms` SET `isRead` = 1 WHERE `id` = ?");
                    $substmt->bind_param("i", $row['id']);
                    $substmt->execute();
                    $substmt->close();
                }
                $stmt->close();

                require("static/header.php");
            ?>
            <div class="padding">
                <span id="padding10">
                    <small><a href="/">WeConnectd</a> / <a href="/pms.php">Incoming PMs</a></small>
                </span><br>
                <div class="customtopLeft">  
                    <div class="splashBlue">
                        Remember to not send harmful messages and make sure your private message is not against the terms of service!
                    </div><br>
                    <center><img style="width: 10em;" src="dynamic/pfp/<?php echo $user['pfp']; ?>"></center><br>
                </div>
                <div class="customtopRight">
                    <center><a href="sentpms.php"><button>View Sent PMs</button></a></center>
                    <table id="replies">
                        <tr>
                            <th style="width: 20%;">Author</th>
                            <th style="width: 60%;">Text</th>
                            <th style="width: 10%;">Date</th>
							<th style="width: 10%;">Reply</th>
                        </tr>
                        <?php 
                            $stmt = $conn->prepare("SELECT * FROM pms WHERE sto = ? ORDER BY id DESC");
                            $stmt->bind_param("s", $_SESSION['siteusername']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while($row = $result->fetch_assoc()) { 
                        ?>
                            <tr>
                                <td>
                                    <center>
                                        <a href="/profile.php?id=<?php echo getIDFromUser($row['sfrom'], $conn); ?>">
                                            <img style="height: 3em; width: 3em;" src="/dynamic/pfp/<?php echo getPFPFromUser($row['sfrom'], $conn); ?>"><br>
                                            <b><?php echo $row['sfrom']; ?></b>
                                        </a>
                                    </center>
                                </td>
                                <td><?php echo $row['message']; ?></td>
                                <td><?php echo $row['date']; ?></td>
								<td>
									<a href="/pm.php?id=<?php echo getIDFromUser($row['sfrom'], $conn); ?>">Reply</a>
								</td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <?php require("static/footer.php"); ?>
    </body>
</html>