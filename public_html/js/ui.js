$(() => {
    $(".search-bar__input").on("input", searchChange);
    $("body").click(updateSearchBar);
});

let lastSearch = "";

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
            updateSearchBar(data);
        } else{
            //Todo
        }
    });
}

function closeSearchOptions(){
    updateSearchBar([]);
}

function updateSearchBar(data){
    const optionsElem = $(".search-bar__options");
    optionsElem.empty();
    if(data.length > 0){
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