<?php

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

function buildrequestwithbin($code, $graph_o, $load, $formula_o, $api_key, $id) {
    return '{
          "method": "eval",
          "params": {"api_key": "' . $api_key . '",
          "load": "' . $load . '",
          "code": "' . $code . '",
          "engine": "maxima",
          "graph_output": "' . $graph_o . '",
          "formula_output": ' . $formula_o . '
          },
          "id": ' . $id . '
          }';
}

function pocetbodov($time_end, $time_start, $platnecislice) {
    $koeficientvzoriek = (double) ($time_end - $time_start);
    while ($koeficientvzoriek > 10)
        $koeficientvzoriek = $koeficientvzoriek / 10;
    $pvz = round(pow(10, $platnecislice) * $koeficientvzoriek) + 1;
    return $pvz;
}

if (empty($_POST["typeinput"]))
    exit();


require 'config.php';
$time_start = $_POST["tzac"];
$time_end = $_POST["tend"];
$pocet_vzoriek=  pocetbodov($time_end, $time_start, $platnecislice);
$vstup_u = $_POST['matlab_u'] . '$';
$id = rand(141, 240);
$load = base64_encode(file_get_contents("numer.mac"));



if ($_POST["typeinput"] == 'zmatice') {
    if ($_POST["nomatlab"] == 'true') {
        $maxima_A = $_POST['matlab_A'];
        $maxima_b = $_POST['matlab_b'];
        $maxima_ct = $_POST['matlab_ct'];
        $maxima_x0 = $_POST['matlab_x0'];
        $maxima_d = $_POST['matlab_d'] . '$ ';
        $rad_sys = substr_count($_POST['matlab_ct'], ',') + 1;
    } else {
        $max_Acelk = mattomax($_POST['matlab_A'], true);
        $maxima_A = $max_Acelk[0];
        $maxima_b = mattomax($_POST['matlab_b'], false);
        $maxima_ct = mattomax($_POST['matlab_ct'], false);
        $maxima_x0 = mattomax($_POST['matlab_x0'], false);
        $maxima_d = $_POST['matlab_d'] . '$ ';
        $rad_sys = $max_Acelk[1];
    }
} elseif ($_POST["typeinput"] == 'zpf') {
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

        $odoslima = buildrequest($code, $graph_o, $formula_o, $api_key, 434);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $appUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $odoslima);
        $vypocet = curl_exec($ch);
        $vypocet = json_decode($vypocet);
        curl_close($ch);
        $vysl = (array) $vypocet->result->formulas->native;
        $maxima_d = $vysl[0];
        $pfcitold = $_POST["pfcit"];
        $_POST["pfcit"] = str_replace("$", "", $vysl[1]);
    } else {
        $maxima_d = '0$ ';
    }
    $max = pf2stav($_POST["pfcit"], $_POST["pfmen"]);
    $maxima_A = $max[1];
    $maxima_b = $max[2];
    $maxima_ct = $max[3];
    $rad_sys = $max[4];  
    if ($_POST["nomatlab"] == 'true') {
        $maxima_x0 = $_POST['matlab_x0'];
    } else
        $maxima_x0 = mattomax($_POST["matlab_x0"], false);
    if (strpos($maxima_x0, '1') || strpos($maxima_x0, '2') || strpos($maxima_x0, '3') || strpos($maxima_x0, '4') || strpos($maxima_x0, '5') || strpos($maxima_x0, '6') || strpos($maxima_x0, '7') || strpos($maxima_x0, '8') || strpos($maxima_x0, '9')) {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $appUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $code = 'A:'
        . $maxima_A
        .' b:'
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
        if (strpos($novepodmienky->result->result, "undefined: 0 to a negative exponent") != FALSE ) {
            echo json_encode('nie je možné vytvoriť transformačnú maticu');
            exit();
        }

        $novepodmienky=(array)$novepodmienky->result->formulas;
        
        $maxima_x0=$novepodmienky['native'][0];
        curl_close($ch);
    }
}



$grafyvykstr = '';

$rovnice = '';   
if (!((($rad_sys - 1) == substr_count($_POST['matlab_x0'], ' ')) || (($rad_sys - 1) == substr_count($_POST['matlab_x0'], ';'))|| (($rad_sys - 1) == substr_count($_POST['matlab_x0'], ','))))
    $maxima_x0 = 'ematrix(length(A),1, 0,1,1)$ ';
if ($rad_sys == 0)
    $maxima_x0 = '0$ '; 


