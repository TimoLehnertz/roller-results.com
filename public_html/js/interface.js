"use strict";

function countrytableFrompersons(persons){
    const table = [];
    for (const person of persons) {
        const row = {
            Name: personToTd(person),
            Gender: person.gender,
            Country: person.country,
            Team: person.team,
            Club: person.club
        }
        table.push(row);
    }
    return table;
}

const simplePersontCols = ["firstname", "lastname", "gender", "country", "team", "club"];

function trFromPerson(person){
    const tr = {};
    for (const col of simplePersontCols) {
        if(person[col] != undefined){
            tr[col] = person[col];
        } else{
            tr[col] = "";
        }
    }
    return tr;
}

function resultsTotable(results){
    const table = [];
    for (const result of results) {
        table.push(trFromResult(result));
    }
    return table;
}


const simpleResultCols = ["place", "category", "gender", "remark", "trackStreet", "distance"];

function trFromResult(result){
    const tr = {};
    for (const col of simpleResultCols) {
        if(result[col] == undefined){
            tr[col] = "";
        } else{
            tr[col] = result[col];
        }
    }
    tr["Athlete"] = personToTd(result["person1"]);
    if(result["person2"] != null){
        tr["Athlete2"] = personToTd(result["person2"]);
    }
    if(result["person3"] != null){
        tr["Athlete3"] = personToTd(result["person3"]);
    }
    return tr;
}

function personToTd(person){
    const elem = $(`<a href="/athlete?id=${person.id}" class="result__person"><span>${person.firstname + "  " + person.lastname}</span></a`);
    const coutryCode = countryNameToCode(person.country);
    if(coutryCode != undefined){
        elem.append($(`<a href="/country?id=${person.country}" class="img-wrapper"><img class="result__country-flag" src="https://www.countryflags.io/${coutryCode}/shiny/32.png"></a>`));
        new Tooltip(elem.find(".img-wrapper"), person.country);
    }
    return elem;
}

function sortAthletes(athletes){
    athletes.sort((a, b) => {
        if(a.score > b.score) return -1;
        if(b.score > a.score) return 1;
        return 0;
    });
    return athletes;
}

function updateAllAthleteProfiles() {
    for (const profile of Profile.allProfiles) {
        if(profile.type === "athlete" && !profile.grayedOut) {
            profile.update();
        }
    }
}

function updateAllCountryProfiles() {
    for (const profile of Profile.allProfiles) {
        if(profile.type === "country" && !profile.grayedOut) {
            profile.update();
        }
    }
}

