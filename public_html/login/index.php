<?php

include_once "../api/userAPI.php";
include_once "../includes/error.php";

if(isLoggedIn()){
    returnHome();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
    <title>Sign up</title>
    <link rel="stylesheet" href="/styles/pages/signup.css">
</head>
<body>
    <h1>Welcom back!</h1>
    <form action="login.php" method="POST">
        <input type="text" placeholder="username / email" id="username" name="username" required>
        <br>
        <input type="password" placeholder="password" id="password" name="password" required>
        <br>Remember me</label>
        <input type="checkbox" name="rememberMe" id="rememberMe">
        <br>
        <button type="submit" name="login-submit">Log in</button>
    </form>
</body>
</html>