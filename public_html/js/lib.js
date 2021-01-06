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
        return $(`<i class="${faClass} ${extraClasses != undefined ? extraClasses : ""}"><i>`);
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
 * Class for parsing elements
 * 
 * dependencies:
 *  JQuery.js
 *  FontAwesome.js
 * 
 * an element can be a country, name, icon, image etc...
 * 
 * elements can be given in raw form of text, numbers, dom elements etc
 * but can also be a js object containing the data itself and meta information about how to be displayed
 * meta informations can contain:
 *  data: //data to be displayed and interpreteed
 *  type: //type to be interpreted as | default("text")
 *  link: //link wich to where the parsed elem should navigate
 *  onclick: //callback to be called on click
 *  display: "inline" / "block" default("block")
 *  icon: "fas fa-users" //Font awesome icon class
 *  validate: () => true // callback to verify the data is correct. doesnt display if returned false
 *  bounds: {left: 0, top: 0}
 *  description: "description"
 *  
 *  
 * types can be added manualy using addType(name, parser)
 * 
 * examples:
 *  "hallo welt"
 *  1
 *  true
 *  false
 *  
 *  {
 *      data: "w"
 *      type: ElemParser.GENDER
 *  }
 *  {
 *      data: "/img/uploads/profile.jpg"
 *      type: ElemParser.IMAGE
 *  }
 *  {
 *      data: "GER" / "Germany"
 *      type: ElemParser.COUNTRY
 *      link: "/country/index?country=GERMANY"
 *      onclick: () => {alert("test")}
 *      icon: "fas fa-users"
 *  }
 */
class ElemParser{

    /**
     * default types
     */
    static PRIMITIVE = "primitive";
    static IMAGE = "image";
    static COUNTYR_FLAG = "countryFlag";
    static GENDER = "gender";
    static TEXT = "text";
    static DOM = "dom"

    /**
     * helpers
     */
    static MALE = 100;
    static FEMALE = 101;
    static DIVERSE = 102;

    static parser = {
        [ElemParser.PRIMITIVE]: (elem) => $(`<div>${elem.data}</div>`),
        [ElemParser.IMAGE]: (elem) => $(`<img src="${elem.date}" alt="image">`),
        [ElemParser.COUNTYR_FLAG]: (elem) => getCountryFlag(elem.data),
        [ElemParser.GENDER]: (elem) => ElemParser.parseGender(elem.data),
        [ElemParser.TEXT]: (elem) => $(`<div>${elem.data}</div>`),
        [ElemParser.DOM]: (elem) => elem.data
    };

    static addType(type, parser){
        ElemParser.parser[type] = parser;
    }

    static parse(elem){
        if(typeof elem === 'object'){
            return ElemParser.finishElem(ElemParser.parseMeta(elem), elem);
        } else if(elem !== undefined && elem !== null){
            return ElemParser.finishElem(ElemParser.parsePrimitive(elem));
        } else{
            return ElemParser.finishElem(ElemParser.getFreshElem());
        }
    }

    static parseMeta(meta){
        if(isDomElem(meta)){
            return meta;
        }
        if(ElemParser.isValidMeta(meta)){
            if(meta.data === null){
                return false;
            }
            if(meta.hasOwnProperty("validate")){
                if(!meta.validate(meta.data)){
                    return false;
                }
            } else{
                if(meta.data.length === 0){
                    return false;
                }
            }
            if(meta.hasOwnProperty("type")){
                if(ElemParser.parser.hasOwnProperty(meta.type)){
                    const parsedElem = ElemParser.parser[meta.type](meta);
                    return parsedElem;
                }
            }
            return ElemParser.parser[ElemParser.TEXT](meta);
        } else{
            return false;
        }
    }

