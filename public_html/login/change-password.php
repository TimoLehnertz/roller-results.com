<?php
$noErrorAlert = 1;
include_once "../api/index.php";

$message = "";
if(isset($_GET["s"])) {
    $message = "Email has been sent";
}
if(isset($_GET["e"])) {
    $message = "Password could not be changed<br>Please try again";
}


if(validateObjectProperties($_POST, [
    [
        "property" => "submit",
        "value" => "1"
    ],[
        "property" => "email-or-username",
        "type" => "string",
        "minLength" => 1
    ],[
        "property" => "new-password",
        "type" => "string",
        "minLength" => 1
    ]
], false)) {
    initPwReset($_POST["email-or-username"], $_POST["new-password"]);
    header("location: /login/change-password.php?s=1");
    exit();
}
    
if(isset($_GET["id"])) {
    if(processPwReset($_GET["id"])) {
        header("location: /login/index.php?pc=1");
    } else {
        header("location: /login/change-password.php?e=1");
    }
    exit();
}
include_once "../head.php";
?>
<body class="body login">
    <main class="main">
        <div class="center">
            <div class="welcome">
                <div class="flex">
                    <img src="/img/logo/rr.png" alt="Roller results" style="width: 4rem">
                </div>
                <h1>Change your password<i class="fas fa-lock margin left btn create gray"></i></h1>
            </div>
            <form class="form" action="#" method="POST" autocomplete="off">
                <?=$getErrorMessage?>
                <p class="font color orange"><?=$message?></p>
                <p>We will send you an email and<br>as soon as you click the provided<br>link your password will be changed</p>
                <br>
                <br>
                <div>
                    <label for="email-or-username">Email or username</label>
                    <br>
                    <input type="text" name="email-or-username" id="email-or-username" required>
                </div>
                <div>
                    <label for="new-password">New password</label>
                    <br>
                    <input type="password" name="new-password" id="new-password" autocomplete="false" required>
                </div>
                <br>
                <br>
                <button type="submit" name="submit" class="btn create green" value="1">Send me an email</button>
            </form>
        </div>
    </main>
</body>
</html>