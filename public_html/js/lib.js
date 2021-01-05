"use strict";

/**
 * Tooltip
 * 
 * Dependencies:
 *  Jquery.js
 *  _tooltip.sass
 */

class Tooltip{
    constructor(elem, text){
        this.elem = elem;
        this.text = text;
        $(() => {this.init()});
    }

    init(){
        $(this.elem).addClass("tooltip");
        $(this.elem).append(`<span class="tooltiptext">${this.text}</span>`);
    }
}

/**
 * Drop down
 * 
 * Dependencies:
 *  JQuery.js
 *  _dropdown.sass
 *  Tooltip
 *  fontawesome
 * 
 * constructor:
 *      elem    ->  elem to be used as opening for the dropdown
 *      content ->  ether a dom element to be inside the dropdown,
 *                  or an object in the form of
 *                  [
 *                      {
 *                              element: ? //Element to be represented / can be text,
 *                              tooltip: ? //tooltip,
 *                              children: [] //children to move to if clicked(in the same form as parent),
 *                              icon: //icon to be showed at the left in form of class name from font awesome,
 *                              onclick: //onclick event return true to close dropdown,
 *                       }
 *                  ]
 */

class Dropdown{

    static allDropDowns = [];
    static dropdownClass = "data-dropdown";
    static entryClass = "data-dropdown__entry";
    static nameClass = "data-dropdown__name";

    constructor(elem, content){
        this.elem = elem;
        this.content = content;
        this.unfolded = false;
        this.path = [];
        this.customClass = undefined;
        this.backIcon = "fas fa-arrow-circle-left";
        this.name = undefined;
        
        /**
         * animations
         * anime.js objects are used
         * factory functions
         */
        this.openAnimation = (bounds) => {
            return  {
                height: [0, bounds.height],
                scale: [0.5, 1],
                opacity: [0, 1],
                duration: 100,
                easing: "easeOutCubic"
            }
        }
        
        this.closeAnimation = () => {
            return  {
                height: 0,
                scale: [1, 0.7],
                opacity: [1, 0],
                duration: 200,
                easing: "easeOutCubic"
            }
        }
    }

    getDropDownElem(){
        return this.dropDownElem.get();
    }

    /**
     * Setip function to be called before init()
     * @param {*} setup Object to be used as setup
     */
    setup(setup){
        if(setup.hasOwnProperty("customClass")){//custom class to be added to the dropdowns classList
            this.customClass = setup.customClass;
        }
        if(setup.hasOwnProperty("openAnimation")){//custom class to be added to the dropdowns classList
            this.openAnimation = setup.openAnimation;
        }
        if(setup.hasOwnProperty("closeAnimation")){//custom class to be added to the dropdowns classList
            this.closeAnimation = setup.closeAnimation;
        }
        if(setup.hasOwnProperty("backIcon")){//custom class to be added to the dropdowns classList
            this.backIcon = setup.backIcon;
        }
        if(setup.hasOwnProperty("name")){//custom class to be added to the dropdowns classList
            this.name = setup.name;
        }
    }

    /**
     * setup should be called before if it is used default setup is sufficient
     * Init to be called after constructor
     */
    init(){
        this.dropDownElem = $(`<div class="${Dropdown.dropdownClass} ${this.customClass != undefined ? this.customClass : ""}"></div>`);
        this.dropDownElem.append(this.content);
        /**
         * Css beeing defined in _dropdown.sass
         */
        $(this.elem).append(this.dropDownElem);
        this.dropDownElem.css("display", "none");
        $(this.elem).css("position", "relative");//Relative for alowing absolute placement inside
        this.initEvents();
        if(Dropdown.allDropDowns.indexOf(this) === -1){
            Dropdown.allDropDowns.push(this);
        }
    }

    /**
     * Initiate open and close events
     */
    initEvents(){
        $(window).click(() => {
            this.close();
        });
        $(this.elem).click((e) => {
            this.open();
            e.stopPropagation();
        });
    }

    open(){
        if(!this.unfolded){
            Dropdown.closeAll();
            this.path = [];
            this.unfolded = true;
            this.parentObj = undefined;
            this.dropDownElem.css("display", "block");
            this.load(this.content);
            const bounds = Dropdown.getFullBounds(this.dropDownElem);
            const anim = this.openAnimation(bounds);
            anim.targets = this.dropDownElem.get();
            anime(anim);
        }
    }

    load(object){
        this.dropDownElem.empty();
        if(Array.isArray(object)){
            this.path.push(object);
            if(this.name != undefined){
                this.dropDownElem.append(`<div class="${Dropdown.nameClass}">${this.name}</div>`);
            }
            if(this.parentObj != undefined){
                if(object != this.content){
                    this.dropDownElem.append(this.getBackButton());
                }
            }
            for (const obj of object) {
                this.dropDownElem.append(this.getObjElem(obj))
            }
            const bounds = Dropdown.getFullBounds(this.dropDownElem);
            anime({
                targets: this.dropDownElem.get(),
                width: bounds.width + 20,
                height: bounds.height,
                duration: 50,
                easing: "easeOutSine"
            });
        } else{
            console.log("todo");
        }
    }

