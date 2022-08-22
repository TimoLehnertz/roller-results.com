<?php
include_once "../includes/roles.php";
include_once "../includes/error.php"; 
include_once "../api/index.php";
include_once "../header.php";

// if(!canI("uploadResults")) {
//     throwError($ERROR_NO_PERMISSION, "/tools/index.php");
// }

function echoCompsSelect() {
    $comps = getAllCompetitions();
    echo "<select onchange='compChanged()' class='comps-select' style='max-width: 15rem;'>";
    echo "<option value='-1234'>select</option>";
    var_dump($comps);
    foreach ($comps as $comp) {
        $type = $comp["type"];
        $year = date('Y', strtotime($comp["startDate"]));
        $location = $comp["location"]; 
        $id = $comp["idCompetition"];
        $checked = " (checked)";
        if($comp["checked"] == "0") {
            $checked = "(unchecked)";
        }
        echo "<option value='$id'>$year $type $location $checked</option>";
    }
    echo "</select>";
}

function echoAliasSelect() {
    echo "<select onchange='aliasChanged()' class='alias-select' style='max-width: 15rem;'>";
    $groups = getAliasGroups();
    if(sizeof($groups) == 0) {
        echo "<option value='-1234'>No Groups</option>";
    } else {
        echo "<option value='-1234'>Select</option>";
    }
    foreach ($groups as $group) {
        echo "<option value='".$group["aliasGroup"]."'>".$group["aliasGroup"]." (".$group["count"]." entries)</option>";
    }
    echo "</select>";
}
// print_r($comps);
?>
<script>
    const iduser = <?php 
        if(isLoggedIn()) {
            echo $_SESSION["iduser"];
        } else {
            echo "undefined";
        }
    ?>;
    const isAdmin = <?php
        if(canI("managePermissions")) {
            echo "true";
        } else {
            echo "false";
        }
    ?>;

    const canUploadResults = <?php
        if(canI("uploadResults")) {
            echo "true";
        } else {
            echo "false";
        }
    ?>;
</script>
<style>
    .create-new input {
        max-width: 8rem;
    }
</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
<div class="top-site">
        
</div>
<main class="athlete-search main">
    <div class="section light">
        <h1 class="align center margin top triple">Roller results Import procedure</h1>
        <br>
        <?php if(!canI("uploadResults")) { ?>
            <h2 class="margin top bottom">Contact us at <span class="code padding left right">roller.results@gmail.com</span> to get full accsess to this tool!</h2>
        <?php }?>
        <p>Here anybody can upload results from any competition.<br>
        Note: after you uploaded results they will appear as <span class="code">unchecked</span>
        We will review them and set them to <span class="code">checked</span> when they are correct.</p>
        <br>
        <p>
            We don't have results like on paper.
            Our results are linked with their athletes profile.
            So simply putting the name isn't sufficient.
            Names are often spelled differently or change(marriage). So when uploading results you must link every athlete to his/her corrisponding profile or create a new profile.</p>
        <p>This site will guide you through this process. Complete each step one by one.</p>
        <br>
        <p>You will need a unique identification number per athlete to upload results. In case you only upload one competition the start number will be sufficient. But we recomment something thats more long term like the license number or similar.</p>
        <br>
        <p>Linking athletes:</p>
        <p>You will be asked to link your athletes to our athletes. On the left hand side you will see the information that you provided in your file.
            The right hand side shows all skaters that we think match your input.
            If the correct skater doesnt appear search it using the search function at the top and link it manually.<br>
            Manually finding an id:<br> To find the id of a skater on roller results go to his profile and check the url at the top of your browsers window. <br>
            https://www.roller-results.com/athlete/?id=<span class="code">1973</span>&search1=bart%20sw => 1973 is the id<br><br>
            <img style="width: 80%; height: auto; margin-left: 10%;" src="/img/alias-explenation.JPG" alt="alias image">
            Furthermore there is the option to create a new Skater. Please ony create new skaters when you are sure that they do not appear on roller results yet!
            Nessesary informations are: firstname, lastname and country.
        </p>
        <br>
        <p>
            <span class="font size bigger-medium">Important:</span><br>
            When you at the upload step please take your time to check every race with its results to ensure that we your results get approved. <br><br>
            please report bugs to <span class="code">Roller.results@gmail.com</span>
        </p>
    </div>
    <div class="section dark">
        <h2 class="align center">Step 1: <span class="font size medium margin left">Create event</span></h2>
        <br>
        <p>Select competition
            <?php echoCompsSelect();?><br><br>
            <a target="blank" href="create-competition.php">Create new</a> (reload this page)
        </p>
    </div>
    <div class="section light">
        <h2 class="align center">Step 2: <span class="font size medium margin left">Alias</span></h2>
        <br>
        <p>Select Alias Group:
            <?php echoAliasSelect();?><br><br>
            <label for="newAliasName">Create new</label>
            <input id="newAliasName" type="text" class="aliasGroupName" list="existingAlias">
            <button class="btn blender alone" id="createAliasBtn" onclick="createAlias()">Create Alias</button>
        </p>
    </div>
    <div class="section dark">
        <h2 class="align center">Step 3: <span class="font size medium margin left">Select results</span></h2>
        <br>
        <p>Download excel file <a href="import-preset.xlsx">here</a> and fill in results</p><br>
        <p>Upload file here: <input type="file" id="fileUpload" onchange="uploadResultsFile()"/><br>
    </div>
    <div class="section light">
        <h2 class="align center">Step 4: <span class="font size medium margin left">Link athletes</span></h2>
        <br>
        <p class="remove-me-on-athlete-load">Upload results to proceed</p>
        <div class="preview"></div>
    </div>
    <div class="section dark">
        <h2 class="align center">Step 5:<span class="font size medium margin left">Upload</span></h2>
        <br>
        <div class="loading-placeholder"></div>
        <p class="remove-me-on-athlete-finish">Save athletes to proceed</p>
        <div class="race-preview flex mobile align-start">
            <div>
                <h3>Existing races:</h3>
                <div class="existing-races"></div>
            </div>
            <div>
                <h3>Races to add</h3>
                <div class="races-to-add"></div>
            </div>
        </div>
    </div>