function athleteDataToProfileData(athlete, useRank = false, alternativeRank = undefined) {
    let trophy1 = {
        data: getMedal("silver", athlete.silver, athlete.silver +" Silver medals | Used competitions: " + getMedalComps()),
        type: ElemParser.DOM,
        // validate: () => athlete.silver > 0
    }
    let trophy2 = {
        data: getMedal("gold", athlete.gold, athlete.gold + " Gold medals | Used competitions: " + getMedalComps()),
        type: ElemParser.DOM,
        // validate: () => athlete.gold > 0
    }
    let trophy3 = {
        data: getMedal("bronze", athlete.bronze, athlete.bronze + " Bronze medals | Used competitions: " + getMedalComps()),
        type: ElemParser.DOM,
        // validate: () => athlete.bronze > 0
    }

    let searchParam = findGetParameter("search1");

    if(searchParam) {
        searchParam = "&search1=" + searchParam;
    } else {
        searchParam = "";
    }

    let amount = 0;
    let color;
    if(athlete.bronze > 0){
        amount++; color = "bronze";
    }
    if(athlete.silver > 0){
        amount++; color = "silver";
    }
    if(athlete.gold > 0){
        amount++; color = "gold";
    }
    let name = athlete.firstname + " " +athlete.lastname;
    if(!athlete.checked) {
        name += " (unchecked)";
    }
    if(athlete.firstname == undefined) {
        name = "";
    }
    if(!athlete.id) {
        athlete.id = athlete.idAthlete; 
    }
    const data = {
        type: "athlete",
        maximizePage: `/athlete?id=${athlete.id}${searchParam}`,
        name,
        image: athlete.image != null ? "/img/uploads/" + athlete.image : null,
        left: {data: athlete.country, type: "countryFlag", link: `/country?id=${athlete.country}`, tooltip: athlete.country},
        right: {data: athlete.gender, type: "gender", tooltip: athlete.gender?.toLowerCase() == "w" ? "Female" : "Male"},
        trophy1, trophy2, trophy3,
        share: {
            url: "https://www.roller-results.com/athlete/index.php?id=" + athlete.id + "&name=" + athlete.firstname + "_" + athlete.lastname,
            title: `See ${athlete.firstname} ${athlete.lastname}'s athlete profile`,
            text: `Check out ${athlete.firstname} ${athlete.lastname}'s athlete profile on Roller-results.`,
        },
        special: {
            data: athlete.gold + "",
            tooltip: "Gold medals on competitions declared in the settings (" + getUsedMedalsString() + ")",
            type: ElemParser.TEXT,
            validate: () => athlete.gold > 0
        },
        primary: {
            medalScore: {
                data: athlete.medalScore,
                description: "Medal points:",
                tooltip: "(Gold=3pts, Silver=2pts, Bronze=1pt) using only competitions checked in settings(" + getUsedMedalsString() + ")"
            },
            medalScoreShort: {
                description: "Points short:",
                data: athlete.medalScoreShort,
                tooltip: "Medal score (Gold=3pts, Silver=2pts, Bronze=1pt) only applied to distances <p 1500m",
            },
            medalScoreLong: {
                description: "Points long:",
                data: athlete.medalScoreLong,
                tooltip: "Medal score (Gold=3pts, Silver=2pts, Bronze=1pt) only applied to distances > 1500m"
            },
            sprinter: {
                data: athlete.medalScoreLong / athlete.medalScore,
                description: "Best discipline",
                description1: "Sprint",
                description2: "Long",
                type: "slider",
                tooltip: "Relation of Score short and long points"
            },
            topTen: {
                data: athlete.topTen,
                description: "Top 10 places:",
                validate: () => athlete.topTen > 0,
                tooltip: "All top 10 places on competitions in the medal settings (All competitions that are ticked in the settings)",
            },
            birthYear: {
                data: athlete.birthYear,
                icon: "far fa-calendar",
                validate: (data) => {return data !== null && data > 1800},
                description: "Birth year:",
                tooltip: "Birth year(Might be incorrect)"
            },
            bestDistance: {
                data: athlete.bestDistance,
                description: "Favorite discipline:",
                tooltip: `The discipline ${athlete.firstname} got the most score points on`
            },
            club: {
                data: athlete.club,
                description: "Club:",
                tooltip: "Athletes club"
            },
            team: {
                data: athlete.team,
                description: "Team:",
                tooltip: "Athletes team / sponsor"
            }
        },
        secondary: profileInit,
        secondaryData: athlete,
        update: function() {
            this.grayOut = true;
            // console.log("Updating athlete");
            const id = athlete.id | athlete.idAthlete;
            get("athlete", id).receive((succsess, newAthlete) => {
                // console.log(newAthlete);
                if(succsess) {
                    this.grayOut = false;
                    this.updateData(athleteDataToProfileData(newAthlete, useRank));
                } else {
                    console.log("failed loading profile")
                }
            });
            this.loadCareer?.();
        },
        athleteData: athlete
    };
    if(useRank){
        if(alternativeRank !== undefined){
            data.rank = alternativeRank;
        } else if("rank" in athlete) {
            data.rank = athlete.rank;
        }
    }
    return data;
    
        /**
     * ToDo:
     * -best Times
     * -competitions
     *      -races(place, time etc)
     * similar athletes after score and sprit / long distance (only for highly scored athletes)
     * -carrear(future)
     * contact
     * follow(also card mode)
     * 
     * 
     */
    function profileInit(wrapper, athlete) {
        /**
         * Navigation
         */
        const idCareer = getUid();
        const idGallery = getUid();
        const idBestTimes = getUid();
        const idCompetitions = getUid();

        const nav = $(`<div class="profile-navigation">
            <a href="#${idCareer}">Career</a>
            <a href="#${idGallery}">Gallery</a>
            <a href="#${idBestTimes}">Best times</a>
            <a href="#${idCompetitions}">Competitions</a>
        </div>`);
        wrapper.append(nav);
        /**
         * Career
         */
        const careerElem = $(`<div id="${idCareer}"></div>`);
        wrapper.append(careerElem);
        this.loadCareer = function() {
            careerElem.empty();
            careerElem.append(`<h2 class="section__header">Career</h2><p class="margin left double">Used competitions: ${getUsedMedalsString()}</p><div class="loading circle"></div>`);
            if(getUsedMedalsString().length == 0) {
                careerElem.append(getSettingsAdvice(`${athlete.firstname}'s career`));
                return;
            }
            get("athleteCareer", athlete.id).receive((succsess, career) => {
                careerElem.find(".loading").remove();
                if(succsess && career.length !== 0){
                    careerGraphAt(careerElem, career);
                } else{
                    careerElem.append(`<p class="margin left double">${athlete.firstname} didnt competed in ${getUsedMedalsStringOred()} yet</p>`);
                }
            });
        }
        /**
         * Gallery
         */
        const galleryElem = $(`<div id="${idGallery}"></div>`);
        galleryElem.append(`<h2 class="section__header">Gallery</h2><div class="loading circle"><br><br></div>`);
        wrapper.append(galleryElem);
        get("athleteImages", athlete.id).receive((succsess, images) => {
            galleryElem.find(".loading").remove();
            if(!succsess) return galleryElem.append(`<p class="font color red>Error occoured while fetching ${athlete.firstname} images. Try again later</p>"`);
            if(images.length == 0) {
                console.log(athlete);
                galleryElem.append(`<p class="margin left double">${athlete.firstname} didnt got tagged in any photos yet. Head ofer to the <a href="/gallery">gallery</a> and tag ${athlete?.gender?.toLowerCase() == "m" ? "him" : "her"}.</p>`);
                return;
            }
            const flexElem = $(`<div class="top-3-images"></div>`);
            console.log(images);
            let loadedAmount = 0;
            const load = function(amount) {
                const loadUntil = loadedAmount + amount;
                for (loadedAmount; loadedAmount < loadUntil && loadedAmount < images.length; loadedAmount++) {
                    // console.log("loading image nr ", loadedAmount);
                    // console.log(images);
                    flexElem.append(`<img src="${images[loadedAmount].image}" alt="${loadedAmount + 1}th Image of ${athlete.firstname}">`);
                }
                $(".load-more-btn").remove();
                if(loadedAmount < images.length) {
                    const loadMoreBtn = $(`<button class="load-more-btn btn blender alone">Load more</button>`);
                    loadMoreBtn.click(() => {load(10)});
                    flexElem.append(loadMoreBtn);
                }
            }
            load(ismobile() ? 1 : 3);
            galleryElem.append(flexElem);
        });

        /**
         * best times
         */
        const bestTimesElem = $(`<div id="${idBestTimes}"><h2 class="section__header">Personal best times</h2><div class="loading circle"></div></div>`);
        get("athleteBestTimes", athlete.id).receive((succsess, times) => {
            bestTimesElem.find(".loading").remove();
            if(succsess && times.length !== 0){
                bestTimesAt(bestTimesElem, times)
            } else{
                bestTimesElem.append(`<p class="margin left double">There are no records for ${athlete.firstname} in the database yet.</p>`)
            }
        });
        wrapper.append(bestTimesElem);
        /**
         * competitions
         */
        const compElem = $(`<div id="${idCompetitions}"><h2 class="section__header">Competitions</h2><div class="loading circle"></div></div>`);
        wrapper.append(compElem);
        get("athleteCompetitions", athlete.id).receive((succsess, competitions) => {
            compElem.find(".loading").remove();
            if(succsess && competitions.length !== 0){
                compElem.append(getCompetitionListElem(competitions, false, athlete.id));
            } else{
                compElem.append(`<p class="margin left double">${athlete.firstname} didn't compete in any of our listed races yet</p>`)
            }
        });
    };
}

