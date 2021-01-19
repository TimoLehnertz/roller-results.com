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

function athleteDataToProfileData(athlete){
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
    // console.log(athlete.birthYear);
    return {
        name: athlete.firstname + " " +athlete.lastname,
        image: athlete.image != null ? "/img/uploads/" + athlete.image : null,
        left: {data: athlete.country, type: "countryFlag", link: `/country?id=${athlete.country}`},
        right: {data: athlete.gender, type: "gender"},
        trophy1, trophy2, trophy3,
        special: Math.round(athlete.score),
        primary: {
            sprinter: {
                data: (athlete.scoreLong / athlete.score),
                description: "Best discipline",
                description1: "Sprint",
                description2: "Long",
                type: "slider"
            },
            category: {
                date: athlete.category,
                validate: (e) => athlete.category.length > 0
            },
            topTen: {
                data: athlete.topTen,
                description: "WM top 10 places:",
                validate: () => athlete.topTen > 0
            },
            birthYear: {data: athlete.birthYear, icon: "far fa-calendar", validate: (data) => {return data !== null && data > 1800}},
            club: {data: athlete.club, description: "Club:"},
            team: {data: athlete.team, description: "Team:"}
        },
        secondary: profileInit,
        secondaryData: athlete
    };
    
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
        wrapper.append(`<h2>Best times coming soon</h2>`);
        const compElem = $(`<div><h2>Competitions</h2><div class="loading circle"></div></div>`);
        wrapper.append(compElem);

        get("athleteCompetitions", athlete.id).receive((succsess, competitions) => {
            compElem.find(".loading").remove();
            for (const comp of competitions) {
                const body = $(`<div class="margin left"></div>`);
                for (const race of comp.races) {
                    const acRace = new Accordion(`<div class="race min"><span>${race.distance} ${race.category} ${race.gender}</span>${getPlaceElem(race.placeNumeric).get()[0].outerHTML}</div>`, $("<div class='loading circle'></div>"), {onextend: (head, body1, status) => {
                        if(!status.fetched){
                            get("race", race.id).receive((succsess, race) => {
                                if(!succsess){
                                    return;
                                }
                                body1.find(".loading").remove();
                                getRaceTable(body1, race);
                            });
                            status.fetched = true;
                        }
                    }}, {status: {fetched: false}});
                    body.append(acRace.element);
                }
                const ac = new Accordion(`${comp.type} ${comp.location} ${comp.raceYear}`, body);
                compElem.append(ac.element);
            }
        });
    };
}

function athleteToProfile(athlete, minLod = Profile.MIN){
    const profile = new Profile(athleteDataToProfileData(athlete), minLod);
    if("score" in athlete === false || "scoreLong" in athlete === false || "scoreShort" in athlete === false){//athlete not complete needs ajax
        get("athlete", athlete.id).receive((succsess, newAthlete) => {
            profile.updateData(athleteDataToProfileData(newAthlete));
        });
    }
    return profile;
}

function pathFromRace(r){
    return $(`
    <div class="path">
        <a href="/year?id=${r.raceyear}" class="elem">${r.raceyear}<span class="delimiter"> > </span></a>
        <a href="/competition?id=${r.idCompetition}" class="elem"> ${r.location}<span class="delimiter"> > </span></a>
        <a href="/competition?id=${r.idCompetition}&trackStreet=${r.trackStreet}" class="elem">${r.trackStreet}<span class="delimiter"> > </span></a>
        <a class="elem">${r.category}<span class="delimiter"> > </span></a>
        <a class="elem">${r.gender}<span class="delimiter"> > </span></a>
        <a class="elem">${r.distance}</a>
    </div>`);
}

function getRaceTable(parent, race){
    const elem = $(`<div class="race"></div>`);
    elem.append(pathFromRace(race));
    for (const result of race.results) {
        result.athletes = profilesElemFromResult(result);
        result.place = {
            data: result.place,
            type: "place"
        };
    }
    const table = new Table(elem, race.results);
    table.setup({
        layout: {
            place: {allowSort: false},
            time: {
                displayName: "Time",
                allowSort: true
            },
            athletes: {
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
        type: "list"
    }
    if("athlete1" in result){
        elem.data.push({
            data: athleteToProfile(result.athlete1, Profile.MIN),
            type: "profile"
        });
    }
    if("athlete2" in result){
        elem.data.push({
            data: athleteToProfile(result.athlete2, Profile.MIN),
            type: "profile"
        });
    }
    if("athlete3" in result){
        elem.data.push({
            data: athleteToProfile(result.athlete3, Profile.MIN),
            type: "profile"
        });
    }
    return elem;
}