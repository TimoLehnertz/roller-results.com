<?php

include_once "../../includes/roles.php";

if(!canI("managePermissions")){
    header("location: /index.php");
    exit();
}

if(isset($_GET["url"])){
    echo file_get_contents($_GET["url"]);
}