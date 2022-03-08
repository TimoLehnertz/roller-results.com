<?php
include_once "../header.php";
include_once "../api/index.php";
?>
<div class="form">
    <p class="margin bottom" >Get data from skateresults:</p>
    <label for="event">Event:</label>
    <select id="event"><option value="-1">Loading...</option></select>
    <label for="ageGroup">Age group:</label>
    <select id="ageGroup" disabled><option value="-1">Select event</option></select>
    <label for="competition">Competition:</label>
    <select id="competition" disabled><option value="-1">Select age group</option></select>
    
</div>
<label for="aliasGroup">Alias group: </label>
<select id="aliasGroup">
<?php
    $groups = getAliasGroups();
    if(sizeof($groups) === 0) {
        echo "<option value='NOPE123'>You dont have any alias groups Yet!</option>";
    } else {
        echo "<option value='NOPE123'>Select</option>";
    }
    foreach ($groups as $group) {
        echo "<option value='$group'>$group</option>";
    }
?>
</select>
<textarea class="input" id="" cols="30" rows="10" placeholder="[001,002,...]">["001", "002"]</textarea>
<button class="go">Go</button>

<div class="result">

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
    const event = $("#event").val();
    if(event === "-1") return;
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
    const event = $("#event").val();
    const ageGroup = $("#ageGroup").val();
    if(ageGroup === "-1" || event == "-1") return;
    getAPI(getUrl + "events/" + event + "/age-groups/" + ageGroup + "/competitions").receive((succsess, response) => {
        console.log(response);
        if(succsess) {
            $('#agegroup').prop("disabled", false);
            $("#agegroup").empty();
            $("#agegroup").append(`<option value="-1">Select</option>`);
            for (const race of response.items) {
                $("#agegroup").append(`<option value="${race.id}">${race.name}</option>`);
            }
        } else {
            alert(getUrl + " did not respond correctly!");
        }
    });
});

$("#aliasGroup").change(() => {
    console.log("change")
    localStorage.setItem('speakerAliasGroup', $("#aliasGroup").val());
});

$(".go").click(() => {
    let aliases = $(".input").val();
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
    if(aliasGroup === "NOPE123") {
        alert("Please choose Alias Group!");
        return;
    }
    aliases = JSON.parse(aliases);
    $(".result").empty();
    post("aliasIds", {aliasGroup, aliases}).receive((succsess, athletes) => {
        console.log(athletes);
        for (const athlete of athletes) {
            const profile = athleteToProfile(athlete, Profile.MIN);
            profile.openInNewTab = true;
            profile.update();
            profile.appendTo($(".result"));
        }
    });
});
</script>

<?php
    include_once "../footer.php";
?>