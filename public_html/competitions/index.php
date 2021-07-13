<?php
include_once "../header.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/api/index.php";

$comps = getAllCompetitions();

// print_r($comps[0]);

echoRandWallpaper();
?>
<main class="main competitions-page">

    <div class="top-site">
        <h1>Competitions</h1>
        <p>See all competitions</p>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <div class="comps">
        <?php
            if(sizeof($comps) > 0) {
                $year = 0;
                $begun = false;
                foreach($comps as $comp) {
                    if($comp["raceYearNum"] !== $year) {
                        $year = $comp["raceYearNum"];
                        if($begun) {
                            echo "</div>";
                        }
                        echoYear($year);
                        echo "<div class='comp-gallery'>";
                        $begun = true;
                    }
                    echoComp($comp);
                }
                echo "</div>";
            }

            function echoComp($comp) {
                $startDate = $comp["raceYearNum"];
                if($comp["startDate"] !== NULL) {
                    $startDate = date("M d Y", strtotime($comp["startDate"]));
                }
                $link = "/competition/index.php?id=".$comp["idCompetition"];
                $flag = "<img class='flag' alt='".$comp["country"]."' src='/img/countries/".strtolower($comp["alpha-2"]).".svg'>";
                echo "
                <a class='no-underline comp-link' href='$link'>
                    <div class='comp'>
                        <div class='left'>
                            $flag
                            <div class='name'>
                                ".translateCompType($comp["type"])." - ".$comp["location"]."
                            </div>
                            <div class='date'>
                                $startDate
                            </div>
                            <div class='location'>
                            ".$comp['country']."
                            </div>
                        </div>
                        <div class='right'>
                            <p>See More</p>
                        </div>
                    </div>
                </a>";
            }

            function echoYear($year) {
                echo "
                 <div class='year'>
                    <p class='year__num'>$year</p>
                </div>";
            }
        ?>
    </div>
</main>
<?php
include_once "../footer.php";
?>