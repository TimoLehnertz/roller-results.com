<?php

/**
 * Embeding
 */
$embed = false;
// if($_SERVER["HTTP_SEC_FETCH_SITE"] == "cross-site") {
//     if(!isset($allowEmbedding)) {
//         echo "This site cannot be embedded";
//         exit(0);
//     }
//     // print_r($_SERVER);
//     if(!isset($_GET["apiKey"])) {
//         echo "please provide a valid API key! Contact roller.results@gmail.com if you don't have one yet.";
//         exit(0);
//     }
//     if(!checkApiKey($_GET["apiKey"])) {
//         echo "This API key is invalid!";
//         exit(0);
//     }
//     $embed = true;
// }

include_once "head.php";

if(!$embed) { // hide header if beeing embedded
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
                <a class="index-link" href="/index.php">
                    <?php
                        if(!isset($indexPage)){
                            // include "logo.html";
                            include "rr-logo.html";
                        }
                    ?>
                <!-- <div class="site-name"><span class="inline">Inline </span><span class="data">data</span><span class="org"></span></div> -->
                </a>
                <div class="settings-toggle">
                    <img src="/img/settings.svg" alt="Settings">
                    <!-- <i class="fas fa-cog"></i> -->
                </div>
            </div>
        </div>
        <?php if(!isset($noHeaderSearchBar)) { ?>
        <div class="search-bar">
            <svg class="search-bar__icon" focusable="false" height="24px" viewBox="0 0 24 24" width="24px"><path d="M20.49,19l-5.73-5.73C15.53,12.2,16,10.91,16,9.5C16,5.91,13.09,3,9.5,3S3,5.91,3,9.5C3,13.09,5.91,16,9.5,16 c1.41,0,2.7-0.47,3.77-1.24L19,20.49L20.49,19z M5,9.5C5,7.01,7.01,5,9.5,5S14,7.01,14,9.5S11.99,14,9.5,14S5,11.99,5,9.5z"></path><path d="M0,0h24v24H0V0z" fill="none"></path></svg>
            <?php
                $search = "";
                if(isset($_GET["search1"])){
                    $search = $_GET["search1"];
                }
            ?>
            <input class="search-bar__input" type="text" autocomplete="off" placeholder="Search for athletes / countries / locations / Events / Years..." value="<?=$search?>">
            <div class="search-bar__options" id="search-bar__options__header"></div>
        </div>
        <?php } else {?>
            <div style="pointer-events: none"></div>
        <?php }?>
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
                    <a href="/index.php"><i class="fa-solid fa-magnifying-glass-plus"></i>Search</a>
                </li>
                <?php if(canISeePascalPage()) { ?>
                <li style="margin-top: 1rem">
                    <div style="background: #347; border-radius: 1rem; padding: 0.5rem">
                        <a href="/pascal/index.php" style="padding-top: 0"><i class="fa fa-solid fa-map margin right"></i>Pascal map manager</a>
                    </div>
                </li>
                <?php } ?>
                <li>
                    <a href="/home/index.php"><i class="fas fa-home margin right"></i>Home</a>
                </li>
                <li>
                    <a href="/analytics"><i class="fas fa-binoculars margin right"></i>Analytics</a>
                </li>
                <li>
                    <a href="/performance"><i class="fas fa-binoculars margin right"></i>Performance</a>
                </li>
                <li>
                    <a href="/tools/import-project.php"><i class="fas fa-binoculars margin right"></i>Upload results</a>
                </li>
                <li>
                    <a href="/countries"><i class="fas fa-globe-americas margin right"></i>Countries</a>
                </li>
                <li>
                    <a href="/hall-of-fame"><i class="fas fa-medal margin right"></i>Hall of fame</a>
                </li>
                <li>
                    <a href="/competitions"><i class="fas fa-flag-checkered margin right"></i></i>Competitions</a>
                </li>
                <li>
                    <a href='/tools/index.php'><i class="fa fa-solid fa-toolbox margin right"></i>Tool box</a>
                </li>
                <li>
                    <a href='/track-map/index.php'><i class="fa fa-solid fa-map margin right"></i>Track map</a>
                </li>
                <li>
                    <a href="/calendar"><i class="fa fa-solid fa-calendar margin right"></i>Calendar</a>
                </li>
                <li>
                    <a href="/gallery"><i class="fa fa-solid fa-images margin right"></i>Gallery</a>
                </li>
                <li>
                    <a href="/organizers"><i class="fa fa-solid fa-user margin right"></i>For organizers</a>
                </li>
                <li>
                    <a href="/blog"><i class="fa fa-brands fa-stack-exchange margin right"></i>Features</a>
                </li>
                <li>
                    <a href="/race-series"><i class="fa fa-brands fa-stack-exchange margin right"></i>Race Series</a>
                </li>
                <li>
                    <a href="/roller-timing/download.php"><i class="fa fa-brands fa-stack-exchange margin right"></i>Roller timing</a>
                </li>
                <!-- <li>
                    <a href="/music"><i class="fa fa-solid fa-music margin right"></i>Music</a>
                </li> -->
                <?php
                // print_r($_SESSION);
                if(canI("seeAdminPage")) {
                    echo "<li><a href='/admin/index.php'><i class='fas fa-shield-alt margin right'></i>Admin</a></li>";
                }
                ?>
                <!-- <li>
                    <a href="/impressum"><i class="fas fa-book margin right"></i>Impressum</a>
                </li> -->
            </ul>
        </nav>
        <div class="profile-section">
            <div class="flex column justify-start align-start gap">
                <?php if($loggedIn) {
                    echo "<p class='font size big'><i class='fa fa-solid fa-user margin right'></i>".$user["username"]."</p>";
                    ?>
                    <p class="realname"><?=$user["firstname"] ?? ""?> <?=$user["lastname"] ?? ""?></p>
                    <a class='btn create no-underline gray' href='/profile'>Your profile</a>
                    <a href="/performance" class="btn create no-underline">Your performance</a>
                    <?php if(doIHaveRollerTiming()) { ?>
                        <a href="/roller-timing" class="btn create no-underline">Roller timing</a>
                    <?php } ?>
                    <form action='/logout/index.php' method='POST'>
                        <input type="text" name="returnTo" value="<?=$_SERVER["REQUEST_URI"]?>" hidden></input>
                        <button class="btn create red" name="logout-submit" value="1" type="submit"><i class="fas fa-sign-out-alt margin right"></i>Log out</button>
                    </form>
                    <?php } else { ?>
                    <p>Join the comunity</p>
                    <a class="btn create green no-underline" href="/signup">Sign up</a>
                    <p>Login to see your <br>trainings progress,<br> results analysis<br> and more</p>
                    <form action="/login/index.php" method="POST">
                        <input type="text" name="returnTo" value="<?=$_SERVER["REQUEST_URI"]?>" hidden></input>
                        <button type="submit" name="submit" class="btn create">Log in</button>
                    </form>
                <?php } ?>
            </div>
        </div>
        <div class="hider"></div>
    </header>
<?php } ?>