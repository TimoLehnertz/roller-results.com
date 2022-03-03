<?php

include_once "../../includes/roles.php";

if(!canI("managePermissions")){
    header("location: /index.php");
    exit();
}

include_once "../../../data/dbh.php";

// $file = file_get_contents("https://raw.githubusercontent.com/lukes/ISO-3166-Countries-with-Regional-Codes/f3d559220372d99a2d5c13a213cf9c2bceb8c6d9/all/all.json");

// $countries = json_decode ($file, true);
// var_dump($countries);

// $sql = "INSERT INTO TbCountry VALUES ";
// $delimiter = "";
// $vals = [];
// $types = "";

// foreach($countries as $key => $country){
//     $sql .= "$delimiter (";
//     $delimiter1 = "";
//     foreach ($country as $key => $value) {
//         $sql .= "$delimiter1 ?";
//         $delimiter1 = ", ";
//         $vals[] = $value;
//         $types .= "s";
//     }
//     $sql .= ")";
//     $delimiter = ", ";
// }
// $sql .= ";";

// echo $sql;

// dbExecuteArr($sql, $types, $vals);



// $file = file_get_contents("https://gist.githubusercontent.com/tadast/8827699/raw/f5cac3d42d16b78348610fc4ec301e9234f82821/countries_codes_and_coordinates.csv");

// $handle = fopen("https://gist.githubusercontent.com/tadast/8827699/raw/f5cac3d42d16b78348610fc4ec301e9234f82821/countries_codes_and_coordinates.csv", "r");

// $header = fgetcsv($handle);
// // var_dump($header);

// $skip = true;

// $countries = [];
// while (($data = fgetcsv($handle)) !== FALSE) {
//     if($skip) {
//         $skip = false;
//         continue;
//     }
//     $countries []= [
//         "alpha-2" => $data[1],
//         "lat" => $data[4],
//         "lng" => $data[5],
//     ];
// }
// // print_r($countries);


// foreach($countries as $key => $country){
//     $sql = "UPDATE TbCountry set latitude = ?, longitude = ? WHERE `alpha-2` = ?;";
//     echo dbExecute($sql, "dds", $country["lat"], $country["lng"], $country["alpha-2"]);
//     // exit();
// }

// exit();
// $delimiter = "";
// $vals = [];
// $types = "";

// foreach($countries as $key => $country){
//     $sql .= "$delimiter (";
//     $delimiter1 = "";
//     foreach ($country as $key => $value) {
//         $sql .= "$delimiter1 ?";
//         $delimiter1 = ", ";
//         $vals[] = $value;
//         $types .= "s";
//     }
//     $sql .= ")";
//     $delimiter = ", ";
// }
// $sql .= ";";

// echo $sql;

// dbExecuteArr($sql, $types, $vals);

// $handle = fopen("https://gist.githubusercontent.com/tadast/8827699/raw/f5cac3d42d16b78348610fc4ec301e9234f82821/countries_codes_and_coordinates.csv", "r");

// $header = fgetcsv($handle);
// // var_dump($header);

// $skip = true;

// $countries = [];
// while (($data = fgetcsv($handle)) !== FALSE) {
//     if($skip) {
//         $skip = false;
//         continue;
//     }
//     $countries []= [
//         "alpha-2" => $data[1],
//         "lat" => $data[4],
//         "lng" => $data[5],
//     ];
// }
// // print_r($countries);


// foreach($countries as $key => $country){
//     $sql = "UPDATE TbCountry set latitude = ?, longitude = ? WHERE `alpha-2` = ?;";
//     echo dbExecute($sql, "dds", $country["lat"], $country["lng"], $country["alpha-2"]);
//     // exit();
// }

// $handle = file_get_contents("https://raw.githubusercontent.com/mledoze/countries/master/countries.json", "r");

// $json = json_decode($handle, true);
// // var_dump($json[0]);

// $skip = true;

// $countries = [];