function preprocessTime(time) {
    if(time === undefined) return "00:00:00.000";
    const list = time.split(/[.:]+/);
    let timeString = "";
    let delimiter = "";
    let started = false;
    for (let i = 0; i < list.length - 1; i++) {
        if(parseInt(list[i]) > 0){
            timeString += delimiter + parseInt(list[i]);
            delimiter = ":";
            started = true;
        } else if(started) {
            timeString += delimiter + "00";
        }
    }
    timeString += ("" + parseFloat("0." + list.pop())).substring(1, 100); //last 3 digits
    return timeString;
}

function bestTimesAt(elem, bestTimes){
    const wrapper = $(`<div class="best-times flex"></div>`);
    const shortElem = $(`<div class="sprint"><h2>Short</h2></div>`);
    const longElem = $(`<div class="long"><h2>Long</h2></div>`);
    let short = false;
    let long = false;
    for (const time of bestTimes) {
        const timeElem = $(`<div class="time flex justify-space-between"/>`);
        timeElem.append(`<a href="/race/index.php?id=${time.idRace}"><div>${time.distance}</div><div>${preprocessTime(time.bestTime)}</div><div>${time.athleteName !== undefined ? time.athleteName : ""}</div></a>`);
        if(time.isSprint == 1){
            shortElem.append(timeElem);
            short = true;
        } else{
            longElem.append(timeElem);
            long = true;
        }
    }
    if(short){
        wrapper.append(shortElem)
    }
    if(long){
        wrapper.append(longElem)
    }
    elem.append(wrapper);
}

const allAthleteProfiles = [];
function athleteToProfile(athlete, minLod = Profile.MIN, useRank = false, alternativeRank = undefined, loadFirst = true){
    const profile = new Profile(athleteDataToProfileData(athlete, useRank, alternativeRank), minLod);
    // if(loadFirst && (!athlete.score || !athlete.scoreLong || !athlete.scoreShort || !athlete.gold || !athlete.silver || !athlete.bronze)){//athlete not complete needs ajax
    //     profile.update();
    //     // console.log("loading incomplete profile");
    //     // get("athlete", athlete.idAthlete).receive((succsess, newAthlete) => {
    //     //     if(succsess){
    //     //         profile.updateData(athleteDataToProfileData(newAthlete, useRank));
    //     //     } else{
    //     //         console.log("failed loading profile")
    //     //     }
    //     // });
    // }
    if(athlete.needsUpdate) {
        profile.update();
    }
    allAthleteProfiles.push(profile);
    return profile;
}

