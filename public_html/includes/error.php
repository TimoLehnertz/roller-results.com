<?php

$ERROR_NO_ID = "NoId";
$ERROR_INVALID_ID = "InvalidId";

/**
 * Specific errors wich will be handled individually and dont need any message here
 */
$ERROR_NO_EMAIL = "NoEmail";
$ERROR_NO_USERNAME = "NoUsername";
$ERROR_NO_PWD1 = "NoPwd1";
$ERROR_NO_PWD2 = "NoPwd2";

$ERROR_MAPPING = [
    $ERROR_NO_ID => "Please provide an Id",
    $ERROR_INVALID_ID => "The provided id could not be found :(",
];

function getErrormessage($errorCode){
    global $ERROR_MAPPING;
    return $ERROR_MAPPING[$errorCode];
}

/**
 * Redirects the user to the index page with the givven error
 */
function throwError($errorCode){
    header("location: /index.php?error=$errorCode");
    exit(0);
}