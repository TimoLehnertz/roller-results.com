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
    header("location: /signup/index.php?error=$ERROR_NO_EMAIL&user=$username&email=$email");
    exit(0);
}
if(!isset($_POST["username"])){
    header("location: /signup/index.php?error=$ERROR_NO_USERNAME&user=$username&email=$email");
    exit(0);
}
if(!isset($_POST["password1"])){
    header("location: /signup/index.php?error=$ERROR_NO_PWD1&user=$username&email=$email");
    exit(0);
}
if(!isset($_POST["password2"])){
    header("location: /signup/index.php?error=$ERROR_NO_PWD2&user=$username&email=$email");
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
    header("location: /signup/index.php?error=$ERROR_INVALID_EMAIL&user=$username&email=$email");
    exit(0);
}
// username
if(strlen($email) > 300){
    header("location: /signup/index.php?error=$ERROR_INVALID_EMAIL&user=$username&email=$email");
    exit(0);
}
// username
if(!checkUsername($username)){
    header("location: /signup/index.php?error=$ERROR_INVALID_USERNAME&user=$username&email=$email");
    exit(0);
}
// pw1
if(strlen($pwd1) < 1){
    header("location: /signup/index.php?error=$ERROR_INVALID_PWD1&user=$username&email=$email");
    exit(0);
}
//pwd match
if($pwd1 !== $pwd2){
    header("location: /signup/index.php?error=$ERROR_NO_PWD_MATCH&user=$username&email=$email");
    exit(0);
}

/**
 * Check database if all information is valid
 */
$result = query("SELECT username, email from TbUser WHERE username = ? OR email = ?;", "ss", $username, $email);
if(sizeof($result) > 0){
    if($result[0]["username"] == $username){
        header("location: /signup/index.php?error=$ERROR_USERNAME_TAKEN&user=$username&email=$email");
        exit(0);
    }
    if($result[0]["email"] == $email){
        header("location: /signup/index.php?error=$ERROR_EMAIL_TAKEN&user=$username&email=$email");
        exit(0);
    }
    header("location: /signup/index.php?error=$ERROR_USERNAME_TAKEN&user=$username&email=$email");
    exit(0);
}

/**
 * Generating additional info
 */
$registerCountry = ip_info("visitor", "Country");
$pwdHash = password_hash($pwd1, PASSWORD_DEFAULT);

//Valid
if(($iduser = dbInsert("INSERT INTO TbUser(username, email, pwdHash, registerCountry) VALUES (?, ?, ?, ?);", "ssss", $username, $email, $pwdHash, $registerCountry)) !== FALSE){
    // var_dump($iduser);
    login($iduser, true);
    sendVerificationMail($email);
    header("location: succsess.php?r=3.1415");
} else {
    header("location: /signup/index.php?error=$ERROR_SERVER_ERROR&user=$username&email=$email");
    exit(0);
}

function sendVerificationMail() {
    if(!isLoggedIn()) return;
    $headers = 'From: roller.results@gmail.com' . "\r\n" .
        'Reply-To: roller.results@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        $userId = ($_SESSION["iduser"] + 45673) * 2617;
    mail($_SESSION["email"], "Verify your mail", "Hello ".$_SESSION["username"].",\r\n
    Welcome to Roller results. To complete setting up your profile, please click the link below.\r\n
    If you wish, you can edit your athlete profile by first linking it to this account. Set up the link on your profile page and reply to this mail so that we can activate the link.\r\n
    http://www.roller-results.com/verify.php?u=$userId\r\n
    \r\n
    If you have any questions, just send us an email to this address, or contact us on Instagram.\r\n
    \r\n
    Kind regards\r\n
    Timo and Alex Lehnertz\r\n
    \r\n
    Roller results\r\n
    https://www.roller-results.com\r\n", $headers);
}