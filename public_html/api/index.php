<?php
/**
 * Php api for interacting with the database
 * 
 * get methods always return a json array of the requested data and take an ID
 * the returned array does not include child arrays. only specific information
 * 
 * get methods:
 *      getrace 
 *          id
 *      getcompetition
 *          id
 *      getresult
 *          id
 *      getperson
 *          id
 */

if(isset($_GET["getperson"])){
    if($id = $_GET["id"]){
        echo json_encode(getPerson($id));
    }
}

function getPerson($id){
    return 0;
}

