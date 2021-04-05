"use strict";

/**
 * simple Accordion
 */

class Accordion{

    // static registered = [];

    constructor(head, body, setup = {}){
        this.extended = false;
        this.elem = undefined;

        this.status = {};

        this.oncollapse = (head, body) => true;
        this.onextend = (head, body) => true;

        this.head = ElemParser.parse(head);
        this.body = ElemParser.parse(body);
        this.setup(setup);
        this.init();
    }

    /**
     * possible options:
     * extended: true / false //initial state
     * onextend: callback //callback to be called on extend with signature of (head, body) if returns false extend will be canceled
     * oncolapse: callback //callback to be called on collapse with signature of (head, body) if returns false collapse will be canceled
     * status: prop // a avriable that will only be stored and not modified. will be passed to the onextend and oncollapse callbacks to simplify ajax calls etc
     * 
     * 
     * @param {{}} setup setup object
     */
    setup(setup){
        if(setup === undefined){
            return false;
        }
        const props = ["extended", "onextend", "oncollapse", "status"];//to be extended
        for (const prop of props) {
            if(setup.hasOwnProperty(prop)){
                this[prop] = setup[prop];
            }
        }
    }

    init(){
        this.elem = $(`<div class="accordion"><div class="accordion__head"></div><div class="accordion__body"></div></div>`);
        this.elem.find(".accordion__head").append(this.head);
        this.elem.find(".accordion__body").append(this.body);
        this.body.css("display", "none");
        this.head.click(() => {
            this.toggle();
        });
        if(this.extended){
            this.extend();
        } else{
            this.collapse();
        }
        // this.element.parents().each((i, e) => {
        //     if(Accordion.registered.hasOwnProperty(e)){
        //         Accordion.registered[e].
        //         return;
        //     }
        // });
        // register()
    }

    toggle(){
        if(this.extended){
            this.collapse();
        } else{
            this.extend();
        }
    }

    extend(){
        if(this.onextend(this.head, this.body, this.status) === false){
            return false;
        }
        // this.body.css("height", "");
        this.body.css("display", "block");
        this.body.parent().addClass("extended");
        this.extended = true;
    }

    collapse(){
        if(this.oncollapse(this.head, this.body, this.status) === false){
            return false;
        }
        // this.body.css("height", "0");
        this.body.css("display", "none");
        // window.setTimeout(() => {this.body.css("display", "none")}, 90);
        this.body.parent().removeClass("extended");
        this.extended = false;
    }

    // register(){
    //     Accordion.registered[this.elem] = this;
    // }

    get element(){
        return this.elem;
    }
}

/**
 * Slideshow
 * Dependencies: 
 *  JQuery.js
 */
class Slideshow{
    /**
     * @param {dom elem} elem dom element
     */
    constructor(elem){
        this.elem = $(elem);
        this.velX = 0;
        this.velY = 0;
        this.x = 0;
        this.fps = 60;
        this.pressed = false;
        this.lastMoved = Date.now();
        this.init();
    }

    init(){
        this.elem.addClass("slideshow");
        this.elem.get()[0].addEventListener('mousedown', (e) => this.down(e));
        this.elem.get()[0].addEventListener('mouseup', (e) => this.up(e));
        this.elem.get()[0].addEventListener('touchstart', (e) => this.down(e));
        this.elem.get()[0].addEventListener('touchend', (e) => this.up(e));
        this.elem.get()[0].addEventListener('mousemove', (e) => this.move(e));
        this.elem.get()[0].addEventListener('touchmove', (e) => this.move(e));
        this.elem.get()[0].addEventListener('mouseenter', (e) => this.enter(e));
        this.elem.get()[0].addEventListener('mouseleave', (e) => this.leave(e));
        this.elem.get()[0].addEventListener('touchenter', (e) => this.enter(e));
        this.elem.get()[0].addEventListener('touchleave', (e) => this.leave(e));
    }

    remove(){
        this.elem.empty();
    }

    update(){
        if(!this.pressed){
            // alert(this.x + this.velX * 10800);
            anime({
                targets: this.elem.get()[0],
                scrollLeft: this.getClosest(this.velX * 100),
                duration: (1000 / this.fps) * 30,
                easing: 'easeOutQuint'
            });
        } else{
            this.elem.get()[0].scrollLeft = this.x;
        }
    }

    getClosest(add){
        let closest = this.elem.width();
        let closestIndex = -1;
        let closestOffset = 0;
        const scroll = this.elem.get()[0].scrollLeft + add;
        this.elem.children().each(function(i) {
            var childPos = $(this).offset();
            var parentPos = $(this).parent().offset();
            var childOffset = {
                top: childPos.top - parentPos.top,
                left: childPos.left - parentPos.left
            }
            if(Math.abs(childOffset.left) < closest){
                closest = Math.abs(childOffset.left);
                closestIndex = i;
                closestOffset = childOffset.left;
            }
        });
        if(closestIndex !== -1){
            return closestOffset + scroll;
        } else{
            return x;
        }
    }

    down(e){
        this.pressed = true;
        this.x = this.elem.get()[0].scrollLeft;
        const page = Slideshow.getPageFromEvent(e);
        this.isMobile = page.isMobile;
        this.tapStartX = page.x;
        this.scrollStartX = this.x;
        this.velX = 0;
        this.velY = 0;
        this.lastMoveTime = Date.now();
    }

    up(e){
        this.pressed = false;
        this.x = this.elem.get()[0].scrollLeft;
        this.update();
        // e.stopPropagation();
        // e.preventDefault();
    }

    move(e){
        if(!this.pressed){
            return;
        }
        const now = Date.now();
        const page = Slideshow.getPageFromEvent(e);
        this.velX = (this.lastMoveX - page.x) / (now - this.lastMoveTime);
        this.velY = (this.lastMoveY - page.y) / (now - this.lastMoveTime);
        this.lastMoveX = page.x;
        this.lastMoveY = page.y;
        this.lastMoveTime = now;
        this.x = this.scrollStartX + (this.tapStartX - page.x);
        if(Math.abs(this.velY) * 1.5 > Math.abs(this.velX)){
            this.velX = 0;
        } else {
            e.preventDefault();
            this.update();
        }
    }

    enter(e){
        // const page = Slideshow.getPageFromEvent(e);
    }

    leave(e){
        this.up(e);
    }

    static getPageFromEvent(e){
        const mobileEventes = ["touchstart", "touchend", "touchleave", "touchenter", "touchmove"];
        let x = 0;
        let y = 0;
        let isMobile = false;
        if(mobileEventes.includes(e.type)){
            isMobile = true;
            if(e.touches[0] !== undefined){
                x = e.touches[0].pageX;
                y = e.touches[0].pageY;
            }
        } else{
            x = e.pageX;
            y = e.pageY;
        }
        return {x, y, isMobile};
    }
}

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
 *                              style: //style object example: {padding: "1rem", etc},
 *                       }
 *                  ]
 */

class Dropdown{

    static allDropDowns = [];
    static dropdownClass = "data-dropdown";
    static entryClass = "data-dropdown__entry";
    static nameClass = "data-dropdown__name";

