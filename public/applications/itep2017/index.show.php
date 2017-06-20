    <script src="<?= $path ?>../common_assets/plotly-latest.min.js"></script>
    <script src="<?= $path ?>js/sse.js"></script>
    <script src="<?= $path ?>js/functions.js"></script>
    <script>
        var baseUrl = '<?= $path ?>';
    </script>
    <script>    
    $(function() 
    { var simNo = 1;  
      $("#parController").change(function(e) 
        { e.preventDefault(); 
           var src = ($("#blockScheme").attr('src') === baseUrl + 'pics/sffc1.png')
            ? baseUrl +'pics/dffc1.png'
            : baseUrl +'pics/sffc1.png';
          $("#blockScheme").attr("src",src);
        });
      
      $("#addNewSimButton").click(function(e) 
        { e.preventDefault();        //toto zabrani znovunacitaniu stranky, http://encosia.com/button-click-handlers-ajax-premature-submission
      var HOST = '147.175.105.140:8011'; // :8011  //147.175.105.140
      var API_KEY = 'c0a082896a8c2f946ea7f67d3ae39c41';
      $('.plots').fadeIn('slow');
      var layout1 = {
            title: 'System output',
            titlefont: {
                    //family: 'Courier New, monospace',
                    size: 14,
                    //color: '#7f7f7f'
                  },
            margin: { t: 30, b:40 },
            xaxis: {
              title: 'time',
             // range: [0,30]
            },
            yaxis: {
              title: 'y(t)',
              //range: [0,1.6]
            }
          };
      var layout2 = {
            title: 'Control variable',
            titlefont: {
                    //family: 'Courier New, monospace',
                    size: 14,
                    //color: '#7f7f7f'
                  },            
            margin: { t: 40, b:40 },
            xaxis: {
              title: 'time',
            //  range: [0,30]
            },
            yaxis: {
              title: 'u(t)',
           //   range: [-1,1]
            }
          };    
    //console.log(parseFloat($('#parA').val()));
    var controllerType = $('#parController').val();
    var fileName;
    switch (controllerType) {
        case "sffc":
            fileName = baseUrl+"sffc0.cos";
            break;
        case "dffc":
            fileName = baseUrl+"dffc0.cos";
            break;
    }
    //console.log(fileName);
    var param = "Ks="+parseFloat($('#parKS').val())+",a="+parseFloat($('#parA').val());
    param=param+",Td="+parseFloat($('#parTD').val())+",Tf="+parseFloat($('#parTF').val());
    param=param+",Umin="+parseFloat($('#parUMIN').val())+",Umax="+parseFloat($('#parUMAX').val());
    param=param+",w="+parseFloat($('#parW').val())+",tw="+parseFloat($('#parTW').val());
    param=param+",vi="+parseFloat($('#parVI').val())+",ti="+parseFloat($('#parTI').val());
    param=param+",vo="+parseFloat($('#parVO').val())+",to="+parseFloat($('#parTO').val());
    var params=param+",tsim="+parseFloat($('#parTSIM').val());
    //console.log(param);   
    
    var formData = new FormData(); 
    formData.append("engine", "scicoslab");
    formData.append("data_type", "simulation");
    formData.append("formula_output", "raw");
    formData.append("variable_list", "");
    formData.append("advanced_features", "yes");
    //formData.append("simulation_parameters", "Ks=1,a=0.5,Td=1,Tf=0.5,Umin=-10,Umax=10,w=1,tw=1,vi=0,ti=0,vo=0,to=0");
    formData.append("simulation_parameters", params);
    formData.append("code", "");
    formData.append("graphic_figure", "");
    formData.append("api_key", API_KEY);  
    formData.append("source", 'js');//vyuzite pri SSE
    
    //http://www.henryalgus.com/reading-binary-files-using-jquery-ajax/
    var xhr = new XMLHttpRequest();
    xhr.open('GET', fileName, true);
    xhr.responseType = 'blob';
    xhr.onload = function(e) {
      if (this.status == 200) {
        // get binary data as a response
        var blob = this.response;
        //console.log(blob);        
        
        var fileData = new FormData();     
        formData.append("file_name", blob, fileName);
        
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
//                  var dataset1 = generateDataset(allDataResult,1,controllerType+", a="+parseFloat($('#parA').val()));
//                  var dataset2 = generateDataset(allDataResult,2,controllerType+", a="+parseFloat($('#parA').val()));
                  var dataset1 = generateDataset(allDataResult,1,controllerType+", set: "+simNo);
                  var dataset2 = generateDataset(allDataResult,2,controllerType+", set: "+simNo);

                  //console.log(dataset1);
                  //https://community.plot.ly/t/remove-options-from-the-hover-toolbar/130/2
                  //toImage,sendDataToCloud,zoom2d,pan2d,select2d,lasso2d,zoomIn2d,zoomOut2d,autoScale2d,resetScale2d,hoverClosestCartesian,hoverCompareCartesian,zoom3d,pan3d,orbitRotation,tableRotation
    if( $('#plotdiv1').is(':empty') ) {
                  Plotly.newPlot($('#plotdiv1')[0], dataset1,layout1, {modeBarButtonsToRemove: ['sendDataToCloud','pan2d','zoomIn2d','zoomOut2d'],displaylogo: false});
                  //$('#chartdiv')[0] je ekvivalent k document.getElementById('chartdiv'); pozri http://stackoverflow.com/questions/4069982/document-getelementbyid-vs-jquery
                  Plotly.newPlot($('#plotdiv2')[0], dataset2,layout2, {modeBarButtonsToRemove: ['sendDataToCloud','pan2d','zoomIn2d','zoomOut2d'],displaylogo: false}); 
                  $('<p>set '+simNo+': '+param+'</p>').appendTo('#textdiv');
                  simNo++;
    }
    else
    {
                  Plotly.addTraces($('#plotdiv1')[0], dataset1);
                  Plotly.addTraces($('#plotdiv2')[0], dataset2);
                  $('<p>set '+simNo+': '+param+'</p>').appendTo('#textdiv');
                  simNo++;
    }
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



                             });  
                                  
});  
                              
                             
    
    </script>
    <style>
    label,input {width:50px; height: 20px; display:inline-block;}
    .input-group-addon { width: 50px; text-align:left; }
    .plots {width: 100%; max-width: 710px; margin: 0 auto;}
    .input-group {
        margin: 5px 0;
    }
    .plots {
        display: none;
    }
    </style>


   <div class="" style="margin-top: 30px;padding-top: 15px;">
    <div class="input-group"> 
      <span class="input-group-addon">Select block scheme</span>
      <select id="parController" class="form-control">
        <option value="sffc">Static feed forward control</option>
        <option value="dffc">Dynamic feed forward control</option>
      </select> 
    </div>
  <div class="row"> 
      <div class="col-xs-12 col-sm-6 col-lg-6">
      <div  style="padding:40px 0 20px;">
         <img id="blockScheme" class="img-responsive" src="<?= $path ?>pics/sffc1.png" alt="schema">
      </div> 
    </div>
<div class="form-horizontal">  
  <div class="col-xs-6 col-sm-3 col-lg-3">
  <div class="input-group">
    <span class="input-group-addon">K<sub>&nbsp;s</sub></span>
    <input id="parKS" type="text" value="1" class="form-control">
  </div>
  <div class="input-group">
    <span class="input-group-addon">a</span>
    <input id="parA" type="text" value="0.5" class="form-control">
  </div> 
  <div class="input-group">
    <span class="input-group-addon">T<sub>&nbsp;d</sub></span>
    <input id="parTD" type="text" value="1" class="form-control">
  </div> 
  <div class="input-group">
    <span class="input-group-addon">T<sub>&nbsp;f</sub></span>
    <input id="parTF" type="text" value="0.5" class="form-control">
  </div> 
  <div class="input-group">
    <span class="input-group-addon">U<sub>&nbsp;1</sub></span>
    <input id="parUMIN" type="text" value="-10" class="form-control">
  </div> 
  <div class="input-group">
    <span class="input-group-addon">U<sub>&nbsp;2</sub></span>
    <input id="parUMAX" type="text" value="10" class="form-control">
  </div>  
  
     <div style="margin: 10px 0 0 0;">
  <div class="input-group">
    <span class="input-group-addon">t<sub>&nbsp;sim</sub></span>
    <input id="parTSIM" type="text" value="30" class="form-control">
  </div> 
     </div>
   </div>
  
    
    <div class="col-xs-6 col-sm-3 col-lg-3">     
  <div class="input-group">
    <span class="input-group-addon">w</span>
    <input id="parW" type="text" value="1" class="form-control">
  </div>
  <div class="input-group">
    <span class="input-group-addon">t<sub>&nbsp;w</sub></span>
    <input id="parTW" type="text" value="1" class="form-control">
  </div> 
  <div class="input-group">
    <span class="input-group-addon">d<sub>&nbsp;i</sub></span>
    <input id="parVI" type="text" value="0" class="form-control">
  </div> 
  <div class="input-group">
    <span class="input-group-addon">t<sub>&nbsp;i</sub></span>
    <input id="parTI" type="text" value="0" class="form-control">
  </div> 
  <div class="input-group">
    <span class="input-group-addon">d<sub>&nbsp;o</sub></span>
    <input id="parVO" type="text" value="0" class="form-control">
  </div> 
  <div class="input-group">
    <span class="input-group-addon">t<sub>&nbsp;o</sub></span>
    <input id="parTO" type="text" value="0" class="form-control">
  </div>
     <div style="margin: 10px 0 0 0;text-align:center">
      <button id="addNewSimButton" class="btn btn-success">Spustiť simuláciu</button>
     </div>
     
     </div>
  

    </div>  
</div>     
<div class="plots" class="row">     
    <div id="plotdiv1" style="width:100%;max-width:700px;height:200px;margin-top:20px;"></div>
    <div id="plotdiv2" style="width:100%;max-width:700px;height:200px;margin-top:20px;"></div>
</div>
   </div>