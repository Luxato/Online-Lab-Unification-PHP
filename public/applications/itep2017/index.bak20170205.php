<!DOCTYPE html>           
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>ITEP2017</title>
    <link rel="stylesheet" type="text/css" href="css/jquery.jqplot.min.css">
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.jqplot.min.js"></script>
    <script src="js/plotly-latest.min.js"></script>
<!--    <script src="js/sse.js"></script> -->
     <script src="js/sse.js"></script>

  </head>

  <body>
    hop 
    <div id="chartdiv" style="width:600px;height:250px;"></div>
    
    
      <script>   

var allDataString, allDataStringOld;

//http://stackoverflow.com/questions/7848004/get-column-from-a-two-dimensional-array-in-javascript
function getCol(matrix, col){
   var column = [];
   for(var i=0; i<matrix.length; i++){
      column.push(matrix[i][col]);
   }
   return column;
}

function convertScicosData(allDataString){
   allDataString = allDataString.replace(/ /g, '');  //odstrani medzery        
   //.replace(/\s/g, ''); //odstrani aj nove riadky
   allDataString = allDataString.replace(/\n/,''); //odstrani prvy vrateny pradny riadok
                
   var allDataObj = allDataString.replace( /\n\n/g, "|" ).split( "|" )
   var allDataLength = allDataObj.length;
    
   var allDataResult = [];            
   for (let i = 0; i < allDataLength ; i++) {
      var oneStepDataObj = allDataObj[i].split(/\n/);  
      var oneStepDataLength = oneStepDataObj.length;
      var oneStepDataResult = [];
      for (let j = 0; j < oneStepDataLength; j++) {
         oneStepDataResult[j]=eval(oneStepDataObj[j]);
      }   
      //console.log(oneStepDataResult);
   allDataResult[i]=oneStepDataResult;
   }
   return allDataResult;
}

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
    


//http://www.henryalgus.com/reading-binary-files-using-jquery-ajax/
var xhr = new XMLHttpRequest();
xhr.open('GET', 'ssfc.cos', true);
xhr.responseType = 'blob';
xhr.onload = function(e) {
  if (this.status == 200) {
    // get binary data as a response
    var blob = this.response;
    //console.log(blob);        
    
    var fileData = new FormData();     
    formData.append("file_name", blob,'ssfc.cos');
    
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
                { //console.log(typeof(data));
                  //console.log(data);
                var msg = JSON.parse(data);
                //console.log(msg.response);
                closeEventSource();
                //allDataString = msg.response.raw;
                var allDataResult = convertScicosData(msg.response.raw);
                
      //          console.log(allDataResult);
      //          console.log(getCol(allDataResult, 0));
                //$('#chartdiv').html('');
                //$.jqplot('chartdiv', [getCol(allDataResult, 1),getCol(allDataResult, 2)]);
                var dataset1 = eval("[{x: ["+getCol(allDataResult, 0).slice(1, -1)+"],\n y: ["+getCol(allDataResult, 1).slice(1, -1)+"],\n name: 'y', }]");
                console.log(dataset1);
                var dataset2 = eval("[{x: ["+getCol(allDataResult, 0).slice(1, -1)+"],\n y: ["+getCol(allDataResult, 2).slice(1, -1)+"],\n name: 'u', }]");

                TESTER = document.getElementById('chartdiv');
                var layout = {
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
                Plotly.newPlot(TESTER, dataset1,layout);
                Plotly.addTraces(TESTER, dataset2); 
                //Plotly.plot($('#chartdiv'), dataset);
                }
                else {
                    // Handle errors here
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
