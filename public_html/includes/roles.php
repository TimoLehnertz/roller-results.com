<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/api/userAPI.php";
/**
 * File for dealing with roles wich are stored as numbers for each user
 * 0 is the default role with the least permissions
 * with idRole set to 0 all permissions are set to false
 */

$defaultPermissions = [
    0   => "default",
    5  => "uploadResults",
    10  => "speaker",
    50  =>"seeAdminPage",
    90  => "configureAthletes",
    100 =>"managePermissions",
];

function permissionsForRole($role){
    /**
     * default permissions
     */
    global $defaultPermissions;
    $permissions = [];
    // if(is_null($user)){//all to false
    //     foreach ($defaultPermissions as $key => $value) {
    //         $permissions[$value] = false;
    //     }
    //     return $permissions;
    // }
    // $idRole = $user["idRole"];
    foreach ($defaultPermissions as $key => $value) {
        $permissions[$value] = $role >= $key;
    }
    return $permissions;
}

function canI($permission){
    // $user = null;
    $p;
    if(!isLoggedIn()){
        // $user = getUser($_SESSION["iduser"]);
        $p = permissionsForRole(0);
    } else {
        $p = permissionsForRole($_SESSION["role"]);
    }
    return $p[$permission];
    // return permissionsForUser($user)[$permission];
}