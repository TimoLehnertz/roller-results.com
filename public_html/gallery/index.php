<?php
// include_once "../includes/roles.php";
// include_once "../includes/error.php";
include_once "../api/index.php";
include_once "../header.php";
echoRandWallpaper();



$pathFromRoot = "/gallery/nas-share";

$path = $_SERVER["DOCUMENT_ROOT"].$pathFromRoot;
$relativePath = ""; // relative path from gallery
if(isset($_GET["path"])) {
    $relativePath = str_replace("../", "", $_GET["path"]);
    $relativePath = str_replace("\\", "", $relativePath);
    $path = $_SERVER["DOCUMENT_ROOT"].$pathFromRoot."/".$relativePath;
    if(!file_exists($path)) {
        $path = $_SERVER["DOCUMENT_ROOT"].$pathFromRoot;
        $relativePath = ""; // relative path from gallery
    }
}
$backPath = dirname($relativePath);
?>
<div class="absolute">
    <div class="img-display"></div>
</div>
<main class="main competition-page analytics race-flow">
    <div class="top-site"></div>
    <svg style="margin-bottom: 0; position: relative; transform: translateY(85%); z-index: -1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <svg style="margin-bottom: 0; position: relative; top: 0px; z-index: 1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#151515"></path></svg>
    <div class="dark section no-shadow">
        <h1 class="font size biggest">Gallery<i class="fa fa-solid fa-images margin right"></i></h1>
        <p class="align center font size big color light margin top double">
            Image gallery for races - <span class="font color orange">Beta release</span>
        </p>
    </div>
    <div class="path margin bottom" id="files">
        <a href="/gallery#files">Gallery</a>
        <span class="delimiter margin left right half">></span>
        <?php
            $folders = explode("/", $relativePath);
            $tmpPath = "";
            $i = 0;
            foreach ($folders as $folder) {
                $i++;
                if($folder == "." || strlen($folder) == 0) continue;
                $tmpPath .= "/".$folder;
                if($i < sizeof($folders)) {
                    echo "<a href='/gallery?path=$tmpPath'>$folder</a>";
                } else {
                    echo "<span>$folder</span>";
                }
                if($i < sizeof($folders)) {
                    echo "<span class='delimiter margin left right half'>></span>";
                }
            }
        ?>
    </div>
    <div class="light section files">
        <a class="folder" href='/gallery?path=<?=$backPath ?>#files'>Back</a>
        <?php
            $imgFiles = [];
            if(file_exists($path)) {
                $dir = scandir($path);
                foreach ($dir as $file) {
                    $filePath = $path."/".$file;
                    if(!file_exists($filePath)) continue;
                    $pathinfo = pathinfo($filePath);
                    $name = $pathinfo["filename"];
                    if($name === "."  || $name == "#recycle" || strlen($name) == 0) continue;
                    if(is_dir($filePath)) {
                        echo "<a class='folder' href='/gallery?path=".$relativePath."/".$name."#files'><i class='fa fa-solid fa-folder'></i>$name</a>";
                    }
                }
                foreach ($dir as $file) {
                    $filePath = $path."/".$file;
                    if(!file_exists($filePath)) continue;
                    $pathinfo = pathinfo($filePath);
                    $isDir = is_dir($filePath);
                    $name = $pathinfo["filename"];
                    $extension = "";
                    if(isset($pathinfo["extension"])) {
                        $extension = $pathinfo["extension"];
                    }
                    $allowedExtensions = ["JPG", "PNG", "jpg"];
                    if($isDir) continue;
                    if(!in_array($extension, $allowedExtensions)) continue;
                    echo "<button class='btn no-style file' onclick='showImage(\"$file\", true)'><i class='fa fa-solid fa-image'></i>$name</button>";
                    $imgFiles []= $file;
                }
            }
        ?>
    </div>
</main>
<script>
<?php
    echo "const images = ".json_encode($imgFiles).";";
    echo "const relativePath = \"$relativePath\";";
    $isLogged = isLoggedIn() ? "true" : "false";
    echo "const isLoggedIn = $isLogged;";
    if($isLogged) {
        echo "const iduser = ".$_SESSION["iduser"].";";
    }
?>

let current = "";

let lastUid;

