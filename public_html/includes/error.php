<?php

$ERROR_NO_ID = "NoId";
$ERROR_INVALID_ID = "InvalidId";
$ERROR_SERVER_ERROR = "ServerError";
$ERROR_NO_SUBMIT = "NoSubmit";
/**
 * Specific errors wich will be handled individually and dont need any message here
 */
$ERROR_NO_EMAIL = "NoEmail";
$ERROR_NO_USERNAME = "NoUsername";
$ERROR_NO_PWD1 = "NoPwd1";
$ERROR_NO_PWD2 = "NoPwd2";
$ERROR_INVALID_EMAIL = "InvalidEmail";
$ERROR_INVALID_USERNAME = "InvalidUsername";
$ERROR_INVALID_PWD1 = "InvalidPwd1";
$ERROR_INVALID_PWD2 = "InvalidPwd2";
$ERROR_NO_PWD_MATCH = "NoPwdMatch";
$ERROR_USERNAME_TAKEN = "UsernameTaken";
$ERROR_EMAIL_TAKEN = "EmailTaken";
$ERROR_WRONG_CREDENTIALS = "WrongCredentials";
$ERROR_WRONG_PASSWORD = "WrongPassword";
$ERROR_NO_PERMISSION = "NoPermission";

$ERROR_MAPPING = [
    $ERROR_NO_ID => "Please provide an Id",
    $ERROR_INVALID_ID => "The provided id could not be found :(",
    $ERROR_SERVER_ERROR => "An error serverside error occoured. We are attempting to fix it, try again later",
    $ERROR_NO_SUBMIT => "A form is required to enter this page",
    $ERROR_NO_PERMISSION => "You dont have permissions to accsess that",
    $ERROR_INVALID_EMAIL => "Please provide a valid e-mail",
    $ERROR_INVALID_USERNAME => "Please dont use @ or : in you username",
    $ERROR_NO_PWD_MATCH => "Your passwords did not match :(",
    $ERROR_USERNAME_TAKEN => "That username is already taken :(",
    $ERROR_EMAIL_TAKEN => "You already have an account on that email",
    $ERROR_WRONG_CREDENTIALS => "Username or password is incorrect try again",
    $ERROR_WRONG_PASSWORD => "Incorrect password. Try again",
];

function getErrormessage($errorCode){
    global $ERROR_MAPPING;
    return $ERROR_MAPPING[$errorCode];
}

/**
 * Redirects the user to the index page with the givven error
 */
function throwError($errorCode, $location = "/index.php"){
    if(strpos($location, "?") != -1){
        header("location: $location&error=$errorCode");
    } else{
        header("location: $location?error=$errorCode");
    }
    exit(0);
}

function returnHome(){
    header("location: /index.php");
    exit(0);
}