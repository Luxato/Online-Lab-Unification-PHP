
function dampedHarmonicOscillator(canvas,context,y)
{ body = { x: 112,  y: 45,  width: 75,  height: 40 };
  spring = { x: 125,  ystart: 0+30 };
  damper = { x: 170,  ystart: 0+30 };
    drawWall(0,0,1,0,canvas,context,width,height,p);
    drawBody(body.x,y,body.width,body.height,canvas,context,p);
    drawSpringVertical(spring.x,spring.ystart,y,canvas,context,p);
    drawDamperVertical(damper.x,damper.ystart,y,canvas,context,p);
}

function twoWagons(canvas,context,x1,x2)
{ body1 = { x: 200, y: 173, width: 120, height: 70 };
  body2 = { x: 200, y: 173, width: 120, height: 70 };
    drawWall(1,0,0,1,canvas,context,width,height,p);
    drawWagon(x1,body1.y,body1.width,body1.height,canvas, context,p,12);
    drawWagon(x2,body2.y,body2.width,body2.height,canvas, context,p,12);
    drawDamperHorizontal(0+20,body1.y+20,x1,canvas,context,p);
    drawDamperHorizontal(x1+120,body2.y+20,x2,canvas,context,p);
    drawSpringHorizontal(0+20,body1.y+50,x1,canvas,context,p);
    drawSpringHorizontal(x1+120,body2.y+50,x2,canvas,context,p);
}

function beamAndBall(canvas,context,tu,prey)
{ 
  mot=100*d;klada=100*L;polomerLopty=R*100+10;   
  drawWall(0,0,0,1,canvas,context,width,height,p);
  drawWallVertical(100,190-2*mot,canvas,context,270,p);
  drawWallVertical(100+klada,190,canvas,context,270,p);
  whiteCircle(110+klada,190,mot,canvas,context,p);
  drawWheel(110+klada,190,canvas,context,p,mot);
  
  x1= 110+klada + mot*Math.cos(u);
  y1= 190 - mot*Math.sin(u);
  drawRod(110+klada,y1-mot-mot,x1,y1,canvas,context,p,4,"black");
  context.lineWidth = 1;

  rozdiel=Math.abs(y1-190)/2;

  drawRod(110+klada,y1-2*mot,110,190-2*mot,canvas,context,p,6,"black");
  context.lineWidth = 1;

  whiteJoint(x1,y1,7,canvas,context,p);               //motor
  whiteJoint(110+klada,y1-2*mot,7,canvas,context,p);      //rod
  whiteJoint(110,190-2*mot,15,canvas,context,p);

  xl=110+klada/2+tu;
  yl=190-2*mot-(prey*rozdiel)-polomerLopty;
    
  yl=yl+(animationStep*(rozdiel*2)/klada);
  if(xl<100){xl=(100-polomerLopty);yl=(height-30-polomerLopty);}
  if(xl>(100+klada+20)){xl=(100+klada+20+polomerLopty);yl=(height-30-polomerLopty);}
  drawBall(xl,yl-3,canvas,context,p,polomerLopty);
}

function runAnim(model,data,column)
{ contentHolder = document.getElementById('content-holder');
  var canvas = document.createElement('canvas');
    canvas.setAttribute('id','animateID');
    canvas.setAttribute("width", width * p);
    canvas.setAttribute("height", height * p);
  contentHolder.appendChild(canvas);
  animData=$.makeArray(data);
  drawModel('animateID',model,animData,column);
}

function drawModel(canvasID,model,animData,column)
{	var canvas = document.getElementById(canvasID);
  var context = canvas.getContext('2d');
  setInterval(function () {animateModel(canvas,context,model,animData,column);}, 100);
}

function animateModel(canvas,context,model,animData,column) 
{ context.clearRect(0, 0, canvas.width, canvas.height);
  switch (model) 
  { case "dampedHarmonicOscillator":
      y = (animData[column][animationStep] * 100)/4;
      eval(model+'(canvas,context,y)');
      break;
    case "twoWagons":
      c1=1;
      c2=3;
      x1=(animData[c1][animationStep]*100)/4+(width/7);
      x2=(animData[c2][animationStep]*100)/4+(width/7)*3;
      eval(model+'(canvas,context,x1,x2)');
      break;
    case "beamAndBall":
      if(u<3.14){tu=(-1)*animData[column][animationStep];prey=1;} else {tu=animData[column][animationStep];prey=(-1);}
      eval(model+'(canvas,context,tu,prey)');
      break;
    default:
      alert("Sorry");
  }
  animationStep++;
  if (animationStep === animData[1].length) {animationStep--;}
}

