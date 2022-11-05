<?php
include_once "../includes/roles.php";
include_once "../includes/error.php"; 
include_once "../api/index.php";
include_once "../header.php";
?>
<main class="athlete-search">
    <h1 class="align center">Speaker tools</h1>
    <div>
    <?php if(canI("speaker")){?>
        <div class="form">
            <p class="margin bottom" >Get data from skateresults:</p>
            <p>
                <label for="event">Event:</label>
                <select id="event"><option value="-1">Loading...</option></select>
            </p>
        </div>
    <?php }?>
        <div class="flex">
            <div>
                <p>
                    JSON: [{alias,firstName,lastName,[gender],[nation],[category],}]
                </p>
                <textarea id="athletes" cols="30" rows="10" class="input">
                    [{"id":"Y7691WVNknxjamM0s5Pp-10","bib":444,"lastName":"Biro","firstName":"Hanna","club":"Tornado Team","team":"Hungary","nation":"HUN","event":"1CBRQqdJC0Qulu5vfL6g","ageGroup":"Y7691WVNknxjamM0s5Pp-353"}]
                </textarea>
                <button onclick="updateSearch()">Update</button>
            </div>
            <div>
                <p>
                    CSV: firstname;lastname;firstname;lastname
                </p>
                <textarea id="csvAthletes" cols="30" rows="10" class="input">Felix;Rijhnen;Bart;Swings</textarea>
                <button onclick="updateCsvSearch()">Update</button>
            </div>
        </div>
        <br>
        <br>
    </div>
    <?php if(canI("speaker")){?>
    <p class="aliasArea">
        <label for="existingAlias" class="margin right double">Existing</label><br>
        <select id="existingAlias">
            
        <?php
            $groups = getAliasGroups();
            if(sizeof($groups) == 0) {
                echo "<option value='-1234'>No Groups</option>";
            } else {
                echo "<option value='-1234'>Select</option>";
            }
            foreach ($groups as $group) {
                echo "<option value='".$group["aliasGroup"]."'>".$group["aliasGroup"]." (".$group["count"]." entries)</option>";
            }
        ?>
        </select>
        <button onclick="update()">Update Alias</button>
        <button onclick="deleteAlias()">Delete Alias</button><br><br><br>
        
        <label for="newAliasName">Create new</label><br>
        <input id="newAliasName" type="text" class="aliasGroupName" list="existingAlias">
        <button onclick="createAlias()">Create Alias</button>
    </p>
    <br>
    <hr>
    <br>
    <?php }?>
    <div class="preview">

    </div>
</main>
<script>

const getUrl = "https://api.skateresults.app/";

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
    const event = $("#event").val();
    if(event === "-1") return;
    $(".form").append(`<div class="loading circle"/>`);
    getAPI(getUrl + "events/" + event + "/athletes").receive((succsess, response) => {
        $(".loading").remove();
        if(succsess) {
            console.log(response);
            $("#athletes").empty();
            $("#athletes").val(JSON.stringify(response.items));
            updateSearch();
        } else {
            alert(getUrl + " did not respond correctly!");
        }
    });
});

let athletes = [];

function updateCsvSearch() {
    $(".error").empty();
    const text = $("#csvAthletes").val();
    const athletes = [];
    const split = text.split(';');
    for (let i = 0; i < split.length; i+=2) {
        athletes.push({
            firstName: split[i].trim(),
            lastName: split[i+1]?.trim()
        });
    }
    process(athletes);  
}

function updateSearch() {
    $(".error").empty();
    const text = $("#athletes").val();
    if(IsJson(text)) {
        const json = JSON.parse(text);
        console.log(json);
        process(json);
    } else {
        $(".error").append(`Invalid JSON`);
    }
}

/**
 * Valid athlete properties:
 *  firstName,
 *  lastName,
 *  gender,
 *  nation,
 *  category,
 *  alias
 */
function process(search) {
    post("searchAthletes", search).receive((succsess, res) => {
        if(res) {
            console.log(res);
            athletes = res;
            updateUI();
        } else {
            console.log("no succsess");
        }
    });
}

