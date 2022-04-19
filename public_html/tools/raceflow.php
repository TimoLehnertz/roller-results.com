<?php
// include_once "../includes/roles.php";
// include_once "../includes/error.php";
include_once "../api/index.php";
include_once "../header.php";
$comps = getAllCompetitions();
?>
<main class="main race-flow">
    <h1 class="align center margin top double">Race flow</h1>
    <p>Choose race to analyze</p>

    <label for="compSelect">Competition:</label>
    <select id="compSelect">
        <option value="-1">Select</option>
        <?php
        foreach ($comps as $comp) {
            echo "<option value='".$comp["idCompetition"]."'>".date('Y', strtotime($comp["startDate"]))." ".$comp["type"]." ".$comp["location"]."</option>";
        }?>
    </select>
    <label for="raceSelect">Race:</label>
    <select id="raceSelect"></select>
    <label for="laps">Laps</label>
    <input type="number" min="1" value="5" id="laps" onchange="changeLaps()">
    <div class="time"></div>
    <button class="btn blender alone" onclick="saveState()">Save race state</button>
    <button class="btn blender left" onclick="uncheckAll()">Uncheck all</button>
    <button class="btn blender right" onclick="checkAll()">Check all</button>
    <button class="btn blender alone" onclick="save()">Save to cloud</button>
    <div id="athletes"></div>
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
        $(".time").before(`<a target="blank" class="race-link" href="/race/index.php?id=${race.id}">Race link</a>`);
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
            console.log("fetched athletes:");
            console.log(athletes);
            // athletes.push({}); // placeholder at the end for dragging to last pos
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
                console.log("lap != overtake.lap. newAthletes:");
                // Filling gaps
                for (let n = 0; n < athletes.length; n++) {
                    if(newAthletes[n] == undefined) {
                        for (const athlete of athletes) {
                            if(!newAthletes.includes(athlete)) {
                                console.log("found");
                                console.log(athlete);
                                newAthletes[n] = athlete;
                                break;
                            }
                        }
                    }
                    
                }
                console.log(newAthletes);
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
            // athletes.splice(athletes.indexOf(athlete), 1);
            // athletes.splice(overtake.toPlace - 1, 0, athlete);
            // console.log(newAthletes);
        }
        // trigger update
        frameEdited = true;
        timeline.frame = 10000;
        timeline.frame = 0;
        console.log(athletes);
    }

    /**
     * @param positions: [{
     *  athlete: <athlete>
     *  insideOut: <string>
     * }]
     */
    function updatePositions(positions) {
        console.log("update");
        console.log(positions);
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
                position.use = athlete.use;
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
            console.log("timeline changed. value:");
            console.log(value);
            positions = value;
            frameEdited = false;
            updatePositions(value);
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
        timeline.addKeyframe(getPositionsFromAthletes(athletes));
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
        console.log("resorting");
        console.log(athletes);
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
        console.log(athletes);
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
        const overtakes = [];
        const athleteStates = {};
        console.log(athletes);
        for (const athlete of athletes) {
            athleteStates[athlete.idAthlete] = {prevPlace: 0};
        }
        for (const keyframe of timeline.keyframes) {
            let place = 1;
            for (const position of keyframe.value) {
                if(!position.use) continue;
                const athlete = position.athlete;
                // console.log(position);
                // console.log(athleteStates);
                if(athlete.idAthlete == undefined) continue;
                if(athleteStates[athlete.idAthlete].prevPlace == place) continue;
                
                overtakes.push({
                    athlete: athlete.idAthlete,
                    race: currentRace.id,
                    fromPlace: athleteStates[athlete.idAthlete].prevPlace,
                    toPlace: place,
                    lap: keyframe.frame,
                    insideOut: position.insideOut ?? "-"
                });
                place++;
            }
        }
        console.log("saving:");
        console.log(overtakes);
        post("overtakes", overtakes);
    }
</script>
<?php
    include_once "../footer.php";
?>