///////////////////////////////////////////////////////////////////////


//left,right,up,down,canva,context,weigh,high,parameter
function drawWall(l,r,u,d,canvas,context,w,h,p)
{	var krok= 20*p;
	if(l==1)
  { context.beginPath();
    context.fillStyle = '#e5e5e5';
    context.rect(0,0,krok,h*p);
    context.fill();
    var poc=0; //dalsie pocitadlo preto lebo ak p=2 tak modulo uz nefunguje  
    var f=15*p; //aby ta horna nebola obtiahnuta pretp + 15
    while(f<h*p)
    { context.moveTo(0,f);
      context.lineTo(krok,f);
      if (poc%2===0)
      { context.moveTo(krok*0.65,f);
        context.lineTo(krok*0.65,f-15*p) 
      };
    poc++; 
    f=f+15*p;
    }
    context.stroke();
  }
  if(r==1)
  { context.beginPath();
    context.fillStyle = '#e5e5e5';
    context.rect(w*p-krok,0,krok,h*p);
    context.fill();
    context.moveTo(w*p, 0);
    context.lineTo(p*w,h*p);     
    var poc=0; //dalsie pocitadlo preto lebo ak p=2 tak modulo uz nefunguje  
    var f=15*p; //aby ta horna nebola obtiahnuta pretp + 15
    while(f<h*p)
    { context.moveTo(w*p-krok,f);
      context.lineTo(w*p,f);
      if (poc%2===0)
      { context.moveTo(w*p-krok+krok*0.65,f);
        context.lineTo(w*p-krok+krok*0.65,f-15*p) 
      };
      poc++; 
      f=f+15*p;
    }
    context.stroke();
  }
  if(u==1){

	context.beginPath();
	

    context.fillStyle = '#e5e5e5';
    context.rect(0,0,w*p,30*p);
    context.fill();


    
    context.moveTo(0, 15*p);
    context.lineTo(p*w,15*p); // stredna ciara

	var opak= (p*w)/krok;
	for (var i = 0; i < opak; i++) {
       context.moveTo((krok*i),15*p);
       if(i%2===0){
           context.lineTo(krok*i,30*p);
           context.moveTo((krok*i),15*p);
       }
       
       if(i%2===1){
           context.lineTo(krok*i,0);
           context.moveTo((krok*i),15*p);
       }
    }

    
    context.stroke();
}


if(d==1){
    context.beginPath();
    
    context.fillStyle = '#e5e5e5';
    context.rect(0,h*p-30*p,w*p,30*p);
    context.fill();


    
    context.moveTo(0, (h-15)*p);
    context.lineTo(p*w,(h-15)*p);//stredna ciara
    
    var opak= (p*w)/krok;
    
    for (var i = 0; i < opak; i++) {
       context.moveTo((krok*i),(h-15)*p);
       if(i%2===0){
           context.lineTo(krok*i,(h-30)*p);
           context.moveTo((krok*i),(h-30)*p);
       }
       
       if(i%2===1){
           context.lineTo(krok*i,(h*p));
           context.moveTo((krok*i),(h-15)*p);
       }
    }
   
    context.stroke();
}
}

function drawBody(x,y,sirka,vyska,canvas, context,p)
{ context.beginPath();
  context.rect(x*p, y*p, sirka*p, vyska*p);
  context.fillStyle = '#f2dede';
  context.fill();
  context.strokeStyle = 'black';
  context.stroke();
}

function drawDamperVertical(xzaciatok, yzaciatok,ykonec,canvas,context,p){

   // if(ykonec<=yzaciatok){alert("TLMIC ykonec musi byt vacsie ako yzaciatok, kresli sa z hore dole");return;}


  context.beginPath();


  

//v tele
//  var y=(ykonec*p-yzaciatok*p+150*p)/5;
// // if((ykonec*p)/5+30*p > yzaciatok*p+50*p) y=yzaciatok*p+49*p;
//   context.moveTo(xzaciatok*p-10*p,y);
//   context.lineTo((xzaciatok*p)+10*p,y);

  //vrchna ciarka
  context.moveTo(xzaciatok*p,yzaciatok*p);
  context.lineTo(xzaciatok*p,yzaciatok*p+10*p);

  //telo
  context.rect(xzaciatok*p-12*p,yzaciatok*p+10*p,24*p,40*p);

  //bezec
  context.moveTo(xzaciatok*p-12*p,yzaciatok*p+5*p+ykonec*p/10);
  context.lineTo(xzaciatok*p+12*p,yzaciatok*p+5*p+ykonec*p/10);

  //rameno
  context.moveTo(xzaciatok*p,yzaciatok*p+5*p+ykonec*p/10);
  context.lineTo(xzaciatok*p,ykonec*p);


  context.stroke();
}



