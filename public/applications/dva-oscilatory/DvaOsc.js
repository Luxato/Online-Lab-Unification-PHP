var w = 500;
var h = 700;

var animData=[];
var animData2=[];

var rychlostData=[];
var rychlostData2=[];

var poc=0;
var p=0.8;

var upravaGrafu=0;
var pomocnePreGraf1anim=[];
var pomocnePreGraf2anim=[];
var pomocnePreGraf1rych=[];
var pomocnePreGraf2rych=[];

var pocetHodnot;
var globMin;
var globMax;


function setDef(){
    
    var def=[40,15,25,8,10,0,10,40,2,5,0,20,200];
    var form=document.getElementById("myForm");
    
    for (var g=1; g<form.length-1; g++){
        form.elements[g].value=def[g-1];
    }
}


function setMaM(){
    var animMax=animData[0][1];
    
    for (var i = 1; i < animData.length; i++) {
        if (animData[i][1]>animMax)animMax=animData[i][1];
    };

    var animMax2=animData2[0][1];
    
    for (var i = 1; i < animData2.length; i++) {
        if (animData2[i][1]>animMax2)animMax2=animData2[i][1];
    };


    if(animMax>animMax2)animMax=animMax;
    else animMax=animMax2;



    var rychMax=rychlostData[0][1];
    
    for (var i = 1; i < rychlostData.length; i++) {
        if (rychlostData[i][1]>rychMax)rychMax=rychlostData[i][1];
    };

    var rychMax2=rychlostData2[0][1];
    
    for (var i = 1; i < rychlostData2.length; i++) {
        if (rychlostData2[i][1]>rychMax2)rychMax2=rychlostData2[i][1];
    };


    if(rychMax>rychMax2)rychMax=rychMax;
    else rychMax=rychMax2;
    
    if(animMax>rychMax)globMax=animMax;
    else globMax=rychMax;

    globMax=globMax+15;
////////////////////////////////////////////////////
   
    var animMin=animData[0][1];
    
    for (var i = 1; i < animData.length; i++) {
        if (animData[i][1]<animMin)animMin=animData[i][1];
    };

    var animMin2=animData2[0][1];
    
    for (var i = 1; i < animData2.length; i++) {
        if (animData2[i][1]<animMin2)animMin2=animData2[i][1];
    };


    if(animMin<animMin2)animMin=animMin;
    else animMin=animMin2;

    var rychMin=rychlostData[0][1];
    
    for (var i = 1; i < rychlostData.length; i++) {
        if (rychlostData[i][1]<rychMin)rychMin=rychlostData[i][1];
    };

    var rychMin2=rychlostData2[0][1];
    
    for (var i = 1; i < rychlostData2.length; i++) {
        if (rychlostData2[i][1]<rychMin2)rychMin2=rychlostData2[i][1];
    };

    
    if(rychMin<rychMin2)rychMin=rychMin;
    else rychMin=rychMin2;

    if(animMin<rychMin)globMin=animMin;
    else globMin=rychMin;

    globMin=globMin-3;
    

}


function spracuj(poloha1,rychlost1,poloha2,rychlost2,poleVstupov,cas){
    //alert(poloha1[0]);
    //alert(rychlost1);
    //alert(poloha2);
    //alert(rychlost2);
    

    var form=document.getElementById("myForm");
    
    for (var g=1; g<form.length-1; g++){
               form.elements[g].value=poleVstupov[g-1];
    }
    
    pocetHodnot=cas[cas.length-1];
    //alert(pocetHodnot);


    contentHolder = document.getElementById('content-holder');

    
    var canvas = document.createElement("canvas");
    canvas.setAttribute("id", "animacia");
    canvas.setAttribute("width", w * p);
    canvas.setAttribute("height", h * p);
    contentHolder.appendChild(canvas);

    var graf = document.createElement('div');
    graf.setAttribute('id','chartdiv');
    graf.setAttribute("style","width:450px;height:300px;");
    contentHolder.appendChild(graf);
    
    spravDatka(poloha1,rychlost1,poloha2,rychlost2,cas);
    setMaM();
    kresli();
    vykresliGraf();

    
}

