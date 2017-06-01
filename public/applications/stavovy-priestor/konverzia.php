<?php

function coef2poly($coef) {
    $poly = '';
    $switch = true;
    for ($it = strlen($coef) - 2, $cf = 0; $coef[$it] <> '['; $it--) {

        if ((($coef[$it] == '0') || ($coef[$it] == '1') || ($coef[$it] == '2') || ($coef[$it] == '3') || ($coef[$it] == '4') || ($coef[$it] == '5') || ($coef[$it] == '6') || ($coef[$it] == '7') || ($coef[$it] == '8') || ($coef[$it] == '9')) && $switch) {
            $poly.=$cf . '**s*';
            $cf++;
            $switch = false;
        }
        if ($coef[$it] == ' ') {
            $switch = true;
            if (!($coef[$it - 1] == '[' || $coef[$it + 1] == ']' || $coef[$it + 1] == ',' || $coef[$it + 1] == ',')) {
                $coef[$it] = '+';
            }
        }
        $poly.=$coef[$it];
    }

    $cf--;
    $out[1] = strrev($poly);
    $out[2] = $cf;
    return $out;
}

function mattomax($matica, $nxn) { //funkcia na prelozenie matlab kodu matice do maximy aj je true overuje aj ci je stvorcova  a daj je velkost
    $rows = 0;
    if ($matica == '0') {
        return '0' . '$';
    }
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
            . $A
            . ' b:'
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
    $codeNFR.=' t1t:matrix(invert(Qr)[' . $rozmer . '])$   IT:t1t$ ';
    for ($it = 1; $it < ($rozmer); $it++) {
        $codeNFR.='  IT:addrow(IT,' . $T . ')$ ';
        $T.='.A';
    }
    $codeNFR.="fpprintprec:3$ "
            . " T:invert(IT)$"
            . 'Ar:IT.A.T;   '
            . 'br:IT.b;   '
            . 'ctr:ct.T; '
            . 'x0r:IT.x0$ '
            . 'x0r:x0r; ';
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
            . '   Qp:ct$ '
            . "fpprintprec:3$ ";
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
            . 'x0r:T.x0$ '
            . 'x0r:x0r; ';
    return $codeNFP;
}

function toParalModel($A, $b, $ct, $x0, $rozmer) {//normalna forma pozorovatelnosti
    $codePM = ' load(\"diag\")$ '
            . "fpprintprec:5$ "
            . ' A:'
            . $A .
            '   b:'
            . $b
            . ' ct:'
            . $ct
            . ' x0:'
            . $x0
            . ' T:ModeMatrix(A,jordan(A))$'
            . ' IT:invert(T)$'
            . ' Aj:IT.A.T$ '
            . ' bj:IT.b$ '
            . ' ctj:ct.T$ '
            . 'x0r:expand(IT.x0)$ '
            . ' roundme(x):=if (abs(x)<0.000001) then x:0 else x$'
            . ' if (slength(string(Aj[1][1]))>20) then block(Aj:expand(float(Aj)),bj:expand(float(bj)),ctj:expand(float(ctj)),x0r:expand(float(x0r)))$'
            . ' Aj:matrixmap(roundme,Aj);'
            . ' bj:matrixmap(roundme,bj);'
            . ' ctj:matrixmap(roundme,ctj);'
            . ' x0r:matrixmap(roundme,x0r); ';

    return $codePM;
}

function toPF($A, $b, $ct, $x0, $d) {
    
    if (strpos($x0, '1') || strpos($x0, '2') || strpos($x0, '3') || strpos($x0, '4') || strpos($x0, '5') || strpos($x0, '6') || strpos($x0, '7') || strpos($x0, '8') || strpos($x0, '9')) {
           // KONVERZIA PODMIENOK DO DIFFERENCIALNEJ ROVNICE
        $dodatok = 'n:length(A)$'
                . 'Qr:ct$'
                . 'Qrnas:ct$'
                . 'for x:2 step 1 thru length(A) do block(Qrnas:Qrnas.A,Qr:addrow(Qr,Qrnas))$'
                . 'y0:Qr.x0;';
    } else {
        $dodatok = 'x0; ';
    }

    $codePF = "fpprintprec:3$ "
            . ' A:'
            . $A .
            '   b:'
            . $b
            . ' ct:'
            . $ct
            . ' d:'
            . $d
            . ' PF:ratsimp(factor(expand(ct.invert(s*ident(length(A))-A).b)))$ '
            . 'PF:ratsimp(factor(PF:PF+denom(PF)*d/denom(PF)));'
            . 'reverse(makelist(coeff(num(PF),s,i),i,0,hipow(num(PF),s))); '
            . 'reverse(makelist(coeff(denom(PF),s,i),i,0,hipow(denom(PF),s))); '
            . 'x0:'
            . $x0
            . $dodatok;
    return $codePF;

}