function pathFromRace(r) {
    return $(`
    <div class="path">
        <a href="/year?id=${r.raceYear}" class="elem">${r.raceYear}<span class="delimiter"> > </span></a>
        <a href="/competition?id=${r.idCompetition}" class="elem"> ${r.location}<span class="delimiter"> > </span></a>
        <a href="/competition?id=${r.idCompetition}&trackStreet=${r.trackStreet}" class="elem">${r.trackStreet}<span class="delimiter"> > </span></a>
        <div class="elem">${r.category} ${r.gender} ${r.distance}<span class="delimiter"></span></div>
    </div>`);
}

// function getGalleryImagePath(path) {
//     return `/gallery/nas-share/public/${path}`;
// }

function linksFromLinkString(string){
    if(!string || string.length === 0){
        return [];
    }
    let links = string.split(";");
    for (let i = 0; i < links.length; i++) {
        links[i] = links[i].split("v=")[1]?.split("&")[0];
    }
    // let links = string.split("https://www.youtube.com/watch?v=");
    // for (let i = 0; i < links.length; i++) {
    //     links[i] = links[i].replace(";", "");
    // }
    // links.splice(0,1);
    return links;
}

function getYtVideoElems(link) {
    const links = linksFromLinkString(link);
    const data = [];
    for (const link of links) {
        const a = $(`<a href="https://www.youtube.com/watch?v=${link}" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></a>`);
        a.click((e) => e.stopPropagation())
        data.push(a);
    }
    return {
        data,
        type: ElemParser.LIST
    }
}

function getYtVideo(link){
    const ids = linksFromLinkString(link);
    if(ids.length === 0){
        return $();
    }
    let text = "videos";
    if(ids.length === 1){
        text = "video";
    }
    const head = $(`<div class="youtube-head"><i class="fab fa-youtube"></i><div class="margin left">${ids.length} ${text}</div></div>`);
    const body = $(`<div class="youtube-body"></div>`);
    for (const id of ids) {
        body.append(
            `<iframe style="width: 100%;"src="https://www.youtube.com/embed/${id}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`
        );
    }
    const ac = new Accordion(head, body)
    return ac.element;
}
// <iframe width="949" height="534" src="https://www.youtube.com/embed/YcXbt0iVu0A" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

function athleteFromResult(result) {
    const athlete = {};
    Object.assign(athlete, result);
    athlete.id = athlete.idAthlete;
    return athlete;
}

function getRaceTable(parent, race) {
    const elem = $(`<div class="race"></div>`);
    const raceTable = $(`<div class="race-table">`);
    elem.append(pathFromRace(race));
    elem.append(getYtVideo(race.link));
    elem.append(raceTable);

    const places = [];
    const results = [];
    for (const result of race.results) {
        if(places.includes(result.place)) {
            results[results.length - 1].athletes.push(athleteFromResult(result));
        } else {
            result.athletes = [athleteFromResult(result)];
            results.push(result);
            places.push(result.place);
        }
    }
    race.results = results;

    for (const result of race.results) {
        if(result.time !== undefined) {
            result.timeDate = result.time;
        }
        if(result.timeDate !== null) {
            result.time = preprocessTime(result.timeDate);
        }
        result.profiles = profilesElemFromResult(result);
        result.place = {
            data: parseInt(result.place),
            alignment: "center",
            type: "place"
        };
        result.country = {
            data: result.athletes[0].country,
            type: "countryFlag",
            link: "/country?id=" + result.athletes[0].country,
            tooltip: result.athletes[0].country
        }
    }
    
    const table = new Table(raceTable, race.results);
    // console.log(JSON.parse(JSON.stringify(race.results)));
    table.setup({
        layout: {
            place: {allowSort: true, displayName: "Place"},
            time: {
                displayName: "Time",
                allowSort: true,
                use: race.results[0]?.time !== null
            },
            country: {
                displayName: "Country",
                allowSort: false
            },
            profiles: {
                displayName: "Athlete/s",
                allowSort: false
            },
        }
    });
    table.init();
    parent.append(elem);
    return table;
}

function profilesElemFromResult(result) {
    // console.log("profile from result");
    // console.log(JSON.parse(JSON.stringify(result)));
    const elem = {
        data: [],
        type: "list",
        direction: "column"
    }
    if("athletes" in result){
        for (const athlete of result.athletes) {
            elem.data.push({
                data: athleteToProfile(athlete, Profile.MIN),
                type: "profile"
            });
        }
        
    }
    return elem;
}

/**
 * Country
 */
const allCountryProfiles = [];
function countryToProfile(country, minLod = Profile.MIN, useRank = false, alternativeRank = undefined){
    const profile = new Profile(countryToProfileData(country, useRank, alternativeRank), minLod);
    // if("score" in country === false || "scoreLong" in country === false || "scoreShort" in country === false || "gold" in country === false || "silver" in country === false || "bronze" in country === false){//athlete not complete needs ajax
    //     profile.update();
    //     // console.log("loading incomplete profile")
    //     // get("country", country.country).receive((succsess, newCountry) => {
    //     //     if(succsess){
    //     //         profile.updateData(athleteDataToProfileData(newCountry));
    //     //     } else{
    //     //         console.log("failed loading country " + country.country);
    //     //     }
    //     // });
    // }
    profile.colorScheme = 1;
    allCountryProfiles.push(profile);
    return profile;
}