    static finishElem(elem, meta){
        if(elem === false){
            return false;
        }
        if(meta === undefined){
            meta = {};
        }
        if(meta.hasOwnProperty("onclick")){
            if(meta.hasOwnProperty("link")){
                $(elem).click((e) => {
                    meta.onclick(e);
                    window.location = meta.link;
                });
            }
        } else if(meta.hasOwnProperty("link")){
            $(elem).click(() => {
                window.location = meta.link;
            });
        }
        const wrapper = ElemParser.getFreshElem(meta);
        if(meta.hasOwnProperty("icon")){
            wrapper.addClass("flex align-start justify-start");
            wrapper.prepend(`<i class="${meta.icon} margin right"></i>`);
        }
        wrapper.append(elem);
        if(meta.hasOwnProperty("bounds")){
            wrapper.css("position", "absolute");
            if(meta.bounds.hasOwnProperty("left")){
                wrapper.css("left", meta.bounds.left);
            }
            if(meta.bounds.hasOwnProperty("top")){
                wrapper.css("top", meta.bounds.top);
            }
            if(meta.bounds.hasOwnProperty("bottom")){
                wrapper.css("bottom", meta.bounds.bottom);
            }
            if(meta.bounds.hasOwnProperty("right")){
                wrapper.css("right", meta.bounds.right);
            }
        }
        if(meta.hasOwnProperty("description")){
            elem.prepend(`<div class="margin right">${meta.description}</div>`);
            elem.addClass("flex justify-start");
        }
        return wrapper;
    }

    /**
     * meta data is valid if it has at least the data attribute
     * 
     * @param {{}} meta meta to be checked
     */
    static isValidMeta(meta){
        if(typeof meta === 'object'){
            return meta.hasOwnProperty("data");
        }
        return false;
    }

    static getFreshElem(data){
        if(data !== undefined){
            if(typeof data === 'object'){
                if(data.hasOwnProperty("display")){
                    if(data.display === "inline"){
                        return $(`<span/>`);
                    }
                }
            }
        }
        return $(`<div/>`);
    }

    static parsePrimitive(prim){
        const elem = $(`<div>${prim}</div>`);
        return elem;
    }

    static getGender(gender){
        switch(gender.toLowerCase()){
            case "w": return ElemParser.FEMALE;
            case "women": return ElemParser.FEMALE;
            case "female": return ElemParser.FEMALE;
            case "m": return ElemParser.MALE;
            case "man": return ElemParser.MALE;
            case "men": return ElemParser.MALE;
            case "male": return ElemParser.MALE;
            case "d": return ElemParser.DIVERSE;
            case "divers": return ElemParser.DIVERSE;
            default: return ElemParser.MALE;
        }
    }

    static parseGender(data){
        switch(ElemParser.getGender(data)){
            case ElemParser.MALE: return $(`<i class="fas fa-mars"></i>`);
            case ElemParser.FEMALE: return $(`<i class="fas fa-venus"></i>`);
            case ElemParser.DIVERSE: return $(`<img src="/img/diverse.png" alt="diverse">`);
            default: return ElemParser.getFreshElem();
        }
    }

