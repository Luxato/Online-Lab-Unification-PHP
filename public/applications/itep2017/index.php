<!DOCTYPE html>           
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>ITEP2017</title>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/plotly-latest.min.js"></script>
    <script src="js/sse.js"></script>
    <script src="js/functions.js"></script>
  </head>

  <body>
    hop 
    <div id="plotdiv1" style="width:600px;height:250px;"></div>
    <div id="plotdiv2" style="width:600px;height:250px;"></div>   
    
      <script>   
var HOST = '147.175.105.140:8011'; // :8011  //147.175.105.140
var API_KEY = 'c0a082896a8c2f946ea7f67d3ae39c41';
var layout1 = {
      //title: 'Sales Growth',
      margin: { t: 40 },
      xaxis: {
        title: 'time',
        range: [0,30]
      },
      yaxis: {
        title: 'y,u',
        range: [0,1.6]
      }
    };
var layout2 = {
      title: 'Control variable',
      margin: { t: 40 },
      xaxis: {
        title: 'time',
        range: [0,30]
      },
      yaxis: {
        title: 'u',
        range: [-1,1]
      }
    };    
    
var formData = new FormData(); 
formData.append("engine", "scicoslab");
formData.append("data_type", "simulation");
formData.append("formula_output", "raw");
formData.append("variable_list", "");
formData.append("advanced_features", "yes");
formData.append("simulation_parameters", "Ks=1,a=0.5,Td=1,Tf=0.5,Umin=-10,Umax=10,w=1,tw=1,vi=0,ti=0,vo=0,to=0");
formData.append("code", "");
formData.append("graphic_figure", "");
formData.append("api_key", API_KEY);  
formData.append("source", 'js');//vyuzite pri SSE

//http://www.henryalgus.com/reading-binary-files-using-jquery-ajax/
var xhr = new XMLHttpRequest();
xhr.open('GET', 'ssfc0.cos', true);
xhr.responseType = 'blob';
xhr.onload = function(e) {
  if (this.status == 200) {
    // get binary data as a response
    var blob = this.response;
    //console.log(blob);        
    
    var fileData = new FormData();     
    formData.append("file_name", blob,'ssfc0.cos');
    
    //vypise vsetky kluce a hodnoty ulozene vo formData
    //for(var pair of formData.entries()) {console.log(pair[0]+ ', '+ pair[1]);}    
    
    createEventSource(); 
    
    $(function() {
      $.ajax({
        type: "POST",
        url: 'http://' + HOST + '/sciengine/engine/compute',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data, textStatus, jqXHR) {
           if (textStatus == 'success')//typeof data.status == 'ok')
            { //console.log(data);
              var msg = JSON.parse(data);
              //console.log(msg.response);
              closeEventSource();
              //allDataString = msg.response.raw;
              var allDataResult = convertScicosData(msg.response.raw);
              var dataset1 = generateDataset(allDataResult,1,"y");
              var dataset2 = generateDataset(allDataResult,2,"u");
              console.log(dataset1);
              //https://community.plot.ly/t/remove-options-from-the-hover-toolbar/130/2
              //toImage,sendDataToCloud,zoom2d,pan2d,select2d,lasso2d,zoomIn2d,zoomOut2d,autoScale2d,resetScale2d,hoverClosestCartesian,hoverCompareCartesian,zoom3d,pan3d,orbitRotation,tableRotation
              Plotly.newPlot($('#plotdiv1')[0], dataset1,layout1, {modeBarButtonsToRemove: ['sendDataToCloud','pan2d','zoomIn2d','zoomOut2d'],displaylogo: false});
              //$('#chartdiv')[0] je ekvivalent k document.getElementById('chartdiv'); pozri http://stackoverflow.com/questions/4069982/document-getelementbyid-vs-jquery
              Plotly.addTraces($('#plotdiv1')[0], dataset2);
              Plotly.newPlot($('#plotdiv2')[0], dataset2,layout2, {modeBarButtonsToRemove: ['sendDataToCloud','pan2d','zoomIn2d','zoomOut2d'],displaylogo: false}); 
            }
           else 
            { // Handle errors here
              console.log('ERRORS: ' + data.error);
              closeEventSource();     
            } }, 
        error: function(req, err){ console.log('my message: ' + err); }                
        });     
    });     
 
  }
};
xhr.send();

    </script>  
  </body>
</html>
