<?php require("static/config.inc.php"); ?>
<?php require("static/conn.php"); ?>
<?php require("lib/profile.php"); ?>
<?php require("lib/manage.php"); ?>
<?php require("includes/dbconn.php"); ?>

<!DOCTYPE html>
<html>

<head>
    <title>
        <?php echo $config['pr_title']; ?>
    </title>
    <link rel="stylesheet" href="<?php echo ROOT_URL; ?>/static/css/required.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/theme/monokai.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <link rel="stylesheet" href="codemirror/codemirror.css">
    <script src="codemirror/codemirror.js"></script>
    <style>
        .view-profile-button {
            margin: 0px 0px 20px 0px;
            width: 100%;
        }

        .view-profile-button a {
            width: 100%;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            background: #46ad46;
            padding: 10px;
        }

        .form-items {
            display: flex;
        }

        .set-btn {
            background: #d84315;
            border: 1px solid;
            padding: 3px 10px;
            color: #fff;
            box-shadow: 1px 1px 5px 2px;
            cursor: pointer;
        }
    </style>
    <?php
        if (!isset($_SESSION['siteusername'])) {
            redirectToLogin();
        }
        $user = getUserFromName($_SESSION['siteusername'], $conn);
        ?>
    <?php
        if (isset($_POST['customurl'])) {
            $midurl = $_POST['midurl'];
            $url = $_POST['url'];
            $fullurl = $midurl . '/' . $url;

            if (preg_match('/^[a-zA-Z]+[a-zA-Z0-9]+$/', $url)) {
                $ch_url = $dbconn->query("SELECT * FROM users WHERE url='$fullurl'");
                if ($ch_url->num_rows > 0) {
                    $url_error = "This url already exist!";
                } else {
                    $up_url = $dbconn->query("UPDATE users SET url='$fullurl' WHERE username='" . $_SESSION['siteusername'] . "'");
                    if ($up_url) {
                        header('location: manage.php');
                    } else {
                        $url_error = "There is some server issue!";
                    }
                }
            } else {
                $url_error = "Invalid Pattern! you can use only A-Z a-z 0-9";
            }
        }
        if (isset($_POST['set_relationship'])) {
            $relationship_status = $_POST['relationship_status'];
            $up_url = $dbconn->query("UPDATE users SET relationship_status='$relationship_status' WHERE username='" . $_SESSION['siteusername'] . "'");
            if ($up_url) {
                header('location: manage.php');
            } else {
                $error = "There is some server issue!";
            }

        }
        if (isset($_POST['set_zipcode'])) {
            $zipcode = $_POST['zipcode'];
            $up_zipcode = $dbconn->query("UPDATE users SET zipcode='$zipcode' WHERE username='" . $_SESSION['siteusername'] . "'");
            if ($up_zipcode) {
                header('location: manage.php');
            } else {
                $error = "There is some server issue!";
            }
        }
        if (isset($_POST['set_occupation'])) {
            $occupation = $_POST['occupation'];
            $up_occupation = $dbconn->query("UPDATE users SET occupation='$occupation' WHERE username='" . $_SESSION['siteusername'] . "'");
            if ($up_occupation) {
                header('location: manage.php');
            } else {
                $error = "There is some server issue!";
            }
        }

        if (isset($_POST['set_tcc'])) {
            $tcc1 = $_POST['tcc1'];
            $tcc2 = $_POST['tcc2'];
            $tcc3 = $_POST['tcc3'];
            $tcc4 = $_POST['tcc4'];
            $tcc5 = $_POST['tcc5'];
            $tcc6 = $_POST['tcc6'];
            $tcc7 = $_POST['tcc7'];
            $tcc8 = $_POST['tcc8'];
            $tcc9 = $_POST['tcc9'];
            $tcc10 = $_POST['tcc10'];

            $arr_tcc = array($tcc1, $tcc2, $tcc3, $tcc4, $tcc5, $tcc6, $tcc7, $tcc8, $tcc9, $tcc10);
            $top_10_crypto = implode(',', $arr_tcc);
            $up_tcc = $dbconn->query("UPDATE users SET top_10_crypto='$top_10_crypto' WHERE username='" . $_SESSION['siteusername'] . "'");
            if ($up_tcc) {
                header('location: manage.php');
            } else {
                $error = "There is some server issue!";
            }
        }
        ?>
    <?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bioset'])) {
            updateUserBio($_SESSION['siteusername'], $_POST['bio'], $conn);
            header("Location: manage.php");
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cssset'])) {
            updateUserCSS($_SESSION['siteusername'], $_POST['css'], $conn);
            header("Location: manage.php");
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['genderset'])) {
            updateUserGender($_SESSION['siteusername'], $_POST['gender'], $conn);
            header("Location: manage.php");
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['songtitleset'])) {
            updateUserSong($_SESSION['siteusername'], $_POST['songtitle'], $conn);
            header("Location: manage.php");
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ageset'])) {
            updateUserAge($_SESSION['siteusername'], $_POST['age'], $conn);
            header("Location: manage.php");
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['locationset'])) {
            updateUserLocation($_SESSION['siteusername'], $_POST['location'], $conn);
            header("Location: manage.php");
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['interestsmusicset'])) {
            updateUserInterestMusic($_SESSION['siteusername'], $_POST['interestsmusic'], $conn);
            header("Location: manage.php");
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['interestsset'])) {
            updateUserInterest($_SESSION['siteusername'], $_POST['interests'], $conn);
            header("Location: manage.php");
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['privacyset'])) {
            $buffer = $_POST['blogsprivacy'] . "|" . $_POST['friendsprivacy'] . "|" . $_POST['commentssprivacy'];
            $stmt = $conn->prepare("UPDATE users SET privacy = ? WHERE username = ?");
            $stmt->bind_param("ss", $buffer, $_SESSION['siteusername']);
            $stmt->execute();
            $stmt->close();
            header("Location: manage.php");
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cryptoportfolioset'])) {
            updateUserCryptoProfile($_SESSION['siteusername'], $_POST['cryptoportfolio'], $conn);
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pfpset'])) {
            //This is terribly awful and i will probably put this in a function soon
            $target_dir = "dynamic/pfp/";
            $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
            $target_name = md5_file($_FILES["fileToUpload"]["tmp_name"]) . "." . $imageFileType;

            $target_file = $target_dir . $target_name;

            $uploadOk = true;
            $movedFile = false;

            if (
                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                $fileerror = 'unsupported file type. must be jpg, png, jpeg, or gif';
                $uploadOk = false;
            }

            if (file_exists($target_file)) {
                $movedFile = true;
            } else {
                $movedFile = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
            }

            if ($uploadOk) {
                if ($movedFile) {
                    $stmt = $conn->prepare("UPDATE users SET pfp = ? WHERE `users`.`username` = ?;");
                    $stmt->bind_param("ss", $target_name, $_SESSION['siteusername']);
                    $stmt->execute();
                    $stmt->close();
                    header("Location: manage.php");
                } else {
                    $fileerror = 'fatal error';
                }
            }
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['songset']) ) {
            $uploadOk = true;
            $movedFile = false;

            $target_dir = "dynamic/music/";
            $songFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
            $target_name = md5_file($_FILES["fileToUpload"]["tmp_name"]) . "." . $songFileType;

            $target_file = $target_dir . $target_name;

            if ($songFileType != "ogg" && $songFileType != "mp3") {
                $fileerror = 'unsupported file type. must be mp3 or ogg<hr>';
                $uploadOk = false;
            }

            if (file_exists($target_file)) {
                $movedFile = true;
            } else {
                $movedFile = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
            }

            if ($uploadOk) {
                if ($movedFile) {
                    $stmt = $conn->prepare("UPDATE users SET music = ? WHERE `users`.`username` = ?;");
                    $stmt->bind_param("ss", $target_name, $_SESSION['siteusername']);
                    $stmt->execute();
                    $stmt->close();
                    header("Location: manage.php");
                } else {
                    $fileerror = 'fatal error' . $_FILES["fileToUpload"]["error"] . '<hr>';
                }
            }
        }
        ?>
    <style>
        .customtopLeft {
            float: left;
            width: calc(30% - 20px);
            padding: 10px;
        }

        .customtopRight {
            float: right;
            width: calc(70% - 20px);
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php require($_SESSION['ROOT_PATH'] . "/static/header.php"); ?>
        <div class="padding">
            <span style="padding-left: 20px;">
                <h1 id="noMargin">&nbsp;Profile Edit</h1>
            </span>
            <div class="customtopLeft">
                <div class="splashBlue">
                    You may enter CSS in the CSS text field. Javascript is not allowed and will be filtered out. Do not
                    use CSS maliciously or your account will be disabled.
                </div><br>
                <center><img style="width: 100%;" src="dynamic/pfp/<?php echo $user['pfp']; ?>"></center><br>
                <div class="view-profile-button">
                    <a href="/profile.php?id=<?php echo $user['id']; ?>">View your profile</a>
                </div>
                <center>
                    <div style="font-size:22px; font-weight:700;"> Coinconnect Radio</div>
                    <iframe style="width:100%; height:500px;"
                        src="https://gcp-embeds.datpiff.com/mixtape/1015418/"></iframe>
                    <br>
                </center>
                <center>
                    <div style="font-size:22px; font-weight:700;"> Coinconnect TV</div>
                    <iframe style="width:100%"
                        src="https://www.youtube.com/embed/8RbsvgcGPsE?list=PLtLkbqLvv34YPr_0aEQefmpr5d3NQT8uu&loop=1">
                    </iframe>
                    <br>
                    <div style="font-size:22px; font-weight:700;"> Video Chat</div>
                    <button>Join</button>
                </center>

            </div>
            <div class="customtopRight">
                <div class="splashBlue">
                    <?php if (isset($fileerror)) {
                            echo "<small style='color:red'>" . $fileerror . "</small><br>";
                        } ?>
                    <center>
                        <?php
                        ini_set('display_errors', 1);
                        ini_set('display_startup_errors', 1);
                        error_reporting(E_ALL);

                        if (!isset($_SESSION['steamid'])) {
                            //loginbutton("rectangle"); //login button
                        } else {
                            include($_SERVER['DOCUMENT_ROOT'] . '/vendor/smith197/steamauthentication/steamauth/userInfo.php'); //To access the $steamprofile array
                            logoutbutton(); //Logout Button
                            updateSteamURL($steamprofile['profileurl'], $_SESSION['siteusername'], $conn);
                        }
                        ?>
                    </center>
                    <form method="post" enctype="multipart/form-data">
                        <b>User Privacy</b><br><br>
                        <?php
                            $select_privacy = explode('|', $user['privacy']);
                            $select_blog = $select_privacy[0];
                            $select_friend = $select_privacy[1];
                            $select_comment = $select_privacy[2];

                            ?>
                        <div class="form-items">
                            <label for="blogsprivacy">Blogs</label>
                            <div class="custom-select" style="width:200px;">
                                <select name="blogsprivacy" id="blogsprivacy">
                                    <option <?php if ($select_blog=='public') {
                                        echo 'selected';
                                    } ?>
                                        value="public">Public</option>
                                    <option <?php if ($select_blog=='hide') {
                                        echo 'selected';
                                    } ?> value="hide">Hide
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-items">
                            <label for="friendsprivacy">Friends</label>
                            <div class="custom-select" style="width:200px;">
                                <select name="friendsprivacy" id="friendsprivacy">
                                    <option <?php if ($select_friend=='public') {
                                        echo 'selected';
                                    } ?>
                                        value="public">Public</option>
                                    <option <?php if ($select_friend=='hide') {
                                        echo 'selected';
                                    } ?> value="hide">Hide
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-items">
                            <label for="commentsprivacy">Comments</label>
                            <div class="custom-select" style="width:200px;">
                                <select name="commentssprivacy" id="commentsprivacy">
                                    <option <?php if ($select_comment=='public') {
                                        echo 'selected';
                                    } ?>
                                        value="public">Public</option>
                                    <option <?php if ($select_comment=='friend') {
                                        echo 'selected';
                                    } ?>
                                        value="friend">Connect-Only</option>
                                    <option <?php if ($select_comment=='hide') {
                                        echo 'selected';
                                    } ?> value="hide">Hide
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-items">
                            <input class="set-btn" type="submit" value="Update" name="privacyset">
                        </div>
                    </form><br>
                    <form method="post" enctype="multipart/form-data">
                        <b>Profile Picture</b><br>
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input class="set-btn" type="submit" value="Upload Image" name="pfpset">
                    </form><br>
                    <!--<form method="post" enctype="multipart/form-data">
                            <b>Song</b><br>
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <input type="submit" value="Upload Song" name="songset">
                        </form><br>-->
                    <form method="post" enctype="multipart/form-data">
                        <b>Bio</b><br>
                        <textarea cols="56" id="biomd" placeholder="Bio"
                            name="bio"><?php echo $user['bio']; ?></textarea><br>
                        <script>
                            var simplemde = new SimpleMDE({ element: document.getElementById("biomd") });
                        </script>
                        <input class="set-btn" name="bioset" type="submit" value="Set">
                    </form><br>
                    <form method="post" enctype="multipart/form-data">
                        <b>Top 5 Crypto Currencies</b><br>
                        <?php
                            $edit_tcc = explode(',', $user['top_10_crypto']);
                            ?>
                        1.<input type="text" name="tcc1" id="tcc1" value="<?php echo $edit_tcc[0]; ?>"><br>
                        2.<input type="text" name="tcc2" id="tcc2" value="<?php echo $edit_tcc[1]; ?>"><br>
                        3.<input type="text" name="tcc3" id="tcc3" value="<?php echo $edit_tcc[2]; ?>"><br>
                        4.<input type="text" name="tcc4" id="tcc4" value="<?php echo $edit_tcc[3]; ?>"><br>
                        5.<input type="text" name="tcc5" id="tcc5" value="<?php echo $edit_tcc[4]; ?>"><br>
                        <input name="set_tcc" type="submit" value="Set">
                    </form><br>
                    <form method="post" enctype="multipart/form-data">
                        <b>Interests</b><br>
                        <textarea cols="56" placeholder="Interests"
                            name="interests"><?php echo $user['interests']; ?></textarea><br>
                        <input class="set-btn" name="interestsset" type="submit" value="Set">
                    </form><br>
                    <form method="post" enctype="multipart/form-data">
                        <b>Music Interests</b><br>
                        <textarea cols="56" placeholder="Interests Music"
                            name="interestsmusic"><?php echo $user['interestsmusic']; ?></textarea><br>
                        <input class="set-btn" name="interestsmusicset" type="submit" value="Set">
                    </form><br>
                    <form method="post" enctype="multipart/form-data">
                        <b>Crypto Portfolio</b>
                        <br>
                        <textarea cols="56" placeholder="Crypto Portfolio" name="cryptoportfolio"><?php echo isset($user['cryptoportfolio']) ? $user['cryptoportfolio'] : ''; ?></textarea>
                        <br>
                        <input class="set-btn" name="cryptoportfolioset" type="submit" value="Set">
                    </form><br>
                    <button onclick="loadpfwin()" id="prevbtn">Show Live CSS Preview</button>
                    <form method="post" enctype="multipart/form-data">
                        <b>CSS</b><br>
                        <textarea id="cssarea" placeholder="CSS" name="css"><?php echo $user['css']; ?></textarea><br>
                        <script src="codemirror/mode/css/css.js"></script>
                        <script>
                            var editor = CodeMirror.fromTextArea(cssarea, {
                                lineNumbers: true,
                                tabSize: 2,
                                value: "<?php echo trim(preg_replace('/\s+/', ' ', addslashes($user['css']))); ?>",
                                mode: "css"
                            });
                        </script>
                        <input class="set-btn" name="cssset" type="submit" value="Set"><br>
                    </form>
                    <form method="post">
                        <b>Age</b> <br><input value="<?php echo $user['age']; ?>" type="text" name="age"
                            required="required" row="4"><br>
                        <input class="set-btn" type="submit" value="Set" name="ageset">
                    </form><br>
                    <form method="post">
                        <b>Occupation</b> <br><input value="<?php echo $user['occupation']; ?>" type="text"
                            name="occupation" required="required" row="4"><br>
                        <input class="set-btn" type="submit" value="Set" name="set_occupation">
                    </form><br>
                    <form method="post">
                        <b>Relationship Status</b> <br>
                        <select method="post" name="relationship_status">
                            <option <?php if ($user['relationship_status']=='Single') {
                                    echo 'selected';
                                } ?>
                                value="Single">Single</option>
                            <option <?php if ($user['relationship_status']=='Looking for Coinconnects') {
                                    echo 'selected';
                                } ?> value="Looking for Coinconnects">Looking for Coinconnects</option>
                            <option <?php if ($user['relationship_status']=='Married') {
                                    echo 'selected';
                                } ?>
                                value="Married">Married</option>
                            <option <?php if ($user['relationship_status']=='In A Relationship') {
                                    echo 'selected';
                                } ?>
                                value="In A Relationship">In A Relationship</option>
                            <option <?php if ($user['relationship_status']=='Polymory') {
                                    echo 'selected';
                                } ?>
                                value="Polymory">Polymory</option>
                            <option <?php if ($user['relationship_status']=='Coinmate') {
                                    echo 'selected';
                                } ?>
                                value="Coinmate">Coinmate</option>
                            <option <?php if ($user['relationship_status']=='Coinboy') {
                                    echo 'selected';
                                } ?>
                                value="Coinboy">Coinboy</option>
                            <option <?php if ($user['relationship_status']=='Not Interested At All') {
                                    echo 'selected';
                                }
                                ?> value="Not Interested At All">Not Interested At All</option>
                        </select><br>
                        <input class="set-btn" type="submit" value="Set" name="set_relationship">
                    </form><br>
                    <form method="post">
                        <b>Country</b> <br><input value="<?php echo $user['location']; ?>" type="text" name="location"
                            required="required" row="4"><br>
                        <input class="set-btn" type="submit" value="Set" name="locationset">
                    </form><br>
                    <form method="post">
                        <b>Zipcode</b> <br><input value="<?php echo $user['zipcode']; ?>" type="number" name="zipcode"
                            required="required" row="4"><br>
                        <input type="submit" value="Set" name="set_zipcode">
                    </form><br>
                    <form method="post">
                        <b>Gender</b> <br><input value="<?php echo $user['gender']; ?>" type="text" name="gender"
                            required="required" row="4"><br>
                        <input class="set-btn" type="submit" value="Set" name="genderset">
                    </form><br>

                    <form method="post">
                        <b>Custom URL</b> <br>
                        <span style="color:red;">
                            <?php if (isset($url_error)) {
                                echo $url_error;
                            } ?>
                        </span>
                        <?php
                            if (!empty($user['url'])) {
                                $url_sep = explode('/', $user['url']);
                                $furl = $url_sep[0];
                                $lurl = $url_sep[1];
                            } else {
                                $furl = '';
                                $lurl = '';
                            }

                            ?>
                        <br>https://weconnectd.com/<select name="midurl">
                            <option <?php if ($furl=='x') {
                                echo "selected";
                            } ?> value="x">x/</option>
                            <option <?php if ($furl=='spot') {
                                  echo "selected";
                              } ?> value="spot">spot/</option>
                            <option <?php if ($furl == 'share') {
                                    echo "selected";
                                } ?> value="share">share/</option>
                            <option <?php if ($furl=='profile') {
                                      echo "selected";
                                  } ?> value="profile">profile/</option>
                        </select><input value="<?php echo $lurl; ?>" type="text" name="url" required="required"
                            row="4"><br>
                        <input class="set-btn" type="submit" value="Set" name="customurl">
                    </form><br>
                </div>
            </div>
        </div>
    </div>
    <br>
    <?php require("static/footer.php"); ?>
    <!-- CSS Editor -->
    <script>
        // Constants (should be defined by PHP)
        let webroot = "https://weconnectd.com";
        let profile_id = <?php echo getIDFromUser($_SESSION[' siteusername '], $conn) ?>;

        // Global vars
        var profile_window;
        var chkclose_timer;

        function freepfwin() {
            // Enable Open Preview button
            document.getElementById("prevbtn").style.display = null;

            // Disable changes being sent to preview
            document.getElementById("cssarea").onkeyup = null;
        }

        function loadpfwin() {
            profile_window = window.open(`${webroot}/preview.php?id=${profile_id}&ed`, "WeConnectd: Preview CSS", "width=920,height=600");

            profile_window.window.onload = () => {
                // Disable Open Preview button
                document.getElementById("prevbtn").style.display = "none";

                // Any changes change css on preview
                editor.on('change', function () {
                    profile_window.document.getElementsByTagName("style")[0].innerHTML = editor.getValue();
                });
            };

            chkclose_timer = setInterval(() => {
                if (profile_window.closed) {
                    console.log("closed")
                    clearInterval(chkclose_timer);
                    freepfwin();
                }
            }, 100);
        };

    </script>
</body>

</html>