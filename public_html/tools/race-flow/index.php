<?php
// include_once "../includes/roles.php";
// include_once "../includes/error.php";
include_once "../../api/index.php";
include_once "../../header.php";
$distances = getAllRaceFlowDistances();
echoRandWallpaper();
?>
<main class="main competition-page analytics">
    <div class="top-site"></div>
    <svg style="margin-bottom: 0; position: relative; transform: translateY(85%); z-index: -1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <svg style="margin-bottom: 0; position: relative; top: 0px; z-index: 1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#151515"></path></svg>
    <div class="dark section no-shadow">
        <h1 class="flex mobile font size biggest">Race flow graphs</h1>
        <p class="align center font size big color light margin top double">
            Analyze and compare every overtake that happened during races
        </p>
        <br>
        <p class="align center font size big">
            <a href="raceflow.php">Race flow editor</a>
        </p>
        <br><br>
        <p>
            Explore the tool that will visulize all movements within a races. See winning strategies of the best skaters in history.
        </p>
        <p>
            Head over to the <a href="raceflow.php">Edit section</a> to start analyzing races on the timeline yourself.
        </p>
        <br><hr><br>
        <ul>
            <li>
                <span class="code">X axis</span>: represents the passed laps during the race
            </li>
            <br>
            <li>
                <span class="code">Y axis</span>: represents the skaters current position
            </li>

        </ul>
    </div>
    <div class="speaker section dark no-shadow">
        <form class="form margin bottom double">
            <p>
                <label for="distanceSelect">Distance: </label>
                <select id="distanceSelect">
                    <option value="-1">Select</option>
                    <?php
                    foreach ($distances as $d) {
                        echo "<option value='$d'>$d</option>";
                    }?>
                </select>
                <label for="women">Women</label>
                <input type="checkbox" id="women" checked>
                <label for="men">Men</label>
                <input type="checkbox" id="men" checked>
            </p>
            <br>
            <p>
                <label for="min-place">Min place:</label>
                <input id="min-place" type="number" step="1" min = "1" value="1">
                Display Only skaters that finished on these positions
            </p>
            <p>
                <label for="max-place">Max place:</label>
                <input id="max-place" type="number" step="1" min = "1" value="3"><br>
            </p>
            <button type="button" class="btn blender alone margin top font size big" onclick="go()">Go!</button>
        </form>
    </div>
    <div class="graph padding left right" style="max-width: 95vw;">
        
    </div>
</main>
<script>
    $("#distanceSelect").val("1000m");
    go();
    function go() {
        const distance = $("#distanceSelect").val();
        if(distance == "-1") return;
        console.log(distance);
        $(".graph").empty();
        $(".graph").append(`<canvas id="canvas" width="1920" height="${isMobile() ? "3000" : "700"}"></canvas>`);

        const gender = ($("#men").is(':checked') ? "m" : "") + ($("#women").is(':checked') ? "w" : "");

        get("overtakesByDistance", distance, gender).receive((succsess, overtakes) => {
            if(!succsess) {
                alert("Error");
                return;
            }
            console.log(overtakes);
            const labels = [];
            const datasets = [];
            let end = 0;
            let maxPlace = 0;
            let minPlace = parseInt($("#min-place").val());
            for (const o of overtakes) {
                end = Math.max(end, o.lap);
                maxPlace = Math.max(maxPlace, o.finishPlace);
            }
            maxPlace = Math.min($("#max-place").val(), maxPlace);
            for (let i = 0; i <= end; i += 0.05) {
                labels.push(Math.round(i * 1000) / 1000 + "");
            }

            function findDataset(overtake) {
                for (const dataset of datasets) {
                    if(dataset.finishPlace == overtake.finishPlace && dataset.race == overtake.race) return dataset;
                }
                // add dataset
                const dataset = {
                    label: "a",
                    label: `${overtake.location} ${overtake.raceYear} ${overtake.category} ${overtake.gender} ${overtake.distance} #${overtake.finishPlace} ${overtake.firstname} ${overtake.lastname}`,
                    data: [],
                    borderColor: getPlaceColor(overtake.finishPlace),
                    borderWidth: 1,
                    showLabel: false,
                    spanGaps: true,
                    finishPlace: overtake.finishPlace,
                    race: overtake.race
                }
                datasets.push(dataset);
                return dataset;
            }

            for (const overtake of overtakes) {
                if(overtake.finishPlace > maxPlace || overtake.finishPlace < minPlace) continue;
                dataset = findDataset(overtake);
                dataset.data[overtake.lap * (1 / 0.05)] = overtake.toPlace;
            }

            const canvas = document.getElementById("canvas");
            const ctx = canvas.getContext('2d');
            Chart.defaults.global.defaultFontColor = 'white';
            Chart.defaults.global.defaultFontSize = 16;
            console.log(datasets);
            new Chart(ctx,
                {
                    type: 'line',
                    data: {
                        labels,
                        datasets,
                    },
                    options: {
                        legend: {
                            display: false
                        },
                        defaultFontColor: "#FFF",
                        layout: {
                            padding: {
                                left: 0,
                                right: 0,
                                top: 0,
                                bottom: 0
                            }
                        },
                        scales: {
                            y: {
                                stacked: true,
                                grid: {
                                    display: true,
                                    color: "rgba(255,99,132,0.2)"
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        responsive: true
                    }
                });
        });
    }
</script>
<?php
    include_once "../../footer.php";
?>