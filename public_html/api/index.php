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
    "getPascalPlaces" => 1,
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
    if(!isset($apiKey)) return false;
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
        if($res !== false) {
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getcountryNames"])) {
        $res = getAllCountries();
        if($res !== false) {
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
        if(!isset($data["user"]) || !isset($data["triggers"]) || !is_array($data["triggers"])) {
            http_response_code(400);
            exit(400);
        }
        $sessionName = uploadResults($data);
        if($sessionName === false) {
            http_response_code(400);
            exit(400);
        } else {
            echo $sessionName;
        }
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
    } else if(isset($_GET["getcompsRaces"])) {
        echo json_encode(getCompsRaces($_GET["getcompsRaces"]));
    } else if(isset($_GET["getcompRacesFlow"])) {
        echo json_encode(getCompRacesFlow($_GET["getcompRacesFlow"]));
    } else if(isset($_GET["getraceSeries"])) {
        echo json_encode(getAllRaceSeriesWithRaces());
    }
    else if(isset($_GET["getraceAthletes"])) {
        echo json_encode(getRaceAthletes($_GET["getraceAthletes"]));
    } else if(isset($_GET["overtakes"])) {
        $overtakes = json_decode(file_get_contents('php://input'), true);
        saveOvertakes($overtakes);
    } else if(isset($_GET["getovertakes"])) {
        echo json_encode(getOvertakes($_GET["getovertakes"]));
    } else if(isset($_GET["getovertakesByDistance"]) && isset($_GET["data"])) {
        echo json_encode(getOvertakesByDistance($_GET["getovertakesByDistance"], $_GET["data"]));
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
    } else if(isset($_GET["getaddRaceToSeries"])) {
        if(!isAdmin()) exit(0);
        if(addRaceToSeries($_GET["idRace"], $_GET["idRaceSeries"])) {
            echo '{}';
        } else {
            echo 'error';
        }
    } else if(isset($_GET["getremoveRaceFromSeries"])) {
        if(!isAdmin()) exit(0);
        if(removeRaceFromSeries($_GET["idRace"], $_GET["idRaceSeries"])) {
            echo '{}';
        } else {
            echo 'error';
        }
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
    } else if(isset($_GET["setcreatePerformanceCategory"])) {
        $performanceCategory = json_decode(file_get_contents('php://input'), true);
        if(validateObjectProperties($performanceCategory, [
            [
                "property" => "name",
                "type" => "string",
                "maxLength" => 50,
            ],[
                "property" => "description",
                "type" => "string",
                "required" => false,
                "maxLength" => 200,
            ],[
                "property" => "users",
                "type" => "array",
            ]
        ])) {
            if(!createPerformanceCategory($performanceCategory["name"], $performanceCategory["description"], $performanceCategory["type"], $performanceCategory["users"])) {
                echo "Error creating performance category";
            }
        }
    } else if(isset($_GET["seteditPerformanceCategory"])) {
        $performanceCategory = json_decode(file_get_contents('php://input'), true);
        if(validateObjectProperties($performanceCategory, [
            [
                "property" => "idPerformanceCategory",
                "type" => "integer"
            ],[
                "property" => "name",
                "type" => "string",
                "maxLength" => 50,
            ],[
                "property" => "description",
                "type" => "string",
                "required" => false,
                "maxLength" => 200,
            ]
            ], true)) {
            if(!editPerformanceCategory($performanceCategory["idPerformanceCategory"], $performanceCategory["name"], $performanceCategory["description"])) {
                echo "Error while editing performance category";
            }
        }
    } else if(isset($_GET["setmakePerformanceCategoryUserCreator"])) {
        $performanceCategory = json_decode(file_get_contents('php://input'), true);
        if(validateObjectProperties($performanceCategory, [
            [
                "property" => "idPerformanceCategory",
                "type" => "integer"
            ],[
                "property" => "idUser",
                "type" => "integer",
            ]
            ], true)) {
            if(!makePerformanceCategoryUserCreator($performanceCategory["idPerformanceCategory"], $performanceCategory["idUser"])) {
                echo "Error while making user creator in performance category";
            } else {
                echo "succsess";
            }
        }
    } else if(isset($_GET["setmakePerformanceCategoryUserAdmin"])) {
        $performanceCategory = json_decode(file_get_contents('php://input'), true);
        if(validateObjectProperties($performanceCategory, [
            [
                "property" => "idPerformanceCategory",
                "type" => "integer"
            ],[
                "property" => "idUser",
                "type" => "integer",
            ],[
                "property" => "makeAdmin",
                "type" => "integer",
            ]
            ], true)) {
            if(!makePerformanceCategoryUserAdmin($performanceCategory["idPerformanceCategory"], $performanceCategory["idUser"], $performanceCategory["makeAdmin"], true)) {
                echo "Error while making user admin in performance category";
            } else {
                echo "succsess";
            }
        }
    } else if(isset($_GET["setuserToPerformanceCategory"])) {
        $user = json_decode(file_get_contents('php://input'), true);
        if(validateObjectProperties($user, [
            [
                "property" => "idPerformanceCategory",
                "type" => "integer",
            ],[
                "property" => "idUser",
                "type" => "integer",
            ]
            ], true)) {
            if(!addUserToPerformanceCategory($user["idPerformanceCategory"], $user["idUser"])) {
                echo "Error while adding user to Performance category";
            } else {
                echo "succsess";
            }
        }
    } else if(isset($_GET["setremoveUserFromPerformanceCategory"])) {
        $user = json_decode(file_get_contents('php://input'), true);
        if(validateObjectProperties($user, [
            [
                "property" => "idPerformanceCategory",
                "type" => "integer",
            ],[
                "property" => "idUser",
                "type" => "integer",
            ]
            ], true)) {
            if(!removeUserFromPerformanceCategory($user["idPerformanceCategory"], $user["idUser"])) {
                echo "Error while removing user from Performance category";
            } else {
                echo "succsess";
            }
        }
    } else if(isset($_GET["setuploadPerformanceRecord"])) {
        $record = json_decode(file_get_contents('php://input'), true);
        if(validateObjectProperties($record, [
            [
                "property" => "idPerformanceCategory",
                "type" => "integer",
            ],[
                "property" => "idUser",
                "type" => "integer",
            ],[
                "property" => "value",
                "type" => "float",
            ],[
                "property" => "comment",
                "type" => "string",
                "required" => false,
            ],[
                "property" => "date",
                "type" => "string",
            ]
        ])) {
            if(!uploadPerformanceRecord($record["idPerformanceCategory"], $record["idUser"], $record["value"], $record["comment"], $record["date"])) {
                echo "Error while editing Performance record";
            }
        }
    } else if(isset($_GET["seteditPerformanceRecord"])) {
        $record = json_decode(file_get_contents('php://input'), true);
        if(validateObjectProperties($record, [
            [
                "property" => "idPerformanceRecord",
                "type" => "integer",
            ],[
                "property" => "value",
                "type" => "float",
            ]
        ])) {
            if(!editPerformanceRecord($record["idPerformanceRecord"], $record["value"])) {
                echo "Error while editing Performance record";
            }
        }
    } else if(isset($_GET["setdeletePerformanceRecord"])) {
        $record = json_decode(file_get_contents('php://input'), true);
        if(validateObjectProperties($record, [
            [
                "property" => "idPerformanceRecord",
                "type" => "integer",
            ]
        ])) {
            if(!deletePerformanceRecord($record["idPerformanceRecord"])) {
                echo "Error while deleting Performance record";
            } else {
                echo "succsess";
            }
        }
    } else if(isset($_GET["getperformanceCategoryUsers"])) {
        $users = getPerformanceCategoryUsers($_GET["getperformanceCategoryUsers"]);
        echo json_encode($users);
    } else if(isset($_GET["getperformanceRecords"])) {
        $records = getPerformanceRecords($_GET["getperformanceRecords"]);
        echo json_encode($records);
    } else if(isset($_GET["setdeletePlace"])) {
        $place = json_decode(file_get_contents('php://input'), true);
        if(deletePlace($place["id"] ?? 0)) {
            echo "succsess";
        } else {
            echo "error no permission";
        }
    } else if(isset($_GET["getclubAthletes"])) {
        echo json_encode(getAthletesByClub($_GET["getclubAthletes"]));
    } else if(isset($_GET["getPascalPlaces"])) {
        cors();
        echo json_encode(getPascalMembershipsForMap());
    } else if(isset($_GET["payhip-webhook"])) {
        cors();
        $path = dirname($_SERVER["DOCUMENT_ROOT"])."/logs";
        if (!file_exists($path)) {
            // dir doesn't exist, make it
            mkdir($path, 0700, true);
          }
        //   echo($path);
        file_put_contents($path."/payhip-log.txt", "\n------------------- ".date("Y-m-d H:i:s")." --------------------\n", FILE_APPEND);
        $get = var_export($_GET, true);
        file_put_contents($path."/payhip-log.txt", $get, FILE_APPEND);
        file_put_contents($path."/payhip-log.txt", file_get_contents('php://input'), FILE_APPEND);
        $event = json_decode(file_get_contents('php://input'), true);
        if($event['type'] === 'subscription.created') {
            createPascalSubscribtion($event);
        } else if($event['type'] === 'subscription.deleted') {
            deletePascalSubscribtion($event);
        }
    } else if(isset($_GET["updatePascalMembership"])) {
        cors();
        if(!array_key_exists("customer_id", $_GET) || !array_key_exists("lat", $_GET) || !array_key_exists("long", $_GET) || !array_key_exists("name", $_GET) || !array_key_exists("contact", $_GET) || !array_key_exists("email", $_GET) || !array_key_exists("phoneNumber", $_GET) || !array_key_exists("website", $_GET)) {
            echo "invalid args";
            http_response_code(400);
            exit;
        }
        $customerID = $_GET["customer_id"];
        $lat = $_GET["lat"];
        $long = $_GET["long"];
        $name = $_GET["name"];
        $contact = $_GET["contact"];
        $email = $_GET["email"];
        $phoneNumber = $_GET["phoneNumber"];
        $website = $_GET["website"];
        updatePascalMembershipByUser($customerID, $lat, $long, $name, $contact, $email, $phoneNumber, $website);
    } else if(isset($_GET["getPascalMembership"])) {
        cors();
        if(!array_key_exists("customer_id", $_GET)) {
            echo "invalid args";
            exit();
        }
        $customer_id = $_GET["customer_id"];
        echo json_encode(getPascalMembership($customer_id));
    }
}

