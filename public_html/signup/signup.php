<?php
include_once "../includes/error.php";

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