</main>
<script>

// $(window).bind('beforeunload', function(){
//   return 'Are you sure you want to leave? Not uploaded data will be lost';
// });

$(() => {
    const idCompetition = sessionStorage.getItem('importScriptIdCompetition');
    if(idCompetition !== undefined) {
        $(".comps-select").val(idCompetition);
        compChanged();
    }
    const aliasGroup = sessionStorage.getItem('importScriptAliasGroup');
    if(aliasGroup !== undefined) {
        $(".alias-select").val(aliasGroup);
        aliasChanged();
    }
});

let allCountries = [];
get("countries").receive((succsess, res) => {
    if(succsess) {
        allCountries = res;
        allCountries.sort((a,b) => a.country.localeCompare(b.country));
    }
    // console.log(countries);
})

compChanged();
aliasChanged();

let existingRaces = undefined;
let existingCompetition = undefined;

function getCountrySelect() {
    const elem = $(`<select/>`);
    for (const country of allCountries) {
        elem.append(`<option value="${country.country}">${country.country}</option>`);
    }
    return elem;
}

function compChanged() {
    const idCompetition = $(".comps-select").val();
    $(".alias-select").attr("disabled",     idCompetition == "-1234");
    $("#newAliasName").attr("disabled",     idCompetition == "-1234");
    $("#createAliasBtn").attr("disabled",   idCompetition == "-1234");
    $("#fileUpload").attr("disabled",   idCompetition == "-1234");

    if(idCompetition != "-1234") {
        sessionStorage.setItem('importScriptIdCompetition', idCompetition);
        existingRaces = undefined;
        existingCompetition = undefined;
        get("competition", idCompetition).receive((succsess, comp) => {
            if(!succsess) return;
            existingRaces = comp.races;
            existingCompetition = comp;
        });
    }
}

function updateExistingRaces() {
    const idCompetition = $(".comps-select").val();
    if(idCompetition == "-1234") return;
    get("competition", idCompetition).receive((succsess, comp) => {
        if(!succsess) return;
        existingRaces = comp.races;
        existingCompetition = comp;
        $(".existing-races").empty().append(getRacesElem(existingRaces));
    });
}

function aliasChanged() {
    $("#fileUpload").attr("disabled", $(".alias-select").val() == "-1234" || $(".alias-select").val() == null);
    if($(".alias-select").val() != "-1234") {
        sessionStorage.setItem('importScriptAliasGroup', $(".alias-select").val());
    }
}

