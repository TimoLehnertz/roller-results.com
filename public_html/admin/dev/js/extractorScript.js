let urls = []
const rows = [];

function go(){
    load( $("#start").val(), () => {
        urls = findUrls()
        extract(0);
    });
}

function load(url, callback){
    $(".worker__wrapper").empty();
    get(url, (text) => $(".worker__wrapper").append(text));
    window.setTimeout(callback, 2000);
}

function findUrls(){
    console.log("finding urls...");
    let urls = [];
    $(".table-style-2 a").each(function(){
        urls.push("https://www.the-sports.org/" + $(this).attr("href"));
    })
    const womenUrls = [];
    for (const url of urls) {
        let women = url;
        women = women.replace("men-epm", "women-epf");
        womenUrls.push(women);
    }
    urls = urls.concat(womenUrls);
    console.log(urls)
    return urls;
    // return womenUrls;
}

function extract(url){
    console.log("extarcting " + urls[url] + "...")
    const result = [];
    load(urls[url], () => {
        // console.log("--------------------------------------------")
        const wrapper = $(".messageBox").parent();
        // console.log(wrapper)

        let competition = "?";
        let compYear = "?";
        let gender = "?";
        let date = "?";
        let distance = "?";
        let trackStreet = "?";
        let special = "?";

        wrapper.children().each(function() {
            if($(this).prop("tagName") === "H3"){
                const text = $(this).text();
                competition = text.split(" - ")[0];
                if(text.includes("Men")){
                    gender = "Men";
                } else{
                    gender = "Women"
                }
                compYear = text.split(" ").pop();
            }
            if($(this).prop("tagName") === "H4"){
                const text = $(this).find("a").text();
                date = text.split(" - ")[1];

                year = text.split(" ").pop();

                distance = text.split(" ")[1];

                trackStreet = text.split(" - ")[0].split(" ").pop();

                if(text.includes("m ")){
                    special = text.split("m ")[1].split(" - ")[0];
                } else{
                    special = "?";
                }

                // console.log("year: " + year);
                // console.log("compYear: " + compYear);
                // console.log("competition: " + competition);
                // console.log("gender: " + gender);
                // console.log("date: " + date);
                // console.log("distance: " + distance);
                // console.log("trackStreet: " + trackStreet);
                // console.log("special: " + special);
                // console.log("-------------------------");
            }
            if($(this).hasClass("messageBox")){
                $(this).find("tr").each(function() {
                    const row = {
                        competition,
                        compYear,
                        gender,
                        date,
                        distance,
                        trackStreet,
                        special,
                        place: parseInt($(this).find(".tdcol-5").text()),
                        athleteCountry: $(this).find("img").attr("alt"),
                        name: $(this).find(".nodecort").text().split("(")[0],
                    }
                    rows.push(row);
                    // console.log(row);
                    // console.log("---------------------------------")
                });
            }
        });

        if(urls.length > url + 1 && true){
            extract(url + 1);
        } else{
            console. clear();
            console.log(rows);
            $(".worker__wrapper").empty();
            $(".worker__wrapper").append(JSON.stringify(rows));
        }
    })
}

function get(url, callback){
    $.ajax({
        type: "GET",
        url: "get.php?url=" + url,
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