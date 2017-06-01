<html>
    <head>
        <title>LED cube</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= $path ?>css/css.css">
        <script src="<?= $path ?>libs/three.js"></script>
        <script src="<?= $path ?>libs/jspdf/dist/jspdf.debug.js"></script>
        <script src="<?= $path ?>libs/jspdf/libs/html2canvas/dist/html2canvas.js"></script>
        <script src="<?= $path ?>libs/FileSaver.min.js"></script>
        <script src="<?= $path ?>libs/jquery-2.1.4.js"></script>
        <script src="<?= $path ?>libs/ace-builds/ace.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?= $path ?>script.js"></script>
        <style>
            #kocka canvas {
                margin: 0 auto;
                display: block;
            }
            #editor {
                height: 200px;
            }
        </style>
    </head>
    <body>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-magic" aria-hidden="true"></i> Tutorial</h4>
                </div>
                <div class="modal-body">
                    <h3>Rozsvietenie</h3>
                    1.on(x,y,z,color,stop,start);<br>
                    x,y,z - pozicie - povinne parametre<br>
                    start - čas v sekundách, o ktorý sa posunie vykonanie funkcie- default 0<br>
                    stop - čas v sekundách, za ktorý sa dane ledky zhasnú - default null<br>
                    color - farba rozsvietenia - 'r','b' (default),'g'<br>
                    napr. on( 3:5 ,1, y:[3 4 5], 'r',2, 2)<br><br>
                    on(x,y,z) rozsvietenie pozicií<br>
                    on(x,y,z,color) rozsvietene + farba<br>
                    on(x,y,z,stop) rozsvietenie + stop<br>
                    on(x,y,z,'',start) rozsvietenie +start<br>
                    on(x,y,z,color,'',start) rozsvietenie +farba+start<br>
                    on(x,y,z,color,stop) rozsvietenie + farba +stop<br>
                    on(x,y,z,color,stop,start) všetky parametre<br><br>

                    <h3>Zhasínanie</h3>
                    1.off(x,y,z)<br>
                    off(x,y,z,start)<br><br>
                    <h3> Možnosti zadávania pozícií</h3>
                    (1,1,1) jedna poziciia<br>
                    (1:5,1,1) sekvencia <br>
                    ([1 3 6],1,1) pole pozícií<br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
                </div>
            </div>

        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <section id="content">
                    <a id="restartImg" style="color: #000;"><i style="font-size: 25px;position: relative;top: 4px;" class="fa fa-refresh" aria-hidden="true"></i></a>
                    <a style="cursor: pointer;" data-toggle="modal" data-target="#myModal"><i style="font-size: 25px; color: #000; position: relative;top: 4px;" class="fa fa-question-circle" aria-hidden="true"></i></a>
                    <div id="manualDiv">
                        <!--
                        <div class="manualDivs" id="jsManual">
                            <img src="<?= $path ?>img/javascript_icon.png" alt="javaScript Manual" height="30" width="30">
                            <div id="manualJS" class="manual">
                                <img src="<?= $path ?>img/pdf_icon.png" id="pdf_icon_js" alt="javaScript Manual" height="30" width="30">
                                <h2>Manual JavaScript</h2>

                                <div id="rozsvietenie">
                                    <h3> Rozsvietenie</h3>
                                    1.on({x, y, z, start, color, stop });<br>
                                    x,y,z - pozície - povinné parametre<br>
                                    start - čas v sekundách, o ktorý sa posunie vykonanie funkcie- default 0<br>
                                    stop - čas v sekundách, za ktorý sa dané ledky zhasnú - default null<br>
                                    color - farba rozsvietenia - "r","b" (default),"g"<br>
                                    napr. on({x: 3:5 , z:1, y:[3,4,5], start: 2, color:"r", stop: 2 })<br><br>
                                    2. on(x,y,z,color,stop,start)<br>
                                    on(x,y,z) rozsvietenie pozicií<br>
                                    on(x,y,z,"g") rozsvietene + farba<br>
                                    on(x,y,z,stop) rozsvietenie + stop<br>
                                    on(x,y,z,"",start) rozsvietenie +start<br>
                                    on(x,y,z,color,"",start) rozsvietenie +farba+start<br>
                                    on(x,y,z,color,stop) rozsvietenie + farba +stop<br>
                                    on(x,y,z,color,stop,start) všetky parametre<br><br>
                                </div>
                                <div id="zhasinanie">
                                    <h3>Zhasínanie</h3>
                                    1.off({x, y, z, start});<br>
                                    2.off(x,y,z)<br>
                                    off(x,y,z,start)<br><br>
                                    <h3>Možnosti zadávania pozícií</h3>
                                    (1,1,1) jedna pozícia<br>
                                    (1:5,1,1) sekvencia (medzi číslom a : nesmie byť medzera) <br>
                                    ([1,3,6],1,1) pole pozícií<br>
                                </div>
                            </div>
                        </div>
                        -->
                        
                    </div>
                    <div id="kocka" style="width: 100%;"></div>
                    <div id="buttons">
                        <div id="radioButons">
                            <!--
                             <div class="radioB">
                                 Mode:<input type="radio" class="tlacidlo" id="js" name="mode" value="js" checked>JS
                                 <input type="radio" class="tlacidlo" id="matlab" name="mode" value="matlab"> Matlab
                                 |</div>
                             -->
                            <input type="hidden" name="mode" value="matlab">
                            <div class="radioB">
                                <strong>Model:</strong><input type="radio" class="tlacidlo" id="3D" name="model" value="3D" checked>3D Cube
                                <input type="radio" class="tlacidlo" id="2D" name="model" value="2D"> 2D Square
                                <!-- |--></div>
                            <!--
                            <div class="radioB">
                                | Video?:<input type="radio" class="tlacidlo" id="videoAno" name="video" value="videoAno" checked>Yes
                                <input type="radio" class="tlacidlo" id="videoNie" name="video" value="videoNie" > No
                                <span id="errVideo"> </span>
                            </div>
                            -->
                        </div>
                        <div id="clickButtons">
                            <button id="runButton" class="tlacidlo btn btn-md btn-success" >RUN</button>
                            <button class="tlacidlo btn btn-md btn-info" onclick="download()">SAVE SCRIPT</button>
                            <button class="tlacidlo btn btn-md btn-info" id="loadScript">LOAD SCRIPT</button>
                            <!--<button class="tlacidlo" id="stiahniVideo" onclick="saveVideo()">Save Video</button>   -->
                            <input class="tlacidlo" type="file" id="fileInput">
                            <!--<button class="tlacidlo" id="loadDemoButton" >LOAD DEMO</button>
                            <select id="demoSelect">
                                <option value=" " selected></option>
                            </select>      -->
                        </div>
                    </div><br>

                    <div id="editor"><!--
on({x: 3:5, z:1, y:[3,4,5], start: 2, color:"r", stop: 2 });
on(1,1,1);
on(5,5,5,"r");
on(1:5,1:5,1,"",2); // rozsvieti sa po 2 sekundach po predchadzajucej
on([2,4,8],8,1,3);// po 3 sekundach sa dane ledky zhasnu
on(8,8,8,"r",2,3);// rozsvieti sa na cerveno 3sek po predchadzajucej a o 2sek sa zhasne
off({x: 1, y:1, z:1 }); //zhasnutie
off(5,5,5); //zhasnutie
off(1:5,1:5,1,2); // dane ledky sa zhasnu 2 sek po predchadzajucej funkcii
-->on(1,1,1);
                        on(3,4,5,'r');
                        on(4:7,4:7,1,' ',2); %rozsviesti sa po 2 sekundach
                        on([2,4,8],8,1,3); %po 3 sekundach sa zhasne
                        on(8,8,8,'r',2,3); %rozsvieti sa po 2 a zhasne po 3 sekundach
                        off(5,5,5); %zhasnutie;
                        off(1:5,[1,3,5],1,2); %vykona sa po 2 sekundach
                    </div>
                </section>
            </div>
        </div>
    </div>
    </body>
</html>