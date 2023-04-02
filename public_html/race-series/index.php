<?php
include_once "../header.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/api/index.php";

$raceSeries = getAllRaceSeries();

echoRandWallpaper();
?>
<main class="main competitions-page">

    <div class="top-site">
        
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <div class="comps">
        <h1 class="align center font color gray size biggest">Race series</h1>
        <p class="align center font color gray size big">See all race series</p>
        <br>
        <div>
            <button class="btn blender left" onclick="checkAll(true)">Show all</button>
            <button class="btn blender right" onclick="checkAll(false)">Hide all</button>
        </div>
        <br>
        <div class="filters font color black grid four mobile-two gap padding left right">
        </div>
        <?php
            if(sizeof($raceSeries) > 0) {
                $year = 0;
                $begun = false;
                foreach($raceSeries as $raceSerie) {
                    if($raceSerie["year"] !== $year) {
                        $year = $raceSerie["year"];
                        if($begun) {
                            echo "</div>";
                        }
                        echoYear($year);
                        echo "<div class='comp-gallery' id='".$year."'>";
                        $begun = true;
                    }
                    echoSerie($raceSerie);
                }
                echo "</div>";
            }

            function echoSerie($raceSerie) {
                $link = "results.php?id=".$raceSerie["idRaceSeries"];
                echo "
                <a class='no-underline comp-link ".$raceSerie["type"]."' href='$link'>
                    <div class='comp'>
                        <div class='left'>
                            <div class='name'>
                                ".$raceSerie["name"]."
                            </div>
                            <div class='date'>
                                (".$raceSerie["races"]." races)
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