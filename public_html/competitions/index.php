<?php
include_once "../header.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/api/index.php";

$comps = getAllCompetitions();

print_r($comps[0]);

echoRandWallpaper();
?>
<main class="main competitionss-page">

    <div class="top-site">
        <h1>Competitions</h1>
        <p>See all competitions</p>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <div class="comps">
        <?php
            if(sizeof($comps) > 0) {
                $year = $comps[0]->raceYearNum;
            }

            function echoComp($comp) {
                $link = "/competition/index.php?id=$comp->idCompetition";
                echo "
                <div class='comp'>
                <div class='left'>
                    <div class='name'>
                        $comp->location
                    </div>
                    <div class='type'>
                        $comp->type
                    </div>
                    <div class='location'>
                        $comp->location
                    </div>
                </div>
                <a class='no-underline right' href='$link'>
                    <p>See More</p>
                </a>
            </div>";
            }

            function echoYear($year) {
                echo "
                 <div class='year'>
                    <p class='year__num'>$year</p>
                </div>";
            }
        ?>


        <div class="year">
            <p class="year__num">2019</p>
        </div>
        <div class="comp-gallery">
            <div class="comp">
                <div class="left">
                    <div class="name">
                        Barcelona
                    </div>
                    <div class="type">
                        Worlds
                    </div>
                    <div class="location">
                        Barcelona, Espana
                    </div>
                </div>
                <a class="no-underline right" href="#">
                    <p>See More</p>
                </a>
            </div>
        </div>
    </div>
</main>
<?php
include_once "../footer.php";
?>