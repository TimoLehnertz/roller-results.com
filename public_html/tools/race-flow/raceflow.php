<?php
// include_once "../includes/roles.php";
// include_once "../includes/error.php";
include_once "../../api/index.php";
include_once "../../header.php";
$comps = getAllCompetitions();
echoRandWallpaper();
?>
<main class="main competition-page analytics race-flow">
    <div class="top-site"></div>
    <svg style="margin-bottom: 0; position: relative; transform: translateY(85%); z-index: -1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <svg style="margin-bottom: 0; position: relative; top: 0px; z-index: 1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#151515"></path></svg>
    <div class="dark section no-shadow">
        <h1 class="font size biggest">Race flow editor<i class="fa fa-solid fa-pencil margin left"></i></h1>
        <p class="align center font size big color light margin top double">
            Analyze and compare every overtake that happened during races
        </p>
    </div>
    <div class="light section">
        <br>
        <h2>Quick Tips</h2>
        <p class="font size big">Controlls<i class="fa fa-solid fa-gamepad margin left font color black"></i></p>
        <ul>
            <li>Drag the the Timeline's dark section to move the blue cursor</li>
            <li>Drag the the Timeline's lighter section to move arround</li>
            <li>Hover the Timeline and use the scrollwheel to zoom in and out</li>
            <li>Click the yellow keyframes to place the cursor on top</li>
            <li>Drag and drop athletes to change their order</li>
            <li>Use the checkboxes to select wich athletes you will be looking on</li>
        </ul>
        <br>
        <p class="font size big">Getting started<i class="fa fa-solid fa-play margin left font color black"></i></p>
        <ul>
            <li>Select the competition and race to analyze</li>
            <li>Find a video of the race</li>
            <li>For every overtake you see in the video move the cursor to the aproximate lapcount, arrange the athletes order and hit <span class="code">Save race state</span></li>
            <li>When you are done be sure to click <span class="code">Save race to cloud to save your progress</span></li>
            <li>See your graps the <a href="/tools/race-flow">Race flow</a> page</li>
        </ul>
    </div>
    <div class="dark section">
        <form class="form">
            <!-- <p>Choose race to analyze</p> -->
            <!-- <label for="compSelect">Competition:</label> -->
            <select id="compSelect">
                <option value="-1">Select</option>
                <?php
                foreach ($comps as $comp) {
                    echo "<option value='".$comp["idCompetition"]."'>".date('Y', strtotime($comp["startDate"]))." ".$comp["type"]." ".$comp["location"]."</option>";
                }?>
            </select>
            <!-- <label for="raceSelect">Race:</label> -->
            <select id="raceSelect"></select>
            <label for="laps">Laps</label>
            <input type="number" min="1" value="5" id="laps" onchange="changeLaps()">
        </form>
        <h3 class="align center font color light">Timeline</h3>
        <div class="time"></div>
        <button class="btn blender left margin left" onclick="uncheckAll()">Uncheck all</button>
        <button class="btn blender right" onclick="checkAll()">Check all</button>
        <button class="btn blender alone margin left triple" onclick="saveState()">Save race state</button>
        <button class="btn blender alone save" onclick="save()">Save race to cloud</button>
        <div id="athletes"></div>
    </div>
