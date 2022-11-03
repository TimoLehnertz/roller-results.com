<?php

// include_once $_SERVER["DOCUMENT_ROOT"]."/includes/resize-class.php";

$IMG_ALLOWED_FILE_EXTENSIONS = [
    "png", "jpg", "gif", "jpeg"
];
$IMG_MAX_SIZE = 5000000;

function resize_image($file, $w, $h) {
    // $resizeObj = new resize($file);
    // $resizeObj -> resizeImage($w, $h, 'crop');
    // $resizeObj -> saveImage($file, 100);
    // echo $dest;
    // WideImage::load($file)
    // ->resize($w, h, 'outside', 'any')
    // ->crop('center', 'center', $w, $h)
    // ->output('png');
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
    $dest = $_SERVER["DOCUMENT_ROOT"].'/img/uploads/' . $nameNew;
    $succsess = move_uploaded_file($tmp, $dest);
    
    /**
     * resize
     */
    resize_image($dest, 100, 100);
    

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
    if(!$gender) return "/img/profile-men.png";
    if(strtolower($gender) == "w"){
        return "/img/profile-female.jpg";
    } else{
        return "/img/profile-men.png";
    }
}

function echoRandWallpaper(){
    $files = glob($_SERVER["DOCUMENT_ROOT"]."/img/rand-wallpaper/" . '/*.*');
    $file = $files[array_rand($files)];
    echo("<div class='rand-wallpaper'><img alt='random wallpaper' src='/img/rand-wallpaper/".basename($file)."'></div>");
}