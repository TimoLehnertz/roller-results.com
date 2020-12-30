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

$person = getPerson($_GET["id"]);
if(!$person){
    throwError($ERROR_INVALID_ID);
}

include_once "../header.php";

echo "<script>const person = [". json_encode($person) ."];</script>";
?>
<main class="main">
    <div class="athlete-head">
        <?php
            echo echoAthleteImg($person);
        ?>
        <div>
            <h2>Athlete <?php echo $person["firstName"]." ".$person["sureName"]?></h2>
            <p><?php echo $person["country"]?></p>
            <p><?php echo $person["gender"]?></p>
        </div>
    </div>
    
</main>
<?php
include_once "../footer.php";
?>