    getBackButton(){
        const btn = $(`<div class="${Dropdown.entryClass}">Back</div>`);
        btn.prepend(Dropdown.getIcon(this.backIcon, "margin right"));
        btn.click(() => {
            this.path.pop();
            this.load(this.path[this.path.length - 1]);
        });
        return btn;
    }

    /**
     * get font awesome icon
     * @param {text} faClass class from fonawesome
     * @param {text} extraClasses extra classes to be appended useful for margin right / left
     */
    static getIcon(faClass, extraClasses){
        return $(`<i class="${faClass} ${extraClasses != null ? extraClasses : ""}"><i>`);
    }

    getObjElem(obj){
        const elem = $(`<div class="${Dropdown.entryClass}"></div>`);
        if(obj.hasOwnProperty("element")){
            elem.append(obj.element);
        } else {
            elem.append(`<div>-- empty --</div>`);
        }
        if(obj.children != undefined){
            elem.click(() => {
                this.parentObj = obj;
                this.load(obj.children);
            });
        }
        /**
         * onclick
         */
        if(obj.hasOwnProperty("onclick")){
            elem.click(() => {
                if(obj.onclick()){
                    this.close();
                }
            });
        }
        /**
         * tooltip
         */
        if(obj.hasOwnProperty("tooltip")){
            new Tooltip(elem, obj.tooltip);
        }
        /**
         * Icon
         */
        if(obj.hasOwnProperty("icon")){
            elem.prepend(Dropdown.getIcon(obj.icon, "margin right"));
        }
        return elem;
    }

    close(){
        if(this.unfolded){
            this.unfolded = false;
            const anim = this.closeAnimation();
            anim.targets = this.dropDownElem.get();
            anim.complete = () => {this.dropDownElem.css("display", "none")};
            anime(anim);
        }
    }

    static closeAll(){
        for (const dropDown of Dropdown.allDropDowns) {
            dropDown.close();
        }
    }

    static getFullBounds(elem){
        const elemCpy = $(elem).clone();
        elemCpy.find(".tooltiptext").remove();
        elemCpy.css("display", "block");
        elemCpy.css("opacity", "0");
        elemCpy.css("width", "");
        elemCpy.css("height", "");
        elemCpy.css("position", "absolute");
        $("body").append(elemCpy);
        return {width: elemCpy.width(), height: elemCpy.height()};
    }
}

/**
 * Data-datble
 * Dependencies:
 * Dropdown
 * table.sass
 * 
 * Data shoud be in format {
 *      [{
 *          a: x
 *          b: x
 *      },{
 *          a: x
 *          b: x
 *      }]
 * }
 */

class Table{

    static class = "data-table";
    static headClass = "data-table__head";
    static bodyClass = "data-table__body";

    constructor(elem, data, name){
        this.data = data;
        this.elem = elem;
        this.name = name;
        this.initiated = false;
        this.layout = undefined;
        this.usedColumns= this.getUsedColumns();
    }

    /**
     * Optional setup
     * possible parameters:
     *      RowLink
     *      layout
     * @param {{}} params 
     */
    setup(params){
        /**
         * Rowlink should be a callback wich takes a row and returns a url to wich the row should create a link
         */
        if(params.hasOwnProperty("rowLink")){
            this.rowLink = params.rowLink;
        }
        /**
         * way to configure individual rows
         * should be in format
         *  {
         *      <row-name>: {
         *          use: true / false | default: true
         *          allowSort: true / false | default: true
         *          initialSort: "asc" / "dsec" //unset for no initial sort | default: unset
         *          displayName: "name" used to overwrite the column name on screen. No effect on data behind the scenes
         *      }
         *  }
         */
        if(params.hasOwnProperty("layout")){
            this.layout = params.layout;
        }
        /**
         * Specify the initial order 
         * example
         *  orderBy: {column: "place", up: true}
         */
        if(params.hasOwnProperty("orderBy")){
            this.orderBy = params.orderBy;
        }
        this.usedColumns= this.getUsedColumns();
    }

    getDisplayNameOfColumn(column){
        if(this.layout == undefined){
            return column;
        }
        if (this.layout.hasOwnProperty(column)) {
            const element = this.layout[column];
            if(element.hasOwnProperty("displayName")){
                return element.displayName;
            } else{
                return column;
            }
        } else{
            return "-";
        }
    }

