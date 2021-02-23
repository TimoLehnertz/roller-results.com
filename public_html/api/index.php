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
 *      getAthlete
 *          id
 */

include_once $_SERVER["DOCUMENT_ROOT"]."/../data/dbh.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/includes/roles.php";
canI("managePermissions");
/**
 * Getters
 */

if(!isset($NO_GET_API)){
    if(isset($_GET["getathlete"])){
        $res = getAthlete($_GET["getathlete"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getcompetition"])){
        $res = getCompetition($_GET["getcompetition"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getresult"])){
        $res = getResult($_GET["getresult"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getrace"])){
        $res = getRace($_GET["getrace"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    }else if(isset($_GET["getraces"])){
        $res = getRaces();
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getcountry"])){
        $res = getCountry($_GET["getcountry"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getcountries"])){
        $res = getCountries();
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["search"])){
        $res = search($_GET["search"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getathleteCompetitions"])){
        $res = getAthleteCompetitions($_GET["getathleteCompetitions"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getcountryCompetitions"])){
        $res = getCountryCompetitions($_GET["getcountryCompetitions"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    }else if(isset($_GET["getcountryAthletes"])){
        $limit = 10;
        if(isset($_GET["data"])){
            $limit = $_GET["data"];
        }
        $res = getCountryAthletes($_GET["getcountryAthletes"], $limit);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    }
    else if(isset($_GET["getathleteBestTimes"])){
        $res = getAthleteBestTimes($_GET["getathleteBestTimes"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    }
    else if(isset($_GET["getcountryBestTimes"])){
        $res = getCountryBestTimes($_GET["getcountryBestTimes"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    }
    else if(isset($_GET["getcountryCareer"])){
        $res = getCountryCareer($_GET["getcountryCareer"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    }
    else if(isset($_GET["getathleteCareer"])){
        $res = getAthleteCareer($_GET["getathleteCareer"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    }else if(isset($_GET["getallAthletes"])){
        $res = getAllAthletes();
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    }else if(isset($_GET["getcountryCodes"])){
        $res = getCountryCodes();
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    }else if(isset($_GET["getallCompetitions"])){
        $res = getAllCompetitions();
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    }else if(isset($_GET["getbestAthletes"])){
        echo json_encode(getBestSkaters());
    } else if(isset($_GET["getathleteRacesFromCompetition"])){
        $id = intval($_GET["getathleteRacesFromCompetition"]);
        if(isset($_GET["data"])){
            $data = $_GET["data"];
            echo json_encode(getAthleteRacesFromCompetition($id, $data));
        } else{
            echo "error provide data";
        }
    }
    /**
     * set api
     */
    /**
     * takes an array of objects each {idRace: ?, link: "?"}
     * link beeing a ; seperated string of youtube links
     */
    if(canI("managePermissions")){
        if(isset($_GET["setraceLinks"])){
            $data = json_decode(file_get_contents('php://input'), true);
            if($data === null){
                echo "Data could not be parsed :(";
                exit();
            }
            setRaceLinks($data);
        }
    }
}

function setRaceLinks($races){
    // var_dump($races);
    $oldRaces = getRaces();

    $new = [];

    foreach ($oldRaces as $key => &$oldRace) {
        foreach ($races as $newRace) {
            if($newRace["idRace"] === $oldRace["idRace"]){
                $oldLinks = [];
                if($oldRace["link"]){
                    $oldLinks = explode(";", $oldRace["link"]);
                }
                $newLinks = [];
                if($newRace["link"]){
                    var_dump($newRace["link"]);
                    $newLinks = explode(";", $newRace["link"]);
                    // $newLinks = $newRace["link"];
                }
                if($newLinks === false){
                    continue;
                }
                if(sizeof($newLinks) === 0){
                    continue;
                }

                var_dump($newLinks);

                $insertLink = $oldRace["link"];
                $changed = false;

                $delimiter = "";
                if(strlen($oldRace["link"]) > 0){
                    $delimiter = ";";
                }
                
                foreach ($newLinks as $key => $link) {
                    if(!in_array($link, $oldLinks)){
                        $insertLink .= $delimiter.$link;
                        $delimiter = ";";
                        $changed = true;
                    }
                }
                if($changed){
                    $new[$oldRace["idRace"]] = $insertLink;
                }
                break;//next
            }
        }
    }
    var_dump($new);
    foreach ($new as $idRace => $link) {
        dbExecute("UPDATE TbRace SET link = ? WHERE id = ?;", "si", $link, $idRace);
    }
    // $delimiter = "";
    // $sql = "UPDATE TbRace SET link";
}



function getAllCompetitions(){
    $res = query("SELECT * FROM vCompetition;");
    if(sizeof($res) > 0){
        return $res;
    } else{
        return [];
    }
}

function getCountryCodes(){
    $res = query("SELECT * FROM TbCountry;");
    if(sizeof($res) > 0){
        return $res;
    } else{
        return [];
    }
}

function getAllAthletes(){
    $res = query("SELECT * FROM vAthletePublic;");
    if(sizeof($res) > 0){
        return $res;
    } else{
        return [];
    }
}

function getCountryCareer($country){
    $res = query("CALL sp_countryCareer(?);", "s", $country);
    if(sizeof($res) > 0){
        return $res;
    } else{
        return [];
    }
}

function getAthleteCareer($idAthlete){
    $res = query("CALL sp_athleteCareer(?);", "i", $idAthlete);
    if(sizeof($res) > 0){
        return $res;
    } else{
        return [];
    }
}

function getCountryBestTimes($country){
    $times = query("CALL sp_getCountryBestTimes(?);", "s", $country);
    if(sizeof($times) > 0){
        return $times;
    } else{
        return [];
    }
}

function getAthleteBestTimes($idAthlete){
    $times = query("CALL sp_getAthleteBestTimes(?);", "i", $idAthlete);
    if(sizeof($times) > 0){
        return $times;
    } else{
        return [];
    }
}

function getCountryAthletes($country, $limit){
    $res = query("SELECT * FROM vAthlete WHERE country = ? ORDER BY score DESC LIMIT ?;", "si", $country, $limit);
    if(sizeof($res) > 0){
        return $res;
    } else{
        return [];
    }
}

function getAthleteAmount(){
    $res = query("SELECT count(*) as amount FROM vAthletePublic;");
    if(sizeof($res) > 0){
        return $res[0]["amount"];
    } else{
        return [];
    }
}

function getCountryAmount(){
    $res = query("SELECT count(*) as amount FROM vCountry;");
    if(sizeof($res) > 0){
        return $res[0]["amount"];
    } else{
        return [];
    }
}

function getResultAmount(){
    $res = query("SELECT count(*) as amount FROM vResult;");
    if(sizeof($res) > 0){
        return $res[0]["amount"];
    } else{
        return [];
    }
}

function getRaceAmount(){
    $res = query("SELECT count(*) as amount FROM vRace;");
    if(sizeof($res) > 0){
        return $res[0]["amount"];
    } else{
        return [];
    }
}

function getCompetitionAmount(){
    $res = query("SELECT count(*) as amount FROM vCompetitionSmall;");
    if(sizeof($res) > 0){
        return $res[0]["amount"];
    } else{
        return [];
    }
}

function getCountryCompetitions($country){
    $competitions = query("CALL sp_getCountryCompetitions(?);", "s", $country);
    if(sizeof($competitions) > 0){
        foreach ($competitions as $key => &$competition) {
            $competition["races"] = getCountryRacesFromCompetition($country, $competition["idCompetition"]);
        }
        return $competitions;
    } else{
        return [];
    }
}

function getCountryRacesFromCompetition($country, $idcompetition){
    $races = query("CALL sp_getCountryRacesFromCompetition(?, ?);", "si", $country, intval($idcompetition));
    if(sizeof($races) > 0){
        return $races;
    } else {
        return [];
    }
}

function getBestSkaters(){
    $skaters = query("SELECT * FROM vAthletePublic ORDER BY score DESC LIMIT 100;");
    if(sizeof($skaters) > 0){
        return $skaters;
    } else{
        return [];
    }
}

function getYearCompetitions($year){
    $comps = query("SELECT * FROM vCompetition WHERE raceYear = ?;", "i", $year);
    if(sizeof($comps) > 0){
        return $comps;
    } else{
        return [];
    }
}

function getAthleteRacesFromCompetition($idathlete, $idcompetition){
    $races = query("CALL sp_getAthleteRacesFromCompetition(?, ?);", "ii", intval($idathlete), intval($idcompetition));
    if(sizeof($races) > 0){
        return $races;
    } else {
        return [];
    }
}

function getAthleteCompetitions($idathlete){
    $competitions = query("CALL sp_getAthleteCompetitions(?);", "i", intval($idathlete));
    if(sizeof($competitions) > 0){
        foreach ($competitions as $key => $competition) {
            $competitions[$key] ["races"] = getAthleteRacesFromCompetition($idathlete, $competition["idCompetition"]);
        }
        return $competitions;
    } else{
        return [];
    }
}

function getAthlete($id){
    $result = query("SELECT * FROM vAthlete WHERE idAthlete = ?;", "i", intval($id));
    if(sizeof($result) > 0){
        return $result[0];
    } else{
        return [];
    }
}

function getCompetition($id){
    $result = query("SELECT * FROM vCompetition WHERE idCompetition = ?;", "i", intval($id));
    if(sizeof($result) > 0){
        $result[0] ["races"] = getRacesFromCompetition($id);
        return $result[0];
    } else{
        return [];
    }
}

function getCountry($name){
    $country = query("SELECT * FROM vCountry WHERE country = ?;", "s", $name);
    if(sizeof($country) > 0){
        return $country[0];
    } else{
        return [];
    }
}

function getCountries(){
    $countries = query("SELECT * FROM vCountry ORDER BY score DESC");
    if(sizeof($countries) > 0){
        return $countries;
    } else{
        return [];
    }
}

function getResult($id){
    $result = query("SELECT * FROM vResult WHERE idResult = ?;", "i", intval($id));
    if(sizeof($result) > 0){
        return $result[0];
    } else{
        return [];
    }
}

function getRace($id){
    $result = query("SELECT * FROM vRace WHERE idRace = ?;", "i", intval($id));
    if(sizeof($result) > 0){
        $result[0]["results"] = getRaceResults($id);
        return $result[0];
    } else{
        return [];
    }
}

function getRaces(){
    $result = query("SELECT * FROM vRace;");
    if(sizeof($result) > 0){
        return $result;
    } else{
        return [];
    }
}

function getRacesFromCompetition($id){
    $result = query("CALL sp_getRacesFromCompetition(?);", "i", intval($id));
    if(sizeof($result) > 0){
        return $result;
    } else{
        return [];
    }
}

function getRaceResults($id){
    $results = query("CALL sp_getRaceResults(?);", "i", intval($id));
    // print_r($results);
    $parsed = [];
    foreach ($results as $key => &$result) {
        $place = $result["place"];
        if(!array_key_exists($place, $parsed)){
            $parsed[$place] = $result;
        }
        $parsed[$place]["athletes"][] = athleteFromResult($result);
    }
    $filtered = [];
    foreach ($parsed as $key => $value) {
        if(isset($value)){
            $filtered[] = $value;
        }
    }
    return $filtered;
}

function athleteFromResult($result){
    $athlete = [
        "idAthlete" => NULL,
        "firstname" => NULL,
        "lastname" => NULL,
        "gender" => NULL,
        "country" => NULL,
        "club" => NULL,
        "team" => NULL,
        "image" => NULL,
        "birthYear" => NULL,
        "facebook" => NULL,
        "instagram" => NULL,
        "rank" => NULL,
        "score" => NULL,
        "scoreShort" => NULL,
        "scoreLong" => NULL,
        "bronze" => NULL,
        "silver" => NULL,
        "gold" => NULL,
        "topTen" => NULL,
        "medalScore" => NULL,
        "raceCount" => NULL,
        "minAge" => NULL,
    ];
    foreach ($athlete as $key => $val) {
        if(array_key_exists($key, $result)){
            $athlete[$key] = $result[$key];
        }
    }
    return $athlete;
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
    setMaxResultSize(10);
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
        $results = array_merge($results, searchPersons($name));
        /**
         * competitionTypes
         */
        $names = explode("  ", $name);
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
                    "id" => $country["country"],
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
    setMaxResultSize(-1);
    return $results;
}

function searchPersons($name){
    $results = [];
    $names = explode("  ", $name);
    $personIds = [];
    foreach ($names as $key => $value) {
        $persons = query("CALL sp_searchPerson(?)", "s", $value);
        foreach ($persons as $key => $person) {
            if(!in_array($person["idAthlete"], $personIds)){
                $personIds[] = $person["idAthlete"];
                $results[] = [
                    "id" => $person["idAthlete"],
                    "name" => $person["firstname"]." ".$person["lastname"]." - ".$person["country"],
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
    return $results;
}