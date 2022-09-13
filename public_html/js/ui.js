"use strict";

const scoreCallbacks = [];
const medalCallbacks = [];

const defaultCompSettings =  {
    worlds: {dbName: "WM",                          displayName: "Worlds",                  influence: 1,   useMedals: true,icon: "fas fa-globe"},
    worldGames: {dbName: "World Games",             displayName: "World games",             influence: 1,   useMedals: true,icon: "fas fa-globe"},
    yog: {dbName: "Youth Olympic Games",            displayName: "Youth Olympic Games",     influence: 0,   useMedals: false, icon: "fas fa-globe"},
    euros: {dbName: "EM",                           displayName: "Euros",                   influence: 0.2, useMedals: false,icon: "fas fa-globe-europe"},
    combined: {dbName: "Combined",                  displayName: "Worlds / Euros Combined", influence: 0,   useMedals: false, icon: "fas fa-globe-europe"},
    universade: {dbName: "Universade",              displayName: "Universade",              influence: 0,   useMedals: false, icon: "fas fa-graduation-cap"},
    cadetsChallenge: {dbName: "Cadets Challenge",   displayName: "Cadets Challenge",        influence: 0,   useMedals: false,  icon: "fas fa-award"},
    junior: {dbName: "Junior",                      displayName: "Junior and below",        influence: 0,   useMedals: true,   icon: "fas fa-solid fa-user"},
    senior: {dbName: "Senior",                      displayName: "Senior",                  influence: 0,   useMedals: true,   icon: "fas fa-solid fa-user"}
}

// $(() => {
//     window.scroll(0, 0);
// });

let settingCompetitions = defaultCompSettings;
let settingsDropdown;

$(() => {
    $(".search-bar__input").on("input", searchChange);
    initHeader();
    initSearchBar();
    initNav();
    initSettings();
});

function initNav(){
    $(".nav a").each(function() {
        if(window.location.pathname.includes($(this).attr("href"))){
            $(this).parent().addClass("active");
            return false;
        }
    });
}

function initHeader(){
    /**
     * nav
     */
    $(".toggle-nav").click((e) => {
        $(".nav").toggleClass("extended");
        $(".toggle-nav").toggleClass("toggle");
        $(".profile-section").removeClass("extended");
        e.stopPropagation();
    });
    $("body, .hider").click(() => {
        $(".nav").removeClass("extended");
        $(".toggle-nav").removeClass("toggle");
    });
    $(".nav").click((e) => {
        e.stopPropagation();
    });

    /**
     * profile-section
     */
    $(".toggle-profile-section").click((e) => {
        $(".profile-section").toggleClass("extended");
        $(".nav").removeClass("extended");
        $(".toggle-nav").removeClass("toggle");
        e.stopPropagation();
    });
    $("body, .hider").click(() => {
        $(".profile-section").removeClass("extended");
    });
    $(".profile-section").click((e) => {
        e.stopPropagation();
    });
}


loadStorage();

function getMedalCount() {
    let count = 0;
    for (const key in settingCompetitions) {
        if (Object.hasOwnProperty.call(settingCompetitions, key)) {
            const comp = settingCompetitions[key];
            if(comp.useMedals) {
                count++;
            }
        }
    }
    return count;
}

function getMedalComps() {
    let out = "";
    let delimiter = "";
    for (const key in settingCompetitions) {
        if (Object.hasOwnProperty.call(settingCompetitions, key)) {
            const comp = settingCompetitions[key];
            if(comp.useMedals) {
                out += delimiter + comp.displayName;
                delimiter = ", ";
            }
        }
    }
    return out;
}

function loadStorage() {
    const storedSettings = sessionStorage.getItem("settingCompetitions");
    if(storedSettings && storedSettings.senior) {
        settingCompetitions = JSON.parse(storedSettings);
    }
}

function updateStorage() {
    sessionStorage.setItem("settingCompetitions", JSON.stringify(settingCompetitions));
}