function levelByPascalEvent($event): ?int {
    return 2;
}

// {"subscription_id":"N9G87jxBVe","customer_id":"PjWl2Z6EBv","status":"active","customer_email":"timolehnertz1@gmail.com","plan_name":"Subscribtion","product_name":"Trainer membership","product_link":"Ya7cE","gdpr_consent":"No","date_subscription_started":1712237697,"customer_first_name":"Timo","customer_last_name":"Lehnertz","type":"subscription.created","signature":"e6e5dd60c1354566f2dd5d7e0eaa6bc818868fd2989fad51376eadc5bbd81885"}
function createPascalSubscribtion($event) {
    $name = $event['customer_first_name'].' '.$event['customer_last_name'];
    $rows = query("SELECT * FROM TbPascalTrainers WHERE customer_id=?;", "s", $event["customer_id"]);
    $level = levelByPascalEvent($event);
    if(sizeof($rows) > 0) {
        dbExecute("UPDATE TbPascalTrainers SET `level`=? WHERE customer_id=?;", "is", $level, $event["customer_id"]);
    } else {
        dbExecute("INSERT INTO TbPascalTrainers (`name`, email, `level`, customer_id) VALUES(?,?,?,?);","ssis", $name, $event['customer_email'], $level, $event["customer_id"]);
    }
}

// {"subscription_id":"N9G87jxBVe","customer_id":"PjWl2Z6EBv","status":"canceled","customer_email":"timolehnertz1@gmail.com","plan_name":"Subscribtion","product_name":"Trainer membership","product_link":"Ya7cE","gdpr_consent":"No","date_subscription_started":1712237697,"date_subscription_deleted":1712237776,"customer_first_name":"Timo","customer_last_name":"Lehnertz","type":"subscription.deleted","signature":"e6e5dd60c1354566f2dd5d7e0eaa6bc818868fd2989fad51376eadc5bbd81885"}
function deletePascalSubscribtion($event) {
    $level = levelByPascalEvent($event);
    if($level === null) {
        return;
    }
    $row = dbExecute("DELETE FROM TbPascalTrainers WHERE customer_id=? AND `level`=?;", "si", $event["customer_id"], $level);
}

function cors() {
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: token, Content-Type');
        header('Access-Control-Max-Age: 1728000');
        header('Content-Length: 0');
        header('Content-Type: text/plain');
        die();
    }

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

}


function rollerTimingNameExists(string $name): bool {
    return sizeof(query("SELECT idRollerTiming FROM TbRollerTiming WHERE `session`=? LIMIT 1", "s", $name)) > 0;
}

function doIOwnRollerTiming(string $name): bool {
    if(!isLoggedIn()) {
        return false;
    }
    $probe = query("SELECT `user` FROM TbRollerTiming WHERE `session`=? LIMIT 1", "s", $name);
    if(sizeof($probe) === 0) {
        return false;
    }
    return $_SESSION['iduser'] === $probe[0]["user"];
}

function renameRollerTimingSession(String $from, String $to): bool {
    if(!doIOwnRollerTiming($from)) {
        return false;
    }
    if(rollerTimingNameExists($to)) {
        return false;
    }
    return dbExecute("UPDATE TbRollerTiming SET `session`=? WHERE `session`=?;", "ss", $to, $from);
}

function doIHaveRollerTiming(): bool {
    if(!isLoggedIn()) {
        return false;
    }
    return sizeof(query("SELECT idRollerTiming FROM TbRollerTiming WHERE `user`=? LIMIT 1;", "i", $_SESSION["iduser"])) > 0;
}

function getRollerTrainings() {
    if(!isLoggedIn()) {
        return [];
    }
    return query("SELECT `session`, count(*) as `triggers`, max(rowCreated) as `uploadDate` FROM TbRollerTiming WHERE user=? GROUP BY `session`;", "i", $_SESSION["iduser"]);
}

function getTrainingsSession($sessionName) {
    if(!isLoggedIn()) return false;
    $res = query("SELECT * FROM TbRollerTiming WHERE user=? AND `session`=? ORDER BY timeMs ASC;", "is", $_SESSION["iduser"], $sessionName);
    if(empty($res)) {
        return false;
    }
    return $res;
}

function removeNonNumeric($inputString) {
    return preg_replace('/[^0-9]/', '', $inputString);
  }

/**
 * @return the name of the session or false
 */
function uploadResults($data): string | bool {
    if(sizeof($data['triggers']) === 0) {
        return false;
    }
    foreach ($data['triggers'] as $trigger) {
        if(!isset($trigger['triggerType']) || !isset($trigger['millimeters']) || !isset($trigger['timeMs'])) {
            return false;
        }
    }
    $userRes = query("SELECT * FROM TbUser WHERE username=? OR email=?;", "ss", $data["user"], $data["user"]);
    if(empty($userRes)) {
        return false;
    }
    $idUser = $userRes[0]["iduser"];
    if(isset($data["sessionName"]) && is_string($data["sessionName"])) {
        $sessionName = $data["sessionName"];
    } else {
        $unnamedSessions = query("SELECT `session` FROM TbRollerTiming WHERE user=? AND `session` LIKE 'My training %' GROUP BY `session`;", "i", $idUser);
        $number = 0;
        foreach ($unnamedSessions as &$row) {
            if(intval(removeNonNumeric($row['session'])) > $number) {
                $number = intval(removeNonNumeric($row['session']));
            }
        }
        $number++;
        $sessionName = "My training $number";
    }
    foreach ($data['triggers'] as &$trigger) {
        $trigger["session"] = $sessionName;
        $trigger["user"] = $idUser;
    }
    if(!arrayInsert("TbRollerTiming", ["triggerType", "timeMs", "millimeters", "user", "session"], "iiiis", $data['triggers'])) {
        return false;
    }
    return $sessionName;
}

function removeRaceFromSeries($idRace, $idRaceSeries) {
    if(!isAdmin()) return false;
    if(!isRaceInSeries($idRace, $idRaceSeries)) return true;
    dbExecute('DELETE FROM TbRaceInSeries WHERE race=? AND raceSeries=?;', 'ii', $idRace, $idRaceSeries);
    dbExecute('DELETE FROM TbRaceSeriesPoints WHERE race=? AND raceSeries=?;', 'ii', $idRace, $idRaceSeries);
    return true;
}

function addRaceToSeries($idRace, $idRaceSeries) {
    if(!isAdmin()) return false;
    if(isRaceInSeries($idRace, $idRaceSeries)) return true;
    $id = dbInsert('INSERT INTO TbRaceInSeries(`race`, `raceSeries`) VALUES(?,?);', 'ii', $idRace, $idRaceSeries);
    return true;
}