    /**
     * returns false if not set and {column: "name", up: true / false} if given
     */
    getInitialSort(){
        if(this.orderBy == undefined){
            return false;
        } else{
            return this.orderBy;
        }
    }

    init(){
        if(!this.initiated){
            let initialSort = this.getInitialSort();
            if(initialSort !== false){
                this.initiated = true;// to prevent recursion as sort calls this function
                this.sort(initialSort.column, initialSort.up);
            }
        }
        $(this.elem).empty();
        $(this.elem).append(this.getTable());
        anime({
            targets: `.${Table.class} tr`,
            translateX: [-50, 0],
            opacity: [0, 1],
            duration: 50,
            delay: anime.stagger(10), // increase delay by 100ms for each elements.
            easing: "easeOutCubic",
            complete: () => {
                $(`.${Table.class} tr`).css("transform", "");
                $(`.${Table.class} td`).css("position", "");
            }
        });
        this.initiated = true;
    }

    getLayoutIndex(name){
        let i = 0;
        for (const key in this.layout) {
            if(this.layout.hasOwnProperty(key)){
                const head =this.layout[key];
                if(head === name){
                    return i;
                }
            }
            i++;
        }
    }

    getUsedColumns(){
        const columns = [];
        if(this.layout != undefined){
            for (const key in this.layout) {
                if (this.layout.hasOwnProperty(key)) {
                    const element = this.layout[key];
                    if(element.hasOwnProperty("use")){
                        if(element.use){
                            columns.push(key);
                        }
                    } else{
                        columns.push(key);
                    }
                }
            }
            return columns;
        }
        for (const row of this.data) {
            for (const column in row) {
                if (row.hasOwnProperty(column)) {
                    if(!columns.includes(column)){
                        columns.push(column);
                    }
                }
            }
        }
        return columns;
    }

    updateData(data){
        this.data = data;
        this.init();
    }

    getTable(){
        const table = $(`<table class="${Table.class} ${this.name}"></table>`);
        $(table).append(this.getTableHead());
        let zebra = false;
        for (const row of this.data) {
            $(table).append(this.getRow(row, zebra));
            zebra = !zebra;
        }
        return table;
    }

    sort(column, up){
        const mul = up ? 1 : -1
        this.data.sort(function(a, b){
            if(a[column] == undefined){
                return mul;
            }
            if(b[column] == undefined){
                return -mul;
            }
            if(a[column] < b[column]) { return -1 * mul;}
            if(a[column] > b[column]) { return 1 * mul;}
            return 0;
        });
        this.init();
        const index = this.getLayoutIndex(column);
        this.getHeadElem(index).append(Dropdown.getIcon(`fas fa-sort-${up ? "up" : "down"}`, "margin left"));
    }
   
    getHeadElem(index){
        return $(this.elem).find(".index-" + index);
    }

    getTableHead(){
        const head = $(`<tr class="${Table.headClass}"></tr>`);
        let count = 0;
        for (const td of this.usedColumns) {
            let use = true;
            let allowSort = true;
            if(this.layout != undefined){
                if(this.layout.hasOwnProperty("allowSort")){
                    allowSort = this.layout.allowSort;
                }
                if(this.layout.hasOwnProperty("use")){
                    use = this.layout.use;
                }
            }
            const tdElem = $(`<td class="index-${count}">${this.getDisplayNameOfColumn(td)}</td>`);
            if(allowSort){
                const dropdown = new Dropdown(tdElem, [
                    {
                        element: "Sort ascending",
                        icon: "fas fa-sort-up",
                        onclick: () => {
                            this.sort(td, true);
                            return true;
                        }
                    }, {
                        element: "Sort descending",
                        icon: "fas fa-sort-down",
                        onclick: () => {
                            this.sort(td, false);
                            return true;
                        }
                    }
                ]);
                dropdown.setup({
                    name: "Sort by " + td
                })
                dropdown.init();
            }
            $(head).append(tdElem);
            count++;
        }
        return head;
    }

    getRow(row, zebra){
        const rowElem = $(`<tr class="${Table.bodyClass} ${zebra ? "zebra" : ""}"></tr>`);
        for (const column of this.usedColumns) {
            if(row.hasOwnProperty(column)){
                $(rowElem).append(this.getColumn(row[column]));
            } else{
                $(rowElem).append(this.getColumn(""));
            }
        }
        if(this.rowLink != undefined){
            rowElem.click(() => {
                window.location = this.rowLink(row);
            })
        }
        return rowElem;
    }
    
    getColumn(elem){
        if (elem instanceof jQuery){
            const e = $(`<td></td>`);
            e.append(elem);
            return e;
        } else if(elem == undefined){
            return $(`<td></td>`);
        } else{
            return $(`<td>${elem}</td>`);
        }
    }
}

