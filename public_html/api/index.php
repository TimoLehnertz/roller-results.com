<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/../data/dbh.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/includes/roles.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/api/userAPI.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/includes/roles.php";

$allowedOrigins = [
    // 'https://api.jquery.com',
    // 'https://flow.polar.com',
    // 'http://localhost/',
];
if(isset($_SERVER['HTTP_ORIGIN'])) {
    if(in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
        header("Access-Control-Allow-Origin: ".$_SERVER['HTTP_ORIGIN']);
    }
}

// nameOfFunction => minPermissionLevel
// has to stay updated because not listed functions will be available for everyone
$functions = [
    "getathlete" => 1,
    "getathleteWithScore" => 1,
    "getcompetition" => 1,
    "getathleteVideos" => 1,
    "getrace" => 1,
    "getraces" => 1,
    "getcountry" => 1,
    "getcountries" => 1,
    "getworldMovement" => 1,
    "search" => 1,
    "getathleteCompetitions" => 1,
    "getcountryCompetitions" => 1,
    "getcountryRacesFromCompetition" => 1,
    "getcountryAthletes" => 1,
    "getcountryAthletes" => 1,
    "getathleteBestTimes" => 1,
    "getputAthleteImage" => 1,
    "getremoveAthleteImage" => 1,
    "getcountryBestTimes" => 1,
    "getcountryCareer" => 1,
    "getaliasGroup" => 1,
    "getcountryCodes" => 1,
    "getallCompetitions" => 1,
    "getallDistances" => 1,
    "getcountryScores" => 1,
    "gethallOfFame" => 1,
    "createResults" => 1,
    "createRace" => 1,
    "getathleteRacesFromCompetition" => 1,
    "compAthleteMedals" => 1,
    "compCountryMedals" => 1,
    "get500mData" => 1,
    "getyourCompetitions" => 1,
    "getRaceDescription" => 1,
    "getteamAdvantage" => 1,
    "uploadResults" => 1,
    "uploadTriggers" => 1,
    "getathleteImages" => 1,
    "getdeleteCompetition" => 1,
    "getteamAdvantageDetails" => 1,
    "setathletes" => 1,
    "getselectPresets" => 1,
    "getdeleteRace" => 1,
    "getdeleteSelectPreset" => 1,
    "getdeleteAnalytics" => 1,
    "getanalytics" => 1,
    "getimgAthletes" => 1,
    "searchAthletes" => 1,
    "searchAthletesFullname" => 1,
    "putAliases" => 1,
    "getathleteMedals" => 1,
    "getcompRaces" => 1,
    "getcompRacesFlow" => 1,
    "getraceAthletes" => 1,
    "overtakes" => 1,
    "getovertakes" => 1,
    "getovertakesByDistance" => 1,
    "aliasIds" => 1,
    "setraceLinks" => 1,
    "setanalytics" => 1,
    "setupdateCompetition" => 1,
];


if(session_status() != PHP_SESSION_ACTIVE){
    session_start();
}
if(!isset($_SESSION["apiGranted"]) || $_SESSION["apiGranted"] != true) {
    // $NO_GET_API = true;
    if(isset($_GET["apiKey"])) {
        if(checkApiKey($_GET["apiKey"])) {
            $NO_GET_API = false;
        } else {
            echo "Your API key doesn't allow you to do that!";
        }
    }
}

function checkApiKey($apiKey) {
    global $functions;
    $apiKeys = query("SELECT * FROM TbApiKey WHERE `key`=?;", "s", $apiKey);
    if(sizeof($apiKeys) == 0) return false;
    $keyPermissionLevel = $apiKeys[0]["permissionLevel"];
    if($keyPermissionLevel == 0) return false;
    foreach ($_GET as $key => $value) { // check all get parameters for permission
        if(!array_key_exists($key, $functions)) continue; // skip unrelevant get parameter
        if($keyPermissionLevel < $functions[$key]) {
            dbExecute("UPDATE TbApiKey SET amountUsedWrongly = amountUsedWrongly + 1 WHERE `key`=?;", "s", $apiKey); // remember wrong usage
            return false;
        }
    }
    dbExecute("UPDATE TbApiKey SET amountUsed = amountUsed + 1 WHERE `key`=?;", "s", $apiKey); // remember wrong usage
    return true;
}

// canI("managePermissions");

/**
 * setup
 */
$scoreInfluences = "WM,World Games,EM"; // @todo
$usedMedals = "WM,World Games,Junior,Senior,";

if(isset($_SESSION["usedMedals"])) {
    $usedMedals = $_SESSION["usedMedals"];
}

/**
 * Getters
 */
