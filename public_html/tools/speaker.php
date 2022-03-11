<?php
include_once "../includes/roles.php";
include_once "../includes/error.php";
if(!canI("speaker")){
    throwError($ERROR_NO_PERMISSION, "/tools/index.php");
} 
include_once "../header.php";
include_once "../api/index.php";
?>
<main class="speaker">
<div class="form">
    <p class="margin bottom" >Get data from skateresults:</p>
    <p>
        <label for="event">Event:</label>
        <select id="event"><option value="-1">Loading...</option></select>
    </p>
    <p>
        <label for="ageGroup">Age group:</label>
        <select id="ageGroup" disabled><option value="-1"></option></select>
    </p>
    <p>
        <label for="competition">Competition:</label>
        <select id="competition" disabled><option value="-1"></option></select>
    </p>
    <p>
        <label for="round">Round:</label>
        <select id="round" disabled><option value="-1"></option></select>
    </p>
    <p>
        <label for="race">Race:</label>
        <select id="race" disabled><option value="-1"></option></select>
    </p>
</div>
<br>
<label for="aliasGroup">Alias group: </label>
<select id="aliasGroup">
<?php
    $groups = getAliasGroups();
    if(sizeof($groups) === 0) {
        echo "<option value='-1234'>You dont have any alias groups Yet!</option>";
    } else {
        echo "<option value='-1234'>Select</option>";
    }
    foreach ($groups as $group) {
        echo "<option value='".$group["aliasGroup"]."'>".$group["aliasGroup"]." (".$group["count"]." entries)</option>";
    }
?>
</select>
<textarea class="hidden" id="idInput" cols="30" rows="10" placeholder="[001,002,...]">
    [{"startPos":4,"rank":1,"alias":"Y7691WVNknxjamM0s5Pp-101"},
    {"startPos":1,"rank":2,"alias":"Y7691WVNknxjamM0s5Pp-13"},
    {"startPos":3,"rank":3,"alias":"Y7691WVNknxjamM0s5Pp-145"},
    {"startPos":2,"rank":4,"alias":"Y7691WVNknxjamM0s5Pp-37"}]
</textarea>
<button class="go" onclick="go()">Go</button>

<br>
<br>
<hr>
<br>

<div class="result">
    <table class="speaker-table">
        <tr>
            <td>Start pos</td>
            <td>Athlete</td>
            <td>Country</td>
            <td>Gold</td>
            <td>Silver</td>
            <td>Bronze</td>
            <td>Best discipline</td>
            <td>Favorite race</td>
        </tr>
    </table>
</div>

<script>

const getUrl = "https://api.dev.skateresults.app/";

// Setup
$(() => {
    // alias group
    let aliasGroup = localStorage.getItem('speakerAliasGroup');
    if(aliasGroup) {
        $("#aliasGroup").val(aliasGroup);
    }
    getAPI(getUrl + "events").receive((succsess, response) => {
        console.log(response);
        if(succsess) {
            $("#event").empty();
            $("#event").append(`<option value="-1">Select</option>`);
            for (const event of response.items) {
                $("#event").append(`<option value="${event.id}">${event.name} ${event.dateBegin}</option>`);
            }
        } else {
            alert(getUrl + " did not respond correctly!");
        }
    });
});

$("#event").change(() => {
    $('#ageGroup').prop("disabled", true);
    $('#competition').prop("disabled", true);
    $('#round').prop("disabled", true);
    $('#race').prop("disabled", true);
    const event = $("#event").val();
    if(event === "-1") return;
    $('#ageGroup').empty();
    $('#ageGroup').append(`<option>Loading...</option>`);
    getAPI(getUrl + "events/" + event + "/age-groups").receive((succsess, response) => {
        console.log(response);
        if(succsess) {
            $('#ageGroup').prop("disabled", false);
            $("#ageGroup").empty();
            $("#ageGroup").append(`<option value="-1">Select</option>`);
            for (const ageGroup of response.items) {
                $("#ageGroup").append(`<option value="${ageGroup.id}">${ageGroup.name} ${ageGroup.gender}</option>`);
            }
        } else {
            alert(getUrl + " did not respond correctly!");
        }
    });
});

$("#ageGroup").change(() => {
    $('#competition').prop("disabled", true);
    $('#round').prop("disabled", true);
    $('#race').prop("disabled", true);
    const event = $("#event").val();
    const ageGroup = $("#ageGroup").val();
    if(ageGroup === "-1" || event == "-1") return;
    $('#competition').empty();
    $('#competition').append(`<option>Loading...</option>`);
    getAPI(getUrl + "events/" + event + "/age-groups/" + ageGroup + "/competitions").receive((succsess, response) => {
        console.log(response);
        if(succsess) {
            $('#competition').prop("disabled", false);
            $("#competition").empty();
            $("#competition").append(`<option value="-1">Select</option>`);
            for (const race of response.items) {
                $("#competition").append(`<option value="${race.id}">${race.name}</option>`);
            }
            if(response.items.length == 1) {
                $("#competition").val(response.items[0].id).change();
            }
        } else {
            alert(getUrl + " did not respond correctly!");
        }
    });
});

