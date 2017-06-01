<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Dva Oscilátori</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <script type="text/javascript" src="kniznica.js"></script>   
        <script type="text/javascript" src="lib/jquery.min.js"></script>
        <script type="text/javascript" src="lib/jquery.flot.js"></script>
        <script type="text/javascript" src="DvaOsc.js"></script>
    </head>
    <body id="body">

      
              
              <script language="php"> 
                                  
                              if(@$_POST['dajHodnoty'])
                                  {
                                  function vypocetHodnot()
                                  {

                                    
                                    $f=$_POST['f'];
                                    
                                    $m1=$_POST['m1'];
                                    
                                    $kp1=$_POST['kp1'];
                                    
                                    $kt1=$_POST['kt1'];
                                    
                                    $xo1=$_POST['xo1'];
                                    
                                    $xi1=$_POST['xi1'];

                                    $m2=$_POST['m2'];
                                    
                                    $kp2=$_POST['kp2'];
                                    
                                    $kt2=$_POST['kt2'];
                                    
                                    $xo2=$_POST['xo2'];
                                    
                                    $xi2=$_POST['xi2'];
                                    
                                    $cs=$_POST['cs'];
                                    
                                    $ce=$_POST['ce'];

                                    $poleVstupov;
                                    $poleVstupov[0]=$f;
                                    $poleVstupov[1]=$m1;
                                    $poleVstupov[2]=$kp1;
                                    $poleVstupov[3]=$kt1;
                                    $poleVstupov[4]=$xo1;
                                    $poleVstupov[5]=$xi1;
                                    
                                    $poleVstupov[6]=$m2;
                                    $poleVstupov[7]=$kp2;
                                    $poleVstupov[8]=$kt2;
                                    $poleVstupov[9]=$xo2;
                                    $poleVstupov[10]=$xi2;
                                    $poleVstupov[11]=$cs;
                                    $poleVstupov[12]=$ce;

                                $appUrl="http://147.175.105.140:8001/mathnew/app/";
                                $poz='{"method": "eval","params": {"api_key": "6aa20fbb186a9ee50319fe8a2ed01d1f","code": "function xdot = f (x, t)  \r\n   f=';
                                $poz=$poz . $f;
                                $poz=$poz . ';\r\n   m1= ';
                                $poz=$poz . $m1;
                                $poz=$poz . ';\r\n   kp1= ';
                                $poz=$poz . $kp1;
                                $poz=$poz . ';\r\n   kt1= ';
                                $poz=$poz . $kt1;
                                $poz=$poz . '; \r\n   m2= ';
                                $poz=$poz . $m2;
                                $poz=$poz . ';\r\n   kp2= ';
                                $poz=$poz . $kp2;
                                $poz=$poz . ';\r\n   kt2= ';
                                $poz=$poz . $kt2;
                                $poz=$poz . ';\r\ng=9.81;\r\n\r\n\r\n  xdot(1) = x(2);\r\n  xdot(2) = f/m1-kp1*(x(1)-x(3))/m1-kt1*(x(2)-x(4))/m1+g;\r\n  xdot(3) = x(4);\r\n  xdot(4) = kp1*x(1)/m2+kt1*x(2)/m2-(kp1+kp2)*x(3)/m2-(kt1+kt2)*x(4)/m2+g;\r\nendfunction\r\n\r\n x0 = [';
                                $poz=$poz . $xo1;
                                $poz=$poz . '; ';
                                $poz=$poz . $xi1;
                                $poz=$poz . '; ';
                                $poz=$poz . $xo2;
                                $poz=$poz . '; ';
                                $poz=$poz . $xi2;
                                $poz=$poz. '];\r\nt = linspace (0, ';
                                $poz=$poz . $cs;
                                $poz=$poz . ',';
                                $poz=$poz . $ce;
                                $poz=$poz . ')\';\r\nx = lsode (\"f\", x0, t);\r\n[x,t]\r\n","engine": "octave"},"id": 1}';
                               
                               //var_dump($poz);

                                $request=$poz;
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $appUrl);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                $response = curl_exec($ch);
                                curl_close($ch);


                                $A;
                                $B;
                                $C;
                                $D;
                                $Cas;

                                

                                $response = json_decode($response,true);
                                
                                $newResponse=$response["result"]["result"];
                                
                                $newResponse=substr($newResponse,7);//kazdy row ma potom 40 znakov
                                
                                $rows = explode("\n", $newResponse);//pole riadkov
                                
                                for ($i = 0; $i<count($rows); $i++) {
                                    if($rows[$i] == "")break;//kooli poslednym trom nullom
                                
                                 $columns=explode(" ", $rows[$i]);
                                //   //var_dump($columns[3]);
                                 $columns = array_filter($columns,'strlen');
                                 $columns= array_slice( $columns, 0  );
                                 //var_dump($columns);
                                 $A[$i]=$columns[0];
                                 $B[$i]=$columns[1];
                                 $C[$i]=$columns[2];
                                 $D[$i]=$columns[3]; 
                                 $Cas[$i]=$columns[4];
                                 };
                                  

                              //var_dump($Cas);
                                    $xjs1=json_encode($A);
                                    $xjs2=json_encode($B);
                                    $xjs3=json_encode($C);
                                    $xjs4=json_encode($D);
                                   
                                 

                                    $xjs5=json_encode($poleVstupov);
                                    $xjs6=json_encode($Cas);

                                     echo '<script type="text/javascript">',"var poloha1 = ". $xjs1 . ";\n" ,"var rychlost1 = ". $xjs2 . ";\n" ,"var poloha2 = ". $xjs3 . ";\n" ,"var rychlost2 = ". $xjs4 . ";\n" ,"var poleVstupovjs = ". $xjs5 . ";\n" ,"var casJs = ". $xjs6 . ";\n" ,'window.onload=function(){spracuj(poloha1,rychlost1,poloha2,rychlost2,poleVstupovjs,casJs);};', '</script>';
                                    
                              }

                              vypocetHodnot();
                              }

                      </script>
        
            <form id='myForm' action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
            <fieldset>
                <legend>Vstupne hodnoty</legend>
                
                <p><label class="field">Vonkajšia sila pôsobiaca na nižšie teleso:</label><input class="textbox" id="f" name="f" value="40" type="number" min="0" max="45" step="0.01"></p>
                <p><label class="field">Hmotnosť nižšieho telesa:</label><input class="textbox" id="m1" name="m1" value="15" type="number" min="0.01" max="45" step="0.01"></p>
                <p><label class="field">Konštanta nižšej pružiny:</label><input class="textbox" id="kp1" name="kp1" value="25" type="number" min="0" max="45" step="0.01"></p>
                <p><label class="field">Konštanta nižšieho tlmiča:</label><input class="textbox" id="kt1" name="kt1" value="8" type="number" min="0" max="45" step="0.01"></p>
                <p><label class="field">Počiatočná poloha nižšieho telesa:</label><input class="textbox" id="xo1" name="xo1" value="10" type="number" min="0" max="45" step="0.01"></p>
                <p><label class="field">Počiatočná rýchlosť nižšieho telesa:</label><input class="textbox" id="xi1" name="xi1" value="0" type="number" min="0" max="45" step="0.01"></p>
                
                <p><label class="field">Hmotnosť vyššieho telesa:</label><input class="textbox" id="m2" name="m2" value="10" type="number" min="0.01" max="45" step="0.01"></p>
                <p><label class="field">Konštanta vyššej pružiny:</label><input class="textbox" id="kp2" name="kp2" value="40" type="number" min="0" max="45" step="0.01"></p>
                <p><label class="field">Konštanta vyššieho tlmiča:</label><input class="textbox" id="kt2" name="kt2" value="2" type="number" min="0" max="45" step="0.01"></p>
                <p><label class="field">Počiatočná poloha vyššieho telesa:</label><input class="textbox" id="xo2" name="xo2" value="5" type="number" min="0" max="45" step="0.01"></p>
                <p><label class="field">Počiatočná rýchlosť vyššieho telesa:</label><input class="textbox" id="xi2" name="xi2" value="0" type="number" min="0" max="45" step="0.01"></p>

                <p><label class="field">Konečný čas v sekundách:</label><input class="textbox" id="cs" name="cs" value="20" type="number" min="0" max="45" step="0.01"></p>
                <p><label class="field">Počet hodnôt:</label><input class="textbox" id="ce" name="ce" value="200" type="number" min="0" max="500" step="0.01"></p>           
                 </fieldset>
        <input type="submit" id="button" name="dajHodnoty">
        <!-- <input type="submit" onclick="spracuj();" id="button" name="dajHodnoty"> -->
        </form>            
         <button type="button" onclick="setDef();">set default</button>

        <div id="content-holder" style="border: 1px solid;">
      </div>  
    </body>
</html>