</main>
<script>

    const timeline = new Timeline();
    timeline.onchange = handleTimelineChange;
    let currentRace;
    let frameEdited = false;
    let athletes = [];
    
    $(".time").append(timeline.elem);

    $(() => {
        $("#compSelect").val(1).trigger("change");
        setTimeout(() => {
            $("#raceSelect").val(races[32].id).trigger("change");
        }, 500);
    });


    let races = [];
    $("#compSelect").change(() => {
        $('#raceSelect').prop("disabled", true);
        const idComp = $("#compSelect").val();
        if(idComp === "-1") return;
        $('#raceSelect').empty();
        $('#raceSelect').append(`<option>Loading...</option>`);
        get("compRacesFlow", idComp).receive((succsess, resRaces) => {
            if(!succsess) {
                alert("Server error :(");
                return;
            }
            races = resRaces;
            $('#raceSelect').empty();
            $('#raceSelect').prop("disabled", false);
            $("#raceSelect").append(`<option value="-1">Select</option>`);
            for (const race of races) {
                $("#raceSelect").append(`<option style="color: white; background-color: ${race.raceFlow == "1" ? "#014201" : "#1c1312"}" value="${race.id}">${race.distance} ${race.category} ${race.gender}</option>`);
            }
        });
    });

    $("#raceSelect").change(() => {
        const idRace = $("#raceSelect").val();
        if(idRace === "-1") return;
        for (const race of races) {
            if(race.id == idRace) {
                initRace(race);
                return;
            }
        }
        alert("Invalid race");
    });

    function initRace(race) {
        $(".race-link").remove();
        $(".form").append(`<a target="blank" class="race-link" href="/race/index.php?id=${race.id}">Race link</a>`);
        currentRace = race;
        get("raceAthletes", race.id).receive((succsess, res) => {
            if(!succsess) {
                alert("server error");
                return;
            }
            athletes = res;
            for (const athlete of athletes) {
                athlete.use = true;
            }
            timeline.removeAllKeyframes();
            timeline.frame = timeline.lastFrame;
            saveState();
            timeline.frame = timeline.startFrame;
            updatePositions(getPositionsFromAthletes(athletes));

            if(race.raceFlow == "1") {
                get("overtakes", race.id).receive((succsess, overtakes) => {
                    if(!succsess || currentRace != race) { // if another race gets fetched before completion or another error
                        alert("error while fetching overtakes");
                        return;
                    }
                    initOvertakes(overtakes);
                });
            }
        });
    }

    function getAthleteById(idAthlete) {
        for (const athlete of athletes) {
            if(athlete.idAthlete == idAthlete) {
                return athlete;
            }
        }
    }

    function initOvertakes(overtakes) {
        timeline.removeAllKeyframes();
        let newAthletes = [];
        for (const athlete of athletes) {
            athlete.use = false; // gets set to true when actually used
        }
        let lap = overtakes[0].lap;
        for (let i = 0; i <= overtakes.length; i++) {
            const overtake = overtakes[i];
            if(lap != overtake?.lap || i == overtakes.length) {
                // Filling gaps
                for (let n = 0; n < athletes.length; n++) {
                    if(newAthletes[n] == undefined) {
                        for (const athlete of athletes) {
                            if(!newAthletes.includes(athlete)) {
                                newAthletes[n] = athlete;
                                break;
                            }
                        }
                    }
                    
                }
                athletes = newAthletes;
                newAthletes = [];
                timeline.frame = lap;
                const positions = getPositionsFromAthletes(athletes);
                timeline.addKeyframe(positions);
                lap = overtake?.lap;
                if(i == overtakes.length) {
                    break;
                } else {
                    for (const athlete of athletes) {
                        athlete.use = false;
                    }
                }
            }
            const athlete = getAthleteById(overtake.athlete);
            athlete.insideOut = overtake.insideOut;
            athlete.use = true;
            newAthletes[overtake.toPlace - 1] = athlete;
        }
        // trigger update
        frameEdited = true;
        timeline.frame = 10000;
        timeline.frame = 0;
    }

    /**
     * @param positions: [{
     *  athlete: <athlete>
     *  insideOut: <string>
     * }]
     */
    function updatePositions(positions) {
        $("#athletes").empty();
        let place = 1;
        for (const position of positions) {
            const athlete = position.athlete;
            if(athlete.finishPos == undefined && athlete.idAthlete != undefined) {
                athlete.finishPos = place;
            }
            const use = position.use || position.use == undefined;
            const athleteElem = $(`
            <div class="race-athlete" idAthlete="${athlete.idAthlete ?? -1}" draggable="true">
                <input class="use" type="checkbox" ${use ? "checked" : ""}>
                <div class="position">${place}</div>
                <div class="place">${athlete.finishPos ?? ""}</div>
                <select class="inside-outside">
                    <option value="-1">-</option>
                    <option value="inside">Inside</option>
                    <option value="ouside">Outside</option>
                </select>
                <div class="first-name">${athlete.firstname ?? ""}</div>
                <div class="last-name">${athlete.lastname ?? ""}</div>
            </div>`);
            if(!use) {
                athleteElem.addClass("unused");
            }
            const insideOut = athleteElem.find(".inside-outside");
            if(position.insideOut != undefined) {
                insideOut.val(position.insideOut);
            }
            const checkbox = athleteElem.find("input").change(function() {
                athlete.use = checkbox.is(':checked');
                if(athlete.use) {
                    athleteElem.removeClass("unused");
                } else {
                    athleteElem.addClass("unused");
                }
                frameEdited = true;
            });
            insideOut.change(() => {
                frameEdited = true;
                athlete.insideOut = insideOut.val();
            });

            athleteElem.on("dragstart", dragstart);
            athleteElem.on("dragover",  dragover);
            athleteElem.on("dragleave", dragleave);
            athleteElem.on("dragend",   dragend);
            athleteElem.find(".first-name").before(getCountryFlagSimple(athlete.country, "2rem", "2rem", true));
            $("#athletes").append(athleteElem);
            place++;
        }
        const placeholer = $(`<div class="race-athlete placeholder"></div>`);
        placeholer.on("dragover",  dragover);
        placeholer.on("dragleave", dragleave);
        $("#athletes").append(placeholer);
    }

    function handleTimelineChange(value, changed) {
        if(changed || frameEdited) {
            positions = value;
            frameEdited = false;
            updatePositions(value);
            resortAthletes();
        }
    }

    function getPositionsFromAthletes(athletes) {
        positions = [];
        for (const athlete of athletes) {
            positions.push({
                athlete,
                use: athlete.use,
                insideOut: athlete.insideOut ?? "-"
            });
        }
        return positions;
    };

    function saveState() {
        const positions = getPositionsFromAthletes(athletes);
        timeline.addKeyframe(positions);
    }

    /**
     * Drag'n drop
     */
    let receiver;
    function dragstart(e) {
        $(e.target).removeClass("dragged");
        $(e.target).addClass("dragging");
        setTimeout(function() {
            e.target.style.height = "0";
        }, 1);
    }

    function dragleave(e) {
        e.preventDefault();
        $(this).removeClass("drop-before");
    }

    function dragover(e){
        receiver = this;
        $(this).addClass("drop-before");
    }

    function dragend(e) {
        if(receiver == e.target) return;
        $(e.target).detach();
        $(receiver).before($(e.target));
        $(receiver).removeClass("drop-before");
        $(e.target).addClass("dragged");
        $(e.target).removeClass("dragging");
        $(".race-athlete").not(".placeholder").each(function(i) {$(this).find(".position").text(i + 1)});
        setTimeout(function() {
            e.target.style.height = "2rem";
        }, 1);
        resortAthletes();
        frameEdited = true;
    }

    function resortAthletes() {
        const newAthletes = [];
        $(".race-athlete").not(".placeholder").each(function(i) {
            const idAthlete = $(this).attr("idAthlete");
            if(idAthlete < 0) return;
            for (const athlete of athletes) {
                if(athlete.idAthlete == idAthlete) {
                    newAthletes.push(athlete);
                    break;
                }
            }
        });
        athletes = newAthletes;
    }

    function changeLaps() {
        timeline.lastFrame = parseFloat($("#laps").val());
        timeline.draw();
    }

    function checkAll(check) {
        $(".race-athlete").removeClass("unused");
        $(".race-athlete input").prop( "checked", true).trigger("change");
        // for (const athlete of athletes) {
        //     athlete.use = true;
        // }
    }

    function uncheckAll() {
        $(".race-athlete").addClass("unused");
        $(".race-athlete input").prop( "checked", false).trigger("change");
        // for (const athlete of athletes) {
        //     athlete.used = false;
        // }
    }

    function save() {
        $(".save").html(`<div class="loading circle small"></div>`);
        const overtakes = [];
        const athleteStates = {};
        for (const athlete of athletes) {
            athleteStates[athlete.idAthlete] = {prevPlace: 0};
        }
        for (const keyframe of timeline.keyframes) {
            let place = 0;
            for (const position of keyframe.value) {
                place++;
                if(!position.use) continue;
                const athlete = position.athlete;
                if(athlete.idAthlete == undefined) continue;
                if(athleteStates[athlete.idAthlete].prevPlace == place) continue;
                console.log(athlete);
                overtakes.push({
                    athlete: athlete.idAthlete,
                    race: currentRace.id,
                    fromPlace: athleteStates[athlete.idAthlete].prevPlace,
                    toPlace: place,
                    lap: keyframe.frame,
                    insideOut: position.insideOut ?? "-",
                    finishPlace: athlete.finishPos
                });
            }
        }
        // return;
        post("overtakes", overtakes).receive((succsess, res) => {
            $(".save").html(`Save race to cloud`);
            if(succsess) {
                setTimeout(() => {
                    alert("Saved");
                }, 100);
            } else {
                alert("Error: " + res);
            }
        });
    }
</script>
<?php
    include_once "../../footer.php";
?>