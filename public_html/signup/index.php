<?php
include_once "../head.php";

include_once "../api/userAPI.php";
include_once "../includes/error.php";



if(isLoggedIn()){
    returnHome();
}

$username = "";
$email = "";

if(isset($_GET["user"])){
    $username = $_GET["user"];
}
if(isset($_GET["email"])){
    $email = $_GET["email"];
}
?>
<body class="body login">
    <main class="main">
        <div class="center">
            <div class="welcome">
                <div class="flex">
                    <img src="/img/logo/rr.png" alt="Roller results" style="width: 4rem">
                </div>
                <h1>Create an account</h1>
                <h3 class="subtitle">It's quick and easy</h3>
            </div>
            <form class="form" action="signup.php" method="POST">
                <div>
                    <label for="username">Username</label>
                    <br>
                    <input type="text" placeholder="username" id="username" name="username" value="<?=$username?>" required>
                </div>
                <div>
                    <label for="email">Email</label>
                    <br>
                    <input type="email" placeholder="email" id="email" name="email" value="<?=$email?>" required>
                </div>
                <div>
                    <label for="password1">Password</label>
                    <br>
                    <input type="password" placeholder="Password" id="password1" name="password1" required>
                </div>
                <div>
                    <label for="password1">Confirm password</label>
                    <br>
                    <input type="password" placeholder="Confirm" id="password2" name="password2" required>
                </div>
                <div>
                    <p>Cookies will be used to log me in</p>
                    <p class="font size small">We value your privacy and only use cookies for logins</p>
                    <div class="margin top"></div>
                    <input type="checkbox" id="cookies" name="cookies" required>
                    <label for="cookies" class="margin left">Accept to login Cookies</label>
                </div>
                <div>
                    <button class="btn create green" type="submit"><i class="fas fa-lock margin right btn create gray"></i>Create account</button>
                    <div class="flex align-center margin top double">
                        <p class="margin right">
                            Already have an account?
                        </p>
                        <a class="btn create no-underline" href="/login">Login</a>
                    </div>
                </div>
            </form>
        </div>
    </main>
</body>
<?php
if(isset($_GET["message"])){
    $msg = getErrormessage($_GET["message"]);
    echo "<script>$(() => {window.setTimeout(() => {alert('$msg');removeParams('message');}, 1000)});</script>";
}
?>
</html>