"use strict";

/**
 * Drop down
 * 
 * Dependencies:
 *  JQuery
 *  _dropdown.sass
 * 
 * constructor:
 *      elem    ->  elem to be used as opening for the dropdown
 *      content ->  ether a dom element to be inside the dropdown,
 *                  or an object in the form of
 *                  [
 *                      {
 *                              element: ? //Element to be represented / can be text
 *                              tooltip: ? //tooltip
 *                              children: [] //children to move to if clicked(in the same form as parent)
 *                              icon: //icon to be showed at the left @todo
 *                       }
 *                  ]
 */

class Dropdown{

    static allDropDowns = [];
    static dropdownClass = "data-dropdown";
    static entryClass = "data-dropdown__entry";

    constructor(elem, content){
        console.log(typeof content);
        this.elem = elem;
        this.content = content;
        this.unfolded = false;
        this.customClass = undefined;
        this.dropDownElem = undefined;
        this.path = [];
    }

    setup(setup){console.log("setting up");
        console.log(setup);
        if(setup.hasOwnProperty("customClass")){//custom class to be added to the dropdowns classList
            this.customClass = setup.customClass;
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
        }
    }

    load(object){
        this.dropDownElem.empty();
        if(Array.isArray(object)){
            console.log("array");
            this.path.push(object);
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
                duration: 0
            });
        } else{
            console.log("todo")
        }
    }

    getBackButton(){
        const btn = $(`<div class="${Dropdown.entryClass}"><- Back</div>`);
        btn.click(() => {
            this.path.pop();
            this.load(this.path[this.path.length - 1]);
        });
        return btn;
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
        return elem;
    }

    close(){
        if(this.unfolded){
            this.unfolded = false;
            this.dropDownElem.css("display", "none");
        }
    }

    static closeAll(){
        for (const dropDown of Dropdown.allDropDowns) {
            dropDown.close();
        }
    }

    static getFullBounds(elem){
        const elemCpy = $(elem).clone();
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

    constructor(elem, data, name){
        this.data = data;
        this.elem = elem;
        this.name = name;
        this.layout = undefined;
        this.init();
    }

    init(){
        this.layout = this.getLayout(this.data);
        $(this.elem).empty();
        $(this.elem).append(this.getTable());
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
        const table = $(`<table class="data-table ${this.name}"></table>`);
        $(table).append(this.getTableHead(this.layout));
        let zebra = false;
        for (const row of this.data) {
            $(table).append(this.getRow(row, zebra));
            zebra = !zebra;
        }
        return table;
    }

    getTableHead(layout){
        const head = $(`<tr class="data-table__head"></tr>`);
        for (const td of layout) {
            const tdElem = $(`<td>${td}</td>`);
            // let dropDown = new Dropdown(tdElem, $(`<p>Filter<br>testa<hr>testb</p>`));
            let dropDown = new Dropdown(tdElem, [
                {
                    element: "test A",
                    tooltip: "this is a test",
                    children: [
                        {
                            element: "test A-1",
                            tooltip: "this is a inner test",
                        },{
                            element: "test A-2",
                            tooltip: "this is a inner test",
                        },{
                            element: "test A-3",
                            tooltip: "this is a inner test",
                        }
                    ]
                }, {
                    element: $("<div>B</div>"),
                    tooltip: "this is a test",
                    children: [
                        {
                            element: "test B-1",
                            tooltip: "this is a inner test",
                        },{
                            element: "test B-2",
                            tooltip: "this is a inner test",
                        },{
                            element: "test B-3",
                            tooltip: "this is a inner test",
                        }
                    ]
                }, {
                    element: "test C",
                    tooltip: "this is a test",
                    children: [
                        {
                            element: "test C-1",
                            tooltip: "this is a inner test",
                        },{
                            element: "test C-2",
                            tooltip: "this is a inner test",
                        },{
                            element: "test C-3",
                            tooltip: "this is a inner test",
                        }
                    ]
                }, 
            ]);
            dropDown.init();
            $(head).append(tdElem);
        }
        return head;
    }

    getRow(row, zebra){
        const rowElem = $(`<tr ${zebra ? `class="zebra"` : ""}></tr>`);
        for (const column of this.layout) {
            if(row.hasOwnProperty(column)){
                $(rowElem).append(this.getColumn(row[column]));
            } else{
                $(rowElem).append(this.getColumn(""));
            }
        }
        return rowElem;
    }
    
    getColumn(text){
        const column = $(`<td>${text}</td>`);
        return column;
    }
}