function countryToProfileData(country, useRank = false, alternativeRank = undefined) {
    let trophy1 = {
        data: getMedal("silver", country.silver, country.silver + " Silver medals | Used competitions: " + getMedalComps()),
        type: ElemParser.DOM,
        // validate: () => country.silver > 0
    }
    let trophy2 = {
        data: getMedal("gold", country.gold, country.gold + " Gold medals | Used competitions: " + getMedalComps()),
        type: ElemParser.DOM,
        // validate: () => country.gold > 0
    }
    let trophy3 = {
        data: getMedal("bronze", country.bronze, country.bronze + " Bronze medals | Used competitions: " + getMedalComps()),
        type: ElemParser.DOM,
        // validate: () => country.bronze > 0
    }

    let searchParam = findGetParameter("search1");

    if(searchParam) {
        searchParam = "&search1=" + searchParam;
    } else {
        searchParam = "";
    }

    let amount = 0;
    let color;
    if(country.bronze > 0){
        amount++; color = "bronze";
    }
    if(country.silver > 0){
        amount++; color = "silver";
    }
    if(country.gold > 0){
        amount++; color = "gold";
    }
    // if(amount === 1){
    //     let tmp = trophy2;
    //     switch(color){
    //         case "silver": trophy2 = trophy1; trophy1 = tmp; break;
    //         case "bronze": trophy2 = trophy3; trophy3 = tmp; break;
    //     }
    // }
    const data = {
        type: "country",
        maximizePage: `/country?id=${country.country}${searchParam}`,
        name: country.country,
        share: {
            url: "https://www.roller-results.com/country/index.php?id=" + country.country,
            title: `See ${country.country}'s national profile`,
            text: `Check out ${country.country}'s nation profile on Roller-results.`,
        },
        image: {data: country.country, type: "countryFlag", link: `/country?id=${country.country}`, width: "100%", height: "100%", class: "countryBig"},
        // right: country.country,
        trophy1, trophy2, trophy3,
        special: {
            data: country.gold + "",
            tooltip: "Gold medals won on the selected types of competition (" + getUsedMedalsString() + ")",
            type: ElemParser.TEXT
        },
        primary: {
            rank: {
                data: country.rank,
                description: "Overall rank:",
                tooltip: "Ranking using first gold medals than silver medals, than bronze. Only using the selected competitions(" + getUsedMedalsString() + ")"
            },
            medalScore: {
                data: country.medalScore,
                description: "Medal points:",
                tooltip: "(Gold=3pts, Silver=2pts, Bronze=1pt)",
            },
            scoreShort: {
                description: "Points short:",
                data: country.medalScoreShort,
                tooltip: "Medal score (Gold=3pts, Silver=2pts, Bronze=1pt) only applied to distances <p 1500m"
            },
            scoreLong: {
                description: "Points long:",
                data: country.medalScoreLong,
                tooltip: "Medal score (Gold=3pts, Silver=2pts, Bronze=1pt) only applied to distances > 1500m"
            },
            sprinter: {
                data: country.medalScoreLong / country.medalScore,
                description: "Best discipline",
                description1: "Sprint",
                description2: "Long",
                type: "slider",
                tooltip: "Relation of Score short and long score"
            },
            topTen: {
                data: country.topTen,
                description: "Top 10 places:",
                validate: () => country.topTen > 0,
                tooltip: "All top 10 places on competitions checked in the medal settings (" + getUsedMedalsString() + ")"
            },
            members: {
                data: country.members,
                description: "Members:",
                tooltip: "Amount of members that raced for this country(Note: only competitions checked in the settings count)"
            },
        },
        secondary: profileInit,
        secondaryData: country,
        update: function() {
            this.grayOut = true;
            get("country", country.country).receive((succsess, newCountry) => {
                if(succsess) {
                    this.grayOut = false;
                    this.updateData(countryToProfileData(newCountry));
                    const slideshow = this.elem.find(".country-skater-slideshow").first();
                    get("countryAthletes", country.country, 5).receive((succsess, athletes) => {
                        slideshow.empty();
                        let i = 0;
                        for (const athlete of athletes) {
                            const profile = athleteToProfile(athlete, Profile.CARD, true, ++i);
                            profile.appendTo(slideshow);
                            if(i >= 5) break;
                        }
                    });
                } else{
                    console.log("failed loading country " + country.country);
                }
            });
            this.updateCareer?.();
        }
    };
    if(useRank) {
        if(alternativeRank !== undefined){
            data.rank = alternativeRank;
        } else if("rank" in country) {
            data.rank = country.rank;
        }
    }
    return data;
    
        /**
     * ToDo:
     * -best Times
     * -competitions
     *      -races(place, time etc)
     * similar countrys after score and sprit / long distance (only for highly scored countrys)
     * -carrear(future)
     * contact
     * follow(also card mode)
     * 
     */
    function profileInit(wrapper, country) {
        /**
         * Navigation
         */
        const idAthletes = getUid();
        const idCareer = getUid();
        const idBestTimes = getUid();
        const idCompetitions = getUid();

        const nav = $(`<div class="profile-navigation">
            <a href="#${idAthletes}">Athletes</a>
            <a href="#${idCareer}">Career</a>
            <!--<a href="#${idBestTimes}">Best times</a>--!>
            <a href="#${idCompetitions}">Competitions</a>
        </div>`);
        wrapper.append(nav);
        /**
         * Athletes
         */
        const max = 5;
        const athletesElem = $(`<div id="${idAthletes}"><h2 class="section__header">Top ${Math.min(country.members, max)} athletes</h2></div>`)
        wrapper.append(athletesElem);

        const slideShow = $(`<div class="country-skater-slideshow"/>`);
        new Slideshow(slideShow);
        athletesElem.append(slideShow);
        for(let i = 0; i < max; i++) {
            slideShow.append(Profile.getPlaceholder(Profile.CARD));
        }

        const allAthletesElem = $(`<div><div class="athlete-list-big margin bottom"></div></div>`);
        wrapper.append(allAthletesElem);

        const athleteButton = $(`<button class=" align center btn default">Load all athlethes</button>`);
        allAthletesElem.append(athleteButton);
        
        let maxDisplay = max;
        const settingsAdviceAthletes = getSettingsAdvice(` ${country.country}'s athletes`);
        if(getUsedMedalsString().length == 0) {
            wrapper.append(settingsAdviceAthletes);
        }
        get("countryAthletes", country.country, 5).receive((succsess, athletes) => {
            if(getUsedMedalsString().length > 0) {
                settingsAdviceAthletes.remove();
            }
            const profiles = [];
            let i = 0;
            for (const athlete of athletes) {
                if(i == max){
                    break;
                }
                const profile = athleteToProfile(athlete, Profile.CARD, true, i + 1);
                profile.update = function() {
                    this.grayOut = true;
                }
                profiles.push(profile);
                i++;
            }
            if(succsess){
                slideShow.empty();
                for (const profile of profiles) {
                    profile.appendTo(slideShow);
                }
            }
            /**
             * all athletes
             */
            athleteButton.text(`Load more athletes`);
            athleteButton.click(() => {
                athleteButton.hide();
                let count = 0;
                let overflow = false;
                // console.log(athletes);
                for (const athlete of athletes) {
                    const profile = athleteToProfile(athlete, Profile.MIN, false, 0, false);
                    profile.appendTo(allAthletesElem.find(".athlete-list-big"));
                    count++;
                    if(count >= maxDisplay) {
                        overflow = true;
                        break;
                    }
                }
                if(overflow) {
                    allAthletesElem.append(`<a style="color: white" class="btn default margin left top" href="/country/allAthletes.php?id=${athletes[0].country}">See All athletes</a>`);
                }
            });
        });


        /**
         * Career
         */
        const careerElem = $(`<div id="${idCareer}"></div></div>`);
        wrapper.append(careerElem);
        this.updateCareer = function() {
            careerElem.empty();
            careerElem.append(`<h2 class="section__header">Career</h2><p class="margin left double">Used competitions: ${getUsedMedalsString()}</p><div class="loading">`);
            if(getUsedMedalsString().length == 0) {
                careerElem.append(getSettingsAdvice(` ${country.country}'s career`));
                return;
            }
            get("countryCareer", country.country).receive((succsess, career) => {
                careerElem.find(".loading").remove();
                if(succsess && career.length !== 0) {
                    careerGraphAt(careerElem, career);
                }
            });
        }

         /**
         * best times
         */
        // const bestTimesElem = $(`<div id="${idBestTimes}"><h2 class="section__header">Countrywide best times</h2><div class="loading circle"></div></div>`);
        // get("countryBestTimes", country.country).receive((succsess, times) => {
        //     bestTimesElem.find(".loading").remove();
        //     if(succsess){
        //         bestTimesAt(bestTimesElem, times)
        //     }
        // });
        // wrapper.append(bestTimesElem);
        /**
         * competitions
         */
        const compElem = $(`<div id="${idCompetitions}"><h2 class="section__header">Competitions</h2><div class="loading circle"></div></div>`);
        wrapper.append(compElem);
        get("countryCompetitions", country.country).receive((succsess, competitions) => {
            compElem.find(".loading").remove();
            if(succsess) {
                compElem.append(getCompetitionListElem(competitions, true, country.country));
            }
        });
    };
}

