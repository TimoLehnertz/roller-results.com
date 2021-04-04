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

function updateAllAthleteProfiles(){
    for (const profile of Profile.allProfiles) {
        if(profile.type === "athlete"){
            profile.update();
        }
    }
}

function updateAllCountryProfiles(){
    for (const profile of Profile.allProfiles) {
        if(profile.type === "country"){
            profile.update();
        }
    }
}

function athleteDataToProfileData(athlete, useRank = false, alternativeRank = undefined){
    let trophy1 = {
        data: getMedal("silver", athlete.silver),
        type: ElemParser.DOM,
        validate: () => athlete.silver > 0
    }
    let trophy2 = {
        data: getMedal("gold", athlete.gold),
        type: ElemParser.DOM,
        validate: () => athlete.gold > 0
    }
    let trophy3 = {
        data: getMedal("bronze", athlete.bronze),
        type: ElemParser.DOM,
        validate: () => athlete.bronze > 0
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
    if(amount === 1){
        let tmp = trophy2;
        switch(color){
            case "silver": trophy2 = trophy1; trophy1 = tmp; break;
            case "bronze": trophy2 = trophy3; trophy3 = tmp; break;
        }
    }
    const data = {
        type: "athlete",
        maximizePage: `/athlete?id=${athlete.idAthlete}${searchParam}`,
        name: athlete.firstname + " " +athlete.lastname,
        image: athlete.image != null ? "/img/uploads/" + athlete.image : null,
        left: {data: athlete.country, type: "countryFlag", link: `/country?id=${athlete.country}`, tooltip: true},
        right: {data: athlete.gender, type: "gender"},
        trophy1, trophy2, trophy3,
        special: Math.round(athlete.score),
        primary: {
            // scoreShort: {
            //     description: "score short",
            //     data: Math.round(athlete.scoreShort)
            // },
            // scoreLong: {
            //     description: "score long",
            //     data: Math.round(athlete.scoreLong)
            // },
            sprinter: {
                data: (athlete.scoreLong / (athlete.scoreLong + athlete.scoreShort)),
                description: "Best discipline",
                description1: "Sprint",
                description2: "Long",
                type: "slider"
            },
            topTen: {
                data: athlete.topTen,
                description: "WM top 10 places:",
                validate: () => athlete.topTen > 0
            },
            birthYear: {
                data: athlete.birthYear,
                icon: "far fa-calendar",
                validate: (data) => {return data !== null && data > 1800}
            },
            bestDistance: {
                data: athlete.bestDistance,
                description: "Best discipline",
            },
            rank: {
                data: athlete.rank,
                description: "Rank",
            },
            rankShort: {
                data: athlete.rankShort,
                description: "Rank Short",
            },
            rankLong: {
                data: athlete.rankLong,
                description: "Rank long",
            },
            club: {data: athlete.club, description: "Club:"},
            team: {data: athlete.team, description: "Team:"}
        },
        secondary: profileInit,
        secondaryData: athlete,
        update: function() {
            this.grayOut = true;
            get("athlete", athlete.idAthlete).receive((succsess, newAthlete) => {
                if(succsess){
                    this.grayOut = false;
                    this.updateData(athleteDataToProfileData(newAthlete, useRank));
                } else{
                    console.log("failed loading profile")
                }
            });
        }
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
    function profileInit(wrapper, athlete){
        /**
         * Navigation
         */
        const idCareer = getUid();
        const idBestTimes = getUid();
        const idCompetitions = getUid();

        const nav = $(`<div class="profile-navigation">
            <a href="#${idCareer}">Career</a>
            <a href="#${idBestTimes}">Best times</a>
            <a href="#${idCompetitions}">Competitions</a>
        </div>`);
        wrapper.append(nav);
        /**
         * Career
         */
        const careerElem = $(`<div id="${idCareer}"><h2 class="section__header">Career</h2><div class="loading"></div></div>`);
        wrapper.append(careerElem);
        get("athleteCareer", athlete.idAthlete).receive((succsess, career) => {
            careerElem.find(".loading").remove();
            if(succsess && career.length !== 0){
                careerGraphAt(careerElem, career);
            } else{
                careerElem.append(`<p class="margin left double">${athlete.fullname} didnt competed in wolrd championships yet</p>`);
            }
        });

        /**
         * best times
         */
        const bestTimesElem = $(`<div id="${idBestTimes}"><h2 class="section__header">Personal best times</h2><div class="loading circle"></div></div>`);
        get("athleteBestTimes", athlete.idAthlete).receive((succsess, times) => {
            bestTimesElem.find(".loading").remove();
            if(succsess && times.length !== 0){
                bestTimesAt(bestTimesElem, times)
            } else{
                bestTimesElem.append(`<p class="margin left double">There are no records for ${athlete.fullname} in the database yet :(</p>`)
            }
        });
        wrapper.append(bestTimesElem);
        /**
         * competitions
         */
        const compElem = $(`<div id="${idCompetitions}"><h2 class="section__header">Competitions</h2><div class="loading circle"></div></div>`);
        wrapper.append(compElem);
        get("athleteCompetitions", athlete.idAthlete).receive((succsess, competitions) => {
            compElem.find(".loading").remove();
            if(succsess && competitions.length !== 0){
                compElem.append(getCompetitionListElem(competitions));
            } else{
                compElem.append(`<p class="margin left double">${athlete.fullname} didn't compete in any of our listed races yet :(</p>`)
            }
        });
    };
}

function preprocessTime(time){
    const list = time.split(/[.:]+/);
    let timeString = "";
    let delimiter = "";
    for (let i = 0; i < list.length - 1; i++) {
        if(parseInt(list[i]) > 0){
            timeString += delimiter + parseInt(list[i]);
            delimiter = ":";
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
function athleteToProfile(athlete, minLod = Profile.MIN, useRank = false, alternativeRank = undefined){
    const profile = new Profile(athleteDataToProfileData(athlete, useRank, alternativeRank), minLod);
    if(athlete?.score || "scoreLong" in athlete || "scoreShort" in athlete || "gold" in athlete || "silver" in athlete || "bronze" in athlete){//athlete not complete needs ajax
        profile.update();
        // console.log("loading incomplete profile");
        // get("athlete", athlete.idAthlete).receive((succsess, newAthlete) => {
        //     if(succsess){
        //         profile.updateData(athleteDataToProfileData(newAthlete, useRank));
        //     } else{
        //         console.log("failed loading profile")
        //     }
        // });
    }
    allAthleteProfiles.push(profile);
    return profile;
}

function pathFromRace(r){
    return $(`
    <div class="path">
        <a href="/year?id=${r.raceYear}" class="elem">${r.raceYear}<span class="delimiter"> > </span></a>
        <a href="/competition?id=${r.idCompetition}" class="elem"> ${r.location}<span class="delimiter"> > </span></a>
        <a href="/competition?id=${r.idCompetition}&trackStreet=${r.trackStreet}" class="elem">${r.trackStreet}<span class="delimiter"> > </span></a>
        <div class="elem">${r.category} ${r.gender} ${r.distance}<span class="delimiter"></span></div>
    </div>`);
}

function linksFromLinkString(string){
    if(string === undefined){
        return [];
    }
    if(string === null){
        return [];
    }
    if(string.length === 0){
        return [];
    }
    let links = string.split("https://www.youtube.com/watch?v=");
    for (let i = 0; i < links.length; i++) {
        links[i] = links[i].replace(";", "");
    }
    links.splice(0,1);
    return links;
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

function getRaceTable(parent, race){
    const elem = $(`<div class="race"></div>`);
    const raceTable = $(`<div class="race-table">`);
    elem.append(pathFromRace(race));
    elem.append(getYtVideo(race.link));
    elem.append(raceTable);
    for (const result of race.results) {
        if(result.time !== null) {
            result.time = preprocessTime(result.time);
        }
        result.profiles = profilesElemFromResult(result);
        result.place = {
            data: result.place,
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
    table.setup({
        layout: {
            place: {allowSort: false},
            time: {
                displayName: "Time",
                allowSort: true,
                use: race.results[0].time !== null
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

function profilesElemFromResult(result){
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
    if("score" in country === false || "scoreLong" in country === false || "scoreShort" in country === false || "gold" in country === false || "silver" in country === false || "bronze" in country === false){//athlete not complete needs ajax
        profile.update();
        // console.log("loading incomplete profile")
        // get("country", country.country).receive((succsess, newCountry) => {
        //     if(succsess){
        //         profile.updateData(athleteDataToProfileData(newCountry));
        //     } else{
        //         console.log("failed loading country " + country.country);
        //     }
        // });
    }
    profile.colorScheme = 1;
    allCountryProfiles.push(profile);
    return profile;
}

function countryToProfileData(country, useRank = false, alternativeRank = undefined){
    let trophy1 = {
        data: getMedal("silver", country.silver),
        type: ElemParser.DOM,
        validate: () => country.silver > 0
    }
    let trophy2 = {
        data: getMedal("gold", country.gold),
        type: ElemParser.DOM,
        validate: () => country.gold > 0
    }
    let trophy3 = {
        data: getMedal("bronze", country.bronze),
        type: ElemParser.DOM,
        validate: () => country.bronze > 0
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
    if(amount === 1){
        let tmp = trophy2;
        switch(color){
            case "silver": trophy2 = trophy1; trophy1 = tmp; break;
            case "bronze": trophy2 = trophy3; trophy3 = tmp; break;
        }
    }
    const data = {
        type: "country",
        maximizePage: `/country?id=${country.country}${searchParam}`,
        name: country.country,
        image: {data: country.country, type: "countryFlag", link: `/country?id=${country.country}`, width: "100%", height: "100%", class: "countryBig"},
        // right: country.country,
        trophy1, trophy2, trophy3,
        special: Math.round(country.score),
        primary: {
            scoreShort: {
                description: "score short",
                data: Math.round(country.scoreShort)
            },
            scoreLong: {
                description: "score long",
                data: Math.round(country.scoreLong)
            },
            sprinter: {
                data: (country.scoreLong / (country.scoreLong + country.scoreShort)),
                description: "Best discipline",
                description1: "Sprint",
                description2: "Long",
                type: "slider"
            },
            topTen: {
                data: country.topTen,
                description: "WM top 10 places:",
                validate: () => country.topTen > 0
            },
        },
        secondary: profileInit,
        secondaryData: country,
        update: function(){
            // console.log("loading incomplete profile")
            this.grayOut = true;
            get("country", country.country).receive((succsess, newCountry) => {
                if(succsess){
                    this.grayOut = false;
                    this.updateData(countryToProfileData(newCountry));
                } else{
                    console.log("failed loading country " + country.country);
                }
            });
        }
    };
    if(useRank){
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
     * 
     */
    function profileInit(wrapper, country){
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
            <a href="#${idBestTimes}">Best times</a>
            <a href="#${idCompetitions}">Competitions</a>
        </div>`);
        wrapper.append(nav);
        /**
         * Athletes
         */
        const max = 5;
        const athletesElem = $(`<div id="${idAthletes}"><h2 class="section__header">Top ${Math.min(country.members, max)} athletes</h2><div class="loading circle"></div></div>`)
        wrapper.append(athletesElem);
        get("countryAthletes", country.country).receive((succsess, athletes) => {
            const profiles = [];
            let i = 0;
            for (const athlete of athletes) {
                if(i == max){
                    break;
                }
                profiles.push(athleteToProfile(athlete, Profile.CARD, true, i + 1));
                i++;
            }
            athletesElem.find(".loading").remove();
            if(succsess){
                const slideShow = $(`<div/>`);
                profileSlideShowIn(slideShow, profiles);
                athletesElem.append(slideShow);
            }
        });

        /**
         * Career
         */
        const careerElem = $(`<div id="${idCareer}"><h2 class="section__header">Career</h2><div class="loading"></div></div>`);
        wrapper.append(careerElem);
        get("countryCareer", country.country).receive((succsess, career) => {
            careerElem.find(".loading").remove();
            if(succsess && career.length !== 0){
                careerGraphAt(careerElem, career);
            } else{
                // careerElem.append(`<p class="margin left double">${athlete.fullname} didnt competed in wolrd championships yet</p>`);
            }
        });

         /**
         * best times
         */
        const bestTimesElem = $(`<div id="${idBestTimes}"><h2 class="section__header">Countrywide best times</h2><div class="loading circle"></div></div>`);
        get("countryBestTimes", country.country).receive((succsess, times) => {
            bestTimesElem.find(".loading").remove();
            if(succsess){
                bestTimesAt(bestTimesElem, times)
            }
        });
        wrapper.append(bestTimesElem);
        /**
         * competitions
         */
        const compElem = $(`<div id="${idCompetitions}"><h2 class="section__header">Competitions</h2><div class="loading circle"></div></div>`);
        wrapper.append(compElem);
        get("countryCompetitions", country.country).receive((succsess, competitions) => {
            compElem.find(".loading").remove();
            if(succsess){
                compElem.append(getCompetitionListElem(competitions));
            }
        });
    };
}

function getCompetitionListElem(competitions){
    const elem = $(`<div class="competition-list"/>`);
    for (const comp of competitions) {
        const compElem = $(`<div class="competition"></div>`);
        for (const race of comp.races) {
            const head = $(`<div class="race flex align-center justify-space-between padding right"><span>${race.distance} ${race.category} ${race.gender}</span></div>`)
            const links = linksFromLinkString(race.link).length;
            if(links > 0){
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
                        if(!status.fetched){
                            get("race", race.idRace).receive((succsess, race) => {
                                body1.find(".loading").remove();
                                if(!succsess){
                                    return;
                                }
                                getRaceTable(body1, race);
                            });
                            status.fetched = true;
                        }
                }}, {
                    status: {
                        fetched: false
                    }
                }
            );
            compElem.append(acRace.element);
        }
        const head = $(`<div class="flex justify-start align-center"><div>${comp.type} ${comp.location} ${comp.raceYear}</div></div>`);
        if(comp.bronzeMedals !== undefined){
            if(comp.bronzeMedals > 0){
                head.append(getMedal("bronze", comp.bronzeMedals));
            }
            if(comp.silverMedals > 0){
                head.append(getMedal("silver", comp.silverMedals));
            }
            if(comp.goldMedals > 0){
                head.append(getMedal("gold", comp.goldMedals));
            }
        }
        if(comp.hasLink !== null){
            head.append(`<div class="flex justify-end flex-grow"><i class="fab fa-youtube font size bigger"></i></div>`);
        }
        const acComp = new Accordion(head, compElem);
        elem.append(acComp.element);
    }
    return elem;
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
                    label: 'sprint score',
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