function buildrequest($code, $graph_o, $formula_o, $api_key, $id) {
    return '{
              "method": "eval",
              "params": {"api_key": "' . $api_key . '",
              "code": "' . $code . '",
              "engine": "maxima",
              "graph_output": "' . $graph_o . '",
              "formula_output": ' . $formula_o . '
              },
              "id": ' . $id . '
              }';
}

function polynomtoarr($polynom) {
    $zvysok = strchr($polynom, "[");
    $start = false;
    $cislo = "";
    $ind = 0;
    for ($it = 0; $it < strlen($zvysok); $it++) {
        if (($zvysok[$it] <> ' ') || ($zvysok[$it] <> ','))
            $start = true;
        if ((($zvysok[$it] == ' ') || ($zvysok[$it] == ',')) && ($start)) {
            $a[$ind] = $cislo;
            $cislo = "";
            $ind++;
        }
        if (($zvysok[$it] == '-') || ($zvysok[$it] == '0') || ($zvysok[$it] == '1') || ($zvysok[$it] == '2') || ($zvysok[$it] == '3') || ($zvysok[$it] == '4') || ($zvysok[$it] == '5') || ($zvysok[$it] == '6') || ($zvysok[$it] == '7') || ($zvysok[$it] == '8') || ($zvysok[$it] == '9') || ($zvysok[$it] == '.')) {
            $cislo.=$zvysok[$it];
        }
        if ($zvysok[$it] == ']') {
            $a[$ind] = $cislo;
            break;
        }
    }
    return $a;
}

function pf2stav($pfcit, $pfmen) { //funkcia na prevod z prenosovej fcie do stavoveho priestoru
    $b = array_reverse(polynomtoarr($pfcit), false);
    $a = array_reverse(polynomtoarr($pfmen), false);
    $rad_sys = count($a) - 1;
    if ($a[$rad_sys] <> 1) {
        for ($it = 0; $it <= count($b) - 1; $it++) {
            $b[$it].='/(' . $a[$rad_sys] . ')';
        }
        for ($it = 0; $it <= $rad_sys; $it++) {
            $a[$it].='/(' . $a[$rad_sys] . ')';
        }
    }
    for ($it = count($b); $it < $rad_sys; $it++) {
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

if (empty($_POST["type"]))
    exit();

require 'config.php';

if ($_POST["type"] == 'zmatice') {
    $matlab_A = $_POST["matlab_A"];
    $matlab_b = $_POST["matlab_b"];
    $matlab_ct = $_POST["matlab_ct"];
    $matlab_x0 = $_POST["matlab_x0"];
    $maxima_d = $_POST["matlab_d"] . '$';

    $max_Acelk = mattomax($matlab_A, true);
    $maxima_A = $max_Acelk[0];
    $maxima_b = mattomax($matlab_b, false);
    $maxima_ct = mattomax($matlab_ct, false);
    $maxima_x0 = mattomax($matlab_x0, false);
    $rad_sys = $max_Acelk[1];
}
if ($_POST["type"] == 'zpf') {
    $pfcit = coef2poly($_POST["pfcit"]);
    $pfmen = coef2poly($_POST["pfmen"]);
    $rcit = $pfcit[2];
    $rmen = $pfmen[2];

    if ($pfcit[2] > $pfmen[2]) {
        echo 'Takýto systém nie je realizovateľný';
        exit();
    }
    if ($pfcit[2] == $pfmen[2]) {
        $code = "cit: "
                . $pfcit[1]
                . "$ men: "
                . $pfmen[1]
                . "$ vys:expand(divide(cit,men))$ "
                . "fpprintprec:3$ "
                . "vys[1]; "
                . "reverse(makelist(coeff(vys[2],s,i),i,0,hipow(vys[2],s)));";

        $odoslima = buildrequest($code, $graph_o, $formula_o, $api_key, 433);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $appUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $odoslima);
        $vypocet = curl_exec($ch);
        if ($vypocet == false) {
            echo json_encode('nepodarilo sa spojit so serverom');
            exit();
        }
        $vypocet = json_decode($vypocet);
        curl_close($ch);
        $vysl = (array) $vypocet->result->formulas->native;
        $maxima_d = $vysl[0];
        $pfcitold = $_POST["pfcit"];
        $pfmenold = $_POST["pfmen"];
        $_POST["pfcit"] = str_replace("$", "", $vysl[1]);
    }
    $matlab_x0 = $_POST["matlab_x0"];
    $max = pf2stav($_POST["pfcit"], $_POST["pfmen"]);
    $maxima_A = $max[1];
    $maxima_b = $max[2];
    $maxima_ct = $max[3];
    $rad_sys = $max[4];
    $maxima_x0 = mattomax($matlab_x0, false);
    // KONVERZIA PODMIENOK Z DIFFERENCIALNEJ ROVNICE
    if (strpos($maxima_x0, '1') || strpos($maxima_x0, '2') || strpos($maxima_x0, '3') || strpos($maxima_x0, '4') || strpos($maxima_x0, '5') || strpos($maxima_x0, '6') || strpos($maxima_x0, '7') || strpos($maxima_x0, '8') || strpos($maxima_x0, '9')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $appUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $code = 'A:'
                . $maxima_A
                . ' b:'
                . $maxima_b
                . '   ct:'
                . $maxima_ct
                . 'y0:'
                . $maxima_x0
                . 'n:length(A)$'
                . 'Qr:ct$'
                . 'Qrnas:ct$'
                . 'for x:2 step 1 thru length(A) do block(Qrnas:Qrnas.A,Qr:addrow(Qr,Qrnas))$'
                . 'invert(Qr).y0;';
        $odoslima = buildrequest($code, $graph_o, $formula_o, $api_key, 200 + rand(241, 340));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $odoslima);
        $novepodmienky = curl_exec($ch);
        if ($novepodmienky == false) {
            echo json_encode('nepodarilo sa spojit so serverom');
            exit();
        }
        $novepodmienky = json_decode($novepodmienky);
        if (strpos($novepodmienky->result->result, "undefined: 0 to a negative exponent") != FALSE) {
            echo json_encode('nie je možné vytvoriť transformačnú maticu');
            exit();
        }

        $novepodmienky = (array) $novepodmienky->result->formulas;

        $maxima_x0 = $novepodmienky['native'][0];
    }
}


