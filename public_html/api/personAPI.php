<?php

include_once $_SERVER["DOCUMENT_ROOT"]."/api/index.php";
include_once "../../data/dbh.php";

/**
 * Updates a person with new values
 * example data:
 * Array
 *   (
 *       [lastname] => Lehnertz
 *       [firstname] => Timo
 *       [gender] => M
 *       [country] => Germany
 *       [linkCollection] => 
 *       [mail] => 
 *       [comment] => 
 *       [club] => Cologne Speed Team
 *       [team] => Bont
 *       [birthYear] => 
 *       [LVKuerzel] => 
 *       [source] => 
 *       [image] => athlete:Timo-Lehnertz-5fec8aebc37088.30008448.png
 *   )
 */
function updatePerson($idperson, $person){
    global $mysqli;
    $oldPerson = getAthlete($idperson);
    $update = "";
    $delimiter = "";
    $types = "";
    $vals = [];
    foreach ($person as $key => $value) {
        $update .= "$delimiter `$key` = ?";
        $vals[] = $value;
        if($key === "birthYear"){
            $types .= "i";
        } else{
            $types .= "s";
        }
        $delimiter = ", ";
    }
    $vals[] = $idperson;
    $succsess = dbExecuteArr("UPDATE TbAthlete SET $update WHERE id = ?;", $types."i", $vals);
    // if($oldPerson["image"] !== $person["image"]){
    //     deleteImg($oldPerson["image"]);
    // }
    return $succsess;
}