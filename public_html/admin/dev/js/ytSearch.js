/**
 * yt api key inline data:
    AIzaSyAMKwOKCbFDbwGD0nNplSWSuYjqoawgwyk
 * yt api key tlehnertz1:
    AIzaSyAadAdnWAm1uVD1db4d7AXhkMmbVcvy0zk
 * yt api key skyteanimotion:
    AIzaSyB0XCAvGlFcVU6ayLIKbSH7TUTgJtvCsVk
 */

const keys = [
    "AIzaSyAMKwOKCbFDbwGD0nNplSWSuYjqoawgwyk",
    "AIzaSyAadAdnWAm1uVD1db4d7AXhkMmbVcvy0zk",
    "AIzaSyB0XCAvGlFcVU6ayLIKbSH7TUTgJtvCsVk",
    "AIzaSyB11ZR7BnfJbpeWlWVEUw3GpZ-BWYhONH8",
    "AIzaSyCWcwXfGHDnFxgnjO2wMGskXly3mw6F_Fc"
]

let races = [];

initRaces();

function initRaces(){
    get("races").receive((succsess, response) => {
        races = response;
        for (const race of races) {
            race.links = [];
        }
        races = races.filter(r => {
            // console.log(parseInt(r.raceYear) > 2005)
            // let pass = parseInt(r.raceYear) > 2005;

            let pass = true;
            pass = pass && r.type == "WM";

            return pass;
        });
        console.log("races:")
        console.log(races);
    });
}

function getSearchTerms(callback){
    const terms = [];
    for (let i = 0; i < races.length; i++) {
        terms.push(termFromRace(races[i]));
    }
    callback(terms);
}

// WM 2019 Espana Barcelona one Lap Road Senior W
function waysToWrite(dis){
    let ways = [];
    const numeric = parseInt(dis.replace(/\D/g,''));
    if(!isNaN(numeric)){
        ways.push(numeric + " ");
        ways.push(numeric + "M");
        ways.push(numeric + "m");
        const ns = numeric + "";
        if(ns.length > 3){
            ways.push(ns.substring(0, ns.length - 3) + " " + ns.substring(ns.length - 3, ns.length));
            ways.push(ns.substring(0, ns.length - 3) + "." + ns.substring(ns.length - 3, ns.length));
            ways.push(ns.substring(0, ns.length - 3) + "," + ns.substring(ns.length - 3, ns.length));
        }
        if(numeric >= 1000){
            ways.push(Math.floor(numeric / 1000) + "K");
            ways.push(Math.floor(numeric / 1000) + " K");
            ways.push(Math.floor(numeric / 1000) + "Km");
            ways.push(Math.floor(numeric / 1000) + " Km");
        }
    }
    ways.push(dis);
    if(dis.toLowerCase().includes("one lap")){
        ways.push("1 lap");
    }
    return ways;
}

function waysToWriteGender(gender){
    if(gender.toLowerCase() === "m"){
        return [" m ", " men", "boys", "jongens", "Varones"];
    } else{
        return [" w ", "women", "girls", "ladies", "dames", "damas"];
    }
}

function waysToWriteCategory(cat){
    if(cat.toLowerCase() === "junior"){
        return [" J ", "JUN", "junior"];
    } else{
        return [" S ", "SEN", "senior"];
    }
}

function waysToWriteType(type){
   switch(type){
       case "WM":                   return ["WM", "world championchip", "WRG", "World Roller Games", "World Roller Speed Skating Championships", "World Speed Skating Championship", "worlds"];
       case "Youth Olympic Games":  return ["YOG", "Youth Olympic Games"];
       case "World Games":          return ["WG", "World Games", "WRG", "World Roller games"];
       case "EM":                   return ["EM", "European championship", "euros"];
       case "Cadets Challenge":     return ["Cadets Challenge", "Oostende", "Zandvorde"];
       case "Universiade":          return ["Universiade"];
       case "Combined":             return ["Combined", "WM"];
       case "EC":                   return ["EC", "europe cup", "europa cup"];
       default:                     return ["3peiuwhwufhwe"];
   }
}

function waysToWriteRaceType(distance){
    if(distance.toLowerCase().includes("points/elimination")){
        return ["points/elimination", "points+elimination", "points elimination", "punkte ausscheidung", "punkte/ausscheidung", "punkte+ausscheidung", "Pts./Elim.", "Pts.+Elim.", "Pts. Elim."]
    }
    if(distance.includes("points")){
        return ["points", "punkte", "pts"]
    }
    if(distance.includes("elimination")){
        return ["points", "punkte", "elim"]
    }
    return [" "];//default should always match
}