/**
 * Profile
 * Generic profile class to deal with all kinds of profiles
 * profiles can be displayed in three LODs(level of detail):
 *  -> min
 *  -> card
 *  -> max
 * 
 * min:
 *  minimized view showing only the profile image, the name and one special information
 * 
 * card:
 *  showing only the profile image and al simple information like name, age etc.
 * 
 * max
 *  maximized view taking up the full screen revealing all informations
 * 
 * the min LOD can be set via the constructor
 * the profile will display the min LOD after initialization.
 * the user will allways be able to propagate to a higher LOD but never lower than the min LOD
 * 
 * profiles can be assigned a score to determine the order they should be displayed when put together in a slideshow
 * 
 * Dependencies:
 *  JQuery.js
 *  Tooltip
 *  fontawesome
 *  _profile.sass
 */

class Profile{

    /**
     * constants - not to be changed
     */
    static DEFAULT_SCORE = 0;
    static MIN = 0;//LOD min
    static CARD = 1;//LOD card
    static MAX = 2;//LOD max

    static MALE = 3;
    static FEMALE = 4;
    static DIVERSE = 5;

    /**
     * 
     * @param {{}} data data to fill this profile in the form of the name or as object like this:
     * {
     *  name: "",
     *  image: url,
     * 
     *  primary: {//those will be displayed in the card view. all dom elements or texts are supported but the following are predefined:
     *      gender: "m" / "w" / "d" / "man" / "women" / "diverse" / "female" / "male"
     *      category: "sen" / "jun"
     *      country "germany" etc.
     *      birthYear: number > 1800 //for detecting errors
     *      club: text //if empty not displayed
     *      team: text //if empty not displayed
     *  }
     * 
     *  secondary: { //those will only be displayed in the max view
     *      name1: dom elem1,
     *      name2: dom elem2,
     *  }
     * }
     * @param {Number} score 
     */
    constructor(data, minLod = Profile.MIN, score = Profile.DEFAULT_SCORE){
        console.log(data)
        this.score = score;
        this.minLod = minLod;
        this.lod = minLod;
        /**
         * default values
         */
        this.wrapper = undefined;
        this.elem = undefined; //jquery dom object
        this.name = "";
        this.image = undefined;
        this.primary = {};
        this.secondary = {};
        /**
         * initialization
         */
        if(typeof data === 'object'){
            if(data.hasOwnProperty("name")){
                this.name = data.name;
            }
            if(data.hasOwnProperty("image")){
                this.image = data.image;
            }
            if(data.hasOwnProperty("primary")){
                this.primary = data.primary;
            }
            if(data.hasOwnProperty("secondary")){
                this.secondary = data.secondary;
            }
        } else if(typeof data === 'string'){
            this.name = data;
        }

        this.init();
    }

    init(){
        if(this.elem !== undefined){
            this.elem.empty();
        }
        this.elem = $(`<div class="profile ${this.lodClass}"></div>`);
        this.elem.append(this.profileImg);
        this.elem.append(this.nameElem);
        this.elem.append(this.primaryElem);
        this.elem.append(this.minimizeElem);
        if(this.lod >= Profile.CARD){
            this.elem.append(this.secondaryElem);
        }
        if(this.lod === Profile.MIN){
            this.elem.click(() => {if(this.lod == Profile.MIN) {this.incrementLod()}});
        }
    }

    incrementLod(){
        if(this.lod < Profile.MAX){
            this.elem.removeClass(this.lodClass);
            this.lod++;
            this.elem.addClass(this.lodClass);
        }
    }

    decrementLod(){
        if(this.lod > this.minLod){
            this.elem.removeClass(this.lodClass);
            this.lod--;
            this.elem.addClass(this.lodClass);
        }
    }

    appendTo(parent){
        this.wrapper = $(`<div class="profile__wrapper ${this.lodClass}"/>`);
        this.wrapper.append(this.elem);
        $(parent).append(this.wrapper);
    }

    get nameElem(){
        return $(`<div class="profile__name"><span>${this.name}</span></div>`);
    }

    get profileImg(){
        if(this.image != null){
            return $(`<div class="profile__image"><img src="${this.image}" alt="profile image"></div>`);
        } else {
            const gender = this.gender;
            if(gender == Profile.FEMALE){
                return $(`<div class="profile__image"><img src="/img/profile-female.jpg" alt="profile image"></div>`);
            } else{
                return $(`<div class="profile__image"><img src="/img/profile-men.png" alt="profile image"></div>`);
            }
        }
    }

