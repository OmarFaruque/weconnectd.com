<?php if (session_status() === PHP_SESSION_NONE)
    session_start();
require($_SESSION['ROOT_PATH'] . "/static/config.inc.php");
require($_SESSION['ROOT_PATH'] . "/static/conn.php");
require($_SESSION['ROOT_PATH'] . "/lib/profile.php");
ini_set('display_errors', 0);
?>
<!DOCTYPE html>
<html>

<head>
    <title>
        <?php echo $config['pr_title']; ?>
    </title>
    <link rel="stylesheet" href="<?php echo ROOT_URL; ?>static/css/required.css">
    <link rel="stylesheet" href="<?php echo ROOT_URL; ?>static/css/table2.css">
    <link rel="stylesheet" href="<?php echo ROOT_URL; ?>forum/assets/css/forum-css.css">
</head>

<body>

    <div class="container">
        <?php require($_SESSION['ROOT_PATH'] . "/static/header.php"); ?>
        <br>

        <div class="padding">
            <small><a href="/">WeConnectd</a> / <a href="/forum/">Forums</a></small><br>
            <div class="customtopLeft">
                <div class="sideblog">
                    <h3><a href="https://weconnectd.com/forum/">Forum</a></h3>
                    <ul>
                        <ul>
                            <?php
                            $fc = $conn->query("SELECT * FROM forum_category");
                            if ($fc->num_rows > 0) {
                                while ($fc_d = $fc->fetch_assoc()) {
                            ?>
                            <li><a href="https://weconnectd.com/forum/?category=<?php echo str_replace(' ', ' ', $fc_d['name']); ?>"
                                    class="man">
                                    <?php echo $fc_d['name']; ?>
                                </a></li>
                            <?php
                                }
                            }
                                    ?>
                        </ul>
                    </ul>
                </div>
            </div>
            <center><img src="images/forumpic33.png" alt="Forum Pic"></center>

            <div class="customtopRight">
                <div class="splashBlue">
                    <b>
                        <h2 id="noMargin">WeConnectd Forums</h2>
                    </b>
                </div>
                <a href="add-post.php">
                    <div class="add-btn">
                        + Add Post
                    </div>
                </a>
                <br>
                <h3> Recent Posts </h3>
                <?php

    if (isset($_GET['category'])) {
        $category = $_GET['category'];
        $stmt = $conn->prepare("SELECT * FROM forum_post WHERE category='$category' ORDER BY id DESC");
    } else {
        $stmt = $conn->prepare("SELECT * FROM forum_post ORDER BY id DESC");
    }
    $stmt->execute();
    ?>
                <div id="posts">
                    <?php
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            print("No posts available <br/>");
        } else {
            while ($row = $result->fetch_assoc()) {
                $stmt = $conn->prepare("select * from users where id=?");
                $stmt->bind_param(
                    "i",
                    $row['creator']
                );
                $stmt->execute();
                $answer = $stmt->get_result();
                $answerRow = $answer->fetch_assoc();

                if (!$answerRow)
                    continue;

                $profileImg = isset($answerRow['pfp']) && !empty($answerRow['pfp']) ? ROOT_URL . 'dynamic/pfp/' . $answerRow['pfp'] : ROOT_URL . 'dynamic/pfp/default.png';

                include($_SESSION['ROOT_PATH'] . '/forum/temp/content-forum-posts.php');
            }
        }
        ?>
                </div>
            </div>
        </div>
    </div>
    <br>
    <?php require($_SESSION['ROOT_PATH'] . "/static/footer.php"); ?>
</body>

</html>