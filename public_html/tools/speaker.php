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
    <p>
        <label for="history">History:</label>
        <select id="history">

        </select>
        <button onclick="deleteHistory()">Delete</button>
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

<div class="speaker-settings align center">
    <label for="sort-method">Sort by</label>
    <select id="sort-method">
        <option value="startPos">Start pos</option>
        <option value="medal">Medal(gold, silver, bronze)</option>
        <option value="nation">Nation</option>
        <option value="club">club</option>
    </select>
    <select id="sort-asc-desc">
        <option value="asc">🔼 </option>
        <option value="desc">🔽  </option>
    </select>
</div>
<div class="result">
    <table class="speaker-table">
        <tr>
            <td>Start pos</td>
            <td>Athlete</td>
            <td>Details</td>
            <td>Country</td>
            <td>Club</td>
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

let eventName;
let ageGroupName;
let competitionName;
let roundName;
let raceName;

// Setup
$(() => {
    // alias group
    let aliasGroup = localStorage.getItem('speakerAliasGroup');
    if(aliasGroup) {
        $("#aliasGroup").val(aliasGroup);
    }
    getAPI(getUrl + "events").receive((succsess, response) => {
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
    eventName = $("#event option:selected" ).text();
    $('#ageGroup').empty();
    $('#ageGroup').append(`<option>Loading...</option>`);
    getAPI(getUrl + "events/" + event + "/age-groups").receive((succsess, response) => {
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
    ageGroupName = $("#ageGroup option:selected" ).text();
    $('#competition').empty();
    $('#competition').append(`<option>Loading...</option>`);
    getAPI(getUrl + "events/" + event + "/age-groups/" + ageGroup + "/competitions").receive((succsess, response) => {
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
    competitionName = $("#competition option:selected" ).text();
    $('#round').empty();
    $('#round').append(`<option>Loading...</option>`);
    getAPI(getUrl + "events/" + event + "/age-groups/" + ageGroup + "/competitions/" + competition + "/rounds").receive((succsess, response) => {
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
    roundName = $("#round option:selected" ).text();
    $('#race').empty();
    $('#race').append(`<option>Loading...</option>`);
    getAPI(getUrl + "events/" + event + "/age-groups/" + ageGroup + "/competitions/" + competition + "/rounds/" + round + "/races").receive((succsess, response) => {
        if(succsess) {
            $('#race').prop("disabled", false);
            $("#race").empty();
            $("#race").append(`<option value="-1">Select</option>`);
            let i = 1;
            for (const race of response.items) {
                $("#race").append(`<option value="${race.id}">${i} ${race.done ? "(done)" : "(no results)"}</option>`);
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
    raceName = $("#race option:selected" ).text();
    $(".result").prepend(`<div class="loading circle"/>`);
    getAPI(getUrl + "events/" + event + "/age-groups/" + ageGroup + "/competitions/" + competition + "/rounds/" + round + "/races/" + race).receive((succsess, response) => {
        if(succsess) {
            const ids = [];
            for (const result of response.athletes) {
                ids.push({
                    startPos: result.startPos,
                    rank: result.rank,
                    alias: result.athlete.id
                });
            }
            lastRaceId = race + round + competition;
            $("#idInput").val(JSON.stringify(ids));
            cachHistory = true;
            go();
        } else {
            alert(getUrl + " did not respond correctly!");
        }
    });
});

$("#sort-method").change(() => {
    display(lastAthletes);
});

$("#sort-asc-desc").change(() => {
    display(lastAthletes);
});

$("#aliasGroup").change(() => {
    localStorage.setItem('speakerAliasGroup', $("#aliasGroup").val());
});

let lastAthletes;
let lastAliases;
let lastRaceId;

function go() {
    $(".loading").remove();
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
    $(".racePath").remove();
    $(".result").prepend(`<div class="racePath"><hr><div class="path margin top bottom">
        <span class="elem margin left right">${eventName}<span class="delimiter">></span></span>
        <span class="elem margin left right">${ageGroupName}<span class="delimiter">></span></span>
        <span class="elem margin left right">${competitionName}<span class="delimiter">></span></span>
        <span class="elem margin left right">${roundName}<span class="delimiter">></span></span>
        <span class="elem margin left right">${raceName}</span>
        </div><hr></div>`);
    aliases = JSON.parse(aliases);
    
    post("aliasIds", {aliasGroup, aliases}).receive((succsess, athletes) => {
        if(succsess) {
            for (let i = 0; i < athletes.length; i++) {
                athletes[i].startPos = aliases[i].startPos;
                athletes[i].previousJson = JSON.parse(athletes[i].previous);
                athletes[i].club = athletes[i].previousJson.club;
                athletes[i].country = athletes[i].previousJson.country;
            }
            lastAliases = aliases;
            lastAthletes = athletes;
            display(athletes);
        } else {
            alert("Invalid answer!");
        }
    });
}

function getDetailContentFor(athlete) {
    if(!athlete.idAthlete) {
        return $(`<div>No information for this athlete :("</div>`);
    }
    const elem = $(`<div class="font size bigger-medium">
        <p class="font size big">${athlete.firstname} ${athlete.lastname}</p>
        <div class="loading circle"></div>
    </div>`);
    get("athleteMedals", athlete.idAthlete).receive((succsess, results) => {
        console.log(results);
        elem.find(".loading").remove();
        if(!succsess) return;
        let idCompetition;
        let competition;
        let year;
        let gold = 0;
        let silver = 0;
        let bronze = 0;
        let disciplines = [];
        for (const result of results) {
            const newYear = new Date(result.startDate).getFullYear();
            if(idCompetition != result.idCompetition) {
                elem.append(getCompetition());
                gold = 0;
                silver = 0;
                bronze = 0;
                disciplines = [];
                idCompetition = result.idCompetition;
                competition = result.type + " | " + result.location;
            }
            if(year != newYear) {
                year = newYear;
                elem.append(`<hr><p>${year}</p>`);
            }
            disciplines.push({
                discipline: result.distance,
                place: result.place
            });
            if(result.place == 1) gold++;
            if(result.place == 2) silver++;
            if(result.place == 3) bronze++;

        }
        elem.append(getCompetition());

        function getCompetition() {
            if(!competition) return $();
            const elem =  $(`<div class="display flex column align-end"></div>`);
            const comp = $(`<div class="flex row"><span>${competition}</span></div>`);
            comp.append(getMedal("gold", gold, gold + " Gold medals"));
            comp.append(getMedal("silver", silver, silver + " Silver medals"));
            comp.append(getMedal("bronze", bronze, bronze + " Bronze medals"));
            elem.append(comp);
            for (const discipline of disciplines) {
                const disElem = $(`<div class="flex row justify-end"><span class="font size medium">${discipline.discipline}</span></div>`);
                const p = discipline.place;
                const m = p == 1 ? "gold": (p == 2 ? "silver" : "bronze");
                disElem.append(getMedal(m));
                elem.append(disElem);
            }
            return elem;
        }
    });
    return elem;
}

function isRaceVisited(idRace) {
    const history = sessionStorage.getItem('speakerHistory');
    for (const elem of history) {
        if(elem.idRace == idRace) return true;
    }
    return false;
}

let cachHistory = true;

$("#history").change(() => {
    const raceId = $("#history").val();
    const history = JSON.parse(sessionStorage.getItem('speakerHistory'));
    console.log(history);
    for (const elem of history) {
        if(elem.raceId == raceId) {
            eventName = elem.eventName;
            ageGroupName = elem.ageGroupName;
            competitionName = elem.competitionName;
            roundName = elem.roundName;
            raceName = elem.raceName;
            $("#idInput").val(JSON.stringify(elem.athletes));
            lastRace = elem.raceId;
            cachHistory = false;
            go();
            return;
        }
    }
});

$(updateHistory);

function deleteHistory() {
    sessionStorage.setItem('speakerHistory', "[]");
    $("#history").empty();
}

function updateHistory() {
    $("#history").empty();
    const history = JSON.parse(sessionStorage.getItem('speakerHistory'));
    if(!history) {
        sessionStorage.setItem('speakerHistory', "[]");
    }
    $("#history").append(`<option value="-1">Select</option>`);
    for (const elem of history.reverse()) {
        $("#history").append(`<option value="${elem.raceId}">${elem.name}</option>`);
    }
}

let detailsId;
function display(athletes) {
    const aliases = lastAliases;

    if(cachHistory) {
        const history = JSON.parse(sessionStorage.getItem('speakerHistory'));
        history.push({
            athletes,
            aliases,
            raceId: lastRaceId,
            name: `${competitionName} ${roundName} ${raceName}`,
            eventName,
            ageGroupName,
            competitionName,
            roundName,
            raceName
        });
        sessionStorage.setItem('speakerHistory', JSON.stringify(history));
        updateHistory();
    }

    const table = $(".speaker-table");
    $(".speaker-table .row").remove();
    const asc = $("#sort-asc-desc").val() != "asc";
    const sortMethod = $("#sort-method").val();
    if(sortMethod == "medal") {
        athletes = sortArray(athletes, "gold", asc);
        athletes = sortArray(athletes, "silver", asc);
        athletes = sortArray(athletes, "bronze", asc);
    }
    if(sortMethod == "startPos") {
        athletes = sortArray(athletes, "startPos", asc);
    }
    if(sortMethod == "nation") {
        athletes = sortArray(athletes, "country", asc);
    }
    if(sortMethod == "club") {
        athletes = sortArray(athletes, "club", asc);
    }

    for (const athlete of athletes) {
        const row = $(`<tr class="row">
            <td>${athlete.startPos}</td>
            <td class="profile-td"/>
            <td class="details-td"/>
            <td class="country-td"/>
            <td class="club-td"/>
            <td class="gold-td">0</td>
            <td class="silver-td">0</td>
            <td class="bronze-td">0</td>
            <td class="sprinter-long-td"></td>
            <td class="best-distance-td"></td>
            </tr>`);
        const uid = getUid();
        const previous = JSON.parse(athlete.previous);
        const detailToggle = $(`<button class="detail-toggle">+</button>`);
        detailToggle.click(function() {
            if(toggleDetailsOn($(this), getDetailContentFor(athlete))) {// opened
                $(".detail-toggle").text("+");
                $(this).text("-");
                detailsId = uid;
            } else {// closed
                if(uid !== detailsId) {
                    toggleDetailsOn($(this), getDetailContentFor(athlete));
                    $(".detail-toggle").text("+");
                    $(this).text("-");

                    detailsId = uid;
                } else {
                    $(this).text("+");
                }
            }
        })
        row.find(".details-td").append(detailToggle)
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
            row.find(".profile-td").append(`${previous.firstName || "-"} ${previous.lastName || "-"}`);
            row.find(".country-td").append(`${previous.country || "-"}`);
        }
        row.find(".club-td").append(`${previous.club || "-"}`);
        table.append(row);
    }
}

let detailsVisible = false;
function toggleDetailsOn(target, details) {
    if(detailsVisible) {
        hideDetails();
    } else {
        showDetailsOn(target, details);
    }
    return detailsVisible;
}

function showDetailsOn(target, detailsElem) {
    detailsElem.addClass("details")
    // $(".details").empty();
    // $(".details").append(detailsElem);
    // $(".details").removeClass("hidden");
    // const details = $(".details").detach();
    target.parent().append(detailsElem);
    detailsVisible = true;
}

function hideDetails() {
    $(".details").addClass("hidden");
    detailsVisible = false;
}
</script>
</main>
<?php
    include_once "../footer.php";
?>