<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/conn.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/lib/profile.php"); ?>
<?php
    $stmt = $conn -> prepare("select * from users where username=?");
    $stmt -> bind_param("s",
    $_SESSION['siteusername']
    );            
    $stmt->execute();
    $result = $stmt -> get_result();
    $row = $result -> fetch_assoc();
    ?>
<?php

    $stmt = $conn -> prepare("insert into forum_post (creator, title, content, category) values (?, ?, ?, ?)");
    $stmt -> bind_param("isss",$creator, $title, $content, $category);
    $creator = $row['id'];

    $category = htmlspecialchars($_POST['category']);
    $category = strip_tags($category);

    $title = htmlspecialchars($_POST['title']);
    $title = strip_tags($title);

    $content = htmlspecialchars($_POST['content']);
    $content =strip_tags($content);
    $stmt -> execute();

    $data = array('creator' => $_SESSION['siteusername'], 'title' => $title, 'content' => $content, 'category'=>$category);
    $json_obj = json_encode($data);

    print($json_obj);
    ?>