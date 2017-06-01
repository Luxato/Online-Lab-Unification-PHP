/**
 * http://www.html5rocks.com/en/tutorials/eventsource/basics/
 * demo:
 * https://github.com/html5rocks/www.html5rocks.com/tree/master/content/tutorials/eventsource/basics/static/demo
 *
 *
 * Server Send Events
 */

 var HOST = '147.175.105.140:8011';
var streamUri = "http://" + HOST + "/sciengine/index.php?controller=engine&action=ssereaddata";
//var streamUri = "scilab2.php";
var eSource;
var allDataString, allDataStringOld;

//todo: napisat ci je to podporovane v priehladaci: http://www.w3schools.com/html/html5_serversentevents.asp
function createEventSource()
{
    if (!!window.EventSource) {
        eSource = new EventSource(streamUri);
       // interval = setInterval(plotData, 1000);
    } else {
        // Result to xhr polling :(
    }

    eSource.addEventListener('message', function(e) {
        var msg = JSON.parse(e.data);

        allDataString = msg.message;
         //console.log(msg.message);

    }, false);

    eSource.addEventListener('open', function(e) {
        // Connection was opened.
    }, false);

    eSource.addEventListener('error', function(e) {
        if (e.readyState == EventSource.CLOSED) {
            // Connection was closed.
        //    clearInterval(interval);
        }
    }, false);

}

function closeEventSource()
{
    eSource.close();
    //clearInterval(interval);
}