function initSettings(){
    /**
     * header
     */
    const list = [{
        element: "Settings",
        // children: [
            // {
            //     element: "How do scores work?",
            //     children: [
            //         $("<p><b>How do our scores work?</b></p>"),
            //         $("<p>Scores are the numbers<br>visible in <span class='font color purple'>purple circles</span></p>"),
            //         $("<p>Scores are divided into <br><b>sprint</b>- and <b>long-scores</b>.<br>added together those<br>give the overall score</p>"),
            //         $("<p>We calculate them in<br><b>real-time</b>based on<br>your settings</p>"),
            //         $("<p></p>"),
            //         $("<p><b>But how?</b></p>"),
            //         $("<p>We take each <b>place</b><br>feed them into a<br><b>formula</b>, multiply the<br>result with your values<br>and <b>sum them up</b></p>"),
            //         $("<p>Change the Percentages<br>per competition type<br>just as you like</p>"),
            //         $("<p><b>The formula</b>:<br>f(<b>place</b>)=1/(<b>place</b>^1.2)*30;</p>"),
            //         $(`<iframe src="https://www.desmos.com/calculator/locbyec6or?embed" width="200" height="100" style="border: 1px solid #ccc" frameborder=0></iframe>`),
            //         $(`<a target="_blank" rel="noopener noreferrer" href="https://www.desmos.com/calculator/locbyec6or?lang=de">Open in Desmos</a>`),
            //     ]
            // }, {
            //     element: "How do medals work?",
            //     children: [
            //         $("<p><b>How do our medals work?</b></p>"),
            //         $("<p>Medals are counted<br>per <b>country</b> and <b>athlete</b>.<br>You can see them in<br>displayed under or<br>right to the<br>profile image.</p>"),
            //         $("<p>What competitions are<br>counted can be set<br>via the settings.<br>Use the checkboxes<br>next to the<br>competitions.</p>"),
            //     ]
            // }
        // ],
        icon: "fas fa-sliders-h",
        style: {
            padding: "1rem",
            backgroundColor: "#333",
            color: "white"
        },
    }];

    /**
     * rest
     */
    for (const type in settingCompetitions) {
        if (Object.hasOwnProperty.call(settingCompetitions, type)) {
            const comp = settingCompetitions[type];
            let icon = undefined;
            if(comp.icon) {
                icon = $(`<i class="fas ${comp.icon}" style="color: #444; text-shadow: none"></i>`)
            }
            list.push({
                element: {
                    type: "list",
                    style: {
                        padding: "0.2rem",
                        width: "100%"
                    },
                    data: [
                        icon,
                        {
                            data: comp.displayName,
                            style: {width: "7rem", marginLeft: "0.0rem"}
                        },
                        // {
                        //     type: "input",
                        //     inputType: "number",
                        //     data: 1,
                        //     attributes: {
                        //         min: 0,
                        //         value: () => comp.influence * 100,
                        //         step: 1,
                        //         style: "width: 4.2rem"
                        //     },
                        //     // reset: (me) => {
                        //     //     me.attr("value", defaultCompSettings[type].influence);
                        //     // },
                        //     change: function(e, val){
                        //         comp.influence = Math.max(val / 100, 0);
                        //     },
                        //     style: {marginLeft: "0.3rem"}
                        // }, "%",
                        {
                            type: "input",
                            inputType: "checkbox",
                            data: 1,
                            attributes: {
                                checked: () => comp.useMedals ? true : undefined,
                            },
                            // reset: (me) => {
                            //     console.log("resetting");
                            //     me.attr("checked", defaultCompSettings[type].useMedals);
                            // },
                            change: function(e, val){
                                comp.useMedals = val;
                                applyMedals(true);
                            },
                            style: {
                                marginLeft: "0.0rem",
                                marginRight: "0.1rem"
                            }
                        }
                    ],
                    justify: "justify-space-between"
                    // justify: "justify-end"
                }
            });
        }
    }
    /**
     * aply btn
     */
    list.push({
        element: {
            type: "list",
            data: [
            //     {
            //     type:"input",
            //     inputType: "button",
            //     data: 1,
            //     attributes: {
            //         value: "Apply"
            //     },
            //     style: {
            //         padding: "1rem",
            //         background: "transparent"
            //     },
            //     onclick: () => {
            //         applyScores(true);
            //         settingsDropdown.close();
            //         return true;
            //     }
            // },
            {
                type:"input",
                inputType: "button",
                data: 1,
                attributes: {
                    value: "Reset"
                },
                style: {
                    padding: "1rem",
                    background: "transparent"
                },
                onclick: () => {
                    settingCompetitions = defaultCompSettings;
                    updateStorage();
                    settingsDropdown.close();
                    window.location.reload();
                    return true;
                }
            }]
        }
    });
    /**
     * init
     */
    settingsDropdown = new Dropdown($(".settings-toggle"), list, {customClass: "settings-dropdown"});
    // settingsDropdown.elem.find(".data-dropdown").css("left", "-13rem");
}

