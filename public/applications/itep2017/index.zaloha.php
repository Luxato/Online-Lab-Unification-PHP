<!DOCTYPE html>           
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>ITEP2017</title>
    <link rel="stylesheet" type="text/css" href="css/jquery.jqplot.min.css">
    <script src="js/jquery-1.11.1.min.js"></script>
<!--    <script src="js/sse.js"></script> -->
     <script src="js/sse.js"></script>
    <script>   

var HOST = '147.175.105.140:8011'; // :8011  //147.175.105.140
var API_KEY = 'c0a082896a8c2f946ea7f67d3ae39c41';

    var formData = new FormData(); 
    formData.append("engine", "scicoslab");
    formData.append("data_type", "simulation");
    formData.append("formula_output", "raw");
    formData.append("variable_list", "");
    formData.append("advanced_features", "yes");
    formData.append("simulation_parameters", "");
    formData.append("code", "");
    formData.append("graphic_figure", "");
    formData.append("api_key", API_KEY);  
    formData.append("source", 'js');//vyuzite pri SSE
    
   // formData.append("file_name", 'ssfc.cos');
/* 
$.get( "ssfc.cos", function( data ) {
  formData.append("file_name", data);
});
*/
 //var fileData = new FormData(); 

function handleData( responseData ) {

    // Do what you want with the data
    console.log(responseData);
    fileData.append("file_name", responseData);
}

//http://www.henryalgus.com/reading-binary-files-using-jquery-ajax/
var xhr = new XMLHttpRequest();
xhr.open('GET', 'ssfc.cos', true);
xhr.responseType = 'blob';
xhr.onload = function(e) {
  if (this.status == 200) {
    // get binary data as a response
    var blob = this.response;
    console.log(blob);        
    //handleData(blob); 
    
    var fileData = new FormData();     
    formData.append("file_name", blob);
    for(var pair of formData.entries()) {console.log(pair[0]+ ', '+ pair[1]);}
    
    
    createEventSource(); 
    $(function() {
 $.ajax({
    type: "POST",
//    url: "scilab1.php",
    url: 'http://' + HOST + '/sciengine/engine/compute',
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data, textStatus, jqXHR) {
                if (textStatus == 'success')//typeof data.status == 'ok')
                { console.log(typeof(data));
                  console.log(data);
                var msg = JSON.parse(data);
                console.log(msg.response);
               // <?php var_dump(data);?>
                closeEventSource();
                allDataString = msg.response.raw;
                console.log(allDataString);
                }
                else {
                    // Handle errors here
                    console.log('ERRORS: ' + data.error);
                    closeEventSource();     
                } }, 
    error: function(req, err){ console.log('my message: ' + err); }                

        });     
    }); 
    
    
    
    //var xhrForm = new XMLHttpRequest();
    //xhrForm.open("POST", 'http://' + HOST + '/sciengine/index.php?action=uploadScript&api_key=' + API_KEY);
    //xhrForm.send(fileData);     
  }
};
xhr.send();

//console.log(fileData);


 
 //fileData.append("file_name", 'ssfc.cos');
/* 
  $.ajax({
                    url: 'http://' + HOST + '/sciengine/index.php?action=uploadScript&api_key=' + API_KEY,
                    type: 'POST',
                    data: fileData,
                    cache: false,
                    dataType: 'json',
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function (data, textStatus, jqXHR) {
                        console.log(data.status);
                        if (data.status == 'ok') //(typeof data.error === 'undefined')
                        {
                            // Success so call function to process the form
                            //$('#errors').html(data.message);
                            //submitForm(event, data);
                        }
                        else {
                            $('#errors').html(data.message);
                            // Handle errors here
                            console.log('ERRORS: ' + data.message);
                            showHideSpinner('hide');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // Handle errors here
                        $('#errors').html('Error: Nepodarilo sa odoslať súbor. Pozri konzolu pre bližšie info.');
                        console.log('ERRORS: ' + textStatus);
                        console.log('Data: ' + textStatus);
                        // STOP LOADING SPINNER
                    }
                }); 
*/            
    createEventSource();   
    
                        
$(function() {
 $.ajax({
    type: "POST",
//    url: "scilab1.php",
    url: 'http://' + HOST + '/sciengine/engine/compute',
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data, textStatus, jqXHR) {
                if (textStatus == 'success')//typeof data.status == 'ok')
                { console.log(typeof(data));
                  console.log(data);
                var msg = JSON.parse(data);
                console.log(msg.response);
               // <?php var_dump(data);?>
                closeEventSource();
                allDataString = msg.response.raw;
                console.log(allDataString);
                }
                else {
                    // Handle errors here
                    console.log('ERRORS: ' + data.error);
                    closeEventSource();     
                } }, 
    error: function(req, err){ console.log('my message: ' + err); }                

        });     
    });   
  
    </script>
  </head>

  <body>
    hop 
    <div id="chartdiv" style="height:600px;width:inherit"></div>
  </body>
</html>
