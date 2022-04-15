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
    <div id="athletes"></div>
</main>
<script>

    const timeline = new Timeline();
    timeline.onchange = handleTimelineChange;

    $(".time").append(timeline.elem);

    let races = [];
    $("#compSelect").change(() => {
        $('#raceSelect').prop("disabled", true);
        const idComp = $("#compSelect").val();
        if(idComp === "-1") return;
        $('#raceSelect').empty();
        $('#raceSelect').append(`<option>Loading...</option>`);
        get("compRaces", idComp).receive((succsess, resRaces) => {
            if(!succsess) {
                alert("Server error :(");
                return;
            }
            races = resRaces;
            $('#raceSelect').empty();
            $('#raceSelect').prop("disabled", false);
            $("#raceSelect").append(`<option value="-1">Select</option>`);
            for (const race of races) {
                $("#raceSelect").append(`<option value="${race.id}">${race.distance} ${race.category} ${race.gender}</option>`);
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
        get("raceAthletes", race.id).receive((succsess, res) => {
            if(!succsess) {
                alert("server error");
                return;
            }
            athletes = res;
            athletes.push({}); // placeholder at the end for dragging to last pos
            timeline.removeAllKeyframes();
            timeline.frame = timeline.lastFrame;
            timeline.addKeyframe(athletes);
            timeline.frame = timeline.startFrame;
            updateAthletes();
        });
    }
    $(() => {
        $("#compSelect").val(1).trigger("change");
        setTimeout(() => {
            $("#raceSelect").val(races[1].id).trigger("change");
        }, 500);
    });

    let athletes = [];

    /**
     * @param athletes: []
     */
    function updateAthletes() {
        $("#athletes").empty();
        let place = 1;
        for (const athlete of athletes) {
            let draggable = "true";
            if(place == athletes.length) {
                place = "";
                draggable = "false";
            }
            if(athlete.finishPos == undefined) {
                athlete.finishPos = place;
            }
            const athleteElem = $(`
            <div class="race-athlete" idAthlete="${athlete.idAthlete ?? -1}" draggable="${draggable}">
                <div class="position">${place}</div>
                <div class="place">${athlete.finishPos}</div>
                <div class="first-name">${athlete.firstname ?? ""}</div>
                <div class="last-name">${athlete.lastname ?? ""}</div>
            </div>`);
            athleteElem.on("dragstart", dragstart);
            athleteElem.on("dragover",  dragover);
            athleteElem.on("dragleave ",dragleave);
            athleteElem.on("dragend ",  dragend);
            athleteElem.find(".first-name").before(getCountryFlagSimple(athlete.country, "2rem", "2rem", true));
            $("#athletes").append(athleteElem);
            place++;
        }
    }

    function handleTimelineChange(value) {
        athletes = value;
        updateAthletes();
    }

    function saveState() {
        timeline.addKeyframe(athletes);
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
        $(".race-athlete").each(function(i) {$(this).find(".position").text(i + 1)});
        setTimeout(function() {
            e.target.style.height = "2rem";
        }, 1);
        resortAthletes();
    }

    function resortAthletes() {
        const newAthletes = [];
        $(".race-athlete").each(function(i) {
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
</script>
<?php
    include_once "../footer.php";
?>