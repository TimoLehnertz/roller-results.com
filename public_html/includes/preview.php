<?php

include_once $_SERVER["DOCUMENT_ROOT"]."/api/index.php";

function getPreview() {
    $path = $_SERVER["REQUEST_URI"];
    if(strpos($path, "athlete")) {
        $id = $_GET["id"];
        // if(file_exists($_SERVER["DOCUMENT_ROOT"]."/img/previews/athletes/$id.jpg")) {
        //     return "/img/previews/atheles/$id.jpg";
        // } else {
            return makeAthletePreview($id);
        // }
    }

    return "https://www.roller-results.com/img/previews/logo.PNG";
    // return "/img/previews/logo.PNG";
}

/**
 * creates or overwrites the athletes preview's
 */
function makeAthletePreview($id) {
    $athlete = getAthlete($id);
    $bgFileName = $_SERVER["DOCUMENT_ROOT"]."/img/previews/athletes/bg.jpg";
    $previewFileName = $_SERVER["DOCUMENT_ROOT"]."/img/previews/athletes/$id.jpg";
    // copy($bgFileName, $previewFileName);
    // $img = imagecreatetruecolor(120, 20);
    $font = 5;
    // echo $bgFileName;
    $img = imagecreatefromjpeg($bgFileName);
    // $img = imagecreatetruecolor(100, 100);
    $bg = imagecolorallocate($img, 70, 60, 150);
    $textcolor = imagecolorallocate($img, 255, 255, 255);

    $fontFile = $_SERVER["DOCUMENT_ROOT"]."/fonts/win/CenturyGothic.ttf";
    $fontSizeName = 55;
    $fontSizeMEdal = 90;

    imagettftext($img, $fontSizeName, 0, 60, 100, $textcolor, $fontFile, $athlete["firstname"]);
    imagettftext($img, $fontSizeName, 0, 60, 175, $textcolor, $fontFile, $athlete["lastname"]);
    //medals
    imagettftext($img, $fontSizeMEdal, 0, 115, 328, $textcolor, $fontFile, $athlete["silver"]);
    imagettftext($img, $fontSizeMEdal, 0, 245, 348, $textcolor, $fontFile, $athlete["gold"]);
    imagettftext($img, $fontSizeMEdal, 0, 375, 372, $textcolor, $fontFile, $athlete["bronze"]);

    imagejpeg($img, $previewFileName);
    // return "/img/previews/athletes/$id.jpg";
    return "https://www.roller-results.com/img/previews/athletes/$id.jpg";
}