function getSettingsAdvice(text) {
    return $(`<p class="margin left double flex justify-start">Select competition types in the <img class="margin left right half" style="max-height: 1.5rem" src="/img/settings.svg" alt="Settings"> to see ${text}</p>`);
}

function getCompetitionListElem(competitions, isCountry, name) {
    const elem = $(`<div class="competition-list"/>`);
    for (const comp of competitions) {
        elem.append(getCompetitionElem(comp, isCountry, name));
    }
    return elem;
}

function getCompetitionElem(comp, isCountry, name) {
    const getter = isCountry ? "countryRacesFromCompetition" : "athleteRacesFromCompetition";
    /**
     * Head
     */
    // const year = comp.startDate.split("-")[0];
    const head = $(`<div class="flex justify-start align-center"><div>${comp.raceYear} ${comp.type} ${comp.location}</div></div>`);
    const right = $(`<div class="flex justify-end flex-grow"></div>`);
    if(comp.bronzeMedals !== undefined) {
        if(comp.goldMedals > 0){
            right.append(getMedal("gold", comp.goldMedals, comp.goldMedals + " Gold medals | Used competitions: " + getMedalComps()));
        }
        if(comp.silverMedals > 0) {
            right.append(getMedal("silver", comp.silverMedals, comp.silverMedals + " Silver medals | Used competitions: " + getMedalComps()));
        } else {
            right.append(getEmptyMedal());
        }
        if(comp.bronzeMedals > 0){
            right.append(getMedal("bronze", comp.bronzeMedals, comp.bronzeMedals +" Bronze medals | Used competitions: " + getMedalComps()));
        } else {
            right.append(getEmptyMedal());
        }
        head.append(right);
    }
    if(comp.hasLink !== null) {
        right.append(`<i class="fab fa-youtube font size bigger pc-only"></i>`);
    } else {
        right.append(`<i class="fab fa-youtube font size bigger pc-only hidden-placeholder"></i>`);
    }
    head.append(right);
    return new Accordion(head, $("<div class='loading circle'></div>"), {
        onextend: (head, body) => {
            get(getter, name, comp.idCompetition).receive((succsess, races) => {
                getRacesElem(races, body);
                // body.empty();
                // body.addClass("competition");
                // let trackStreet = "";
                // let distance = "";
                // for (const race of races) {
                //     if(trackStreet !== race.trackStreet) {
                //         trackStreet = race.trackStreet;
                //         body.append(getRaceDelimiter(`<h2>${trackStreet}<h2>`));
                //     }
                //     if(distance !== race.distance) {
                //         distance = race.distance;
                //         body.append(getRaceDelimiter(distance));
                //     }
                //     body.append(getRaceElem(race));
                // }
            });
        }
    }).element;
}

