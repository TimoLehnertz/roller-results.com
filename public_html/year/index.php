<?php
include_once "../includes/error.php";
/**
 * Setup
 */
if(!isset($_GET["id"])){
    throwError($ERROR_NO_ID);
}
include_once "../api/index.php";
include_once "../api/imgAPI.php";

$comps = getYearCompetitions($_GET["id"]);
$year = $_GET["id"];
if(!$comps){
    throwError($ERROR_INVALID_ID);
}

include_once "../header.php";
// echo "<script>const person = ". json_encode($person) .";</script>";
?>
<main class="main">
    <h1 class="align center margin top double font size bigger">Competitions in <?=$year?></h1>
    <div class="display flex column">
    <?php
        foreach ($comps as $key => $comp) {
            echo "<a class='font size big margin top double' href='/competition?id=".$comp["idCompetition"]."'>";
            echo  $comp["type"] . " " . $comp["location"] . " ". $comp["raceYear"];
            echo "</a>";
        }
    ?>
    </div>
</main>
<?php
include_once "../footer.php";
?>