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

echo "<script>const comp = ". json_encode($comp) .";</script>";

?>
<main class="main">
    <h2><?= $comp["location"]." ".$comp["raceYear"]?></h2>
    <div class="races-table"></div>
    <script>
        console.log(comp)
        const table = new Table($(".races-table"), comp.races);
        table.setup({
            rowLink: row => `/race?id=${row.id}`,
            orderBy: {column: "distance", up: true},
            layout: {
                distance: {
                    allowSort: false
                },
                category: {},
                gender: {},
                trackStreet: {}
            }
        })
        table.init();
    </script>
</main>
<?php
include_once "../footer.php";
?>