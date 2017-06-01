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
   allDataString = allDataString.replace(/D /g, 'E');  //odstrani medzery       
   //.replace(/\s/g, ''); //odstrani aj nove riadky
   allDataString = allDataString.replace(/\n/,''); //odstrani prvy vrateny prazdny riadok
                
   var allDataObj = allDataString.replace( /\n\n/g, "|" ).split( "|" )
   var allDataLength = allDataObj.length;
    
   var allDataResult = [];            
   for (let i = 0; i < allDataLength ; i++) {
      var oneStepDataObj = allDataObj[i].split(/\n/);  
      var oneStepDataLength = oneStepDataObj.length;
      var oneStepDataResult = [];
      for (let j = 0; j < oneStepDataLength; j++) {
         oneStepDataResult[j]=Number(oneStepDataObj[j]);
      }   
      //console.log(oneStepDataResult);
   allDataResult[i]=oneStepDataResult;
   }
   return allDataResult;
}

function generateDataset(allDataResult,n,name){
//allDataResult - dvojdimenzionalne pole, kde prvy stlpec je cas a dalsie stlpce predstavuju premenne, ktore chceme vynasat do grafu
//n - cislo poradia stlpca, ktory chceme spolu s casom dostat na vystup funkcie a potom vykreslit; vektor casu netreba vyznacovat, berie sa automaticky tiez
//name - meno pre dataset, toto meno sa zobrazi aj na grafe, ak tam je viac ako 1 vykreslena zavislost
var dataset = "[{x: ["+getCol(allDataResult, 0).slice(1, -1)
              +"],\n y: ["+getCol(allDataResult, n).slice(1, -1)
              +"],\n name: '"+name
              +"', }]";
return eval(dataset);
}

//http://stackoverflow.com/questions/13752984/html5-file-api-downloading-file-from-server-and-saving-it-in-sandbox
//http://baxincc.cc/questions/104804/html5-file-api-downloading-file-from-server-and-saving-it-in-sandbox
//https://crosswalk-project.org/jira/browse/XWALK-3864
function downloadFile(url, success) {
    var xhr = new XMLHttpRequest(); 
    xhr.open('GET', url, true); 
    xhr.responseType = "blob";
    xhr.onreadystatechange = function () { 
        if (xhr.readyState == 4) {
            if (success) success(xhr.response);
        }
    };
    xhr.send(null);
}

function generatePlot(filename,formData,param,opt){
//http://www.henryalgus.com/reading-binary-files-using-jquery-ajax/
  var xhr = new XMLHttpRequest();
  xhr.open('GET', filename, true);
  xhr.responseType = 'blob';
  xhr.onload = function(e) {
    if (this.status == 200) {
      // get binary data as a response
      var blob = this.response;
      //console.log(blob);        
       
      formData.append("file_name", blob,filename);
      if (formData.has("simulation_parameters")) {formData.delete("simulation_parameters");}
      formData.append("simulation_parameters", param);
      //vypise vsetky kluce a hodnoty ulozene vo formData
      for(var pair of formData.entries()) {console.log(pair[0]+ ', '+ pair[1]);}    
      
      createEventSource(); 
      
     // $(function() {
        $.ajax({
          type: "POST",
          url: 'http://' + HOST + '/sciengine/engine/compute',
          //async: false,
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
               
                if (opt === "new")
                {
                Plotly.newPlot($('#plotdiv1')[0], dataset1,layout1, {modeBarButtonsToRemove: ['sendDataToCloud','pan2d','zoomIn2d','zoomOut2d'],displaylogo: false});
                //$('#chartdiv')[0] je ekvivalent k document.getElementById('chartdiv'); pozri http://stackoverflow.com/questions/4069982/document-getelementbyid-vs-jquery
                Plotly.newPlot($('#plotdiv2')[0], dataset2,layout2, {modeBarButtonsToRemove: ['sendDataToCloud','pan2d','zoomIn2d','zoomOut2d'],displaylogo: false});
                }
                else
                {
                Plotly.addTraces($('#plotdiv1')[0], dataset1);
                Plotly.addTraces($('#plotdiv2')[0], dataset2);
                } 
              }
             else 
              { // Handle errors here
                console.log('ERRORS: ' + data.error);
                closeEventSource();     
              } }, 
          error: function(req, err){ console.log('my message: ' + err); }                
          });     
     // });     
   
    }
  };
  xhr.send();
}