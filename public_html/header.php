<html>
    <head>
        <meta charset="UTF-8">
        <meta name="Cologne Speed Team" content="width=device-width, initial-scale=1">
        <title>Cologne Speed Team</title>
        <link rel="icon" type="image/gif" href="/img/rolle2.gif">
        <link rel="stylesheet" href="/styles/main.css">
        <link href="https://fonts.googleapis.com/css2?family=Carter+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&display=swap" rel="stylesheet">
        <script src="/js/jquery-3.5.1.js"></script>
        <script src="/js/anime.min.js"></script>
        <script src="/js/ajaxAPI.js"></script>
        <script src="/js/lib.js"></script>
        <script src="/js/ui.js"></script>
        <script src="/js/interface.js"></script>
        <script src="https://kit.fontawesome.com/bb5d468397.js" crossorigin="anonymous"></script>
    </head>
    <body class="body">
    <header class="header">
        <div class="left">
            <a href="/index.php">
                <i class="fas fa-clock margin left"></i>
                <span class="title">Speed-skate.org</span>
            </a>
        </div>
        <div class="search-bar">
            <svg class="search-bar__icon" focusable="false" height="24px" viewBox="0 0 24 24" width="24px"><path d="M20.49,19l-5.73-5.73C15.53,12.2,16,10.91,16,9.5C16,5.91,13.09,3,9.5,3S3,5.91,3,9.5C3,13.09,5.91,16,9.5,16 c1.41,0,2.7-0.47,3.77-1.24L19,20.49L20.49,19z M5,9.5C5,7.01,7.01,5,9.5,5S14,7.01,14,9.5S11.99,14,9.5,14S5,11.99,5,9.5z"></path><path d="M0,0h24v24H0V0z" fill="none"></path></svg>
            <?php
                $search = "";
                if(isset($_GET["search1"])){
                    $search = $_GET["search1"];
                }
            ?>
            <input class="search-bar__input" type="text" autocomplete="off" placeholder="Search" value="<?=$search?>">
            <div class="search-bar__options">

            </div>
        </div>
        <div class="right">
        </div>
    </header>
    