$(init);

let subjects = [];
let teachers = [];
let rooms = [];
let name = "";
let plan = {};

function init(){
    initTeachers();
    initSubjects();
    initRooms();
    initSave();
    get("plans", null, (plans) => {
        console.log(plans);
        if(plans.plans.length > 0){
            loadPlan(plans.plans[0].name);
        }
    })
}

function initSave(){
    $(".apply").click(() => {
        console.log(plan);
        set("plan", plan, (suc) => {
            if(suc){
                alert("Gespeichert!");
            } else{
                alert("Fehler");
            }
        });
    });
}

function initTeachers(){
    $(".teachers").empty();
    get("teachers", null, (teachers1) => {
        teachers = teachers1;
        const elem = $(`<ul></ul>`);
        for (const teacher of teachers) {
            $(elem).append(`<li draggable="true">${teacher}</li>`);
        }
        $(".teachers").append(elem);
        $(".teachers").append(`<input type="text" placeholder="name" class="teacher-add-name">`);
        const addBtn = $(`<button class="btn slide vertical">Hinzufügen</button>`);
        addBtn.click(()=>{addTeacher($(".teacher-add-name").val())});
        $(".teachers").append(addBtn);
    });
}

function addTeacher(name){
    if(name.length > 0){
        add("teacher", name, (succsess)=>{
            if(!succsess){
                alert("Der name existiert bereits");
            } else{
                initTeachers();
            }
        });
    } else{
        alert("Zu kurz :(");
    }
}

function initRooms(){
    $(".rooms").empty();
    get("rooms", null, (rooms1) => {
        rooms = rooms1;
        const elem = $(`<ul></ul>`);
        for (const room of rooms) {
            $(elem).append(`<li draggable="true">${room}</li>`);
        }
        $(".rooms").append(elem);
        $(".rooms").append(`<input type="text" placeholder="name" class="room-add-name">`);
        const addBtn = $(`<button class="btn slide vertical">Hinzufügen</button>`);
        addBtn.click(()=>{addRoom($(".room-add-name").val())});
        $(".rooms").append(addBtn);
    });
}

function addRoom(name){
    if(name.length > 0){
        add("room", name, (succsess)=>{
            if(!succsess){
                alert("Der name existiert bereits");
            } else{
                initRooms();
            }
        });
    } else{
        alert("Zu kurz :(");
    }
}

function addSubject(name){
    if(name.length > 0){
        add("subject", name, (succsess)=>{
            if(!succsess){
                alert("Der name existiert bereits");
            } else{
                initSubjects();
            }
        });
    } else{
        alert("Zu kurz :(");
    }
}

function addPlan(name){
    if(name.length > 0){
        add("plan", name, (succsess)=>{
            if(!succsess){
                alert("Der name existiert bereits");
            } else{
                loadPlan(name);
            }
        });
    } else{
        alert("Zu kurz :(");
    }
}

function initSubjects(){
    $(".subjects").empty();
    get("subjects", null, (subjects1) => {
        subjects = subjects1;
        const elem = $(`<ul></ul>`);
        for (const subject of subjects) {
            $(elem).append(`<li draggable="true">${subject}</li>`);
        }
        $(".subjects").append(elem);
        $(".subjects").append(`<input type="text" placeholder="name" class="subject-add-name">`);
        const addBtn = $(`<button class="btn slide vertical">Hinzufügen</button>`);
        addBtn.click(()=>{addSubject($(".subject-add-name").val())});
        $(".subjects").append(addBtn);
    });
}

function loadPlan(name){
    get("plan", name, (plan1, succsess) =>{
        if(!succsess){
            alert("Fehler beim laden des plans " + name + " :(");
        } else{
            name = name;
            plan = plan1;
            drawPlan(plan);
        }
    });
}

function drawPlan(plan){
    console.log(plan)
    const elem = $(".planWrapper");
    $(elem).empty();
    $(elem).append(getPlanElem(plan));
}

function getPlanElem(plan){
    const elem = $(`<div class="plan flex"></div>`);
    for (const day of plan.days) {
        const dayElem = $(`<div class="day" ondragover="$(this).addClass('drag-over');"></day>`);
        for (const hour of day.hours) {
            const hourElem = $(`
            <div class="hour">
                <div class="subject">S: </div>
                <div class="room">R: </div>
                <div class="teacher">T: </div>
            </day>`);
            hourElem.find(".subject").append(getSelect(subjects, hour.subject));
            hourElem.find(".subject select").change(function(){
                hour.subject = $(this).val();
            });
            hourElem.find(".room").append(getSelect(rooms, hour.room));
            hourElem.find(".room select").change(function(){
                console.log($(this).val())
                hour.room = $(this).val();
            });
            hourElem.find(".teacher").append(getSelect(teachers, hour.teacher));
            hourElem.find(".teacher select").change(function(){
                hour.teacher = $(this).val();
            });
            dayElem.append(hourElem);
        }
        elem.append(dayElem);
    }
    return elem;
}

function getSelect(options, selected){
    const elem = $(`<select><option value="<empty>">Auswählen</option></select>`);
    for (const option of options) {
        const optionElem = $(`<option value="${option}">${option}</option>`);
        if(option == selected){
            console.log(selected)
            optionElem.attr("selected", "selected");
        }
        elem.append(optionElem);
    }
    return elem;
}

/**
 * Ajax
 */
function get(type, name, callback){
    let request = 'api.php?get' + type + "=1";
    if(name != null){
        request += "&name=" + name;
    }
    $.ajax(request,
    {
        dataType: 'text', // type of response data
        success: function (data,status,xhr) {   // success callback function
            if(data === null){
                onsole.log(data);
                callback(null, false);
            } else if(isJson(data)) {
                // console.log(data)
                callback(JSON.parse(data), true);
            } else{
                console.log(data);
                callback(null, false);
            }
        },
        error: function (jqXhr, textStatus, errorMessage) { // error callback
            alert("error while getting: " + type + ", " + errorMessage);
        }
    });
 }

function add(type, name, callback){
    $.ajax('api.php?add' + type + "=1&name=" + name,
    {
        success: function (data,status,xhr) {   // success callback function
            callback(!data.includes("error"));
        },
        error: function (jqXhr, textStatus, errorMessage) { // error callback
            alert("error while getting: " + type + ", " + errorMessage);
        }
    });
}

function set(type, data, callback){
    $.ajax('api.php?set' + type + "=1",
    {
        method: "POST",
        data: JSON.stringify(data),
        success: function (data,status,xhr) {   // success callback function
            console.log(data);
            callback(!data.includes("error"));
        },
        error: function (jqXhr, textStatus, errorMessage) { // error callback
            alert("error while getting: " + type + ", " + errorMessage);
        }
    });
}


function isJson(text){
    return /^[\],:{}\s]*$/.test(text.replace(/\\["\\\/bfnrtu]/g, '@').
    replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
    replace(/(?:^|:|,)(?:\s*\[)+/g, '')) && text.length !== 0;
}