function updateUI() {
    $(".preview").empty();
    let id = 0;
    let odd = true;
    let found = 0;
    let unsafe = 0;
    for (const search of athletes) {
        odd = !odd;
        const row = $(`<div class="select-row" ${odd ? "style='background-color: #333;'" : ""}></div>`);

        row.append(
        `<div class="prev-info">
            <span class="alias">${search.search.alias          || "-"}</span>
            <span class="first-name">${search.search.firstName || "-"}</span>
            <span class="last-name">${search.search.lastName   || "-"}</span>
            <span class="gender">${search.search.gender        || "-"}</span>
            <span class="country">${search.search.country      || "-"}</span>
        </div>`);

        
        const results = $(`<div class="results"></div>`);
        
        // deleting doublicates
        const ids = [];
        const newResults = [];
        for (const result of search.result) {
            if(!ids.includes(result.id)) {
                newResults.push(result);
                ids.push(result.id);
            }
        }
        search.result = newResults;

        let match = false;
        if(search.result.length > 1) {
            if(parseFloat(search.result[0].priority) > parseFloat(search.result[1].priority)) {
                search.result[0].isBest = search.result[0].priority > 2;
                search.linkId = search.result[0].id;
            }
        } else if(search.result.length === 1) {
            search.result[0].isBest = search.result[0].priority > 2;
            search.linkId = search.result[0].id;
        }
        if(search.result.length > 0 && search.result[0].isBest) {
            found++;
            match = true; 
            while(search.result.length > 3) {
                search.result.pop();
            }
        }
        if(search.result.length > 0 && !search.result[0].isBest) {
            unsafe++;
        }

        const uiId = id;
        
        // empty radio
        results.append(`<div class="res padding top bottom">
            <input id="${uiId}-1" type="radio" name="${uiId}" ${match ? "" : "checked"} value="-1">
            <label for="${uiId}-1">
                <div>No selection</div>
            </label>
        </div>`);
        
        for (const athlete of search.result) {
            const athleteUid = getUid();
            const res = $(`<div class="res">
                <input id="${athleteUid}" type="radio" name="${uiId}" ${athlete.isBest ? "checked" : ""} value="${athlete.id}">
                <label for="${athleteUid}">
                    <div>${athlete.priority}</div>
                    <img class="profile-img" src="${getProfileImg(athlete.image, athlete.gender)}">
                    ${getGenderImg(athlete.gender)}
                    <span class="first-name">${athlete.firstname}</span>
                    <span class="last-name">${athlete.lastname}</span>
                    <span class="">${athlete.country}</span>
                    <div><a target="_blank" href="/athlete/index.php?id=${athlete.id}"><i class="fa-solid fa-link"></i></a></div>
                </label>
            </div>`)
            results.append(res);
            results.find("input").on("change", () => {
                search.linkId = $(`input:radio[name="${uiId}"]:checked`).val();
                row.find(".best").removeClass("best");
                $(`input:radio[name="${uiId}"]:checked`).parent().addClass("best");
                console.log(athletes);
            });
            if(athlete.isBest) {
                res.addClass("best");
            }
        }
        row.append(results);
        $(".preview").append(row);
        id++;
    }
    window.setTimeout(() => {
        alert(`Found ${found} / ${athletes.length} Athletes. ${unsafe} not sure.`);
    }, 100);
}

function getGenderImg(gender) {
    switch(gender?.toUpperCase()){
        case "m":
        case 'M': return `<i class="fas fa-mars"></i>`;
        case "w":
        case 'W': return `<i class="fas fa-venus"></i>`;
        case "d":
        case 'D': return `<i><img src="/img/diverse.png" alt="diverse"></i>`;
    }
}

function update() {
    apply($("#existingAlias").val());
}

function deleteAlias() {
    const aliasGroup = $("#existingAlias").val();
    if(aliasGroup === "-1234") return;
    const aliases = {
        aliases: [], // empty to remove all from db
        aliasGroup
    };
    $(".aliasArea").append(`<div class="loading circle"/>`)
    post("putAliases", aliases).receive((succsess, res) => {
        $(".loading").remove();
        $(`#existingAlias option[value='${aliasGroup}']`).each(function() {
            $(this).remove();
        });
        if(succsess) {
            window.setTimeout(() => {
                alert(`succsesfully Deleted ${aliasGroup}`);
            }, 100);
        } else {
            alert("An error occured");
        }
    });
}

function createAlias() {
    apply($("#newAliasName").val());
}

function apply(aliasGroup) {
    // const aliasGroup = $(".aliasGroupName").val();
    if(aliasGroup.length <= 0) {
        alert("please provide group name");
        return;
    }
    if(aliasGroup === "-1234") {
        alert("Please select alias group!");
        return;
    }
    if(aliasGroup.length > 128) {
        alert("Group name can't be longer than 128 chars");
        return;
    }
    const aliases = {
        aliases: [],
        aliasGroup
    };
    if(athletes.length == 0) {
        alert("Fill JSON or select event first!");
        return;
    }
    console.log(athletes);
    for (const athlete of athletes) {
        if(!athlete.search.alias && !athlete.search.id) {
            // alert("No alias given for " + athlete.search.firstName + " " + athlete.search.lastName);
            // return;
        }
        aliases.aliases.push({
            idAthlete: athlete.linkId != "-1" ? athlete.linkId : null,
            alias: athlete.search.alias || athlete.search.id,
            previous: JSON.stringify(athlete.search)
        });
    }
    console.log(aliases);
    $("main").append(`<div class="loading circle"/>`);
    post("putAliases", aliases).receive((succsess, res) => {
        $(".loading").remove();
        if(succsess) {
            alert("Succsess");
        } else {
            alert("An error occured");
        }
        console.log(res);
    });
}

function getProfileImg(image, gender) {
    if(image != undefined){
        if(typeof image === "string"){
            return `/img/uploads/${image}`;
        }
    } else {
        if(gender?.toUpperCase() === "W"){
            return `/img/profile-female.png`
        } else{
            return `/img/profile-men.png`;
        }
    }
}

function IsJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
</script>
<?php
    include_once "../footer.php";
?>