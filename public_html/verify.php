<?php
if(!isset($_GET["u"])) {
    header("location: /index.php");
    exit();
}
include_once "api/index.php";

$idUser = intval($_GET["u"]) / 2617 - 45673;

$user = getUser($idUser);

if(!$user) {
    header("location: /index.php");
    exit();
}

var_dump(checkUserEmail($idUser));

header("location: /profile/index.php?ev=1");