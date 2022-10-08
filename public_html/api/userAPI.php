<?php

include_once $_SERVER["DOCUMENT_ROOT"]."/../data/dbh.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/includes/cookies.php";
include_once "imgAPI.php";

function isLoggedIn() {
    if(!isset($_COOKIE["cookie_accepted"]) || !$_COOKIE["cookie_accepted"]) {
        return false;
    }
    if(session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }
    return isset($_SESSION["username"]);
}

function setUserRole($iduser, $idRole){
    return dbExecute("UPDATE TbUser SET idRole = ? WHERE iduser = ?;", "ii", $idRole, $iduser);
}

function getAllUsers(){
    $users = [];
    foreach (query("SELECT username, email, registerCountry, iduser, idRole FROM TbUser") as $key => $value) {
        $users[$value["iduser"]] = $value;
    }
    return $users;
}

function updateUsers($newUsers) {
    $users = getAllUsers();
    foreach ($newUsers as $iduser => $changedUser) {
        $newUsers[$iduser]["changed"] = [];
        foreach ($changedUser as $key => $value) {
            if($users[$iduser][$key] != $value){
                $newUsers[$iduser]["changed"][$key] = $value;
            }
        }
    }
    $changed = false;
    foreach ($newUsers as $iduser => $changedUser) {
        if(sizeof($changedUser["changed"]) > 0){
            $changed = true;
            updateUser($changedUser["iduser"], $changedUser["changed"]);
        }
    }
    // exit();
    return $changed;
}

/**
 * Arr should be something like ["username" => "test", etc]
 */
function updateUser($iduser, $arr){
    if(!canI("managePermissions")){
        return false;
    }
    $update = "";
    $delimiter = "";
    $insertTypes = "";
    $insertValues = [];
    foreach ($arr as $key => $value) {
        $update .= "$delimiter SET $key = ?";
        $insertTypes .= columnToType($key);
        $insertValues[] = $value;
        $delimiter = ",";
    }
    $insertValues[] = $iduser;
    return dbExecuteArr("UPDATE TbUser$update WHERE iduser = ?;", $insertTypes."i", $insertValues);
}

function columnToType($column){
    switch($column){
        case "iduser": return "i";
        case "username": return "s";
        case "email": return "s";
        case "idRole": return "i";
        case "registerCountry": return "s";
    }
}

function getDummyUser(){
    return [
        "username" => "max",
        "email" => "musterman@gmail.com",
        "registerCountry" => "Germany",
        "iduser" => 1,
        "idRole" => 0
    ];
}

/**
 * disallowed characters are ["@", ":"]
 * max length: 200
 * min length: 1
 */
function checkUsername($name){
    $forbiddenChars = ["@", ":"];
    foreach ($forbiddenChars as $key => $value) {
        if(strpos($name, $value)){
            return false;
        }
    }
    return strlen($name) < 200 && strlen($name) > 0;
}

function logout() {
    if(session_status() != PHP_SESSION_ACTIVE){
        session_start();
    }
    unsetRememberMe();
    session_unset();
    session_destroy();
}

function getUser($iduser){
    $result = query("SELECT * FROM vUser WHERE idUser = ?;", "i", $iduser);
    if(sizeof($result) == 0) {
        return false;
    }
    if($result[0]["image"] === NULL) {
        $result[0]["image"] = defaultProfileImgPath("m");
    }
    return $result[0];
}

function login($iduser, $rememberMe){
    $user = getUser($iduser);
    if(!$user) {
        return false;
    }
    setCocieAccepted();
    logout();
    session_start();
    $_SESSION["iduser"] = $user["idUser"];
    $_SESSION["username"] = $user["username"];
    $_SESSION["email"] = $user["email"];
    $_SESSION["country"] = $user["registerCountry"];
    $_SESSION["role"] = intval($user["idRole"]);
    if($rememberMe) {
        return rememberMe();
    }
    return true;
}

/**
 * Remember me
 */

function rememberMe() {
    if(!isLoggedIn()) {
        return false;
    }
    $iduser = $_SESSION["iduser"];
    $token = bin2hex(random_bytes(32));
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    if(!dbInsert("INSERT INTO TbRememberMe(iduser, `hash`) VALUES (?, ?);", "is", $iduser, $hashedToken)){
        return false;
    }
    $cookieValue = $iduser."::::".$token;
    setRememberMe($cookieValue);
    return true;
}

function tryRememberMeLogin() {
    if(isLoggedIn()) {
        return false;
    }
    if(!isset($_COOKIE["rememberMe"])) {
        return false;
    }
    $split = explode("::::", $_COOKIE["rememberMe"]);
    if(sizeof($split) != 2){
        return false;
    }
    $iduser = $split[0];
    $token = $split[1];
    $succsess = false;
    foreach (query("SELECT `hash` from TbRememberMe WHERE iduser = ?;", "i", $iduser) as $i => $row) {
        $hashedToken = $row["hash"];
        if(password_verify($token, $hashedToken)){
            $succsess = true;
        }
    }
    if(!$succsess){
        dbExecute("DELETE FROM TbRememberMe WHERE iduser = ?;", "i", $iduser);
        return false;
    }
    dbExecute("DELETE FROM TbRememberMe WHERE iduser = ? AND `hash` = ?;", "is", $iduser, $hashedToken);//delete old remember me as it will be refreshed in login function
    $succsess = login($iduser, true);
    return $succsess;
}

function setAthleteProfile($idAthlete) {
    if(!isLoggedIn()) return false;
    if(sizeof(getAthlete($idAthlete)) == 0) return false;
    return dbExecute("UPDATE TbUser SET athlete = ? WHERE iduser = ?", "ii", $idAthlete, $_SESSION["iduser"]);
}

function removeAthleteProfile() {
    if(!isLoggedIn()) return false;
    return dbExecute("UPDATE TbUser SET athlete = NULL, athleteChecked = 0 WHERE iduser = ?", "i", $_SESSION["iduser"]);
}