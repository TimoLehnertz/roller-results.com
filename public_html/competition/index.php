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

$date = $comp["raceYearNum"];
if($comp["startDate"] !== NULL) {
    $date = date("M d Y", strtotime($comp["startDate"]));
}
if($comp["endDate"] !== NULL) {
    $date .= " - ".date("M d Y", strtotime($comp["endDate"]));
}
$lat = $comp["latitude"];
$lng = $comp["longitude"];

echo "<script>const comp = ". json_encode($comp) .";</script>";
echoRandWallpaper();

// print_r($comp);
$mapsKey = "AIzaSyAZriMrsCFOsEEAKcRLxdtI6V8b9Fbfd-c";

?>
<main class="main competition-page">
    <div class="top-site">
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <div class="content">
        <h1 class="align center"><?= translateCompType($comp["type"])." | ".$comp["location"]." ".$comp["raceYear"]?></h1>
        <div class="date">
            <i class="fas fa-calendar-alt margin right"></i><?= $date?>
        </div>
        <div class="location">
            <iframe class="maps"
                width="1920"
                height="1000"
                frameborder="0" style="border:0"
                src="<?="https://www.google.com/maps/embed/v1/place?key=$mapsKey&q=$lat,$lng&zoom=5";?>"
                allowfullscreen>
            </iframe>
        </div>
        <h2 class="races">Races</h2>
        <div class="races-table alignment center"></div>
        <script>
            const table = new Table($(".races-table"), comp.races);
            let orderBy = {column: "distance", up: true};
            if(findGetParameter("trackStreet") !== null){
                orderBy = {column: "trackStreet", up: findGetParameter("trackStreet") === "Road"};
            }
            

            table.setup({
                rowLink: row => `/race?id=${row.idRace}`,
                orderBy,
                layout: {
                    distance: {
                        // allowSort: false
                    },
                    category: {},
                    gender: {},
                    trackStreet: {}
                }
            });
            table.init();
        </script>
    </div>
</main>
<?php
include_once "../footer.php";
?>