function spravDatka(poloha1,rychlost1,poloha2,rychlost2,cas){
     for (var i=0; i<poloha1.length; i++){ 
      animData.push([cas[i], parseFloat(poloha1[i])]); 
      animData2.push([cas[i], parseFloat(poloha2[i])]);
      rychlostData.push([cas[i], parseFloat(rychlost1[i])]); 
      rychlostData2.push([cas[i], parseFloat(rychlost2[i])]); 
  }
}

function kresli(){
    var canvas = document.getElementById("animacia");
    var context = canvas.getContext("2d");
    
    var teleso1 ={
        x: 200,
        y: 45,
        width: 70,
        height: 35
      };
      
      var teleso2 ={
        x: 200,
        y: 45,
        width: 70,
        height: 35
      };
    
setInterval(function(){
                        animuj(teleso1,teleso2,context,canvas);
                       },
            100);
}

function animuj(teleso1,teleso2,context,canvas){
context.clearRect(0, 0, canvas.width, canvas.height);
//context.lineWidth = 1;
teleso2.y=(animData[poc][1]*100)/4;
teleso1.y=(animData2[poc][1]*100)/4;


var dlzkaAnimDat=animData.length;
var dlzkaRychlostData=rychlostData.length;

    if(upravaGrafu>=dlzkaAnimDat)upravaGrafu=dlzkaAnimDat;
    if(upravaGrafu>=dlzkaRychlostData)upravaGrafu=dlzkaRychlostData;
    
        pomocnePreGraf1anim.push(animData[upravaGrafu]);
        pomocnePreGraf2anim.push(animData2[upravaGrafu]);
        
        pomocnePreGraf1rych.push(rychlostData[upravaGrafu]);
        pomocnePreGraf2rych.push(rychlostData2[upravaGrafu]);
        
        updatniGraf(pomocnePreGraf1anim,pomocnePreGraf2anim,pomocnePreGraf1rych,pomocnePreGraf2rych);
        upravaGrafu++;



kresliMur(0,0,1,0,canvas,context,w,h,p);
kresliTeleso(teleso1.x,teleso1.y,teleso1.width,teleso1.height,canvas, context,p);
kresliTeleso(teleso2.x,teleso2.y,teleso2.width,teleso2.height,canvas, context,p);
//xzaciatok, yzaciatok koli muru,ykonec,canvas,context,p
    kresliTlmic(teleso1.x+20,0+30,teleso1.y,canvas,context,p);
    kresliTlmic(teleso2.x+20,teleso1.y+teleso1.height,teleso2.y,canvas,context,p);

    //xzaciatok, yzaciatok koli muru,ykonec,canvas,context,p
    kresliPruzinu(teleso1.x+60,0+30,teleso1.y,canvas,context,p);
    kresliPruzinu(teleso2.x+60,teleso1.y+teleso1.height,teleso2.y,canvas,context,p);






poc++;
if(poc===animData.length){poc--;}
}


function updatniGraf(doGrafu1,doGrafu2,doGrafu3,doGrafu4){

   // var clear=[[0,0]];
    
    var options= {
        xaxis:{
            max:pocetHodnot
        },
        yaxis:{
            min: globMin,
            max: globMax
        }
    };
    //$.plot("#chartdiv", [{label: "Poloha", data:clear},{label: "Rýchlosť", data:clear}]);
    $.plot("#chartdiv", [{label: "Poloha nižšieho telesa", data:doGrafu1},{label: "Poloha vyššieho telesa", data:doGrafu2},{label: "Rýchlosť nižšieho telesa", data:doGrafu3},{label: "Rýchlosť vyššieho telesa", data:doGrafu4}],options);
}


function  vykresliGraf(){
    $(document).ready(function(){
        $('#chartdiv').show();
    });
}