$("#competition").change(() => {
    $('#round').prop("disabled", true);
    $('#race').prop("disabled", true);
    const event = $("#event").val();
    const ageGroup = $("#ageGroup").val();
    const competition = $("#competition").val();
    if(ageGroup === "-1" || event == "-1" || competition == "-1") return;
    $('#round').empty();
    $('#round').append(`<option>Loading...</option>`);
    getAPI(getUrl + "events/" + event + "/age-groups/" + ageGroup + "/competitions/" + competition + "/rounds").receive((succsess, response) => {
        console.log(response);
        if(succsess) {
            $('#round').prop("disabled", false);
            $("#round").empty();
            $("#round").append(`<option value="-1">Select</option>`);
            for (const race of response.items) {
                $("#round").append(`<option value="${race.id}">${race.name}</option>`);
            }
            if(response.items.length == 1) {
                $("#round").val(response.items[0].id).change();
            }
        } else {
            alert(getUrl + " did not respond correctly!");
        }
    });
});

$("#round").change(() => {
    $('#race').prop("disabled", true);
    const event = $("#event").val();
    const ageGroup = $("#ageGroup").val();
    const competition = $("#competition").val();
    const round = $("#round").val();
    if(ageGroup === "-1" || event == "-1" || competition == "-1" || round == "-1") return;
    $('#race').empty();
    $('#race').append(`<option>Loading...</option>`);
    getAPI(getUrl + "events/" + event + "/age-groups/" + ageGroup + "/competitions/" + competition + "/rounds/" + round + "/races").receive((succsess, response) => {
        console.log(response);
        if(succsess) {
            $('#race').prop("disabled", false);
            $("#race").empty();
            $("#race").append(`<option value="-1">Select</option>`);
            let i = 1;
            for (const race of response.items) {
                $("#race").append(`<option value="${race.id}">${i} (${race.done ? "(done)" : "(no results)"})</option>`);
                i++;
            }
            if(response.items.length == 1) {
                $("#race").val(response.items[0].id).change();
            }
        } else {
            alert(getUrl + " did not respond correctly!");
        }
    });
});

$("#race").change(() => {
    const event = $("#event").val();
    const ageGroup = $("#ageGroup").val();
    const competition = $("#competition").val();
    const round = $("#round").val();
    const race = $("#race").val();
    if(ageGroup === "-1" || event == "-1" || competition == "-1" || round == "-1" || race == "-1") return;
    getAPI(getUrl + "events/" + event + "/age-groups/" + ageGroup + "/competitions/" + competition + "/rounds/" + round + "/races/" + race).receive((succsess, response) => {
        if(succsess) {
            console.log(response);
            const ids = [];
            for (const result of response.athletes) {
                ids.push({
                    startPos: result.startPos,
                    rank: result.rank,
                    alias: result.athlete.id
                });
            }
            $("#idInput").val(JSON.stringify(ids));
            go();
        } else {
            alert(getUrl + " did not respond correctly!");
        }
    });
});

$("#aliasGroup").change(() => {
    localStorage.setItem('speakerAliasGroup', $("#aliasGroup").val());
});

function go() {
    let aliases = $("#idInput").val();
    if(aliases.length == 0) {
        alert("Please fill in JSON array of aliases");
        return;
    }
    if(!isJson(aliases)) {
        alert("invalid JSON");
        return;
    }
    if(!Array.isArray(JSON.parse(aliases))) {
        alert("Invalid JSON array");
        return;
    }
    aliasGroup = $("#aliasGroup").val();
    if(aliasGroup === "-1234") {
        alert("Please choose Alias Group!");
        return;
    }
    aliases = JSON.parse(aliases);
    $(".speaker-table .row").remove();
    post("aliasIds", {aliasGroup, aliases}).receive((succsess, athletes) => {
        const table = $(".speaker-table");
        for (let i = 0; i < athletes.length; i++) {
            athletes[i].startPos = aliases[i].startPos;
        }
        athletes = sortArray(athletes, "startPos", false);

        for (const athlete of athletes) {
            const row = $(`<tr class="row">
                <td>${athlete.startPos}</td>
                <td class="profile-td"/>
                <td class="country-td"/>
                <td class="gold-td">0</td>
                <td class="silver-td">0</td>
                <td class="bronze-td">0</td>
                <td class="sprinter-long-td"></td>
                <td class="best-distance-td"></td>
            </tr>`);
            if(athlete.idAthlete) {
                const profile = athleteToProfile(athlete, Profile.MIN);
                profile.openInNewTab = true;
    
                profile.dataUpdated = (data) => {
                    row.find(".gold-td").empty();
                    row.find(".gold-td").append(data.athleteData.gold + "");
                    row.find(".silver-td").empty();
                    row.find(".silver-td").append(data.athleteData.silver + "");
                    row.find(".bronze-td").empty();
                    row.find(".bronze-td").append(data.athleteData.bronze + "");
                    row.find(".sprinter-long-td").empty();
                    let sprinter = data.athleteData.medalScoreLong / data.athleteData.medalScore;
                    if(isNaN(sprinter)) sprinter = 0.5;
                    row.find(".sprinter-long-td").append(ElemParser.parse({
                        data: sprinter,
                        description1: "Sprint",
                        description2: "Long",
                        type: "slider",
                        tooltip: "Relation of Score short and long score"
                    }));
                    row.find(".best-distance-td").empty();
                    row.find(".best-distance-td").append(data.athleteData.bestDistance || "-");
                    row.find(".country-td").empty();
                    row.find(".country-td").append(data.athleteData.country || "-");
                }
    
                profile.update();
                profile.appendTo(row.find(".profile-td"));
            } else {
                const previous = JSON.parse(athlete.previous);
                row.find(".profile-td").append(`${previous.firstName || "-"} ${previous.lastName || "-"}`);
                row.find(".country-td").append(`${previous.country || "-"}`);
            }
            table.append(row);
        }
    });
}
</script>
</main>
<?php
    include_once "../footer.php";
?>