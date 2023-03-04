<?php if (session_status() === PHP_SESSION_NONE)
    session_start();

require($_SESSION['ROOT_PATH'] . "/static/config.inc.php");
require($_SESSION['ROOT_PATH'] . "/static/conn.php");
require($_SESSION['ROOT_PATH'] . "/lib/profile.php");

$stmt = $conn->prepare("select * from users where username=?");
$stmt->bind_param(
    "s",
    $_SESSION['siteusername']
);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$creator = $row['id'];
if (isset($_POST['submit'])) {
    $stmt = $conn->prepare("insert into forum_post (creator, title, content, category, gallery) values (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $creator, $title, $content, $category, $gallery);


    $date = date('YmdHis');
    if (isset($_FILES['sendimage']) and !empty($_FILES['sendimage']['name'])) {
        $photo_name = $_FILES['sendimage']['name'];
        $photo_tmpname = $_FILES['sendimage']['tmp_name'];
        $photo_size = $_FILES['sendimage']['size'];

        function compressImage($source, $destination, $quality)
        {
            list($width, $height) = getimagesize($source);

            $nwidth = $width;
            $nheight = $height;
            $newimage = imagecreatetruecolor($nwidth, $nheight);
            $info = getimagesize($source);
            if ($info['mime'] == 'image/jpeg') {
                $image = imagecreatefromjpeg($source);
            } elseif ($info['mime'] == 'image/gif') {
                $image = imagecreatefromgif($source);
            } elseif ($info['mime'] == 'image/png') {
                $image = imagecreatefrompng($source);
            }
            imagecopyresized($newimage, $image, 0, 0, 0, 0, $nwidth, $nheight, $width, $height);
            imagejpeg($newimage, $destination, $quality);
        }

        $extension = pathinfo($photo_name, PATHINFO_EXTENSION);
        $new_photo_name = $creator . '_sender_' . $date . '.' . $extension;
        $image_path = 'images/' . $new_photo_name;

        // Compress Image
        if ($imagesize <= 1024) {
            $quality = '100';
        } else if ($imagesize > 1024 and $imagesize <= 1024 * 1024 * 2) {
            $quality = '70';
        } else if ($imagesize > 1024 * 2 and $imagesize <= 1024 * 1024 * 2) {
            $quality = '60';
        } else if ($imagesize > 1024 * 3 and $imagesize <= 1024 * 1024 * 4) {
            $quality = '50';
        } else if ($imagesize > 1024 * 4 and $imagesize <= 1024 * 1024 * 5) {
            $quality = '40';
        } else if ($imagesize > 1024 * 5 and $imagesize <= 1024 * 1024 * 6) {
            $quality = '30';
        } else if ($imagesize > 1024 * 6 and $imagesize <= 1024 * 1024 * 7) {
            $quality = '20';
        } else {
            $quality = '10';
        }
        compressImage($photo_tmpname, $image_path, $quality);
    } else {
        $new_photo_name = '';
    }

    $gallery = $new_photo_name;

    $category = htmlspecialchars($_POST['category']);
    $category = strip_tags($category);

    $title = htmlspecialchars($_POST['title']);
    $title = strip_tags($title);

    $content = htmlspecialchars($_POST['content']);
    $content = strip_tags($content);


    $stmt->execute();
    echo "<script>
    location.href = 'index.php';
    </script>";







}
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
            <small><a href="/">WeConnects</a> / <a href="/forum/">Forums</a></small><br>
            <div class="splashBlue">
                <h1 id="noMargin">WeConnectd Forums</h1>
            </div>
            <?php


            if (isset($_SESSION['siteusername'])) {
                print("<strong>Create a post as " . $_SESSION['siteusername'] . "</strong>");
            ?>
            <form id="postForm" method="post" enctype="multipart/form-data">
                <div class="form-control">
                    <div class="form-row">
                        <div class="label"><label for="title">Title:</label></div>
                        <div class="input">
                            <input name="title" type="text" required id="title" style="width:calc(100% - 10px);height: 40px;">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="label"><label for="category">Category:</label></div>
                        <div class="input">
                            <select name="category" id="category">
                                <?php
                                    $stmt = $conn->prepare("select * from forum_category");
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if ($result->num_rows == 0) {
                                ?>
                                <option value="">No Category Available</option>
                                <?php
                                    } else { ?>
                                <option value="">Select Catgory</option>
                                <?php
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $row['name']; ?>">
                                    <?php echo $row['name']; ?>
                                </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="label"><label for="image">Image:</label></div>
                        <div class="input"><input type="file" name="sendimage" style="width:calc(100% - 10px);"
                                id="image"></div>
                    </div>
                    <div class="form-row">
                        <div class="label"><label for="content">Content:</label></div>
                        <div class="input">
                            <textarea name="content" style="width:calc(100% - 10px);height:200px" required id="content"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                    </div>
                    <div class="form-row">
                        <div><input name="submit" type="submit" value="Post"
                                style="background: #8B0000;color: #fff;padding: 5px 20px;font-size: 16px;font-weight: 700;">
                        </div>
                    </div>
                    <div class="forgot">

                    </div>
                </div>
            </form>
            <?php
            } else {
                print('You need to login to make a post');
            }
            ?>

        </div>


    </div>
    <br>
    <?php require($_SESSION['ROOT_PATH'] . "/static/footer.php"); ?>
</body>

</html>