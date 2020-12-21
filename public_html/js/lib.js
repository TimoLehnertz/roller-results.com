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
            console.log("todo")
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
        this.layout = undefined;
        this.layout = this.getLayout(this.data);
        $(() => {this.init()});
    }

    init(){
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
    }

    getLayoutIndex(name){
        let i = 0;
        for (const head of this.layout) {
            if(head === name){
                return i;
            }
            i++;
        }
    }

    getLayout(data){
        const layout = [];
        for (const columun in data[0]) {
            if (data[0].hasOwnProperty(columun)) {
                layout.push(columun);
            }
        }
        return layout;
    }

    updateData(data){
        this.data = data;
        this.init();
    }

    getTable(){
        const table = $(`<table class="${Table.class} ${this.name}"></table>`);
        $(table).append(this.getTableHead(this.layout));
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

    getTableHead(layout){
        const head = $(`<tr class="${Table.headClass}"></tr>`);
        let count = 0;
        for (const td of layout) {
            const tdElem = $(`<td class="index-${count}">${td}</td>`);
            let dropdown = new Dropdown(tdElem, [
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
            $(head).append(tdElem);
            count++;
        }
        return head;
    }

    getRow(row, zebra){
        const rowElem = $(`<tr class="${Table.bodyClass} ${zebra ? "zebra" : ""}"></tr>`);
        for (const column of this.layout) {
            if(row.hasOwnProperty(column)){
                $(rowElem).append(this.getColumn(row[column]));
            } else{
                $(rowElem).append(this.getColumn(""));
            }
        }
        return rowElem;
    }
    
    getColumn(elem){
        if (elem instanceof jQuery){
            const e = $(`<td></td>`);
            e.append(elem);
            return e;
        } else{

        }
        return $(`<td>${elem}</td>`);
    }
}