    get primaryElem(){
        const elem = $(`<div class="profile__primary"></div>`);
        const prim = this.primary;
        /**
         * gender
         */
        if(prim.hasOwnProperty("gender")){
            const gender = $(`<div class="profile__gender"></div>`);
            gender.append(this.genderElem);
            elem.append(gender);
        }
        /**
         * category
         */
        if(prim.hasOwnProperty("category")){
            elem.append(`<div class="profile__category">${this.categoryElem}</div>`);
        }
        /**
         * country (flag)
         */
        if(prim.hasOwnProperty("country")){
            const country = $(`<div class="profile__country"></div>`);
            country.append(getCountryFlag(prim.country));
            elem.append(country);
        }
        /**
         * birthYear
         */
        if(prim.hasOwnProperty("birthYear")){
            if(Number.isInteger(prim.birthYear) && prim.birthYear > 1800){
                const birthYear = $(`<div></div>`);
                birthYear.append(`<i class="far fa-calendar"></i>`);
                birthYear.append(prim.birthYear);
            }
        }
        /**
         * club
         */
        if(prim.hasOwnProperty("club")){
            if(typeof prim.club === "string" && prim.club.length > 0){
                const club = $(`<div class="profile__club"><i class="fas fa-users"></i></div>`);
                club.append(prim.club);
                elem.append(club);
            }
        }
        /**
         * team
         */
        if(prim.hasOwnProperty("team")){
            if(typeof prim.team === "string" && prim.team.length > 0){
                const team = $(`<div class="profile__team"><i class="fas fa-users"></i></div>`);
                team.append(prim.team);
                elem.append(team);
            }
        }
        return elem;
    }

    get secondaryElem(){
        const secondary = $(`<div class="profile__secondary"></div>`);
        for (const key in this.secondary) {
            if (Object.hasOwnProperty.call(this.secondary, key)) {
                const element = this.secondary[key];
                secondary.append(this.getSecondaryElem(element, key));
            }
        }
        return secondary;
    }

    get minimizeElem(){
        const elem = $(`<div class="profile__minimize"/>`);
        const button = $(`<button>Minimize</button>`);
        button.click((e) => {e.stopPropagation(); this.decrementLod()});
        elem.append(button);
        return elem;
    }

    /**
     * @todo
     * @param {*} obj 
     */
    getSecondaryElem(obj, name){
        return obj;
    }

    get gender(){
        if(this.primary.hasOwnProperty("gender")){
            if(this.primary.gender != null){
                switch(this.primary.gender.toLowerCase()){
                    case "w": return Profile.FEMALE;
                    case "women": return Profile.FEMALE;
                    case "female": return Profile.FEMALE;
                    case "m": return Profile.MALE;
                    case "man": return Profile.MALE;
                    case "men": return Profile.MALE;
                    case "male": return Profile.MALE;
                    case "d": return Profile.DIVERSE;
                    case "divers": return Profile.DIVERSE;
                }
            }
        }
    }

    get categoryElem(){
        if(this.primary.hasOwnProperty("category")){
            if(this.primary.category != null){
                let category;
                switch(this.primary.category.toLowerCase()){
                    case "sen":
                    case "senior":
                        category = "Senior";
                        break;
                    case "jun":
                    case "junior":
                        category = "Junior";
                        break;
                }
                if(category != null){
                    return $(`<div class="profile__category">${category}</div>`);
                } else{
                    return $();
                }
            }
        }
    }

    get genderElem(){
        switch(this.gender){
            case Profile.MALE: return $(`<i class="fas fa-mars"></i>`);
            case Profile.FEMALE: return $(`<i class="fas fa-venus"></i>`);
            case Profile.DIVERSE: return $(`<img src="/img/diverse.png" alt="diverse">`);
            default: return $();
        }
    }

    get lodClass(){
        switch(this.lod){
            case Profile.MIN: return "min";
            case Profile.CARD: return "card";
            case Profile.MAX: return "max";
            default: return "";
        }
    }
}

function removeParams(sParam) {
    var url = window.location.href.split('?')[0]+'?';
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&amp;'),
        sParameterName,
        i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] != sParam) {
            url = url + sParameterName[0] + '=' + sParameterName[1] + '&amp;'
        }
    }
    return url.substring(0,url.length-1);
}

/**
 * countries
 */
function countryNameToCode(name){
    name = name.toLowerCase();
    for (const country of countries) {
        if(country.name.toLowerCase() === name){
            return country.code;
        }
    }
}

function getCountryFlag(country){
    if(country === undefined){
        return $(`<div>-</div`);
    }
    const countryCode = countryNameToCode(country);
    if(countryCode !== null){
        return $(`<img src="https://www.countryflags.io/${countryCode}/shiny/32.png" alt="${country} flag">`);
    } else{
        return $(`<div>${country}</div>`);
    }
}

