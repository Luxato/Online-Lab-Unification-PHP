var w = 300;
var h = 500;
var animData = [];
var rychlostData = [];
var poc=0;
var y=0;
var p=0.7;
var upravaGrafu=0;
var pomocnePreGraf1=[];
var pomocnePreGraf2=[];
var pocetHodnot;
var globMin;
var globMax;

function setDef(){
    
    var def=[40,10,20,2,5,0,20,200];
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



    var rychMax=rychlostData[0][1];
    
    for (var i = 1; i < rychlostData.length; i++) {
        if (rychlostData[i][1]>rychMax)rychMax=rychlostData[i][1];
    };

    if(animMax>rychMax)globMax=animMax;
    else globMax=rychMax;

    globMax=globMax+5;


   
    var animMin=animData[0][1];
    
    for (var i = 1; i < animData.length; i++) {
        if (animData[i][1]<animMin)animMin=animData[i][1];
    };



    var rychMin=rychlostData[0][1];
    
    for (var i = 1; i < rychlostData.length; i++) {
        if (rychlostData[i][1]<rychMin)rychMin=rychlostData[i][1];
    };

    if(animMin<rychMin)globMin=animMin;
    else globMin=rychMin;

    globMin=globMin-3;

}


function spracuj(pozicie,rychlosti,poleVstupov,cas){
    //alert(pozicie);
    //alert(rychlosti);
    //alert(poleVstupov);
    //alert(cas);
   
    var form=document.getElementById("myForm");
    
    for (var g=1; g<form.length-1; g++){
        form.elements[g].value=poleVstupov[g-1];
    }

    pocetHodnot=cas[cas.length-1];

    contentHolder = document.getElementById('content-holder');

	var canvas = document.createElement('canvas');
    canvas.setAttribute('id','animacia');
    canvas.setAttribute("width", w * p);
    canvas.setAttribute("height", h * p);
    contentHolder.appendChild(canvas);


    var graf = document.createElement('div');
    graf.setAttribute('id','chartdiv');
    graf.setAttribute("style","width:450px;height:300px;");
    contentHolder.appendChild(graf);
 
    spravDatka(pozicie,rychlosti,cas);
    setMaM();
    kresli();
    vykresliGraf();

}



function spravDatka(pozicie,rychlosti,cas){
    
    for (var i = 0; i < pozicie.length; i++) {
         animData.push([cas[i], parseFloat(pozicie[i])]);
    }

    for (var i = 0; i < rychlosti.length; i++) {
         rychlostData.push([cas[i], parseFloat(rychlosti[i])]);
    }

 
}

function kresli(){
	var canvas = document.getElementById('animacia');
    var context = canvas.getContext('2d');
    

    setInterval(function () {
        animuj(canvas, context);
        
    }, 100);

}


function animuj(canvas, context) {
    
    context.clearRect(0, 0, canvas.width, canvas.height);

    y = ((animData[poc][1]) * 100)/4;
  

    var dlzkaAnimDat=animData.length;
    var dlzkaRychlostData=rychlostData.length;

    if(upravaGrafu>=dlzkaAnimDat)upravaGrafu=dlzkaAnimDat;
    if(upravaGrafu>=dlzkaRychlostData)upravaGrafu=dlzkaRychlostData;
    
        pomocnePreGraf1.push(animData[upravaGrafu]);
        pomocnePreGraf2.push(rychlostData[upravaGrafu]);
        
        updatniGraf(pomocnePreGraf1,pomocnePreGraf2);
        upravaGrafu++;
        


    //alert(y);
    //left,right,up,down,canva,context,weigh,high,parameter
    kresliMur(0,0,1,0,canvas,context,w,h,p);
    //x,y,sirka,vyska,canvas, context,p
    kresliTeleso(112,y,75,40,canvas,context,p);
    //xzaciatok, yzaciatok koli muru,ykonec,canvas,context,p
    kresliPruzinu(125,0+30,y,canvas,context,p);
    //xzaciatok, yzaciatok koli muru,ykonec,canvas,context,p
    kresliTlmic(170,0+30,y,canvas,context,p);
    
    //ked dojde na konec pozici tak aby nezmizla animacia vykresluje sa stale posledna hodnota z pola pozicii
    poc++;
    if (poc === animData.length){
        poc--;
    }
}

function updatniGraf(doGrafu1,doGrafu2){

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
    $.plot("#chartdiv", [{label: "Poloha", data:doGrafu1},{label: "Rýchlosť", data:doGrafu2}],options);
}


function  vykresliGraf(){
    $(document).ready(function(){
        $('#chartdiv').show();
    });
}