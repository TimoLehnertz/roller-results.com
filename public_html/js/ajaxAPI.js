/**
 * Search function
 * @param {text} text 
 * @param {callback(succsess, response)} callback
 */
function search(text, callback){
    $.ajax({
        url: "/api?search=" + text,
        dataType:  "json",
        success: (json) =>{
            callback(true, json);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            callback(false, null);
            ajaxError(xhr + " " + ajaxOptions + " " + thrownError);
        }
    })
}

/**
 * @todo
 * @param {text} message message to display
 */
function ajaxError(message){
    alert(message);
}