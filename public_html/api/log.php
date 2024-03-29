<?php
if(!isset($_GET["uId"]) || !isset($_GET["currentPage"])) {
    echo "no";
    exit(0);
}

include_once $_SERVER["DOCUMENT_ROOT"]."/../data/dbh.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/api/userAPI.php";

$uId = $_GET["uId"];

$currentPage = $_GET["currentPage"];

$lastPage = NULL;
if(isset($_GET["lastPage"])) {
    $lastPage = $_GET["lastPage"];
}

$device = $_SERVER['HTTP_USER_AGENT'];

$ip = $_SERVER['REMOTE_ADDR'];

$ipInfo = ip_info($ip);
$loc = NULL;
if($ipInfo) {
    $loc = $ipInfo["country"].", ".$ipInfo["state"].", ".$ipInfo["city"];
}

$user = null;
if(isLoggedIn()) {
    $user = $_SESSION["iduser"];
}

$isMobile = "0";
if(isset($_GET["isMobile"])) {
    $isMobile = $_GET["isMobile"];
}


dbExecute("INSERT INTO `results`.`TbLog`
(`userId`,
`from`,
`to`,
`ip`,
`location`,
`device`,
`user`,
`isMobile`)
VALUES
(?,?,?,?,?,?,?,?);", "ssssssis", $uId, $lastPage, $currentPage, $ip, $loc, $device, $user, $isMobile);


function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}
