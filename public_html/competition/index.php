<?php
include_once "../includes/error.php";
/**
 * Setup
 */
if(!isset($_GET["id"])){
    throwError($ERROR_NO_ID);
}
include_once "../api/index.php";

$comp = getCompetition($_GET["id"]);
if(!$comp){
    throwError($ERROR_INVALID_ID);
}

include_once "../header.php";

echo "<script>const comp = [". json_encode($comp) ."];</script>";

?>
<main class="main">
    <h2>Competition <?php echo $comp["location"]." ".$comp["raceyear"]?></h2>
    <div class="person-table"></div>
    <script>
        const table = new Table($(".person-table"), comp);
    </script>
</main>
<?php
include_once "../footer.php";
?>