function drawWallHorizontal(x,y,canvas,context,xend,p){
  //if(xend<=x){alert("MUR xend musi byt vacsie ako x pociatocne, kresli sa z lava do prava");return;}
  var krok= 20*p
  context.beginPath();
  

    context.fillStyle = '#e5e5e5';
    context.rect(x*p,y*p,(xend-x)*p,30*p);
    context.fill();


    //context.moveTo(x*p,p*(y+30));
    //context.lineTo(p*(xend+x),p*(y+30));
    
    context.moveTo(x*p,p*(y+15));
    context.lineTo(p*(xend),p*(y+15));

  var opak= p*(xend-x)/krok;
  for (var i = 1; i < opak; i++) {
       context.moveTo((krok*i)+x*p,p*(y+15));
       if(i%2===0){
           context.lineTo(krok*i+x*p,p*(y+30));
           context.moveTo((krok*i)+x,p*(y+15));
       }
       
       if(i%2===1){
           context.lineTo(krok*i+x*p,y*p);
           context.moveTo((krok*i)+x*p,p*(y+15));
       }
    }

    
    context.stroke();
  
}


function drawWallVertical(x,y,canvas,context,yend,p){
  //if(yend<=y){alert("MUR yend musi byt vacsie ako y pociatocne, kresli sa z hora na dol");return;}
var krok= 20*p
context.beginPath();

 context.fillStyle = '#e5e5e5';
 context.rect(x*p,y*p,krok,(yend-y)*p);
 context.fill();
      //context.moveTo((krok+x)*p,yend*p);
      //context.lineTo((krok+x)*p,y*p); // ta od hora az dole
 var poc=0; //dalsie pocitadlo preto lebo ak p=2 tak modulo uz nefunguje  

var f=y*p+15*p; //aby ta horna nebola obtiahnuta pretp + 15
    while(f<(yend)*p){
      context.moveTo(x*p,f);
      context.lineTo(krok+x*p,f);
        if (poc%2===0){
        context.moveTo(krok*0.65+x*p,f);
        context.lineTo(krok*0.65+x*p,f-15*p) 

        };
poc++; 
    f=f+15*p;
    

    }
    context.stroke();
}


function drawDamperHorizontal(xzaciatok, yzaciatok,xkonec,canvas,context,p){
    //if(xkonec<=xzaciatok){alert("TLMIC xkonec musi byt vacsie ako xzaciatok, kresli sa z lava do prava");return;}

  

  context.beginPath();

  //bezec
  context.moveTo(xzaciatok*p+10*p+xkonec*p/10,yzaciatok*p-12*p);
  context.lineTo(xzaciatok*p+10*p+xkonec*p/10,yzaciatok*p+12*p);

  // od muru k telu
  context.moveTo(xzaciatok*p,yzaciatok*p);
  context.lineTo(xzaciatok*p+10*p,yzaciatok*p);



  //telo
   context.rect(xzaciatok*p+10*p,yzaciatok*p-12*p,40*p,24*p);

  //rameno
  context.moveTo(xzaciatok*p+10*p+xkonec*p/10,yzaciatok*p);
  context.lineTo(xkonec*p,yzaciatok*p);


  context.stroke();

}

function drawSpringVertical(xzaciatok, yzaciatok,ykonec,canvas,context,p){
    //if(ykonec<=yzaciatok){alert("PRUZINA ykonec musi byt vacsie ako yzaciatok, kresli sa z hore dole");return;}

  context.beginPath();
    var curr_diff = ykonec*p-yzaciatok*p;
    var basic_diff = 200;
    for (var y = 0; y < curr_diff; y++) {
        var x= 7 * Math.sin(y/(p*(curr_diff/basic_diff)*(5/p)));
        x = x + xzaciatok;
        context.lineTo(p*x, (y+yzaciatok*p));
    }
    context.stroke();
}

