console.log("importer loaded");

let oldAthletes = [];
let newAthletes = [];
let countryCodes = [];
let competitions = [];

$(() => {
    loadExistingAthletes();
    loadNewAthletes();
    loadCountryCodes();
    // loadCompatitions();
    loadExistingFile();
});

function loadExistingFile(){
    getFile("/admin/dev/data/parsed.json").receive((succsess, json) => {
        $(".out").empty();
        $(".out").append(JSON.stringify(json));
    });
}

function loadNewAthletes(){
    getFile("/admin/dev/data/the-sports-results.json").receive((succsess, json) => {
        newAthletes = json;
        console.log("new: ");
        console.log(newAthletes);
    });
}

function loadNewAthletes(){
    getFile("/admin/dev/data/the-sports-results.json").receive((succsess, json) => {
        newAthletes = json;
        console.log("new: ");
        console.log(newAthletes);
    });
}

function loadCountryCodes(){
    get("countryCodes").receive((succsess, json) => {
        countryCodes = json;
        console.log("country codes:")
        console.log(json)
    });
}

function loadCompatitions(){
    get("allCompetitions").receive((succsess, json) => {
        competitions = json;
        console.log("competitions:");
        console.log(competitions);
    });
}


function loadExistingAthletes(){
    get("allAthletes", null).receive((succsess, fetched) => {
        oldAthletes = fetched;
        console.log("old: ");
        console.log(oldAthletes);
    })
}

function convertToCsv(){
    if(newAthletes.length == 0){
        alert("new athletes not loaded yet");
        return;
    }
    let csv = "";
    for (const key in newAthletes[0]) {
        if (Object.hasOwnProperty.call(newAthletes[0], key)) {
            const element = newAthletes[0][key];
            csv += key + ";";
        }
    }
    csv += "<br>";
    for (const athlete of newAthletes) {
        for (const key in athlete) {
            if (Object.hasOwnProperty.call(athlete, key)) {
                const element = athlete[key];
                csv += element + ";";
            }
        }
        csv += "<br>";
    }
    $(".out").empty();
    $(".out").append(csv);
}

function checkAthletes(){
    if(oldAthletes.length == 0){
        alert("old athletes not loaded yet");
        return;
    }
    if(newAthletes.length == 0){
        alert("new athletes not loaded yet");
        return;
    }
    if(countryCodes.length == 0){
        alert("country codes not loaded yet");
        return;
    }

    let i = 0;
    let max = newAthletes.length;
    const tested = [];
    for (const newAthlete of newAthletes) {
        const country = countryCodeToName(newAthlete.athleteCountry);
        newAthlete["athleteCountry"] = country;
        newAthlete["idAthlete"] = "?";
        if(tested.includes(country + newAthlete.name)){
            continue;
        }
        tested.push(country + newAthlete.name);
        for (const oldAthlete of oldAthletes) {
            
            if(newAthlete.name.trim().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "") === oldAthlete.fullname.trim().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "")
                && country === oldAthlete.country){
                newAthlete["idAthlete"] = oldAthlete.idAthlete;
                // console.log(i + "/" + max + " > " + newAthlete.name);
                i++;
                break;
            }
        }
    }
    console.log("found: " + i + " of " + max + " Athletes");
    $(".out").empty();
    $(".out").append(JSON.stringify(newAthletes));
}


function countryCodeToName(code){
    code = code.toLowerCase();
    for (const country of countryCodes) {
        if(country["alpha-3"].toLowerCase() === code){
            return country.name;
        }
    }
    for (const country of countries1) {
        if(country["alpha-2"].toLowerCase() === code){
            return country.name;
        }
    }
    return code;
}