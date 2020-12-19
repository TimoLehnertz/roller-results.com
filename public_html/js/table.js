/**
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
            $(head).append(`<td>${td}</td>`);
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