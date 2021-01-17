<?php

include_once "utils.php";

define("FILE", "files/plans.json");

if(isset($_GET["getteachers"])){
    echo json_encode(getTeachers());
}
if(isset($_GET["getsubjects"])){
    echo json_encode(getSubjects());
}
if(isset($_GET["getrooms"])){
    echo json_encode(getRooms());
}
if(isset($_GET["getplans"])){
    echo json_encode(getStundenplanFromFile());
}
if(isset($_GET["getplan"]) && isset($_GET["name"])){
    $name = $_GET["name"];
    if(planNameExist($name)){
        echo json_encode(getPlan($_GET["name"]));
    } else{
        echo "error does not exist";
    }
}
if(isset($_GET["setplan"])){
    $data = json_decode(file_get_contents('php://input'), true);
    // print_r($data);
    if(!saveStundenplan($data)){
        echo "error";
    }
}


if(isset($_GET["addteacher"]) && isset($_GET["name"])){
    $name = $_GET["name"];
    addTeacher($name);
}
if(isset($_GET["addsubject"]) && isset($_GET["name"])){
    $name = $_GET["name"];
    addSubject($name);
}
if(isset($_GET["addroom"]) && isset($_GET["name"])){
    $name = $_GET["name"];
    addRoom($name);
}
if(isset($_GET["addplan"]) && isset($_GET["name"])){
    $name = $_GET["name"];
    if(addPlan($name)){
        echo "succsess";
    } else{
        echo "error";
    }
}

function init(){
    $init = [
        "teachers" => ["Rosenthal", "Tikko", "Polep", "Belmiloud"],
        "subjects" => ["Deutsch", "Mathe", "Englisch", "Programmieren", "Sport"],
        "rooms" => ["B112", "B111", "B109", "B107", "B107"],
        "plans" => []];
    if(getStundenplanFromFile()){
        return;
    }
    setStundenplan($init);
}

function saveStundenplan($plan){
    $old = getStundenplanFromFile();
    if(isset($plan["name"])){
        // print_r($old["plans"]);
        foreach ($old["plans"] as $key => $oldPlan) {
            if($oldPlan["name"] == $plan["name"]){
                $old["plans"] [$key] = $plan;
                setStundenplan($old);
                echo "succsess";
                return true;
            }
        }
    }
    return false;
}

function getStundenplanFromFile(){
    if(!file_exists(constant("FILE"))){
        return false;
    }
    $strJsonFileContents = file_get_contents(constant("FILE"));
    // Convert to array 
    $array = json_decode($strJsonFileContents, true);
    return $array;
}

function setStundenplan($data){
    file_put_contents(constant("FILE"), json_encode($data));
}

function getPlan($name){
    foreach (getStundenplanFromFile()["plans"] as $i => $plan) {
        if($plan["name"] == $name){
            return $plan;
        }
    }
    return [];
}

function getPlanNames(){
    $names = [];
    foreach (getStundenplanFromFile()["plans"] as $i => $plan) {
        $names[] = $plan["name"];
    }
    return $names;
}

function planNameExist($name){
    $names = getPlanNames();
    foreach ($names as $i => $name1) {
        if($name1 == $name){
            return true;
        }
    }
    return false;
}

function addTeacher($name){
    $data = getStundenplanFromFile();
    $data["teachers"][] = $name;
    setStundenplan($data);
}

function addSubject($name){
    $data = getStundenplanFromFile();
    $data["subjects"][] = $name;
    setStundenplan($data);
}

function addRoom($name){
    $data = getStundenplanFromFile();
    $data["rooms"][] = $name;
    setStundenplan($data);
}

function getTeachers(){
    return getStundenplanFromFile()["teachers"];
}

function getSubjects(){
    return getStundenplanFromFile()["subjects"];
}

function getRooms(){
    return getStundenplanFromFile()["rooms"];
}

function addPlan($name){
    if(planNameExist($name)){
        return false;
    }
    $data = getStundenplanFromFile();
    $data["plans"][] = getNewStundenplan($name, 4);
    setStundenplan($data);
    return true;
}

function getNewStundenplan($name, $days){
    $plan = ["name" => $name, "days" => []];
    for ($day=0; $day < $days; $day++) { 
        $plan["days"][$day] = getNewDay($day, 9);
    }
    return $plan;
}

function getNewDay($index, $hours){
    $day = ["name" => indexToDay($index), "hours" => []];
    for ($hour=0; $hour < $hours; $hour++) { 
        $day["hours"][$hour] = getNewHour($hour);
    }
    return $day;
}

function getNewHour($index){
    return [
        "index" => $index,
        "subject" => "unset",
        "teacher" => "unset",
        "room" => "unset"];
}

function indexToDay($index){
    $days = ["Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag", "Sonntag"];
    return $days[$index];
}