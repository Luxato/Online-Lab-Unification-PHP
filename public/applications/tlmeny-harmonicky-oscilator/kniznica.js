
//left,right,up,down,canva,context,weigh,high,parameter
function kresliMur(l,r,u,d,canvas,context,w,h,p){
	var krok= 20*p;


	if(l==1){
    context.beginPath();

 context.fillStyle = '#e5e5e5';
 context.rect(0,0,krok,h*p);
 context.fill();
     


var poc=0; //dalsie pocitadlo preto lebo ak p=2 tak modulo uz nefunguje  

var f=15*p; //aby ta horna nebola obtiahnuta pretp + 15
    while(f<h*p){
      context.moveTo(0,f);
      context.lineTo(krok,f);
        if (poc%2===0){
        context.moveTo(krok*0.65,f);
        context.lineTo(krok*0.65,f-15*p) 

        };
poc++; 
    f=f+15*p;
    

    }
    context.stroke();
}


if(r==1){
    context.beginPath();

    context.fillStyle = '#e5e5e5';
    context.rect(w*p-krok,0,krok,h*p);
    //context.rect(w*p-krok,0,w*p-krok,h*p);
    context.fill();
    context.moveTo(w*p, 0);
    context.lineTo(p*w,h*p);

     
var poc=0; //dalsie pocitadlo preto lebo ak p=2 tak modulo uz nefunguje  

var f=15*p; //aby ta horna nebola obtiahnuta pretp + 15
    while(f<h*p){
      context.moveTo(w*p-krok,f);
      context.lineTo(w*p,f);
        if (poc%2===0){
        context.moveTo(w*p-krok+krok*0.65,f);
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

function kresliTeleso(x,y,sirka,vyska,canvas, context,p){
   context.beginPath();

      context.rect(x*p, y*p, sirka*p, vyska*p);
      context.fillStyle = '#f2dede';
      context.fill();
      context.strokeStyle = 'black';
      context.stroke();

}




function kresliTlmic(xzaciatok, yzaciatok,ykonec,canvas,context,p){

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




function kresliMurVodorovne(x,y,canvas,context,xend,p){
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


function kresliMurZvislo(x,y,canvas,context,yend,p){
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


function kresliTlmicVodorovne(xzaciatok, yzaciatok,xkonec,canvas,context,p){
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

function kresliPruzinu(xzaciatok, yzaciatok,ykonec,canvas,context,p){
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

function kresliPruzinuVodorovne(xzaciatok, yzaciatok,xkonec,canvas,context,p){
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


function kresliVozik(x,y,sirka,vyska,canvas, context,p,polomerKolesa){
  // sirka=120;
  // vyska=70;
   //context.beginPath();

      //context.rect(x*p, y*p, sirka*p, vyska*p);
      //context.fillStyle = '#f2dede';
      //context.fill();
      //context.strokeStyle = 'black';
      //context.stroke();
      kresliTeleso(x,y,sirka,vyska,canvas, context,p);

    kresliKoliesko(x+25,y+vyska+13,canvas,context,p,polomerKolesa);
    kresliKoliesko(x+sirka-25,y+vyska+13,canvas,context,p,polomerKolesa);  

}

function kresliKoliesko(x,y,canvas,context,p,polomerKolesa){
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



function kresliTyc(xzaciatok,yzaciatok,xkonec,ykonec,canvas,context,p,hrubka,farba){

   
    
    
    context.beginPath();
  context.moveTo(xzaciatok*p,yzaciatok*p);
  context.lineTo(xkonec*p,ykonec*p);
    context.lineWidth = hrubka*p;
    context.lineCap = 'round';
    context.strokeStyle = farba;
    context.stroke();
context.strokeStyle ='#000000';
    

}

