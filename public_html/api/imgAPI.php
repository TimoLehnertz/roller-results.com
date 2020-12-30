<?php

$IMG_ALLOWED_FILE_EXTENSIONS = [
    "png", "svg", "jpg", "tiff", "jpeg", ""
];
$IMG_MAX_SIZE = 500000;

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