<?php
include_once "../../../api/index.php";
include_once "../../../header.php";
echoRandWallpaper();

?>
<main class="main competition-page">
    <div class="top-site">
        <!-- <h1 class="title">Advantages for sprint teams</h1> -->
    </div>
    <svg style="margin-bottom: 0; position: relative; transform: translateY(85%); z-index: -1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <svg style="margin-bottom: 0; position: relative; top: 0px; z-index: 1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#333"></path></svg>
    <div class="dark section no-shadow">
        <h1 class="flex mobile"><a href="/analytics/index.php">Analytics</a><i class="margin left right fas fa-chevron-right"></i>Do teams have an advantage in sprint finals?</h1>
        <p class="align center font color light">
            This is the tool to compare your statistic chance of winning if you have a team mate in your sprint final
        </p>
    </div>
    <div class="light section">
        <h2>How does it work?</h2>
        <div class="margin left">
            <p>
                This tool takes 2 parameters:
                <ol>
                    <li class="margin top">Distance
                        <div class="margin left font color gray">Wich sprint mass start distance to use</div>
                    </li>
                    <li class="margin top">Competitions</li>
                    <div class="margin left font color gray">All types of competitions to include</div>
                </ol>
            </p>
        </div>
    </div>
    <div class="dark section">
        <h2>Settings</h3>
        <div class="flex row align-start justify-space-arround mobile">
            <div class="compSelect">
                <h2>Types of Competitions</h2>
            </div>
            <i class="fas fa-chevron-right"></i>
            <div>
                <h2>Distance</h2>
                <div><input value="500m" type="radio" name="distance" id="500m" checked><label class="margin left" for="500m">500m</label></div>
                <div><input value="oneLap" type="radio" name="distance" id="oneLap"><label class="margin left" for="oneLap">One lap</label></div>
                <div><input value="1000m" type="radio" name="distance" id="1000m"><label class="margin left" for="1000m">1000m</label></div>
            </div>
            <i class="fas fa-chevron-right"></i>
            <div>
                <button class="go btn default slide font size bigger" onclick="go()">Go!</button>
            </div>
        </div>
        <br>
        <hr>
        <br>
        <h3 class="margin top">Result</h3>
        <div class="res flex row mobile">

        </div>
        <div class="more">

        </div>
    </div>
    <script>

        let lastComps;
        let lastDistance;
        let lastPlace;

        for (const key in defaultCompSettings) {
            if (Object.hasOwnProperty.call(defaultCompSettings, key)) {
                const comp = defaultCompSettings[key];
                const elem = $(`
                <div>
                    <input type="checkbox" id="${key}" ${comp.influence > 0 ? "checked" : ""}>
                    <label for="${key}"><i class="${comp.icon} margin left right"></i>${comp.displayName}</label>
                </div>`);
                $(".compSelect").append(elem);
            }
        }

        function go() {
            lastDistance = getDistance();
            lastPlace = getFinalSize(lastDistance);
            lastComps = getComps();
            get("teamAdvantage", lastDistance, lastPlace, lastComps).receive((succsess, res) => {
                $(".go").prop("disabled", false);
                process(res);
            });
            $(".res").empty();
            $(".res").append("<div class='loading circle'/>");
            $(".go").prop("disabled",true);
        }

        function process(res) {
            $(".res").empty();
            $(".more").empty();
            $(".res").append(`
            <p>${code(res.races)} races found from ${code(res.firstYear)} - ${code(res.lastYear)}.</p>
            <table class="table twoCols">
                <tr><td>Team wins           </td><td>${res.teamWins}</td></tr>
                <tr><td>Team looses         </td><td>${res.teamDoesntWin}</td></tr>
                <tr><td>Succsess(%)         </td><td>${res.percentage}</td></tr>
                <tr><td>Best country        </td><td>${res.bestCountry}</td></tr>
                <tr><td>Best country share  </td><td>${res.bestCountryShare}</td></tr>
            </table>`);
            $(".more").append(`<button class="align center btn style-1 font color white" onclick="showMore()">Show all</button>`);
        }

        function getFinalSize(distance) {
            switch(distance) {
                case "500m%": case "one%": return 4;
                case "1000m%": return 8;
            }
        }

        function getDistance() {
            switch($("input[name='distance']:checked").val()) {
                case "500m": return "500m%";
                case "1000m": return "1000m%";
                case "oneLap": return "one%";
                default: return "500m%";
            }
        }

        function getComps() {
            const comps = [];
            for (const key in defaultCompSettings) {
                if (Object.hasOwnProperty.call(defaultCompSettings, key)) {
                    const comp = defaultCompSettings[key];
                    if($(`#${key}`)[0].checked) {
                        comps.push(comp.dbName);
                    }
                }
            }
            return comps;
        }

        function showMore() {
            $(".more").append(`<div class="loading circle"/>`);
            $(".more btn").prop("disabled", true);
            get("teamAdvantageDetails", lastDistance, lastPlace, lastComps).receive((succsess, res) => {
                if(succsess) {
                    processMore(res);
                }
                console.log(res);
            });
        }

        function processMore(res) {
            $(".more").empty();
            $(".more").append(`<br><hr><br>`);
            const table = new Table($(".more"), res, "table fixed margin top");
            table.setup({
                layout: {
                    distance: {
                        use: true
                    },
                    year: {
                        use: true
                    },
                    gender: {
                        use: true
                    },
                    category: {
                        use: true
                    },
                    winner: {
                        use: true
                    },
                    result: {
                        use: false
                    },
                    doubleCountry: {
                        use: true,
                        displayName: "Team"
                    },
                    succsess: {
                        use: true
                    }
                }
            });
            table.init();
        }
    </script>
</main>
<?php
include_once "../../../footer.php";
?>