function isRaceInSeries($idRace, $idRaceSeries) {
    $res = query('SELECT * FROM TbRaceInSeries WHERE race=? AND raceSeries=?;', 'ii', $idRace, $idRaceSeries);
    return sizeof($res) > 0;
}

function getAthletesByClub($club) {
    return query("SELECT * FROM TbAthlete WHERE club=?;", "s", $club);
}

function getPlace($idPlace) {
    $res = query("SELECT * FROM TbPlace WHERE idPlaces=?;", "i", $idPlace);
    if(!$res || sizeof($res) == 0) return false;
    return $res[0];
}

function deletePlace($idPlace) {
    if(!isLoggedIn()) return false;
    $place = getPlace($idPlace);
    if(!$place) {
        return false;
    }
    if($place["creator"] != $_SESSION["iduser"]) {
        return false;
    };
    return dbExecute("DELETE FROM TbPlace WHERE idPlaces=?;", "i", $idPlace);
}

function uploadPlace($idPlace, $name, $description, $lat, $lng, $contact, $size, $coating, $clubName, $website, $corner, $videoLink, $famousPeople, $coatingYear) {
    if(!isLoggedIn()) return false;
    if($idPlace != NULL && $idPlace != "-1") {
        return updatePlace($idPlace, $name, $description, $lat, $lng, $contact, $size, $coating, $clubName, $website, $corner, $videoLink, $famousPeople, $coatingYear);
    }
    return dbExecute("INSERT INTO TbPlace(title, `description`, latitude, longitude, creator, contact, size, coating, clubName, website, corner, videoLink, famousPeople ,coatingYear) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)", "ssddisisssssss", $name, $description, $lat, $lng, $_SESSION["iduser"], $contact, $size, $coating, $clubName, $website, $corner, $videoLink, $famousPeople, $coatingYear);
}

function updatePlace($idPlace, $name, $description, $lat, $lng, $contact, $size, $coating, $clubName, $website, $corner, $videoLink, $famousPeople) {
    $place = getPlace($idPlace);
    if(!$place) return false;
    // if($_SESSION["iduser"] != $place["creator"]) return false;
    return dbExecute("UPDATE TbPlace SET title=?, `description`=?, latitude=?, longitude=?, creator=?, contact=?, size=?, coating=?, clubName=?, website=?, corner=?, videoLink=?, famousPeople=?, coatingYear=? WHERE idPlaces=?", "ssddisisssssssi", $name, $description, $lat, $lng, $_SESSION["iduser"], $contact, $size, $coating, $clubName, $website, $corner, $videoLink, $famousPeople, $coatingYear, $idPlace);
}

function getPlaces() {
    return query("SELECT * FROM TbPlace;");
}

function getUserByEmailOrusername($emailOrUsername) {
    $user = query("SELECT * FROM TbUser WHERE username=? OR email=?;", "ss", $emailOrUsername, $emailOrUsername);
    if(!$user || sizeof($user) < 1) return false;
    return $user[0];
}

function initPwReset($emailOrUsername, $newPw) {
    $user = getUserByEmailOrusername($emailOrUsername);
    $pwdHash = password_hash($newPw, PASSWORD_DEFAULT);
    if(!$user) return false;
    $resetId = bin2hex(random_bytes(32));
    dbInsert("INSERT INTO results.TbPwReset(`user`, resetId, newPwHash)VALUES(?, ?, ?);", "iss", $user["iduser"], $resetId, $pwdHash);
    $headers = 'From: roller.results@gmail.com'."\r\n".
        'Reply-To: roller.results@gmail.com'. "\r\n".
        'X-Mailer: PHP/'.phpversion();
    mail($user["email"], "Change password", "Hello ".$user["username"].",\r\nClick the link below to change your password.\r\nhttps://www.roller-results.com/login/change-password.php?id=$resetId\r\n\r\nKind regards\r\nTimo and Alex Lehnertz\r\n\r\nRoller results\r\nhttps://www.roller-results.com\r\n", $headers);
    return true;
}

function processPwReset($resetId) {
    $res = query("SELECT *, TIMESTAMPDIFF(Hour, NOW(), rowCreated) AS `hoursPassed` FROM TbPwReset WHERE resetId=? AND `succsess`=0 HAVING `hoursPassed` < 1;", "s", $resetId);
    if($res === False || sizeof($res) == 0) return false;
    dbExecute("UPDATE TbPwReset SET `succsess` = 1 WHERE resetId=?;", "s", $resetId);
    return dbExecute("UPDATE TbUser SET pwdHash=? WHERE iduser=?;", "si", $res[0]["newPwHash"], $res[0]["user"]);
}

function checkUserEmail($idUser) {
    return dbExecute("UPDATE TbUser set emailChecked=1 WHERE iduser=?;", "i", $idUser);
}

function validateObjectProperties(&$object, $properties, $logErrors = false) {
    foreach ($properties as $property) {
        if(!validateObjectOnProperty($object, $property, $logErrors)) return false;
    }
    return true;
}

/**
 * property settings
 * @param property string the name of the property
 * @param required boolean if true invalidates if this property is not existing, default true
 * @param forbidden boolean invalidates if this property is present, overwrites required, default false
 * @param noLog boolean ignore error messages for this error, default false
 * @param type string (string, number, integer, float, array) invalidates different types, default any
 * @param minLength int only for strings
 * @param maxLength int only for strings
 * @param value any value that this property must have
 * @param values any one of values that this property must have
 */
function validateObjectOnProperty(&$object, $property, $logErrors) {
    if(!isset($property["required"])) $property["required"] = true;
    if(!isset($property["forbidden"])) $property["forbidden"] = false;
    if(!isset($property["noLog"])) $property["noLog"] = false;
    if(!isset($property["type"])) $property["type"] = -1;
    if(!isset($property["minLength"])) $property["minLength"] = -1;
    if(!isset($property["maxLength"])) $property["maxLength"] = -1;
    if($property["forbidden"] && isset($object[$property["property"]])) return logError($logErrors && !$property["noLog"], "Missing parameter: ".$property["property"]);
    if($property["required"] && !isset($object[$property["property"]])) return logError($logErrors && !$property["noLog"], "Missing parameter: ".$property["property"]);
    if(!isset($object[$property["property"]])) {
        $object[$property["property"]] = NULL;
        return true;
    }
    $value = $object[$property["property"]];
    if($property["type"] != -1) {
        if($property["type"] === "string"   && !is_string($value)) return logError($logErrors && !$property["noLog"], "Invalid type given for: ".$property["property"].". expected string");
        if($property["type"] === "number"   && !is_numeric($value)) return logError($logErrors && !$property["noLog"], "Invalid type given for: ".$property["property"].". expected number");
        if($property["type"] === "integer"  && !is_int($value)) return logError($logErrors && !$property["noLog"], "Invalid type given for: ".$property["property"].". expected integer");
        if($property["type"] === "float"    && !is_float($value) && !is_int($value) && !is_double($value)) return logError($logErrors && !$property["noLog"], "Invalid type given for: ".$property["property"].". expected float");
        if($property["type"] === "array"    && !is_array($value)) return logError($logErrors && !$property["noLog"], "Invalid type given for: ".$property["property"].". expected array");
        if($property["type"] === "string") {
            if($property["minLength"] > -1 && strlen($value) < $property["minLength"]) return logError($logErrors && !$property["noLog"], "Too short argument given for: ".$property["property"].". expected at least ".$property["minLength"]." chacarters");
            if($property["maxLength"] > -1 && strlen($value) > $property["maxLength"]) return logError($logErrors && !$property["noLog"], "Too long argument given for: ".$property["property"].". expected less than ".$property["maxLength"]." chacarters");;
        }
    }
    if(isset($property["value"]) && $property["value"] !== $value) return false;
    if(isset($property["values"]) && !in_array($value, $property["values"])) return false;
    return true;
}

/**
 * Logs the error if logErrors is true
 * @param logErrors boolean
 * @param error string
 * @returns false
 */
function logError($logErrors, $error) {
    if(!$logErrors) return false;
    echo "Error: $error\n";
    return false;
}

/**
 *  gets the performance categories visible by the current user
 *  returns:
 *  [
 *      {
 *          idPerformanceCategory: <int>,
 *          name: <string>,
 *          description: <string>,
 *          type: <string>,
 *          creator: <int>,
 *          rowCreated: <string>
 *          rowupdated <string>
 *          myRecords: <int>
 *          records: <int>
 *          minValue: <float>
 *          maxValue: <float>
 *          goal: <float>
 *      }
 *  ]
 */
