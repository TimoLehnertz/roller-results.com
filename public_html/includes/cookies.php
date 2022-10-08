<?php
include_once "setup.php";

function setCocieAccepted() {
    global $COOKIE_EXPIRATION_ACCEPTED;
    setcookie("cookie_accepted", true, time() + $COOKIE_EXPIRATION_ACCEPTED, "/", $_SERVER['SERVER_NAME'], false, true);
}

function unsetCookieAccepted() {
    unsetCookie("cookie_accepted");
}

function setRememberMe($value) {
    global $RUNNING_HTTPS;
    global $COOKIE_EXPIRATION_REMEMBERME;
    setcookie("rememberMe", $value, time() + $COOKIE_EXPIRATION_REMEMBERME, "/", $_SERVER['SERVER_NAME'], $RUNNING_HTTPS, true);
}

function unsetRememberMe() {
    // unsetCookie("rememberMe");
    setcookie('rememberMe', null, -1, '/', $_SERVER['SERVER_NAME'], $RUNNING_HTTPS, true);
}

function unsetCookie($name) {
    if (isset($_COOKIE[$name])) {
        unset($_COOKIE[$name]); 
        setcookie($name, null, -1, '/'); 
        return true;
    } else {
        return false;
    }
}