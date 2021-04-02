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

?>
not in use
<a href="/index.php">Return home</a>