function resetSettings() {
    settingCompetitions = defaultCompSettings;
    settingsDropdown
    applyMedals();
    applyScores();
}

applyMedals(false);

function addMedalCallback(callback) {
    medalCallbacks.push(callback);
}

function getUsedMedalsString() {
    let used = "";
    let del = "";
    for (const compName in settingCompetitions) {
        if (Object.hasOwnProperty.call(settingCompetitions, compName)) {
            const comp = settingCompetitions[compName];
            if(comp.useMedals) {
                used += `${del} <span class="font color orange">${comp.displayName}</span>`;
                del = ", ";
            }
        }
    }
    return used;
}

function getUsedMedalsStringOred() {
    let used = "";
    let del = "";
    let usedComps = [];
    for (const compName in settingCompetitions) {
        if (Object.hasOwnProperty.call(settingCompetitions, compName)) {
            const comp = settingCompetitions[compName];
            if(comp.useMedals) {
                usedComps.push(comp);
            }
        }
    }
    for (let i = 0; i < usedComps.length; i++) {
        used += `${del} <span class="font color orange">${usedComps[i].displayName}</span>`;
        if(i == usedComps.length - 2) {
            del = " or ";
        } else {
            del = ", ";
        }
    }
    return used;
}

function applyMedals(updateAthletes) {
    let dbUsedMedals = "";
    let del = "";
    for (const compName in settingCompetitions) {
        if (Object.hasOwnProperty.call(settingCompetitions, compName)) {
            const comp = settingCompetitions[compName];
            if(comp.useMedals){
                dbUsedMedals += del + comp.dbName;
                del = ",";
            }
        }
    }
    ajaxState["usedMedals"] = dbUsedMedals;
    if(updateAthletes) {
        updateAllAthleteProfiles();
        updateAllCountryProfiles();
    }
    updateStorage();
    for (const callback of medalCallbacks) {
        callback();
    }
}

applyScores(false);//scores for ajax state
function applyScores(callCallbacks){
    // console.log("applying scores: ");
    // console.log(settingCompetitions);
    let dbArgument = "";
    let del = "";
    for (const compName in settingCompetitions) {
        if (Object.hasOwnProperty.call(settingCompetitions, compName)) {
            const comp = settingCompetitions[compName];
            dbArgument += `${del}${comp.dbName},${comp.influence}`;
            del = ",";
        }
    }
    ajaxState["scoreInfluences"] = dbArgument;
    let noupdate = false;
    if(callCallbacks){
        Profile.grayOutAll();
        for (const callback of scoreCallbacks) {
            if(callback()){
                noupdate = true;
            }
        }
    }
    if(!noupdate) {
        for (const profile of Profile.allProfiles) {
            if(profile.type == "athlete"){
                profile.update();
            }
        }
    }
    updateStorage();
}

let lastSearch = "";

let searchTooltip;

function initSearchBar(){
    $("body").click(closeSearchBar);
    $(".search-bar__input").keyup((e) => {
        if(e.keyCode === 13){
            if(options.length > 0){
                window.location = linkFromOption(options[0]);
            }
        }
    });
    if(isMobile()) {
        $(".search-bar__input").attr("placeholder", "Search");
    }
    searchTooltip = new Tooltip(".search-bar", `<div class="font color white"><p>Stuff you can find:</p><p><i class="far fa-dot-circle"></i>Athletes</p><p><i class="far fa-dot-circle"></i>Competitions</p><p><i class="far fa-dot-circle"></i>Countries</p><p><i class="far fa-dot-circle"></i>Competitions</p></div>`);
}

let options = [];

function searchChange(e){
    e.stopPropagation();
    const text = $(".search-bar__input").val();
    if(text.length == 0){
        $("#search-bar__options__header").empty();
        return;
    }
    lastSearch = text;
    search(text, ["Year","Team","Competition","Athlete","Country"], (succsess, data) => {
        if(succsess) {
            options = data;
            updateSearchBar(data);
        } else{
            //Todo
        }
    });
}