if(!isset($NO_GET_API) || $NO_GET_API === false) {
    if(isset($_GET["scoreInfluences"])) {
        $scoreInfluences = $_GET["scoreInfluences"];
    }
    if(isset($_GET["usedMedals"])) {
        $usedMedals = $_GET["usedMedals"];
        $_SESSION["usedMedals"] = $usedMedals;
    } if(isset($_GET["getathlete"])) {
        $res = getAthlete($_GET["getathlete"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } if(isset($_GET["getathleteWithScore"])) {
        $res = getAthleteWithScore($_GET["getathleteWithScore"]);
        if($res !== false) {
            echo json_encode($res);
        } else {
            echo "error in api :/";
        }
    } else if(isset($_GET["getcompetition"])) {
        $res = getCompetition($_GET["getcompetition"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getathleteVideos"])) {
        echo json_encode(getAthleteVideos($_GET["getathleteVideos"]));
    } else if(isset($_GET["getresult"])){
        $res = getResult($_GET["getresult"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getrace"])) {
        $res = getRace($_GET["getrace"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    }else if(isset($_GET["getraces"])) {
        $res = getRaces();
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getcountry"])) {
        $res = getCountry($_GET["getcountry"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getcountries"])) {
        $res = getCountries();
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getworldMovement"])) {
        $res = getWorldMovement();
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["search"])) {
        $allowed = "Athlete";
        if(isset($_GET["allowed"])) {
            $allowed = $_GET["allowed"];
        }
        $res = search($_GET["search"], $allowed);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getathleteCompetitions"])) {
        $res = getAthleteCompetitions($_GET["getathleteCompetitions"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getcountryCompetitions"])) {
        $res = getCountryCompetitions($_GET["getcountryCompetitions"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    }else if(isset($_GET["getcountryRacesFromCompetition"]) && isset($_GET["data"])) {
        $res = getCountryRacesFromCompetition($_GET["getcountryRacesFromCompetition"], $_GET["data"]);
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
    else if(isset($_GET["getathleteBestTimes"])) {
        $res = getAthleteBestTimes($_GET["getathleteBestTimes"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getputAthleteImage"]) && isset($_GET["data"])) {
        if(putAthleteImage($_GET["getputAthleteImage"], $_GET["data"])) {
            echo "true";
        } else {
            echo "false";
        }
    } else if(isset($_GET["getremoveAthleteImage"]) && isset($_GET["data"])) {
        if(removeAthleteImage($_GET["getremoveAthleteImage"], $_GET["data"])) {
            echo "true";
        } else {
            echo "false";
        }
    } else if(isset($_GET["getcountryBestTimes"])) {
        $res = getCountryBestTimes($_GET["getcountryBestTimes"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    }
    else if(isset($_GET["getcountryCareer"])) {
        $res = getCountryCareer($_GET["getcountryCareer"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getaliasGroup"])) {
        echo json_encode(getAliasGroup($_GET["getaliasGroup"]));
    } else if(isset($_GET["getathleteCareer"])){
        $res = getAthleteCareer($_GET["getathleteCareer"]);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    // } else if(isset($_GET["getallAthletes"])) {
    //     $res = getAllAthletes();
    //     if($res !== false){
    //         echo json_encode($res);
    //     } else{
    //         echo "error in api";
    //     }
    } else if(isset($_GET["getcountryCodes"])) {
        $res = getCountryCodes();
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getallCompetitions"])) {
        $res = getAllCompetitions();
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getallDistances"])) {
        $res = getAllDistances();
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getcountryScores"])) {
        $res = getCountryScores();
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["gethallOfFame"])) {
        // if(strlen($_GET["gethallOfFame"]) > 0){
            echo json_encode(getBestSkaters());
        // }
    } else if(isset($_GET["createResults"])) {
        $results = json_decode(file_get_contents('php://input'), true);
        if(!is_array($results)) {
            echo "invalid results";
            exit();
        }
        foreach ($results as $result) { // check for errors before creating
            if(!isset($result["idAthlete"]) || !isset($result["idRace"]) || !isset($result["place"])) {
                print_r($result);
                echo "incomplete result encountered";
                exit(0);
            }
        }
        createResults($results);
    } else if(isset($_GET["createRace"])) {
        $race = json_decode(file_get_contents('php://input'), true);
        if(!isset($race["distance"]) || !isset($race["isRelay"]) || !isset($race["gender"]) || !isset($race["category"]) || !isset($race["trackRoad"]) || !isset($race["idCompetition"])) {
            print_r($race);
            echo "invalid race";
            exit();
        }
        $race["round"] = $race["round"] ?? NULL;
        $response["id"] = createRace($race["distance"], $race["isRelay"], $race["gender"], $race["category"], $race["trackRoad"], $race["idCompetition"], $race["round"]);
        echo json_encode($response);
    } else if(isset($_GET["getathleteRacesFromCompetition"])){
        $id = intval($_GET["getathleteRacesFromCompetition"]);
        if(isset($_GET["data"])){
            $data = $_GET["data"];
            echo json_encode(getAthleteRacesFromCompetition($id, $data));
        } else {
            echo "error provide data";
        }
    } else if(isset($_GET["compAthleteMedals"])) {
        if(strlen($_GET["compAthleteMedals"]) > 0){
            $idComp = $_GET["gethallOfFame"];
            echo json_encode(getCompAthleteMedals($idComp));
        }
    } else if(isset($_GET["compCountryMedals"])) {
        if(strlen($_GET["compCountryMedals"]) > 0){
            $idComp = $_GET["compCountryMedals"];
            echo json_encode(getCompCountryMedals($idComp));
        }
    } else if(isset($_GET["get500mData"])){
        echo json_encode(get500mData());
    } else if(isset($_GET["getyourCompetitions"])){
        echo json_encode(getYourCompetitions());
    }
    /**
    * Year: year of competition
    * distance: distance
    * gender: Woman / Men
    * round: must be either final empty
    * event: World games / World Championship / European Championship / Youth Olympic Games
    * category: Junior / Senior
    */
   else if(isset($_GET["getRaceDescription"])) {
       if(!isset($_GET["year"]) || !isset($_GET["distance"]) || !isset($_GET["gender"]) || !isset($_GET["event"]) || !isset($_GET["category"])) {
           echo "Parameter missing!";
           exit();
       }
       if(isset($_GET["round"]) && $_GET["round"] != "Final") exit();
       echo getRaceDescription($_GET["year"], $_GET["event"], $_GET["distance"], $_GET["gender"], $_GET["category"]);
   } else if(isset($_GET["getteamAdvantage"])) {
        if(isset($_GET["data"]) && isset($_GET["data1"])) {
            echo json_encode(getTeamAdvantage($_GET["getteamAdvantage"], $_GET["data"], $_GET["data1"]));
        } else {
            echo("supply distance, maxplace and comps arguments!");
        }
    } else if(isset($_GET["uploadResults"])){
        $data = json_decode(file_get_contents('php://input'), true);
        // var_dump($data);
        if(!isset($_GET["lname"]) || !isset($data["a"]) || !isset($data["d"]) || !isset($data["l"]) || !isset($_GET["user"])) {
            echo "invalid";
            exit(0);
        }
        insertLaserResult($data, $_GET["user"], $_GET["lname"]);
    } else if(isset($_GET["uploadTriggers"]) && isset($_GET["user"])) {
        insertTrigger(file_get_contents('php://input'), $_GET["user"]);
    } else if(isset($_GET["getathleteImages"])) {
        echo json_encode(getAthleteImages($_GET["getathleteImages"]));
    } else if(isset($_GET["getdeleteCompetition"])) {
        deleteCompetition($_GET["getdeleteCompetition"]);
    } else if(isset($_GET["getteamAdvantageDetails"])) {
        if(isset($_GET["data"]) && isset($_GET["data1"])) {
            echo json_encode(getTeamAdvantageDetails($_GET["getteamAdvantageDetails"], $_GET["data"], $_GET["data1"]));
        } else {
            echo("supply distance, maxplace and comps arguments!");
        }
    } else if(isset($_GET["setathletes"])) { // (getAthletes but post ids)
        $distances = $_GET["distances"] ?? ".";// RLIKE
        $comps = $_GET["comps"] ?? "."; //RLIKE
        $gender = $_GET["gender"] ?? "."; //RLIKE
        $categories = $_GET["categories"] ?? "."; //RLIKE
        $discipline = $_GET["discipline"] ?? "."; //RLIKE
        // $orderBy = $_GET["orderBy"] ?? ".";
        $minPlace = $_GET["minPlace"] ?? "1"; // Between
        $maxPlace = $_GET["maxPlace"] ?? "1000";// Between
        $locations = $_GET["locations"] ?? ".";// RLIKE
        $fromDate = $_GET["fromDate"] ?? "1910-04-30";// Between
        $toDate = $_GET["toDate"] ?? "2100-04-30";// Between
        // $ids  = $_GET["ids"] ?? "."; // RLIKE
        $ids  = json_decode(file_get_contents('php://input'), true) ?? "."; // RLIKE
        // var_dump($ids);
        // exit();
        $limit  = $_GET["limit"] ?? "50"; // Limit
        $joinMethode  = $_GET["joinMethode"] ?? "and"; // Limit
        $countries  = $_GET["countries"] ?? "."; // Limit


        $presetName  = $_GET["presetName"] ?? NULL; // Limit
        $public  = isset($_GET["public"]) ? 1 : 0; // Limit

        if(isset($_GET["addPreset"]) && isset($_GET["presetName"])) {
            if(isLoggedIn()) {
                if(analyticsSelectPresetExists($_GET["presetName"])) {
                    if(doIOwnSelectPreset($_GET["presetName"])) {
                        updateSelectPreset($distances, $comps, $gender, $categories, $discipline, $minPlace, $maxPlace, $locations, $fromDate, $toDate, $ids, $limit, $_GET["presetName"], $joinMethode, $countries);
                    } else {
                        echo "Name taken";
                    }
                } else {
                    $owner = $_SESSION["iduser"];
                    addAnalyticsSelectPreset($distances, $comps, $gender, $categories, $discipline, $minPlace, $maxPlace, $locations, $fromDate, $toDate, $ids, $limit,$_GET["presetName"], $owner, $public, $joinMethode, $countries);
                }
            } else {
                echo "You need to be logged in to add presets";
            }
        } else {
            echo json_encode(getAthletes($distances, $comps, $gender, $categories, $discipline, $minPlace, $maxPlace, $locations, $fromDate, $toDate, $ids, $limit, $countries));
        }
    } else if(isset($_GET["getselectPresets"])) {
        echo json_encode(getSelectPresets());
    } else if(isset($_GET["getdeleteRace"])) {
        deleteRace(intval($_GET["getdeleteRace"]));
    } else if(isset($_GET["getdeleteSelectPreset"]) && isset($_GET["presetName"])) {
         $presetName = $_GET["presetName"];
         if(doIOwnSelectPreset($presetName)) {
            deleteSelectPreset($presetName);
        } else {
            echo "You cant delete preset you dont own!";
        }
    } else if(isset($_GET["getdeleteAnalytics"]) && isset($_GET["name"])) {
        $name = $_GET["name"];
        if(doIOwnAnalytics($name)) {
            if(deletAnalytics($name)) {
                echo "true";
            } else {
                echo "\"Error while deleting\"";
            }
       } else {
           echo "\"You cant delete presets you dont own!\"";
       }
    } else if(isset($_GET["getanalytics"])) {
        echo json_encode(getAnalytics());
    } else if(isset($_GET["getimgAthletes"])) {
        echo json_encode(getImgAthletes($_GET["getimgAthletes"]));
    } else if(isset($_GET["searchAthletes"])) {
        // var_dump(file_get_contents('php://input'));
        $input = json_decode(file_get_contents('php://input'), true);
        if(!isset($input["athletes"]) || !isset($input["aliasGroup"])) {
            // var_dump($input);
            echo "invalid input";
            exit(0);
        }
        $athletes = $input["athletes"];
        $aliasGruop = $input["aliasGroup"];
        // print_r($athletes);
        echo json_encode(searchAthletes($athletes, $aliasGruop));
    } else if(isset($_GET["searchAthletesFullname"])) {
        // var_dump(file_get_contents('php://input'));
        $input = json_decode(file_get_contents('php://input'), true);
        if(!isset($input["athletes"]) || !isset($input["aliasGroup"])) {
            // var_dump($input);
            echo "invalid input";
            exit(0);
        }
        $athletes = $input["athletes"];
        $aliasGruop = $input["aliasGroup"];
        // print_r($athletes);
        echo json_encode(searchAthletesFullName($athletes, $aliasGruop));
    } else if(isset($_GET["putAliases"])) {
        if(!isLoggedIn()) {
            echo "No permission";
            exit();
        }
        $aliases = json_decode(file_get_contents('php://input'), true);
        putAliases($aliases);
    } else if(isset($_GET["getathleteMedals"])) {
        echo json_encode(getAthleteMedals($_GET["getathleteMedals"]));
    } else if(isset($_GET["getcompRaces"])) {
        echo json_encode(getCompRaces($_GET["getcompRaces"]));
    } else if(isset($_GET["getcompRacesFlow"])) {
        echo json_encode(getCompRacesFlow($_GET["getcompRacesFlow"]));
    }
    else if(isset($_GET["getraceAthletes"])) {
        echo json_encode(getRaceAthletes($_GET["getraceAthletes"]));
    } else if(isset($_GET["overtakes"])) {
        $overtakes = json_decode(file_get_contents('php://input'), true);
        saveOvertakes($overtakes);
    } else if(isset($_GET["getovertakes"])) {
        echo json_encode(getOvertakes($_GET["getovertakes"]));
    } else if(isset($_GET["getovertakesByDistance"])) {
        echo json_encode(getOvertakesByDistance($_GET["getovertakesByDistance"]));
    }
    /**
     * Expecting:
     *  {
     *      aliasGroup: "Group",
     *      aliases: [001,002,003]
     *  }
     */
    else if(isset($_GET["aliasIds"])) {
        if(!canI("speaker")) {
            echo "No permission ;(";
            exit(0);
        }
        $search = json_decode(file_get_contents('php://input'), true);
        if(!isset($search["aliasGroup"])) {
            echo "Provide aliasGroup attribute!";
            exit(0);
        }
        if(!isset($search["aliases"]) || !is_array($search["aliases"])) {
            echo "Provide aliases attribute as array!";
            exit(0);
        }
        echo json_encode(getAthletesByAlias($search["aliasGroup"], $search["aliases"]));
    } else if(isset($_GET["setraceLinks"])) {
        if(!canI("managePermissions")) exit(0);
        $data = json_decode(file_get_contents('php://input'), true);
        if($data === null){
            echo "Data could not be parsed :(";
            exit(0);
        }
        setRaceLinks($data);
    } else if(isset($_GET["setanalytics"]) && isset($_GET["name"])){
        if(!isLoggedIn()) {
            echo "you need to be logged in";
            exit(0);
        }
        $name = $_GET["name"];
        $json = file_get_contents('php://input');
        $public = isset($_GET["public"]) ? 1 : 0;
        if(analyticsExistsForMe($name)) {
            updateAnalytics($name, $public, $json);
        } else if(analyticsExists($name)) {
            echo "$name does exist already and is not yours. Please choose a different name";
        } else {
            addAnalytics($name, $public, $json);
        }
    } else if(isset($_GET["setupdateCompetition"])){
        $newComp = json_decode(file_get_contents('php://input'), true);
        if(!isAllSet($newComp, ["idCompetition", "name", "startDate", "endDate", "location", "type", "country", "latitude", "longitude", "contact"])) {
            echo "Invalid request";
            exit(0);
        }
        updateComp($newComp);
    } else if(isset($_GET["getcheckCompetitionAndBelow"])) {
        checkCompetitionAndBelow($_GET["getcheckCompetitionAndBelow"]);
    }
}

function checkCompetitionAndBelow($idCompetition) {
    if(!canI("managePermissions")) return false;
    if(!dbExecute("CALL sp_checkCompetitionAndBelow(?);", "i", $idCompetition)) {
        return false;
    }
    echo "true";
    return true;
}

function validateMysqlDate( $date ) {
    return preg_match( '#^(?P<year>\d{2}|\d{4})([- /.])(?P<month>\d{1,2})\2(?P<day>\d{1,2})$#', $date, $matches )
           && checkdate($matches['month'],$matches['day'],$matches['year']);
}

function updateComp($comp) {
    if(!isLoggedIn()) {
        echo "You need to be logged in";
        return false;
    }
    $oldComp = query("SELECT * FROM TbCompetition WHERE idCompetition = ?;", "i", $comp["idCompetition"]);
    if(sizeof($oldComp) == 0) {
        echo "invalid id";
        return false;
    }
    if(!canI("managePermissions") && $oldComp[0]["creator"] != $_SESSION["iduser"]) {
        echo "You dont have permission to do that!";
        return false;
    }
    if(!validateMysqlDate($comp["startDate"])) $comp["startDate"] = NULL;
    if(!validateMysqlDate($comp["endDate"])) $comp["endDate"] = $comp["startDate"];

    if(!dbExecute("UPDATE TbCompetition SET name=?, startDate=?, endDate=?, location=?, type=?, country=?, latitude=?, longitude=?, contact=? WHERE idCompetition=?;", "sssssssssi", $comp["name"], $comp["startDate"], $comp["endDate"], $comp["location"], $comp["type"], $comp["country"], $comp["latitude"], $comp["longitude"], $comp["contact"], $comp["idCompetition"])) {
        echo "An error occoured";
        return false;
    }
    echo "succsess";
    return true;
}

function isAllSet($obj, $arr) {
    foreach ($arr as $property) {
        if(!array_key_exists($property, $obj)) {
            return false;
        }
    }
    return true;
}

function getYourCompetitions() {
    if(!isLoggedIn()) {
        return "You need to be logged in";
    }
    if(canI("managePermissions")) {
        return query("SELECT * FROM TbCompetition ORDER BY startDate DESC;");
    } else {
        return query("SELECT * FROM TbCompetition WHERE creator=? ORDER BY startDate DESC;", "i", $_SESSION["iduser"]);
    }
}

function requestFeatue($title, $description) {
    if(sizeof(query("SELECT * FROM TbDevLog WHERE title = ?;", "s", $title)) > 0) {
        // echo "This request exists already";
        return false;
    }
    return dbExecute("INSERT INTO TbDevLog(title, description, status) VALUES(?,?,'Requested');", "ss", $title, $description);
}

function putAthleteImage($imgPath, $idAthlete) {
    if(!isLoggedIn()) return false;
    if(sizeof(getAthlete($idAthlete)) == 0) return false;
    $existing = query("SELECT count(*) as count FROM TbAthleteHasImage WHERE athlete=? AND image=?;", "is", $idAthlete, $imgPath);
    if($existing[0]["count"] > 0) {
        return false;
    }
    return dbExecute("INSERT INTO TbAthleteHasImage(athlete, image, creator) VALUES (?,?,?);", "isi", $idAthlete, $imgPath, $_SESSION["iduser"]);
}

function removeAthleteImage($imgPath, $idAthlete) {
    if(!isLoggedIn()) return false;
    return dbExecute("DELETE FROM TbAthleteHasImage WHERE creator=? AND image=? AND athlete=?", "isi", $_SESSION["iduser"], $imgPath, $idAthlete);
}

function getImgAthletes($imgPath) {
    return query("SELECT TbAthleteHasImage.*, TbAthlete.firstname, TbAthlete.lastname, TbAthlete.id FROM TbAthleteHasImage JOIN TbAthlete ON TbAthlete.id = TbAthleteHasImage.athlete WHERE TbAthleteHasImage.image = ?;", "s", $imgPath);
}

function getRaceDescription($year, $event, $distance, $gender, $category) {
    $dbEvent = "";
    if($event == "World games") $dbEvent = "World Games"; // db name
    if($event == "World Championship") $dbEvent = "WM"; // db name
    if($event == "European Championship") $dbEvent = "EM"; // db name
    if($event == "Youth Olympic Games") $dbEvent = "Youth Olympic Games"; // db name
    $dbDistance = "%$distance%";
    if($gender == "Men") {
        $dbGender = "m";
    } else {
        $dbGender = "w";
    }
    $races = query("SELECT * FROM TbRace as race JOIN TbCompetition as comp ON comp.idCompetition=race.idCompetition
    WHERE year(comp.startDate)=? AND
    comp.type LIKE ? AND
    race.distance LIKE ? AND
    race.gender LIKE ? AND
    race.category LIKE ?;", "sssss", $year, $dbEvent, $dbDistance, $dbGender, $category);
    if(sizeof($races) > 0) {
        $race = $races[0];
        $results = getRaceResults($race["id"]);
        // echo "<pre>";
        echo "The Inline Speedskating $event of $year were held in ".$race["location"].", ".$race["country"].".\nLocation: http://www.google.com/maps/place/".$race["latitude"].",".$race["longitude"]."\nResults for $distance $category $gender:\n";
        echo "\n---------------------------------------------------------------------------------------------------------------------------\n";
        $maxResults = 10;
        $i = 0;
        foreach ($results as $res) {
            if($i >= $maxResults) break;
            $fullname = $res["firstname"]." ".$res["lastname"];
            if(strlen($fullname) < 10) {
                $tabs = "\t\t\t\t";
            } else if(strlen($fullname) < 17) {
                $tabs = "\t\t\t";
            }
            else if(strlen($fullname) < 24) {
                $tabs = "\t\t";
            }
            else if(strlen($fullname) < 31) {
                $tabs = "\t";
            }
            if($res["place"] < 10) {
                $res["place"] = "0".$res["place"];
            }
            if($i != 0) {
                echo "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - \n";
            }
            $time = "";
            if($res["time"] != NULL) {
                $dateTime = DateTime::createFromFormat('H:i:s.v', $res["time"]);
                if($dateTime->format("H") > 0) {
                    $time = "   |   ".$dateTime->format("H.i.s.v");
                } else if ($dateTime->format("i") > 0){
                    $time = "   |   ".$dateTime->format("i.s.v");
                } else {
                    $time = "   |   ".$dateTime->format("s.v");
                }
            }
            echo "#".$res["place"].": $fullname, ".$res["country"]."$time\n";
            // echo "#".$res["place"].": $fullname, ".$res["country"]."   |   Time: ".$res["time"]."\n";
            echo "       + Athlete: https://www.roller-results.com/athlete?id=".$res["idAthlete"]."\n";
            // echo "-------------------------------------------\n";
            $i++;
        }
        echo "---------------------------------------------------------------------------------------------------------------------------\n\n";
        if(sizeof($results) > $maxResults) {
            echo "All ".sizeof($results)." results can be found at: https://www.roller-results.com/race/index.php?id=".$race["id"];
        } else {
            echo "Full results at: https://www.roller-results.com/race/index.php?id=".$race["id"];
        }
        // echo "</pre>";
    } else {
        echo "Results can be found at www.roller-results.com";
    }
}

function getAllDevLogs() {
    return query("SELECT * FROM results.TbDevLog ORDER BY rowCreated DESC;");
}

function getAthleteImages($idAthlete) {
    return query("SELECT athlete, image, creator, rowCreated FROM TbAthleteHasImage WHERE athlete = ?;", "i", $idAthlete);
}

function spacesAfterText($text, $maxSize) {
    $tabs = "";
    $len = strlen($text);
    // $len = floor($len / $spacesPerTab) * $spacesPerTab;
    while($len < $maxSize) {
        $tabs .= " ";
        $len++;
    }
    return $text.$tabs;
}

/**
 * required properties:
 *  idAthlete
 *  idRace
 *  place
 * optional properties:
 *  tacticalNote
 *  time
 */
function createResults($results) {
    if(!isLoggedIn()) {
        echo "No permission";
        exit();
    }
    $types = "";
    $sql = "INSERT INTO TbResult(idPerson, idRace, place, tacticalNote, timeDate, creator, checked, points, disqualificationTechnical, disqualificationSportsFault, didNotStart, falseStart) VALUES ";

    $checked = canI("managePermissions");
    $delimiter = "";
    $fillers = [];
    foreach ($results as $result) {
        $sql .= "$delimiter(?,?,?,?,?,?,?,?,?,?,?,?)";
        $types .= "iiissiiiiiii";
        $delimiter = ",";
        $fillers []= $result["idAthlete"];
        $fillers []= $result["idRace"];
        $fillers []= $result["place"];
        $tacticalNote = NULL;
        $time = NULL;
        $points = 0;
        $disqualificationTechnical = 0;
        $disqualificationSportsFault = 0;
        $didNotStart = 0;
        $falseStart = 0;
        if(isset($result["tacticalNote"])) {
            $tacticalNote = $result["tacticalNote"];
        }
        if(isset($result["time"])) {
            $time = $result["time"];
        }
        if(isset($result["points"])) {
            $points = $result["points"];
        }
        if(isset($result["disqualificationTechnical"])) {
            $disqualificationTechnical = $result["disqualificationTechnical"];
        }
        if(isset($result["disqualificationSportsFault"])) {
            $disqualificationSportsFault = $result["disqualificationSportsFault"];
        }
        if(isset($result["didNotStart"])) {
            $didNotStart = $result["didNotStart"];
        }
        if(isset($result["falseStart"])) {
            $falseStart = $result["falseStart"];
        }
        $fillers []= $tacticalNote;
        $fillers []= $time;
        $fillers []= $_SESSION["iduser"];
        $fillers []= $checked;
        $fillers []= $points;
        $fillers []= $disqualificationTechnical;
        $fillers []= $disqualificationSportsFault;
        $fillers []= $didNotStart;
        $fillers []= $falseStart;
    }
    $sql .= ";";
    if(dbInsert($sql, $types, ...$fillers) == false) {
        echo "false";
    } else {
        echo "true";
    }
}

function createRace($distance, $isRelay, $gender, $category, $trackRoad, $idCompetition, $round) {
    if(!isLoggedIn()) {
        echo "No permission";
        exit();
    }
    $checked = canI("managePermissions");
    $creator = $_SESSION["iduser"];
    return dbInsert("INSERT INTO TbRace(distance, relay, gender, category, trackStreet, idCompetition, creator, checked, `round`) VALUES (?,?,?,?,?,?,?,?,?)", "sisssiiis", $distance, $isRelay, $gender, $category, $trackRoad, $idCompetition, $creator, $checked, $round);
}

/**
 * @param table: tableName
 * @param colNames: array of column names
 * @param insertTypes: string of insert types ("iiisii")
 * @param rows: php array of rows (key inside row must be present in colNames)
 */
function arrayInsert($tableName, $colNames, $insertTypes, $rows) {
    $sql = "INSERT INTO $tableName(";
    $delim = "";
    $types = "";
    $vals = [];
    foreach ($colNames as $col) {
        $sql .= $delim."`".$col."`";
        $delim = ",";
    }
    $sql.=")VALUES";
    $delim = "";
    $questions = "";
    foreach ($colNames as $something) {
        $questions .= $delim."?";
        $delim = ",";
    }
    $delim = "";
    foreach ($rows as $row) {
        $sql.="$delim($questions)";
        $types .= $insertTypes;
        $delim = ",";
        foreach ($colNames as $colName) {
            $vals[] = $row[$colName];
        }
    }
    $sql.=";";
    dbInsert($sql, $types, ...$vals);
}

function getOvertakesByDistance($distance) {
    return query("SELECT * FROM TbPass JOIN TbRace ON TbRace.id = TbPass.race JOIN TbCompetition ON TbCompetition.idCompetition = TbRace.idCompetition WHERE distance=? ORDER BY race, lap ASC;", "s", $distance);
}

function getOvertakes($idrace) {
    return query("SELECT * FROM TbPass WHERE race=? ORDER BY lap ASC, toPlace ASC;", "i", $idrace);
}

function getAthleteVideos($idAthlete) {
    return query("CALL sp_getAthleteVideos(?);", "i", $idAthlete);
}

function saveOvertakes($overtakes) {
    if(!canI("speaker")) {
        return;
    }
    if(!is_array($overtakes)) {
        echo "Error: overtakes need to be an array";
        return;
    }
    if(sizeof($overtakes) == 0) {
        echo "Error: overtakes need to be filled";
        return;
    }
    $idrace = $overtakes[0]["race"];
    foreach ($overtakes as &$o) {
        if(!isset($o["athlete"]) || !isset($o["race"]) || !isset($o["fromPlace"]) || !isset($o["toPlace"]) || !isset($o["lap"]) || !isset($o["insideOut"]) || !isset($o["finishPlace"])) {
            echo "Error";
            return;
        }
        if($idrace != $o["race"]) {
            echo "Error: invalid idRace";
            return;
        }
       $o["creator"] = $_SESSION["iduser"];
    }
    dbExecute("DELETE FROM TbPass WHERE race=?;", "i", $idrace);
    arrayInsert("TbPass", ["athlete", "race", "fromPlace", "toPlace", "lap", "insideOut", "creator", "finishPlace"], "iiiidsii", $overtakes);
}

function getRaceAthletes($idRace) {
    return query("SELECT * FROM vAthlete JOIN TbResult as res ON res.idPerson = vAthlete.idAthlete WHERE res.idRace = ?;", "i", $idRace);
}

function getCompRaces($idComp) {
    return query("SELECT * FROM TbRace WHERE idCompetition = ? ORDER BY distance, category, gender;", "i", $idComp);
}

function getCompRacesFlow($idComp) {
    return query("SELECT TbRace.*, count(pass.idPass) > 0 as `raceFlow` FROM TbRace LEFT JOIN TbPass as pass ON pass.race = TbRace.id WHERE idCompetition = ? GROUP BY TbRace.id ORDER BY distance, category, gender;", "i", $idComp);
}

function insertTrigger($triggers, $user) {
    $lastTime = 0;
    foreach (explode(",", $triggers) as $trigger) {
        if($lastTime != 0) {
            $time = intval($trigger) - $lastTime;
            dbInsert("INSERT INTO `results`.`TbTrigger` (`user`,`time`)VALUES(?,?);", "ii", $user, $time);
        }
        $lastTime = intval($trigger);
    }
}

function insertLaserResult($result, $user, $lasername) {
    $id = dbInsert("INSERT INTO TbLaserResults(distance,user,laserName,athlete)VALUES(?,?,?,?);", "iiss", $result["d"], $user, $lasername, $result["a"]);
    foreach ($result["l"] as $lap) {
        dbInsert("INSERT INTO TbLaserLap(triggerer,millis,laserResult)VALUES(?,?,?);", "iii", $lap["t"], $lap["ms"], $id);
    }
}

function getAliasAthletes($aliasGroup) {
    return query("SELECT TbAthlete.* FROM TbAthlete JOIN TbAthleteAlias ON TbAthleteAlias.idAthlete = TbAthlete.id WHERE TbAthleteAlias.aliasGroup=?;", "s", $aliasGroup);
}

function getAliasGroups() {
    if(!isLoggedIn()) {
        return [];
    }
    $res = query("SELECT aliasGroup, count(*) as `count` FROM TbAthleteAlias WHERE creator=? GROUP BY aliasGroup;", "i", $_SESSION["iduser"]);
    return $res;
}

function getAthleteMedals($idAthlete) {
    return query(" SELECT *
        FROM
            (((`vResult` `res`
            JOIN `TbRace` `race` ON ((`race`.`id` = `res`.`idRace`)))
            JOIN `TbAthlete` `athlete` ON ((`athlete`.`id` = `res`.`idPerson`)))
            JOIN `TbCompetition` `comp` ON ((`comp`.`idCompetition` = `race`.`idCompetition`)))
            WHERE athlete.id = ? AND res.place <= 3 ORDER BY startDate DESC;", "i", $idAthlete);
}

function getAthletesByAlias($aliasGroup, $aliases) {
    $idString = "";
    $delim = "";
    for ($i=0; $i < sizeof($aliases); $i++) {
        if(is_array($aliases[$i])) {
            $idString .= "$delim".$aliases[$i]["alias"];
        } else {
            $idString .= "$delim".$aliases[$i];
        }
        $delim = ",";
    }
    $athletes = query("SELECT *
        FROM TbAthleteAlias as alias LEFT JOIN vAthletePublic as athlete ON alias.idAthlete = athlete.idAthlete
        WHERE alias.aliasGroup = ? AND FIND_IN_SET(alias.alias,?);", "ss", $aliasGroup, $idString);
    return $athletes;
}

function getAliasGroup($aliasGroup) {
    return query("SELECT * FROM TbAthleteAlias WHERE aliasGroup = ?", "s", $aliasGroup);
}

function putAliases($aliases) {
    if(!isset($aliases["aliasGroup"]) || !isset($aliases["aliases"])) {
        echo "invalid parameters! please provide aliasGroup, aliases";
        return;
    }
    $creator = $_SESSION["iduser"];
    $checked = canI("managePermissions");
    // create new athletes
    foreach ($aliases["aliases"] as &$alias) {
        // var_dump($alias["createNew"]);
        if(!$alias["createNew"]) continue;
        // echo "creating new athlete";
        $newAthlete = $alias["newAthlete"];
        $club = NULL;
        $team = NULL;
        if(!isset($newAthlete["firstName"]) || !isset($newAthlete["lastName"]) || !isset($newAthlete["gender"]) || !isset($newAthlete["country"])) {
            continue;
        }
        if(isset($newAthlete["club"])) $club = $newAthlete["club"];
        if(isset($newAthlete["team"])) $team = $newAthlete["team"];
        $alias["newId"] = dbInsert("INSERT INTO TbAthlete(firstName, lastName, country, gender, club, team, checked, creator) VALUES (?,?,?,?,?,?,?,?)", "ssssssii", $newAthlete["firstName"], $newAthlete["lastName"], $newAthlete["country"], $newAthlete["gender"], $club, $team, $checked, $creator);
        // echo " id: ".$alias["newId"];
    }
    $sql = "INSERT INTO TbAthleteAlias(idAthlete, alias, creator, aliasGroup, previous) VALUES ";
    $delimiter = "";
    $fillers = [];
    $types = "";
    foreach($aliases["aliases"] as &$alias) {
        // remove old alias
        if(!isset($alias["alias"])) {
            $alias["alias"] = 0;
        }
        dbExecute("DELETE FROM TbAthleteAlias WHERE alias=? AND aliasGroup=?;", "ss", $alias["alias"], $aliases["aliasGroup"]);
        if($alias["createNew"] === true) {
            $fillers[] = $alias["newId"];
        } else if(isset($alias["idAthlete"])) {
            $fillers[] = $alias["idAthlete"];
        } else {
            $fillers[] = NULL;
        }
        $fillers[] = $alias["alias"];
        $fillers[] = $creator;
        $fillers[] = $aliases["aliasGroup"];
        $fillers[] = $alias["previous"];
        $sql .= "$delimiter(?,?,?,?,?)";
        $types .= "isiss";
        $delimiter = ",";
    }
    $sql .= ";";
    dbExecute($sql, $types, ...$fillers);
    echo "Done";
}

function searchAthletesFullName($athletes, $aliasGroup) {
    if($athletes == NULL) return [];
    // print_r($athletes);
    $existingAliases = query("SELECT * FROM TbAthleteAlias WHERE aliasGroup=?;", "s", $aliasGroup);
    $res = [];
    foreach ($athletes as $athlete) {
        $foundAlias = false;
        foreach ($existingAliases as $alias) {
            if($alias["alias"] === $athlete["alias"]) {
                $athleteQuery = query("SELECT * FROM TbAthlete WHERE id=?;", "i", $alias["idAthlete"]);
                if(sizeof($athleteQuery) > 0) {
                    $res[] = [
                        "search" => $athlete,
                        "result" => [
                            [
                                "firstname" => $athleteQuery[0]["firstname"],
                                "lastname" => $athleteQuery[0]["lastname"],
                                "country" => $athleteQuery[0]["country"],
                                "gender" => $athleteQuery[0]["gender"],
                                "id" => $athleteQuery[0]["id"],
                                "image" => $athleteQuery[0]["image"],
                                "priority" => 50
                            ]
                        ]
                    ];
                    $foundAlias = true;
                    break;
                }
            }
        }
        if($foundAlias) continue;
        $fullName = "";
        $gender = "%";
        $country = "%";
        $alias = "";
        if(isset($athlete["nation"])) {
            $athlete["country"] = $athlete["nation"]; // alias nation for country
        }
        if(isset($athlete["fullName"])) {
            $fullName = $athlete["fullName"];
        }
        if(isset($athlete["country"]) ) {
            $country = $athlete["country"];
        }
        if(isset($athlete["alias"]) ) {
            $alias = $athlete["alias"];
        }
        if(isset($athlete["gender"])) {
            if(strtolower($athlete["gender"]) === "m") {
                $gender = "m";
            } else {
                $gender = "w";
            }
        }
        $result = [];
        $result["search"] = $athlete;
        // echo $gender;
        $result["result"] = query("CALL sp_searchAthleteFullName(?,?,?,?,?);", "sssss", $fullName, $gender, $country, $alias, $aliasGroup);
        $res[] = $result;
    }
    return $res;
}

function searchAthletes($athletes, $aliasGroup) {
    if($athletes == NULL) return [];
    // print_r($athletes);
    $existingAliases = query("SELECT * FROM TbAthleteAlias WHERE aliasGroup=?;", "s", $aliasGroup);
    $res = [];
    foreach ($athletes as $athlete) {
        $foundAlias = false;
        foreach ($existingAliases as $alias) {
            if($alias["alias"] === $athlete["alias"]) {
                $athleteQuery = query("SELECT * FROM TbAthlete WHERE id=?;", "i", $alias["idAthlete"]);
                if(sizeof($athleteQuery) > 0) {
                    $res[] = [
                        "search" => $athlete,
                        "result" => [
                            [
                                "firstname" => $athleteQuery[0]["firstname"],
                                "lastname" => $athleteQuery[0]["lastname"],
                                "country" => $athleteQuery[0]["country"],
                                "gender" => $athleteQuery[0]["gender"],
                                "id" => $athleteQuery[0]["id"],
                                "image" => $athleteQuery[0]["image"],
                                "priority" => 50
                            ]
                        ]
                    ];
                    $foundAlias = true;
                    break;
                }
            }
        }
        if($foundAlias) continue;
        $firstName = "";
        $lastName = "";
        $gender = "%";
        $country = "%";
        $alias = "";
        if(isset($athlete["nation"])) {
            $athlete["country"] = $athlete["nation"]; // alias nation for country
        }
        if(isset($athlete["firstName"])) {
            $firstName = $athlete["firstName"];
        }
        if(isset($athlete["lastName"])) {
            $lastName = $athlete["lastName"];
        }
        if(isset($athlete["country"]) ) {
            $country = $athlete["country"];
        }
        if(isset($athlete["alias"]) ) {
            $alias = $athlete["alias"];
        }
        if(isset($athlete["gender"])) {
            $gender = strtolower($athlete["gender"]);
            if($gender === "M" || $gender === "M" ) {
                $gender = "M";
            } else {
                $gender = "W";
            }
        }
        $result = [];
        $result["search"] = $athlete;
        // echo $lastName;
        $result["result"] = query("CALL sp_searchAthlete(?,?,?,?,?,?);", "ssssss", $firstName, $lastName, $gender, $country, $alias, $aliasGroup);
        $res[] = $result;
    }
    return $res;
}

function getAnalytics() {
    if(isLoggedIn()) {
        return query("SELECT Tb_analyticsPreset.*, TbUser.username FROM Tb_analyticsPreset JOIN TbUser on TbUser.iduser=`owner` WHERE `owner`=? OR public=1;", "i", $_SESSION["iduser"]);
    } else {
        return query("SELECT Tb_analyticsPreset.*, TbUser.username FROM Tb_analyticsPreset JOIN TbUser on TbUser.iduser=`owner` WHERE public = 1;");
    }
}

function updateAnalytics($name, $public, $json) {
    if(!isLoggedIn()) return false;
    // $existing = query("SELECT owner FROM Tb_analyticsPreset WHERE name=? AND owner = ");
    return dbExecute("UPDATE Tb_analyticsPreset SET `public`=?, `json`=? WHERE `name`=? AND `owner`=?;", "issi", $public, $json, $name, $_SESSION["iduser"]);
}

function addAnalytics($name, $public, $json) {
    if(!isLoggedIn()) return false;
    dbInsert("INSERT INTO Tb_analyticsPreset(`name`,`public`,`json`,`owner`) VALUES (?,?,?,?);", "sisi", $name, $public, $json, $_SESSION["iduser"]);
}

function analyticsExists($name) {
    return sizeof(query("SELECT idAnalyticsPreset FROM Tb_analyticsPreset WHERE `name`=? AND public = 1;", "s", $name)) > 0;
}

function analyticsExistsForMe($name) {
    if(!isLoggedIn()) return false;
    return sizeof(query("SELECT idAnalyticsPreset FROM Tb_analyticsPreset WHERE `name`=? AND owner = ?;", "si", $name, $_SESSION["iduser"])) > 0;
}

function deleteSelectPreset($presetName) {
    if(!isLoggedIn()) {
        return;
    }
    query("DELETE FROM Tb_analyticsSelectPreset WHERE owner = ? AND name = ?;", "is", $_SESSION["iduser"], $presetName);
}

function deletAnalytics($name) {
    if(!isLoggedIn()) return false;
    return dbExecute("DELETE FROM Tb_analyticsPreset WHERE owner = ? AND name = ?;", "is", $_SESSION["iduser"], $name);
}

function doIOwnAnalytics($name) {
    if(!isLoggedIn()) {
        return false;
    }
    return sizeof(query("SELECT idAnalyticsPreset FROM Tb_analyticsPreset WHERE owner = ? AND name = ?;", "is", $_SESSION["iduser"], $name)) > 0;
}

function doIOwnSelectPreset($presetName) {
    if(!isLoggedIn()) {
        return false;
    }
    return sizeof(query("SELECT idAnalyticsSelectPreset FROM Tb_analyticsSelectPreset WHERE owner = ? AND name = ?;", "is", $_SESSION["iduser"], $presetName)) > 0;
}

function getSelectPresets() {
    if(isLoggedIn()) {
        return query("SELECT * FROM Tb_analyticsSelectPreset WHERE public = 1 OR owner = ?;", "i", $_SESSION["iduser"]);
    } else {
        return query("SELECT * FROM Tb_analyticsSelectPreset WHERE public = 1;");
    }
}

function analyticsSelectPresetExists($name) {
    $res = query("SELECT idAnalyticsSelectPreset FROM Tb_analyticsSelectPreset WHERE name = ?;", "s", $name);
    return sizeof($res) > 0;
}

function updateSelectPreset($distances, $comps, $gender, $categories, $discipline, $minPlace, $maxPlace, $locations, $fromDate, $toDate, $ids, $limit, $name, $joinMethode, $countries) {
    query("UPDATE `results`.`Tb_analyticsSelectPreset`
    SET
    `distances` = ?,
    `comps` = ?,
    `gender` = ?,
    `categories` = ?,
    `disciplines` = ?,
    `minPlace` = ?,
    `maxPlace` = ?,
    `locations` = ?,
    `fromDate` = ?,
    `toDate` = ?,
    `limit` = ?,
    `joinMethode` = ?,
    `countries` = ?
    WHERE `name` = ?;", "sssssiisssisss", $distances, $comps, $gender, $categories, $discipline, $minPlace, $maxPlace, $locations, $fromDate, $toDate, $limit, $joinMethode, $name, $countries);
}

function addAnalyticsSelectPreset($distances, $comps, $gender, $categories, $discipline, $minPlace, $maxPlace, $locations, $fromDate, $toDate, $ids, $limit, $presetName, $owner, $public, $joinMethode, $countries) {
    query("INSERT INTO `results`.`Tb_analyticsSelectPreset`(`distances`,`comps`,`gender`,`categories`,`disciplines`,`minPlace`,`maxPlace`,`locations`,`fromDate`,`toDate`,`limit`,`name`, `ids`,`owner`,`public`,`joinMethode`,`countries`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);", "sssssiisssissiiss", $distances, $comps, $gender, $categories, $discipline, $minPlace, $maxPlace, $locations, $fromDate, $toDate, $limit, $presetName, $ids, $owner, $public, $joinMethode, $countries);
}

function getAthletes($distances, $comps, $gender, $categories, $discipline, $minPlace, $maxPlace, $locations, $fromDate, $toDate, $ids, $limit, $countries) {
    $res = query("call results.sp_getAthletes(?,?,?,?,?,?,?,?,?,?,?,?,?);", "sssssiissssis", $distances, $comps, $gender, $categories, $discipline, $minPlace, $maxPlace, $locations, $fromDate,$toDate, $ids, $limit, $countries);
    return $res;
}

function getTeamAdvantage($distance, $maxPlace, $comps) {
    $res = query("CALL sp_teamAdvantage(?, ?, ?);", "sis", $distance, $maxPlace, $comps);
    if(sizeof($res) > 0) {
        return $res[0];
    }
    return [];
}

function getTeamAdvantageDetails($distance, $maxPlace, $comps) {
    $res = query("CALL sp_teamAdvantageDetails(?, ?, ?);", "sis", $distance, $maxPlace, $comps);
    return $res;
}

function get500mData() {
    $res = query("SELECT * FROM `Tb_500m`;");
    return $res;
}

function getWorldMovement() {
    $res = query("SELECT * FROM vWorldMovement;");
    if(sizeof($res) > 0){
        return $res;
    } else{
        return [];
    }
}

function getCompAthleteMedals($idComp) {
    // $res = query("SELECT * FROM vCompAthleteMedals WHERE idCompetition = ?;", "i", $idComp);
    $res = query("CALL sp_getCompAthleteMedals(?)", "i", $idComp);
    if(sizeof($res) > 0){
        return $res;
    } else{
        return [];
    }
}

function getCompCountryMedals($idComp) {
    // $res = query("SELECT * FROM vCompCountryMedals WHERE idCompetition = ?;", "i", $idComp);
    $res = query("CALL sp_getCompCountryMedals(?)", "i", $idComp);
    if(sizeof($res) > 0){
        return $res;
    } else{
        return [];
    }
}

function getCountryScores(){
    global $usedMedals;
    global $scoreInfluences;
    $countries = getCountries();
    $out = [];
    $i = 0;
    foreach($countries as &$country){
        $country["scores"] = [];
        if($country["medalScore"] > 10) {
            $scores = query("CALL sp_countryCareerNew(?, ?);", "ss", $country["country"], $usedMedals);;
            $country["scores"] = $scores;
            $out[] = $country;
            $i++;
            if($i >= 10) {
                break;
            }
        }
    }
    return $out;
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
                    // var_dump($newRace["link"]);
                    $newLinks = explode(";", $newRace["link"]);
                    // $newLinks = $newRace["link"];
                }
                if($newLinks === false){
                    continue;
                }
                if(sizeof($newLinks) === 0){
                    continue;
                }

                // var_dump($newLinks);

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
    // var_dump($new);
    foreach ($new as $idRace => $link) {
        dbExecute("UPDATE TbRace SET link = ? WHERE id = ?;", "si", $link, $idRace);
    }
    // $delimiter = "";
    // $sql = "UPDATE TbRace SET link";
}

function getAllRaceFlowDistances(){
    $res = query("SELECT distance from TbRace JOIN TbPass ON TbPass.race = TbRace.id GROUP BY distance;");
    $out = [];
    foreach ($res as $row) {
        $out[] = $row["distance"];
    }
    return $out;
}

function getAllDistances(){
    $res = query("SELECT distance from TbRace GROUP BY distance;");
    $out = [];
    foreach ($res as $row) {
        $out[] = $row["distance"];
    }
    return $out;
}

function getAllTimes() {
    return query("SELECT * FROM TbTrigger;");
}

function addCompetition($name, $city, $country, $latitude, $longitude, $type, $startDate, $endDate, $description) {
    if(!isLoggedIn()) {
    // if(!canI("uploadResults")) {
        echo "You dont have permission to do that";
        exit(0);
    }
    if(strlen($latitude) == 0) $latitude = NULL;
    if(strlen($longitude) == 0) $longitude = NULL;
    if(!validateMysqlDate($startDate)) $startDate = NULL;
    if(!validateMysqlDate($endDate)) $endDate = $startDate;
    $creator = $_SESSION["iduser"];
    $checked = canI("managePermissions");
    $year = explode("-", $startDate)[0];
    return dbExecute("INSERT INTO TbCompetition(`name`, `location`, `country`, `latitude`, `longitude`, `type`, `startDate`, `endDate`, `description`, `creator`, `checked`, `raceYear`, `raceYearNum`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);", "sssssssssiiii", $name, $city, $country, $latitude, $longitude, $type, $startDate, $endDate, $description, $creator, $checked, $year, $year);
}

function getUsersAnalytics() {
    if(!isLoggedIn()) return [];
    return query("SELECT * FROM Tb_analyticsPreset WHERE `owner` = ?;", "i", $_SESSION["iduser"]);
}

function getUsersCompetitions() {
    if(!isLoggedIn()) return;
    return query("SELECT * FROM TbCompetition WHERE creator = ?;", "i", $_SESSION["iduser"]);
}

function getAllCompetitions(){
    $res = query("call results.sp_getCompetitionsNew();");
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

// function getAllAthletes() {
//     global $scoreInfluences;
//     global $usedMedals;
//     $res = query("CALL sp_athleteFull('%', ?´, ?);", "ss", $scoreInfluences, $usedMedals);
//     // $res = query("SELECT * FROM vAthletePublic;");
//     if(sizeof($res) > 0){
//         return $res;
//     } else{
//         return [];
//     }
// }

function getCountryCareer($country){
    global $usedMedals;
    // $res = query("CALL sp_countryCareer(?, ?);", "ss", $country, $scoreInfluences);
    $res = query("CALL sp_countryCareerNew(?, ?);", "ss", $country, $usedMedals);
    if(sizeof($res) > 0){
        return $res;
    } else{
        return [];
    }
}

function getAthleteCareer($idAthlete){
    global $usedMedals;
    $res = query("CALL sp_athleteCareer(?, ?);", "is", $idAthlete, $usedMedals);
    if(sizeof($res) > 0) {
        return $res;
    } else {
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

function getCountryAthletes($country, $limit) {
    global $scoreInfluences;
    global $usedMedals;
    $res = query("CALL results.sp_getCountryAthletesNew(?, ?);", "ss", $country, $usedMedals);
    // $res = query("CALL results.sp_getCountryAthletes(?, ?, ?, ?);", "sssi", $country, $scoreInfluences, $usedMedals, $limit);
    if(sizeof($res) > 0){
        return $res;
    } else{
        return [];
    }
}

function getAthleteAmount(){
    $res = query("SELECT count(*) as amount FROM TbAthlete;");
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
    $res = query("SELECT count(*) as amount FROM TbResult;");
    if(sizeof($res) > 0){
        return $res[0]["amount"];
    } else{
        return [];
    }
}

function getRaceAmount(){
    $res = query("SELECT count(*) as amount FROM TbRace;");
    if(sizeof($res) > 0){
        return $res[0]["amount"];
    } else{
        return [];
    }
}

function getCompetitionAmount(){
    $res = query("SELECT count(*) as amount FROM TbCompetition;");
    if(sizeof($res) > 0){
        return $res[0]["amount"];
    } else{
        return [];
    }
}

function getVideoAmount(){
    $res = query("SELECT count(*) as amount FROM vRace WHERE link IS NOT NULL;");
    if(sizeof($res) > 0){
        return $res[0]["amount"];
    } else{
        return [];
    }
}

function getCountryCompetitions($country){
    $competitions = query("CALL sp_getCountryCompetitions(?);", "s", $country);
    if(sizeof($competitions) > 0) {
        // foreach ($competitions as $key => &$competition) {
            // $competition["races"] = [];
            // $competition["races"] = getCountryRacesFromCompetition($country, $competition["idCompetition"]);
        // }
        return $competitions;
    } else{
        return [];
    }
}

function getCountryRacesFromCompetition($country, $idcompetition){
    $races = query("CALL sp_getCountryRacesFromCompetition(?, ?);", "si", $country, intval($idcompetition));
    if(sizeof($races) > 0) {
        return $races;
    } else {
        return [];
    }
}

function getBestSkaters(){
    global $usedMedals;
    $limit = 100;
    // $skaters = query("CALL sp_hallOfFame(?);", "s", $scoreInfluences);
    $skaters = query("CALL sp_getAthletesNew(?,?);", "si", $usedMedals, $limit);
    for ($i=0; $i < sizeof($skaters); $i++) { 
        $skaters[$i]["rank"] = $i + 1;
    }
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

function deleteCompetition($idCompetition) {
    if(!isLoggedIn()) {
        echo "\"You need to be logged in to delete a competition\"";
        return false;
    }
    $comp = getCompetition($idCompetition);
    if(sizeof($comp) == 0) {
        echo "\"Invalid competition\"";
        return false;
    }
    if(!canI("managePermissions") && ($comp["creator"] != $_SESSION["iduser"])) {
        echo "\"You can't delete a competition you dont own!\"";
        return false;
    }
    $succsess = dbExecute("CALL sp_deleteCompetition(?);", "i", $idCompetition);
    if(!$succsess) {
        echo "\"An error occoured :/\"";
    } else {
        echo "true";
    }
    return $succsess;
}

function deleteRace($id) {
    if(!isLoggedIn()) {
        echo "You need to be logged in";
        return false;
    }
    $iduser = $_SESSION["iduser"];
    $race = getRace($id);
    $admin = canI("managePermissions");
    if(!$admin && ($race["creator"] != $iduser)) {
        echo "you dont have the permission to do that!";
        return false;
    }
    dbExecute("CALL sp_deleteRace(?)", "i", $id);
    echo "true";
    return true;
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

function updateAthleteInfo($idAthlete, $instagram, $facebook, $website, $description, $team, $club, $img, $country) {
    if($img == NULL) {
        return dbExecute("UPDATE TbAthlete SET instagram=?, facebook=?, website=?, `description`=?, team=?, club=?, country=? WHERE id=?;", "sssssssi", $instagram, $facebook, $website, $description, $team, $club, $country, $idAthlete);
    } else {
        return dbExecute("UPDATE TbAthlete SET instagram=?, facebook=?, website=?, `description`=?, team=?, club=?, `image`=?, country=? WHERE id=?;", "ssssssssi", $instagram, $facebook, $website, $description, $team, $club, $img, $country, $idAthlete);
    }
}

function getAthleteWithScore($id) {
    global $scoreInfluences;
    global $usedMedals;
    $result = query("CALL sp_athleteFull(?, ?, ?)", "iss", intval($id), $scoreInfluences, $usedMedals);
    if(sizeof($result) > 0) {
        return $result[0];
    } else {
        return [];
    }
}

function getAthlete($id) {
    global $scoreInfluences;
    global $usedMedals;
    // $result = query("CALL sp_athleteFull(?, ?, ?)", "iss", intval($id), $scoreInfluences, $usedMedals);
    $result = query("CALL sp_getAthleteNew(?, ?)", "is", intval($id), $usedMedals);
    // print_r($result);
    // echo $usedMedals;
    if(sizeof($result) > 0) {
        return $result[0];
    } else {
        return [];
    }
}

function getAthleteFull($id){
    global $scoreInfluences;
    global $usedMedals;
    $result = query("CALL sp_athletePrivateFull(?, ?, ?)", "iss", intval($id), $scoreInfluences, $usedMedals);
    if(sizeof($result) > 0) {
        return $result[0];
    } else{
        return [];
    }
}

function getCompetition($id) {
    // $result = query("SELECT * FROM vCompetition WHERE idCompetition = ?;", "i", intval($id));
    $result = query("CALL sp_getCompNew(?);", "i", intval($id));
    if(sizeof($result) > 0) {
        $result[0] ["races"] = getRacesFromCompetition($id);
        return $result[0];
    } else {
        return [];
    }
}

function translateCompType($type) {
    switch (strtolower($type)) {
        case "wm": return "Worlds";
        case "em": return "Euros";
        default: return $type;
    }
}

function getCountry($name){
    global $scoreInfluences;
    global $usedMedals;
    $countries = getCountries();
    if(sizeof($countries) === 0) {
        $countries = query("CALL sp_getCountryNew(?)", "s", $name);
    }
    foreach ($countries as $country) {
        if($country["country"] == $name) {
            return $country;
        }
    }
    return [];
}

function getTeam($name) {
    return query("SELECT TbTeam.*, GROUP_CONCAT(TbTeamMember.athlete) as members FROM TbTeam INNER JOIN TbTeamMember ON idTeam = team WHERE `name`=? GROUP BY idTeam;", "s", $name)[0];
}

function getCountries() {
    global $scoreInfluences;
    global $usedMedals;
    // $countries = query("SELECT * FROM vCountry ORDER BY score DESC");
    // $countries = query("CALL sp_getCountries('%', ?, ?)", "ss", $scoreInfluences, $usedMedals);
    $countries = query("CALL sp_getCountriesNew(?)", "s",  $usedMedals);
    for ($i=0; $i < sizeof($countries); $i++) {
        $countries[$i]["rank"] = $i + 1;
    }
    if(sizeof($countries) > 0){
        return $countries;
    } else{
        return [];
    }
}

function getAllCountries() {
    return query("SELECT country FROM TbAthlete GROUP BY country;");
}

function getResult($id) {
    $result = query("SELECT * FROM vResult WHERE idResult = ?;", "i", intval($id));
    if(sizeof($result) > 0){
        return $result[0];
    } else{
        return [];
    }
}

function getRace($id) {
    global $usedMedals;
    $race = query("CALL sp_getRaceNew(?);", "i", intval($id));
    if(sizeof($race) > 0) {
        $race[0]["results"] = query("CALL sp_getRaceResultsNew(?,?)", "is", intval($id), $usedMedals);
        return $race[0];
    } else{
        return [];
    }
}

function getRaces() {
    $result = query("SELECT * FROM vRace;");
    if(sizeof($result) > 0){
        return $result;
    } else{
        return [];
    }
}

function getRacesFromCompetition($id){
    // $result = query("CALL sp_getRacesFromCompetition(?);", "i", intval($id));
    $result = query("CALL sp_getRacesFromCompetitionNew(?);", "i", intval($id));
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
 * <team> searching for names of persons
 * <name> searching for names of persons
 * <type> searching for competiotions by type
 * <year> year of competition
 * <location> location of competition
 * <country> country
 * 
 * allowed: <string> Year,Team,Competition,Athlete,Country
 * 
 */
function search($name, $allowed = "Year,Team,Competition,Athlete,Country") {
    $allowed = explode(",", $allowed);
    // print_r( $allowed);
    $name = trim($name);//remove whitespaces at front and end
    $results = [];
    setMaxResultSize(100);
    /**
     * Year
     */
    $year = substr($name, 0, 4);
    $competition = null;
    if(is_numeric($year) && in_array("Year", $allowed)) {
        $competitions = query("CALL sp_searchYear(?);", "i", intval($year));
        if(sizeof($competitions) > 0){
            $competition = $competitions[0];
        }
        foreach ($competitions as $key => $competition) {
            $results[] = [
                "id" => $competition["idCompetition"],
                "name" => $competition["type"]." ".$competition["location"]." ".$competition["raceYear"],
                "priority" => (intval($year) == $competition["raceYear"]) ? 2 : 1,
                "type" => "competition",
                "link" => "/competition?id=".$competition["idCompetition"]
            ];
        }
        if(strlen($name) == 4 && sizeof($competitions)) {
            $results[] = [
                "id" => $name,
                "name" => "Show all in ".$name,
                "priority" => 10, // hight priority as there is only one anyway
                "type" => "year",
                "link" => "/year?id=".$name
            ];
        }
    } else {
        /**
         * Team
         */
        if(in_array("Team", $allowed)) {
            $teams = query("CALL sp_searchTeams(?)", "s", $name);
            foreach ($teams as $key => $teams) {
                $results[] = [
                    "id" => $teams["name"],
                    "name" => $teams["name"],
                    "priority" => 2,
                    "type" => "team",
                    "link" => "/team?id=".$teams["name"]
                ];
            }
        }
        /**
         * Competition location
         */
        if(in_array("Competition", $allowed)) {
            $competitionName = $name;
            $competitions = query("CALL sp_searchCompetitionLocation(?)", "s", $competitionName);
            foreach ($competitions as $key => $competition) {
                $results[] = [
                    "id" => $competition["idCompetition"],
                    "name" => $competition["type"]." ".$competition["location"]." ".$competition["raceYear"],
                    "priority" => 1,
                    "type" => "competition",
                    "link" => "/competition?id=".$competition["idCompetition"]
                ];
            }
            $names = explode("  ", $name);
            foreach ($names as $key => $value) {
                $competitions = query("CALL sp_searchCompetitionType(?)", "s", $value);
                foreach ($competitions as $key => $competition) {
                    $existing = false;
                    foreach ($results as $res) {
                        if($res["id"] == $competition["idCompetition"]) $existing = true;
                    }
                    if($existing) continue;
                    $results[] = [
                        "id" => $competition["idCompetition"],
                        "name" => $competition["type"]." ".$competition["location"]." ".$competition["raceYear"],
                        "priority" => 1,
                        "type" => "competition",
                        "link" => "/competition?id=".$competition["idCompetition"]
                    ];
                }
            }
        }
        /**
         * persons names
         */
        if(in_array("Athlete", $allowed)) {
            $results = array_merge($results, searchPersons($name));
            // print_r();
        }
        /**
         * competitionTypes
         */
        /**
         * countries
         */
        if(in_array("Country", $allowed)) {
            foreach ($names as $key => $value) {
                $countries = query("CALL sp_searchCountry(?)", "s", $value);
                foreach ($countries as $key => $country) {
                    $results[] = [
                        "id" => $country["country"],
                        "name" => $country["country"],
                        "priority" => 3,
                        "type" => "country",
                        "link" => "/country?id=".$country["country"]
                    ];
                }
            }
        }
    }
    usort($results, "cmpSearchResult");
    // @todo
    // $delimiter = strpos($name, ":");
    // if($delimiter != -1){
    //     $name = substr($name, $delimiter + 1);
    // }
    setMaxResultSize(-1);
    return $results;
}

function cmpSearchResult($b, $a) {
    return $a["priority"] - $b["priority"];
}

function searchPersons($name){
    $results = [];
    $names = explode("  ", $name);
    $personIds = [];
    foreach ($names as $key => $value) {
        $persons = query("CALL sp_searchPerson(?)", "s", $value);
        foreach ($persons as $key => $person) {
            if(!in_array($person["idAthlete"], $personIds)) {
                $personIds[] = $person["idAthlete"];
                $results[] = [
                    "id" => $person["idAthlete"],
                    "name" => $person["firstname"]." ".$person["lastname"]." - ".$person["country"],
                    "priority" => 1,
                    "type" => "person",
                    "link" => "/athlete?id=".$person["idAthlete"],
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