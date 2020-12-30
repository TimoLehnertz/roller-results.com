<?php

include_once "../api/userAPI.php";

if(!isset($_POST["logout-submit"])){
    header("location: /index.php");
    exit();
} else{
    logout();
    header("location: /index.php");
    exit(0);
}