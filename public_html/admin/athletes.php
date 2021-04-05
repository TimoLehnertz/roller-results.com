<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/includes/error.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/includes/roles.php";

if(!canI("configureAthletes")){
    throwError($ERROR_NO_PERMISSION, "/admin/index.php");
    // echo "nopermission";
} 

$NO_GET_API = true;
include_once $_SERVER["DOCUMENT_ROOT"]."/api/index.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/api/personAPI.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/api/imgAPI.php";

$search = "";
if(!empty($_GET["search-athlete"])){
    $search = $_GET["search-athlete"];
}

$changeable = [
    "lastname" => "text",
    "firstname" => "text",
    "gender" => "text",
    "country" => "text",
    "mail" => "text",
    "comment" => "text",
    "club" => "text",
    "team" => "text",
    "image" => "file",
    "birthYear" => "number",
    "LVKuerzel" => "text",
    "source" => "text",
    "instagram" => "text",
    "facebook" => "text"
];

if(isset($_POST["submit-changes"])){
    if(isset($_GET["idperson"])){
        $idperson = intval($_GET["idperson"]);
        $name = $_POST["firstname"]. "-" . $_POST["lastname"];
        if(isset($_FILES["image"])){
            $img = uploadImg($_FILES["image"], "athlete-$name-");
            if($img) {
                $_POST["image"] = $img;
            } else {
                unset($_FILES["image"]);
                echo "<script>alert('Image is not supported. maximum size is 5mb')</script>";
            }
        }
        $person = [];
        foreach ($changeable as $prop => $value) {
            if(!empty($_POST[$prop])){
                $person[$prop] = $_POST[$prop];
            } else{
                $person[$prop] = "";
            }
        }
        if(updatePerson($idperson, $person)){
            header("location: /admin/athletes.php?idperson=$idperson&search-athlete=$search");
            exit();
        } else{
            throwError($ERROR_SERVER_ERROR, "/admin/athletes.php");
        }
    }
}

include_once $_SERVER["DOCUMENT_ROOT"]."/header.php";

?>
<main class="main">
    <h1>Configure athletes</h1>
    <form action="#" method="GET">
        <input type="text" placeholder="Search" name="search-athlete" value="<?=$search?>">
        <button type="submit" name="submit-search" class="btn default slide">Search</button>
    </form>
    <?php
    if(isset($_GET["submit-search"]) && !empty($_GET["search-athlete"])){
        $search = $_GET["search-athlete"];
        echo "<h2>Search results:</h2>";
        foreach (searchPersons($search) as $key => $person) {
            $name = $person["name"];
            $idperson = $person["id"];
            echo "<a href='/admin/athletes.php?idperson=$idperson&search-athlete=$search'>$name</a><br>";
        }
    }
    if(isset($_GET["idperson"])){
        $idperson = $_GET["idperson"];
        $person = getAthleteFull($idperson);
        echo "<form action='#' enctype='multipart/form-data' method='POST'><table>";
            foreach ($changeable as $prop => $type) {
                $value = $person[$prop];
                echo "<tr><td>$prop</td>";
                $image = "";
                if($prop === "image"){
                    $image = "<img height='40px' src='/img/uploads/$value'>";
                }
                echo "<td>$image<input type='$type' name='$prop' placeholder='$prop' value='$value' max-size='200'></td></tr>";
            }
            echo "</table>";
            echo "<button class='btn slide default' type='submit' name='submit-changes'>Submit changes</button>";
        echo "</form>";
    }
    ?>
</main>
<?php
include_once "../footer.php";
?>