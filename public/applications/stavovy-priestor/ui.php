<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="scripts/dygraph-combined.js"></script> 
        <script type="text/javascript" src="scripts/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
        <div id="content">
            <h1> Vitajte v applikácii Stavysolver,</h1>
            <h3>  ktorý vám pomôže pri práci v stavovom priestore </h3> <br> 
            <div  style="background-color:#E1CDC1;">
                <h3>   Vstupné údaje chcem zadať pomocou : <br> </h3> 
                <div id="inp1" style="float:left;">  matíc stavového priestoru
                    <input  type="radio" name="inputforma" value="zmatice" style="margin-top:0px;">&nbsp&nbsp&nbsp </div>
                <div id="inp2" style="margin-left:0px;float:left;">  prenosovej funkcie
                    <input  type="radio" name="inputforma" value="zpf" style="margin-top:0px;"> &nbsp&nbsp&nbsp 
                </div>
                <div id="inp3" style="float:left;">  prednastavených dém
                    <input  type="radio" name="inputforma" value="demo" style="margin-top:0px;">  &nbsp&nbsp&nbsp
                </div>
                <br>
                <div style="background-color:#D5BAAB;">  <br> 
                <div id="minimize" style="background-color:#D5BAAB;float:right;margin-top:-16px;margin-right:10px;"> ---</div>
                </div>
                <div  id="slide1" style="background-color:#D5BAAB;display:none;">
                    <br> Zadajte jednotlivé vektory/matice v matlabovskej syntaxi: 
                    <table border="0" >
                        <tr style="background-color:#D5BAAB;"><td> A= </td><td><input type="text" name="matlab_A" value="<?php //echo $matlab_A;             ?>"> <td>b= </td><td><input type="text" name="matlab_b" value="<?php //echo $matlab_b;             ?>"> </td></tr>
                        <tr style="background-color:#D5BAAB;"><td>ct= </td><td><input  type="text" name="matlab_ct" value="<?php //echo $matlab_ct;             ?>"> <td>d= </td><td><input type="text" name="matlab_d" value="<?php //echo $matlab_d;             ?>"> </td></tr>
                        <tr style="background-color:#D5BAAB;"><td>x0= </td><td><input type="text" name="matlab_x0" value="<?php //echo $matlab_x0;             ?>"> </td></tr>                        
                    </table>             
                </div>


                <div  id="slide2" style="background-color:#D5BAAB;display:none;">
                    <br>    Prenosová funkcia v tvare polynómov : <br>
                    <table border="0" >
                        <tr style="background-color:#D5BAAB;"><td>Čitateľ:</td><td> <input type="text" name="pfcit" style= "text-align: center" size="60" value="">   <td>Sčitanec z podielu čitateľa a menovateľa:  <br> </td><td><input type="text" name="pfd" style= "text-align: center" size="60" value="0">  </td>  </tr>         
                        <tr style="background-color:#D5BAAB;"><td>Menovateľ:  </td><td><input type="text" name="pfmen" style= "text-align: center" size="60" value="">  </td>  </tr>
                        <tr style="background-color:#D5BAAB;">
                    </table> 
                </div>


                <div  id="slide3" style="background-color:#D5BAAB;display:none;">
                    <br>    Vyberte si jedno z prednastavených dém  <br>
                    <table border="0" >
                        <tr style="background-color:#D5BAAB;"><td> <input type="radio" name="demo" value="1" style="margin-top:0px;"></td><td>nestabilný systém 2.rádu</td></tr>         
                        <tr style="background-color:#D5BAAB;"><td><input type="radio" name="demo" value="2" style="margin-top:0px;"></td><td>stabilný systém 2.rádu</td></tr>
                        <tr style="background-color:#D5BAAB;"><td><input type="radio" name="demo" value="3" style="margin-top:0px;"></td><td>stabilný systém 3.rádu</td></tr>
                    </table> 




                </div>  
                <div  id="convert" style="background-color:#DCC5B8;margin-top:0px;">   <br>
                    Konvertuj do 
                    <table border="0" >
                        <tr style="background-color:#DCC5B8;"> <td></td><td><input type="radio" name="forma" value="2" style="margin-top:0px;" <?php //echo $forma[2];           ?>>Normálnej formy pozorovateľnosti </td></tr>
                        <tr style="background-color:#DCC5B8;"> <td></td><td><input type="radio" name="forma" value="3" style="margin-top:0px;" <?php //echo $forma[3];           ?>>Normálnej formy riaditeľnosti <br> </td></tr>
                        <tr style="background-color:#DCC5B8;"> <td></td><td><input type="radio" name="forma" value="4" style="margin-top:0px;" <?php //echo $forma[4];           ?>>Paralelneho modelu(pre systémy s reálnymi koreňmi)<br> </td><td><button id="doformy" style="margin-right:-30px;float:right;">Konvertovať do formy</button></td></tr>
                    </table>

                </div>   
                <div  id="riesavykresli" style="background-color:#DCC0B1;margin-top:-15px;">   <br>
                    Zadaj vstupný signál pre riešenie systému
                    <table border="0" >
                        <tr style="background-color:#DCC0B1;"> <td>u=</td><td><input type="text" name="matlab_u" value="<?php // echo $matlab_u;         ?>"></td></tr>
                    </table>
                    <input type="checkbox" name="vykresligraf"> Vykresliť graf <br> <br>
                    <div id="paramgraf" style="background-color:#DCC0B1;margin-top:-15px;display:none;">
                   <br> Zadaj parametre pre vykreslenie grafu
                    <table border="0" >
                        <tr style="background-color:#DCC0B1;"> <td>Časový interval:</td><td><input type="text" size="7" name="timestart" value="<?php //echo $time_start;         ?>"><input type="text" size="7" name="timeend" value=""></td></tr>
                        <tr style="background-color:#DCC0B1;"> <td>Presnosť=</td><td><input type="text" name="vzorky" size="7" value="<?php //echo $pocet_vzoriek;         ?>"> </td></tr>
                    </table>
                    <button id="vykreslima" style="margin-right:30px;margin-top:-65px;float:right;">Vykresliť graf</button>                    
                    </div>
                </div> 
                  

                </div> 
                <div  id="vykreslenie" style="background-color:#EEC7B0;margin-top:-15px;display:none;"> 
                    <table> 
                        Priebeh výstupnej veličiny a stavových veličín systému v čase
                        <tr style="background-color:#EEC7B0;"><td> <div id="graf"></div><br> <button id="oddial">Oddialiť</button>   </td> 
                            <td><div  id="legenda">sefsef</div> <div id="udajeinput"></div></td>   </tr>


                </div>
                </table>                  
            </div> 

        </div>




        <script>
            function skryvanieudajov(udaj) {
                g.setVisibility(parseInt(udaj.id), udaj.checked);
            }
            function unzoom() {
                g.resetZoom();
                g.updateOptions({xRangePad: 1}, false);
                setTimeout(function() {
                    g.resetZoom();
                    g.updateOptions({xRangePad: 1}, false);
                }, 350);
            }
            



            $(document).ready(function() {
                var currslide="1";
          //      var sli=false;
                $("input[name=vykresligraf]").click(function() {
                    $("#paramgraf").slideToggle();                                       
                });
                $("input[name=inputforma]").click(function() {
                    if ($('input[name=inputforma]:checked').val() == 'zmatice') {
//                        $("#slide2").slideUp();
//                        $("#inp2").css("background-color", "#E1CDC1");
                        $("#slide"+currslide).slideUp();
                        $("#inp"+currslide).css("background-color", "#E1CDC1");
                        $("#slide1").slideDown();
                        $("#inp1").css("background-color", "#D5BAAB");
                        currslide="1";
                    }
                    if ($('input[name=inputforma]:checked').val() == 'zpf') {
 //                       $("#slide1").slideUp();
 //                       $("#inp1").css("background-color", "#E1CDC1");
                        $("#slide"+currslide).slideUp();
                        $("#inp"+currslide).css("background-color", "#E1CDC1");
                        $("#slide2").slideDown();
                        $("#inp2").css("background-color", "#D5BAAB");
                        currslide="2";
                    }
                    if ($('input[name=inputforma]:checked').val() == 'demo') {
 //                       $("#slide1").slideUp();
 //                       $("#inp1").css("background-color", "#E1CDC1");
                        $("#slide"+currslide).slideUp();
                        $("#inp"+currslide).css("background-color", "#E1CDC1");
                        $("#slide3").slideDown();
                        $("#inp3").css("background-color", "#D5BAAB");
                        currslide="3";
                    }
                    $("#convert").css("margin-top", "-15px");
                    sli=true;
                });

                /*                 $(".minimize").click(function() {
                 
                 if ($('input[name=inputforma]:checked').val() == 'zmatice') {
                 $("#slide1").slideToggle();
                 }
                 if ($('input[name=inputforma]:checked').val() == 'zpf') {
                 $("#slide2").slideToggle();
                 }
                 //  {
                 //  $("this").parent.stop();                  
                 if ($('input[name=inputforma]:checked').val() == 'demo') {
                 
                 }
                 }*/
                // );

                $("#vykreslima").click(function() {
                    $("#vykreslenie").slideDown();
                    var GrOptions = {
                        legend: 'always',
                        animatedZooms: true,
                        title: '<div  style="margin:1px 0px 0px 69px; border: thin solid white; border-bottom-color:black ;">Priebeh systémových veličín</div>',
                        drawGapEdgePoints: true,
                        // drawAxesAtZero: true, 
                        xRangePad: 1,
                        axisLineWidth: 0.6,
                        axisTickSize: 10,
                        panEdgeFraction: 0, //??
                        labelsDiv: document.getElementById('legenda'),
                        hideOverlayOnMouseOut: false,
                        gridLineWidth: 0.5,
                        labelsSeparateLines: true,
                        axes: {
                            x: {
                                valueFormatter: function(ms) {
                                    return 't=' + ms.toFixed(3);
                                }
                            }
                        }
                    };
                    bod = "X,Y,Z\n" +
                            "1,0,3\n" +
                            "2,2,6\n" +
                            "3,4,8\n" +
                            "4,6,9\n" +
                            "5,8,9\n" +
                            "6,10,8\n" +
                            "7,12,6\n" +
                            "8,14,3\n";
                   g = new Dygraph(document.getElementById("graf"),
                            bod,
                            GrOptions);


                    //document.getElementById("graph").innerHTML = "zle zadane udaje";
                    //        document.getElementById("tlacitko").innerHTML = "";

                /*   g.resize(g.width_ + 10, g.height_ + 10);*/

                });
                $("#minimize").click(function() {
                        $("#slide"+currslide).slideToggle();  
                        $("#convert").css("margin-top", "0px");
 /*                       if (sli==true) {$("#convert").css("margin-top", "0px");
                            sli=false;
                        }
                        if (sli==false){$("#convert").css("margin-top", "-15px");
                            sli=true;
                        }*/
                });


                $("#doformy").click(function() {

                });
                $("#oddial").click(function() {
                    unzoom();
                });                
            });














        </script>

    </div>
</body>
</html>