function termFromRace(r){
    // console.log(r)
    let gender = "men";
    let relay = " ";
    if(r.relay !== 0){
        relay = " relay ";
    }
    if(r.gender.toLowerCase() === "w"){
        gender = "women";
    }
    return {
        race: r,
        term: `${r.location} "${r.distance}"${relay}${r.category} ${gender} ${r.raceYear} skate`
    };
}

function start(){
    let raceCount = 0;
    for (const race of races) {
        getSearchLocal(race.idRace, (json) => {
            // if(json === null || parseInt(race.raceYear) < 2018){
            if(json === null || parseInt(race.raceYear) < 2005){
                return;
            }
            const e = rowFromSearch(json, race);
            $("body").append(e);
            race.elem = e;
            raceCount++;
        });
    }
    $("body").append(`<button onclick="process()">Get result</button>`);
    $("body").prepend(`<p>Found ${foundRaces} of ${raceCount} races</p>`);
}

function process(){
    console.log(races);
}

let foundRaces = 0;
function rowFromSearch(search, race){
    if(search.items.length === 0){
        return $();
    }
    const row = $(`<div style="display: flex; flex-direction: column; margin-top: 3rem;">
        <h3 style="font-size: 1.5rem; text-align: center;">${race.description}</h3>
    </div>`);
    const list = $(`<div style="display: flex;"></div>`);
    let found  = false;
    for (const item of search.items) {
        if(item.kind === "youtube#searchResult"){
            const e = prevFromItem(item, race);
            if(e.hasClass("active")){
                list.prepend(e);
                if(!found){
                    foundRaces++;
                }
                found  = true;

            } else{
                list.append(e);
            }
        }
    }
    row.append(list);
    return row;
}

function prevFromItem(item, race){

    const link = `https://www.youtube.com/watch?v=${item.id.videoId}`;
    
    let title = item.snippet.title;
    let foundDistance = false;
    for (const way of waysToWrite(race.distance)) {
        const pos = title.toLowerCase().indexOf(way.toLowerCase());
        if(pos !== -1){
            foundDistance = true;
            break;
        }
    }

    let foundGender = false;
    for (const way of waysToWriteGender(race.gender)) {
        const pos = title.toLowerCase().indexOf(way.toLowerCase());
        if(pos !== -1){
            foundGender = true;
            break;
        }
    }

    let foundYear = title.indexOf(race.raceYear) !== -1;

    if(!foundYear && item.snippet.publishedAt.substring(0, 4) == race.raceYear){
        foundYear = true;
    }
    
    let foundCategory = false;
    for (const way of waysToWriteCategory(race.category)) {
        if(title.toLowerCase().indexOf(way.toLowerCase()) !== -1){
            foundCategory = true;
            break;
        }
    }
    if(!foundCategory && race.category == "Senior"){
        foundCategory = true;
    }

    let foundType = false;
    for (const way of waysToWriteType(race.type)) {
        if(title.toLowerCase().indexOf(way.toLowerCase()) !== -1){
            foundType = true;
            break;
        }
    }

    let foundRaceType = false;
    if(race.distance === null){
        console.log(race);
    }
    for (const way of waysToWriteRaceType(race.distance)) {
        if(title.toLowerCase().indexOf(way.toLowerCase()) !== -1){
            foundRaceType = true;
            break;
        }
    }

    let foundLocation = title.toLowerCase().indexOf(race.location.toLowerCase()) !== -1 || title.toLowerCase().indexOf(race.country.toLowerCase()) !== -1;

    const elem = $(`<div class="video" style="display: flex; flex-direction: column; padding: 0.5rem">
        <img width="200" height="150" src="${item.snippet.thumbnails.default.url}">
    </div>`);
    elem.append(`<div>
        <div style="margin-bottom: 1rem; font-size: 1.3rem">${title}</div>
        <hr>
        <div style="margin-bottom: 0.5rem; font-size: 1.1rem">${item.snippet.channelTitle}</div>
        <div style="margin-bottom: 0.3rem; font-size: 1.1rem">${item.snippet.publishedAt.substring(0, 9)}</div>
        <a href="${link}">Link</a>
    </div>`);
    elem.click(function() {
        $(this).toggleClass('active');

        if($(this).hasClass('active') && race.links.indexOf(link) === -1){
            race.links.push(link);
        } else if(!$(this).hasClass('active') && race.links.indexOf(link) !== -1){
            race.links.splice(race.links.indexOf(link), 1);
        }
    });

    let msg = "";
    if(foundDistance){
        activate();
    } else{
        msg += "<div class='error'>No Distance</>";
    }

    if(!foundGender){
        deactivate();
        msg += "<div class='error'>No Gender</div>";
    }

    if(!foundYear){
        deactivate();
        msg += "<div class='error'>No Year</div>";
    }

    if(!foundCategory){
        deactivate();
        msg += "<div class='error'>No Category</div>";
    }

    if(!foundType && !foundLocation){
        deactivate();
        msg += "<div class='error'>No Competition Type / location</div>";
    }

    if(!foundRaceType){
        deactivate();
        msg += "<div class='error'>No Race type(points etc)</div>";
    }

    elem.append(msg);

    function activate(){
        elem.addClass('active');
        if(race.links.indexOf(link) === -1){
            race.links.push(link);
        }
    }

    function deactivate(){
        elem.removeClass('active');
        if(race.links.indexOf(link) !== -1){
            race.links.splice(race.links.indexOf(link), 1);
        }
    }

    return elem;
}

