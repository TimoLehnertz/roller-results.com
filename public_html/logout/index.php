<?php

include_once "../api/userAPI.php";
include_once "../includes/error.php";

if(!isset($_POST["logout-submit"])){
    throwError($INVALID_ARGUMENTS);
    // header("location: /index.php");
    exit();
} else {
    logout();
    header("location: /index.php?logoutComplete");
}