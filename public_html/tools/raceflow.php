<?php
// include_once "../includes/roles.php";
// include_once "../includes/error.php";
include_once "../api/index.php";
include_once "../header.php";
$comps = getAllCompetitions();
?>
<main class="main">
    <h1 class="align center margin top double">Race analytics</h1>
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
    <table id="athleteTable"></table>
</main>
<script>
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
        get("raceAthletes", race.id).receive((succsess, athletes) => {
            if(!succsess) {
                alert("server error");
                return;
            }
            $("#athleteTable").empty();
            $("#athleteTable").append("<tr><td>Current</td><td>Finish</td><td>First name</td><td>Last name</td><td>Country</td></tr>");
            console.log(athletes);
            let place = 1;
            for (const athlete of athletes) {
                $("#athleteTable").append(`<tr draggable="true" ondragstart="start()"  ondragover="dragover()"><td>${place}</td><td>${place}</td><td>${athlete.firstname}</td><td>${athlete.lastname}</td><td>${athlete.country}</td></tr>`);
                place++;
            }
        });
    }
    $(() => {
        $("#compSelect").val(1).trigger("change");
        setTimeout(() => {
            $("#raceSelect").val(races[1].id).trigger("change");
        }, 500);
    });

    /**
     * Drag'n drop
     */
    let row;
    function start(){  
        row = event.target; 
    }
    function dragover(){
        let e = event;
        e.preventDefault(); 
        
        let children= Array.from(e.target.parentNode.parentNode.children);
        
        if(children.indexOf(e.target.parentNode)>children.indexOf(row))
            e.target.parentNode.after(row);
        else
            e.target.parentNode.before(row);
    }
</script>
<style>
    table {
        border-collapse: collapse;
        -webkit-user-select: none; /* Safari */
        -ms-user-select: none; /* IE 10+ and Edge */
        user-select: none; /* Standard syntax */
    }
    td,tr,th {
        border:1px solid black;
        border-collapse: collapse;
        cursor:all-scroll;
    }
</style>
<?php
    include_once "../footer.php";
?>