<!-- Head -->
<?php
include_once "utils.php";
include_once "api.php";
init();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="Cologne Speed Team" content="width=device-width, initial-scale=1">
        <title>Stundenplan</title>
        <link rel="icon" type="image/gif" href="/img/rolle2.gif">
        <link rel="stylesheet" href="https://www.cst-skate.de/css/main.css">
        <link rel="stylesheet" href="styles/style.css">
        <link href="https://fonts.googleapis.com/css2?family=Carter+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/bb5d468397.js" crossorigin="anonymous"></script>
    </head>
    <body id="body">
        <header class="header">
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
            <nav class="nav">
                <ul class="nav-links">
                    <li><a href="index.php">Stundenplan</a></li>
                </ul>
            </nav>
        </header>
        <div class="layout basic">
            <main class="main">
                <section class="section">
                    <h1 class="headline">Stundenplan</h1>
                    

                    <div class="content">
                        <div class="top">
                            <p>Stundenplan zum editieren auswählen, oder neuen erstellen</p>
                            <label for="select">Stundenplan</label>
                            <select calss="select planSelect" id="select" onchange="loadPlan($(this).val())">
                                <?php
                                    echoOptions(getPlanNames());
                                ?>
                            </select>
                            <hr>
                            <label for="name">Neu: </label>
                            <input type="text" class="name" name="name">
                            <button onclick="addPlan($('.name').val());">Hinzufügen</button>
                        </div>
                        <div class="planWrapper">

                            <!-- Plan -->

                        </div>
                        <button class="apply">Speichern</button>
                    </div>

                    
                </section>
            </main>
            <aside class="aside">
                <h2 class="headline">Lehrer</h2>
                <div class="content">
                    <div class="teachers"></div>
                </div>
                <h2 class="headline">Fächer</h2>
                <div class="content">
                    <div class="subjects"></div>
                </div>
                <h2 class="headline">Räume</h2>
                <div class="content">
                    <div class="rooms"></div>
                </div>
            </aside>
        </div>
        <footer class="footer">
            © copyright by 3.14159
        </footer>
    </body>
    <script src="script.js"></script>
    <script src="https://www.cst-skate.de/js/ui.js"></script>
</html>