if (($_POST['zobraz'] == 'false') && ($_POST['graf'] == 'false'))
    exit();
if ($_POST['zobraz'] == 'true') {
    $rovnice = 'matrix([y]); ';
    if ($_POST["typeinput"] == 'zpf') {
        
    } else
        $rovnice.=' stavpremX; ';
}
if ($_POST['graf'] == 'true') {
    $grafyvykstr.= ' plot2d([parametric,t,ev(yg),[t,'
            . $time_start
            . ','
            . $time_end
            . '],[nticks, '
            . $pocet_vzoriek
            . ']])$\r\n ';
    if ($_POST["typeinput"] == 'zpf') {
        
    } else {
        for ($itr = 1; $itr <= $rad_sys; $itr++) {
            $grafyvykstr.=' plot2d([parametric,t,ev(stavpremX['
                    . $itr
                    . '][1]),[t,'
                    . $time_start
                    . ','
                    . $time_end
                    . '],[nticks,'
                    . $pocet_vzoriek
                    . ']])$\r\n ';
        }
    }

}

//prvy prepocet
$code = ' assume(t>0)$'
        . 'fpprintprec:8$'
        . ' A: '
        . $maxima_A
        . ' b:'
        . $maxima_b
        . ' ct:'
        . $maxima_ct
        . ' d:'
        . $maxima_d
        . ' x0:'
        . $maxima_x0
        . ' u:'
        . $vstup_u
        . ' comboilt(f,s,t):=block([transf],(if not freeof(s,transf:ilt(f,s,t)) then transf:nilt(f,s,t)),return(transf))$'
        . ' n:length(A)$'
        . ' charmat:s*ident(n)-A$ '
        . ' rez:factor(invert(charmat))$'
        . ' tilt(x):=comboilt(x,s,t)$'
        . ' fund:matrixmap(tilt, if not matrixp(rez) then matrix([rez]) else rez)$'
        . ' vlastzl:fund.x0$'
        . ' G(a):=integrate(a, tau,0,t)$'
        . ' u:expand(subst(tau,t,u))$'
        . ' pom:(if not matrixp((subst(-tau,t,fund))) then matrix([(subst(-tau,t,fund))]) else (subst(-tau,t,fund))).b*u$'
        . ' pom:if not matrixp(pom) then matrix([pom]) else pom$ '
        . ' vnutenazl:expand(fund.matrixmap(G, pom))$ '
        . ' vnutenazl:if not matrixp(vnutenazl) then matrix([vnutenazl]) else vnutenazl$'
        . ' stavpremX:vlastzl+vnutenazl$'
        . ' yg:(ct.((if not matrixp(vlastzl) then matrix([vlastzl]) else vlastzl )+vnutenazl)+d*u)$'
        . ' y:multthru(combine(distrib(factor(demoivre(expand(radcan(factor(expand(exponentialize(yg))))))))))$'
        . ' if (slength(string(y))>150) then y:eval_string(ssubst(\"*10**\", \"b\", string(distrib(expand(bfloat(y))))))$'
        . $grafyvykstr
        . ' stavpremX:expand(multthru(combine(distrib(factor(demoivre(expand(radcan(factor(expand(exponentialize(stavpremX)))))))))))$'
        . ' if slength(string(stavpremX[1]))>100 then stavpremX:eval_string(ssubst(\"*10**\", \"b\", string(distrib(expand(bfloat(stavpremX))))))$'
        . ' if listp(stavpremX) then stavpremX:matrix([stavpremX[1]])$'
        . $rovnice


;
//var_dump($code);
//struktura poziadavku

$request = buildrequestwithbin($code, $graph_o, $load, $formula_o, $api_key, $id);

//odoslanie poziadavku
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $appUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
$response = curl_exec($ch);
//var_dump($response);
curl_close($ch);


if ($response == false || $response == '' || empty($response)) {
    echo json_encode('nepodarilo sa spojit so serverom');
} else {
    $odpoved = json_decode($response)->result;
    $odpoved->result = $rad_sys;
    //var_dump($odpoved->formulas);
    if (!empty($odpoved->formulas->tex))
        $odpoved->formulas->tex = json_encode($odpoved->formulas->tex);
    if (!empty($odpoved->formulas->native))
        $odpoved->formulas->native = json_encode($odpoved->formulas->native);
    //$odpoved->formulas =addslashes ((array)$odpoved->formulas->tex);        
    echo $res = json_encode($odpoved);
}



