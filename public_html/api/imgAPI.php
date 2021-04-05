<?php

$IMG_ALLOWED_FILE_EXTENSIONS = [
    "png", "svg", "jpg", "tiff", "jpeg", ""
];
$IMG_MAX_SIZE = 5000000;

function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h; 
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}

function uploadImg($file, $prefix = ""){
    global $IMG_ALLOWED_FILE_EXTENSIONS;
    global $IMG_MAX_SIZE;
    $name = $file["name"];
    $tmp = $file["tmp_name"];
    $size = $file["size"];
    $error = $file["error"];

    $ext = explode(".", $name);
    $ext = strtolower(end($ext));

    if($error !== 0){
        return false;
    }
    if(!in_array($ext, $IMG_ALLOWED_FILE_EXTENSIONS)){
        return false;
    }
    if($size > $IMG_MAX_SIZE){
        return false;
    }
    $nameNew = $prefix . uniqid('', true) . '.' . $ext;
    $dest = '../img/uploads/' . $nameNew;
    $succsess = move_uploaded_file($tmp, $dest);
    // resize_image($dest, 100, 100);
    if($succsess){
        return $nameNew;
    }
    return false;
}

function deleteImg($name){
    $file = "../img/uploads/$name";
    if(file_exists($file)){
        unlink($file);
        return true;
    }
    return false;
}

function echoAthleteImg($athlete){
    $name = $athlete["image"];
    $file = "../img/uploads/$name";
    $src = "/img/uploads/$name";
    if(empty($name) || file_exists($src)){
        $src = defaultProfileImgPath($athlete["gender"]);
    }
    echo "<img class='img athlete-img' src='$src' alt='profile image'>";
}

function defaultProfileImgPath($gender){
    if(strtolower($gender) == "m"){
        return "/img/profile-men.png";
    } else{
        return "/img/profile-female.jpg";
    }
}

function echoRandWallpaper(){
    $files = glob($_SERVER["DOCUMENT_ROOT"]."/img/rand-wallpaper/" . '/*.*');
    $file = $files[array_rand($files)];
    echo("<div class='rand-wallpaper'><img alt='random wallpaper' src='/img/rand-wallpaper/".basename($file)."'></div>");
}