<?php

include_once "../api/index.php";

function getPreview() {
    $path = $_SERVER["REQUEST_URI"];
    if(strpos($path, "athlete")) {
        $id = $_GET["id"];
        // if(file_exists($_SERVER["DOCUMENT_ROOT"]."/img/previews/athletes/$id.jpg")) {
        //     return "/img/previews/atheles/$id.jpg";
        // } else {
            // return makeAthletePreview($id);
        // }
    }

    return "/img/previews/logo.PNG";
}

/**
 * creates or overwrites the athletes previews
 */
function makeAthletePreview($id) {
    $athlete = getAthlete($id);
    $bgFileName = $_SERVER["DOCUMENT_ROOT"]."/img/previews/athletes/bg.jpg";
    $previewFileName = $_SERVER["DOCUMENT_ROOT"]."/img/previews/athletes/$id.jpg";
    // copy($bgFileName, $previewFileName);
    // $img = imagecreatetruecolor(120, 20);
    $font = 5;
    $img = imagecreatefromjpeg($bgFileName);
    $bg = imagecolorallocate($img, 70, 60, 150);
    $textcolor = imagecolorallocate($img, 255, 255, 255);

    $fontFile = $_SERVER["DOCUMENT_ROOT"]."/fonts/win/sarcasti.ttf";
    $fontSize = 42;

    // imagettftext($img, $fontSize, 0, 11, 40, $textcolor, $fontFile, $athlete["fullname"]);
    // imagettftext($img, 20, 0, 11, 21, $textcolor, $fontFile, $athlete["fullname"]);

    imagejpeg($img, $previewFileName);
    return "/img/previews/athletes/$id.jpg";
}