let athletes = [];

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
function process(search, aliasGroup) {
    $(".preview").empty();
    const loadingBar = new LoadingBar();
    let remaining = parseInt(athletes.length / 4);
    $(".preview").append(`<p>This will take about <span class="remaining"></span> seconds</p>`)
    $(".preview").append(loadingBar.elem);
    let interval = window.setInterval(() => {
        $(".preview").find(".remaining").text(remaining);
        remaining--;
        if(remaining < 0) {
            window.clearInterval(interval);
        }
    }, 1000);
    post("searchAthletes", {aliasGroup, athletes}).receive((succsess, res) => {
        console.log("got athlete matches from server:");
        log(res);
        loadingBar.remove();
        if(res) {
            athletes = res;
            updateUI();
        } else {
            console.log("no succsess");
        }
    });
}

function hideUnrelevant() {
    for (const athlete of athletes) {
        const matched = athlete.linkId != "-1234" && typeof athlete.linkId === "number";
        if(matched) {
            athlete.guiElem.css("display", "none");
        }
    }
}

function updateUI() {
    $(".preview").empty();
    const hideBtn = $(`<button class="btn blender alone">Hide matched</button>`);
    const showUnrelevalt = $(`<button class="btn blender alone">Show all</button>`);
    $(".preview").append(`<div class="sticky buttons"></div>`);
    $(".preview").find(".buttons").append(hideBtn);
    $(".preview").find(".buttons").append(showUnrelevalt);

    hideBtn.click(() => {
        hideUnrelevant();
    });
    showUnrelevalt.click(() => {
        for (const athlete of athletes) {
            athlete.guiElem.css("display", "block");
        }
    });

    let id = 0;
    let odd = true;
    let found = 0;
    let unsafe = 0;
    for (const athlete of athletes) {
        athlete.sureness = 0;
        for (const result of athlete.result) {
            athlete.sureness = Math.max(athlete.sureness, result.priority);
        }
    }
    athletes.sort((a, b) => a.sureness - b.sureness);
    let i = 1;
    for (const search of athletes) {
        odd = !odd;
        const row = $(`<div class="select-row" ${odd ? "style='background-color: #AAA'" : ""}></div>`);
        search.guiElem = row;
        row.append(
        `<div class="prev-info">
            <div>
                <span class="alias">${search.search.alias          || "-"}</span>
                <span class="first-name">${search.search.firstName || "-"}</span> | 
                <span class="last-name">${search.search.lastName   || "-"}</span>
                <span class="gender">${search.search.gender        || "-"}</span>
                <span class="country">${search.search.country      || "-"}</span>
                <span class="country">${search.search.category     || "-"}</span>
            </div>
            <div>#${i}</div>
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
            search.result[0].isBest = search.result[0].priority >= 2;
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
        
        search.createNew = search.result.length === 0;
        search.newAthlete = JSON.parse(JSON.stringify(search.search));
        const uiId = id;
    
        for (const athlete of search.result) {
            const athleteUid = getUid();
            const res = $(`<div class="res">
                <input id="${athleteUid}" type="radio" name="${uiId}" ${athlete.isBest ? "checked" : ""} value="${athlete.id}">
                <label for="${athleteUid}">
                    <div>${athlete.priority < 10 ? "0" + athlete.priority : athlete.priority}</div>
                    <img class="profile-img" src="${getProfileImg(athlete.image, athlete.gender)}">
                    ${getGenderImg(athlete.gender)}
                    <span class="first-name">${athlete.firstname}</span>
                    <span class="last-name">${athlete.lastname}</span>
                    <span class="">${athlete.country}</span>
                    <div><a target="_blank" href="/athlete/index.php?id=${athlete.id}"><i class="fa-solid fa-link"></i></a></div>
                </label>
            </div>`)
            results.append(res);
            if(athlete.isBest) {
                res.addClass("best");
            }
        }
        // create custom custom link
        results.append(`<div class="link-new res">
            <input class="custom-linker" id="${uiId}-2" type="radio" name="${uiId}" value="-2">
            <label for="${uiId}-2">
                Link manually
                <input id="${uiId}-link-manually" type="number" value="0">
                <div class="athlete"/>
            </label>
        </div>`);
        // create adder
        results.append(`<div class="create-new res ${search.result.length > 0 ? "" : "best"}">
            <input id="${uiId}-1" type="radio" name="${uiId}" ${search.result.length > 0 ? "" : "checked"} value="-1">
            <label id="${uiId}-label-create" for="${uiId}-1">
                <div class="create-new-inputs">Create new: 
                    <input tooltip="AthleteID" placeholder="AthleteID" name="alias" id="${uiId}-alias" value="${search.search.alias}">
                    <input tooltip="First name" placeholder="First name" name="firstName" id="${uiId}-firstName" value="${search.search.firstName}">
                    <input tooltip="Last name" placeholder="Last name" name="lastName" id="${uiId}-lastName" value="${search.search.lastName}">
                    <select id="${uiId}-gender" name="gender">
                        <option value="m" ${search.search.gender === "m" ? "selected" : ""}>Male</option>
                        <option value="w" ${search.search.gender === "w" ? "selected" : ""}>Female</option>
                    </select>
                    <input tooltip="Club" placeholder="Club" name="club" id="${uiId}-club" value="${search.search.club || ""}">
                    <input tooltip="Team" placeholder="Team" name="team" id="${uiId}-team" value="${search.search.team || ""}">
                </div>
            </label>
        </div>`);
        const countryElem = getCountrySelect();
        countryElem.attr("id", `${uiId}-country`);
        countryElem.val(search.search.country);
        results.find(`#${uiId}-label-create`).append(countryElem);
        // add listeners
        function updateAthleteSearch() {
            const idAthlete = results.find(`#${uiId}-link-manually`).val();
            results.find(`#${uiId}-1.custom-linker`).val(idAthlete);
            results.find(".athlete").empty();
            results.find(".athlete").append(`<div class="loading circle"/>`);
            get("athlete", idAthlete).receive((succsess, athlete) => {
                results.find(".athlete").empty();
                if(Array.isArray(athlete)) {
                    results.find(".athlete").append(`Invalid id`);
                    search.linkId = "-1234";
                    return;
                }
                results.find(".athlete").append(`<a target="blank" href="/athlete/index.php?id=${athlete.id}">${athlete.firstname} ${athlete.lastname} | ${athlete.country}</a>`);
                search.linkId = athlete.id;
                console.log(athlete);
            });
        }
        results.find(`.custom-linker#${uiId}-1`).on("change", () => {
            updateAthleteSearch();
        });
        results.find(`#${uiId}-link-manually`).on("change", () => {
            updateAthleteSearch();
        });
        results.find(".create-new-inputs input").on("change", function() {
            search.newAthlete[$(this).attr("name")] = $(this).val();
        });
        countryElem.on("change", function() {
            search.newAthlete["country"] = countryElem.val();
        });
        // results.find(".create-new-inputs").trigger("change");
        results.find("input[type='radio']").on("change", () => {
            search.linkId = $(`input:radio[name="${uiId}"]:checked`).val();
            row.find(".best").removeClass("best");
            $(`input:radio[name="${uiId}"]:checked`).parent().addClass("best");
            search.createNew = $(`input:radio[name="${uiId}"]:checked`).parent().hasClass("create-new");
        });
        row.append(results);
        $(".preview").append(row);
        i++;
        id++;
    }
    if(canUploadResults) {
        $(".preview").append(`<button class="save-athletes-btn btn default" onclick="update()">Save athletes</button>`);
    } else {
        $(".preview").append(`<h2 class="margin top">Contact us at <span class="code padding left right">roller.results@gmail.com</span> to get accsess to this tool</h2>`);
    }
    // $(".preview").append(`<button class="btn default" onclick="update()"></button>`);
    $(".preview").prepend(`<p>Found ${found} / ${athletes.length} Athletes. ${unsafe} not sure.</p>`)
}

function getGenderImg(gender) {
    switch(gender?.toUpperCase()){
        case "m":
        case 'M': return `<i class="fas fa-mars"></i>`;
        case "w":
        case 'W': return `<i class="fas fa-venus"></i>`;
        case "d":
        case 'D': return `<img src="/img/diverse.png" alt="diverse">`;
    }
}

function update() {
    apply($(".alias-select").val());
}

/**
 * @deprecated
 */
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

/**
 * Creates a new alias on gui level. alias only gets saved to database when athletes actually got linked
 */
function createAlias() {
    const newAlias = $("#newAliasName").val().trim();
    if(newAlias.length == 0) return alert("Please enter a name");
    if($(`.alias-select option[value='${newAlias}']`).length > 0) return alert("Alias name taken");
    $(".alias-select").append(`<option value="${newAlias}">${newAlias}</option>${$("#newAliasName").val()}`);
    $(".alias-select").val(newAlias);
    aliasChanged();
}

function checkNewAthlete(athlete, i) {
    return validateObject(athlete, {
        firstName: 2,
        lastName: 2,
        country: 3,
        gender: ["m", "w"],
    }, i);
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
    let i = 0;
    console.log(athletes);
    for (const athlete of athletes) {
        if(athlete.linkId == "-1234") return alert(`Invalid id given for ${i + 1}th athlete!`);
        if(athlete.createNew && !checkNewAthlete(athlete.newAthlete, 0)) return false;
        if(!athlete.search.alias && !athlete.search.id) {
            // alert("No alias given for " + athlete.search.firstName + " " + athlete.search.lastName);
            // return;
        }
        aliases.aliases.push({
            idAthlete: athlete.linkId != "-1" ? athlete.linkId : null,
            alias: athlete.search.alias || athlete.search.id,
            previous: JSON.stringify(athlete.search),
            createNew: athlete.createNew,
            newAthlete: athlete.newAthlete,
        });
        // save athleteId
        for (const result of results) {
            if(result.athleteID === athlete.search.alias) {
                result.idAthlete = athlete.linkId;
                break;
            }
        }
        i++;
    }
    let i1 = 1;
    for (const alias of aliases.aliases) {
        const idAthlete = alias.idAthlete;
        let error = false;
        if(idAthlete == "-1") error = true;
        if(idAthlete == undefined) error = true;
        if(idAthlete == null) error = true;
        if(alias.createNew) error = false;
        if(error) {
            console.log(alias);
            alert(`Athlete #${i1} has no id`);
            return;
        }
        i1++;
    }
    const bar = new LoadingBar();
    $(".loading-placeholder").append(bar.elem);
    $(".save-athletes-btn").attr("disabled", true);
    post("putAliases", aliases).receive((succsess, res) => {
        bar.remove();
        $(".save-athletes-btn").attr("disabled", false);
        if(succsess) {
            $(".remove-me-on-athlete-finish").hide();
            initStep5();
        } else {
            alert("An error occured");
        }
        console.log(res);
    });
}

function initStep5() {
    hideUnrelevant();
    $(".existing-races").empty();
    $(".existing-races").append(getRacesElem(existingRaces));

    // relinking athletes
    const aliasGroup = $(".alias-select").val();
    console.log("relinking athletes");
    get("aliasGroup", aliasGroup).receive((succsess, aliases) => {
        console.log("allAliases:",aliases);
        if(!succsess) {
            alert("Could not relink results to new athletes");
            return;
        }
        for (const result of results) {
            for (const alias of aliases) {
                if(result.athleteID == alias.alias) {
                    result.idAthlete = alias.idAthlete;
                    break;
                }
            }
        }
        // push linked athletes into results
        let errors = [];
        for (const result of results) {
            // find missing ids
            if(result.idAthlete === undefined || typeof result.idAthlete !== "number") {
                errors.push(result);
            }
            result.needsUpdate = true;
        }
        if(errors.length > 0) {
            console.log("results without athletes: ", errors);
            alert(errors.length + " results dont have athlete ids! check console for details");
        }
        initRaces(results);
    });
}

/**
 * compares if right has all or more properties of left with the same value
 */
function compareObjects(left, right) {
    for (const key in left) {
        if (Object.hasOwnProperty.call(left, key)) {
            if(Array.isArray(left[key])) continue; //dont compare arrays
            if(left[key] !== right[key]) return false;
        }
    }
    return true;
}

/**
 * left takes the same values for all properties that left and right share
 */
function takeFromRight(left, right) {
    for (const key in left) {
        if (Object.hasOwnProperty.call(left, key) && Object.hasOwnProperty.call(right, key)) {
            left[key] = right[key];
        }
    }
}

function log(stuff) {
    console.log(JSON.parse(JSON.stringify(stuff)));
}

function saveResults(results, idRace, callback) {
    console.log("saving results:");
    log(results);
    // cleanup
    for (const result of results) {
        result.gender = result.gender.toLowerCase();
        result.trackRoad = result.trackRoad.toLowerCase();
        result.idRace = idRace;
    }
    post("createResults", results).receive((succsess, response) => {
        if(!succsess || response != true) {
            callback(false);
            alert("Error while uploading results");
            return;
        }
        console.log("createResults - response:", response);
        callback(succsess);
    });
}

function saveRace(race, idCompetition, callback) {
    race = JSON.parse(JSON.stringify(race))
    race.idCompetition = idCompetition;
    post("createRace", race).receive((succsess, response) => {
        // response: {id: 24628} (id of inserted race)
        if(!succsess) return alert("Error occured while uploading race");
        if(response.id == undefined) return alert("Error occured while uploading race");
        callback(response.id);
    });
}

function getProfileImg(image, gender) {
    if(image != undefined){
        if(typeof image === "string"){
            return `/img/uploads/${image}`;
        }
    } else {
        if(gender?.toUpperCase() === "W") {
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

function clearFile() {
    $("#fileUpload").val(null);
}

function uploadResultsFile() {
    //Reference the FileUpload element.
    var fileUpload = document.getElementById("fileUpload");

    //Validate whether File is valid Excel file.
    var regex = /.+(.xls|.xlsx)$/;
    if (regex.test(fileUpload.value.toLowerCase())) {
        if (typeof (FileReader) != "undefined") {
            var reader = new FileReader();

            //For Browsers other than IE.
            if (reader.readAsBinaryString) {
                reader.onload = function (e) {
                    initiateResults(GetTableFromExcel(e.target.result));
                };
                reader.readAsBinaryString(fileUpload.files[0]);
            } else {
                //For IE Browser.
                reader.onload = function (e) {
                    var data = "";
                    var bytes = new Uint8Array(e.target.result);
                    for (var i = 0; i < bytes.byteLength; i++) {
                        data += String.fromCharCode(bytes[i]);
                    }
                    initiateResults(GetTableFromExcel(data));
                };
                reader.readAsArrayBuffer(fileUpload.files[0]);
            }
        } else {
            alert("This browser does not support HTML5.");
        }
    } else {
        alert("Please upload a valid Excel file.");
    }
}

function GetTableFromExcel(data) {
    var workbook = XLSX.read(data, {
        type: 'binary'
    });
    var Sheet = workbook.SheetNames[0];
    const json = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[Sheet]);
    return json;
}

let results = [];

function initiateResults(loadedResults) {
    console.log("Excel file loaded")
    clearFile();
    if(!validateResultsFormat(loadedResults)) return;
    console.log("file validated")
    $(".remove-me-on-athlete-load").hide();
    athletes = [];
    results = loadedResults;
    for (const result of results) {
        // check if existing
        let found = false;
        result.place = parseInt(result.place);
        for (const athlete of athletes) {
            if(athlete.alias === result.athleteID) found = true;
        }
        if(found) continue;
        athletes.push({
            alias: result.athleteID,
            firstName: result.firstName,
            lastName: result.lastName,
            gender: result.gender,
            country: result.country,
            club: result.club,
            team: result.team,
            category: result.category,
        })
    }
    const aliasGroup = $(".alias-select").val();
    process(athletes, aliasGroup);
}


function objectExistsInArr(a, arr) {
    for (const b of arr) {
        if(compareObjects(a, b)) {
            return true;
        }
    }
    return false;
}

function raceFromResult(result) {
    let race = {
        distance: "",
        category: "",
        gender: "",
        isRelay: "",
        trackRoad: "",
        results: []
    }
    takeFromRight(race, result);
    return race;
}

function raceByResult(result, races) {
    for (const race of races) {
        if(compareObjects(race, result)) return race;
    }
    return false;
}

function uploadAllRaces() {
    $(".upload-all-btn").attr("disabled", true); // disable all other upload buttons to prevent multiple failures
    $(".upload-bnt").attr("disabled", true); // disable all other upload buttons to prevent multiple failures
    const bar = new LoadingBar()
    $(".loading-placeholder").append(bar.elem);
    for (const race of allQuedRaces) {
        uploadRace(race);
    }
    bar.remove();
    $(".upload-bnt").attr("disabled", false);
    $(".upload-all-btn").attr("disabled", false);
    allQuedRaces = [];
}

function initRaces(results) {
    console.log("initiating races from results:", results);
    let quedRaces = [];
    allQuedRaces = [];
    $(".races-to-add").empty();
    $(".races-to-add").append(`<button class="upload-all-btn btn blender alone" onclick="uploadAllRaces()">Upload all races</button>`);
    const idCompetition = $(".comps-select").val();
    // if(idCompetition === "-1234") return alert("Please select Competition");
    for (const result of results) {
        // preprocessing
        result.distance = result.distance.toLowerCase();
        result.category = result.category.toLowerCase();
        result.gender = result.gender.toLowerCase();
        result.trackRoad = result.trackRoad.toLowerCase();
        if(!objectExistsInArr(raceFromResult(result), quedRaces)) { // new race
            const race = raceFromResult(result);
            if(race.distance !== "") {
                quedRaces.push(race);
                race.results.push(result);
            }
        } else {
            const race = raceByResult(result, quedRaces);
            race.results.push(result);
        }
    }
    // console.log("adding races: ", quedRaces);
    quedRaces = quedRaces.sort((a,b) => a.gender.localeCompare(b.gender));
    quedRaces = quedRaces.sort((a,b) => a.category.localeCompare(b.category));
    quedRaces = quedRaces.sort((a,b) => a.distance.localeCompare(b.distance));
    console.log("initiated races:");
    log(quedRaces);
    for (const race of quedRaces) {
        race.results = race.results.sort((a,b) => parseInt(a.place) - parseInt(b.place));
        addRaceToQue(race, idCompetition);
    }
}

function findExistingRace(race) {
    let testRace = {
        distance: "",
        category: "",
        gender: "",
        trackRoad: "",
    }
    // console.log("existing races:", existingRaces);
    // console.log("race:", race);
    takeFromRight(testRace, race);
    for (const existing of existingRaces) {
        existing.trackRoad = existing.trackStreet;
        if(compareObjects(testRace, existing)) {
            // console.log("existing:", testRace, existing);
            return existing;
        }
    }
    return undefined;
}

function uploadRace(race, callback) {
    if(race.results == undefined) {
        log(race);
        return alert("no results for race");
    }
    const idCompetition = $(".comps-select").val();
    console.log("uploading race:");
    log(race);
    $(".upload-bnt").attr("disabled", true); // disable all other upload buttons to prevent multiple failures
    saveRace(race, idCompetition, (insertId) => {
        console.log("uploading results:(raceid, results)", insertId, results);
        saveResults(race.results, insertId, (succsess) => {
            $(".upload-bnt").attr("disabled", false); // enable buttons regardless of succsess
            if(succsess) {
                if(callback != undefined) {
                    callback();
                }
                console.log("uploaded results");
                race?.raceElem?.remove();
                updateExistingRaces();
            } else {
                deleteRace(race, (succsess) => {
                    if(succsess) {
                        alert("removed race with invalid results");
                    } else {
                        alert("Could not remove race with invalid results. empty race remaining!");
                    }
                });
            }
        });
    });
}

function checkRaceForDoubleAthletes(race) {
    let idAthletes = [];
    let doublicates = [];
    let news = [];
    for (const result of race.results) {
        if(idAthletes.includes(result.idAthlete)) {
            console.log("found doublicate id in race: ", race, result.idAthlete);
            doublicates.push(result);
        }
        idAthletes.push(result.idAthlete);
    }
    return doublicates;
}

let allQuedRaces = [];

function addRaceToQue(race, idCompetition) {
    let doublicates = checkRaceForDoubleAthletes(race);
    race = JSON.parse(JSON.stringify(race));
    race.trackStreet = race.trackRoad;
    race.checked = true; // remove unchecked flag for this area
    race.raceYear = existingCompetition.startDate.split("-")[0];
    race.location = existingCompetition.location;
    const raceElem = getRaceElem(JSON.parse(JSON.stringify(race)), JSON.parse(JSON.stringify(race.results))); // copying results to prevent it from changing on gui side
    race.raceElem = raceElem;
    $(".races-to-add").append(raceElem);
    const uploadBtn = $(`<button class="upload-bnt btn blender alone margin left">Upload(${race.results.length})</button>`);
    uploadBtn.click((e) => {
        uploadRace(race);
        e.preventDefault();
        e.stopPropagation();
        allQuedRaces.splice(allQuedRaces.indexOf(race), 1);
    });
    const existing = findExistingRace(race);
    if(existing === undefined && doublicates.length == 0) {
        raceElem.find(".race.flex").append(uploadBtn);
        allQuedRaces.push(race);
    } else if(existing !== undefined) {
        raceElem.find(".race").append(`<a class="existing-warning code color red" target="blank" href="/race/index.php?id=${existing?.id}">Existing</a>`);
        if(isAdmin || iduser == race.creator) {
            const delBtn = $(`<button class="btn blender alone">Delete Existing</button>`);
            delBtn.click((e) => {
                deleteRace(existing, () => {
                    delBtn.remove();
                    raceElem.find(".race .existing-warning").remove();
                    if(doublicates.length == 0) {
                        raceElem.find(".race").append(uploadBtn);
                        allQuedRaces.push(race);
                    }
                });
                e.preventDefault();
                e.stopPropagation();
            });
            raceElem.find(".race").append(delBtn);
        }
    } else { // doublicate athletes
        let doublicateString = "";
        for (const doublicate of doublicates) {
            doublicateString += `firstname: ${doublicate.firstName}, lastname: ${doublicate.firstName}, id: ${doublicate.idAthlete}, place: ${doublicate.place}<br>`;
        }
        const warningId = getUid();
        raceElem.find(".race").append(`<a id="${warningId}" class="existing-warning code color red" target="blank">Doublicate athlete</span>`);
        new Tooltip("#" + warningId, doublicateString);
    }
}

function deleteRace(race, callback) {
    if(!confirm(`Are you sure to delete the race with id ${race.id}(${race.distance} ${race.gender} ${race.category})?`)) return;
    get("deleteRace", race.id).receive((succsess, res) => {
        if(!succsess) return alert("error occoured while deleting race " + race.id);
        if(res == true) {
            updateExistingRaces();
            callback(true);
        } else {
            alert(res);
            callback(false);
        }
    });
}

/**
 * Example:
 * settings: {
        distance: 3,
        isRelay: ["1", "0"],
        gender: ["m", "w"],
        category: "",
        trackRoad: ["track", "road"],
        athleteID: 1,
        firstName: 1,
        lastName: 1,
        place: "integer",
        time: "timeOrNull",
    }
    */
function validateObject(object, settings, i) {
    for (const property in settings) {
        if (Object.hasOwnProperty.call(settings, property)) {
            const propertySettings = settings[property];
            let value = object[property];
            // alert required but empty
            if((value === undefined || value === null) && propertySettings !== "timeOrNull") {
                console.log(object)
                return parseErrorAt(i, property + " required");
            }
            // trim strings
            if(typeof value === "string") {
                object[property] = object[property].trim();
                value = object[property];
            }
            // alert too short values
            if(typeof propertySettings === 'number' && value.length < propertySettings) return parseErrorAt(i, `min ${propertySettings} characters required for field ${property}`);
            if(Array.isArray(propertySettings)) {
                let succsess = false;
                for (const option of propertySettings) {
                    if(option.toLowerCase() === value.toLowerCase()) {
                        succsess = true;
                        break;
                    }
                }
                if(!succsess) return parseErrorAt(i, `"${value}" is invalid for ${property}. Allowed values are: ${propertySettings}`);
            }
            // alert invalid integers
            if(propertySettings === "integer" && !Number.isInteger(parseFloat(value))) return parseErrorAt(i, `Only integers allowed for field ${property}. given: "${value}"`);
            // alert wrong times
            if(propertySettings === "timeOrNull" && !isTimeOrNull(value)) return parseErrorAt(i, `Invalid time "${value}" use format hh:mm:ss.uuu!"`);
        }
    }
    return true;
}

function validateResultsFormat(results) {
    const validResult = {
        distance: 3,
        isRelay: ["1", "0"],
        gender: ["m", "w"],
        category: "",
        trackRoad: ["track", "road"],
        athleteID: 1,
        firstName: 2,
        lastName: 2,
        place: "integer",
        time: "timeOrNull",
        // country: 3,
    }
    let i = 0;
    for (const result of results) {
        if(!validateObject(result, validResult, i)) return false;
        i++;
    }
    return true;
}

function isTimeOrNull(time) {
    if(time === null || time === undefined) return true;
    return time.match("(0[0-9]|1[0-9]|2[1-4]):(0[0-9]|[1-5][0-9]):(0[0-9]|[1-5][0-9])\.(00[0-9]|0[0-9][0-9]|[0-9][0-9][0-9])") !== null;
}

function parseErrorAt(row, msg) {
    alert(`Invalid result in row ${row}. ${msg}`);
    return false;
}
</script>
<?php
    include_once "../footer.php";
?>