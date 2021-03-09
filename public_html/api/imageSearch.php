<?php
if(!isset($_GET["q"])){
    exit(0);
}
$q = $_GET["q"];
if(strlen($q) === 0){
    exit(0);
}

$q = str_replace(" ", "+", $q);
/**
 * valid
 */
$res =  file_get_contents("https://www.google.com/search?q=$q");

// $pos = strpos($res, '/search?q=');

echo $res;

// $url = "";

// $url = substr($res, $pos, 100);


// echo $url;

// $goon = true;
// $i = $pos;
// while($goon){
//     // if(char_at($i, $res) !=)
//     $i++;
// }