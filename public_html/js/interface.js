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

function athleteToProfile(athlete){
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

    return {
        name: athlete.firstname + " " +athlete.lastname,
        image: athlete.image != null ? "/img/uploads/" + athlete.image : null,
        left: {data: athlete.country, type: "countryFlag", link: `/country?id=${athlete.country}`},
        right: {data: athlete.gender, type: "gender"},
        trophy1, trophy2, trophy3,
        special: Math.round(athlete.score),
        primary: {
            category: {
                date: athlete.category,
                validate: (e) => athlete.category.length > 0
            },
            topTen: {
                data: athlete.topTen,
                description: "Worlds top 10:",
                validate: () => athlete.topTen > 0
            },
            score: {
                data: Math.round(athlete.score * 100) / 100,
                description: "Score:"
            },
            sprinter: {
                data: (athlete.scoreLong / athlete.score),
                description: "Best discipline",
                description1: "Sprint",
                description2: "Long",
                type: "slider"
            },
            birthYear: {data: athlete.birthYear, icon: "far fa-calendar", validate: (data) => data > 1800},
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
        console.log(athlete)
        console.log("test")
        wrapper.append(`<h2>Best times</h2>`);

        get("athlete", athlete.id).receive((succsess, data) => {console.log(data)});
    };
}