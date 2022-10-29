<?php

include_once "../head.php";

include_once "../api/userAPI.php";
include_once "../includes/error.php";


if(isLoggedIn()){
    returnHome();
    exit(0);
}

$username = "";
if(isset($_GET["user"])){
    $username = htmlentities($_GET["user"]);
}

?>
<body class="body login">
    <main class="main">
        <div class="center">
            <div class="welcome">
                <div class="flex">
                    <img src="/img/logo/rr.png" alt="Roller results" style="width: 4rem">
                </div>
                <h1>Welcome back!</h1>
            </div>
            <form class="form" action="login.php" method="POST">
                <div>
                    <label for="username">Username / email</label>
                    <br>
                    <input type="text" placeholder="username / email" id="username" name="username" required value="<?=$username?>">
                </div>
                <div>
                    <label for="password">Password</label>
                    <br>
                    <input type="password" placeholder="password" id="password" name="password" required>
                </div>
                <div>
                    <label for="rememberMe">Remember me</label>
                    <input type="checkbox" name="rememberMe" id="rememberMe">
                </div>
                <div class="flex">
                    <!-- <a href="/index.php" class="btn border-only default">Return home</a> -->
                    <button type="submit" class="btn create green no-underline" name="login-submit">Log in</button>
                </div>
                <br>
                <hr>
                <br>
                <div class="flex gap">
                    <p>No account yet?</p>
                    <a class="btn create gray no-underline" href="/signup">Sign up</a>
                </div>
            </form>
        </div>
    </main>
</body>
<?php
if(isset($_GET["error"])){
    $msg = getErrormessage($_GET["error"]);
    echo "<script>$(() => {window.setTimeout(() => {alert('$msg');removeParams('message');}, 1000)});</script>";
}
?>
</html>