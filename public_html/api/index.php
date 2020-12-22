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

include_once "../../data/dbh.php";

/**
 * Getters
 */
if(isset($_GET["getperson"])){
    echo json_encode(getPerson($_GET["getperson"]));
}
if(isset($_GET["getcompetition"])){
    echo json_encode(getCompetition($_GET["getcompetition"]));
}
if(isset($_GET["getresult"])){
    echo json_encode(getResult($_GET["getresult"]));
}
if(isset($_GET["getrace"])){
    echo json_encode(getRace($_GET["getrace"]));
}
if(isset($_GET["getcountry"])){
    echo json_encode(getCountry($_GET["getcountry"]));
}

if(isset($_GET["search"])){
    echo json_encode(search($_GET["search"]));
}

/**
 * example
 * {"sureName":"Abdelsamie","firstName":"Mokhtar","gender":"M","country":"Egypt","linkCollection":null,"id":5,"mail":null,"comment":null,"club":null,"team":null,"image":null}
 */
function getPerson($id){
    $result = query("CALL sp_getPerson(?);", "i", intval($id));
    if(sizeof($result) > 0){
        return $result[0];
    } else{
        return false;
    }
}

/**
 * example
 * {"idCompetition":4,"startDate":null,"endDate":null,"location":"Wroclaw Wg","description":null,"type":"World Games","bild":null,"gpx":null,"raceyear":"2017"}
 */
function getCompetition($id){
    $result = query("CALL sp_getCompetition(?);", "i", intval($id));
    if(sizeof($result) > 0){
        return $result[0];
    } else{
        return false;
    }
}

/**
 * example
 * {"id":4,"place":34,"resultLink":null,"idRace":349,"idPerson":4,"idPerson2":null,"idPerson3":null,"sureName":"Abdellatif","firstName":"Mariam","gender":"W","country":"Egypt","linkCollection":null,"club":null,"team":null,"image":null,"location":"Nanjing","raceYear":"2016","type":null,"relay":0,"distance":"15000 Elimination Track","raceLink":null,"category":"Jun","remark":null,"trackStreet":null,"idCompetition":null}
 */
function getResult($id){
    $result = query("CALL sp_getResult(?);", "i", intval($id));
    if(sizeof($result) > 0){
        return $result[0];
    } else{
        return false;
    }
}

/**
 * example
 * {"id":349,"raceType":null,"relay":0,"distance":"15000 Elimination Track","raceLink":null,"category":"Jun","gender":"W","remark":null,"trackStreet":null,"idCompetition":null,"startDate":null,"endDate":null,"location":null,"competitionType":null,"gpx":null,"raceyear":null}
 */
function getRace($id){
    $result = query("CALL sp_getRace(?);", "i", intval($id));
    if(sizeof($result) > 0){
        $result[0]["results"] = getRaceResults($id);
        return $result[0];
    } else{
        return false;
    }
}

/**
 * example
 * {"id":349,"raceType":null,"relay":0,"distance":"15000 Elimination Track","raceLink":null,"category":"Jun","gender":"W","remark":null,"trackStreet":null,"idCompetition":null,"startDate":null,"endDate":null,"location":null,"competitionType":null,"gpx":null,"raceyear":null}
 */
function getRacesFromCompetition($id){
    $result = query("CALL sp_getRace(?);", "i", intval($id));
    if(sizeof($result) > 0){
        $result[0]["results"] = getRaceResults($id);
        return $result[0];
    } else{
        return false;
    }
}

function parsePersonFromResult($result, $index){
    $name = "p$index";
    if($index == -1){
        $name = "";
    }
    if(!isset($result[$name."id"])){
        return null;
    }
    $person = [
        "id" => NULL,
        "sureName" => NULL,
        "firstName" => NULL,
        "gender" => NULL,
        "country" => NULL,
        "linkCollection" => NULL,
        "club" => NULL,
        "team" => NULL,
        "image" => NULL
    ];
    foreach ($person as $key => $value) {
        if(isset($result[$name.$key])){
            $person[$key] = $result[$name.$key];
        }
    }
    return $person;
}

