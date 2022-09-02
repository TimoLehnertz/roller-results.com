<?php
include_once "../header.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/api/index.php";

$comps = getAllCompetitions();

echoRandWallpaper();
?>
<main class="main competitions-page">

    <div class="top-site">
        
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <div class="comps">
        <h1 class="align center font color gray size biggest">Competitions</h1>
        <p class="align center font color gray size big">See all competitions</p>
        <br>
        <div>
            <button class="btn blender left" onclick="checkAll(true)">Show all</button>
            <button class="btn blender right" onclick="checkAll(false)">Hide all</button>
        </div>
        <br>
        <div class="filters font color black grid four mobile-two gap padding left right">
        </div>
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
                        echo "<div class='comp-gallery' id='".$year."'>";
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
                <a class='no-underline comp-link ".str_replace(" ", "-", translateCompType($comp["type"]))."' href='$link'>
                    <div class='comp'>
                        <div class='left'>
                            $flag
                            <div class='name'>
                                ".translateCompType($comp["type"])." - ".$comp["location"].($comp["checked"] != "1" ? " <span class='font color orange'>(unchecked)</span>" : "")."
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
<script>
    if(window.location.href.includes("#")) {
        const idx = window.location.href.indexOf("#") + 1;
        if(window.location.href.length >= idx + 4) {
            const year = window.location.href.substring(idx, idx + 4);
            console.log(year);
            $(() => {
                window.setTimeout(() => {
                    document.getElementById(year + "").scrollIntoView({
                        behavior: "smooth",
                        block:    "start",
                        // inline:    "start" | "center" | "end" | "nearest",
                    });
                }, 500);
            })
            // $("#" + year).;
        }
    }

    const types = [];

    function checkAll(checked) {
        $(".show-check").prop("checked", checked)
        $(`.comp-link`).css("display", checked ? "block" : "none");
    }

    $(() => {
        $(".comp-link").each(function() {
            const type = $(this).attr('class').split(' ')[2];
            if(!types.includes(type)) {
                types.push(type);
            }
        });
        types.sort();
        for (const type of types) {
            const div = $("<div></div>")
            const uid = getUid();
            const checker = $(`<input type="checkbox" id="${uid}"checked class="show-check margin right">`);
            div.append(checker);
            div.append(`<label for="${uid}">${type}</label>`)
            $(".filters").append(div);
            checker.change(function() {
                const checked = this.checked;
                $(`.comp-link.${type}`).css("display", checked ? "block" : "none");
            })
        }
    })
</script>
<?php
include_once "../footer.php";
?>