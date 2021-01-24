<?php
include_once "../includes/error.php";
session_start();
if(isset($_GET["r"])){
    if($_GET["r"] != "3.1415"){
        returnHome();
    }
} else{
    returnHome();
}
if(!isset($_SESSION["username"])){
    returnHome();
}
$username = $_SESSION["username"];
include_once "../head.php";
?>
<body class="body login">
    <main class="main">
        <div class="center">
            <div class="welcome">
                <h1>Welcome <?=$username?></h1>
                <h2>Your account has been created :)</h2>
                <a href="/index.php">You may return to the home page</a>
            </div>
            <form class="form" action="login.php" method="POST">
                
            </form>
        </div>
    </main>
</body>
</html>