function getPerformanceCategories() {
    if(!isLoggedIn()) return [];
    $res = query("  SELECT pc.*, count(pr.idPerformanceRecord) as myRecords, min(pr.value) as `minValue`, max(pr.value) as `maxValue`, max(uipc.goal) as goal, max(pr.rowCreated) as lastUpload
                    FROM TbPerformanceCategory pc
                    JOIN TbUserInPerformanceCategory uipc ON uipc.performanceCategory = pc.idPerformanceCategory
                    LEFT JOIN TbPerformanceRecord pr ON pr.performanceCategory = pc.idPerformanceCategory AND pr.`user`=?
                    WHERE uipc.`user`=?
                    GROUP BY pc.idPerformanceCategory
                    ORDER BY lastUpload DESC, rowCreated DESC;", "ii", $_SESSION["iduser"], $_SESSION["iduser"]);
    foreach ($res as &$category) {
        $category["progress"] = getPerformanceCategoryGoal($category);
    }
    return $res;
}

function getPerformanceCategoryUsers($idPerformanceCategory) {
    if(!isLoggedIn() || !isUserInPerformanceCategory($idPerformanceCategory, $_SESSION["iduser"])) return [];
    return query("  SELECT `user`.username, `user`.iduser, IF(athlete.image IS NOT NULL, CONCAT('/img/uploads/', athlete.image), NULL) as image, athlete.firstname, athlete.lastname, athlete.gender, uipc.isAdmin, uipc.creator, pc.creator = `user`.iduser as isCreator, count(TbPerformanceRecord.idPerformanceRecord) as uploads
                    FROM TbUserInPerformanceCategory uipc
                    JOIN TbUser `user` ON `user`.iduser = uipc.`user`
                    LEFT JOIN TbAthlete athlete ON athlete.id = `user`.athlete
                    LEFT JOIN TbPerformanceRecord ON TbPerformanceRecord.user = `user`.iduser AND TbPerformanceRecord.performanceCategory = ?
                    LEFT JOIN TbPerformanceCategory pc ON pc.idPerformanceCategory = uipc.performanceCategory
                    WHERE uipc.performanceCategory = ?
                    GROUP BY `user`.iduser, athlete.id, uipc.idUserInPerformanceCategory;", "ii", $idPerformanceCategory, $idPerformanceCategory);
}

function getPerformanceCategory($idPerformanceCategory) {
    if(!isLoggedIn()) return [];
    $res = query("  SELECT pc.*, SUM(if(pr.user=?, 1, 0)) as myRecords, count(pr.idPerformanceRecord) as records, min(pr.value) as `minValue`, max(pr.value) as `maxValue`, max(uipc.goal) as goal, max(pr.rowCreated) as lastUpload
                    FROM TbPerformanceCategory pc
                    JOIN TbUserInPerformanceCategory uipc ON uipc.performanceCategory = pc.idPerformanceCategory
                    LEFT JOIN TbPerformanceRecord pr ON pr.performanceCategory = pc.idPerformanceCategory AND pr.`user`=?
                    WHERE uipc.`user`=? AND pc.idPerformanceCategory=?
                    GROUP BY pc.idPerformanceCategory
                    ORDER BY lastUpload DESC, rowCreated DESC;", "iiii", $_SESSION["iduser"], $_SESSION["iduser"], $_SESSION["iduser"], $idPerformanceCategory);
    if(sizeof($res) == 0) return false;
    $res[0]["progress"] = getPerformanceCategoryGoal($res[0]);
    return $res[0];
}

function getPerformanceRecords($idPerformanceCategory) {
    if(!isLoggedIn()) return [];
    if(!isUserInPerformanceCategory($idPerformanceCategory, $_SESSION["iduser"])) return [];
    return query("SELECT TbPerformanceRecord.*, TbUser.username FROM TbPerformanceRecord JOIN TbUser ON TbUser.iduser = TbPerformanceRecord.user WHERE performanceCategory=? ORDER BY `date` DESC, `user` ASC, rowCreated ASC;", "i", $idPerformanceCategory);
}

function getPerformanceCategoryGoal($performanceCategory) {
    $progress = 0;
    if($performanceCategory["goal"] != NULL) {
        if(!isPerformanceGroupTypeMin($performanceCategory["type"])) {
            if($performanceCategory["goal"] == 0) return 0;
            $progress = $performanceCategory["maxValue"] / $performanceCategory["goal"];
        } else {
            if($performanceCategory["minValue"] == 0) return 0;
            $progress = $performanceCategory["goal"] / $performanceCategory["minValue"];
        }
    }
    if(is_nan($progress)) return 0;
    return $progress;
}

function getLastPerformanceUploads() {
    if(!isLoggedIn()) return [];
    return query("SELECT pr.*, tpc.name, tpc.type FROM TbPerformanceRecord pr
        JOIN TbPerformanceCategory tpc ON tpc.idPerformanceCategory = pr.performanceCategory 
        WHERE `user` = ? ORDER BY rowCreated DESC LIMIT 15;", "i", $_SESSION["iduser"]);
}

function getFullperformanceCategory($idPerformanceCategory) {
    if(!isLoggedIn() || !isUserInPerformanceCategory($idPerformanceCategory, $_SESSION["iduser"])) return false; // check rights
    $category = getPerformanceCategory($idPerformanceCategory);
    $records = getPerformanceRecords($idPerformanceCategory);
    $category["records"] = $records;
    $category["progress"] = getPerformanceCategoryGoal($category);
    return $category;
}

function updateGoalOnGroup($idPerformanceCategory, $goal) {
    if(!isLoggedIn()) return false;
    return dbExecute("UPDATE TbUserInPerformanceCategory SET goal=? WHERE performanceCategory=? AND `user`=?;", "idi", $goal, $idPerformanceCategory, $_SESSION["iduser"]);
}

function echoProgress($performanceCategory) {
    if($performanceCategory["progress"] == NULL || $performanceCategory["progress"] == 0) return;
    echo "<div class='progress'>
        <div class='progress-bar-background'>
            <div class='progress-bar' style='width: ".round($performanceCategory["progress"] * 100)."%;'></div>
        </div>
        <p>".round($performanceCategory["progress"] * 100)."%</p>
    </div>";
}

/**
 * @param name string
 * @param description string
 * @param type string (time,bpm,distance)
 * @param users array of numbers
 * 
 * Creates a Performance category
 */
function createPerformanceCategory($name, $description, $type, $users) {
    if(!isLoggedIn()) return false;
    $creator = $_SESSION["iduser"];
    $idPerformanceCategory = dbInsert("INSERT INTO TbPerformanceCategory(`name`, `description`, `type`, creator) VALUES(?,?,?,?);", "sssi", $name, $description, $type, $creator);
    if(!$idPerformanceCategory) return false;
    // var_dump($users);
    addUsersToPerformanceCategory($idPerformanceCategory, $users);
    return $idPerformanceCategory;
}

/**
 * changes the name and or description of a performance category if the user is an admin
 */
function editPerformanceCategory($idPerformanceCategory, $name, $description) {
    if(!amIAdminInPerformanceCategory($idPerformanceCategory)) return false;
    return dbExecute("UPDATE TbPerformanceCategory SET `name`=?, `description`=? WHERE idPerformanceCategory=?;", "ssi", $name, $description, $idPerformanceCategory);
}

function makePerformanceCategoryUserAdmin($idPerformanceCategory, $idUser, $admin) {
    if(!doIOwnPerformanceCategory($idPerformanceCategory)) return false;
    return dbExecute("UPDATE TbUserInPerformanceCategory SET isAdmin=? WHERE `user`=? AND performanceCategory =?;", "iii", $admin, $idUser, $idPerformanceCategory);
}

function makePerformanceCategoryUserCreator($idPerformanceCategory, $idUser) {
    if(!doIOwnPerformanceCategory($idPerformanceCategory)) return false;
    return dbExecute("UPDATE TbPerformanceCategory SET `creator`=? WHERE idPerformanceCategory=?;", "ii", $idUser, $idPerformanceCategory);
}

/**
 * Adds a user to the Performance category if the current user is an admin
 * 
 * @param idPerformanceCategory int
 * @param idUser int
 */
function addUserToPerformanceCategory($idPerformanceCategory, $idUser) {
    if(!amIAdminInPerformanceCategory($idPerformanceCategory)) return false;
    if(isUserInPerformanceCategory($idPerformanceCategory, $idUser)) return true;
    $creator = $_SESSION["iduser"];
    return dbInsert("INSERT INTO TbUserInPerformanceCategory
    (`user`, performanceCategory, isAdmin, creator) VALUES (?,?,?,?)", "iiii", $idUser, $idPerformanceCategory, false, $creator) != false;
}

/**
 * removes a user from a performance category if the current user has greater rights
 * 
 * @param idPerformanceCategory int
 * @param idUser int
 */
function removeUserFromPerformanceCategory($idPerformanceCategory, $idUser) {
    if(!amIAdminInPerformanceCategory($idPerformanceCategory)) return false;
    if(isUserAdminInPerformanceCategory($idPerformanceCategory, $idUser) && !doIOwnPerformanceCategory($idPerformanceCategory)) return false;
    return dbExecute("DELETE FROM TbUserInPerformanceCategory WHERE performanceCategory=? AND user=?;", "ii", $idPerformanceCategory, $idUser);
}

/**
 * checks if a user is member in a performance category
 * 
 * @param idPerformanceCategory int
 * @param idUser int
 */
function isUserInPerformanceCategory($idPerformanceCategory, $idUser) {
    $res = query("SELECT * FROM TbUserInPerformanceCategory WHERE performanceCategory=? AND user=?;", "ii", $idPerformanceCategory, $idUser);
    if($res === false) return false;
    return sizeof($res) > 0;
}

/**
 * CHecks if a user is admin in the Performance group
 * 
 * @param idPerformanceCategory int
 * @param idUser int
 */
function isUserAdminInPerformanceCategory($idPerformanceCategory, $idUser) {
    $res = query("SELECT * FROM TbUserInPerformanceCategory WHERE performanceCategory=? AND user=? AND isAdmin=1;", "ii", $idPerformanceCategory, $idUser);
    if(!$res) return false;
    return sizeof($res) > 0;
}

/**
 * adds users to a group
 * Note: ignores if the user is already in the performance group.
 * Only to be used on initialization of performance groups
 * 
 * @param users array of numbers
 */
function addUsersToPerformanceCategory($idPerformanceCategory, $users) {
    if(!isLoggedIn()) return false;
    if(sizeof($users) == 0) return true;
    $types = "";
    $sql = "";
    $del = "";
    $fillers = [];
    foreach ($users as $iduser) {
        $types.="iiii";
        $sql .= "$del(?,?,?,?)";
        $del = ",";
        $fillers[]= $iduser;
        $fillers[]= $idPerformanceCategory;
        $fillers[]= $iduser == $_SESSION["iduser"] ? 1 : 0;
        $fillers[]= $_SESSION["iduser"];
    }
    return dbInsert("INSERT INTO TbUserInPerformanceCategory(`user`, performanceCategory, isAdmin, creator) VALUES $sql;", $types, ... $fillers) != FALSE;
}

/**
 * Checks if the current user is admin in the performance category
 * 
 * @param idPerformanceCategory int
 */
function amIAdminInPerformanceCategory($idPerformanceCategory) {
    if(!isLoggedIn()) return false;
    return isUserAdminInPerformanceCategory($idPerformanceCategory, $_SESSION["iduser"]) || isAdmin();
}

/**
 * Checks if the specified user owns this performance category
 * 
 * @param idPerformanceCategory int
 * @param idUser int
 */
function doesUserOwnPerformanceCategory($idPerformanceCategory, $idUser) {
    $res = query("SELECT * FROM TbPerformanceCategory WHERE idPerformanceCategory=? AND creator=?;", "ii", $idPerformanceCategory, $idUser);
    if(!$res) return false;
    return sizeof($res) > 0;
}

/**
 * Checks if the current user owns the performance category
 */
function doIOwnPerformanceCategory($idPerformanceCategory) {
    if(!isLoggedIn()) return false;
    return doesUserOwnPerformanceCategory($idPerformanceCategory, $_SESSION["iduser"]) || isAdmin();
}

/**
 * Deletes all users from a performance category if the current user is the owner 
 */
function deletePerformanceCategoryUsers($idPerformanceCategory) {
    if(!doIOwnPerformanceCategory($idPerformanceCategory)) return false;
    return dbExecute("DELETE FROM TbUserInPerformanceCategory WHERE performanceCategory = ?;", "i", $idPerformanceCategory);
}

function deletePerformanceCategoryRecords($idPerformanceCategory) {
    if(!doIOwnPerformanceCategory($idPerformanceCategory)) return false;
    return dbExecute("DELETE FROM TbPerformanceRecord WHERE performanceCategory = ?;", "i", $idPerformanceCategory);
}

/**
 * Deletes a performance category and user links if the current user is the creator
 */
function deletePerformanceCategory($idPerformanceCategory) {
    if(!doIOwnPerformanceCategory($idPerformanceCategory)) return false;
    if(!deletePerformanceCategoryUsers($idPerformanceCategory)) return false;
    deletePerformanceCategoryUsers($idPerformanceCategory);
    deletePerformanceCategoryRecords($idPerformanceCategory);
    return dbExecute("DELETE FROM TbPerformanceCategory WHERE idPerformanceCategory = ?;", "i", $idPerformanceCategory);
}

function canIEditPerformanceRecord($idPerformanceCategory, $targetUser) {
    if(!isLoggedIn()) return false;
    if(!isUserInPerformanceCategory($idPerformanceCategory, $_SESSION["iduser"])) return false;
    if(($targetUser != $_SESSION["iduser"]) && !amIAdminInPerformanceCategory($idPerformanceCategory)) return false;
    return true;
}

function canISeePascalPage() {
    if(!isLoggedIn()) return false;
    return isset($_SESSION["pascalManager"]) && $_SESSION["pascalManager"];
}

function getPascalMembership($customer_id): ?array {
    $res = query("SELECT lat, `long`, `name`, contact, email, phoneNumber, website, `level` FROM TbPascalTrainers WHERE customer_id=?;", "s", $customer_id);
    if(count($res) === 0) {
        return null;
    }
    return $res[0];
}

function getPascalMembershipsForMap(): array {
    return query("SELECT `id`, lat, `long`, `name`, contact, email, phoneNumber, website, `level` FROM TbPascalTrainers WHERE lat != 0 && `long` != 0;");
}

function getPascalMembershipsWithCode(): array {
    return query("SELECT `id`, lat, `long`, `name`, contact, email, phoneNumber, website, `level`, `customer_id` FROM TbPascalTrainers;");
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}


function addPascalMembership($lat, $long, $name, $contact, $email, $phoneNumber, $website, $level) {
    $user_id = generateRandomString(10);
    $long = str_replace(",", ".", $long);
    $lat = str_replace(",", ".", $lat);
    return dbInsert("INSERT INTO TbPascalTrainers(lat, `long`, `name`, contact, email, phoneNumber, website, `level`, customer_id) VALUES(?,?,?,?,?,?,?,?,?);","ddsssssis", $lat, $long, $name, $contact, $email, $phoneNumber, $website, $level, $user_id);
}

function updatePascalMembershipByUser($customerID, $lat, $long, $name, $contact, $email, $phoneNumber, $website) {
    $long = str_replace(",", ".", $long);
    $lat = str_replace(",", ".", $lat);
    dbExecute("UPDATE TbPascalTrainers SET lat = ?, `long`= ?, `name`= ?, contact = ?, email = ?, phoneNumber = ?, website = ? WHERE `customer_id`=?;","ddssssss", $lat, $long, $name, $contact, $email, $phoneNumber, $website, $customerID);
}

function updatePascalMembership($id, $lat, $long, $name, $contact, $email, $phoneNumber, $website, $level) {
    dbExecute("UPDATE TbPascalTrainers SET lat = ?, `long`= ?, `name`= ?, contact = ?, email = ?, phoneNumber = ?, website = ?, level = ? WHERE `id`=?;","ddsssssii", $lat, $long, $name, $contact, $email, $phoneNumber, $website, $level, $id);
}

function deletePascalMembership($id) {
    dbExecute("DELETE FROM TbPascalTrainers WHERE id=?","i", $id);
}

function uploadPerformanceRecord($idPerformanceCategory, $idUser, $value, $comment, $date) {
    if(!isLoggedIn()) return false;
    if(!isUserInPerformanceCategory($idPerformanceCategory, $_SESSION["iduser"])) return false;
    return dbInsert("INSERT INTO TbPerformanceRecord(`user`, `value`, `comment`, `performanceCategory`, `date`) VALUES (?,?,?,?,?);", "idsis", $idUser, $value, $comment, $idPerformanceCategory, $date);
}

function editPerformanceRecord($idPerformanceRecord, $value) {
    $record = getPerformanceRecord($idPerformanceRecord);
    if(!$record) return false;
    if(!canIEditPerformanceRecord($idPerformanceCategory, $record["user"])) return false;
    return dbExecute("UPDATE TbPerformanceRecord SET value=? WHERE idPerformanceRecord=?;", "di", $value, $idPerformanceRecord);
}

function deletePerformanceRecord($idPerformanceRecord) {
    $record = getPerformanceRecord($idPerformanceRecord);
    if(!$record) return false;
    if(!canIEditPerformanceRecord($record["performanceCategory"], $record["user"])) return false;
    return dbExecute("DELETE FROM TbPerformanceRecord WHERE idPerformanceRecord=?;", "i", $idPerformanceRecord);
}

function getPerformanceRecord($idPerformanceRecord) {
    $res = query("SELECT * FROM TbPerformanceRecord WHERE idPerformanceRecord=?", "i", $idPerformanceRecord);
    if(!$res) return false;
    if(sizeof($res) == 0) return false;
    return $res[0];
}

function getPerformanceRecordsByCategory($idPerformanceCategory) {
    if(!loggedIn()) return false;
    $isAdmin = amIAdminInPerformanceCategory($idPerformanceCategory);
    $res = query("SELECT *, ? OR `user`=? AS `editable` FROM TbPerformanceRecord WHERE performanceCategory=?;", "iii", $isAdmin, $_SESSION["iduser"], $idPerformanceCategory);
    if(!$res) return false;
    if(sizeof($res) == 0) return false;
    return $res[0];
}

function getPersonalRecordFromPerformanceCategory($category) {
    if(!isLoggedIn()) return false;
    $asc = isPerformanceGroupTypeMin($category["type"]);
    if(sizeof($category["records"]) == 0) return false;
    $found = false;
    foreach ($category["records"] as $record) {
        if($record["user"] != $_SESSION["iduser"]) continue;
        $best = $record["value"];
        $found = true;
        break;
    }
    if(!$found) {
        return false;
    }
    foreach ($category["records"] as $record) {
        if($record["user"] != $_SESSION["iduser"]) continue;
        if($asc) {
            if($record["value"] < $best) $best = $record["value"];
        } else {
            if($record["value"] > $best) $best = $record["value"];
        }
    }
    // var_dump($best);
    return $best.getPerformanceGroupTypeShort($category["type"]);
}

function isPerformanceGroupTypeMin($type) {
    switch($type) {
        case "time": return true;
        case "bpm": return true;
        case "distance": return false;
        case "weight": return false;
        default: return false;
    }
}

function getPerformanceGroupTypeShort($type) {
    switch($type) {
        case "time": return "s";
        case "bpm": return "bpm";
        case "distance": return "m";
        case "weight": return "kg";
        default: return "";
    }
}

function getPerformanceGroupTypeMetricLong($type) {
    switch($type) {
        case "time": return "seconds";
        case "bpm": return "beats per minute";
        case "distance": return "meters";
        case "weight": return "kg";
        default: return "";
    }
}

function getPerformanceGroupTypelong($type) {
    switch($type) {
        case "time": return "Time";
        case "bpm": return "frequency";
        case "distance": return "distance";
        case "weight": return "weight";
        default: return "";
    }
}

function echoPerformanceCategory($performanceCategory) {
    $records = $performanceCategory["myRecords"]." ".($performanceCategory["myRecords"] > 1 ? "uploads" : "upload");
    if($performanceCategory["myRecords"] == 0) {
        $records = "No uploads yet";
    }
    $type = $performanceCategory["type"];
    $best = isPerformanceGroupTypeMin($type) ? $performanceCategory["minValue"] : $performanceCategory["maxValue"];
    $short = !empty($best) ? getPerformanceGroupTypeShort($type) : "";
    $long = getPerformanceGroupTypelong($type);
    $name = $performanceCategory["name"];
    $id = $performanceCategory["idPerformanceCategory"];
    echo "
    <div class='performance-category' id='$id' long='$long' metric='".getPerformanceGroupTypelong($performanceCategory["type"])." (".getPerformanceGroupTypeMetricLong($performanceCategory["type"]).")'>
        <div class='top'>
            <p class='name margin right'>$name</p><p class='best'>pb: $best$short</p>
        </div>
        <p class='records'>$records</p>";

    echoProgress($performanceCategory);
    echo "</div>";
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
    if(!isLoggedIn()) return false;
    if(sizeof(query("SELECT * FROM TbDevLog WHERE title = ?;", "s", $title)) > 0) {
        return false;
    }
    if(sizeof(query("SELECT * FROM TbDevLog WHERE `user`=? AND DATE(rowCreated) = DATE(NOW());", "i", $_SESSION["iduser"])) > 5) {
        return false;
    }
    return dbExecute("INSERT INTO TbDevLog(title, description, status, `user`) VALUES(?,?,'Requested',?);", "ssi", $title, $description, $_SESSION["iduser"]);
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
    $sql = "INSERT INTO TbResult(idPerson, idRace, place, tacticalNote, timeDate, creator, checked, points, disqualificationTechnical, disqualificationSportsFault, didNotStart, falseStart, laps, category) VALUES ";

    $checked = canI("managePermissions");
    $delimiter = "";
    $fillers = [];
    foreach ($results as $result) {
        $sql .= "$delimiter(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $types .= "iiissiiiiiiiis";
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
        $laps = NULL;
        $category = NULL;
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
        if(isset($result["laps"])) {
            $laps = $result["laps"];
        }
        if(isset($result["category"])) {
            $category = $result["category"];
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
        $fillers []= $laps;
        $fillers []= $category;
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
    return dbInsert($sql, $types, ...$vals) !== false;
}

function getOvertakesByDistance($distance, $gender) {
    $w = strpos($gender, "w") !== False ? "w" : "-";
    $m = strpos($gender, "m") !== False ? "m" : "-";
    return query("SELECT * FROM TbPass JOIN TbRace ON TbRace.id = TbPass.race JOIN TbCompetition ON TbCompetition.idCompetition = TbRace.idCompetition JOIN TbAthlete ON TbAthlete.id = TbPass.athlete WHERE distance=? AND (TbRace.gender LIKE ? OR TbRace.gender LIKE ?) ORDER BY race, lap ASC;", "sss", $distance, $m, $w);
}

function getOvertakes($idrace) {
    return query("SELECT * FROM TbPass WHERE race=? ORDER BY lap ASC, toPlace ASC;", "i", $idrace);
}

function getAthleteVideos($idAthlete) {
    return query("CALL sp_getAthleteVideos(?);", "i", $idAthlete);
}

function saveOvertakes($overtakes) {
    // if(!canI("speaker")) {
    //     return;
    // }
    if(!is_array($overtakes)) {
        echo "Error: overtakes need to be an array";
        return;
    }
    if(sizeof($overtakes) == 0) {
        echo "Error: overtakes need to be filled";
        return;
    }
    // if(!isLoggedIn()) {
    //     echo "Error: You need to be logged in";
    //     return;
    // }
    $idUser = NULL;
    if(isLoggedIn()) {
        $idUser = $_SESSION["iduser"];
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
       $o["creator"] = $idUser;
    }
    dbExecute("DELETE FROM TbPass WHERE race=?;", "i", $idrace);
    arrayInsert("TbPass", ["athlete", "race", "fromPlace", "toPlace", "lap", "insideOut", "creator", "finishPlace"], "iiiidsii", $overtakes);
    echo "succsess";
}

function getRaceAthletes($idRace) {
    return query("SELECT * FROM vAthlete JOIN TbResult as res ON res.idPerson = vAthlete.idAthlete WHERE res.idRace = ? ORDER BY place ASC;", "i", $idRace);
}

function getCompRaces($idComp) {
    return query("SELECT * FROM TbRace WHERE idCompetition = ? ORDER BY distance, category, gender;", "i", $idComp);
}

function getCompsRaces($idComps) {
    $comps = query("SELECT * FROM TbRace WHERE FIND_IN_SET(idCompetition, ?) ORDER BY distance, category, gender;", "s", $idComps);
    $races = [];
    foreach ($comps as $comp) {
        $races = array_merge($races, getCompRaces($comp['idCompetition']));
    }
    return $races;
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

function getAliasAthletes($aliasGroup) {
    return query("SELECT TbAthlete.* FROM TbAthlete JOIN TbAthleteAlias ON TbAthleteAlias.idAthlete = TbAthlete.id WHERE TbAthleteAlias.aliasGroup=?;", "s", $aliasGroup);
}

function getAliasGroups() {
    if(!isLoggedIn()) {
        return [];
    }
    $res = query("SELECT aliasGroup, creator, TbUser.username, count(*) as `count`, max(TbAthleteAlias.rowCreated) AS lastUpdate FROM TbAthleteAlias JOIN TbUser ON TbUser.iduser = creator GROUP BY aliasGroup, creator ORDER BY lastUpdate DESC;");
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
        $alias["newId"] = dbInsert("INSERT INTO TbAthlete(firstName, lastName, country, gender, club, team, checked, creator, DRIVlicence) VALUES (?,?,?,?,?,?,?,?,?)", "ssssssiis", $newAthlete["firstName"], $newAthlete["lastName"], $newAthlete["country"], $newAthlete["gender"], $club, $team, $checked, $creator, $newAthlete["DRIVlicence"]);
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
    $res = query("CALL sp_getCompAthleteMedals(?)", "i", $idComp);
    if(sizeof($res) > 0){
        return $res;
    } else{
        return [];
    }
}


function getCompMedals($idComp) {
    return query("SELECT res.place, athlete.id idAthlete, athlete.firstname, athlete.lastname, athlete.image, athlete.country, race.id idRace, race.distance, race.category, race.gender
        FROM TbCompetition comp
        JOIN TbRace race ON race.idCompetition = comp.idCompetition
        JOIN TbResult res ON res.idRace = race.id
        JOIN TbAthlete athlete ON athlete.id = res.idPerson
        WHERE comp.idCompetition=? AND res.place BETWEEN 1 AND 3;", "i", $idComp);
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

function getAllRaceSeries() {
    $res = query("SELECT TbRaceSeries.*, count(TbRaceInSeries.raceSeries) as races FROM TbRaceSeries LEFT JOIN TbRaceInSeries ON TbRaceInSeries.raceSeries = TbRaceSeries.idRaceSeries GROUP BY TbRaceSeries.idRaceSeries;");
    return $res;
}

function getAllRaceSeriesWithRaces() {
    $res = query("SELECT TbRaceSeries.*, TbRaceInSeries.race FROM TbRaceSeries LEFT JOIN TbRaceInSeries ON TbRaceInSeries.raceSeries = TbRaceSeries.idRaceSeries ORDER BY TbRaceSeries.idRaceSeries ASC, year DESC;");
    // echo '<pre>';
    // print_r($res);
    $raceSeries = [];
    $raceSerie = null;
    $idRaceSerie = -1;
    foreach ($res as $row) {
        if($idRaceSerie !== $row['idRaceSeries']) {
            if($raceSerie !== null) {
                $raceSeries [] = $raceSerie;
            }
            $raceSerie = $row;
            unset($raceSerie['race']);
            if($row['race'] !== null) {
                $raceSerie['idRaces'] = [$row['race']];
            } else {
                $raceSerie['idRaces'] = [];
            }
        } else {
            $raceSerie['idRaces'] [] = $row['race'];
        }
        $idRaceSerie = $row['idRaceSeries'];
    }
    if($raceSerie !== null) {
        $raceSeries [] = $raceSerie;
    }
    return $raceSeries;
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
    global $usedMedals;
    $result = query("CALL sp_getAthleteNew(?, ?)", "is", intval($id), $usedMedals);
    if(sizeof($result) > 0) return $result[0];
    return [];
}

function getAthleteFull($id){
    global $scoreInfluences;
    global $usedMedals;
    $result = query("CALL sp_athletePrivateFull(?, ?, ?)", "iss", intval($id), $scoreInfluences, $usedMedals);
    if(sizeof($result) > 0) {
        return $result[0];
    } else {
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

function calculateRaceSeries($id) {
    if(!isAdmin()) return false;
    $raceSeries = query("SELECT * FROM TbRaceSeries WHERE idRaceSeries = ?;", "i", $id);
    if(sizeof($raceSeries) == 0) return false;
    $raceSeries = $raceSeries[0];
    $error = false;
    switch($raceSeries["type"]) {
        case "WSC":
            $error = calculateWSC($raceSeries);
            break;
        default:
            return false;
    }
    if($error === false) {
        return calculateStrikeResults($raceSeries);
    } else {
        return $error;
    }
}

function calculateStrikeResults($raceSeries) {
    // reset all
    dbExecute("UPDATE TbRaceSeriesPoints SET strikeResultCategory=0, strikeResultOverall=0 WHERE raceSeries=?;", "i", $raceSeries["idRaceSeries"]);

    $countedRaces = query("SELECT countedRaces FROM TbRaceSeries WHERE idRaceSeries = ?;", "i", $raceSeries["idRaceSeries"])[0]["countedRaces"];
    
    // strikeResults Overall
    $seriesPointsOverall = query("SELECT * FROM TbRaceSeriesPoints WHERE raceSeries = ? ORDER BY athlete DESC, pointsOverall DESC;", 'i', $raceSeries["idRaceSeries"]);
    $athlete = -1;
    $i = 0;
    $strikedIDs = [];
    foreach ($seriesPointsOverall as $seriesPoint) {
        if($athlete !== $seriesPoint['athlete']) {
            $i = 0;
            $athlete = $seriesPoint['athlete'];
        }
        if($i >= $countedRaces) {
            $strikedIDs []= $seriesPoint['idRaceSeriesPoint'];
        }
        $i++;
    }
    $types = '';
    $fillers = [];
    $inList = '';
    $delimiter = '';
    foreach ($strikedIDs as $strikedID) {
        $types .= 'i';
        $inList .= $delimiter.'?';
        $delimiter = ',';
        $fillers []= $strikedID;
    }
    // print_r($strikedIDs);
    if(sizeof($strikedIDs) > 0) {
        // print_r('UPDATE TbRaceSeriesPoints SET strikeResultOverall=1 WHERE idRaceSeriesPoint IN ('.$inList.');');
        dbExecute('UPDATE TbRaceSeriesPoints SET strikeResultOverall=1 WHERE idRaceSeriesPoint IN ('.$inList.');', $types, ...$fillers);
    }

    // strikeResults Category
    $seriesPointsCategory = query("SELECT * FROM TbRaceSeriesPoints WHERE raceSeries = ? ORDER BY athlete DESC, pointsCategory DESC;", 'i', $raceSeries["idRaceSeries"]);
    $athlete = -1;
    $i = 0;
    $strikedIDs = [];
    foreach ($seriesPointsCategory as $seriesPoint) {
        if($athlete !== $seriesPoint['athlete']) {
            $i = 0;
            $athlete = $seriesPoint['athlete'];
        }
        if($i >= $countedRaces) {
            $strikedIDs []= $seriesPoint['idRaceSeriesPoint'];
        }
        $i++;
    }
    $types = '';
    $fillers = [];
    $inList = '';
    $delimiter = '';
    foreach ($strikedIDs as $strikedID) {
        $types .= 'i';
        $inList .= $delimiter.'?';
        $delimiter = ',';
        $fillers []= $strikedID;
    }
    // print_r($strikedIDs);
    if(sizeof($strikedIDs) > 0) {
        // print_r('UPDATE TbRaceSeriesPoints SET strikeResultOverall=1 WHERE idRaceSeriesPoint IN ('.$inList.');');
        dbExecute('UPDATE TbRaceSeriesPoints SET strikeResultCategory=1 WHERE idRaceSeriesPoint IN ('.$inList.');', $types, ...$fillers);
    }
    return false;
}

function calculateWSC($raceSeries) {
    // delete previous points
    dbExecute("DELETE FROM TbRaceSeriesPoints WHERE raceSeries = ?", "i", $raceSeries["idRaceSeries"]);
    $raceCount = query("SELECT count(*) as `count` FROM TbRaceInSeries WHERE raceSeries = ?", "i", $raceSeries["idRaceSeries"])[0]["count"];
    if($raceCount === 0) return;
    // gather and orgabize results
    $results = query("SELECT TbResult.place, TbResult.idPerson as idAthlete, TbResult.idRace, IFNULL(TbResult.category, race.category) as category
        FROM TbRaceInSeries
        JOIN TbResult ON TbResult.idRace = TbRaceInSeries.race
        JOIN TbRace as race ON race.id = TbRaceInSeries.race
        WHERE raceSeries = ?
        ORDER BY idAthlete;", "i", $raceSeries["idRaceSeries"]);
    $athletes = [];
    $prevIdAthlete = -1;
    $currentAthlete = [];
    // checking that no athletes changed category
    $checkRes = query("SELECT TbResult.idPerson as idAthlete, CONCAT(athlete.firstname, ' ', athlete.lastname) as name, GROUP_CONCAT(TbResult.category) as categories
        FROM TbRaceInSeries
        JOIN TbResult ON TbResult.idRace = TbRaceInSeries.race
        JOIN TbAthlete as athlete on athlete.id = TbResult.idPerson
        WHERE raceSeries = ?
        GROUP BY TbResult.idPerson
        HAVING count(DISTINCT category) > 1", "i", $raceSeries["idRaceSeries"]);
    if(!empty($checkRes)) {
        echo"Those athletes have inconsistent categories. Please fix them before calculating";
        echo "<pre>";
        print_r($checkRes);
        echo "</pre>";
        return "inconsistent categories";
    }
    // echo "<pre>";
    foreach($results as $result) {
        // var_dump($result['category']);
        // if($result['category'] == null) {
        //     return "no category given for result: #".$result['id'];
        // }
        if($prevIdAthlete != $result["idAthlete"]) {
            if($prevIdAthlete >= 0) $athletes[$prevIdAthlete] = $currentAthlete;
            $prevIdAthlete = $result["idAthlete"];
            $currentAthlete = ["results" => []];
        }
        $currentAthlete['category'] = $result["category"];
        $currentAthlete["results"][$result["idRace"]] = ["placeOverall" => $result["place"], "pointsOverall" => calcWSCScore($result["place"])];
    }
    if($prevIdAthlete >= 0) $athletes[$prevIdAthlete] = $currentAthlete; // adding last athlete
    // get age categories
    foreach ($athletes as $idAthlete => $athlete) {
        // $athletes[$idAthlete]["category"] = 'none';
        // $res = query("SELECT category
        // FROM TbRaceInSeries JOIN TbResult ON TbResult.idRace = TbRaceInSeries.race
        // WHERE raceSeries = ? AND TbResult.category IS NOT NULL AND TbResult.idPerson = ?
        // LIMIT 1", "ii", $raceSeries["idRaceSeries"], $idAthlete);
        // if(sizeof($res) > 0) {
        //     $athletes[$idAthlete]["category"] = $res[0]["category"];
        // }
    }
    // get category results
    foreach ($athletes as $idAthlete => $athlete) {
        foreach ($athlete["results"] as $idRace => $results) {
            // if(isset($results["placeCategory"])) continue; // already calculated
            $categoryResults = query("SELECT idPerson
            FROM TbResult
            WHERE TbResult.idRace = ? AND (TbResult.category = ? OR TbResult.category IS NULL)
            ORDER BY TbResult.place ASC;", "is", $idRace, $athlete["category"]);
            if(sizeof($categoryResults) == 0) {
                echo $athlete["category"];
            }
            for ($i=0; $i < sizeof($categoryResults); $i++) {
                $categoryResult = $categoryResults[$i];
                $athletes[$categoryResult["idPerson"]]["results"][$idRace]["placeCategory"] = $i+1;
                $athletes[$categoryResult["idPerson"]]["results"][$idRace]["pointsCategory"] = calcWSCScore($i+1);
            }
        }
    }
    // echo '<pre>';
    // print_r($athletes);
    // echo '</pre>';
    // insert scores
    $inserts = [];
    foreach ($athletes as $idAthlete => $athlete) {
        foreach ($athlete["results"] as $idRace => $results) {
            $inserts []= [
                "race" => $idRace,
                "athlete" => $idAthlete,
                "raceSeries" => $raceSeries["idRaceSeries"],
                "pointsCategory" => $results["pointsCategory"],
                "pointsOverall" => $results["pointsOverall"],
                "placeOverall" => $results["placeOverall"],
                "placeCategory" => $results["placeCategory"],
                "category" => $athlete["category"],
            ];
        }
    }
    arrayInsert("TbRaceSeriesPoints", ["race", "athlete", "raceSeries", "pointsCategory", "pointsOverall", "placeOverall", "placeCategory", "category"], "iiiiiiis", $inserts);
    return false;
}

function calcWSCScore($place) {
    if($place <= 10) {
        return 1000 - ($place - 1) * 10;
    }
    if($place <= 20) {
        return 906 - ($place - 11) * 4;
    }
    if($place <= 50) {
        return 868 - ($place - 21) * 2;
    }
    return max(0, 809 - ($place - 51));
}

function getRaceSeries($id) {
    $series  = query("SELECT * FROM TbRaceSeries WHERE idRaceSeries = ?;", "i", $id);
    if(sizeof($series) == 0) return [];
    $series = $series[0];
    // races
    $series["races"] = query("SELECT TbRace.*, comp.location, comp.type, comp.country, comp.name
    FROM TbRaceInSeries JOIN TbRace ON TbRace.id = TbRaceInSeries.race
    JOIN TbCompetition comp ON comp.idCompetition = TbRace.idCompetition
    WHERE raceSeries = ?
    ORDER BY comp.startDate ASC, TbRace.distance ASC, TbRace.gender DESC;", "i", $id);
    $races = [];
    foreach ($series["races"] as $race) {
        $races[$race["id"]] = $race;
    }
    // overall results
    $overallResults = query("SELECT SUM(CASE WHEN strikeResultCategory = 0 THEN pointsCategory ELSE 0 END) AS pointsCategory, SUM(CASE WHEN strikeResultOverall = 0 THEN pointsOverall ELSE 0 END) AS pointsOverall, TbAthlete.*, IFNULL(max(TbResult.category), max(TbRace.category)) as category
    FROM TbRaceSeriesPoints
    JOIN TbAthlete ON TbAthlete.id = TbRaceSeriesPoints.athlete
    JOIN TbResult ON TbResult.idRace = TbRaceSeriesPoints.race AND TbResult.idPerson = TbAthlete.id
    JOIN TbRace ON TbRace.id = TbRaceSeriesPoints.race
    WHERE TbRaceSeriesPoints.raceSeries = ?
    GROUP BY TbRaceSeriesPoints.athlete
    ORDER BY pointsOverall DESC, pointsCategory DESC;", "i", $id);
    $placeWomen = 1;
    $placeMen = 1;
    foreach ($overallResults as $overallResult) {
        $pointsOverall = $overallResult["pointsOverall"];
        $pointsCategory = $overallResult["pointsCategory"];
        $category = $overallResult["category"];
        unset($overallResult["pointsOverall"]);
        unset($overallResult["pointsOverall"]);
        unset($overallResult["category"]);
        $idAthlete = $overallResult["id"];
        $series["results"][$idAthlete]["athlete"] = $overallResult;
        $series["results"][$idAthlete]["pointsCategory"] = $pointsCategory;
        $series["results"][$idAthlete]["pointsOverall"] = $pointsOverall;
        $series["results"][$idAthlete]["placeOverall"] = strtolower($overallResult['gender']) === 'm' ? $placeMen++ : $placeWomen++;
        $series["results"][$idAthlete]["category"] = $category;
    }
    // individual race results
    $raceResults = query("SELECT athlete, pointsCategory, pointsOverall, strikeResultCategory, strikeResultOverall, race
    FROM TbRaceSeriesPoints
    WHERE raceSeries = ? ORDER BY race DESC;", "i", $id);
    foreach ($raceResults as $raceResult) {
        $race = $races[$raceResult["race"]];
        $raceName = $race["location"];
        if($raceResult["strikeResultOverall"]) {
            $series["results"][$raceResult["athlete"]]["$raceName Overall"] = '('.$raceResult["pointsOverall"].')';
        } else {
            $series["results"][$raceResult["athlete"]]["$raceName Overall"] = $raceResult["pointsOverall"];
        }
        if($raceResult["strikeResultCategory"]) {
            $series["results"][$raceResult["athlete"]]["$raceName Category"] = '('.$raceResult["pointsCategory"].')';
        } else {
            $series["results"][$raceResult["athlete"]]["$raceName Category"] = $raceResult["pointsCategory"];
        }
    }
    if(isset($series["results"])) {
        $series["results"] = array_values($series["results"]);
    }
    return $series;
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
    } else {
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
 * allowed: <string> Year,Team,Competition,Athlete,Country,User
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
    if(in_array("User", $allowed)) {
        // echo "moin";
        $users = query("CALL sp_searchUser(?);", "s", $name);
        foreach ($users as $user) {
            $image = defaultProfileImgPath("m");
            if($user["image"] != NULL) {
                $image = "/img/uploads/".$user["image"];
            }
            $results[] = [
                "id" => $user["iduser"],
                "name" => $user["username"],
                "priority" => 2,
                "type" => "user",
                "image" => $image
            ];
        }
    }
    $year = substr($name, 0, 4);
    $competition = NULL;
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
                    "date" => $competition["startDate"],
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
                        "date" => $competition["startDate"],
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
    // return $a["priority"] - $b["priority"];
    if ($a["priority"] == $b["priority"]) {
        if(isset($a["date"]) && !isset($b["priority"])) return 1;
        if(!isset($a["date"]) && isset($b["priority"])) return -1;
        if(!isset($a["date"]) && !isset($b["priority"])) return 0;
        return ($a["date"] < $b["date"]) ? -1 : 1;
    }
    return ($a["priority"] < $b["priority"]) ? -1 : 1;
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
                    "priority" => $person["priority"],
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