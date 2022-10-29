<?php
include_once "../includes/error.php";
include_once "../../data/dbh.php";
include_once "../includes/setup.php";

if(!isset($_POST["login-submit"])){
    throwError($ERROR_NO_SUBMIT, "/login/index.php");
}

if(!isset($_POST["username"])){
    throwError($ERROR_NO_USERNAME, "/login/index.php");
}

$username = $_POST["username"];
$password = $_POST["password"];

include_once "../api/userAPI.php";

$result = query("SELECT iduser, username, email, pwdHash, registerCountry FROM TbUser WHERE username = ? OR email = ?;", "ss", $username, $username);
if(sizeof($result) == 0) {
    throwError($ERROR_WRONG_CREDENTIALS, "/login/index.php?user=$username");
}

/**
 * check password
 */
$passwordHash = $result[0]["pwdHash"];
if(!password_verify($password, $passwordHash)){
    throwError($ERROR_WRONG_CREDENTIALS, "/login/index.php?user=$username");
}

$email = $result[0]["email"];
$username = $result[0]["username"];
$iduser = $result[0]["iduser"];
$registerCountry = $result[0]["registerCountry"];

/**
 * Correct
 * -> login
 */
if(!login($iduser, !empty($_POST["rememberMe"]))){
    throwError($ERROR_SERVER_ERROR, "/login/index.php?user=$username");
}
if(isset($_POST["returnTo"])) {
    header("location: ".$_POST["returnTo"]);
} else {
    header("location: /index.php");
}