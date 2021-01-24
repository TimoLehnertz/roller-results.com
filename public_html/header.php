<?php
include_once "head.php";
?>
    <body class="body">
    <header class="header">
        <a href="/index.php" class="header__left">
            <?php
                if(!isset($indexPage)){
                    include "logo.html";
                }
            ?>
            <div class="site-name"><span class="inline">Inline </span><span class="data">data</span><span class="org"></span></div>
        </a>
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
        <div class="header__right">
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