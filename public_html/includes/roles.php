<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/api/userAPI.php";
/**
 * File for dealing with roles wich are stored as numbers for each user
 * 0 is the default role with the least permissions
 * with idrole set to 0 all permissions are set to false
 */

$defaultPermissions = [
    0 => "defauilt",
    50 =>"seeAdminPage",
    90 => "configureAthletes",
    100 =>"managePermissions",
];

function permissionsForUser($user){
    /**
     * default permissions
     */
    global $defaultPermissions;
    $permissions = [];
    if(is_null($user)){//all to false
        foreach ($defaultPermissions as $key => $value) {
            $permissions[$value] = false;
        }
        return $permissions;
    }
    $idrole = $user["idrole"];
    foreach ($defaultPermissions as $key => $value) {
        $permissions[$value] = $idrole >= $key;
    }
    return $permissions;
}

function canI($permission){
    $user = null;
    if(isLoggedIn()){
        $user = getUser($_SESSION["iduser"]);
    }
   return permissionsForUser($user)[$permission];
}