if (empty($maxima_d))
    $maxima_d = '0$';
$zmenasyst = '';
if (!((($rad_sys - 1) == substr_count($_POST['matlab_x0'], ' ')) || (($rad_sys - 1) == substr_count($_POST['matlab_x0'], ';'))))
    $maxima_x0 = 'ematrix(length(A),1, 0,1,1)$ ';

if ($_POST["forma"] <> '1') {
    if ($_POST["forma"] == '2')
        $zmenasyst = toNFP($maxima_A, $maxima_b, $maxima_ct, $maxima_x0, $rad_sys);
    if ($_POST["forma"] == '3')
        $zmenasyst = toNFR($maxima_A, $maxima_b, $maxima_ct, $maxima_x0, $rad_sys);
    if ($_POST["forma"] == '4')
        $zmenasyst = toParalModel($maxima_A, $maxima_b, $maxima_ct, $maxima_x0, $rad_sys);
    if ($_POST["forma"] == '5' || $_POST["forma"] == '6')
        $zmenasyst = toPF($maxima_A, $maxima_b, $maxima_ct, $maxima_x0, $maxima_d);
    //  var_dump($zmenasyst);
    $odoslima = buildrequest($zmenasyst, $graph_o, $formula_o, $api_key, rand(241, 340));

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $appUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $odoslima);
    $novysystem = curl_exec($ch);

    if ($novysystem == false) {
        echo json_encode('nepodarilo sa spojit so serverom');
    } else {

        $novysystem = json_decode($novysystem);
        /*        if (!(strpos()==FALSE)) {

          } */
        if (strpos($novysystem->result->result, "undefined: 0 to a negative exponent") != FALSE || $rad_sys == 0) {
            echo json_encode('nie je možné vytvoriť transformačnú maticu');
            exit();
        }
        $novysystem = (array) $novysystem->result->formulas;
        if ($_POST["type"] == 'zpf') {

            if ($rcit == $rmen) {

                //$novysystem['tex'][4] = array($vypocet->result->formulas->tex);
                $novpom = array($vypocet->result->formulas->tex);
                array_push($novysystem['tex'], $novpom[0][0]);
                //   $novysystem['tex'][4] = $novysystem['tex'][4][0][0];
                //   $novysystem['native'][4] = $maxima_d;
                array_push($novysystem['native'], $maxima_d);
                if ($_POST["forma"] == '5' || $_POST["forma"] == '6') {
                    $novysystem['native'][1] = $pfcitold;
                    $novysystem['native'][2] = $pfmenold;
                }
                //    }
            } else {
                array_push($novysystem['tex'], '$$' . $maxima_d . '$');
                array_push($novysystem['native'], $maxima_d);
            }
        }
        if ($_POST["type"] == 'zmatice') {
            array_push($novysystem['tex'], '$$' . $maxima_d . '$');
            array_push($novysystem['native'], $maxima_d);
        }
        echo json_encode($novysystem);
    }
}