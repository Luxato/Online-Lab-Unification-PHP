        <script type="text/javascript" src="<?= $path ?>kniznica.js"></script>
        <script type="text/javascript" src="<?= $path ?>../common_assets/jquery.flot0.8.3.js"></script>
        <script type="text/javascript" src="<?= $path ?>TelesoMedziStenami.js"></script>
        <style>
            label.field {
                width: 100%;
                max-width: 233px;
            }
        </style>
<?php
                if(@$_GET['dajHodnoty'])
                    {
                    function vypocetHodnot()
                    {

                      $f=$_GET['f'];
                      
                      $m=$_GET['m'];
                      
                      $kp=$_GET['kp'];
                      
                      $kt=$_GET['kt'];
                      
                      $xo=$_GET['xo'];
                      
                      $xi=$_GET['xi'];
                      
                      $cs=$_GET['cs'];
                      
                      $ce=$_GET['ce'];

                      $poleVstupov;
                        $poleVstupov[0]=$f;
                        $poleVstupov[1]=$m;
                        $poleVstupov[2]=$kp;
                        $poleVstupov[3]=$kt;
                        $poleVstupov[4]=$xo;
                        $poleVstupov[5]=$xi;
                        $poleVstupov[6]=$cs;
                        $poleVstupov[7]=$ce;
                     
                    
                        // app url
                        //$appUrl = "http://147.175.125.30:8001/math/app/";
                        $appUrl="http://147.175.105.140:8001/mathnew/app/";

                        $poziadavka='{"method": "eval","params": {"api_key": "6aa20fbb186a9ee50319fe8a2ed01d1f","code": "function xdot= f (x, t)  \r\nf=';
                        $poziadavka= $poziadavka . $f;
                        $poziadavka= $poziadavka . ';\r\nm=';
                        $poziadavka= $poziadavka . $m;
                        $poziadavka= $poziadavka . ';\r\np=';
                        $poziadavka= $poziadavka . $kp;
                        $poziadavka= $poziadavka . ';\r\nd=';
                        $poziadavka= $poziadavka . $kt;
                        $poziadavka= $poziadavka . ';\r\n\r\n\r\n  xdot(1) = x(2);\r\n  xdot(2) = -p*x(1)/d-d*x(2)/m+f/m;\r\n\r\nendfunction\r\n\r\n x0 = [';
                        $poziadavka= $poziadavka . $xo;
                        $poziadavka= $poziadavka . '; ';
                        $poziadavka= $poziadavka . $xi;
                        $poziadavka= $poziadavka . '];\r\nt = linspace (0, ';
                        $poziadavka= $poziadavka . $cs;
                        $poziadavka= $poziadavka . ', ';
                        $poziadavka= $poziadavka . $ce;
                        $poziadavka= $poziadavka . ')\';\r\nx = lsode (\"f\", x0, t);\r\n[x,t]\r\n","engine": "octave"},"id": 1}';

                              //var_dump($poziadavka);
                                // json request
                                
                                $request = $poziadavka;
                         
                                // sendRequest
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $appUrl);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                $response = curl_exec($ch);
                                curl_close($ch);

                                $A;
                                  $B;
                                  $Cas;
                         
                                // decode response
                                $response = json_decode($response,true);
                        //vydolujem z responsu pomocou dva krat result, potom odrezem uvod
                        //explodnem podla zalomenia riadku tym padom jeden prvok [x1,x2]
                        //tie su oddelene medzerou preto explodnem este podla medzeri takze kazdy z pieces sa rozpadne
                        // na pole ktore ma 8 alebo 9 prvskov(explodujem do g)
                        //potom whileom prechadzam g a hladam kde je nieco ine ako "" ak je cislo 9.00tak je na 4tom mieste
                        //ak je 12.423 tak na tretom lebo pred bodkou su dve cifry, no proste to funguje, a breakujem
                        //preto lebo sa tam nachadza este jedna hodnota ale tu nescem!
                                $newResponse=$response["result"]["result"];
                                $newResponse=substr($newResponse,7);//odreze to x_=_, 5 preto aby kazdy z row mal 20 charov
                                $rows = explode("\n", $newResponse);//pieces

                                for ($i = 0; $i<count($rows); $i++) {
                                    if($rows[$i] == "")break;//kooli poslednym trom nullom
                                
                                 $columns=explode(" ", $rows[$i]);
                                //   //var_dump($columns[3]);
                                 $columns = array_filter($columns,'strlen');
                                 $columns= array_slice( $columns, 0  );
                                 //var_dump($columns);
                                 $A[$i]=$columns[0];
                                 $B[$i]=$columns[1];
                                 

                                 $Cas[$i]=$columns[2];
                                 };

                                // for ($i = 0; $i < count($rows); $i++) {
                                //     //zjavne to tu nemusi byt :/ if($rows[$i] == "")break; //na poslednych miestach su 3 "" tak aby som nemusel substr 0 po velke cislo tak ukoncim for
                                //     $firstX=explode(" ", $rows[$i]); //g
                                //     $p=0;
                                //         while ($p < count($firstX)) {
                                //             //var_dump($firstX[$p]);
                                //             if($firstX[$p]!=""){$x[$i]=$firstX[$p];break;}
                                //             $p++;
                                //         }

                                //         $q=count($firstX);
                                //         while ($q > 0 ) {
                                //             //var_dump($firstX[$p]);
                                //             if($firstX[$q]!=""){$x2[$i]=$firstX[$q];break;}
                                //             $q--;
                                //         }
                                // }
                                $xjs=json_encode($A);
                                $xjs2=json_encode($B);
                                $xjs3=json_encode($poleVstupov);
                                $xjs4=json_encode($Cas);

                        echo '<script type="text/javascript">',"var xjs = ". $xjs . ";\n" ,"var xjs2 = ". $xjs2 . ";\n" ,"var poleVstupovjs = ". $xjs3 . ";\n" ,"var casJs = ". $xjs4 . ";\n" ,'window.onload=function(){spracuj(xjs,xjs2,poleVstupovjs,casJs);};','</script>';
 
                        
                      
                }

                vypocetHodnot();
                }

        ?>
        <form id='myForm' action="" method="GET">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <fieldset>
                            <legend>Vstupné hodnoty</legend>
                            <p><label class="field">Vonkajšia sila pôsobiaca na systém:</label><input class="textbox" id="f" name="f" value="20" type="number" min="0" max="45" step="0.01"></p>
                            <p><label class="field">Hmotnosť telesa:</label><input class="textbox " id="m" name="m" value="5" type="number" min="0.01" max="45" step="0.01"></p>
                            <p><label class="field">Konštanta pružiny:</label><input class="textbox " id="kp" name="kp" value="20" type="number" min="0" max="45" step="0.01"></p>
                            <p><label class="field">Konštanta tlmiča:</label><input class="textbox " id="kt" name="kt" value="7" type="number" min="0" max="45" step="0.01"></p>
                            <p><label class="field">Počiatočná poloha telesa:</label><input class="textbox " id="xo" name="xo" value="12" type="number" min="0" max="45" step="0.01"></p>
                            <p><label class="field">Počiatočná rýchlosť telesa:</label><input class="textbox " id="xi" name="xi" value="0" type="number" min="0" max="45" step="0.01"></p>
                           <p><label class="field">Konečný čas v sekundách:</label><input class="textbox " id="cs" name="cs" value="20" type="number" min="0" max="45" step="0.01"></p>
                            <p><label class="field">Počet hodnôt:</label><input class="textbox " id="ce" name="ce" value="200" type="number" min="0" max="500" step="0.01"></p>
                        </fieldset>
                        <input class="btn btn-success" type="submit" id="button" name="dajHodnoty" value="Odoslať">
                        <button class="btn btn-info" type="button" onclick="setDef();">set default</button>
                    </div>
                    <div class="col-md-6">
                        <div id="content-holder">
                       </div>
                    </div>
                </div>
            </div>
            </form>