function getRacesElem(races, body) {
    if(body === undefined) {
        body = $(`<div class="competition"></div>`);
    } else {
        body.empty();
    }
    let trackStreet = "";
    let distance = "";
    races = races.sort((a,b)=>a.trackStreet.localeCompare(b.trackStreet));
    for (const race of races) {
        if(trackStreet.toLowerCase() !== race.trackStreet.toLowerCase()) {
            trackStreet = race.trackStreet;
            body.append(getRaceDelimiter(`<h2>${trackStreet}<h2>`));
        }
        if(distance !== race.distance) {
            distance = race.distance;
            body.append(getRaceDelimiter(distance));
        }
        body.append(getRaceElem(race));
    }
    return body;
}

function getRaceDelimiter(text) {
    return $(`<div class="race align center delimiter">${text}</div>`);
}

function getUncheckedElem() {
    const elem = $(`<span class="code font color red">Unchecked</span>`);
    new Tooltip(elem, "This data has been uploaded by the comunity and is not validated yet");
    return elem;
}

/**
 * 
 * @param {*} race Race object
 * @param {*} results optional results object. if not given this will be fetched from the backend
 * @returns 
 */
function getRaceElem(race, results) {
    if(results !== undefined) {
        race.results = results;
    }
    const head = $(`<div class="race flex align-center justify-space-between padding right ${race.gender}"><span>${race.distance} ${race.trackStreet} ${race.category} ${race.gender}</span></div>`)
    if(!race.checked) {
        head.append(getUncheckedElem());
    }
    const links = linksFromLinkString(race.link).length;
    if(links > 0) {
        for (let i = 0; i < links; i++) {
            head.find("span").append(`<i class="fab fa-youtube margin left"></i>`);
        }
    }
    if(race.sportlers !== undefined){
        head.append(`<div class="margin left double">${race.sportlers} sportlers, best place: ${race.bestPlace} </div>`);
    }
    if(race.place !== undefined){
        head.append(getPlaceElem(race.place));
    }

    const acRace = new Accordion(head, $("<div class='loading circle'></div>"),
        {
            onextend: (head, body1, status) => {
                body1.addClass("race--max");
                if(!status.fetched) {
                    if(results !== undefined) {
                        getRaceTable(body1, race);
                        body1.find(".loading").remove();
                    } else {
                        get("race", race.id).receive((succsess, race) => {
                            console.log("loaded race with id ", race.id, race);
                            body1.find(".loading").remove();
                            if(!succsess) {
                                return;
                            }
                            getRaceTable(body1, race);
                        });
                    }
                    status.fetched = true;
                }
            }
        }, {
            status: {
                fetched: false
            }
        }
    );
    return acRace.element;
}

