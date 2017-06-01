<html>
    <head>    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <script src="scripts/dygraph-combined.js"></script> 
        <script type="text/javascript" src="scripts/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <?php

        function maxradsearch($fcia) {
            $max = 0;
            for ($it = 0; $it < strlen($fcia); $it++) {
                if ($fcia[$it] == 's') {
                    if (1 > $max)
                        $max = 1;
                    if ($fcia[$it + 1] == '^')
                        if (intval($fcia[$it + 2]) > $max)
                            $max = intval($fcia[$it + 2]);
                        elseif ($fcia[$it + 2] == '*' && $fcia[$it + 1] == '*') {
                            if (intval($fcia[$it + 3]) > $max)
                                $max = intval($fcia[$it + 3]);
                        }
                }
            }
            return $max;
        }

        function radsearch($fcia, $rad) {
            $pom = false;
            $prvok = '0';
            if ($rad == '1')
                $pom = true;
            for ($it = 0; $it < strlen($fcia); $it++) {
                if ($fcia[$it] == ',')
                    $fcia[$it] = '.';
                if ($fcia[$it] == 's' && (($fcia[$it + 1] == '^' && $fcia[$it + 2] == $rad) || ($pom && $fcia[$it + 1] <> '^'))) {
                    $it--;
                    $prvok = '1';
                    for (; !($fcia[$it] == '+' || $fcia[$it] == '-'); $it--) {
                        $prvok = $fcia[$it] . $prvok;
                    }
                    break;
                }
            }
            //  if ($it==-1) var_dump($prvok,$rad);
            if ($prvok == '0') {
                $it = 1;
                $fcia[$it] = '+';
            }
            if ($fcia[$it] == '-')
                $prvok = $fcia[$it] . $prvok;
            return $prvok;
        }

        function radsearchabs($fcia) {
            $pom = false;
            $prvok = '';
            for ($it = 0; $it < strlen($fcia); $it++) {
                if ($fcia[$it] == ',')
                    $fcia[$it] = '.';
                if (($pom) && ($fcia[$it] == '+') && (strlen($prvok) > 1))
                    break;
                if ($fcia[$it] == '+' || $fcia[$it] == '-' || $pom) {
                    $pom = true;
                    $prvok = $prvok . $fcia[$it];
                    if ($fcia[$it] == 's') {
                        $pom = false;
                        $prvok = '';
                    }
                }
            }
            return $prvok;
        }

        function pf2stav($prenosovaf) { //funkcia na prevod z prenosovej fcie do stavoveho priestoru
            $prenosovaf['cit'] = '+' . $prenosovaf['cit'] . '   ';
            $prenosovaf['men'] = '+' . $prenosovaf['men'] . '   ';
            $rad_sys = maxradsearch($prenosovaf['men']);
            $a[0] = radsearchabs($prenosovaf['men']);
            for ($it = 1; $it <= $rad_sys; $it++) {
                $a[$it] = radsearch($prenosovaf['men'], $it);
            }
            $it--;
            if ($a[$it] <> 1)
                for ($it = 0; $it <= $rad_sys; $it++)
                    $a[$it].='/(' . $a[$rad_sys] . ')';
            $b[0] = radsearchabs($prenosovaf['cit']);
            for ($it = 1; $it <= maxradsearch($prenosovaf['cit']); $it++) {
                $b[$it] = radsearch($prenosovaf['cit'], $it);
            }
            for (; $it < $rad_sys; $it++) {
                $b[$it] = '0';
            }

            $maxima_ct = $b[0];
            $maxima_b = '';
            $mat_a = '';
            for ($it = 1; $it < $rad_sys; $it++) {
                $maxima_ct = $maxima_ct . ',' . $b[$it];
                $maxima_b = $maxima_b . '0,';
                $mat_a.=$a[$it - 1];
                $mat_a.=',';
            }
            $mat_a.=$a[$it - 1];
            $maxima_ct = 'matrix([' . $maxima_ct . '])$';
            $maxima_b = 'transpose(matrix([' . $maxima_b . '1]))$';

            $maxima_A = 'addrow(addcol(zeromatrix(' . $rad_sys . '-1,1),ident(' . $rad_sys . '-1)),-1*matrix([' . $mat_a . ']))$';
            $kody[1] = $maxima_A;
            $kody[2] = $maxima_b;
            $kody[3] = $maxima_ct;
            $kody[4] = $rad_sys;
            return $kody;
        }

        function mattomax($matica, $nxn) { //funkcia na prelozenie matlab kodu matice do maximy aj je true overuje aj ci je stvorcova  a daj je velkost
            $rows = 0;
            $zvysok = strchr($matica, "[");
            $syntax = "matrix([";
            //$odhad=(substr_count($zvysok,";")+1);   
            $rozmer = array(1);
            $cvr = false;
            for ($it = 0; $it < strlen($zvysok); $it++) {
                if (((($zvysok[$it] == ' ') && ($zvysok[$it + 1] <> ']')) || ($zvysok[$it] == ',')) && (($zvysok[($it + 1)] <> ' ') && ($cvr))) {
                    $syntax.=",";
                    $rozmer[0] ++;
                }
                if ($zvysok[$it] == ';') {
                    $syntax.="],[";
                    array_unshift($rozmer, 1);
                    $cvr = false;
                }
                if ($zvysok[$it] == ']') {
                    $syntax.="])";
                }
                if ($zvysok[$it] == "'") {
                    $syntax = "transpose(" . $syntax . ")";
                }
                if (($zvysok[$it] == '0') || ($zvysok[$it] == '1') || ($zvysok[$it] == '2') || ($zvysok[$it] == '3') || ($zvysok[$it] == '4') || ($zvysok[$it] == '5') || ($zvysok[$it] == '6') || ($zvysok[$it] == '7') || ($zvysok[$it] == '8') || ($zvysok[$it] == '9') || ($zvysok[$it] == '.')) {
                    if ($zvysok[$it - 1] == '-') {
                        $syntax.="-";
                    }
                    $syntax.=$zvysok[$it];
                    $cvr = true;
                }
            }
            if (strlen($zvysok) == 0) {
                return "zle zadany retazec";
            }
            $rozmer = array_reverse($rozmer);
            if ($nxn == true) {
                for ($arr = 0; $arr < sizeof($rozmer); $arr++) {
                    if (sizeof($rozmer) <> $rozmer[$arr]) {
                        return "nesedia pozadovane rozmery pre stvorcovu maticu";
                    }
                }
                $vysledok = array($syntax . '$', $rozmer[1]);
                return $vysledok;
            }

            return $syntax . '$';
        }

        function toNFR($A, $b, $ct, $x0, $rozmer) {
            $codeNFR = 'A:'
                    . $A .
                    '   b:'
                    . $b
                    . '   ct:'
                    . $ct
                    . '   Qr:b$ '
                    . 'x0:'
                    . $x0;
            $Qr = ' A.b ';
            for ($it = 1; $it < ($rozmer); $it++) {
                $codeNFR.='   Qr:addcol(Qr,' . $Qr . ')$ ';
                $Qr = 'A.' . $Qr;
            }
            $T = ' t1t.A ';
            $codeNFR.=' t1t:matrix(invert(Qr)[' . $rozmer . '])$   T:t1t$ ';
            for ($it = 1; $it < ($rozmer); $it++) {
                $codeNFR.='  T:addrow(T,' . $T . ')$ ';
                $T.='.A';
            }
            $codeNFR.='Ar:T.A.invert(T);   '
                    . 'br:T.b;   '
                    . 'ctr:ct.invert(T); '
                    . 'x0r:T.x0;';
            return $codeNFR;
        }

        function toNFP($A, $b, $ct, $x0, $rozmer) {//normalna forma pozorovatelnosti
            $codeNFP = 'A:'
                    . $A .
                    '   b:'
                    . $b
                    . '   ct:'
                    . $ct
                    . 'x0:'
                    . $x0
                    . '   Qp:ct$ ';
            $Qp = ' ct.A ';
            for ($it = 1; $it < ($rozmer); $it++) {
                $codeNFP.='   Qp:addrow(Qp,' . $Qp . ')$ ';
                $Qp = $Qp . '.A';
            }
            $codeNFP.='s1:invert(Qp).ematrix(length(A), 1, 1, length(A), 1)$ ';
            $codeNFP.='S:s1$';
            $S = 'A.s1';
            for ($it = 1; $it < ($rozmer); $it++) {
                $codeNFP.='  S:addcol(S,' . $S . ')$ ';
                $S = 'A.' . $S;
            }
            $codeNFP.='T:invert(S)$  ' .
                    'Ap:T.A.S;   '
                    . 'bp:T.b;   '
                    . 'ctp:ct.S; '
                    . 'x0p:T.x0;';
            return $codeNFP;
        }

        function toParalModel($A, $b, $ct, $x0, $rozmer) {//normalna forma pozorovatelnosti
            $codePM = ' load(\"diag\")$ '
                    . ' A:'
                    . $A .
                    '   b:'
                    . $b
                    . ' ct:'
                    . $ct
                    . ' x0:'
                    . $x0
                    . ' F:ModeMatrix(A,jordan(A))$'
                    . ' IF:invert(F)$'
                    . ' Aj:IF.A.F; '
                    . ' bj:IF.b; '
                    . ' ctj:ct.F; '
                    . ' x0j:IF.x0; ';
            return $codePM;
        }

        function Alternativne_vykreslovanie($A, $b, $ct, $x0, $u, $U, $rs, $pv, $id, $time_start, $time_end) {
            $code = ' assume(t>0)$ A: '
                    . $A
                    . ' b:'
                    . $b
                    . ' ct:'
                    . $ct
                    . ' x0:'
                    . $x0
                    . ' u:'
                    . $u
                    . ' U:laplace(u,t,s)$ '
                    . $U
//                        . ' nilt(f,s,t):=block([polyfactor:true,ratprint:false,ft,res], ' /*(c) Wilhelm Haagern nilt GNU licence*/
//                        . ' if not listp(f) then f:[f], '
//                        . ' res:map(lambda([ff], '
//                        . ' ft:ilt(float(num(ff)/allroots(float(denom(ff)))),s,t), '
//                        . ' ev(ft,float,expand)),xthru(f)), '
//                        . ' if length(res)=1 then res[1] else res'
//                        . ')$'
                    . ' comboilt(f,s,t):=block([transf],(if not freeof(s,transf:ilt(f,s,t)) then transf:nilt(f,s,t)),return(transf))$'
                    . ' charmat:s*ident('
                    . $rs
                    . ')-A$ rez:factor(invert(charmat))$'
                    . ' F(x):=comboilt(x,s,t)$'
                    . ' fund:matrixmap(F, rez)$'
                    . ' vlastzl:fund.x0$'
                    . ' G(a):=integrate(a, t, 0, t)$'
                    . ' vnutornazl:expand(matrixmap(G, if not matrixp((fund.b)*F(U)) then [(fund.b)*F(U)] else (fund.b)*F(U)))$'
                    . ' y:expand(radcan(factor(expand(exponentialize(ct.vlastzl+ct.vnutornazl)))))$'
                    . ' stavpremX:vlastzl+vnutornazl$'
                    . ' if listp(stavpremX) then stavpremX:matrix([stavpremX[1]])$'
                    . ' expand(radcan(factor(exponentialize(stavpremX))))$'
                    . ' plot2d([parametric,t,ev(stavpremX[' . strval(($id - 1)) . '][1]),[t,'
                    . $time_start
                    . ','
                    . $time_end
                    . '],[nticks, '
                    . $pv . ']])$ ';
            return $code;
        }

        function buildrequest($code, $graph_o, $formula_o, $id) {
            return '{
          "method": "eval",
          "params": {"code": "' . $code . '",
          "engine": "maxima",
          "graph_output": "' . $graph_o . '",
          "formula_output": ' . $formula_o . '
          },
          "id": ' . $id . '
          }';
        }

        function buildrequestwithbin($code, $graph_o, $load, $formula_o, $id) {
            return '{
          "method": "eval",
          "params": {"load": "' . $load . '",
          "code": "' . $code . '",
          "engine": "maxima",
          "graph_output": "' . $graph_o . '",
          "formula_output": ' . $formula_o . '
          },
          "id": ' . $id . '
          }';
        }
        ?>
    </head>
    <body>
        <?php
        $mnnazvov[1] = 'A';
        $mnnazvov[2] = 'b';
        $mnnazvov[3] = 'ct';
        $mnnazvov[4] = 'x0';
        $mnnazvov[5] = 'Y';
        $mnnazvov[6] = 'X';
        if (!empty($_POST["inputforma"])) {
            if ($_POST["inputforma"] == 'zmatice')
                $out[1] = 'checked';
            else
                $out[1] = '';
            if ($_POST["inputforma"] == 'zpf')
                $out[2] = 'checked';
            else
                $out[2] = '';
        } else {
            $out[1] = '';
            $out[2] = '';
        }
        if (empty($_POST["appUrl"])) {
            $appUrl = "http://147.175.125.30:8001/math/app/";
        } else {
            $appUrl = $_POST["appUrl"];
        }



        if (empty($_POST["inputforma"])) {
            $_POST["inputforma"] = 'zmatice';
        }
        if (($_POST["inputforma"] == 'zmatice')) {
            //premenne systemu zadane pre matlab

            if ((!empty($_POST["demo"])) && ((empty($_POST["matlab_A"])) || (empty($_POST["matlab_b"])) || (empty($_POST["matlab_ct"])) || (empty($_POST["matlab_x0"])) || (empty($_POST["matlab_u"])))) {
                echo "<script> alert('Neboli zadane vsetky potrebné vstupné parametre!');  history.go(-1); </script>";
                exit();
            }
            if (empty($_POST["demo"])) {
                $matlab_A = "[0 1 0;0 0 1;-6 -11 -6]";
                $matlab_b = "[0;0;1]";
                $matlab_ct = "[1 1 1]";
                $matlab_x0 = "[1 -1 3]'";
                $matlab_u = '1';
                echo "Demo priklad systemu 3 radu <br>";
            } elseif ($_POST["demo"] == '3') {
                $matlab_A = "[0 1 0;0 0 1;-6 -11 -6]";
                $matlab_b = "[0;0;1]";
                $matlab_ct = "[1 1 1]";
                $matlab_x0 = "[1 -1 3]'";
                $matlab_u = '1';
                echo "Demo priklad systemu 3 radu <br>";
            } else if ($_POST["demo"] == '2') {
                $matlab_A = "[0 1;-2 -3]";
                $matlab_b = "[0;1]";
                $matlab_ct = "[1 1]";
                $matlab_x0 = "[1;-1]";
                $matlab_u = '1';
                echo "Demo priklad systemu 2 radu <br>";
            } else {
                $matlab_A = $_POST["matlab_A"];
                $matlab_b = $_POST["matlab_b"];
                $matlab_ct = $_POST["matlab_ct"];
                $matlab_x0 = $_POST["matlab_x0"];
                $matlab_u = $_POST["matlab_u"];
            }
            //var_dump($_POST);
            //premenne systemu pre maximu
            /*    $maxima_A = 'matrix([0,1,0],[0,0,1],[-1,-3,-3])';
              $maxima_b = 'matrix([0],[0],[1])';
              $maxima_ct = 'matrix([1,1,1])';
              $maxima_x0 = 'matrix([1],[1],[1])';
              $vstup_u = '1';
              $rad_sys = '3';
             */
            $max_Acelk = mattomax($matlab_A, true);
            $maxima_A = $max_Acelk[0];
            $maxima_b = mattomax($matlab_b, false);
            $maxima_ct = mattomax($matlab_ct, false);
            $maxima_x0 = mattomax($matlab_x0, false);
            $rad_sys = $max_Acelk[1];
            $vstup_u = $matlab_u . '$';
            $maxima_x0 = mattomax($matlab_x0, false);
            $vstup_U = '';
            if (!empty($_POST["pfmen"]))
                $pf['men'] = $_POST["pfmen"];
            if (!empty($_POST["pfcit"]))
                $pf['cit'] = $_POST["pfcit"];
        }

        if (empty($_POST["ucit"]))
            $_POST["ucit"] = '1'; elseif ($_POST["ucit"] == '')
            $_POST["ucit"] = '1';
        if (empty($_POST["umen"]))
            $_POST["umen"] = 's'; elseif ($_POST["umen"] == '')
            $_POST["umen"] = 's';
        if (empty($_POST["pfmen"]))
            $pf['men'] = '1'; elseif ($_POST["pfmen"] == '')
            $pf['men'] = '1';
        if (empty($_POST["pfcit"]))
            $pf["cit"] = '1'; elseif ($_POST["pfcit"] == '')
            $pf["cit"] = '1';

        if (($_POST["inputforma"] == 'zpf')) {
            $pf['men'] = $_POST["pfmen"];
            $pf['cit'] = $_POST["pfcit"];
            $syst = pf2stav($pf);
            //var_dump($syst);
            $maxima_A = $syst[1];
            $maxima_b = $syst[2];
            $maxima_ct = $syst[3];
            $rad_sys = $syst[4];
            $matlab_x0 = $_POST["matlab_x0"];
            $maxima_x0 = mattomax($matlab_x0, false);
            $vstup_U = ' U:(' . $_POST["ucit"] . ')/(' . $_POST["umen"] . ')$ ';
            $vstup_u = '';
            $matlab_A = $_POST["matlab_A"];
            $matlab_b = $_POST["matlab_b"];
            $matlab_ct = $_POST["matlab_ct"];
            $matlab_x0 = $_POST["matlab_x0"];
            $matlab_u = $_POST["matlab_u"];
        }
        //presnost a pocet vzoriek grafu, cas
        if (empty($_POST["vzorky"])) {
            $pocet_vzoriek = '1001';
        } else {
            $pocet_vzoriek = $_POST["vzorky"];
        }
        if (empty($_POST["timestart"])) {
            $time_start = '0';
        } else {
            $time_start = $_POST["timestart"];
        }
        if (empty($_POST["timeend"])) {
            $time_end = '10';
        } else {
            $time_end = $_POST["timeend"];
        }

        $presnost = 4;




        //premenne requestu

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $appUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $pom = '';
        $graph_o = 'array';
        $formula_o = '[
                      "tex",
                     "native"
                       ]';
        $zmenasyst = '';
        if (!empty($_POST["forma"])) {
            if ($_POST["forma"] <> '1') {
                if ($_POST["forma"] == '2')
                    $zmenasyst = toNFP($maxima_A, $maxima_b, $maxima_ct, $maxima_x0, $rad_sys);
                if ($_POST["forma"] == '3')
                    $zmenasyst = toNFR($maxima_A, $maxima_b, $maxima_ct, $maxima_x0, $rad_sys);
                if ($_POST["forma"] == '4')
                    $zmenasyst = toParalModel($maxima_A, $maxima_b, $maxima_ct, $maxima_x0, $rad_sys);
                $odoslima = buildrequest($zmenasyst, $graph_o, $formula_o, 0);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $odoslima);
                $novysystem = curl_exec($ch);
                if (strpos($novysystem, 'an error')) {
                    echo 'zle zadany tvar pre prevod do formy vykreslenie bez konverzie';
                } else {
                    //  var_dump($novysystem);  
                    $novysystem = json_decode($novysystem);
                    $novysystem = (array) $novysystem->result->formulas;
                    $iter = 1;
                    echo "<table> <tr><td><br></td>";
                    foreach ($novysystem["tex"] as $formula) {
                        echo '<td> <center>' . $mnnazvov[$iter] . $formula . ' </center> </td>';
                        $iter++;
                    }
                    $novysystem = $novysystem["native"];
                    $maxima_A = $novysystem[0];
                    $maxima_b = $novysystem[1];
                    $maxima_ct = $novysystem[2];
                    $maxima_x0 = $novysystem[3];
                }
            }
        }
        for ($id = 1; $id <= ($rad_sys + 1); $id++) {   //                                                //                                                                                                                                                                                                                                                                                                                                                                                                                                                 
            if ($id == 1) {         //prvy prepocet
                $code = ' assume(t>0)$'
                        . 'fpprintprec:8$'
                        . ' A: '
                        . $maxima_A
                        . ' b:'
                        . $maxima_b
                        . ' ct:'
                        . $maxima_ct
                        . ' d:0$ '
                        . ' x0:'
                        . $maxima_x0
                        . ' u:'
                        . $vstup_u
                        . ' U:laplace(u,t,s)$ '
                        . $vstup_U
//                        . ' nilt(f,s,t):=block([polyfactor:true,ratprint:false,ft,res], ' /*(c) Wilhelm Haagern nilt GNU licence*/
//                        . ' if not listp(f) then f:[f], '
//                        . ' res:map(lambda([ff], '
//                        . ' ft:ilt(float(num(ff)/allroots(float(denom(ff)))),s,t), '
//                        . ' ev(ft,float,expand)),xthru(f)), '
//                        . ' if length(res)=1 then res[1] else res'
//                        . ')$'
                        . ' comboilt(f,s,t):=block([transf],(if not freeof(s,transf:ilt(f,s,t)) then transf:nilt(f,s,t)),return(transf))$'
                        . ' charmat:s*ident('
                        . $rad_sys
                        . ')-A$ rez:factor(invert(charmat))$'
                        . ' F(x):=comboilt(x,s,t)$'
                        . ' fund:matrixmap(F, if not matrixp(rez) then [rez] else rez)$'
                        . ' vlastzl:fund.x0$'
                        . ' G(a):=integrate(a, t, 0, t)$'
                        . ' vnutornazl:expand(matrixmap(G, if not matrixp((fund.b)*F(U)) then [(fund.b)*F(U)] else (fund.b)*F(U)))$'
                        . ' yg:(ct.if not matrixp(vlastzl) then [vlastzl] else vlastzl +ct.vnutornazl+d*u)$'
                        . ' y:multthru(combine(distrib(factor(demoivre(expand(radcan(factor(expand(exponentialize(yg))))))))))$'
                        . ' if (slength(string(y))>150) then y:eval_string(ssubst(\"*10**\", \"b\", string(distrib(expand(bfloat(y))))))$'
                        . ' y;'
                        . ' stavpremX:vlastzl+vnutornazl$'
                        . ' stavpremX:expand(multthru(combine(distrib(factor(demoivre(expand(radcan(factor(expand(exponentialize(stavpremX)))))))))))$'
                        . ' if slength(string(stavpremX[1]))>100 then stavpremX:eval_string(ssubst(\"*10**\", \"b\", string(distrib(expand(bfloat(stavpremX))))))$'
                        . ' if listp(stavpremX) then stavpremX:matrix([stavpremX[1]])$'
                        . ' stavpremX;'
                        . ' plot2d([parametric,t,ev(yg),[t,'
                        . $time_start
                        . ','
                        . $time_end
                        . '],[nticks, '
                        . $pocet_vzoriek . ']])$';
            } else { //dalej sa uz vyuziva iba vysledok na vykreslenie grafov
                $code = ' ';
                $pom = strval(($id - 1));
                $vykreslovanie = ''
                        //                      . ' bftorat:true$'
                        . ' plot2d([parametric,t,ev(inp1[' .
                        $pom
                        . '][1]),[t,'
                        . $time_start
                        . ','
                        . $time_end
                        . '],[nticks,'
                        . $pocet_vzoriek . ']])$ ';
                //      var_dump($vykreslovanie);
                $pm = 0;
                foreach ($native as $nat) {
                    $code = $code . 'inp' . $pm . ':' . $nat . " ";
                    $pm++;
                }
                $code = $code . $vykreslovanie;
            }
            //struktura poziadavku
            $load = base64_encode(file_get_contents("numer.mac"));
            if ($id == 1) {
                $request[$id] = buildrequestwithbin($code, $graph_o, $load, $formula_o, $id);
            } else
                $request[$id] = buildrequest($code, $graph_o, $formula_o, $id);
            //odoslanie poziadavku

            curl_setopt($ch, CURLOPT_URL, $appUrl);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request[$id]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //   var_dump($request[$id]);
            $response[$id] = curl_exec($ch);
            if ($response[$id] == 'Wrong request format!' || $response[$id] == '' || empty($response[$id])) {
                $request[$id] = buildrequestwithbin(Alternativne_vykreslovanie($maxima_A, $maxima_b, $maxima_ct, $maxima_x0, $vstup_u, $vstup_U, $rad_sys, $pocet_vzoriek, $id, $time_start, $time_end), $graph_o, $load, $formula_o, $id);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $request[$id]);
                $response[$id] = curl_exec($ch);
            }
            $appUrlnejde = '';  //skryte okno pre zadanie adresy ak nenajdena aplikacia na serveri
            if ($response[1] == false) {
                break;
            }
            if (FALSE) {
                echo '<br> Aplikacia nie je spustena skontrolujte cestu k aplikacii <br>' . $appUrl . '<br>';
                $response[1] = false;
                //zmena adresy ked nefunguje defaultna adressa

                $appUrlnejde = 'Cesta k aplikácii= <input size="50" type="text" name="appUrl" value="' . $appUrl . '"><br>';
                break;
            }
            //          var_dump($response[$id]);
            $res = json_decode($response[$id]);
            $res = (array) $res->result;
            if ($id == 1) {

                $myarray[0] = $res["graphs"];
                $res = (array) $res["formulas"];
                if (empty($iter)) {
                    echo "<table> <tr><td><br></td>";
                }
                $iter = 5;
                foreach ($res["tex"] as $formula) {
                    echo '<td> <center>' . $mnnazvov[$iter] . $formula . '</center> </td>';
                    $iter++;
                }
                echo '</tr> </table>';
                $native = $res["native"];
            } else {
                $pom = $id - 1;
                $myarray[$pom] = $res["graphs"];
            }

            $response[$id] = json_decode($response[$id]);
            //    var_dump($response[$id]->result->formulas);
        }
        curl_close($ch);

        // decode response
        //$response = json_encode($response);
        if ($response[1] == false) {
            echo 'nepodarilo sa dostat odpoved zo serveru';
        } else {

            $response2 = $response[1];
            $pole = (array) $response2;
            //$response->result->formula=$result;
            //echo "<br> " . $pole['result']['result'] . "<br> ";
            $res = (array) $pole["result"];
            //var_dump($res);
            $res = (array) $res["formulas"];

            // var_dump($myarray);
        }

        // var_dump($myarray);
        // TODO pocet vzoriek FORM interval FORM
        //radio foriem
        $forma[1] = '';
        $forma[2] = '';
        $forma[3] = '';
        $forma[4] = '';
        if (empty($_POST['forma'])) {
            $forma[1] = 'checked';
        } else
            $forma[$_POST['forma']] = 'checked';

        if (empty($_POST['demo'])) {
            $demo[1] = 'checked';
        } else
            $demo[$_POST['demo']] = 'checked';
        ?>
        <table> 
            <tr><td><form action="index.php" method="post">
                        <table> 