// foreach ($json as $country) {
//     $test = [
//         "alpha-3" => "empty",
//         "area" => "empty",
//         "capital" => "empty",
//         "status" => "empty"
//     ];
//     $test["alpha-2"] = $country["cca2"];
//     $test["area"] = $country["area"];
//     $test["capital"] = $country["capital"][0];
//     $test["status"] = $country["status"];
//     $countries[] = $test;
// }

// print_r($countries);

// foreach($countries as $country){
//     $sql = "UPDATE TbCountry set area = ?, capital = ?, `status` = ? WHERE `alpha-2` = ?;";
//     echo dbExecute($sql, "isss", $country["area"], $country["capital"], $country["status"], $country["alpha-2"]);
//     // exit();
// }

// $handle = file_get_contents("http://www.spotland.fr/modules/blocklayered/blocklayered-ajax.php?layered_type_16=16&layered_type_11=11&id_category_layered=4&a=1&_=1617460558613", "r");

// $json = json_decode($handle, true);
// // var_dump($json);

// $places = [];

// foreach ($json["spots"] as $place) {
//     $test = [
//         "type" => "Track",
//         "latitude" => NULL,
//         "longitude" => NULL,
//         "image" => NULL,
//         "description" => NULL,
//         "date_creation_sportland" => NULL,
//         "title" => NULL,
//         "keywords" => NULL,
//         "city" => NULL,
//         "region" => NULL,
//         "country" => NULL,
//         "link_sportland" => NULL,
//         "surface" => "asphalt"
//     ];
//     $test["latitude"] = $place["latitude"];
//     $test["longitude"] = $place["longitude"];
//     $test["image"] = $place["img"];
//     $test["description"] = $place["description"];
//     $test["date_creation_sportland"] = $place["date_creation"];
//     $test["title"] = $place["nom"];
//     $test["keywords"] = $place["meta_keywords"];
//     $test["city"] = $place["ville_name"];
//     $test["region"] = $place["region_name"];
//     $test["country"] = $place["pays_name"];
//     $test["department"] = $place["departement_name"];
//     $test["link_sportland"] = $place["link"];

//     foreach ($place["features"] as $feature){
//         if($feature["name"] === "type ?") {
//             echo "found";
//             $test["surface"] = $feature["value"];
//         }
//     }
//     $places[] = $test;
// }

// print_r($places);

// foreach($places as $test) {
//     echo "insert<br>";
//     $sql = "INSERT INTO `results`.`TbPlaces`
//     (`type`,`latitude`,`longitude`,`image`,`description`,`date_creation_sportland`,`title`,`keywords`,`city`,`region`,`country`,`link_sportland`,`surface`)
//     VALUES
//     (?,?,?,?,?,?,?,?,?,?,?,?,?);";
//     var_dump(dbExecute($sql, "sddssssssssss", $test["type"], $test["latitude"], $test["longitude"], $test["image"], $test["description"], $test["date_creation_sportland"], $test["title"], $test["keywords"], $test["city"], $test["region"], $test["country"], $test["link_sportland"], $test["surface"]));
//     // exit();
// }

// Start
// $handle = file_get_contents("https://gist.githubusercontent.com/mjoyce91/2eab2a932c57e010cceddcf9c8957ff8/raw/9f9c10abc895721179402c67c9a27ec2d319ffe1/country-colors.json", "r");
// $handle = preg_replace('/^.+\n/', '', $handle);
// var_dump($handle);

// $json = json_decode($handle, true);

// $countries = [];

// foreach ($json as $country) {
//     $countries[] = [
//         "name" => $country["name"],
//         "color" => $country["colors"][sizeof($country["colors"]) - 1]
//     ];
// }

// print_r($countries);

// foreach($countries as $country) {
//     $sql = "UPDATE `results`.`TbCountry` SET color = ? WHERE `name` = ?;";
//     var_dump(dbExecute($sql, "ss", $country["color"], $country["name"]));
// }

?>
not in use
<a href="/index.php">Return home</a>