"use strict";

$(() => {
    $(".search-bar__input").on("input", searchChange);
    initSearchBar();
    initIndexLogo();
    initHeader();
    initNav();
});

function initNav(){
    $(".nav a").each(function() {
        if(window.location.pathname.includes($(this).attr("href"))){
            $(this).parent().addClass("active");
            return false;
        }
    });
}

function initHeader(){
    /**
     * nav
     */
    $(".toggle-nav").click((e) => {
        $(".nav").toggleClass("extended");
        $(".toggle-nav").toggleClass("toggle");
        $(".profile-section").removeClass("extended");
        e.stopPropagation();
    });
    $("body, .hider").click(() => {
        $(".nav").removeClass("extended");
        $(".toggle-nav").removeClass("toggle");
    });
    $(".nav").click((e) => {
        e.stopPropagation();
    });

    /**
     * profile-section
     */
    $(".toggle-profile-section").click((e) => {
        $(".profile-section").toggleClass("extended");
        $(".nav").removeClass("extended");
        $(".toggle-nav").removeClass("toggle");
        e.stopPropagation();
    });
    $("body, .hider").click(() => {
        $(".profile-section").removeClass("extended");
    });
    $(".profile-section").click((e) => {
        e.stopPropagation();
    });
}


let lastSearch = "";

function initSearchBar(){
    $("body").click(closeSearchBar);
    $(".search-bar__input").keyup((e) => {
        if(e.keyCode === 13){
            if(options.length > 0){
                window.location = linkFromOption(options[0]);
            }
        }
    })
}

let options = [];

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
            options = data;
            updateSearchBar(data);
        } else{
            //Todo
        }
    });
}

function closeSearchOptions(){
    updateSearchBar([]);
}

function closeSearchBar(){
    updateSearchBar();
}

function updateSearchBar(data){
    const optionsElem = $(".search-bar__options");
    optionsElem.empty();
    if(data !== undefined){
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


function initIndexLogo(){
    const logo = $(".index .logo");
    if(logo.length === 0){
        return; // not indexpage
    }
    window.onscroll = update;
    window.onresize = update;

    function update(){
        const max = (window.innerWidth / 2) - (logo.width() / 1.25);
        let offset = Math.min((logo.offset().top - window.scrollY - 50) * 5 / Math.min(window.scrollY / 100, 1), max);
        const progress = (max - offset) / max;
        if(isMobile()){
            offset = max;
            // console.log("mobile")
        }
        $("#logo-filter").attr("stdDeviation", 4 - progress * 2);
        if(progress < 0.9 && !isMobile()){
            logo.css("width", `${(1 - progress) * 8 + 4}rem`);
            logo.css("height", `${(1 - progress) * 4 + 2}rem`);
        } else if(!isMobile()){
            logo.css("width", ``);
            logo.css("height", ``);
        }
        logo.offset({left: offset});
    }
    // window.setTimeout(update, 2000)
    if(isMobile()){
        logo.css("position", "relative");
        console.log(logo.css("position"))
        logo.css("width", `12rem`);
        logo.css("height", `6rem`);
        console.log(logo.css("width"));
    }
    update();
    update();
}