<?php echo $appUrlnejde; ?> 
                            Vstupne udaje zadane pomocou matic <input type="radio" name="inputforma" value="zmatice" <?php echo $out[1]; ?>>
                            <tr><td> A= </td><td><input type="text" name="matlab_A" value="<?php echo $matlab_A; ?>">          </td>  </tr>
                            <td>b= </td><td><input type="text" name="matlab_b" value="<?php echo $matlab_b; ?>"> </td></tr>
                            <tr><td>ct= </td><td><input type="text" name="matlab_ct" value="<?php echo $matlab_ct; ?>"> </td></tr>
                            <tr><td>x0= </td><td><input type="text" name="matlab_x0" value="<?php echo $matlab_x0; ?>"> </td></tr>
                            <tr><td>u= </td><td><input type="text" name="matlab_u" value="<?php echo $matlab_u; ?>"> </td></tr>
                            <tr><td>Forma:</td><td><input type="radio" name="forma" value="1" <?php echo $forma[1]; ?>>Normal </td></tr>
                            <tr><td></td><td><input type="radio" name="forma" value="2" <?php echo $forma[2]; ?>>NFP </td></tr>
                            <tr><td></td><td><input type="radio" name="forma" value="3" <?php echo $forma[3]; ?>>NFR <br> </td></tr>
                            <tr><td></td><td><input type="radio" name="forma" value="4" <?php echo $forma[4]; ?>>Paralelny model<br> </td></tr>
                            <tr><td>Demo: </td><td><input type="radio" name="demo" value="1" checked>Zadane udaje</td></tr>
                            <tr><td></td><td><input type="radio" name="demo" value="2">2.radu</td></tr>
                            <tr><td></td><td><input type="radio" name="demo" value="3">3.radu</td></tr>
                            <tr><td>Pocet vzoriek</td><td><input type="text" name="vzorky" size="7" value="<?php echo $pocet_vzoriek; ?>"></td></tr>
                            <tr><td>Časový <br> interval:</td><td><input type="text" size="7" name="timestart" value="<?php echo $time_start; ?>">
                                    <input type="text" size="7" name="timeend" value="<?php echo $time_end; ?>"></td></tr>
                        </table>
                        <br>
                        <input type="submit">
                        </td>    
                        <td>      
                            <div id="graph"></div>
                            <div  id="tlacitko" style="margin:0px 0px 0px 380px;">   <button onclick="unzoom()">Reset zoomu</button> </div>
                        </td>
                        <td>  <div  id="legenda"></div>
                            <div id="debug"></div>
                            <div id="udajeinput"></div>
                        </td></tr> </table>


        Vstupne udaje zadane pomocou prenosovej funkcie <input type="radio" name="inputforma" value="zpf" <?php echo $out[2]; ?>><br>
        <table>  <center> <tr><td>  Y(s)  </td> <td> 1/U(s) </td></center>  </tr>
        <tr><td>      <input type="text" name="pfcit" style= "border-bottom-color:black; text-align: center" size="60" value="<?php echo $pf['cit']; ?>">  </td> <td>   *     <input type="text" name="umen" style= "border-bottom-color:black; text-align: center" size="15" value="<?php echo $_POST["umen"]; ?>"></td>  </tr>
        <tr><td>      <input type="text" name="pfmen" style= "border-top-color:black; text-align: center" size="60" value="<?php echo $pf['men']; ?>">    </td> <td>    *  <input type="text" name="ucit" style= "border-top-color:black; text-align: center" size="15" value="<?php echo $_POST["ucit"]; ?>"></td>  </tr>
        <tr><td>       <input type="submit"></td>  </tr>
    </form>

    <script>

        function skryvanieudajov(udaj) {
            g.setVisibility(parseInt(udaj.id), udaj.checked);
        }



        var rad =<?= $rad_sys ?>;
        var id = parseInt(rad, 10);
        id++;
        var arrays =<?php echo json_encode($myarray); ?>;
        document.getElementById("debug").innerHTML = id;

        var bod = new String("t,Y");
        for (var i = 0; i < (id - 1); i++) {
            bod += ",X" + (i + 1);
        }
        //    document.getElementById("graph").innerHTML = bod; 

        for (i = 0; i < arrays[0][0].length; i++) {
            bod += "\n";
            bod += arrays[0][0][i][0] + "," + arrays[0][0][i][1];
            for (var j = 1; j < id; j++) {
                bod += "," + arrays[j][0][i][1];
            }
        }
        bod += "\n";
        document.getElementById("graph").innerHTML = bod;

        var udajeinput = 'Zobraziť údaje : <br>';
        udajeinput += '<input type="checkbox" id="' + 0 + '" checked="" onclick="skryvanieudajov(this)"/> <label for="' + 0 + '">Y</label> <br>';
        for (i = 1; i < id; i++) {
            udajeinput += '<input type="checkbox" id="' + i + '" checked="" onclick="skryvanieudajov(this)"/> <label for="' + i + '">X' + (i) + '</label> <br>';
        }
        document.getElementById("udajeinput").innerHTML = udajeinput;
        var GrOptions = {
            legend: 'always',
            animatedZooms: true,
            title: '<div  style="margin:4px 0px 0px 69px; border: thin solid white; border-bottom-color:black ;">System</div>',
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
        g = new Dygraph(document.getElementById("graph"),
                bod,
                GrOptions);


        //document.getElementById("graph").innerHTML = "zle zadane udaje";
        //        document.getElementById("tlacitko").innerHTML = "";

        g.resize(g.width_ + 10, g.height_ + 10);


    </script>
    <script>
        function unzoom() {
            g.resetZoom();
            g.updateOptions({xRangePad: 1}, false);
            setTimeout(function() {
                g.resetZoom();
                g.updateOptions({xRangePad: 1}, false);
            }, 150);
        }
    </script>

</body>
</html>