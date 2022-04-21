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
include_once $_SERVER["DOCUMENT_ROOT"]."/api/userAPI.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/includes/roles.php";
canI("managePermissions");

/**
 * setup
 */
$scoreInfluences = "WM,1,World Games,1,EM,0.2"; // @todo
$usedMedals = "WM,World Games";

/**
 * Getters
 */
if(!isset($NO_GET_API)){
    if(isset($_GET["scoreInfluences"])){
        $scoreInfluences = $_GET["scoreInfluences"];
    }
    if(isset($_GET["usedMedals"])){
        $usedMedals = $_GET["usedMedals"];
    }
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
    } else if(isset($_GET["getworldMovement"])){
        $res = getWorldMovement();
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
    }else if(isset($_GET["getcountryRacesFromCompetition"]) && isset($_GET["data"])){
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
    } else if(isset($_GET["getallAthletes"])){
        $res = getAllAthletes($scoreInfluences);
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getcountryCodes"])){
        $res = getCountryCodes();
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getallCompetitions"])){
        $res = getAllCompetitions();
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getallDistances"])){
        $res = getAllDistances();
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    } else if(isset($_GET["getcountryScores"])){
        $res = getCountryScores();
        if($res !== false){
            echo json_encode($res);
        } else{
            echo "error in api";
        }
    }else if(isset($_GET["gethallOfFame"])){
        // if(strlen($_GET["gethallOfFame"]) > 0){
            echo json_encode(getBestSkaters());
        // }
    } else if(isset($_GET["getathleteRacesFromCompetition"])){
        $id = intval($_GET["getathleteRacesFromCompetition"]);
        if(isset($_GET["data"])){
            $data = $_GET["data"];
            echo json_encode(getAthleteRacesFromCompetition($id, $data));
        } else{
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
    }
    else if(isset($_GET["getteamAdvantage"])){
        if(isset($_GET["data"]) && isset($_GET["data1"])) {
            echo json_encode(getTeamAdvantage($_GET["getteamAdvantage"], $_GET["data"], $_GET["data1"]));
        } else {
            echo("supply distance, maxplace and comps arguments!");
        }
    }
    else if(isset($_GET["uploadResults"])){
        $data = json_decode(file_get_contents('php://input'), true);
        var_dump($data);
        if(!isset($_GET["lname"]) || !isset($data["a"]) || !isset($data["d"]) || !isset($data["l"]) || !isset($_GET["user"])) {
            echo "invalid";
            exit(0);
        }
        insertLaserResult($data, $_GET["user"], $_GET["lname"]);
    }
    else if(isset($_GET["getteamAdvantageDetails"])){
        if(isset($_GET["data"]) && isset($_GET["data1"])) {
            echo json_encode(getTeamAdvantageDetails($_GET["getteamAdvantageDetails"], $_GET["data"], $_GET["data1"]));
        } else {
            echo("supply distance, maxplace and comps arguments!");
        }
    } else if(isset($_GET["getathletes"])) {
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
        $ids  = $_GET["ids"] ?? "."; // RLIKE
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
            deletAnalytics($name);
       } else {
           echo "You cant delete preset you dont own!";
       }
    } else if(isset($_GET["getanalytics"])) {
        echo json_encode(getAnalytics());
    }
    else if(isset($_GET["searchAthletes"])) {
        // var_dump(file_get_contents('php://input'));
        $athletes = json_decode(file_get_contents('php://input'), true);
        // print_r($athletes);
        echo json_encode(searchAthletes($athletes));
    } else if(isset($_GET["putAliases"])) {
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
                exit(0);
            }
            setRaceLinks($data);
        }
    }
    if(isset($_GET["setanalytics"]) && isset($_GET["name"])){
        if(!isLoggedIn()) {
            echo "you need to be logged in";
            exit(0);
        }
        $name = $_GET["name"];
        $json = file_get_contents('php://input');
        $public = isset($_GET["public"]) ? 1 : 0;
        if(analyticsExists($name)) {
            updateAnalytics($name, $public, $json);
        } else {
            addAnalytics($name, $public, $json);
        }
    }
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

function insertLaserResult($result, $user, $lasername) {
    $id = dbInsert("INSERT INTO TbLaserResults(distance,user,laserName,athlete)VALUES(?,?,?,?);", "iiss", $result["d"], $user, $lasername, $result["a"]);
    foreach ($result["l"] as $lap) {
        dbInsert("INSERT INTO TbLaserLap(triggerer,millis,laserResult)VALUES(?,?,?);", "iii", $lap["t"], $lap["ms"], $id);
    }
}