$(() => {
    $(".img-display").append(`<button class="next" onclick="next()"><i class="fa fa-solid fa-angle-right"></i></button>`);
    $(".img-display").append(`<button class="prev" onclick="prev()"><i class="fa fa-solid fa-angle-left"></i></button>`);
    $(".img-display").append(`<div class="name"></div>`);
    $(".img-display").append(`<button class="close-btn" onclick="hideImage()"><i class="fa fa-solid fa-circle-xmark"></i>X</button>`);
    $(".img-display").append(`<button class="toggle-persons" onclick="showPersons()"><i class="fa fa-solid fa-user margin right"></i>Persons <span class="person-amount"></span></button>`);
    $(".img-display").append(`<div class="persons">
        <button class="btn no-style close-persons-btn" onclick="hidePersons()">X</button>
        <p>Who is on this image?</p>
        <div class="person-array flex column align-start"></div>
        <div class="add-athlete-search"></div>
    </div>`);

    const searchBar = new SearchBarSmall(["Athlete"], false, (option) => {
        addPerson(option.id, option.name);
    });
    $(".add-athlete-search").append(searchBar.elem);
});

function addPerson(id, name) {
    $(".error").remove();
    if(currentimgPath == undefined) return;
    get("putAthleteImage", currentimgPath, id).receive((succsess, res) => {
        if(!succsess || !res) return $(".person-array").append(`<p class="error font color red">An error occoured. Does he/she exist already on this image? Please try again</p>`);
        updatePersons();
    });
}

let currentimgPath = undefined;

function showImage(image, first) {
    console.log(image);
    current = image;
    const path = relativePath + "/" + image;
    lastUid = getUid();
    if(first) {
        $(".img-display img").remove();
    }
    currentimgPath = `/gallery/nas-share/${relativePath}/${image}`;
    $(".name").text(image)
    $(".img-display").prepend(`<img id="${lastUid}" onclick="hidePersons()" src="${currentimgPath}">`);
    $(".img-display").addClass("visible");
    $(".person-array").empty();
    updatePersons();
}

function updatePersons() {
    $(".person-array").empty();
    get("imgAthletes", currentimgPath).receive((succsess, athletes) => {
        if(!succsess) return $(".person-array").append(`<p class="font color red">An error occoured while fetching image athletes</p>`);
        if(athletes.length == 0) {
            $(".person-amount").text("");
        } else {
            $(".person-amount").text(`(${athletes.length})`);
        }
        for (const athlete of athletes) {
            const athleteElem = $(`<div><a href="/athlete?id=${athlete.athlete}">${athlete.firstname} ${athlete.lastname}</a></div>`);
            if(isLoggedIn && iduser == athlete.creator) {
                athleteElem.append(`<button onclick="removeAthleteImage(${athlete.athlete});" class="btn blender alone margin left font code color white">X</button>`);
            }
            $(".person-array").append(athleteElem);
        }
    });
}

function removeAthleteImage(idAthlete) {
    $(".error").remove();
    if(currentimgPath == undefined) return;
    get("removeAthleteImage", currentimgPath, idAthlete).receive((succsess, res) => {
        if(!succsess || !res) $(".person-array").append(`<p class="error font color red">An error occoured</p>`);
        updatePersons();
    });
}

function showPersons() {
    $(".persons").addClass("visible");
}

function hidePersons() {
    $(".persons").removeClass("visible");
}

function next() {
    const removal = $("#" + lastUid);
    for (let i = 0; i < images.length; i++) {
        if(images[i] == current && i < images.length - 1) {
            showImage(images[i + 1]);
            removal.addClass("vanish-to-left");
            window.setTimeout(() => {
                removal.remove();
            }, 500);
            return;
        }
    }
}

function prev() {
    const removal = $("#" + lastUid);
    for (let i = images.length - 1; i >= 0; i--) {
        if(images[i] == current && i >= 1) {
            showImage(images[i - 1]);
            console.log("go")
            removal.addClass("vanish-to-right");
            window.setTimeout(() => {
                removal.remove();
            }, 500);
            return;
        }
    }
}

function hideImage() {
    $(".img-display").removeClass("visible");
}

$(".img-display").click((e) => e.stopPropagation());

// $("main").click((e) => $(".img-display").removeClass("visible"));
</script>
<?php
include_once "../footer.php";
?>