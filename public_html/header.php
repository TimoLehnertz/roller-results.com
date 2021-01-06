<?php
include_once "headerMin.php";

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

        <script src="/js/jquery-3.5.1.js"></script>
        <script src="/js/anime.min.js"></script>
        <script src="/js/ajaxAPI.js"></script>
        <script src="/js/lib.js"></script>
        <script src="/js/ui.js"></script>
        <script src="/js/interface.js"></script>

        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/bb5d468397.js" crossorigin="anonymous"></script>
    </head>
    <body class="body">
    <header class="header">
        <div class="left">
            <a href="/index.php">
                <i class="fas fa-clock margin left"></i>
                <span class="title">Inline data</span>
            </a>
        </div>
        <div class="search-bar">
            <svg class="search-bar__icon" focusable="false" height="24px" viewBox="0 0 24 24" width="24px"><path d="M20.49,19l-5.73-5.73C15.53,12.2,16,10.91,16,9.5C16,5.91,13.09,3,9.5,3S3,5.91,3,9.5C3,13.09,5.91,16,9.5,16 c1.41,0,2.7-0.47,3.77-1.24L19,20.49L20.49,19z M5,9.5C5,7.01,7.01,5,9.5,5S14,7.01,14,9.5S11.99,14,9.5,14S5,11.99,5,9.5z"></path><path d="M0,0h24v24H0V0z" fill="none"></path></svg>
            <?php
                $search = "";
                if(isset($_GET["search1"])){
                    $search = $_GET["search1"];
                }
                //Error display
                if(isset($_GET["error"])){
                    echo "<script>$(() => {alert('". getErrormessage($_GET["error"]) ."'); window.location = removeParams('error');})</script>";
                }
            ?>
            <input class="search-bar__input" type="text" autocomplete="off" placeholder="Search" value="<?=$search?>">
            <div class="search-bar__options"></div>
        </div>
        <div class="right">
            <?php if($loggedIn){?>
                <?php
                    if(canI("seeAdminPage")){
                        echo "<a href='/admin/index1.php'>Admin</a>";
                    }
                ?>
                <form action='/logout/index.php' method='POST'>
                    <button class="btn slide vertical signup-btn default" name="logout-submit" value="1" type="submit">Log out</button>
                </form>
            <?php } else {?>
                <div class="btn slide vertical signup-btn default">
                    <a href="/signup">Sign up</a>
                </div>
                <div class="btn slide vertical signup-btn default">
                    <a href="/login">log in</a>
                </div>
            <?php }?>
        </div>
    </header>