let workingKey = keys[0];


function getSearch(term, callback, key = workingKey, attemp = 0){
    if(attemp >= keys.length){
        callback(null);
        return;
    }
    $.ajax({
        type: "GET",
        url: `https://youtube.googleapis.com/youtube/v3/search?part=snippet&maxResults=15&q=${term}&videoDefinition=any&videoDimension=any&key=${key}`,
        accept: 'application/json',
        success: (response) =>{
            workingKey = key;
            callback(response);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            getSearch(term, callback, keys[(keys.indexOf(key) + 1) % keys.length], attemp + 1);

            console.error(xhr + " " + ajaxOptions + " " + thrownError);
        }
    });
}


let localSearch = [];

initLocal();
function initLocal(){
    getFile("/admin/dev/data/ytApi.json").receive((succsess, data) => {
        localSearch = data;
        console.log("local: ")
        console.log(localSearch);
    });
}

function getSearchLocal(idRace, callback){
    for (const race of localSearch) {
        if(parseInt(race.idRace) === parseInt(idRace)){
            callback(race.search);
            return;
        }
    }
    callback(null);
}

function getApi(){
    if(races.length === 0){
        alert("races not loaded yet");
        return;
    }
    getFile("/admin/dev/data/ytApi.json").receive((succsess, data) => {
        console.log("data:");
        console.log(data)
        const needed = [];
        let i = 0;
        for (const race of races) {
            let found = false;

            /**filter */
            if(parseInt(race.raceYear) < 2000 || (race.type != "WM" && race.type != "EM")){
                found = true;
                // console.log("year: " + race.raceYear);
                // console.log("type: " + race.type);
            }

            for (const search of data) {
                if(search.idRace === race.idRace){
                    found = true;
                    break;
                }
            }

            if(!found){
                needed.push(race);
                i++;
                if(i >= $(".max").val()){
                    break; //test
                }
            }
        }
        console.log("needed: ")
        console.log(needed);
        searchApi(0, needed, data);
    });
}



function searchApi(i, needed, data) {
    if(i >= needed.length){
        console.log(data);
        $("apiRes").empty();
        $(".apiRes").append(JSON.stringify(data));
        return;
    }
    const need = needed[i];
    getSearch(termFromRace(need).term, ((search) => {
        if(search !== null){
            data.push({
                idRace: need.idRace,
                search
            });
            searchApi(i + 1, needed, data);
        } else{
            alert("stopped after " + i + " searches");
            searchApi(i + 10000000000, needed, data);
        }
    }))
}

/**
 * database
 */

function updateDb() {
    const linkRaces = [];
    for (const race of races) {
        if(race.links === undefined){
            continue;
        }
        if(race.links === null){
            continue;
        }
        if(race.links.length === 0){
            continue;
        }
        linkRaces.push({
            idRace: race.idRace,
            link: race.links.join(";"),
            description: race.description
        });
    }
    console.log("linkRaces:");
    console.log(linkRaces);
    set("raceLinks", linkRaces).receive((data) => {
        // console.log(data);
    });
}