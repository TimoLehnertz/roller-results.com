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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
    <title>Registered</title>
    <link rel="stylesheet" href="/styles/pages/signup-succsess.css">
</head>
<body>
    <h1>Welcome <?=$username?></h1>
    <h2>Your account has been created :)</h2>
    <a href="/index.php">You may return to the home page</a>
</body>
</html>