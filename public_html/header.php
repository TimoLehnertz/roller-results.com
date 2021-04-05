<?php
include_once "head.php";
?>
    <body class="body">
    <header class="header">
        <div class="header__left">
            <div class="wrapper">
                <div class="burger toggle-nav">
                    <div class="line1"></div>
                    <div class="line2"></div>
                    <div class="line3"></div>
                </div>
                <a href="/index.php">
                    <?php
                        if(!isset($indexPage)){
                            include "logo.html";
                        }
                    ?>
                <!-- <div class="site-name"><span class="inline">Inline </span><span class="data">data</span><span class="org"></span></div> -->
                </a>
                <div class="settings-toggle">
                    <i class="fas fa-cog"></i>
                </div>
            </div>
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
        <div class="header__right">
            <?php if($loggedIn){ ?>
                <div class="toggle-profile-section">
                    <img class="profile-img" src="<?php echo $user["image"];?>" alt="profile image">
                    <div class="profile-name"><?php echo $user["username"]; ?></div>
                </div>
            <?php } else{?>
                <div class="toggle-profile-section">
                    <img class="profile-img" src="/img/profile-men.png" alt="profile image">
                    <div class="profile-name">Log in</div>
                </div>
                <!-- <a class="btn default" href="/signup">Sign up</a>
                <a class="btn default" href="/login">log in</a> -->
            <?php }?>
        </div>
        <nav class="nav">
            <!-- <div class="hider"></div>
            <div class="hider hider2"></div> -->
            <ul>
                <li>
                    <a href="/index.php"><i class="fas fa-home margin right"></i>Home</a>
                </li>
                <li>
                    <a href="/countries"><i class="fas fa-globe-americas margin right"></i>Countries</a>
                </li>
                <li>
                    <a href="/hall-of-fame"><i class="fas fa-medal margin right"></i>Hall of fame</a>
                </li>
                <li>
                    <a href="/analytics"><i class="fas fa-binoculars margin right"></i>Analytics</a>
                </li>
                <li>
                    <a href="/impressum"><i class="fas fa-book margin right"></i>Impressum</a>
                </li>
                <?php
                    if(canI("seeAdminPage")){
                        echo "<li><a href='/admin/index.php'><i class='fas fa-shield-alt margin right'></i>Admin</a></li>";
                    }
                ?>
            </ul>
        </nav>
        <div class="profile-section">
            <!-- <div class="hider hider2"></div> -->
            <?php if($loggedIn){
                echo "<p>".$user["username"]."</p>";
                ?>
                <form action='/logout/index.php' method='POST'>
                    <button class="btn slide signup-btn default" name="logout-submit" value="1" type="submit"><i class="fas fa-sign-out-alt margin right"></i>Log out</button>
                </form>
            <?php } else { ?>
                <a class="btn default" href="/signup">Sign up</a>
                <a class="btn default" href="/login">log in</a>
            <?php } ?>
        </div>
        <div class="hider"></div>
    </header>