function careerGraphAt(parent, career){
    let height = 400;
    let padding = 20;
    if(isMobile()){
        height = 1000;
        padding = 0;
    }
    career = preprocessCareer(career);
    const elem = $(`<div class="career"></div>`);
    const canvas = $(`<canvas class="career__canvas" width="1000px" height="${height}"/>`);
    elem.append(canvas);
    const ctx = canvas.get()[0].getContext('2d');

    /**
     * processing data
     */
    const labels = [];
    for (const year of career) {
        labels.push(year.raceYear);
    }
    const dataArrays = [];
    const usedFields = ["score", "scoreLong", "scoreShort"];
    for (const field of usedFields) {
        const dataArray = [];
        for (const year of career) {
            if(year.hasOwnProperty(field)){
                dataArray.push(Math.round(year[field] * 100) / 100);
            } else{
                dataArray.push(0);
            }
        }
        dataArrays.push(dataArray);
    }
    Chart.defaults.global.defaultFontColor = 'white';
    Chart.defaults.global.defaultFontSize = 16;
    new Chart(ctx,
        {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Score short',
                    data: dataArrays[2],
                    backgroundColor: "#77f81577",
                    borderColor: "#00aa33",
                    borderWidth: 1
                }, {
                    label: 'long distance score',
                    data: dataArrays[1],
                    backgroundColor: "#42CECC",
                    borderColor: "#166aa1",
                    borderWidth: 1
                }, {
                    label: 'Overall score',
                    data: dataArrays[0],
                    backgroundColor: "#FA48EA",
                    borderColor: "#8A286A",
                    borderWidth: 1
                }]
            },
            options: {
                defaultFontColor: "#FFF",
                layout: {
                    padding: {
                        left: padding,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                scales: {
                    yAxes: [{
                        color: "#FFF"
                    }]
                }
            }
        });
    parent.append(elem);
}

function preprocessCareer(career){
    if(career.length === 0){
        return career;
    }
    let last = career[0].raceYear;
    const parsed = [];
    for (const year of career) {
        year.raceYear = parseInt(year.raceYear);
        year.races = parseInt(year.races);
        while(last + 1 < year.raceYear){
            parsed.push({
                raceYear: last + 1,
                score: 0,
                scoreLong: 0,
                scoreShort: 0,
                races: 0
            });
            last++;
        }
        last = year.raceYear;
        parsed.push(year);
    }
    if(parsed.length === 1){
        parsed.push(parsed[0]);
    }
    return parsed;
}

function minMaxYearFromCountries(countries){
    let min = 200000;
    let max = 0;
    for (const country of countries) {
        for (const year of country.scores) {
            min = Math.min(year.raceYear, min);
            max = Math.max(year.raceYear, max);
        }
    }
    return {min, max};
}

function countryCompareElemAt(parent, countries){
    countries = sortArray(countries, "score", true);
    countries.splice(10, 1000);

    let height = 400;
    let padding = 20;
    if(isMobile()){
        height = 1000;
        padding = 0;
    }
    const elem = $(`<div class="country-compare"></div>`);
    const canvas = $(`<canvas class="country-compare__canvas" width="1000px" height="${height}"/>`);
    elem.append(canvas);
    const ctx = canvas.get()[0].getContext('2d');

    /**
     * processing data
     */
    const labels = [];
    const minmax = minMaxYearFromCountries(countries);
    for (let i = minmax.min; i < minmax.max; i++) {
        labels.push(i);
    }
    const datasets = [];
    for (const country of countries) {
        const data = [];
        for (let i = 0; i < minmax.max - minmax.min; i++) {
            data.push(0);
        }
        for (const year of country.scores) {
            if("score" in year){
                data[year.raceYear - minmax.min] = Math.round(year.score * 100) / 100;
            }
        }
        datasets.push({
            label: country.country,
            data,
            backgroundColor: getRandomColor() + "44",
            borderColor: "#62BEFC77",
            borderWidth: 1
        });
    }

    Chart.defaults.global.defaultFontColor = 'white';
    Chart.defaults.global.defaultFontSize = 16;
    const chart = new Chart(ctx,
        {
            type: 'line',
            data: {
                labels,
                datasets
            },
            options: {
                defaultFontColor: "#FFF",
                layout: {
                    padding: {
                        left: padding,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                scales: {
                    yAxes: [{
                        color: "#FFF"
                    }]
                },
                legend: {

                }
            }
        });
    const hideBtn = $(`<button class="btn border-only">Hide all</button>`);
    const showBtn = $(`<button class="btn border-only">Show all</button>`);
    hideBtn.click(() => {
        for (const set of chart.data.datasets) {
            set.hidden = true;
        }
        chart.update();
    });
    showBtn.click(() => {
        for (const set of chart.data.datasets) {
            set.hidden = false;
        }
        chart.update();
    });
    parent.append(hideBtn);
    parent.append(showBtn);
    parent.append(elem);
}