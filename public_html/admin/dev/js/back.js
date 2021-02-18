/**
 * yt api key:
    AIzaSyAMKwOKCbFDbwGD0nNplSWSuYjqoawgwyk
 */

function getSearchTerms(callback){
    get("races").receive((succsess, races) => {
        console.log("races:")
        console.log(races);
        const terms = [];
        for (let i = 0; i < 20; i++) {
            terms.push(termFromRace(races[i]));
        }
        callback(terms);
    });
}

function termFromRace(r){
    let gender = "men";
    if(r.gender == "w"){
        gender = "women"
    }
    return {
        reference: r.idRace,
        term: `${r.location} "${r.distance}" ${r.category} ${gender} ${r.raceYear} skate`
    };
}

function start(){
    getSearchTerms((terms) => {
        console.log("terms:");
        console.log(terms);
        search(terms, 3);
    });
}

function prevFromObj(obj){
    const elem = $(`<div link="${obj.link}" style="display: flex; flex-direction: column">
        <img width="320" height="180" src="${obj.thumbLink}">
    </div>`);
    elem.append(`<div>
        <div style="margin-bottom: 1rem; font-size: 1.3rem">${obj.title}</div>
        <div style="margin-bottom: 1rem; font-size: 1.1rem">${obj.chanel}</div>
        <div style="margin-bottom: 1rem; font-size: 1rem; color: #444">${obj.duration}</div>
    </div>`);
    return elem;
}


/**
http://localhost/dev/ytSearch.html
 */

console.log(localStorage.getItem("terms"));

if(localStorage.getItem("terms") !== null){
    const terms = JSON.parse(localStorage.getItem("terms"));
    const amountPerTerm = JSON.parse(localStorage.getItem("amountPerTerm"));
    const i = JSON.parse(localStorage.getItem("i"));
    const results = JSON.parse(localStorage.getItem("results"));
    search(terms, amountPerTerm, i, results);
}


function search(terms, amountPerTerm, i = 0, results = []){
    console.log("starting search: progress: " + i)
    if(i < terms.length){
        load("https://www.youtube.com/results?search_query=" + terms[i].term, () => {
            const found = {
                term: terms[i],
                matches: []
            }
            $(".style-scope ytd-video-renderer").each(function(index) {
                if(index >= amountPerTerm){
                    return false;
                }
                console.log($(this).find("a"));
                found.matches.push({
                    title: $(this).find("yt-formatted-string.style-scope.ytd-video-renderer").first().text(),
                    chanel: $(this).find("a.yt-simple-endpoint.style-scope.yt-formatted-string").text(),
                    thumbLink: $(this).find(".style-scope.yt-img-shadow").attr("src"),
                    duration: $(this).find("span.style-scope.ytd-thumbnail-overlay-time-status-renderer").text(),
                    link: "youtube.com" + $(this).find("a").attr("href")
                });
            });
            console.log(results);
            results.push(found);

            localStorage.setItem("terms", JSON.stringify(terms));
            localStorage.setItem("amountPerTerm", JSON.stringify(amountPerTerm));
            localStorage.setItem("i", JSON.stringify(i + 1));
            localStorage.setItem("results", JSON.stringify(results));

            window.stop();
            document.write();
            deleteAllCookies();
            console.log("reloading soon")
            window.setTimeout(() => {
                window.location = "/dev/ytSearch.html";
            }, 5000);
            // search(terms, amountPerTerm, i + 1, results);
        });
    } else{
        localStorage.removeItem("terms");
        done(results);
    }
}

function done(results){
    $(() => {
        console.log("done ------------------")
        console.log(results)
        $(".result").empty();
        // $("head").empty();
        for (const result of results) {
            console.log(result)
            const div = $(`<div style="display: flex; flex-direction: column"></div>`);
            const list = $(`<div style="display: flex;">`);
            div.append(`<h2>${result.term.term}</h2>`);
            div.append(list);
            for (const match of result.matches) {
                list.append(prevFromObj(match));
            }
            $(".result").append(div);
            console.log($(".result").html());
        }
    })
}

function load(url, callback){
    // window.stop();
    $("body").empty();
    getPage(url, (text) => {
        text.replaceAll("<script>", "<pre>");
        text.replaceAll("</script>", "</pre>");
        $("body").append(text);
        window.setTimeout(callback, 10000);
    });
}

function deleteAllCookies() {
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
}

function getPage(url, callback){
    $.ajax({
        type: "GET",
        url,
        dataType:  "text",
        crossDomain: true,
        xhrFields: { withCredentials: true },
        success: (response) =>{
            // console.log(response)
            callback(response);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            callback(null)
            console.log(xhr + " " + ajaxOptions + " " + thrownError);
        }
    });
}