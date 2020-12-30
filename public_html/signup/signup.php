<?php
include_once "../includes/error.php";
include_once "../includes/cookies.php";

/**
 * Set cookie
 */

if(isset($_POST["cookies"])){
    $accepted = $_POST["cookies"];
    if($accepted == "on"){
        setCocieAccepted();
    }
}

/**
 * Validate if all information is given
 */

if(!isset($_POST["email"])){
    header("location: /signup/index.php?message=$ERROR_NO_EMAIL");
    exit(0);
}
if(!isset($_POST["username"])){
    header("location: /signup/index.php?message=$ERROR_NO_USERNAME");
    exit(0);
}
if(!isset($_POST["password1"])){
    header("location: /signup/index.php?message=$ERROR_NO_PWD1");
    exit(0);
}
if(!isset($_POST["password2"])){
    header("location: /signup/index.php?message=$ERROR_NO_PWD2");
    exit(0);
}

include_once "../includes/utils.php";
include_once "../../data/dbh.php";//database handler
include_once "../api/userAPI.php";

$email = $_POST["email"];
$username = $_POST["username"];
$pwd1 = $_POST["password1"];
$pwd2 = $_POST["password2"];

/**
 * Validate if all information is valid
 */

// Email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("location: /signup/index.php?message=$ERROR_INVALID_EMAIL");
    exit(0);
}
// username
if(strlen($email) > 300){
    header("location: /signup/index.php?message=$ERROR_INVALID_EMAIL");
    exit(0);
}
// username
if(!checkUsername($username)){
    header("location: /signup/index.php?message=$ERROR_INVALID_USERNAME");
    exit(0);
}
// pw1
if(strlen($pwd1) < 1){
    header("location: /signup/index.php?message=$ERROR_INVALID_PWD1");
    exit(0);
}
//pwd match
if($pwd1 !== $pwd2){
    header("location: /signup/index.php?message=$ERROR_NO_PWD_MATCH");
    exit(0);
}

/**
 * Check database if all information is valid
 */
$result = query("SELECT username from TbUser WHERE username = ? OR email = ?;", "ss", $username, $email);
if(sizeof($result) > 0){
    if($result[0]["username"] == $username){
        header("location: /signup/index.php?message=$ERROR_USERNAME_TAKEN");
        exit(0);
    }
    if($result[0]["email"] == $email){
        header("location: /signup/index.php?message=$ERROR_EMAIL_TAKEN");
        exit(0);
    }
    header("location: /signup/index.php?message=$ERROR_USERNAME_TAKEN");
    exit(0);
}

/**
 * Generating additional info
 */
$registerCountry = ip_info("visitor", "Country");
$pwdHash = password_hash($pwd1, PASSWORD_DEFAULT);

//Valid
if(($iduser = dbInsert("INSERT INTO TbUser(username, email, pwdHash, registerCountry) VALUES (?, ?, ?, ?);", "ssss", $username, $email, $pwdHash, $registerCountry)) !== FALSE){
    login($iduser, $username, $email, $registerCountry);
    header("location: succsess.php?r=3.1415");
} else{
    header("location: /signup/index.php?message=$ERROR_SERVER_ERROR");
    exit(0);
}