    constructor(elem, content = "Dropdown", setupObj = {}){
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
                transformOrigin: "top",
                rotateX: ["-20deg", 0],
                opacity: [0, 1],
                duration: 300,
                easing: "easeOutCubic"
            }
        }
        
        this.closeAnimation = () => {
            return  {
                opacity: [1, 0],
                duration: 100,
                easing: "easeOutCubic"
            }
        }
        this.setup(setupObj);
        this.init();
    }

    getDropDownElem(){
        return this.dropDownElem.get();
    }

    /**
     * Setup function
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
     * init (caled last by constructor)
     */
    init(){
        this.dropDownElem = $(`<div class="${Dropdown.dropdownClass} ${this.customClass != undefined ? this.customClass : ""}"></div>`);
        // console.log(this.content);
        // this.dropDownElem.append(this.content);
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
            if(this.parentObj != undefined) {
                if(object != this.content) {
                    this.dropDownElem.append(this.getBackButton());
                }
            }
            for (const obj of object) {
                const elem = this.getObjElem(obj);
                this.dropDownElem.append(elem)
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
        return $(`<i class="${faClass} ${extraClasses ? extraClasses : ""}"><i>`);
    }

    getObjElem(obj){
        const elem = $(`<div class="${Dropdown.entryClass} flex"></div>`);
        if(obj.hasOwnProperty("element")){
            elem.append(ElemParser.parse(obj.element));
        } else {
            elem.append(ElemParser.parse(obj));
        }
        if(obj.children){
            elem.click(() => {
                this.parentObj = obj;
                this.load(obj.children);
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

        if(obj?.element?.hasOwnProperty("justify")){
            elem.addClass(obj.element.justify);
        }
        /**
         * padding
         */
        // if("style" in obj){
        if(obj.hasOwnProperty("style")){
            for (const key in obj.style) {
                if (Object.hasOwnProperty.call(obj.style, key)) {
                    const element = obj.style[key];
                    elem.css(key, element);
                }
            }
        }
        // elem.css("width", "100%")
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

    // reset(content = this.content) {
    //     if(!this.unfolded){
    //         return;
    //     }
    //     if(Array.isArray(content)){
    //         for (const elem of content) {
    //             if(!elem.elem || typeof elem.reset !== 'function') continue;
    //             elem?.reset(elem.elem);
    //             reset(elem);
    //         }
    //     } else if(content.elem && typeof content.reset === 'function'){
    //         content?.reset(content.elem);
    //     }
    // }

    static getFullBounds(elem){
        const elemCpy = $(elem).clone();
        elemCpy.find(".tooltiptext").remove();
        elemCpy.css("display", "block");
        elemCpy.css("opacity", "0");
        elemCpy.css("width", "");
        elemCpy.css("height", "");
        elemCpy.css("position", "absolute");
        $("body").append(elemCpy);
        const bounds = {width: elemCpy.width(), height: elemCpy.height()}
        elemCpy.remove();
        return bounds;
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
         *          callback: callback to be called on initialization to parse the column | form: callback(column, row)
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
                this.sort(initialSort.column, initialSort.up, true);
            }
        }
        $(this.elem).find(".data-table").remove();
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

    sort(column, up, noInit){
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
        if(noInit !== true){
            this.init();
        }
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
                if(this.layout[td].hasOwnProperty("allowSort")){
                    allowSort = this.layout[td].allowSort;
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
            if(column in row){
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
    
    getColumn(column){
        const elem = $(`<td></td>`);
        elem.append(ElemParser.parse(column));
        return elem;
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
     * as text
     */
    static PRIMITIVE = "primitive";
    /**
     * "www.some-url.com"
     */
    static IMAGE = "image";
    /**
     * GER
     */
    static COUNTYR_FLAG = "countryFlag";
    /**
     * "m" | "w"
     */
    static GENDER = "gender";
    /**
     * "hallo welt"
     */
    static TEXT = "text";
    /**
     * dom element
     */
    static DOM = "dom"
    /**
     * {
     *  description: "Best discipline",
     *  description1: "sprint",
     *  description2: "long",
     *  data: 0.5
     * }
     */
    static SLIDER = "slider"
    /**
     * profile
     */
    static PROFILE = "profile";
    /**
     * function(elem){return $(`<div>${elem.data}</div>`)}
     */
    static CALLBACK = "callback";
    /**
     * {
     *  direction: "row",
     *  data: [elem1, elem2]
     * }
     */
    static LIST = "list";
    /**
     * 1 | 2 | 100
     */
    static PLACE = "place";
    /**
     * {
     *  inputType: "text",
     *  label: "hallo welt"
     *  attributes: {
     *      value: "123"
     *  }
     * }
     */
    static INPUT = "input";
    /**
     * helpers
     */
    static MALE = 100;
    static FEMALE = 101;
    static DIVERSE = 102;
    

    static parser = {
        [ElemParser.PRIMITIVE]: (elem) => $(`<div>${elem.data}</div>`),
        [ElemParser.IMAGE]: (elem) => $(`<img src="${elem.data}" alt="image">`),
        [ElemParser.COUNTYR_FLAG]: (elem) => getCountryFlag(elem.data, elem.width, elem.height, elem.tooltip),
        [ElemParser.GENDER]: (elem) => {return ElemParser.parseGender(elem.data)},
        [ElemParser.TEXT]: (elem) => $(`<div>${elem.data}</div>`),
        [ElemParser.DOM]: (elem) => $(elem.data),
        [ElemParser.SLIDER]: (elem) => ElemParser.parseSlider(elem),
        [ElemParser.PROFILE]: (elem) => ElemParser.parseProfile(elem),
        [ElemParser.CALLBACK]: (elem) => ElemParser.parse(elem.data.callback(elem)),
        [ElemParser.LIST]: (elem) => ElemParser.parseList(elem),
        [ElemParser.PLACE]: (elem) => getPlaceElem(elem.data),
        [ElemParser.INPUT]: (elem) => ElemParser.parseInput(elem),
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
            // return ElemParser.finishElem(ElemParser.getFreshElem());
            return $();
        }
    }

    static parseMeta(meta){
        if(isDomElem(meta)){
            return meta;
        }
        if(ElemParser.isValidMeta(meta)){
            if(!meta.data){
                return false;
            }
            if(meta.data.length === 0 || meta.data === ""){
                return false;
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
        if(meta === undefined || meta === null){
            meta = {};
        }
        if(meta.hasOwnProperty("validate")){
            if(!meta.validate(meta.data)){
                return $();
            }
        }
        if(elem === false){
            return $();
        }
        if("onclick" in meta){
            if(meta.hasOwnProperty("link")){
                $(elem).click((e) => {
                    meta.onclick(e);
                    window.location = meta.link;
                });
            } else{
                $(elem).click((e) => {
                    if(meta.onclick(e)) {
                        e.stopPropagation();
                    }
                });
            }
        }
        if("change" in meta){
            $(elem).change(function(e) {
                if($(this).find("input[type='checkbox']").length !== 0){
                    meta.change(e, $(this).find("input").is(":checked"));
                } else {
                    meta.change(e, $(this).find("input").val());
                }
            });
        }
        if(meta.hasOwnProperty("link")){
            $(elem).click(() => {
                window.location = meta.link;
            });
        }
        const wrapper = ElemParser.getFreshElem(meta);
        if(meta.hasOwnProperty("icon")){
            wrapper.addClass("flex align-start justify-start");
            wrapper.prepend(`<i class="${meta.icon} margin right"></i>`);
        }
        if(meta.hasOwnProperty("alignment")){
            if(meta.alignment === "center"){
                wrapper.addClass("flex");
            }
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
        if("class" in meta){
            elem.addClass(meta.class);
        }
        if(meta.hasOwnProperty("description")){
            if(ElemParser.useDescriptionOn(meta)){
                elem.prepend(`<div class="margin right">${meta.description}</div>`);
                elem.addClass("flex justify-start");
            }
        }
        if("style" in meta){
            for (const style in meta.style) {
                if (Object.hasOwnProperty.call(meta.style, style)) {
                    const value = meta.style[style];
                    wrapper.css(style, value);
                }
            }
        }
        return wrapper;
    }

    static useDescriptionOn(meta){
        if(!meta.hasOwnProperty("type")){
            return true;
        } else{
            return meta.type !== ElemParser.SLIDER;
        }
    }

    /**
     * meta data is valid if it has at least the data attribute
     * 
     * @param {{}} meta meta to be checked
     */
    static isValidMeta(meta){
        if(typeof meta === 'object' && meta !== null){
            if("data" in meta){
                return meta.data !== undefined && meta.data !== null;
            }
            return false;
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
        if(!prim) return false;
        const elem = $(`<div>${prim}</div>`);
        return elem;
    }

    static getGender(gender){
        if(typeof gender === 'string'){
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
            }
        }
        return ElemParser.MALE;
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
    
    static parseSlider(meta){
        const elem = $(`<div class="slider"></div>`);
        let desc1 = "1";
        let desc2 = "2";
        let value = 0.5
        let desc = "slider";
        if(meta.hasOwnProperty("description1")){
            desc1 = meta.description1;
        }
        if(meta.hasOwnProperty("description2")){
            desc2 = meta.description2;
        }
        if(meta.hasOwnProperty("description")){
            desc = meta.description;
        }
        if(meta.hasOwnProperty("data")){
            if(!isNaN(meta.data)){
                value = Math.min(Math.max(meta.data, 0), 1);
            }
        }
        elem.append(`<div class="slider__header">${desc}</div`);
        const body = $(`<div class="slider__body"></div>`);
        body.append(`<div class="slider__description text-align right margin">${desc1}</div>`);
        const slider = $(`<div class="slider__slider"></div>`);
        const circle = $(`<div class="slider__circle"></div>`);
        circle.css("width", (value * 100) + '%');
        slider.append(circle);
        body.append(slider);
        body.append(`<div class="slider__description margin left">${desc2}</div>`);
        elem.append(body);
        return elem;
    }

    static parseProfile(meta){
        const elem = $(`<div class="elem-parser__profile"></div>`);
        meta.data.appendTo(elem);
        return elem;
    }

    static valueFrom(variable){
        if(ElemParser.isFunction(variable)){
           return variable();
        } else{
            return variable;
        }
    }

    static isFunction(functionToCheck) {
        return functionToCheck && {}.toString.call(functionToCheck) === '[object Function]';
    }

    /**
     * {
     *  type: "text",
     *  label: "hallo welt"
     *  attributes: {
     *      value: "123"
     *  }
     * }
     */
    static parseInput(meta){
        const id = getUid();
        let type = "text";
        if("inputType" in meta){
            type = meta.inputType;
        }
        let attrs = "";
        if("attributes" in meta){
            for (const attr in meta.attributes) {
                if (Object.hasOwnProperty.call(meta.attributes, attr)) {
                    const value = ElemParser.valueFrom(meta.attributes[attr]);
                    if(value !== undefined && value !== null) {
                        attrs += ` ${attr}="${value}"`;
                    }
                }
            }
        }

        const elem = $(`<div><input id="${id}" type="${type}" ${attrs}></div>`);
        
        if("label" in meta){
            elem.prepend($(`<label for="${id}">${meta.label}</label>`));
        }
        return elem;
    }

    static parseList(meta){
        let direction = "row";
        let justify = "";
        if("justify" in meta) {
            justify = meta.justify;
        }
        if("direction" in meta){
            direction = meta.direction;
        }
        const elem = $(`<div class="flex ${direction} ${justify}"></div>`);
        for (const elem1 of meta.data) {
            elem.append(ElemParser.parse(elem1));
        }
        return elem;
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
    static allProfiles = [];

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
     *  special: special elem to be displayed right in min view
     * 
     *  primary: {
     *      gender: "m"
     *  },
     * 
     *  secondary: callback,callback to be called when max mode is reached callback receives a dom element to be filled
     *  secondaryData: data to be passed to the callback
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
        this.wrapper = $(`<div class="profile__wrapper ${this.lodClass}"/>`);
        this.elem = undefined; //jquery dom object
        this.left = undefined;
        this.right = undefined;
        this.special = undefined;
        this.name = "";
        this.grayedOut = false;
        this.image = undefined;
        this.secondaryData = undefined;
        this.primary = {};
        this.secondary = {};
        this.secondaryElem = $(`<div class="profile__secondary"/>`);
        

        /**
         * initialization
         * callback needs to be set first to allow maximized profiles to load imideatly
         */
        if(data.hasOwnProperty("secondary")){
            this.secondary = data.secondary;
        } if(data.hasOwnProperty("secondaryData")){
            this.secondaryData = data.secondaryData;
        }
        this.init();
        this.updateData(data);
        this.elem.append(this.secondaryElem);
        Profile.allProfiles.push(this);
    }

    updateData(data){
        if(typeof data === 'object'){
            if("maximizePage" in data) {
                this.maximizePage = data.maximizePage;
            }
            if(data.hasOwnProperty("name")){
                this.name = data.name;
                this.elem.find(".profile__name").remove();
                this.elem.append(this.nameElem);
            }
            if(data.hasOwnProperty("left")){
                this.left = data.left;
                this.elem.find(".profile__left").remove();
                this.elem.append(this.leftElem);
            }
            if(data.hasOwnProperty("right")){
                this.right = data.right;
                this.elem.find(".profile__right").remove();
                this.elem.append(this.rightElem);
            }
            if(data.hasOwnProperty("trophy1")){
                this.trophy1 = data.trophy1;
                this.elem.find(".profile__trophy-1").remove();
                this.elem.append(this.getTrophy(0));
            }
            if(data.hasOwnProperty("trophy2")){
                this.trophy2 = data.trophy2;
                this.elem.find(".profile__trophy-2").remove();
                this.elem.append(this.getTrophy(1));
            }
            if(data.hasOwnProperty("trophy3")){
                this.trophy3 = data.trophy3;
                this.elem.find(".profile__trophy-3").remove();
                this.elem.append(this.getTrophy(2));
            }
            if(data.hasOwnProperty("special")){
                this.special = data.special;
                this.elem.find(".profile__special").remove();
                this.elem.append(this.specialElem);
            }
            if(data.hasOwnProperty("primary")){
                this.primary = data.primary;
                this.elem.find(".profile__primary").remove();
                this.elem.prepend(this.primaryElem);
            }
            if(data.hasOwnProperty("secondaryData")){
                this.secondaryData = data.secondaryData;
            }
            if(data.hasOwnProperty("secondary")) {
                this.secondary = data.secondary;
                this.secondaryElem.empty();
                if(this.lod === Profile.MAX) {
                    this.secondary(this.secondaryElem, this.secondaryData);
                }
            }
            if("rank" in data){
                this.elem.find(".profile__rank").remove();
                this.elem.append(`<div class="profile__rank">${data.rank}</div>`);
            }
            if(data.hasOwnProperty("image")){
                this.image = data.image;
                this.elem.find(".profile__image").remove();
                this.elem.append(this.profileImg);
            }
            if("update" in data){
                this.update = data.update;
            }
            if("type" in data){
                this.type = data.type;
            }
        } else if(typeof data === 'string'){
            this.name = data;
        }
    }

    init(){
        if(this.elem !== undefined){
            this.elem.empty();
        }
        this.elem = $(`<div class="profile ${this.lodClass}" id="${this.idprofile}"></div>`);
        this.wrapper.append(this.elem);
        if(this.lod < Profile.MAX){
            this.elem.append(this.minimizeElem);
            this.elem.append(this.maximizeElem);
            $(this.wrapper).on("dblclick", '.profile', {}, (e) => {this.incrementLod()});
        }
        if(this.lod === Profile.CARD){
            this.elem.find(".profile__minimize").css("display", "none");
        }
        if(this.lod === Profile.MAX){
            this.initMax();
        }
        if(this.lod === Profile.MIN){
            $(this.wrapper).on("click", '.profile', {}, () => {if(this.lod == Profile.MIN) {this.incrementLod()}});
        }
        this.checkGet();
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
        if(this.lod < Profile.MAX && !this.grayedOut){
            this.closeAllOthers();
            this.elem.removeClass(this.lodClass);
            this.lod++;
            this.elem.addClass(this.lodClass);
            if(this.lod === Profile.CARD){
                this.wrapper.removeClass("min");
                this.wrapper.addClass(this.lodClass);
            } else{
                this.wrapper.removeClass("card");
                this.wrapper.addClass(this.minLodClass);
            }
            if(this.lod === Profile.MAX){
                this.elem.find(".profile__minimize button").text("Back");
                this.initMax();
            }
            if(Profile.expanded.indexOf(this) === -1){
                Profile.expanded.push(this);//add to expanded
            }
            this.scollIntoView();
        }
    }

    decrementLod(){
        if(this.lod > this.minLod && !this.grayedOut){
            this.elem.removeClass(this.lodClass);
            this.lod--;
            this.elem.addClass(this.lodClass);
            this.wrapper.removeClass("card");
            this.wrapper.addClass(this.minLodClass);
            if(this.lod === this.minLod){
                Profile.expanded.splice(Profile.expanded.indexOf(this), 1);//remove from expanded
            }
            if(this.lod === Profile.CARD){
                this.showEverythingElse();
                this.scollIntoView();
                this.elem.find(".profile__minimize button").text("Minimize");
                this.destroyMax();
            }
            if(this.lod === Profile.MAX){
                this.initMax();
            }
        }
    }

    initMax(){
        if(this.maximizePage) {
            window.location = this.maximizePage;
        }
        this.elem.find(".profile__minimize").css("display", "");
        if(this.secondary !== undefined){
            this.elem.find(".profile__secondary").empty();
            this.secondary(this.secondaryElem, this.secondaryData);
        }
        $(`body > *:not(header, footer)`).addClass("hidden");
        $("header").after(this.elem);
    }

    destroyMax(){
        $(`body > *`).removeClass("hidden");
        this.secondaryElem.empty();
        this.wrapper.append(this.elem);
        if(this.minLod === Profile.CARD){
            this.elem.find(".profile__minimize").css("display", "none");
        }
    }

    hideEverythingElse(){
        $(`main > *:not(header, footer)`).addClass("hidden");
        this.wrapper.siblings().addClass("hidden");
        this.elem.parents().each(function() {
            $(this).children().addClass("hidden");
        });
        this.elem.parents().removeClass("hidden");
        this.elem.removeClass("hidden");
        this.elem.find("*:not(.profile__maximize)").removeClass("hidden");
        const bounds = this.elem.get(0).getBoundingClientRect();
        this.elem.css("left", -bounds.left);
    }

    showEverythingElse(){
        $(`main *`).removeClass("hidden");
        this.elem.css("left", 0);
    }

    closeAllOthers(){
        for (const profile of Profile.expanded) {
            if(profile !== this && profile.lod !== Profile.MAX){
                profile.close();
            }
        }
    }

    close(){
        while(this.lod > this.minLod){
            this.decrementLod();
        }
    }

    appendTo(parent){
        $(parent).append(this.wrapper);
    }

    insertBefore(before){
        this.wrapper.insertBefore($(before));
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

    set colorScheme(id){
        switch(id){
            case 0: this.elem.removeClass("alternative-color"); return;
            case 1: this.elem.addClass("alternative-color"); return;
        }
    }

    get specialElem(){
        return $(`<div class="profile__special">${this.special}</div>`);
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

    set grayOut(gray) {
        this.grayedOut = gray;
        if(gray){
            this.elem.addClass("gray")
        } else{
            this.elem.removeClass("gray");
        }
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
            if(typeof this.image === "string"){
                return $(`<div class="profile__image"><img src="${this.image}" alt="profile image"></div>`);
            } else{
                const elem = $(`<div class="profile__image"></div>`);
                elem.append(ElemParser.parse(this.image));
                return elem;
            }
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
        return ElemParser.MALE;
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

    get minimizeElem(){
        const elem = $(`<div class="profile__minimize"/>`);
        const button = $(`<button class="btn border-only">Minimize</button>`);
        button.click((e) => {e.stopPropagation(); this.decrementLod()});
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

    get minLodClass(){
        switch(this.minLod){
            case Profile.MIN: return "min";
            case Profile.CARD: return "card";
            case Profile.MAX: return "max";
            default: return "";
        }
    }

    static grayOutAll(gray = true){
        for (const profile of Profile.allProfiles) {
            profile.grayOut = gray;
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
    // elem.click(() => {window.location = "/hall-of-fame"});
    new Tooltip(elem, color);
    return elem;
}

function getPlaceElem(place){
    const elem = $(`<div class=""/>`);
    if(place < 4){
        switch(place){
            case 1: elem.append(getMedal("gold", "#1")); break;
            case 2: elem.append(getMedal("silver", "#2")); break;
            case 3: elem.append(getMedal("bronze", "#3")); break;
        }
    } else{
        elem.append($(`<div>#${place}</div>`));
    }
    return elem;
}

/**
 * Utils
 */
function isMobile() {
    let check = false;
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
    return check;
};

let uidCounter = 0;
function getUid(){
    uidCounter++;
    return "a" + (uidCounter - 1);
}

function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
  }

function sortArray(array, field, asc = true){
    const mul = asc ? -1 : 1;
    array.sort((a, b) => {
        if(a[field] === undefined || b[field] === undefined){
            return 0;
        }
        if(b[field] === null && b[field] === null){
            return 0;
        }
        if(b[field] === null){
            return mul;
        }
        if(a[field] === null){
            return -mul;
        }
        if(a[field] < b[field]){
            return -mul;
        } else if(a[field] > b[field]){
            return mul;
        } else{
            return 0
        }
    });
    return array;
}

function profileSlideShowIn(elem, profiles){
    const slideshow = new Slideshow(elem);
    for (const profile of profiles) {
        profile.appendTo(elem);
    }
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

function numberAnimate(setup){
    const targets = setup.targets ?? "";//needed
    const from = setup.from ?? 0;
    const to = setup.to ?? 100
    const duration = setup.duration ?? 1000;
    const easing = setup.easing ?? 'easeOutExpo';
    const delay = setup.delay ?? 0;
    const round = setup.round ?? true;
    let wrapper = {data: 0};
    anime({
        targets: wrapper,
        data: [from, to],
        easing,
        delay,
        round,
        duration,
        update: function(anim) {
            $(targets).text(wrapper.data);
        }
    });
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

function countryCodeValid(name){
    name = name.toLowerCase();
    for (const country of countries) {
        if(country.code.toLowerCase() === name){
            return true;
        }
    }
    return false;
}

function getCountryFlag(country, width = "2rem", height = "1.5rem", tooltip = false){
    let style = `style="width: ${width}; height: ${height}"`;
    // if(res !== 32 && res !== 64){
    //     style = `width="${res}" height="${res}"`;
    //     res = 64;
    // }
    if(country === undefined){
        return $(`<div>-</div`);
    }
    const countryCode = countryNameToCode(country);
    if(countryCode !== undefined){
        const elem = $(`<div class="country-flag"><img src="/img/countries/${countryCode.toLowerCase()}.svg" alt="${country} flag" ${style}"></div>`);
        if(tooltip){
            new Tooltip(elem, country);
        }
        return elem;
        // return $(`<div class="country-flag"><img src="https://www.countryflags.io/${countryCode}/flat/${res}.png" alt="${country} flag" ${style}"></div>`);
    } else {
        if(countryCodeValid(country)){
            return $(`<div class="country-flag"><img src="/img/countries/${countryCode.toLowerCase()}.svg" alt="${country} flag" ${style}"></div>`);
            // return $(`<div class="country-flag"><img src="https://www.countryflags.io/${country}/flat/${res}.png" alt="${country} flag" ${style}"></div>`);
        } else{
            return $(`<div>${country}</div>`);
        }
    }
}

const countries1 = [{"name":"Afghanistan","alpha-2":"AF","alpha-3":"AFG","country-code":"004","iso_3166-2":"ISO 3166-2:AF","region":"Asia","sub-region":"Southern Asia","intermediate-region":"","region-code":"142","sub-region-code":"034","intermediate-region-code":""},{"name":"Åland Islands","alpha-2":"AX","alpha-3":"ALA","country-code":"248","iso_3166-2":"ISO 3166-2:AX","region":"Europe","sub-region":"Northern Europe","intermediate-region":"","region-code":"150","sub-region-code":"154","intermediate-region-code":""},{"name":"Albania","alpha-2":"AL","alpha-3":"ALB","country-code":"008","iso_3166-2":"ISO 3166-2:AL","region":"Europe","sub-region":"Southern Europe","intermediate-region":"","region-code":"150","sub-region-code":"039","intermediate-region-code":""},{"name":"Algeria","alpha-2":"DZ","alpha-3":"DZA","country-code":"012","iso_3166-2":"ISO 3166-2:DZ","region":"Africa","sub-region":"Northern Africa","intermediate-region":"","region-code":"002","sub-region-code":"015","intermediate-region-code":""},{"name":"American Samoa","alpha-2":"AS","alpha-3":"ASM","country-code":"016","iso_3166-2":"ISO 3166-2:AS","region":"Oceania","sub-region":"Polynesia","intermediate-region":"","region-code":"009","sub-region-code":"061","intermediate-region-code":""},{"name":"Andorra","alpha-2":"AD","alpha-3":"AND","country-code":"020","iso_3166-2":"ISO 3166-2:AD","region":"Europe","sub-region":"Southern Europe","intermediate-region":"","region-code":"150","sub-region-code":"039","intermediate-region-code":""},{"name":"Angola","alpha-2":"AO","alpha-3":"AGO","country-code":"024","iso_3166-2":"ISO 3166-2:AO","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Middle Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"017"},{"name":"Anguilla","alpha-2":"AI","alpha-3":"AIA","country-code":"660","iso_3166-2":"ISO 3166-2:AI","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Antarctica","alpha-2":"AQ","alpha-3":"ATA","country-code":"010","iso_3166-2":"ISO 3166-2:AQ","region":"","sub-region":"","intermediate-region":"","region-code":"","sub-region-code":"","intermediate-region-code":""},{"name":"Antigua and Barbuda","alpha-2":"AG","alpha-3":"ATG","country-code":"028","iso_3166-2":"ISO 3166-2:AG","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Argentina","alpha-2":"AR","alpha-3":"ARG","country-code":"032","iso_3166-2":"ISO 3166-2:AR","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"South America","region-code":"019","sub-region-code":"419","intermediate-region-code":"005"},{"name":"Armenia","alpha-2":"AM","alpha-3":"ARM","country-code":"051","iso_3166-2":"ISO 3166-2:AM","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"Aruba","alpha-2":"AW","alpha-3":"ABW","country-code":"533","iso_3166-2":"ISO 3166-2:AW","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Australia","alpha-2":"AU","alpha-3":"AUS","country-code":"036","iso_3166-2":"ISO 3166-2:AU","region":"Oceania","sub-region":"Australia and New Zealand","intermediate-region":"","region-code":"009","sub-region-code":"053","intermediate-region-code":""},{"name":"Austria","alpha-2":"AT","alpha-3":"AUT","country-code":"040","iso_3166-2":"ISO 3166-2:AT","region":"Europe","sub-region":"Western Europe","intermediate-region":"","region-code":"150","sub-region-code":"155","intermediate-region-code":""},{"name":"Azerbaijan","alpha-2":"AZ","alpha-3":"AZE","country-code":"031","iso_3166-2":"ISO 3166-2:AZ","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"Bahamas","alpha-2":"BS","alpha-3":"BHS","country-code":"044","iso_3166-2":"ISO 3166-2:BS","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Bahrain","alpha-2":"BH","alpha-3":"BHR","country-code":"048","iso_3166-2":"ISO 3166-2:BH","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"Bangladesh","alpha-2":"BD","alpha-3":"BGD","country-code":"050","iso_3166-2":"ISO 3166-2:BD","region":"Asia","sub-region":"Southern Asia","intermediate-region":"","region-code":"142","sub-region-code":"034","intermediate-region-code":""},{"name":"Barbados","alpha-2":"BB","alpha-3":"BRB","country-code":"052","iso_3166-2":"ISO 3166-2:BB","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Belarus","alpha-2":"BY","alpha-3":"BLR","country-code":"112","iso_3166-2":"ISO 3166-2:BY","region":"Europe","sub-region":"Eastern Europe","intermediate-region":"","region-code":"150","sub-region-code":"151","intermediate-region-code":""},{"name":"Belgium","alpha-2":"BE","alpha-3":"BEL","country-code":"056","iso_3166-2":"ISO 3166-2:BE","region":"Europe","sub-region":"Western Europe","intermediate-region":"","region-code":"150","sub-region-code":"155","intermediate-region-code":""},{"name":"Belize","alpha-2":"BZ","alpha-3":"BLZ","country-code":"084","iso_3166-2":"ISO 3166-2:BZ","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Central America","region-code":"019","sub-region-code":"419","intermediate-region-code":"013"},{"name":"Benin","alpha-2":"BJ","alpha-3":"BEN","country-code":"204","iso_3166-2":"ISO 3166-2:BJ","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Western Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"011"},{"name":"Bermuda","alpha-2":"BM","alpha-3":"BMU","country-code":"060","iso_3166-2":"ISO 3166-2:BM","region":"Americas","sub-region":"Northern America","intermediate-region":"","region-code":"019","sub-region-code":"021","intermediate-region-code":""},{"name":"Bhutan","alpha-2":"BT","alpha-3":"BTN","country-code":"064","iso_3166-2":"ISO 3166-2:BT","region":"Asia","sub-region":"Southern Asia","intermediate-region":"","region-code":"142","sub-region-code":"034","intermediate-region-code":""},{"name":"Bolivia (Plurinational State of)","alpha-2":"BO","alpha-3":"BOL","country-code":"068","iso_3166-2":"ISO 3166-2:BO","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"South America","region-code":"019","sub-region-code":"419","intermediate-region-code":"005"},{"name":"Bonaire, Sint Eustatius and Saba","alpha-2":"BQ","alpha-3":"BES","country-code":"535","iso_3166-2":"ISO 3166-2:BQ","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Bosnia and Herzegovina","alpha-2":"BA","alpha-3":"BIH","country-code":"070","iso_3166-2":"ISO 3166-2:BA","region":"Europe","sub-region":"Southern Europe","intermediate-region":"","region-code":"150","sub-region-code":"039","intermediate-region-code":""},{"name":"Botswana","alpha-2":"BW","alpha-3":"BWA","country-code":"072","iso_3166-2":"ISO 3166-2:BW","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Southern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"018"},{"name":"Bouvet Island","alpha-2":"BV","alpha-3":"BVT","country-code":"074","iso_3166-2":"ISO 3166-2:BV","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"South America","region-code":"019","sub-region-code":"419","intermediate-region-code":"005"},{"name":"Brazil","alpha-2":"BR","alpha-3":"BRA","country-code":"076","iso_3166-2":"ISO 3166-2:BR","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"South America","region-code":"019","sub-region-code":"419","intermediate-region-code":"005"},{"name":"British Indian Ocean Territory","alpha-2":"IO","alpha-3":"IOT","country-code":"086","iso_3166-2":"ISO 3166-2:IO","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Brunei Darussalam","alpha-2":"BN","alpha-3":"BRN","country-code":"096","iso_3166-2":"ISO 3166-2:BN","region":"Asia","sub-region":"South-eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"035","intermediate-region-code":""},{"name":"Bulgaria","alpha-2":"BG","alpha-3":"BGR","country-code":"100","iso_3166-2":"ISO 3166-2:BG","region":"Europe","sub-region":"Eastern Europe","intermediate-region":"","region-code":"150","sub-region-code":"151","intermediate-region-code":""},{"name":"Burkina Faso","alpha-2":"BF","alpha-3":"BFA","country-code":"854","iso_3166-2":"ISO 3166-2:BF","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Western Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"011"},{"name":"Burundi","alpha-2":"BI","alpha-3":"BDI","country-code":"108","iso_3166-2":"ISO 3166-2:BI","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Cabo Verde","alpha-2":"CV","alpha-3":"CPV","country-code":"132","iso_3166-2":"ISO 3166-2:CV","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Western Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"011"},{"name":"Cambodia","alpha-2":"KH","alpha-3":"KHM","country-code":"116","iso_3166-2":"ISO 3166-2:KH","region":"Asia","sub-region":"South-eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"035","intermediate-region-code":""},{"name":"Cameroon","alpha-2":"CM","alpha-3":"CMR","country-code":"120","iso_3166-2":"ISO 3166-2:CM","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Middle Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"017"},{"name":"Canada","alpha-2":"CA","alpha-3":"CAN","country-code":"124","iso_3166-2":"ISO 3166-2:CA","region":"Americas","sub-region":"Northern America","intermediate-region":"","region-code":"019","sub-region-code":"021","intermediate-region-code":""},{"name":"Cayman Islands","alpha-2":"KY","alpha-3":"CYM","country-code":"136","iso_3166-2":"ISO 3166-2:KY","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Central African Republic","alpha-2":"CF","alpha-3":"CAF","country-code":"140","iso_3166-2":"ISO 3166-2:CF","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Middle Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"017"},{"name":"Chad","alpha-2":"TD","alpha-3":"TCD","country-code":"148","iso_3166-2":"ISO 3166-2:TD","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Middle Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"017"},{"name":"Chile","alpha-2":"CL","alpha-3":"CHL","country-code":"152","iso_3166-2":"ISO 3166-2:CL","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"South America","region-code":"019","sub-region-code":"419","intermediate-region-code":"005"},{"name":"China","alpha-2":"CN","alpha-3":"CHN","country-code":"156","iso_3166-2":"ISO 3166-2:CN","region":"Asia","sub-region":"Eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"030","intermediate-region-code":""},{"name":"Christmas Island","alpha-2":"CX","alpha-3":"CXR","country-code":"162","iso_3166-2":"ISO 3166-2:CX","region":"Oceania","sub-region":"Australia and New Zealand","intermediate-region":"","region-code":"009","sub-region-code":"053","intermediate-region-code":""},{"name":"Cocos (Keeling) Islands","alpha-2":"CC","alpha-3":"CCK","country-code":"166","iso_3166-2":"ISO 3166-2:CC","region":"Oceania","sub-region":"Australia and New Zealand","intermediate-region":"","region-code":"009","sub-region-code":"053","intermediate-region-code":""},{"name":"Colombia","alpha-2":"CO","alpha-3":"COL","country-code":"170","iso_3166-2":"ISO 3166-2:CO","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"South America","region-code":"019","sub-region-code":"419","intermediate-region-code":"005"},{"name":"Comoros","alpha-2":"KM","alpha-3":"COM","country-code":"174","iso_3166-2":"ISO 3166-2:KM","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Congo","alpha-2":"CG","alpha-3":"COG","country-code":"178","iso_3166-2":"ISO 3166-2:CG","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Middle Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"017"},{"name":"Congo, Democratic Republic of the","alpha-2":"CD","alpha-3":"COD","country-code":"180","iso_3166-2":"ISO 3166-2:CD","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Middle Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"017"},{"name":"Cook Islands","alpha-2":"CK","alpha-3":"COK","country-code":"184","iso_3166-2":"ISO 3166-2:CK","region":"Oceania","sub-region":"Polynesia","intermediate-region":"","region-code":"009","sub-region-code":"061","intermediate-region-code":""},{"name":"Costa Rica","alpha-2":"CR","alpha-3":"CRI","country-code":"188","iso_3166-2":"ISO 3166-2:CR","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Central America","region-code":"019","sub-region-code":"419","intermediate-region-code":"013"},{"name":"Côte d'Ivoire","alpha-2":"CI","alpha-3":"CIV","country-code":"384","iso_3166-2":"ISO 3166-2:CI","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Western Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"011"},{"name":"Croatia","alpha-2":"HR","alpha-3":"HRV","country-code":"191","iso_3166-2":"ISO 3166-2:HR","region":"Europe","sub-region":"Southern Europe","intermediate-region":"","region-code":"150","sub-region-code":"039","intermediate-region-code":""},{"name":"Cuba","alpha-2":"CU","alpha-3":"CUB","country-code":"192","iso_3166-2":"ISO 3166-2:CU","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Curaçao","alpha-2":"CW","alpha-3":"CUW","country-code":"531","iso_3166-2":"ISO 3166-2:CW","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Cyprus","alpha-2":"CY","alpha-3":"CYP","country-code":"196","iso_3166-2":"ISO 3166-2:CY","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"Czechia","alpha-2":"CZ","alpha-3":"CZE","country-code":"203","iso_3166-2":"ISO 3166-2:CZ","region":"Europe","sub-region":"Eastern Europe","intermediate-region":"","region-code":"150","sub-region-code":"151","intermediate-region-code":""},{"name":"Denmark","alpha-2":"DK","alpha-3":"DNK","country-code":"208","iso_3166-2":"ISO 3166-2:DK","region":"Europe","sub-region":"Northern Europe","intermediate-region":"","region-code":"150","sub-region-code":"154","intermediate-region-code":""},{"name":"Djibouti","alpha-2":"DJ","alpha-3":"DJI","country-code":"262","iso_3166-2":"ISO 3166-2:DJ","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Dominica","alpha-2":"DM","alpha-3":"DMA","country-code":"212","iso_3166-2":"ISO 3166-2:DM","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Dominican Republic","alpha-2":"DO","alpha-3":"DOM","country-code":"214","iso_3166-2":"ISO 3166-2:DO","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Ecuador","alpha-2":"EC","alpha-3":"ECU","country-code":"218","iso_3166-2":"ISO 3166-2:EC","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"South America","region-code":"019","sub-region-code":"419","intermediate-region-code":"005"},{"name":"Egypt","alpha-2":"EG","alpha-3":"EGY","country-code":"818","iso_3166-2":"ISO 3166-2:EG","region":"Africa","sub-region":"Northern Africa","intermediate-region":"","region-code":"002","sub-region-code":"015","intermediate-region-code":""},{"name":"El Salvador","alpha-2":"SV","alpha-3":"SLV","country-code":"222","iso_3166-2":"ISO 3166-2:SV","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Central America","region-code":"019","sub-region-code":"419","intermediate-region-code":"013"},{"name":"Equatorial Guinea","alpha-2":"GQ","alpha-3":"GNQ","country-code":"226","iso_3166-2":"ISO 3166-2:GQ","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Middle Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"017"},{"name":"Eritrea","alpha-2":"ER","alpha-3":"ERI","country-code":"232","iso_3166-2":"ISO 3166-2:ER","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Estonia","alpha-2":"EE","alpha-3":"EST","country-code":"233","iso_3166-2":"ISO 3166-2:EE","region":"Europe","sub-region":"Northern Europe","intermediate-region":"","region-code":"150","sub-region-code":"154","intermediate-region-code":""},{"name":"Eswatini","alpha-2":"SZ","alpha-3":"SWZ","country-code":"748","iso_3166-2":"ISO 3166-2:SZ","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Southern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"018"},{"name":"Ethiopia","alpha-2":"ET","alpha-3":"ETH","country-code":"231","iso_3166-2":"ISO 3166-2:ET","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Falkland Islands (Malvinas)","alpha-2":"FK","alpha-3":"FLK","country-code":"238","iso_3166-2":"ISO 3166-2:FK","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"South America","region-code":"019","sub-region-code":"419","intermediate-region-code":"005"},{"name":"Faroe Islands","alpha-2":"FO","alpha-3":"FRO","country-code":"234","iso_3166-2":"ISO 3166-2:FO","region":"Europe","sub-region":"Northern Europe","intermediate-region":"","region-code":"150","sub-region-code":"154","intermediate-region-code":""},{"name":"Fiji","alpha-2":"FJ","alpha-3":"FJI","country-code":"242","iso_3166-2":"ISO 3166-2:FJ","region":"Oceania","sub-region":"Melanesia","intermediate-region":"","region-code":"009","sub-region-code":"054","intermediate-region-code":""},{"name":"Finland","alpha-2":"FI","alpha-3":"FIN","country-code":"246","iso_3166-2":"ISO 3166-2:FI","region":"Europe","sub-region":"Northern Europe","intermediate-region":"","region-code":"150","sub-region-code":"154","intermediate-region-code":""},{"name":"France","alpha-2":"FR","alpha-3":"FRA","country-code":"250","iso_3166-2":"ISO 3166-2:FR","region":"Europe","sub-region":"Western Europe","intermediate-region":"","region-code":"150","sub-region-code":"155","intermediate-region-code":""},{"name":"French Guiana","alpha-2":"GF","alpha-3":"GUF","country-code":"254","iso_3166-2":"ISO 3166-2:GF","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"South America","region-code":"019","sub-region-code":"419","intermediate-region-code":"005"},{"name":"French Polynesia","alpha-2":"PF","alpha-3":"PYF","country-code":"258","iso_3166-2":"ISO 3166-2:PF","region":"Oceania","sub-region":"Polynesia","intermediate-region":"","region-code":"009","sub-region-code":"061","intermediate-region-code":""},{"name":"French Southern Territories","alpha-2":"TF","alpha-3":"ATF","country-code":"260","iso_3166-2":"ISO 3166-2:TF","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Gabon","alpha-2":"GA","alpha-3":"GAB","country-code":"266","iso_3166-2":"ISO 3166-2:GA","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Middle Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"017"},{"name":"Gambia","alpha-2":"GM","alpha-3":"GMB","country-code":"270","iso_3166-2":"ISO 3166-2:GM","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Western Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"011"},{"name":"Georgia","alpha-2":"GE","alpha-3":"GEO","country-code":"268","iso_3166-2":"ISO 3166-2:GE","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"Germany","alpha-2":"GER","alpha-3":"DEU","country-code":"276","iso_3166-2":"ISO 3166-2:DE","region":"Europe","sub-region":"Western Europe","intermediate-region":"","region-code":"150","sub-region-code":"155","intermediate-region-code":""},{"name":"Ghana","alpha-2":"GH","alpha-3":"GHA","country-code":"288","iso_3166-2":"ISO 3166-2:GH","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Western Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"011"},{"name":"Gibraltar","alpha-2":"GI","alpha-3":"GIB","country-code":"292","iso_3166-2":"ISO 3166-2:GI","region":"Europe","sub-region":"Southern Europe","intermediate-region":"","region-code":"150","sub-region-code":"039","intermediate-region-code":""},{"name":"Greece","alpha-2":"GR","alpha-3":"GRC","country-code":"300","iso_3166-2":"ISO 3166-2:GR","region":"Europe","sub-region":"Southern Europe","intermediate-region":"","region-code":"150","sub-region-code":"039","intermediate-region-code":""},{"name":"Greenland","alpha-2":"GL","alpha-3":"GRL","country-code":"304","iso_3166-2":"ISO 3166-2:GL","region":"Americas","sub-region":"Northern America","intermediate-region":"","region-code":"019","sub-region-code":"021","intermediate-region-code":""},{"name":"Grenada","alpha-2":"GD","alpha-3":"GRD","country-code":"308","iso_3166-2":"ISO 3166-2:GD","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Guadeloupe","alpha-2":"GP","alpha-3":"GLP","country-code":"312","iso_3166-2":"ISO 3166-2:GP","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Guam","alpha-2":"GU","alpha-3":"GUM","country-code":"316","iso_3166-2":"ISO 3166-2:GU","region":"Oceania","sub-region":"Micronesia","intermediate-region":"","region-code":"009","sub-region-code":"057","intermediate-region-code":""},{"name":"Guatemala","alpha-2":"GT","alpha-3":"GTM","country-code":"320","iso_3166-2":"ISO 3166-2:GT","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Central America","region-code":"019","sub-region-code":"419","intermediate-region-code":"013"},{"name":"Guernsey","alpha-2":"GG","alpha-3":"GGY","country-code":"831","iso_3166-2":"ISO 3166-2:GG","region":"Europe","sub-region":"Northern Europe","intermediate-region":"Channel Islands","region-code":"150","sub-region-code":"154","intermediate-region-code":"830"},{"name":"Guinea","alpha-2":"GN","alpha-3":"GIN","country-code":"324","iso_3166-2":"ISO 3166-2:GN","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Western Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"011"},{"name":"Guinea-Bissau","alpha-2":"GW","alpha-3":"GNB","country-code":"624","iso_3166-2":"ISO 3166-2:GW","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Western Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"011"},{"name":"Guyana","alpha-2":"GY","alpha-3":"GUY","country-code":"328","iso_3166-2":"ISO 3166-2:GY","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"South America","region-code":"019","sub-region-code":"419","intermediate-region-code":"005"},{"name":"Haiti","alpha-2":"HT","alpha-3":"HTI","country-code":"332","iso_3166-2":"ISO 3166-2:HT","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Heard Island and McDonald Islands","alpha-2":"HM","alpha-3":"HMD","country-code":"334","iso_3166-2":"ISO 3166-2:HM","region":"Oceania","sub-region":"Australia and New Zealand","intermediate-region":"","region-code":"009","sub-region-code":"053","intermediate-region-code":""},{"name":"Holy See","alpha-2":"VA","alpha-3":"VAT","country-code":"336","iso_3166-2":"ISO 3166-2:VA","region":"Europe","sub-region":"Southern Europe","intermediate-region":"","region-code":"150","sub-region-code":"039","intermediate-region-code":""},{"name":"Honduras","alpha-2":"HN","alpha-3":"HND","country-code":"340","iso_3166-2":"ISO 3166-2:HN","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Central America","region-code":"019","sub-region-code":"419","intermediate-region-code":"013"},{"name":"Hong Kong","alpha-2":"HK","alpha-3":"HKG","country-code":"344","iso_3166-2":"ISO 3166-2:HK","region":"Asia","sub-region":"Eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"030","intermediate-region-code":""},{"name":"Hungary","alpha-2":"HU","alpha-3":"HUN","country-code":"348","iso_3166-2":"ISO 3166-2:HU","region":"Europe","sub-region":"Eastern Europe","intermediate-region":"","region-code":"150","sub-region-code":"151","intermediate-region-code":""},{"name":"Iceland","alpha-2":"IS","alpha-3":"ISL","country-code":"352","iso_3166-2":"ISO 3166-2:IS","region":"Europe","sub-region":"Northern Europe","intermediate-region":"","region-code":"150","sub-region-code":"154","intermediate-region-code":""},{"name":"India","alpha-2":"IN","alpha-3":"IND","country-code":"356","iso_3166-2":"ISO 3166-2:IN","region":"Asia","sub-region":"Southern Asia","intermediate-region":"","region-code":"142","sub-region-code":"034","intermediate-region-code":""},{"name":"Indonesia","alpha-2":"ID","alpha-3":"IDN","country-code":"360","iso_3166-2":"ISO 3166-2:ID","region":"Asia","sub-region":"South-eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"035","intermediate-region-code":""},{"name":"Iran (Islamic Republic of)","alpha-2":"IR","alpha-3":"IRN","country-code":"364","iso_3166-2":"ISO 3166-2:IR","region":"Asia","sub-region":"Southern Asia","intermediate-region":"","region-code":"142","sub-region-code":"034","intermediate-region-code":""},{"name":"Iraq","alpha-2":"IQ","alpha-3":"IRQ","country-code":"368","iso_3166-2":"ISO 3166-2:IQ","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"Ireland","alpha-2":"IE","alpha-3":"IRL","country-code":"372","iso_3166-2":"ISO 3166-2:IE","region":"Europe","sub-region":"Northern Europe","intermediate-region":"","region-code":"150","sub-region-code":"154","intermediate-region-code":""},{"name":"Isle of Man","alpha-2":"IM","alpha-3":"IMN","country-code":"833","iso_3166-2":"ISO 3166-2:IM","region":"Europe","sub-region":"Northern Europe","intermediate-region":"","region-code":"150","sub-region-code":"154","intermediate-region-code":""},{"name":"Israel","alpha-2":"IL","alpha-3":"ISR","country-code":"376","iso_3166-2":"ISO 3166-2:IL","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"Italy","alpha-2":"IT","alpha-3":"ITA","country-code":"380","iso_3166-2":"ISO 3166-2:IT","region":"Europe","sub-region":"Southern Europe","intermediate-region":"","region-code":"150","sub-region-code":"039","intermediate-region-code":""},{"name":"Jamaica","alpha-2":"JM","alpha-3":"JAM","country-code":"388","iso_3166-2":"ISO 3166-2:JM","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Japan","alpha-2":"JP","alpha-3":"JPN","country-code":"392","iso_3166-2":"ISO 3166-2:JP","region":"Asia","sub-region":"Eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"030","intermediate-region-code":""},{"name":"Jersey","alpha-2":"JE","alpha-3":"JEY","country-code":"832","iso_3166-2":"ISO 3166-2:JE","region":"Europe","sub-region":"Northern Europe","intermediate-region":"Channel Islands","region-code":"150","sub-region-code":"154","intermediate-region-code":"830"},{"name":"Jordan","alpha-2":"JO","alpha-3":"JOR","country-code":"400","iso_3166-2":"ISO 3166-2:JO","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"Kazakhstan","alpha-2":"KZ","alpha-3":"KAZ","country-code":"398","iso_3166-2":"ISO 3166-2:KZ","region":"Asia","sub-region":"Central Asia","intermediate-region":"","region-code":"142","sub-region-code":"143","intermediate-region-code":""},{"name":"Kenya","alpha-2":"KE","alpha-3":"KEN","country-code":"404","iso_3166-2":"ISO 3166-2:KE","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Kiribati","alpha-2":"KI","alpha-3":"KIR","country-code":"296","iso_3166-2":"ISO 3166-2:KI","region":"Oceania","sub-region":"Micronesia","intermediate-region":"","region-code":"009","sub-region-code":"057","intermediate-region-code":""},{"name":"Korea (Democratic People's Republic of)","alpha-2":"KP","alpha-3":"PRK","country-code":"408","iso_3166-2":"ISO 3166-2:KP","region":"Asia","sub-region":"Eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"030","intermediate-region-code":""},{"name":"Korea, Republic of","alpha-2":"KR","alpha-3":"KOR","country-code":"410","iso_3166-2":"ISO 3166-2:KR","region":"Asia","sub-region":"Eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"030","intermediate-region-code":""},{"name":"Kuwait","alpha-2":"KW","alpha-3":"KWT","country-code":"414","iso_3166-2":"ISO 3166-2:KW","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"Kyrgyzstan","alpha-2":"KG","alpha-3":"KGZ","country-code":"417","iso_3166-2":"ISO 3166-2:KG","region":"Asia","sub-region":"Central Asia","intermediate-region":"","region-code":"142","sub-region-code":"143","intermediate-region-code":""},{"name":"Lao People's Democratic Republic","alpha-2":"LA","alpha-3":"LAO","country-code":"418","iso_3166-2":"ISO 3166-2:LA","region":"Asia","sub-region":"South-eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"035","intermediate-region-code":""},{"name":"Latvia","alpha-2":"LV","alpha-3":"LVA","country-code":"428","iso_3166-2":"ISO 3166-2:LV","region":"Europe","sub-region":"Northern Europe","intermediate-region":"","region-code":"150","sub-region-code":"154","intermediate-region-code":""},{"name":"Lebanon","alpha-2":"LB","alpha-3":"LBN","country-code":"422","iso_3166-2":"ISO 3166-2:LB","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"Lesotho","alpha-2":"LS","alpha-3":"LSO","country-code":"426","iso_3166-2":"ISO 3166-2:LS","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Southern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"018"},{"name":"Liberia","alpha-2":"LR","alpha-3":"LBR","country-code":"430","iso_3166-2":"ISO 3166-2:LR","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Western Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"011"},{"name":"Libya","alpha-2":"LY","alpha-3":"LBY","country-code":"434","iso_3166-2":"ISO 3166-2:LY","region":"Africa","sub-region":"Northern Africa","intermediate-region":"","region-code":"002","sub-region-code":"015","intermediate-region-code":""},{"name":"Liechtenstein","alpha-2":"LI","alpha-3":"LIE","country-code":"438","iso_3166-2":"ISO 3166-2:LI","region":"Europe","sub-region":"Western Europe","intermediate-region":"","region-code":"150","sub-region-code":"155","intermediate-region-code":""},{"name":"Lithuania","alpha-2":"LT","alpha-3":"LTU","country-code":"440","iso_3166-2":"ISO 3166-2:LT","region":"Europe","sub-region":"Northern Europe","intermediate-region":"","region-code":"150","sub-region-code":"154","intermediate-region-code":""},{"name":"Luxembourg","alpha-2":"LU","alpha-3":"LUX","country-code":"442","iso_3166-2":"ISO 3166-2:LU","region":"Europe","sub-region":"Western Europe","intermediate-region":"","region-code":"150","sub-region-code":"155","intermediate-region-code":""},{"name":"Macao","alpha-2":"MO","alpha-3":"MAC","country-code":"446","iso_3166-2":"ISO 3166-2:MO","region":"Asia","sub-region":"Eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"030","intermediate-region-code":""},{"name":"Madagascar","alpha-2":"MG","alpha-3":"MDG","country-code":"450","iso_3166-2":"ISO 3166-2:MG","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Malawi","alpha-2":"MW","alpha-3":"MWI","country-code":"454","iso_3166-2":"ISO 3166-2:MW","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Malaysia","alpha-2":"MY","alpha-3":"MYS","country-code":"458","iso_3166-2":"ISO 3166-2:MY","region":"Asia","sub-region":"South-eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"035","intermediate-region-code":""},{"name":"Maldives","alpha-2":"MV","alpha-3":"MDV","country-code":"462","iso_3166-2":"ISO 3166-2:MV","region":"Asia","sub-region":"Southern Asia","intermediate-region":"","region-code":"142","sub-region-code":"034","intermediate-region-code":""},{"name":"Mali","alpha-2":"ML","alpha-3":"MLI","country-code":"466","iso_3166-2":"ISO 3166-2:ML","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Western Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"011"},{"name":"Malta","alpha-2":"MT","alpha-3":"MLT","country-code":"470","iso_3166-2":"ISO 3166-2:MT","region":"Europe","sub-region":"Southern Europe","intermediate-region":"","region-code":"150","sub-region-code":"039","intermediate-region-code":""},{"name":"Marshall Islands","alpha-2":"MH","alpha-3":"MHL","country-code":"584","iso_3166-2":"ISO 3166-2:MH","region":"Oceania","sub-region":"Micronesia","intermediate-region":"","region-code":"009","sub-region-code":"057","intermediate-region-code":""},{"name":"Martinique","alpha-2":"MQ","alpha-3":"MTQ","country-code":"474","iso_3166-2":"ISO 3166-2:MQ","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Mauritania","alpha-2":"MR","alpha-3":"MRT","country-code":"478","iso_3166-2":"ISO 3166-2:MR","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Western Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"011"},{"name":"Mauritius","alpha-2":"MU","alpha-3":"MUS","country-code":"480","iso_3166-2":"ISO 3166-2:MU","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Mayotte","alpha-2":"YT","alpha-3":"MYT","country-code":"175","iso_3166-2":"ISO 3166-2:YT","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Mexico","alpha-2":"MX","alpha-3":"MEX","country-code":"484","iso_3166-2":"ISO 3166-2:MX","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Central America","region-code":"019","sub-region-code":"419","intermediate-region-code":"013"},{"name":"Micronesia (Federated States of)","alpha-2":"FM","alpha-3":"FSM","country-code":"583","iso_3166-2":"ISO 3166-2:FM","region":"Oceania","sub-region":"Micronesia","intermediate-region":"","region-code":"009","sub-region-code":"057","intermediate-region-code":""},{"name":"Moldova, Republic of","alpha-2":"MD","alpha-3":"MDA","country-code":"498","iso_3166-2":"ISO 3166-2:MD","region":"Europe","sub-region":"Eastern Europe","intermediate-region":"","region-code":"150","sub-region-code":"151","intermediate-region-code":""},{"name":"Monaco","alpha-2":"MC","alpha-3":"MCO","country-code":"492","iso_3166-2":"ISO 3166-2:MC","region":"Europe","sub-region":"Western Europe","intermediate-region":"","region-code":"150","sub-region-code":"155","intermediate-region-code":""},{"name":"Mongolia","alpha-2":"MN","alpha-3":"MNG","country-code":"496","iso_3166-2":"ISO 3166-2:MN","region":"Asia","sub-region":"Eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"030","intermediate-region-code":""},{"name":"Montenegro","alpha-2":"ME","alpha-3":"MNE","country-code":"499","iso_3166-2":"ISO 3166-2:ME","region":"Europe","sub-region":"Southern Europe","intermediate-region":"","region-code":"150","sub-region-code":"039","intermediate-region-code":""},{"name":"Montserrat","alpha-2":"MS","alpha-3":"MSR","country-code":"500","iso_3166-2":"ISO 3166-2:MS","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Morocco","alpha-2":"MA","alpha-3":"MAR","country-code":"504","iso_3166-2":"ISO 3166-2:MA","region":"Africa","sub-region":"Northern Africa","intermediate-region":"","region-code":"002","sub-region-code":"015","intermediate-region-code":""},{"name":"Mozambique","alpha-2":"MZ","alpha-3":"MOZ","country-code":"508","iso_3166-2":"ISO 3166-2:MZ","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Myanmar","alpha-2":"MM","alpha-3":"MMR","country-code":"104","iso_3166-2":"ISO 3166-2:MM","region":"Asia","sub-region":"South-eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"035","intermediate-region-code":""},{"name":"Namibia","alpha-2":"NA","alpha-3":"NAM","country-code":"516","iso_3166-2":"ISO 3166-2:NA","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Southern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"018"},{"name":"Nauru","alpha-2":"NR","alpha-3":"NRU","country-code":"520","iso_3166-2":"ISO 3166-2:NR","region":"Oceania","sub-region":"Micronesia","intermediate-region":"","region-code":"009","sub-region-code":"057","intermediate-region-code":""},{"name":"Nepal","alpha-2":"NP","alpha-3":"NPL","country-code":"524","iso_3166-2":"ISO 3166-2:NP","region":"Asia","sub-region":"Southern Asia","intermediate-region":"","region-code":"142","sub-region-code":"034","intermediate-region-code":""},{"name":"Netherlands","alpha-2":"NL","alpha-3":"NLD","country-code":"528","iso_3166-2":"ISO 3166-2:NL","region":"Europe","sub-region":"Western Europe","intermediate-region":"","region-code":"150","sub-region-code":"155","intermediate-region-code":""},{"name":"New Caledonia","alpha-2":"NC","alpha-3":"NCL","country-code":"540","iso_3166-2":"ISO 3166-2:NC","region":"Oceania","sub-region":"Melanesia","intermediate-region":"","region-code":"009","sub-region-code":"054","intermediate-region-code":""},{"name":"New Zealand","alpha-2":"NZ","alpha-3":"NZL","country-code":"554","iso_3166-2":"ISO 3166-2:NZ","region":"Oceania","sub-region":"Australia and New Zealand","intermediate-region":"","region-code":"009","sub-region-code":"053","intermediate-region-code":""},{"name":"Nicaragua","alpha-2":"NI","alpha-3":"NIC","country-code":"558","iso_3166-2":"ISO 3166-2:NI","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Central America","region-code":"019","sub-region-code":"419","intermediate-region-code":"013"},{"name":"Niger","alpha-2":"NE","alpha-3":"NER","country-code":"562","iso_3166-2":"ISO 3166-2:NE","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Western Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"011"},{"name":"Nigeria","alpha-2":"NG","alpha-3":"NGA","country-code":"566","iso_3166-2":"ISO 3166-2:NG","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Western Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"011"},{"name":"Niue","alpha-2":"NU","alpha-3":"NIU","country-code":"570","iso_3166-2":"ISO 3166-2:NU","region":"Oceania","sub-region":"Polynesia","intermediate-region":"","region-code":"009","sub-region-code":"061","intermediate-region-code":""},{"name":"Norfolk Island","alpha-2":"NF","alpha-3":"NFK","country-code":"574","iso_3166-2":"ISO 3166-2:NF","region":"Oceania","sub-region":"Australia and New Zealand","intermediate-region":"","region-code":"009","sub-region-code":"053","intermediate-region-code":""},{"name":"North Macedonia","alpha-2":"MK","alpha-3":"MKD","country-code":"807","iso_3166-2":"ISO 3166-2:MK","region":"Europe","sub-region":"Southern Europe","intermediate-region":"","region-code":"150","sub-region-code":"039","intermediate-region-code":""},{"name":"Northern Mariana Islands","alpha-2":"MP","alpha-3":"MNP","country-code":"580","iso_3166-2":"ISO 3166-2:MP","region":"Oceania","sub-region":"Micronesia","intermediate-region":"","region-code":"009","sub-region-code":"057","intermediate-region-code":""},{"name":"Norway","alpha-2":"NO","alpha-3":"NOR","country-code":"578","iso_3166-2":"ISO 3166-2:NO","region":"Europe","sub-region":"Northern Europe","intermediate-region":"","region-code":"150","sub-region-code":"154","intermediate-region-code":""},{"name":"Oman","alpha-2":"OM","alpha-3":"OMN","country-code":"512","iso_3166-2":"ISO 3166-2:OM","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"Pakistan","alpha-2":"PK","alpha-3":"PAK","country-code":"586","iso_3166-2":"ISO 3166-2:PK","region":"Asia","sub-region":"Southern Asia","intermediate-region":"","region-code":"142","sub-region-code":"034","intermediate-region-code":""},{"name":"Palau","alpha-2":"PW","alpha-3":"PLW","country-code":"585","iso_3166-2":"ISO 3166-2:PW","region":"Oceania","sub-region":"Micronesia","intermediate-region":"","region-code":"009","sub-region-code":"057","intermediate-region-code":""},{"name":"Palestine, State of","alpha-2":"PS","alpha-3":"PSE","country-code":"275","iso_3166-2":"ISO 3166-2:PS","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"Panama","alpha-2":"PA","alpha-3":"PAN","country-code":"591","iso_3166-2":"ISO 3166-2:PA","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Central America","region-code":"019","sub-region-code":"419","intermediate-region-code":"013"},{"name":"Papua New Guinea","alpha-2":"PG","alpha-3":"PNG","country-code":"598","iso_3166-2":"ISO 3166-2:PG","region":"Oceania","sub-region":"Melanesia","intermediate-region":"","region-code":"009","sub-region-code":"054","intermediate-region-code":""},{"name":"Paraguay","alpha-2":"PY","alpha-3":"PRY","country-code":"600","iso_3166-2":"ISO 3166-2:PY","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"South America","region-code":"019","sub-region-code":"419","intermediate-region-code":"005"},{"name":"Peru","alpha-2":"PE","alpha-3":"PER","country-code":"604","iso_3166-2":"ISO 3166-2:PE","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"South America","region-code":"019","sub-region-code":"419","intermediate-region-code":"005"},{"name":"Philippines","alpha-2":"PH","alpha-3":"PHL","country-code":"608","iso_3166-2":"ISO 3166-2:PH","region":"Asia","sub-region":"South-eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"035","intermediate-region-code":""},{"name":"Pitcairn","alpha-2":"PN","alpha-3":"PCN","country-code":"612","iso_3166-2":"ISO 3166-2:PN","region":"Oceania","sub-region":"Polynesia","intermediate-region":"","region-code":"009","sub-region-code":"061","intermediate-region-code":""},{"name":"Poland","alpha-2":"PL","alpha-3":"POL","country-code":"616","iso_3166-2":"ISO 3166-2:PL","region":"Europe","sub-region":"Eastern Europe","intermediate-region":"","region-code":"150","sub-region-code":"151","intermediate-region-code":""},{"name":"Portugal","alpha-2":"PT","alpha-3":"PRT","country-code":"620","iso_3166-2":"ISO 3166-2:PT","region":"Europe","sub-region":"Southern Europe","intermediate-region":"","region-code":"150","sub-region-code":"039","intermediate-region-code":""},{"name":"Puerto Rico","alpha-2":"PR","alpha-3":"PRI","country-code":"630","iso_3166-2":"ISO 3166-2:PR","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Qatar","alpha-2":"QA","alpha-3":"QAT","country-code":"634","iso_3166-2":"ISO 3166-2:QA","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"Réunion","alpha-2":"RE","alpha-3":"REU","country-code":"638","iso_3166-2":"ISO 3166-2:RE","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Romania","alpha-2":"RO","alpha-3":"ROU","country-code":"642","iso_3166-2":"ISO 3166-2:RO","region":"Europe","sub-region":"Eastern Europe","intermediate-region":"","region-code":"150","sub-region-code":"151","intermediate-region-code":""},{"name":"Russian Federation","alpha-2":"RU","alpha-3":"RUS","country-code":"643","iso_3166-2":"ISO 3166-2:RU","region":"Europe","sub-region":"Eastern Europe","intermediate-region":"","region-code":"150","sub-region-code":"151","intermediate-region-code":""},{"name":"Rwanda","alpha-2":"RW","alpha-3":"RWA","country-code":"646","iso_3166-2":"ISO 3166-2:RW","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Saint Barthélemy","alpha-2":"BL","alpha-3":"BLM","country-code":"652","iso_3166-2":"ISO 3166-2:BL","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Saint Helena, Ascension and Tristan da Cunha","alpha-2":"SH","alpha-3":"SHN","country-code":"654","iso_3166-2":"ISO 3166-2:SH","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Western Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"011"},{"name":"Saint Kitts and Nevis","alpha-2":"KN","alpha-3":"KNA","country-code":"659","iso_3166-2":"ISO 3166-2:KN","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Saint Lucia","alpha-2":"LC","alpha-3":"LCA","country-code":"662","iso_3166-2":"ISO 3166-2:LC","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Saint Martin (French part)","alpha-2":"MF","alpha-3":"MAF","country-code":"663","iso_3166-2":"ISO 3166-2:MF","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Saint Pierre and Miquelon","alpha-2":"PM","alpha-3":"SPM","country-code":"666","iso_3166-2":"ISO 3166-2:PM","region":"Americas","sub-region":"Northern America","intermediate-region":"","region-code":"019","sub-region-code":"021","intermediate-region-code":""},{"name":"Saint Vincent and the Grenadines","alpha-2":"VC","alpha-3":"VCT","country-code":"670","iso_3166-2":"ISO 3166-2:VC","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Samoa","alpha-2":"WS","alpha-3":"WSM","country-code":"882","iso_3166-2":"ISO 3166-2:WS","region":"Oceania","sub-region":"Polynesia","intermediate-region":"","region-code":"009","sub-region-code":"061","intermediate-region-code":""},{"name":"San Marino","alpha-2":"SM","alpha-3":"SMR","country-code":"674","iso_3166-2":"ISO 3166-2:SM","region":"Europe","sub-region":"Southern Europe","intermediate-region":"","region-code":"150","sub-region-code":"039","intermediate-region-code":""},{"name":"Sao Tome and Principe","alpha-2":"ST","alpha-3":"STP","country-code":"678","iso_3166-2":"ISO 3166-2:ST","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Middle Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"017"},{"name":"Saudi Arabia","alpha-2":"SA","alpha-3":"SAU","country-code":"682","iso_3166-2":"ISO 3166-2:SA","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"Senegal","alpha-2":"SN","alpha-3":"SEN","country-code":"686","iso_3166-2":"ISO 3166-2:SN","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Western Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"011"},{"name":"Serbia","alpha-2":"RS","alpha-3":"SRB","country-code":"688","iso_3166-2":"ISO 3166-2:RS","region":"Europe","sub-region":"Southern Europe","intermediate-region":"","region-code":"150","sub-region-code":"039","intermediate-region-code":""},{"name":"Seychelles","alpha-2":"SC","alpha-3":"SYC","country-code":"690","iso_3166-2":"ISO 3166-2:SC","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Sierra Leone","alpha-2":"SL","alpha-3":"SLE","country-code":"694","iso_3166-2":"ISO 3166-2:SL","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Western Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"011"},{"name":"Singapore","alpha-2":"SG","alpha-3":"SGP","country-code":"702","iso_3166-2":"ISO 3166-2:SG","region":"Asia","sub-region":"South-eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"035","intermediate-region-code":""},{"name":"Sint Maarten (Dutch part)","alpha-2":"SX","alpha-3":"SXM","country-code":"534","iso_3166-2":"ISO 3166-2:SX","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Slovakia","alpha-2":"SK","alpha-3":"SVK","country-code":"703","iso_3166-2":"ISO 3166-2:SK","region":"Europe","sub-region":"Eastern Europe","intermediate-region":"","region-code":"150","sub-region-code":"151","intermediate-region-code":""},{"name":"Slovenia","alpha-2":"SI","alpha-3":"SVN","country-code":"705","iso_3166-2":"ISO 3166-2:SI","region":"Europe","sub-region":"Southern Europe","intermediate-region":"","region-code":"150","sub-region-code":"039","intermediate-region-code":""},{"name":"Solomon Islands","alpha-2":"SB","alpha-3":"SLB","country-code":"090","iso_3166-2":"ISO 3166-2:SB","region":"Oceania","sub-region":"Melanesia","intermediate-region":"","region-code":"009","sub-region-code":"054","intermediate-region-code":""},{"name":"Somalia","alpha-2":"SO","alpha-3":"SOM","country-code":"706","iso_3166-2":"ISO 3166-2:SO","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"South Africa","alpha-2":"ZA","alpha-3":"ZAF","country-code":"710","iso_3166-2":"ISO 3166-2:ZA","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Southern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"018"},{"name":"South Georgia and the South Sandwich Islands","alpha-2":"GS","alpha-3":"SGS","country-code":"239","iso_3166-2":"ISO 3166-2:GS","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"South America","region-code":"019","sub-region-code":"419","intermediate-region-code":"005"},{"name":"South Sudan","alpha-2":"SS","alpha-3":"SSD","country-code":"728","iso_3166-2":"ISO 3166-2:SS","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Spain","alpha-2":"ES","alpha-3":"ESP","country-code":"724","iso_3166-2":"ISO 3166-2:ES","region":"Europe","sub-region":"Southern Europe","intermediate-region":"","region-code":"150","sub-region-code":"039","intermediate-region-code":""},{"name":"Sri Lanka","alpha-2":"LK","alpha-3":"LKA","country-code":"144","iso_3166-2":"ISO 3166-2:LK","region":"Asia","sub-region":"Southern Asia","intermediate-region":"","region-code":"142","sub-region-code":"034","intermediate-region-code":""},{"name":"Sudan","alpha-2":"SD","alpha-3":"SDN","country-code":"729","iso_3166-2":"ISO 3166-2:SD","region":"Africa","sub-region":"Northern Africa","intermediate-region":"","region-code":"002","sub-region-code":"015","intermediate-region-code":""},{"name":"Suriname","alpha-2":"SR","alpha-3":"SUR","country-code":"740","iso_3166-2":"ISO 3166-2:SR","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"South America","region-code":"019","sub-region-code":"419","intermediate-region-code":"005"},{"name":"Svalbard and Jan Mayen","alpha-2":"SJ","alpha-3":"SJM","country-code":"744","iso_3166-2":"ISO 3166-2:SJ","region":"Europe","sub-region":"Northern Europe","intermediate-region":"","region-code":"150","sub-region-code":"154","intermediate-region-code":""},{"name":"Sweden","alpha-2":"SE","alpha-3":"SWE","country-code":"752","iso_3166-2":"ISO 3166-2:SE","region":"Europe","sub-region":"Northern Europe","intermediate-region":"","region-code":"150","sub-region-code":"154","intermediate-region-code":""},{"name":"Switzerland","alpha-2":"CH","alpha-3":"CHE","country-code":"756","iso_3166-2":"ISO 3166-2:CH","region":"Europe","sub-region":"Western Europe","intermediate-region":"","region-code":"150","sub-region-code":"155","intermediate-region-code":""},{"name":"Syrian Arab Republic","alpha-2":"SY","alpha-3":"SYR","country-code":"760","iso_3166-2":"ISO 3166-2:SY","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"Taiwan, Province of China","alpha-2":"TW","alpha-3":"TWN","country-code":"158","iso_3166-2":"ISO 3166-2:TW","region":"Asia","sub-region":"Eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"030","intermediate-region-code":""},{"name":"Tajikistan","alpha-2":"TJ","alpha-3":"TJK","country-code":"762","iso_3166-2":"ISO 3166-2:TJ","region":"Asia","sub-region":"Central Asia","intermediate-region":"","region-code":"142","sub-region-code":"143","intermediate-region-code":""},{"name":"Tanzania, United Republic of","alpha-2":"TZ","alpha-3":"TZA","country-code":"834","iso_3166-2":"ISO 3166-2:TZ","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Thailand","alpha-2":"TH","alpha-3":"THA","country-code":"764","iso_3166-2":"ISO 3166-2:TH","region":"Asia","sub-region":"South-eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"035","intermediate-region-code":""},{"name":"Timor-Leste","alpha-2":"TL","alpha-3":"TLS","country-code":"626","iso_3166-2":"ISO 3166-2:TL","region":"Asia","sub-region":"South-eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"035","intermediate-region-code":""},{"name":"Togo","alpha-2":"TG","alpha-3":"TGO","country-code":"768","iso_3166-2":"ISO 3166-2:TG","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Western Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"011"},{"name":"Tokelau","alpha-2":"TK","alpha-3":"TKL","country-code":"772","iso_3166-2":"ISO 3166-2:TK","region":"Oceania","sub-region":"Polynesia","intermediate-region":"","region-code":"009","sub-region-code":"061","intermediate-region-code":""},{"name":"Tonga","alpha-2":"TO","alpha-3":"TON","country-code":"776","iso_3166-2":"ISO 3166-2:TO","region":"Oceania","sub-region":"Polynesia","intermediate-region":"","region-code":"009","sub-region-code":"061","intermediate-region-code":""},{"name":"Trinidad and Tobago","alpha-2":"TT","alpha-3":"TTO","country-code":"780","iso_3166-2":"ISO 3166-2:TT","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Tunisia","alpha-2":"TN","alpha-3":"TUN","country-code":"788","iso_3166-2":"ISO 3166-2:TN","region":"Africa","sub-region":"Northern Africa","intermediate-region":"","region-code":"002","sub-region-code":"015","intermediate-region-code":""},{"name":"Turkey","alpha-2":"TR","alpha-3":"TUR","country-code":"792","iso_3166-2":"ISO 3166-2:TR","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"Turkmenistan","alpha-2":"TM","alpha-3":"TKM","country-code":"795","iso_3166-2":"ISO 3166-2:TM","region":"Asia","sub-region":"Central Asia","intermediate-region":"","region-code":"142","sub-region-code":"143","intermediate-region-code":""},{"name":"Turks and Caicos Islands","alpha-2":"TC","alpha-3":"TCA","country-code":"796","iso_3166-2":"ISO 3166-2:TC","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Tuvalu","alpha-2":"TV","alpha-3":"TUV","country-code":"798","iso_3166-2":"ISO 3166-2:TV","region":"Oceania","sub-region":"Polynesia","intermediate-region":"","region-code":"009","sub-region-code":"061","intermediate-region-code":""},{"name":"Uganda","alpha-2":"UG","alpha-3":"UGA","country-code":"800","iso_3166-2":"ISO 3166-2:UG","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Ukraine","alpha-2":"UA","alpha-3":"UKR","country-code":"804","iso_3166-2":"ISO 3166-2:UA","region":"Europe","sub-region":"Eastern Europe","intermediate-region":"","region-code":"150","sub-region-code":"151","intermediate-region-code":""},{"name":"United Arab Emirates","alpha-2":"AE","alpha-3":"ARE","country-code":"784","iso_3166-2":"ISO 3166-2:AE","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"United Kingdom of Great Britain and Northern Ireland","alpha-2":"GB","alpha-3":"GBR","country-code":"826","iso_3166-2":"ISO 3166-2:GB","region":"Europe","sub-region":"Northern Europe","intermediate-region":"","region-code":"150","sub-region-code":"154","intermediate-region-code":""},{"name":"United States of America","alpha-2":"US","alpha-3":"USA","country-code":"840","iso_3166-2":"ISO 3166-2:US","region":"Americas","sub-region":"Northern America","intermediate-region":"","region-code":"019","sub-region-code":"021","intermediate-region-code":""},{"name":"United States Minor Outlying Islands","alpha-2":"UM","alpha-3":"UMI","country-code":"581","iso_3166-2":"ISO 3166-2:UM","region":"Oceania","sub-region":"Micronesia","intermediate-region":"","region-code":"009","sub-region-code":"057","intermediate-region-code":""},{"name":"Uruguay","alpha-2":"UY","alpha-3":"URY","country-code":"858","iso_3166-2":"ISO 3166-2:UY","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"South America","region-code":"019","sub-region-code":"419","intermediate-region-code":"005"},{"name":"Uzbekistan","alpha-2":"UZ","alpha-3":"UZB","country-code":"860","iso_3166-2":"ISO 3166-2:UZ","region":"Asia","sub-region":"Central Asia","intermediate-region":"","region-code":"142","sub-region-code":"143","intermediate-region-code":""},{"name":"Vanuatu","alpha-2":"VU","alpha-3":"VUT","country-code":"548","iso_3166-2":"ISO 3166-2:VU","region":"Oceania","sub-region":"Melanesia","intermediate-region":"","region-code":"009","sub-region-code":"054","intermediate-region-code":""},{"name":"Venezuela (Bolivarian Republic of)","alpha-2":"VE","alpha-3":"VEN","country-code":"862","iso_3166-2":"ISO 3166-2:VE","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"South America","region-code":"019","sub-region-code":"419","intermediate-region-code":"005"},{"name":"Viet Nam","alpha-2":"VN","alpha-3":"VNM","country-code":"704","iso_3166-2":"ISO 3166-2:VN","region":"Asia","sub-region":"South-eastern Asia","intermediate-region":"","region-code":"142","sub-region-code":"035","intermediate-region-code":""},{"name":"Virgin Islands (British)","alpha-2":"VG","alpha-3":"VGB","country-code":"092","iso_3166-2":"ISO 3166-2:VG","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Virgin Islands (U.S.)","alpha-2":"VI","alpha-3":"VIR","country-code":"850","iso_3166-2":"ISO 3166-2:VI","region":"Americas","sub-region":"Latin America and the Caribbean","intermediate-region":"Caribbean","region-code":"019","sub-region-code":"419","intermediate-region-code":"029"},{"name":"Wallis and Futuna","alpha-2":"WF","alpha-3":"WLF","country-code":"876","iso_3166-2":"ISO 3166-2:WF","region":"Oceania","sub-region":"Polynesia","intermediate-region":"","region-code":"009","sub-region-code":"061","intermediate-region-code":""},{"name":"Western Sahara","alpha-2":"EH","alpha-3":"ESH","country-code":"732","iso_3166-2":"ISO 3166-2:EH","region":"Africa","sub-region":"Northern Africa","intermediate-region":"","region-code":"002","sub-region-code":"015","intermediate-region-code":""},{"name":"Yemen","alpha-2":"YE","alpha-3":"YEM","country-code":"887","iso_3166-2":"ISO 3166-2:YE","region":"Asia","sub-region":"Western Asia","intermediate-region":"","region-code":"142","sub-region-code":"145","intermediate-region-code":""},{"name":"Zambia","alpha-2":"ZM","alpha-3":"ZMB","country-code":"894","iso_3166-2":"ISO 3166-2:ZM","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"},{"name":"Zimbabwe","alpha-2":"ZW","alpha-3":"ZWE","country-code":"716","iso_3166-2":"ISO 3166-2:ZW","region":"Africa","sub-region":"Sub-Saharan Africa","intermediate-region":"Eastern Africa","region-code":"002","sub-region-code":"202","intermediate-region-code":"014"}]

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
    {name: 'Chinese Taipei', code: 'CN'}, 
    {name: 'Christmas Island', code: 'CX'}, 
    {name: 'Cocos (Keeling) Islands', code: 'CC'}, 
    {name: 'Colombia', code: 'CO'}, 
    {name: 'Comoros', code: 'KM'}, 
    {name: 'Congo', code: 'CG'}, 
    {name: 'Congo, The Democratic Republic of the', code: 'CD'}, 
    {name: 'Cook Islands', code: 'CK'}, 
    {name: 'Costa Rica', code: 'CR'}, 
    {name: 'Cote D\'Ivoire', code: 'CI'},
    {name: "Côte d'Ivoire", code: 'CI'},
    {name: 'Croatia', code: 'HR'}, 
    {name: 'Cuba', code: 'CU'}, 
    {name: 'Cyprus', code: 'CY'}, 
    {name: 'Czech Republic', code: 'CZ'}, 
    {name: 'Czechia', code: 'CZ'}, 
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
    {name: 'Iran', code: 'IR'}, 
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
    {name: 'Kor', code: 'KR'}, 
    {name: 'South Korea', code: 'KR'}, 
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
    {name: 'Russia', code: 'RU'}, 
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
    {name: 'Serbia', code: 'CS'}, 
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
    {name: 'United States of America', code: 'US'},
    {name: 'America', code: 'US'},
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
    {name: 'Zimbabwe', code: 'ZW'},
    {name: 'Great Britain', code: 'GB'}
];