<?php 

$dir = $_SERVER["DOCUMENT_ROOT"]."/".$_GET['path'];

$newWidth = 50;
if(isset($_GET["size"])) {
    $newWidth = intval($_GET["size"]);
}

header('Content-type: image/jpeg');

list($width, $height) = getimagesize($dir);

$newHeight = (int) ($newWidth * ($height / $width));

$create = imagecreatetruecolor($newWidth, $newHeight); 
$img = imagecreatefromjpeg($dir); 


imagecopyresized($create, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

imagejpeg($create, null, 100);

?>