    static isGender(element){
        if(!ElemParser.isValidMeta(element)){
            return false;
        }
        if(typeof element === 'object'){
            if(element.hasOwnProperty("type")){
                if(element.type == ElemParser.GENDER){
                    return true;
                }
            }
        }
        return false;
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

    static profileCount = 0;

    /**
     * storage
     */
    /**
     * used to close all others when one is opened
     */
    static expanded = [];

    /**
     * All properties can be primitive date or element objects to bve parsed by ElemParser see ElemParser to see documentation
     * 
     * @param {{}} data data to fill this profile in the form of the name or as object like this:
     * {
     *  name: "",
     *  image: url,
     *  left: elem //left and right refering to the stuff wich can be displayed left and right to the image in card view
     *  right: elem
     *  trophy1: elem//trophys to be displayed right next to the image
     *  trophy2: elem
     *  trophy3: elem
     * 
     *  primary: {
     *      gender: "m"
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

        /**
         * idprofile
         */
        this.idprofile = Profile.profileCount;
        Profile.profileCount++;

        this.score = score;
        this.minLod = minLod;
        this.lod = minLod;
        /**
         * default values
         */
        this.wrapper = undefined;
        this.elem = undefined; //jquery dom object
        this.left = undefined;
        this.right = undefined;
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
            if(data.hasOwnProperty("left")){
                this.left = data.left;
            }
            if(data.hasOwnProperty("right")){
                this.right = data.right;
            }
            if(data.hasOwnProperty("trophy1")){
                this.trophy1 = data.trophy1;
            }
            if(data.hasOwnProperty("trophy2")){
                this.trophy2 = data.trophy2;
            }
            if(data.hasOwnProperty("trophy3")){
                this.trophy3 = data.trophy3;
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
        this.elem = $(`<div class="profile ${this.lodClass}" id="${this.idprofile}"></div>`);
        this.elem.append(this.profileImg);
        this.elem.append(this.nameElem);
        this.elem.append(this.leftElem);
        this.elem.append(this.rightElem);
        this.elem.append(this.getTrophy(0));
        this.elem.append(this.getTrophy(1));
        this.elem.append(this.getTrophy(2));
        this.elem.append(this.primaryElem);
        this.elem.append(this.minimizeElem);
        this.elem.append(this.maximizeElem);
        if(this.lod === Profile.MAX){
            this.elem.append(this.secondaryElem);
            this.initMax();
        }
        if(this.lod === Profile.MIN){
            this.elem.click(() => {if(this.lod == Profile.MIN) {this.incrementLod()}});
        }
        this.checkGet();
    }

    initMax(){
        
    }

    /**
     * check if get has parameter pointing to this profile and cardify it if so
     */
    checkGet(){
        const idprofile = findGetParameter("idprofile");
        if(idprofile !== null){
            idprofile = parseInt(idprofile);
            if(idprofile === this.idprofile){
                this.cardify();
                removeParams("idprofile");
            }
        }
    }

    incrementLod(){
        if(this.lod < Profile.MAX){
            this.closeAllOthers();
            this.elem.removeClass(this.lodClass);
            this.lod++;
            this.elem.addClass(this.lodClass);
            if(this.lod === Profile.MAX){
                window.setTimeout(() => {this.hideEverythingElse()}, 200);
                this.elem.find(".profile__minimize button").text("Back");
            }
            if(Profile.expanded.indexOf(this) === -1){
                Profile.expanded.push(this);//add to expanded
            }
            this.scollIntoView();
        }
    }

    decrementLod(){
        if(this.lod > this.minLod){
            this.elem.removeClass(this.lodClass);
            this.lod--;
            this.elem.addClass(this.lodClass);
            if(this.lod === this.minLod){
                Profile.expanded.splice(Profile.expanded.indexOf(this), 1);//remove from expanded
            }
            if(this.lod === Profile.CARD){
                this.showEverythingElse();
                this.scollIntoView();
                this.elem.find(".profile__minimize button").text("Minimize");
            }
        }
    }

    hideEverythingElse(){
        $(`main *:not(header, footer`).addClass("hidden");
        this.elem.parents().removeClass("hidden");
        this.elem.removeClass("hidden");
        this.elem.find("*:not(.profile__maximize)").removeClass("hidden");

        const bounds = this.elem.get(0).getBoundingClientRect();
        console.log(bounds);
        this.elem.css("left", -bounds.left);
        // this.elem.css("top", -bounds.top);
    }

    showEverythingElse(){
        $(`main *`).removeClass("hidden");
        this.elem.css("left", 0);
        // this.elem.css("top", 0);
    }

    closeAllOthers(){
        for (const profile of Profile.expanded) {
            if(profile !== this){
                profile.close();
            }
        }
    }

    close(){
        console.log("closing")
        while(this.lod > this.minLod){
            this.decrementLod();
        }
    }

    appendTo(parent){
        this.wrapper = $(`<div class="profile__wrapper ${this.lodClass}"/>`);
        this.wrapper.append(this.elem);
        $(parent).append(this.wrapper);
    }

    scollIntoView(){
        var offset = $(this.elem).offset();
        offset.left -= window.scrollX;
        offset.top -= window.scrollY;
        if(offset.top < 0 || offset.left < 0 || offset.top > window.innerHeight - 500 || offset.left > window.innerWidth - 300){
            var offset = $(this.elem).offset();
            $('html, body').animate({
                scrollTop: offset.top - 70,
                scrollLeft: offset.left - 20,
                duration: 100
            });
        }
    }

    get nameElem(){
        return $(`<div class="profile__name"><span>${this.name}</span></div>`);
    }

    get leftElem(){
        if(this.left !== undefined){
            const elem = ElemParser.parse(this.left);
            elem.addClass("profile__left");
            return elem;
        }
        return $();
    }

    get rightElem(){
        if(this.right !== undefined){
            const elem = ElemParser.parse(this.right);
            elem.addClass("profile__right");
            return elem;
        }
        return $();
    }

    getTrophy(index){
        index++;
        const name = "trophy" + index;
        if(this[name] !== undefined){
            const elem = ElemParser.parse(this[name]);
            if(elem !== false){
                elem.addClass("profile__trophy-" + index);
                elem.addClass("profile__trophy");
                return elem;
            }
        }
        return $();
    }

    get profileImg(){
        if(this.image != undefined){
            return $(`<div class="profile__image"><img src="${this.image}" alt="profile image"></div>`);
        } else {
            const gender = this.gender;
            if(gender == ElemParser.FEMALE){
                return $(`<div class="profile__image"><img src="/img/profile-female.png" alt="profile image"></div>`);
            } else{
                return $(`<div class="profile__image"><img src="/img/profile-men.png" alt="profile image"></div>`);
            }
        }
    }

    get gender(){
        for (const key in this.primary) {
            if (Object.hasOwnProperty.call(this.primary, key)) {
                const element = this.primary[key];
                if(ElemParser.isGender(element)){
                    return ElemParser.getGender(element.data);
                }
            }
        }
        if(ElemParser.isGender(this.left)){
            return ElemParser.getGender(this.left.data);
        }
        if(ElemParser.isGender(this.right)){
            return ElemParser.getGender(this.right.data);
        }
    }

    get primaryElem(){
        const elem = $(`<div class="profile__primary"></div>`);
        for (const key in this.primary) {
            if (Object.hasOwnProperty.call(this.primary, key)) {
                const primElem = ElemParser.parse(this.primary[key]);
                if(primElem !== false){
                    primElem.addClass(`profile__primary__${key}`);
                    elem.append(primElem);
                }
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
        const button = $(`<button class="btn border-only">Minimize</button>`);
        button.click((e) => {e.stopPropagation(); this.decrementLod(); console.log("dec clicked")});
        elem.append(button);
        return elem;
    }

    get maximizeElem(){
        const elem = $(`<button class="profile__maximize"/>`);
        elem.click((e) => {e.stopPropagation(); this.incrementLod()});
        return elem;
    }

    /**
     * @todo
     * @param {*} obj 
     */
    getSecondaryElem(obj, name){
        return obj;
    }

    get categoryElem(){
        if(this.primary.hasOwnProperty("category")){
            if(this.primary.category != undefined){
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
                if(category != undefined){
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

/**
 * GET
 */

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

function findGetParameter(parameterName) {
    var result = null, tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
          tmp = item.split("=");
          if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}

/**
 * Medals
 */

function getMedal(color, amount){
    let linkSimple = "/img/medals/" + color + "-medal-simple.svg";
    let linkBig = "/img/medals/" + color + "-medal.svg";
    const elem = $(`<div class="medal ${color}">
        <img class="medal__big" width="40" src="${linkBig}" alt="${color} medal">
        <img class="medal__simple" width="40" src="${linkSimple}" alt="${color} medal">
        <span class="medal__amount">${amount}</span>
    </div>`);
    return elem;
}

/**
 * dom
 */
function isDomElem(obj) {
    if(obj instanceof HTMLCollection && obj.length) {
        for(var a = 0, len = obj.length; a < len; a++) {
            if(!checkInstance(obj[a])) {
                return false;
            }
        }
        return true;
    } else {
        return checkInstance(obj);
    }

    function checkInstance(elem) {
        if((elem instanceof jQuery && elem.length) || elem instanceof HTMLElement) {
            return true;
        }
        return false;
    }
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

function countryCodeValid(code){
    for (const country of countries) {
        if(country.code === code){
            return true;
        }
    }
    return false;
}

function getCountryFlag(country){
    if(country === undefined){
        return $(`<div>-</div`);
    }
    const countryCode = countryNameToCode(country);
    if(countryCode !== undefined){
        return $(`<img src="https://www.countryflags.io/${countryCode}/shiny/32.png" alt="${country} flag">`);
    } else{
        if(countryCodeValid(country)){
            return $(`<img src="https://www.countryflags.io/${country}/shiny/32.png" alt="${country} flag">`);
        } else{
            return $(`<div>${country}</div>`);
        }
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