function drawSpringHorizontal(xzaciatok, yzaciatok,xkonec,canvas,context,p){
  //console.log("xzaciatok");
  //if(xkonec<=xzaciatok){alert("PRUZINA xkonec musi byt vacsie ako xzaciatok, kresli sa z lava do prava");return;}

   xzaciatok=xzaciatok*p;
   xkonec=xkonec*p;
  // yzaciatok=yzaciatok*p;
  // xkonec=xkonec*p;
  //alert("kresli kresliPruzinuVodorovne");
context.beginPath();
        
         var curr_diff = xkonec-xzaciatok;
         var basic_diff = 200;//pocet vlnike
        
        for(var x = 0; x < curr_diff ; x++) { 
          var y = 7 * Math.sin(x/(p*(curr_diff/basic_diff)*(5/p))); //15 vysku 
          y=y+yzaciatok;
          context.lineTo(xkonec-x,y*p);

          }
        
        context.stroke();
}


function drawWagon(x,y,sirka,vyska,canvas, context,p,polomerKolesa){
  // sirka=120;
  // vyska=70;
   //context.beginPath();

      //context.rect(x*p, y*p, sirka*p, vyska*p);
      //context.fillStyle = '#f2dede';
      //context.fill();
      //context.strokeStyle = 'black';
      //context.stroke();
      drawBody(x,y,sirka,vyska,canvas, context,p);

    drawWheel(x+25,y+vyska+13,canvas,context,p,polomerKolesa);
    drawWheel(x+sirka-25,y+vyska+13,canvas,context,p,polomerKolesa);  

}

function drawWheel(x,y,canvas,context,p,polomerKolesa){
  x=x*p;
  y=y*p;
  
    context.beginPath();
    context.lineWidth=2;
    //context.arc(x+(25*p),y+(63*p),(12*p),2*Math.PI,false);
    //context.arc(x+(25*p),y,(polomerKolesa*p),2*Math.PI,false);
    context.arc(x,y,(polomerKolesa*p),2*Math.PI,false);

    context.closePath();
    context.stroke();
    
   //stred
     context.lineWidth=1;
     context.beginPath();
      //context.arc(x+(25*p),y,(polomerKolesa/6*p),2*Math.PI,false);

     context.arc(x,y,(polomerKolesa/6*p),2*Math.PI,false);
     context.fillStyle = 'black';
     context.fill();
     context.closePath();
     context.stroke();
    
    context.beginPath();
     context.arc(x,y,(polomerKolesa-3)*p,((x/100))*Math.PI,((x/100)-1.8)*Math.PI);
     context.lineTo(x,y);
     context.closePath();
     context.stroke();
    
    context.beginPath();
     context.arc(x,y,(polomerKolesa-3)*p,((x/100)+0.8)*Math.PI,((x/100)-1)*Math.PI);
     context.lineTo(x,y);
     context.closePath();
     context.stroke();
    
     context.beginPath();
     context.arc(x,y,(polomerKolesa-3)*p,((x/100)+0.4)*Math.PI,((x/100)+0.6)*Math.PI);
     context.lineTo(x,y);
     context.closePath();
     context.stroke();
    
     context.beginPath();
     context.arc(x,y,(polomerKolesa-3)*p,((x/100)+1.6)*Math.PI,((x/100)+1.8)*Math.PI);
     context.lineTo(x,y);
     context.closePath();
     context.stroke();
    
     context.beginPath();
     context.arc(x,y,(polomerKolesa-3)*p,((x/100)+1.2)*Math.PI,((x/100)+1.4)*Math.PI);
     context.lineTo(x,y);
     context.closePath();
     context.stroke();
    
}



function drawRod(xzaciatok,yzaciatok,xkonec,ykonec,canvas,context,p,hrubka,farba)
{ context.beginPath();
  context.moveTo(xzaciatok*p,yzaciatok*p);
  context.lineTo(xkonec*p,ykonec*p);
  context.lineWidth = hrubka*p;
  context.lineCap = 'round';
  context.strokeStyle = farba;
  context.stroke();
  context.strokeStyle ='#000000';  
}

function whiteCircle(x,y,pol,canvas,context,p)
{ context.beginPath();
  context.fillStyle="white";
  context.arc(x*p,y*p,pol*p,0,2*Math.PI);
  context.fill();
  context.stroke();
}

function whiteJoint(x,y,pol,canvas,context,p)
{ context.beginPath();
  context.fillStyle="black";
  context.arc(x*p,y*p,pol*p,0,2*Math.PI);
  context.fill();
  context.stroke(); 
  context.beginPath();
  context.fillStyle="#e5e5e5";
  context.arc(x*p,y*p,pol/1.2*p,0,2*Math.PI);
  context.fill();
  context.stroke();
}

function drawBall(x,y,canvas,context,p,pol)
{ context.beginPath();
  context.fillStyle="#f2dede";
  context.arc(x*p,y*p,pol*p,0,2*Math.PI);
  context.fill();
  context.stroke();
}

