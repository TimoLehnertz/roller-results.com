<?php
include_once "../header.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/api/index.php";

$times = getAllTimes();

echoRandWallpaper();
?>
<main class="main competitions-page">

    <div class="top-site">
        
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <div class="comps">
        <h1 class="align center font color gray size biggest">Saved times</h1>
        <p class="align center font color gray size big">See all your trainings times</p>
        <br>
        <br>
        <hr>
        <table class="data-table">
            <tr class="data-table__head"><td>#</td><td>Upload date</td><td>Time</td></tr>
        <?php
            if(sizeof($times) > 0) {
                $year = 0;
                $begun = false;
                $i = 1;
                foreach($times as $time) {
                    $t = msToTime($time["time"]);
                    $uploadDate = explode(" ", $time["uploadDate"])[0];
                    $uploadDate = $time["uploadDate"];
                    $zebra = $i % 2 == 0 ? "zebra" : "";
                    echo "<tr class='data-table__body $zebra'><td>$i</td><td>$uploadDate</td><td>$t</td>";
                    echo "</tr>";
                    $i++;
                }
            }

            function msToTime($ms) {
                $seconds = (int) ($ms / 1000);
                $millis = $ms % 1000;
                if($millis < 10) {
                    $millis = "00".$millis;
                } else if($millis < 100) {
                    $millis = "0".$millis;
                }
                return "$seconds:$millis";
            }

            function echoTime($time) {
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
        </table>
    </div>
</main>
<?php
include_once "../footer.php";
?>