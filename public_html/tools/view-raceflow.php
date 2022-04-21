<?php
// include_once "../includes/roles.php";
// include_once "../includes/error.php";
include_once "../api/index.php";
include_once "../header.php";
$distances = getAllRaceFlowDistances();
?>
<main class="main race-flow">
    <h1 class="align center margin top double">Race flow</h1>
    <div class="speaker">
        <form class="form margin top bottom double">
            <select id="distanceSelect">
                <option value="-1">Select</option>
                <?php
                foreach ($distances as $d) {
                    echo "<option value='$d'>$d</option>";
                }?>
            </select>
            <label for="max-place">Max place:</label>
            <input id="max-place" type="number" step="1" min = "1" value="3">
            <label for="min-place">Min place:</label>
            <input id="min-place" type="number" step="1" min = "1" value="1">
            <button type="button" class="btn blender alone margin top" onclick="go()">Go!</button>
        </form>
    </div>
    <div class="graph">
        
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
        $(".graph").append(`<canvas class="career__canvas" width="1920" height="${isMobile() ? "3000" : "700"}"></canvas>`);

        get("overtakesByDistance", distance).receive((succsess, overtakes) => {
            if(!succsess) {
                alert("Error");
                return;
            }
            console.log(overtakes);
            const labels = [];
            const datasets = [];
            let end = 0;
            let maxPlace = 0;
            let minPlace = $("#min-place").val();
            for (const o of overtakes) {
                end = Math.max(end, o.lap);
                maxPlace = Math.max(maxPlace, o.finishPlace);
            }
            maxPlace = Math.min($("#max-place").val(), maxPlace);
            for (let i = 0; i <= end; i += 0.05) {
                labels.push(Math.round(i * 1000) / 1000 + "");
            }

            let idRace = overtakes[0].race;
            let raceData = [];
            let lastPlace = 1;
            for (let place = minPlace; place <= maxPlace + 1; place++) {
                for (let i = 0; i <= overtakes.length; i++) {
                    const o = overtakes[Math.min(i, overtakes.length - 1)];
                    if(o.finishPlace != place) continue;
                    if(i == overtakes.length || idRace != o.race || lastPlace != place) {
                        datasets.push({
                            label: `${o.location} ${o.raceYear} ${o.category} ${o.gender} ${o.distance} #${place - 1}`,
                            data: raceData,
                            // backgroundColor: getRandomColor(),
                            borderColor: getPlaceColor(place - 1),
                            borderWidth: 1
                        });
                        raceData = [];
                        idRace = o.race;
                        lastPlace = place;
                    }
                    if(i == overtakes.length) break; // done
                    if(place == maxPlace+1) break; // done
                    
                    // handle race overtake
                    for (let n = o.lap * 20; n < end / 0.05 + 1; n++) {
                        raceData[n] = o.toPlace;
                    }
                }
            }

            const canvas = document.getElementsByClassName("career__canvas")[0];
            const ctx = canvas.getContext('2d');
            
            console.log(datasets);

            Chart.defaults.global.defaultFontColor = 'white';
            Chart.defaults.global.defaultFontSize = 16;
            new Chart(ctx,
                {
                    type: 'line',
                    data: {
                        labels,
                        datasets,
                    },
                    options: {
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
                            yAxes: [{
                                color: "#FFF"
                            }]
                        }
                    }
                });
        });
    }
</script>
<?php
    include_once "../footer.php";
?>