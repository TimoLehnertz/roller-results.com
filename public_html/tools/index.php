<?php
include_once "../includes/roles.php";
include_once "../includes/error.php";
if(!canI("configureAthletes")){
    throwError($ERROR_NO_PERMISSION, "/index.php");
} 

include_once "../header.php";
?>
<main class="athlete-search">
    <h1 class="align center">Competition tools</h1>
    <div class="error color red"></div>
    <a href="/tools/speaker.php">Speaker Tools</a>
    <div>
        <p>
            JSON: [{alias,firstName,lastName,[gender],[country],[category],}]
        </p>
        <textarea name="" id="" cols="30" rows="10" class="input">[{"firstName":"timo", "lastName": "Lehnertz", "alias":"001"}, {"firstName": "Felix", "lastName":"Rijhnen","country":"GER", "gender":"m", "alias":"002"}]
        </textarea>
        <button onclick="update()">Update</button>
        <div class="preview">
            
        </div>
    </div>
    <input type="text" class="aliasGroupName">
    <button onclick="apply()">Apply</button>
</main>
<script>
    // $(".input").on("input", update);

    let athletes = [];

    function update() {
        $(".error").empty();
        const text = $(".input").val();
        if(IsJson(text)) {
            const json = JSON.parse(text);
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
     *  country,
     *  category,
     *  alias
     */
    function process(search) {
        post("searchAthletes", search).receive((succsess, res) => {
            if(res) {
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
        for (const search of athletes) {
            const row = $(`<div class="select-row"></div>`);

            row.append(
            `<div class="prev-info">
                <span class="alias">${search.search.alias          || "-"}</span>
                <span class="first-name">${search.search.firstName || "-"}</span>
                <span class="last-name">${search.search.lastName   || "-"}</span>
                <span class="gender">${search.search.gender        || "-"}</span>
                <span class="country">${search.search.country      || "-"}</span>
            </div>`);

            
            const results = $(`<div class="results"></div>`);
            
            if(search.result.length > 1) {
                if(parseFloat(search.result[0].priority) > parseFloat(search.result[1].priority)) {
                    search.result[0].isBest = true;
                    search.linkId = search.result[0].id;
                }
            } else if(search.result.length === 1) {
                search.result[0].isBest = true;
                search.linkId = search.result[0].id;
            }

            const uiId = id;
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
    }

    function getGenderImg(gender) {
        switch(gender.toUpperCase()){
            case "m":
            case 'M': return `<i class="fas fa-mars"></i>`;
            case "w":
            case 'W': return `<i class="fas fa-venus"></i>`;
            case "d":
            case 'D': return `<img src="/img/diverse.png" alt="diverse">`;
        }
    }

    function apply() {
        const aliasGroup = $(".aliasGroupName").val();
        console.log(aliasGroup);
        if(aliasGroup.length <= 0) {
            alert("please provide group name");
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
        for (const athlete of athletes) {
            if(!athlete.search.alias) {
                alert("No alias given for " + athlete.search.firstName + " " + athlete.search.lastName);
                return;
            }
            aliases.aliases.push({
                idAthlete: athlete.linkId,
                alias: athlete.search.alias,
                previous: JSON.stringify(athlete.search)
            });
        }
        console.log(aliases);
        post("putAliases", aliases).receive((succsess, res) => {
            console.log(res);
        });
    }
    
    function getProfileImg(image, gender) {
        if(image != undefined){
            if(typeof image === "string"){
                return `/img/uploads/${image}`;
            }
        } else {
            if(gender.toUpperCase() === "W"){
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