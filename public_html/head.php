<?php

include_once "api/userAPI.php";

if(!isLoggedIn()){
    tryRememberMeLogin();
}


include_once "includes/error.php";
include_once "api/userAPI.php";
include_once "includes/roles.php";
$loggedIn = isLoggedIn();
$user;
if($loggedIn){
    $user = getUser($_SESSION["iduser"]);
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
        <title>Inline data</title>
        <link rel="icon" type="image/gif" href="/img/rolle2.gif">
        <link rel="stylesheet" href="/styles/main.css">
        <!-- GOOGLE fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;1,200;1,400;1,500;1,600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">

        <!-- Jquery -->
        <script src="/js/jquery-3.5.1.js"></script>

        <!-- Anime -->
        <script src="/js/anime.min.js"></script>

        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/bb5d468397.js" crossorigin="anonymous"></script>

        <script src="/js/ajaxAPI.js"></script>
        <script src="/js/lib.js"></script>
        <script src="/js/ui.js"></script>
        <script src="/js/interface.js"></script>
    </head>