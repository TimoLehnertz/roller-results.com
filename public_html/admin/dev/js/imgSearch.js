$(() => {
    console.log(athletes);
    start();
});

function start(){
    for (var i = 0; i < 10; i++){
        search(termFromAthlete(athletes[i]), (res) => {
            console.log(res);
        });
    }
}

function termFromAthlete(athlete){
    return athlete.fullname;
}

function search(term, callback){
    $.ajax({
        type: "GET",
        url: `/api/imageSearch.php?q=${term}`,
        accept: 'application/json',
        success: (response) =>{
            callback(response);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.error("ajax error: " + xhr + " " + ajaxOptions + " " + thrownError);
        }
    });
}