function closeSearchOptions(){
    updateSearchBar([]);
}

function closeSearchBar(){
    updateSearchBar();
}

function updateSearchBar(data){
    // console.log(data);
    if(data?.length > 0) {
        searchTooltip.close();
    }
    const optionsElem = $("#search-bar__options__header");
    optionsElem.empty();
    if(data !== undefined){
        data = sortSearch(data);
    } else{
        return;
    }
    for (const option of data) {
        optionsElem.append(elemFromSearchOption(option, true));
    }
}

function sortSearch(search){
    search.sort((a, b) => {
        if(a.priority < b.priority) { return 1}
        if(a.priority > b.priority) { return -1}
        return 0;
    });
    return search;
}

function elemFromSearchOption(option, useLinks, callback) {
    if(!isFunction(callback)) callback = () => {};
    const elem = $(
    `<${useLinks ? "a" : "p"} href="${linkFromOption(option)}" class="search__option">
        <span class="search__name">${option.name}</span>
    </${useLinks ? "a" : "p"}>`);
    elem.prepend(iconFromSearch(option));
    elem.click(() => {callback(option);});
    return elem;
}

function linkFromOption(option) {
    if(option.type == "year") {
        return `/competitions/index.php#${option.id}&search1=${lastSearch}`;
    }
    if(option.type == "person") {
        return `/athlete?id=${option.id}&search1=${lastSearch}`;
    }
    return `/${option.type}?id=${option.id}`;
}

function iconFromSearch(option) {
    switch(option.type) {
        case "competition": return $(`<i class="fas fa-map-marker-alt result__left"></i>`);
        case "person": return  $(`<i class="fas fa-user result__left"></i>`);
        case "team": return  $(`<i class="fas fa-people-group result__left"></i>`);
        case "country": const code = countryNameToCode(option.name); if(code !== null) {return $(`<img class="result__left" src="/img/countries/${code}.svg">`);} else{return $()};
    }
}

function hintFromAllowedSearch(allowed) {
    let out = "";
    let delimiter = "";
    for (const string of allowed) {
        switch(string) {
            case "Athlete": out += delimiter + "Athletes"; break;
            case "Team": out += delimiter + "Teams"; break;
            case "Competition": out += delimiter + "Events"; break;
            case "Country": out += delimiter + "Countries"; break;
            case "Year": out += delimiter + "Years"; break;
        }
        delimiter = " / ";
    }
    return out;
}

class SearchBarSmall {
    constructor(allowed, useLinks, callback) {
        this.useLinks = useLinks ?? false;
        this.allowed = allowed;
        this.lastResults = [];
        if(!isFunction(callback)) callback = () => {};
        this.callback = callback;
        this.elem = $(`<div class="search-bar"></div>`);
        this.input = $(`<input type="text" class="search-bar__input" placeholder="Search for ${hintFromAllowedSearch(allowed)}">`);
        this.options = $(`<div class="search-bar__options flex column align-start"></div>`);
        this.input.on("input", (e) => this.handleChange(e));
        this.elem.append(this.input);
        this.elem.append(this.options);
        $("body").click(() => this.options.empty());
        this.input.keyup((e) => {
            if(e.keyCode !== 13) return;
            if(this.lastResults.length == 0) return;
            if(this.useLinks) {
                window.location = linkFromOption(this.lastResults[0]);
            }
            this.options.empty();
            this.callback(this.lastResults[0]);
        });
    }

    handleChange(e) {
        e.stopPropagation();
        const text = this.input.val();
        if(text.length == 0){
            this.options.empty();
            return;
        }
        search(text, this.allowed, (succsess, data) => {
            if(!succsess) return;
            data = sortSearch(data, this.allowed);
            this.updateSearchBar(data);
            this.lastResults = data;
        });
    }

    updateSearchBar(data) {
        this.options.empty();
        if(data === undefined) return;
        for (const option of data) {
            this.options.append(elemFromSearchOption(option, this.useLinks, (option) => {this.options.empty(); this.callback(option)}));
        }
    }
}

function isFunction(functionToCheck) {
    return functionToCheck && {}.toString.call(functionToCheck) === '[object Function]';
}