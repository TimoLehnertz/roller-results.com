<?php
include_once "../includes/error.php";
/**
 * Setup
 */
if(!isset($_GET["id"])){
    throwError($ERROR_NO_ID);
}
include_once "../api/index.php";

$idComp = $_GET["id"];
$comp = getCompetition($idComp);
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

$bestAthletes = getCompAthleteMedals($idComp);
$bestCountries = getCompCountryMedals($idComp);

$bestCountry = $bestCountries[0]["country"];
$bestAthlete = $bestAthletes[0]["fullname"];
$bestAthleteId = $bestAthletes[0]["idAthlete"];

$athleteCount = sizeof($bestAthletes);
$countryCount = sizeof($bestCountries);

$femaleCount = 0;
$maleCount = 0;

foreach ($bestAthletes as $athlete) {
    if($athlete["gender"] == "w" || $athlete["gender"] == "W") {
        $femaleCount++;
    } else {
        $maleCount++;
    }
}

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
        <div class="basic-stats">
            <div>Countries: <div class="stat"><?=$countryCount?></div></div>
            <div>Athletes: <div class="stat"><?=$athleteCount?></div></div>
            <div>Female: <div class="stat"><?=$femaleCount?></div></div>
            <div>Male:  <div class="stat"><?=$maleCount?></div></div>
            <div>Best Country: <a href="/country/?id=<?=$bestCountry?>"><?=$bestCountry?></a></div>
            <div>Best Athlete: <a href="/athlete/?id=<?=$bestAthleteId?>"><?=$bestAthlete?></a></div>
            <a href="#medals">See more</a>
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
        <div class="stats">
            <h2 class="races">Statistics</h2>
            <div class="medal-stats" id="medals">
                <div class="countries">
                    <h3 class="align center">Countries</h3>
                    <table>
                        <tr><td>Position</td><td>Country</td><td class="goldm"></td><td class="silverm"></td><td class="bronzem"></td><td>Points</td></tr>
                        <?php
                            $i = 1;
                            foreach ($bestCountries as $country) {
                                $countryName = $country["country"];
                                $bronze = $country["bronze"];
                                $silver = $country["silver"];
                                $gold = $country["gold"];
                                $total = $country["medalScore"];
                                if(!$total) {
                                    break;
                                }
                                echo "<tr><td>$i</td><td><a href='/country/?id=$countryName'>$countryName</td><td>$gold</td><td>$silver</td><td>$bronze</td><td>$total</td></tr>";
                                $i++;
                            }
                        ?>
                    </table>
                </div>
                <div class="athletes">
                    <h3 class="align center">Athletes</h3>
                    <table>
                        <tr><td>Position</td><td>Athlete</td><td class="goldm"></td><td class="silverm"></td><td class="bronzem"></td><td>Points</td></tr>
                        <?php
                            $i = 1;
                            foreach ($bestAthletes as $athlete) {
                                $athleteName = $athlete["fullname"];
                                $athleteId = $athlete["idAthlete"];
                                $bronze = $athlete["bronze"];
                                $silver = $athlete["silver"];
                                $gold = $athlete["gold"];
                                $total = $athlete["medalScore"];
                                if(!$total) {
                                    break;
                                }
                                echo "<tr><td>$i</td><td><a href='/athlete/?id=$athleteId'>$athleteName</td><td>$gold</td><td>$silver</td><td>$bronze</td><td>$total</td></tr>";
                                $i++;
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <script>
            
            
            $(".bronzem").each(function() {
                $(this).append(getMedal("bronze", 3, false));
            });
            $(".silverm").each(function() {
                $(this).append(getMedal("silver", 2, false));
            });
            $(".goldm").each(function() {
                $(this).append(getMedal("gold", 1, false));
            });
            
            console.log(comp);
            comp.races.filter(race => race.resultCount > 0);
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
                    trackStreet: {},
                    link: {
                        callback: (link) => getYtVideoElems(link),
                        displayName: "Videos",
                        allowSort: false
                    },
                }
            });
            table.init();
        </script>
    </div>
</main>
<?php
include_once "../footer.php";
?>