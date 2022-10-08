<?php

include_once "../api/userAPI.php";
include_once "../includes/error.php";

if(!isset($_POST["logout-submit"])){
    throwError($INVALID_ARGUMENTS);
    // header("location: /index.php");
    exit();
} else {
    logout();
    // echo "logged out";
    // header("location: /index.php?logoutComplete");
    exit(0);
}