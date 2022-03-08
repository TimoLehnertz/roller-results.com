/**
 * Search function
 * @param {text} text 
 * @param {callback(succsess, response)} callback
 */
function search(text, callback){
    $.ajax({
        url: "/api/index.php?search=" + text,
        dataType:  "text",
        success: (response) =>{
            if(isJson(response)){
                callback(true, JSON.parse(response));
            } else{
                callback(false, null);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            callback(false, null);
            ajaxError(xhr + " " + ajaxOptions + " " + thrownError);
        }
    });
}

/**
 * @todo
 * @param {text} message message to display
 */
function ajaxError(message){
    // alert("axax error occoured: " + message);
    console.log("ajax error");
}

function isJson(text){
    if(!text.replace) return false;
    return /^[\],:{}\s]*$/.test(text.replace(/\\["\\\/bfnrtu]/g, '@').
    replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
    replace(/(?:^|:|,)(?:\s*\[)+/g, ''));
}

/**
 * js API
 */
function post(mode, data) {
    const promise = {
        receive: (callback) => {promise.callback = callback},
        callback: () => {console.log("no callback")}
    }
    if(typeof data === "object") {
        data = JSON.stringify(data);
    }
    let url = `/api/index.php?${mode}=1`;
    $.ajax({
        type: "POST",
        url: url + getAjaxStateString(),
        data,
        dataType:  "text",
        success: (response) =>{
            if(!isJson(response)){
                console.log("no json");
                console.log(response);
            }
            if(isJson(response) && response.length > 0/* && !response.includes("error")*/){
                promise.callback(true, JSON.parse(response));
            } else{
                console.log("Response from " + mode + " wasn't JSON");
                promise.callback(true, response);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            promise.callback(false, null);
            ajaxError(xhr + " " + ajaxOptions + " " + thrownError);
        }
    });
    return promise;
}

/**
 * js get api
 * @param {text} property property to be called from the server
 * @param {text / number} data data to be send mostly ids
 */
function get(property, data1, data2, data3){
    const promise = {
        receive: (callback) => {promise.callback = callback},
        callback: () => {console.log("no callback")}
    }
    let url = `/api/index.php?get${property}`;
    if(typeof data1 === 'object' ) {
        for (const key in data1) {
            if (Object.hasOwnProperty.call(data1, key)) {
                const element = data1[key];
                url += `&${key}=${element}`;
            }
        }
    } else {
        url += `=${data1}`;
        if(data2 !== undefined) {
            url += `&data=${data2}`;
            if(data3 !== undefined) {
                url += `&data1=${data3}`;
            }
        }
    }
    
    $.ajax({
        type: "GET",
        url: url + getAjaxStateString(),
        dataType:  "text",
        success: (response) =>{
            if(!isJson(response)){
                console.log("no json")
            }
            if(isJson(response) && response.length > 0/* && !response.includes("error")*/){
                promise.callback(true, JSON.parse(response));
            } else{
                console.log("Response from get" + property + " wasn't JSON");
                promise.callback(false, null);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            promise.callback(false, null);
            ajaxError(xhr + " " + ajaxOptions + " " + thrownError);
        }
    });
    return promise;
}

function set(property, data){
    const promise = {
        receive: (callback) => {promise.callback = callback},
        callback: () => {}
    }
    $.ajax(`/api/?set${property}`, {
        method: "POST",
        // data: data,
        data: JSON.stringify(data),
        success: (response) => {
            promise.callback(response);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            promise.callback(null);
            ajaxError(xhr + " " + ajaxOptions + " " + thrownError);
        },
        // dataType: "text"
      });
      return promise;
}

function getFile(path){
    const promise = {
        receive: (callback) => {promise.callback = callback},
        callback: () => {}
    }
    $.ajax({
        type: "GET",
        url : path,
        dataType:  "text",
        success: (response) =>{
            if(isJson(response) && response.length > 0){
                promise.callback(true, JSON.parse(response));
            } else{
                promise.callback(true, response);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            promise.callback(false, null);
            ajaxError(xhr + " " + ajaxOptions + " " + thrownError);
        }
    });
    return promise;
}

function getAPI(url) {
    const promise = {
        receive: (callback) => {promise.callback = callback},
        callback: () => {}
    }
    $.ajax({
        type: "GET",
        url : url,
        // dataType:  "text",
        success: (response) =>{
            if(isJson(response) && response.length > 0){
                promise.callback(true, JSON.parse(response));
            } else{
                promise.callback(true, response);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            promise.callback(false, null);
            ajaxError(xhr + " " + ajaxOptions + " " + thrownError);
        }
    });
    return promise;
}

function getAjaxStateString(){
    let string = "";
    for (const state in ajaxState) {
        if (Object.hasOwnProperty.call(ajaxState, state)) {
            const val = ajaxState[state];
            string += `&${state}=${val}`
        }
    }
    return string;
}

const ajaxState = {}