const countries = [ 
    {name: 'Afghanistan', code: 'AF'}, 
    {name: 'Åland Islands', code: 'AX'}, 
    {name: 'Albania', code: 'AL'}, 
    {name: 'Algeria', code: 'DZ'}, 
    {name: 'American Samoa', code: 'AS'}, 
    {name: 'AndorrA', code: 'AD'}, 
    {name: 'Angola', code: 'AO'}, 
    {name: 'Anguilla', code: 'AI'}, 
    {name: 'Antarctica', code: 'AQ'}, 
    {name: 'Antigua and Barbuda', code: 'AG'}, 
    {name: 'Argentina', code: 'AR'}, 
    {name: 'Armenia', code: 'AM'}, 
    {name: 'Aruba', code: 'AW'}, 
    {name: 'Australia', code: 'AU'}, 
    {name: 'Austria', code: 'AT'}, 
    {name: 'Azerbaijan', code: 'AZ'}, 
    {name: 'Bahamas', code: 'BS'}, 
    {name: 'Bahrain', code: 'BH'}, 
    {name: 'Bangladesh', code: 'BD'}, 
    {name: 'Barbados', code: 'BB'}, 
    {name: 'Belarus', code: 'BY'}, 
    {name: 'Belgium', code: 'BE'}, 
    {name: 'Belize', code: 'BZ'}, 
    {name: 'Benin', code: 'BJ'}, 
    {name: 'Bermuda', code: 'BM'}, 
    {name: 'Bhutan', code: 'BT'}, 
    {name: 'Bolivia', code: 'BO'}, 
    {name: 'Bosnia and Herzegovina', code: 'BA'}, 
    {name: 'Botswana', code: 'BW'}, 
    {name: 'Bouvet Island', code: 'BV'}, 
    {name: 'Brazil', code: 'BR'}, 
    {name: 'British Indian Ocean Territory', code: 'IO'}, 
    {name: 'Brunei Darussalam', code: 'BN'}, 
    {name: 'Bulgaria', code: 'BG'}, 
    {name: 'Burkina Faso', code: 'BF'}, 
    {name: 'Burundi', code: 'BI'}, 
    {name: 'Cambodia', code: 'KH'}, 
    {name: 'Cameroon', code: 'CM'}, 
    {name: 'Canada', code: 'CA'}, 
    {name: 'Cape Verde', code: 'CV'}, 
    {name: 'Cayman Islands', code: 'KY'}, 
    {name: 'Central African Republic', code: 'CF'}, 
    {name: 'Chad', code: 'TD'}, 
    {name: 'Chile', code: 'CL'}, 
    {name: 'China', code: 'CN'}, 
    {name: 'Christmas Island', code: 'CX'}, 
    {name: 'Cocos (Keeling) Islands', code: 'CC'}, 
    {name: 'Colombia', code: 'CO'}, 
    {name: 'Comoros', code: 'KM'}, 
    {name: 'Congo', code: 'CG'}, 
    {name: 'Congo, The Democratic Republic of the', code: 'CD'}, 
    {name: 'Cook Islands', code: 'CK'}, 
    {name: 'Costa Rica', code: 'CR'}, 
    {name: 'Cote D\'Ivoire', code: 'CI'}, 
    {name: 'Croatia', code: 'HR'}, 
    {name: 'Cuba', code: 'CU'}, 
    {name: 'Cyprus', code: 'CY'}, 
    {name: 'Czech Republic', code: 'CZ'}, 
    {name: 'Denmark', code: 'DK'}, 
    {name: 'Djibouti', code: 'DJ'}, 
    {name: 'Dominica', code: 'DM'}, 
    {name: 'Dominican Republic', code: 'DO'}, 
    {name: 'Ecuador', code: 'EC'}, 
    {name: 'Egypt', code: 'EG'}, 
    {name: 'El Salvador', code: 'SV'}, 
    {name: 'Equatorial Guinea', code: 'GQ'}, 
    {name: 'Eritrea', code: 'ER'}, 
    {name: 'Estonia', code: 'EE'}, 
    {name: 'Ethiopia', code: 'ET'}, 
    {name: 'Falkland Islands (Malvinas)', code: 'FK'}, 
    {name: 'Faroe Islands', code: 'FO'}, 
    {name: 'Fiji', code: 'FJ'}, 
    {name: 'Finland', code: 'FI'}, 
    {name: 'France', code: 'FR'}, 
    {name: 'French Guiana', code: 'GF'}, 
    {name: 'French Polynesia', code: 'PF'}, 
    {name: 'French Southern Territories', code: 'TF'}, 
    {name: 'Gabon', code: 'GA'}, 
    {name: 'Gambia', code: 'GM'}, 
    {name: 'Georgia', code: 'GE'}, 
    {name: 'Germany', code: 'DE'}, 
    {name: 'Ghana', code: 'GH'}, 
    {name: 'Gibraltar', code: 'GI'}, 
    {name: 'Greece', code: 'GR'}, 
    {name: 'Greenland', code: 'GL'}, 
    {name: 'Grenada', code: 'GD'}, 
    {name: 'Guadeloupe', code: 'GP'}, 
    {name: 'Guam', code: 'GU'}, 
    {name: 'Guatemala', code: 'GT'}, 
    {name: 'Guernsey', code: 'GG'}, 
    {name: 'Guinea', code: 'GN'}, 
    {name: 'Guinea-Bissau', code: 'GW'}, 
    {name: 'Guyana', code: 'GY'}, 
    {name: 'Haiti', code: 'HT'}, 
    {name: 'Heard Island and Mcdonald Islands', code: 'HM'}, 
    {name: 'Holy See (Vatican City State)', code: 'VA'}, 
    {name: 'Honduras', code: 'HN'}, 
    {name: 'Hong Kong', code: 'HK'}, 
    {name: 'Hungary', code: 'HU'}, 
    {name: 'Iceland', code: 'IS'}, 
    {name: 'India', code: 'IN'}, 
    {name: 'Indonesia', code: 'ID'}, 
    {name: 'Iran, Islamic Republic Of', code: 'IR'}, 
    {name: 'Iraq', code: 'IQ'}, 
    {name: 'Ireland', code: 'IE'}, 
    {name: 'Isle of Man', code: 'IM'}, 
    {name: 'Israel', code: 'IL'}, 
    {name: 'Italy', code: 'IT'}, 
    {name: 'Italia', code: 'IT'}, 
    {name: 'Jamaica', code: 'JM'}, 
    {name: 'Japan', code: 'JP'}, 
    {name: 'Jersey', code: 'JE'}, 
    {name: 'Jordan', code: 'JO'}, 
    {name: 'Kazakhstan', code: 'KZ'}, 
    {name: 'Kenya', code: 'KE'}, 
    {name: 'Kiribati', code: 'KI'}, 
    {name: 'Korea, Democratic People\'S Republic of', code: 'KP'}, 
    {name: 'Korea, Republic of', code: 'KR'}, 
    {name: 'Kuwait', code: 'KW'}, 
    {name: 'Kyrgyzstan', code: 'KG'}, 
    {name: 'Lao People\'S Democratic Republic', code: 'LA'}, 
    {name: 'Latvia', code: 'LV'}, 
    {name: 'Lativa', code: 'LV'}, 
    {name: 'Lebanon', code: 'LB'}, 
    {name: 'Lesotho', code: 'LS'}, 
    {name: 'Liberia', code: 'LR'}, 
    {name: 'Libyan Arab Jamahiriya', code: 'LY'}, 
    {name: 'Liechtenstein', code: 'LI'}, 
    {name: 'Lithuania', code: 'LT'}, 
    {name: 'Luxembourg', code: 'LU'}, 
    {name: 'Macao', code: 'MO'}, 
    {name: 'Macedonia, The Former Yugoslav Republic of', code: 'MK'}, 
    {name: 'Madagascar', code: 'MG'}, 
    {name: 'Malawi', code: 'MW'}, 
    {name: 'Malaysia', code: 'MY'}, 
    {name: 'Maldives', code: 'MV'}, 
    {name: 'Mali', code: 'ML'}, 
    {name: 'Malta', code: 'MT'}, 
    {name: 'Marshall Islands', code: 'MH'}, 
    {name: 'Martinique', code: 'MQ'}, 
    {name: 'Mauritania', code: 'MR'}, 
    {name: 'Mauritius', code: 'MU'}, 
    {name: 'Mayotte', code: 'YT'}, 
    {name: 'Mexico', code: 'MX'}, 
    {name: 'Micronesia, Federated States of', code: 'FM'}, 
    {name: 'Moldova, Republic of', code: 'MD'}, 
    {name: 'Monaco', code: 'MC'}, 
    {name: 'Mongolia', code: 'MN'}, 
    {name: 'Montserrat', code: 'MS'}, 
    {name: 'Morocco', code: 'MA'}, 
    {name: 'Mozambique', code: 'MZ'}, 
    {name: 'Myanmar', code: 'MM'}, 
    {name: 'Namibia', code: 'NA'}, 
    {name: 'Nauru', code: 'NR'}, 
    {name: 'Nepal', code: 'NP'}, 
    {name: 'Netherlands', code: 'NL'}, 
    {name: 'Netherlands Antilles', code: 'AN'}, 
    {name: 'New Caledonia', code: 'NC'}, 
    {name: 'New Zealand', code: 'NZ'}, 
    {name: 'Nicaragua', code: 'NI'}, 
    {name: 'Niger', code: 'NE'}, 
    {name: 'Nigeria', code: 'NG'}, 
    {name: 'Niue', code: 'NU'}, 
    {name: 'Norfolk Island', code: 'NF'}, 
    {name: 'Northern Mariana Islands', code: 'MP'}, 
    {name: 'Norway', code: 'NO'}, 
    {name: 'Oman', code: 'OM'}, 
    {name: 'Pakistan', code: 'PK'}, 
    {name: 'Palau', code: 'PW'}, 
    {name: 'Palestinian Territory, Occupied', code: 'PS'}, 
    {name: 'Panama', code: 'PA'}, 
    {name: 'Papua New Guinea', code: 'PG'}, 
    {name: 'Paraguay', code: 'PY'}, 
    {name: 'Peru', code: 'PE'}, 
    {name: 'Philippines', code: 'PH'}, 
    {name: 'Pitcairn', code: 'PN'}, 
    {name: 'Poland', code: 'PL'}, 
    {name: 'Portugal', code: 'PT'}, 
    {name: 'Puerto Rico', code: 'PR'}, 
    {name: 'Qatar', code: 'QA'}, 
    {name: 'Reunion', code: 'RE'}, 
    {name: 'Romania', code: 'RO'}, 
    {name: 'Russian Federation', code: 'RU'}, 
    {name: 'RWANDA', code: 'RW'}, 
    {name: 'Saint Helena', code: 'SH'}, 
    {name: 'Saint Kitts and Nevis', code: 'KN'}, 
    {name: 'Saint Lucia', code: 'LC'}, 
    {name: 'Saint Pierre and Miquelon', code: 'PM'}, 
    {name: 'Saint Vincent and the Grenadines', code: 'VC'}, 
    {name: 'Samoa', code: 'WS'}, 
    {name: 'San Marino', code: 'SM'}, 
    {name: 'Sao Tome and Principe', code: 'ST'}, 
    {name: 'Saudi Arabia', code: 'SA'}, 
    {name: 'Senegal', code: 'SN'}, 
    {name: 'Serbia and Montenegro', code: 'CS'}, 
    {name: 'Seychelles', code: 'SC'}, 
    {name: 'Sierra Leone', code: 'SL'}, 
    {name: 'Singapore', code: 'SG'}, 
    {name: 'Slovakia', code: 'SK'}, 
    {name: 'Slovenia', code: 'SI'}, 
    {name: 'Solomon Islands', code: 'SB'}, 
    {name: 'Somalia', code: 'SO'}, 
    {name: 'South Africa', code: 'ZA'}, 
    {name: 'South Georgia and the South Sandwich Islands', code: 'GS'}, 
    {name: 'Spain', code: 'ES'}, 
    {name: 'Sri Lanka', code: 'LK'}, 
    {name: 'Sudan', code: 'SD'}, 
    {name: 'Suriname', code: 'SR'}, 
    {name: 'Svalbard and Jan Mayen', code: 'SJ'}, 
    {name: 'Swaziland', code: 'SZ'}, 
    {name: 'Sweden', code: 'SE'}, 
    {name: 'Switzerland', code: 'CH'}, 
    {name: 'Syrian Arab Republic', code: 'SY'}, 
    {name: 'Taiwan, Province of China', code: 'TW'}, 
    {name: 'Tajikistan', code: 'TJ'}, 
    {name: 'Tanzania, United Republic of', code: 'TZ'}, 
    {name: 'Thailand', code: 'TH'}, 
    {name: 'Timor-Leste', code: 'TL'}, 
    {name: 'Togo', code: 'TG'}, 
    {name: 'Tokelau', code: 'TK'}, 
    {name: 'Tonga', code: 'TO'}, 
    {name: 'Trinidad and Tobago', code: 'TT'}, 
    {name: 'Tunisia', code: 'TN'}, 
    {name: 'Turkey', code: 'TR'}, 
    {name: 'Turkmenistan', code: 'TM'}, 
    {name: 'Turks and Caicos Islands', code: 'TC'}, 
    {name: 'Tuvalu', code: 'TV'}, 
    {name: 'Uganda', code: 'UG'}, 
    {name: 'Ukraine', code: 'UA'}, 
    {name: 'United Arab Emirates', code: 'AE'}, 
    {name: 'United Kingdom', code: 'GB'}, 
    {name: 'United States', code: 'US'}, 
    {name: 'United States Minor Outlying Islands', code: 'UM'}, 
    {name: 'Uruguay', code: 'UY'}, 
    {name: 'Uzbekistan', code: 'UZ'}, 
    {name: 'Vanuatu', code: 'VU'}, 
    {name: 'Venezuela', code: 'VE'}, 
    {name: 'Viet Nam', code: 'VN'}, 
    {name: 'Virgin Islands, British', code: 'VG'}, 
    {name: 'Virgin Islands, U.S.', code: 'VI'}, 
    {name: 'Wallis and Futuna', code: 'WF'}, 
    {name: 'Western Sahara', code: 'EH'}, 
    {name: 'Yemen', code: 'YE'}, 
    {name: 'Zambia', code: 'ZM'}, 
    {name: 'Zimbabwe', code: 'ZW'} 
  ]