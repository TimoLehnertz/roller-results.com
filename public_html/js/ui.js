"use strict";

const scoreCallbacks = [];

$(() => {
    $(".search-bar__input").on("input", searchChange);
    initSearchBar();
    // initIndexLogo();
    initHeader();
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

const defaultCompSettings =  {
    worlds: {dbName: "WM",                          displayName: "Worlds",                  influence: 1,   useMedals: true, icon: "fas fa-globe"},
    worldGames: {dbName: "World Games",             displayName: "World games",             influence: 1,   useMedals: true, icon: "fas fa-globe"},
    yog: {dbName: "Youth Olympic Games",            displayName: "Youth Olympic Games",     influence: 0.5, useMedals: false, icon: "fas fa-globe"},
    euros: {dbName: "EM",                           displayName: "Euros",                   influence: 0.3, useMedals: false, icon: "fas fa-globe-europe"},
    combined: {dbName: "Combined",                  displayName: "Worlds / Euros Combined", influence: 0.3, useMedals: false, icon: "fas fa-globe-europe"},
    universade: {dbName: "Universade",              displayName: "Universade",              influence: 0.1, useMedals: false, icon: "fas fa-graduation-cap"},
    cadetsChallenge: {dbName: "Cadets Challenge",   displayName: "Cadets Challenge",        influence: 0.05,useMedals: false, icon: "fas fa-award"}
}

let settingCompetitions = defaultCompSettings;
loadStorage();

function loadStorage() {
    const storedSettings = sessionStorage.getItem("settingCompetitions");
    if(storedSettings) {
        settingCompetitions = JSON.parse(storedSettings);
    }
}

function updateStorage() {
    sessionStorage.setItem("settingCompetitions", JSON.stringify(settingCompetitions));
}

let settingsDropdown;

function initSettings(){
    /**
     * header
     */
    const list = [{
        element: "How does it work?",
        children: [
            "1 / place^1.2 * 30"
        ],
        icon: "fas fa-question",
        style: {
            padding: "1rem",
            backgroundColor: "#333",
            color: "white"
        }
    }];

    /**
     * rest
     */
    for (const type in settingCompetitions) {
        if (Object.hasOwnProperty.call(settingCompetitions, type)) {
            const comp = settingCompetitions[type];
            let icon = undefined;
            if(comp.icon) {
                icon = $(`<i class="fas ${comp.icon}"></i>`)
            }
            list.push({
                element: {
                    type: "list",
                    style: {
                        padding: "0.4rem",
                        width: "100%"
                    },
                    data: [
                        icon,
                        {
                            data: comp.displayName,
                            style: {width: "6rem", marginLeft: "0.3rem"}
                        },
                        {
                            type: "input",
                            inputType: "number",
                            data: 1,
                            attributes: {
                                min: 0,
                                value: () => comp.influence * 100,
                                step: 1,
                                style: "width: 4.2rem"
                            },
                            // reset: (me) => {
                            //     me.attr("value", defaultCompSettings[type].influence);
                            // },
                            change: function(e, val){
                                comp.influence = Math.max(val / 100, 0);
                            },
                            style: {marginLeft: "0.3rem"}
                        }, "%", {
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
                                marginLeft: "0.3rem",
                                marginRight: "0.3rem"
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
            data: [{
                type:"input",
                inputType: "button",
                data: 1,
                attributes: {
                    value: "Apply"
                },
                style: {
                    padding: "1rem",
                    background: "transparent"
                },
                onclick: () => {
                    applyScores(true);
                    settingsDropdown.close();
                    return true;
                }
            }, {
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
    settingsDropdown.elem.find(".data-dropdown").css("left", "-10rem");
}

function resetSettings() {
    settingCompetitions = defaultCompSettings;
    settingsDropdown
    applyMedals();
    applyScores();
}

applyMedals(false);
function applyMedals(updateAthletes){
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
    if(updateAthletes){
        updateAllAthleteProfiles();
        updateAllCountryProfiles();
        // for (const profile of Profile.allProfiles) {
        //     profile.update();
        // }
    }
    updateStorage();
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
    if(callCallbacks){
        Profile.grayOutAll();
        for (const callback of scoreCallbacks) {
            callback();
        }
    }
    for (const profile of Profile.allProfiles) {
        if(profile.type == "athlete"){
            profile.update();
        }
    }
    updateStorage();
}

let lastSearch = "";

function initSearchBar(){
    $("body").click(closeSearchBar);
    $(".search-bar__input").keyup((e) => {
        if(e.keyCode === 13){
            if(options.length > 0){
                window.location = linkFromOption(options[0]);
            }
        }
    })
}

let options = [];

function searchChange(e){
    e.stopPropagation();
    const text = $(".search-bar__input").val();
    if(text.length == 0){
        $(".search-bar__options").empty();
        return;
    }
    lastSearch = text;
    search(text, (succsess, data) => {
        if(succsess){
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
    const optionsElem = $(".search-bar__options");
    optionsElem.empty();
    if(data !== undefined){
        data = sortSearch(data);
    } else{
        return;
    }
    for (const option of data) {
        optionsElem.append(elemFromSearchOption(option));
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

function elemFromSearchOption(option){
    const elem = $(
    `<a href="${linkFromOption(option)}" class="search__option">
        <span class="search__name">${option.name}</span>
    </a>`);
    elem.prepend(iconFromSearch(option));
    elem.click(() => {optionClicked(option)});
    return elem;
}


function linkFromOption(option){
    if(option.type == "person"){
        return `/athlete?id=${option.id}&search1=${lastSearch}`;
    }
    return `/${option.type}?id=${option.id}`;
}

function optionClicked(option){
    console.log("clicked");
    console.log(option);
}

function iconFromSearch(option){
    switch(option.type){
        case "competition": return $(`<i class="fas fa-map-marker-alt result__left"></i>`);
        case "person": return  $(`<i class="fas fa-user result__left"></i>`);
        case "country": const code = countryNameToCode(option.name); if(code !== null) {return $(`<img class="result__left" src="https://www.countryflags.io/${code}/shiny/32.png">`);} else{return $()};
    }
}


// function initIndexLogo(){
//     const logo = $(".index .logo");
//     if(logo.length === 0){
//         return; // not indexpage
//     }
//     window.onscroll = update;
//     window.onresize = update;

//     function update(){
//         const max = (window.innerWidth / 2) - (logo.width() / 1.25);
//         let offset = Math.min((logo.offset().top - window.scrollY - 50) * 5 / Math.min(window.scrollY / 100, 1), max);
//         const progress = (max - offset) / max;
//         if(isMobile()){
//             offset = max;
//             // console.log("mobile")
//         }
//         $("#logo-filter").attr("stdDeviation", 4 - progress * 2);
//         if(progress < 0.9 && !isMobile()){
//             logo.css("width", `${(1 - progress) * 8 + 4}rem`);
//             logo.css("height", `${(1 - progress) * 4 + 2}rem`);
//         } else if(!isMobile()){
//             logo.css("width", ``);
//             logo.css("height", ``);
//         }
//         logo.offset({left: offset});
//     }
//     // window.setTimeout(update, 2000)
//     if(isMobile()){
//         logo.css("position", "relative");
//         console.log(logo.css("position"))
//         logo.css("width", `12rem`);
//         logo.css("height", `6rem`);
//         console.log(logo.css("width"));
//     }
//     update();
//     update();
// }