<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/conn.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/lib/profile.php"); ?>
<?php
    $stmt = $conn->prepare("SELECT * FROM bulletinlikes WHERE toid = ? AND owner = ? AND type = 'l' ");
    $stmt->bind_param("is", $_GET['id'], $_SESSION['siteusername']);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 1) die('YOu already liked this');
    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM bulletinlikes WHERE toid = ? AND owner = ? AND type = 'd' ");
    $stmt->bind_param("is", $_GET['id'], $_SESSION['siteusername']);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 1) die('You already disliked this');
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO bulletinlikes (toid, type, owner) VALUES (?, 'l', ?)");
    $stmt->bind_param("is", $_GET['id'], $_SESSION['siteusername']);
    $stmt->execute();
    $stmt->close();

    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>