function getRaceResults($id){
    $results = query("CALL sp_getRaceResults(?);", "i", intval($id));
    $counter = 0;
    foreach ($results as $key => $result) {
        for ($person=1; $person < 4; $person++) { 
            $results[$counter] ["person".$person] = parsePersonFromResult($result, $person);
        }
        $counter++;
    }
    return $results;
}

/**
 * Get all athletes from a country
 * Example:
 * [{"surname":"Albrecht","firstname":"Simon","gender":"M","country":"Germany","linkCollection":null,"id":40,"club":null,"team":null,"image":null,"birthYear":null,"LVKuerzel":null}}
 */
function getCountry($name){
    $result = query("CALL sp_getCountry(?);", "s", $name);
    $persons = [];
    if(sizeof($result) > 0){
        foreach ($result as $key => $person) {
            $persons[] = parsePersonFromResult($person, -1);
        }
        return $persons;
    } else{
        return false;
    }
}

/**
 * Searches through the names of every person, and competition to find matching names
 * 
 * Search syntax
 * 
 * <name> searching for names of persons
 * <type> searching for competiotions by type
 * <year> year of competition
 * <location> location of competition
 * <country> country
 * 
 */
function search($name){
    $name = trim($name);//remove whitespaces at front and end
    $results = [];
    /**
     * Year
     */
    $year = substr($name, 0, 4);
    $competition = null;
    if(is_numeric($year)){
        $competitions = query("CALL sp_searchYear(?);", "i", intval($year));
        if(sizeof($competitions) > 0){
            $competition = $competitions[0];
        }
        foreach ($competitions as $key => $competition) {
            $results[] = [
                "id" => $competition["idCompetition"],
                "name" => $competition["type"]." ".$competition["location"]." ".$competition["raceYear"],
                "priority" => (intval($year) == $competition["raceYear"]) ? 2 : 1,
                "type" => "competition"
            ];
        }
    } else{
        /**
         * Competition location
         */
        $delimiter = strpos($name, ":");
        $competitionName = $name;
        if($delimiter != -1){
            $competitionName = substr($name, $delimiter + 1);
        }
        $competitions = query("CALL sp_searchCompetitionLocation(?)", "s", $competitionName);
        foreach ($competitions as $key => $competition) {
            $results[] = [
                "id" => $competition["idCompetition"],
                "name" => $competition["type"]." ".$competition["location"]." ".$competition["raceYear"],
                "priority" => (intval($year) == $competition["raceYear"]) ? 2 : 1,
                "type" => "competition"
            ];
        }
        /**
         * persons names
         */
        $names = explode("  ", $name);
        $personIds = [];
        foreach ($names as $key => $value) {
            $persons = query("CALL sp_searchPerson(?)", "s", $value);
            foreach ($persons as $key => $person) {
                if(!in_array($person["id"], $personIds)){
                    $personIds[] = $person["id"];
                    $results[] = [
                        "id" => $person["id"],
                        "name" => $person["firstName"]." ".$person["sureName"]." - ".$person["country"],
                        "priority" => 1,
                        "type" => "person"
                    ];
                } else{
                    $i = 0;
                    foreach ($results as $key => $value) {
                        if($value["type"] == "person" && $value["id"] == $person["id"]){
                            $results[$i] ["priority"] = 5;
                        }
                        $i++;
                    }
                }
            }
        }
        /**
         * competitionTypes
         */
        foreach ($names as $key => $value) {
            $competitions = query("CALL sp_searchCompetitionType(?)", "s", $value);
            foreach ($competitions as $key => $competition) {
                $results[] = [
                    "id" => $competition["idCompetition"],
                    "name" => $competition["type"]." ".$competition["location"]." ".$competition["raceYear"],
                    "priority" => 2,
                    "type" => "competition"
                ];
            }
        }
        /**
         * countries
         */
        foreach ($names as $key => $value) {
            $countries = query("CALL sp_searchCountry(?)", "s", $value);
            foreach ($countries as $key => $country) {
                $results[] = [
                    "id" => -1,
                    "name" => $country["country"],
                    "priority" => 4,
                    "type" => "country"
                ];
            }
        }
    }
    // @todo
    // $delimiter = strpos($name, ":");
    // if($delimiter != -1){
    //     $name = substr($name, $delimiter + 1);
    // }
    return $results;
}