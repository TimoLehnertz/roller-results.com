$(() => {
    $(".search-bar__input").on("input", searchChange);
});

function searchChange(){
    const text = $(".search-bar__input").val();
    search(text, (succsess, data) => {
        if(succsess){
            
            console.log(data);

            updateSearchBar(data);
        } else{

        }
    });
}

function updateSearchBar(data){
    data = sortSearch(data);
    const optionsElem = $(".search-bar__options");
    optionsElem.empty();
    for (const option of data) {
        optionsElem.append(elemFromSearchOption(option));
    }
}

function sortSearch(search){
    search.sort((a, b) => {
        if(a.score < b.score) { return -1}
        if(a.score > b.score) { return 1}
        return 0;
    });
    return search;
}

function elemFromSearchOption(option){
    const elem = $(
    `<a href="${lonkFromOption(option)}" class="search__option">
        <span class="search__name">${option.name}</span>
    </a>`);
    elem.prepend(iconFromSearch(option));
    elem.click(() => {optionClicked(option)});
    return elem;
}


function lonkFromOption(option){
    if(option.type == "person"){
        return `/athlete?id=${option.id}`;
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
        case "country": return $(`<img class="result__left" src="https://www.countryflags.io/${countryNameToCode(option.name)}/shiny/32.png">`);
    }
}