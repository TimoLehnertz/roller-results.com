<?php
include_once "../includes/error.php";
/**
 * Setup
 */
if(!isset($_GET["id"])){
    throwError($ERROR_NO_ID);
}
include_once "../api/index.php";

$race = getRace($_GET["id"]);
if(!$race){
    throwError($ERROR_INVALID_ID);
}

include_once "../header.php";

echo "<script>const race = ". json_encode($race) .";</script>";

?>
<main class="main">
    <h2>Race <?php echo $race["location"]." ".$race["raceyear"]." ".$race["distance"]." ".$race["gender"]?></h2>
    <div class="person-table"></div>
    <script>
        const table = new Table($(".person-table"), resultsTotable(race.results));
        console.log(resultsTotable(race.results));
        table.setup({
            orderBy: {column: "place", up: true}
        });
        table.init();
    </script>
</main>
<?php
include_once "../footer.php";//s
?>