function getAliasGroups() {
    if(!isLoggedIn()) {
        return [];
    }
    // $res = query("SELECT aliasGroup, count(*) as `count` FROM TbAthleteAlias WHERE creator = ? GROUP BY aliasGroup;", "i", $_SESSION["iduser"]);
    $res = query("SELECT aliasGroup, count(*) as `count` FROM TbAthleteAlias GROUP BY aliasGroup;");
    // $out = [];
    // foreach ($res as $row) {
    //     $out []= $row["aliasGroup"];
    // }
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

function putAliases($aliases) {
    if(!canI("speaker")) {
        echo "You dont have permission to do that";
        return;
    }
    if(!isset($aliases["aliasGroup"]) || !isset($aliases["aliases"])) {
        echo "invalid parameters! please provide aliasGroup, aliases";
        return;
    }
    $creator = $_SESSION["iduser"];
    $res = query("SELECT * FROM TbAthleteAlias WHERE creator=? AND aliasGroup=?;", "is", $creator, $aliases["aliasGroup"]);
    if(sizeof($res) > 0) {
        echo "deleting old aliases";
        dbExecute("DELETE FROM TbAthleteAlias WHERE creator=? AND aliasGroup=?;", "is", $creator, $aliases["aliasGroup"]);
    }
    // echo "inserting";
    $sql = "INSERT INTO TbAthleteAlias(idAthlete, alias, creator, aliasGroup, previous) VALUES ";
    $delimiter = "";
    $fillers = [];
    $types = "";
    foreach($aliases["aliases"] as $alias) {
        if(isset($alias["idAthlete"])) {
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

function searchAthletes($athletes) {
    if($athletes == NULL) return [];
    $res = [];
    foreach ($athletes as $athlete) {
        $firstName = "";
        $lastName = "";
        $gender = "%";
        $country = "%";
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
        $result["result"] = query("CALL sp_searchAthlete(?,?,?,?);", "ssss", $firstName, $lastName, $gender, $country);
        $res[] = $result;
    }
    return $res;
}

function getAnalytics() {
    if(isLoggedIn()) {
        return query("SELECT * FROM Tb_analyticsPreset WHERE `owner`=? OR public=1;", "i", $_SESSION["iduser"]);
    } else {
        return query("SELECT * FROM Tb_analyticsPreset WHERE public=1;");
    }
}

function updateAnalytics($name, $public, $json) {
    if(isLoggedIn()) {
        query("UPDATE Tb_analyticsPreset SET `public`=?, `json`=? WHERE `name`=? AND `owner`=?;", "issi", $public, $json, $name, $_SESSION["iduser"]);
    }
}

function addAnalytics($name, $public, $json) {
    if(isLoggedIn()) {
        query("INSERT INTO Tb_analyticsPreset(`name`,`public`,`json`,`owner`) VALUES (?,?,?,?);", "sisi", $name, $public, $json, $_SESSION["iduser"]);
    }
}

function analyticsExists($name) {
    if(isLoggedIn()) {
        return sizeof(query("SELECT idAnalyticsPreset FROM Tb_analyticsPreset WHERE `name` = ? AND (owner = ? OR public = 1);", "si", $name, $_SESSION["iduser"])) > 0;
    } else {
        return sizeof(query("SELECT idAnalyticsPreset FROM Tb_analyticsPreset WHERE `name` = ? AND public = 1;", "s", $name)) > 0;
    }
}

function deleteSelectPreset($presetName) {
    if(!isLoggedIn()) {
        return;
    }
    query("DELETE FROM Tb_analyticsSelectPreset WHERE owner = ? AND name = ?;", "is", $_SESSION["iduser"], $presetName);
}

function deletAnalytics($name) {
    if(!isLoggedIn()) {
        return;
    }
    query("DELETE FROM Tb_analyticsPreset WHERE owner = ? AND name = ?;", "is", $_SESSION["iduser"], $name);
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

function getAllAthletes($influences){
    global $scoreInfluences;
    global $usedMedals;
    $res = query("CALL sp_athleteFull('%', ?´, ?);", "ss", $scoreInfluences, $usedMedals);
    // $res = query("SELECT * FROM vAthletePublic;");
    if(sizeof($res) > 0){
        return $res;
    } else{
        return [];
    }
}

function getCountryCareer($country){
    global $scoreInfluences;
    // $res = query("CALL sp_countryCareer(?, ?);", "ss", $country, $scoreInfluences);
    $res = query("CALL sp_countryCareerNew(?, ?);", "ss", $country, $scoreInfluences);
    if(sizeof($res) > 0){
        return $res;
    } else{
        return [];
    }
}

function getAthleteCareer($idAthlete){
    global $scoreInfluences;
    $res = query("CALL sp_athleteCareer(?, ?);", "is", $idAthlete, $scoreInfluences);
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
    global $scoreInfluences;
    global $usedMedals;
    // $result = query("CALL sp_athleteFull(?, ?, ?)", "iss", intval($id), $scoreInfluences, $usedMedals);
    $result = query("CALL sp_getAthleteNew(?, ?)", "is", intval($id), $usedMedals);
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

function getCompetition($id){
    // $result = query("SELECT * FROM vCompetition WHERE idCompetition = ?;", "i", intval($id));
    $result = query("CALL sp_getCompNew(?);", "i", intval($id));
    if(sizeof($result) > 0){
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

function getResult($id){
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

function getRaces(){
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
        $competitionName = $name;
        $competitions = query("CALL sp_searchCompetitionLocation(?)", "s", $competitionName);
        foreach ($competitions as $key => $competition) {
            $results[] = [
                "id" => $competition["idCompetition"],
                "name" => $competition["type"]." ".$competition["location"]." ".$competition["raceYear"],
                "priority" => 2,
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
                    "priority" => 1,
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
                    "priority" => 3,
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