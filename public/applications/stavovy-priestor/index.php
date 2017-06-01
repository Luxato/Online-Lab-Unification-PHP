<link rel="stylesheet" type="text/css" href="<?= $path ?>style.css">
<link rel="stylesheet" type="text/css" href="<?= $path ?>styleknazek.css">
<script src="<?= $path ?>scripts/dygraph-combined.js"></script>
<script src="<?= $path ?>scripts/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?= $path ?>scripts/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
<script src="<?= $path ?>scripts/jquery.balloon.js"></script>
<script>
    var baseUrl = '<?= $path ?>';
</script>
<style>
    .form-group input, td input {
        margin: 10px 0;
    }
    td input {
        margin-right: 5px;
    }
</style>
<div id='container' style="padding: 15px;background-color: #E6E6E6;border: 1px solid black;border-radius: 19px;">
    <fieldset style="background-color:#E6E6E6;">
        <h3> Vstupné údaje chcem zadať pomocou : <br></h3>
        <table border="0">
            <tr style="background-color:#E6E6E6;">
                <td>
                    <div id="inp1" style="float:left;"> matíc stavového priestoru
                        <input type="radio" name="inputforma" value="zmatice" style="margin-top:0px;">&nbsp&nbsp&nbsp
                    </div>
                </td>
                <td>
                    <div id="inp2" style="margin-left:0px;float:left;"> prenosovej funkcie
                        <input type="radio" name="inputforma" value="zpf" style="margin-top:0px;"> &nbsp&nbsp&nbsp
                    </div>
                </td>
            </tr>

            <tr style="background-color:#E6E6E6;">
                <td>
                    <div id="inp4" style="margin-left:0px;float:left;"> diferenciálnej rovnice
                        <input type="radio" name="inputforma" value="diff" style="margin-top:0px;"> &nbsp&nbsp&nbsp
                    </div>
                </td>
                <td>
                    <div id="inp3" style="float:left;"> vzorových príkladov
                        <input type="radio" name="inputforma" value="demo" style="margin-top:0px;"> &nbsp&nbsp&nbsp
                    </div>
                </td>
            </tr>
        </table>

    </fieldset>


    <fieldset class="form-inline" id="slide1" style="background-color:#E6E6E6;display:none;">
        <legend class="legenda" style="width: 100%;">
            <img class="quit" style="display:none" src="<?= $path ?>tlacoff.png" alt="X">
            <img class="maximize" style="display:none" src="<?= $path ?>tlacdole.png" alt="---">
            <br> Zadajte jednotlivé vektory/matice v matlabovskej syntaxi:
        </legend>
        <div>
            <form class="form-inline">
                <div class="col-md-6">
                    <div class="form-group">
                        <label style="display: inline;" for="email">A=:</label>
                        <input class="form-control" type="text" name="matlab_A" value="[0 1 0;0 0 1;-1 -3 -3]">
                        <a data-toggle="tooltip" title="Maticu systému v tvare n x n napr. [0 1 0;0 0 1;-1 -3 -3]"><i style="font-size:19px;" class="fa fa-question-circle" aria-hidden="true"></i></a>
                    </div>
                    <div class="form-group">
                        <label style="display: inline;" for="email">b=:</label>
                        <input class="form-control" type="text" name="matlab_b" value="[1;1;2]">
                        <a data-toggle="tooltip" title="Riadiaci stĺpcový vektor s rozmermi n x 1 napr [1;1;2]"><i style="font-size:19px;" class="fa fa-question-circle" aria-hidden="true"></i></a>
                    </div>
                    <div class="form-group">
                        <label style="display: inline;" for="email">c<sup>t</sup>=</label>
                        <input class="form-control" type="text" name="matlab_ct" value="[1 1 1]">
                        <a data-toggle="tooltip" title="Riadkový výstupný vektor s rozmermi 1 x n napr v  tvare [1 0 1]"><i style="font-size:19px;" class="fa fa-question-circle" aria-hidden="true"></i></a>
                    </div>
                    <div class="form-group">
                        <label style="display: inline;" for="email">d=</label>
                        <input class="form-control" type="text" name="matlab_d" value="0">
                        <a data-toggle="tooltip" title="Priama väzba medzi vstupom a výstupom napr. 2"><i style="font-size:19px;" class="fa fa-question-circle" aria-hidden="true"></i></a>
                    </div>
                    <div class="form-group">
                        <label style="display: inline;" for="email">x<sub>0</sub>=</label>
                        <input class="form-control" type="text" name="matlab_x0" value="[0 0 0]'">
                        <a data-toggle="tooltip" title="Začiatočné podmienky napríklad v tvare  [0 0 0]' - ' je transponovanie na stlpcový vektor"><i style="font-size:19px;" class="fa fa-question-circle" aria-hidden="true"></i></a>
                    </div>
                </div>
            </form>
            <div class="col-md-6">
                        <button class="btn btn-success" id="showmemat" style="">Ukáž</button>
                        <button class="konvshow btn btn-info" style="margin-left: 1.5cm">Konverzia</button>
                        <button class="casriesshow btn btn-info" style="">Riešenie</button>

            </div>
            <div id="shownmat" class='showshow'></div>
            <div class="legenda">
                <img class="minimize" style="" src="<?= $path ?>tlachore.png" alt="▲">
            </div>
        </div>
    </fieldset>


    <fieldset id="slide2" style="background-color:#E6E6E6;display:none;">
        <legend class="legenda">
            <img class="quit" style="display:none" src="<?= $path ?>tlacoff.png" alt="X">
            <img class="maximize" style="display:none" src="<?= $path ?>tlacdole.png" alt="---">
            <br> Prenosová funkcia v tvare polynómov :
        </legend>
        <div>
            <table border="0">
                <tr style="background-color:#E6E6E6;">
                    <td>Čitateľ:</td>
                    <td><input class="form-control" type="text" name="pfcit" style="text-align: center" size="60"
                               value="[1 2]"></td>
                        <td> <a data-toggle="tooltip" title="Vektor koeficientov čitateľa prenosovej funkcie napr.[1 2]"><i style="font-size:19px;" class="fa fa-question-circle" aria-hidden="true"></i></a>


                        <input class="form-control" type="text" name="pf_x0" style="text-align: center;display:none"
                               size="60" value="[0]">
                        <!--      <img class="help" style="" id='help_x0pf' title="stlpcový vektor začiatočných podmienok s dĺžkou n v  napr.tvare  [0 0 0]' - ' je transponovanie" src="<?= $path ?>tlacinfo.png" alt="i">
--></td>
                </tr>
                <tr style="background-color:#E6E6E6;">
                    <td>Menovateľ:</td>
                    <td><input class="form-control" type="text" name="pfmen" style="text-align: center" size="60"
                               value="[1 3 3 1]">
                    </td>
                    <td><a data-toggle="tooltip" title="Vektor koeficientov menovateľa prenosovej funkcie napr. pre systém 3.rádu [1 3 3 1]"><i style="font-size:19px;" class="fa fa-question-circle" aria-hidden="true"></i></a>
                    </td>
                </tr>
            </table>
            <br>
            <table border="0">
                <tr style="background-color:#E6E6E6;">
                    <td></td>
                    <td>
                        <button class="btn btn-success" id="showmepf" style="">Ukáž</button>
                        <button class="konvshow btn btn-info" style="margin-left:1.5cm;">Konverzia</button>
                        <button class="casriesshow btn btn-info" style="">Riešenie</button>
                    </td>
                </tr>
            </table>
            <br>
            <br>
            <br>
            <div id="shownpf" class='showshow' style=""></div>
            <div class="legenda">
                <img class="minimize" style="" src="<?= $path ?>tlachore.png" alt="▲">
            </div>
        </div>
    </fieldset>


    <fieldset id="slide3" style="background-color:#E6E6E6;display:none;">

        <legend class="legenda">
            <img class="quit" style="display:none" src="<?= $path ?>tlacoff.png" alt="X">
            <img class="maximize" style="display:none" src="<?= $path ?>tlacdole.png" alt="---">
            <br>Vyberte si jeden z nasledujúcich vzorových príkladov
        </legend>
        <div>
            <table border="0">
                <tr style="background-color:#E6E6E6;">
                    <td><input type="radio" name="demo" value="1" style="margin-top:0px;"></td>
                    <td>nestabilný systém 2.rádu</td>
                </tr>
                <tr style="background-color:#E6E6E6;">
                    <td><input type="radio" name="demo" value="2" style="margin-top:0px;"></td>
                    <td>stabilný systém 2.rádu</td>
                </tr>
                <tr style="background-color:#E6E6E6;">
                    <td><input type="radio" name="demo" value="3" style="margin-top:0px;"></td>
                    <td>stabilný systém 3.rádu</td>
                </tr>
            </table>
            <div class="legenda">
                <img class="minimize" style="" src="<?= $path ?>tlachore.png" alt="▲">
            </div>
        </div>
    </fieldset>


    <fieldset id="slide4" style="background-color:#E6E6E6;display:none;">
        <legend class="legenda">
            <img class="quit" style="display:none" src="<?= $path ?>tlacoff.png" alt="X">
            <img class="maximize" style="display:none" src="<?= $path ?>tlacdole.png" alt="---">
            <br> Zadaj diferenciálnu rovnicu:
        </legend>
        <div>
            <table border="0">
                <tr style="background-color:#E6E6E6;">
                    <td>Rovnica:</td>
                    <td><input class="form-control" type="text" name="diff" style="text-align: center;width:500px;"
                               size="60" value="D3y+3D2y+3Dy+y=Du+2u"></td>
                    <td><a data-toggle="tooltip" title="píšte v tvare ŷ(t)=ũ(t)napr: ...+3D2y+3Dy+y=...Du+2u"><i style="font-size:19px;" class="fa fa-question-circle" aria-hidden="true"></i></a></td>
                </tr>
            </table>
            <table border="0">
                <tr style="background-color:#E6E6E6;">
                    <td>ŷ<sub>0</sub>= <br></td>
                    <td><input class="form-control" type="text" name="diff_y0" style="text-align: center" size="60"
                               value="[0 0 0]"></td>
                    <td><a data-toggle="tooltip" title="Stlpcový vektor začiatočných podmienok rozmermi n x 1 v  napr.tvare  [y(0) dy(0) d2y(0) d3y(0) ...]' - ' je transponovanie, podmienky u(0) du(0) d2u(0).. uvažujeme nulové"><i style="font-size:19px;" class="fa fa-question-circle" aria-hidden="true"></i></a>
                </tr>

            </table>
            <br>
            <table border="0">
                <tr style="background-color:#E6E6E6;">
                    <td></td>
                    <td>
                        <button class="btn btn-success" id="showmediff" style="">Ukáž</button>
                        <button class="konvshow btn btn-info" style="margin-left:1.5cm;">Konverzia</button>
                        <button class="casriesshow btn btn-info" style="">Riešenie</button>
                    </td>
                </tr>
            </table>

            <div id="showndiff" class='showshow' style=""></div>
            <div class="legenda">
                <img class="minimize" style="" src="<?= $path ?>tlachore.png" alt="▲">
            </div>
        </div>
    </fieldset>


    <fieldset id="convert" style="background-color:#E6E6E6;margin-top:0px;display:none;">
        <legend class="legenda">
            <img class="quit" style="" src="<?= $path ?>tlacoff.png" alt="X">
            <img class="maximize" id="maximize1" style="display:none" src="<?= $path ?>tlacdole.png" alt="---">
            <br> Konvertuj do
        </legend>
        <div>
            <table border="0">
                <tr style="background-color:#E6E6E6;">
                    <td></td>
                    <td><input type="radio" name="forma" value="2" style="margin-top:0px;">Normálnej formy
                        pozorovateľnosti
                    </td>
                </tr>
                <tr style="background-color:#E6E6E6;">
                    <td></td>
                    <td><input type="radio" name="forma" value="3" style="margin-top:0px;">Normálnej formy riaditeľnosti
                        <br></td>
                </tr>
                <tr style="background-color:#E6E6E6;">
                    <td></td>
                    <td><input type="radio" name="forma" value="4" style="margin-top:0px;">Paralelneho modelu(pre
                        systémy s reálnymi koreňmi)<br></td>
                <tr style="background-color:#E6E6E6;">
                    <td></td>
                    <td>
                        <div id="convertpf" style="display:none;"><input type="radio" name="forma" value="5"
                                                                         style="margin-top:0px;">Do prenosovej funkcie
                        </div>
                    </td>
                <tr style="background-color:#E6E6E6;">
                    <td></td>
                    <td>
                        <div id="convertdiff" style="display:none;"><input type="radio" name="forma" value="6"
                                                                           style="margin-top:0px;">Do differenciálnej
                            rovnice
                        </div>
                    </td>
                    <td>
                        <button id="doformy" style="margin-right:-30px;float:right;">Konvertovať</button>
                    </td>
                </tr>
            </table>
            <div id="matice" style="background-color:#E6E6E6;"></div>
            <div class="legenda">
                <img class="minimize" style="" src="<?= $path ?>tlachore.png" alt="▲">
            </div>
        </div>
    </fieldset>

    <fieldset id="riesavykresli" style="background-color:#E6E6E6;margin-top:0px;display:none;">
        <legend class="legenda">
            <img class="quit" style="" src="<?= $path ?>tlacoff.png" alt="X">
            <img class="maximize" id="maximize2" style="display:none" src="<?= $path ?>tlacdole.png" alt="---"> <br>
            Zadaj vstupný signál pre riešenie systému
        </legend>

        <div>
            <table border="0">
                <tr style="background-color:#E6E6E6;">
                    <td><input type="checkbox" class="bothgraph" name="drawfrominput" checked> Vypočítať pre zadané
                        údaje
                    </td>
                    <td>
                        <div id="afterconvert" style='display:none;'><input type="checkbox" class="bothgraph"
                                                                            name="drawfromconvert">Vypočítať pre
                            konverziu
                        </div>
                    </td>
                </tr>
            </table>
            <table border="0">
                <tr style="background-color:#E6E6E6;">
                    <td>u=</td>
                    <td><input class="form-control" type="text" name="matlab_u" value="1"></td>
                    <td><img class="help" style="" id='help_u'
                             title="vstupný signál napr jednotkový skok - 1 alebo rampa - pi*t"
                             src="<?= $path ?>tlacinfo.png" alt="i"></td>
                </tr>
                <tr style="background-color:#E6E6E6;">
                    <td>D=</td>
                    <td><input class="form-control" type="text" name="delay" value="0"></td>
                    <td><img class="help" style="" id='help_D' title="dopravné oneskorenie"
                             src="<?= $path ?>tlacinfo.png" alt="i"></td>
                </tr>
            </table>
            <table border="0">
                <tr style="background-color:#E6E6E6;">
                    <td></td>
                    <td><input type="checkbox" name="riesenie" checked> Vypočítať odozvu systému</td>
                    <td>
                        <input type="checkbox" name="vykresligraf" class="bothgraph"> Vykresliť graf<br></td>
                </tr>
                <tr style="background-color:#E6E6E6;">
                    <td></td>
                    <td>
                        <div style="display:none" id="bothgraphs"><input type="checkbox" name="drawboth"> Vykresliť do
                            jedného grafu <br></div>
                    </td>
                </tr>
                <tr style="background-color:#E6E6E6;">
                    <td></td>
                    <td></td>
                    <td>
                        <button id="odoslat" style="">Odoslať</button>
                    </td>
                </tr>
            </table>

            <div id="paramgraf" style="background-color:#E6E6E6;margin-top:0px;display:none;">
                <br> Zadaj parametre pre vykreslenie grafu <br> <br>
                <table border="0">
                    <tr style="background-color:#E6E6E6;">
                        <td>Časový interval od</td>
                        <td><input class="form-control" type="text" size="7" name="timestart"
                                   style="width:40px;text-align:center;" value="0"> do <input type="text" size="7"
                                                                                              style="width:40px;text-align:center;"
                                                                                              name="timeend" value="5">
                        </td>
                    </tr>
                </table>
                <table border="0">
                    <tr style="background-color:#E6E6E6;">
                        <td>Presnost=</td>
                        <td><input class="form-control" type="text" name="precision" size="7"
                                   style="width:40px;text-align:center;" value="2"></td>
                        <td><img class="help" style="" id='help_prec'
                                 title="Počet zobrazených desatinných miest v grafe zadaj celé číslo od 1-7(je možné zmeniť aj po vykreslení grafu)"
                                 src="<?= $path ?>tlacinfo.png" alt="i"></td>
                    </tr>
                </table>
            </div>

            <div class="legenda">
                <img class="minimize" style="" src="<?= $path ?>tlachore.png" alt="▲">
            </div>
        </div>
    </fieldset>


    <fieldset id="vykreslenie" style="background-color:#E6E6E6;margin-top:0px;display:none;">

        <legend class="legenda">
            <img class="quit" style="" src="<?= $path ?>tlacoff.png" alt="X">
            <img class="maximize" id="maximize3" style="display:none" src="<?= $path ?>tlacdole.png" alt="---">
            <br> Priebeh výstupnej veličiny a stavových veličín systému v čase
        </legend>
        <div>
            <table><br>
                <tr style="background-color:#E6E6E6;">
                    <td>
                        <div id="graf"></div>
                        <br>
                        <button id="oddial" style="display:none">Oddialiť</button>
                        <img id="download" title="ulož údaje do súboru vo formáte csv"
                             style="width: 50px;height: 50px;display:none;margin-top:-8px;"
                             src="<?= $path ?>tlacdwld.png" alt="-↓-"></td>
                    <td>
                        <div id="legenda"></div>
                    </td>
                    <td>
                        <div id="udajeinput"></div>
                    </td>
                <tr style="background-color:#E6E6E6;"></tr>
                <tr style="background-color:#E6E6E6;">
                    <td>
                        <div id="grafconvert"></div>
                        <br>
                        <button id="oddialconvert" style="display:none">Oddialiť</button>
                        <img id="downloadconvert" title="ulož údaje do súboru vo formáte csv"
                             style="width: 50px;height: 50px;margin-top:-8px;display:none;"
                             src="<?= $path ?>tlacdwld.png" alt="-↓-"></td>
                    <td>
                        <div id="legendaconvert"></div>
                    </td>
                    <td>
                        <div id="udajeinputconvert"></div>
                    </td>
                <tr style="background-color:#E6E6E6;">
                    <td></td>
                </tr>
            </table>
            <div class="legenda">
                <img class="minimize" style="" src="<?= $path ?>tlachore.png" alt="▲">
            </div>

        </div>

    </fieldset>

    <fieldset id="vypis" style="background-color:#E6E6E6;margin-top:0px;display:none;">
        <legend class="legenda">

            <img class="quit" style="" src="<?= $path ?>tlacoff.png" alt="X">
            <img class="maximize" id="maximize4" style="display:none" src="<?= $path ?>tlacdole.png" alt="---"> <br>
            Riešenie systému a jeho stavové veličiny
        </legend>
        </legend>
        <div>
            <div id="maticeries" style="background-color:#E6E6E6;"></div>
            <div id="maticeriesconvert" style="background-color:#E6E6E6;"></div>

            <div class="legenda">
                <img class="minimize" style="" src="<?= $path ?>tlachore.png" alt="▲">
            </div>
        </div>
    </fieldset>
</div>


<script>

    var konvnative;
    var konvtex;
    var bod;
    var bodconvert;
    var gconvert;

    function stiahnibod() {
        document.location = 'data:Application/octet-stream,' +
            encodeURIComponent(bod);
    }
    function stiahnibodconvert() {
        document.location = 'data:Application/octet-stream,' +
            encodeURIComponent(bodconvert);
    }
    //////chooose demo
    function choosedemo() {

        if ($('input[name=demo]:checked').val() == '1') {
            $('input[name=matlab_A]').val('[1 2;0 1]');
            $('input[name=matlab_b]').val('[1;2]');
            $('input[name=matlab_ct]').val('[1 2]');
            $('input[name=matlab_d]').val('0');
            $('input[name=matlab_x0]').val('[1;2]');
            $('input[name=pfcit]').val('[5 -1]');
            $('input[name=pfmen]').val('[1 -2 1]');

        }
        if ($('input[name=demo]:checked').val() == '2') {

            $('input[name=matlab_A]').val('[0 1;-9 -18]');
            $('input[name=matlab_b]').val('[0;1]');
            $('input[name=matlab_ct]').val('[3 2]');
            $('input[name=matlab_d]').val('0');
            $('input[name=matlab_x0]').val('[3;2]');
            $('input[name=pfcit]').val('[2 3]');
            $('input[name=pfmen]').val('[1 18 9]');

        }
        if ($('input[name=demo]:checked').val() == '3') {
            $('input[name=matlab_A]').val('[0 1 0;0 0 1;-1 -3 -3]');
            $('input[name=matlab_b]').val('[1;1;2]');
            $('input[name=matlab_ct]').val('[1 1 1]');
            $('input[name=matlab_d]').val('0');
            $('input[name=matlab_x0]').val('[1;2;3]');
            $('input[name=pfcit]').val('[4 5 6]');
            $('input[name=pfmen]').val('[1 3 3 1]');

        }
    }
    ////////////// cleaning
    function resetresults(flag) {
        if (flag == 1 || flag == 3) {
            document.getElementById("maticeriesconvert").innerHTML = '';
            document.getElementById("maticeries").innerHTML = '';
            document.getElementById("udajeinputconvert").innerHTML = '';
            document.getElementById("udajeinputconvert").innerHTML = '';
            document.getElementById("graf").innerHTML = '';
            document.getElementById("grafconvert").innerHTML = '';
            document.getElementById("graf").style = '';
            document.getElementById("grafconvert").style = '';
            document.getElementById("legenda").innerHTML = '';
            document.getElementById("legendaconvert").innerHTML = '';
            document.getElementById("udajeinput").innerHTML = '';
            document.getElementById("udajeinputconvert").innerHTML = '';
            $('#vykreslenie').css('display', 'none');
            $('#download').css('display', 'none');
            $('#downloadconvert').css('display', 'none');
            $('#vypis').css('display', 'none');
            $('#oddial').css('display', 'none');
            $('#oddialconvert').css('display', 'none');
        }
        if (flag == 2 || flag == 3) {
            document.getElementById("matice").innerHTML = '';
            konvnative = '';
            konvtex = '';
            $('#afterconvert').css('display', 'none');
            $('input[name=drawfromconvert]').prop('checked', false);
        }
    }

    ///////////// convert and draw ajax
    function convertajaxdata() {
        var code;
        if ($('input[name=inputforma]:checked').val() == 'zpf') {
            code = {
                'pfcit': cleaninput($('input[name=pfcit]').val()),
                'pfmen': cleaninput($('input[name=pfmen]').val()),
                'forma': $('input[name=forma]:checked').val(),
                'matlab_x0': cleaninput($('input[name=pf_x0]').val()),
                'matlab': false,
                'type': 'zpf'
            };
        } else if ($('input[name=inputforma]:checked').val() == 'diff') {

            code = {
                'pfcit': diffcoef(cleaninput($('input[name=diff]').val()), 'u'),
                'pfmen': diffcoef(cleaninput($('input[name=diff]').val()), 'y'),
                'forma': $('input[name=forma]:checked').val(),
                'matlab_x0': cleaninput($('input[name=diff_y0]').val()),
                'matlab': false,
                'type': 'zpf'
            };
        }
        else if ($('input[name=inputforma]:checked').val() == 'zmatice') {
            code = {
                'matlab_A': cleaninput($('input[name=matlab_A]').val()),
                'matlab_b': cleaninput($('input[name=matlab_b]').val()),
                'matlab_ct': cleaninput($('input[name=matlab_ct]').val()),
                'matlab_x0': cleaninput($('input[name=matlab_x0]').val()),
                'matlab_d': cleaninput($('input[name=matlab_d]').val()),
                'forma': $('input[name=forma]:checked').val(),
                'matlab': false,
                'type': 'zmatice'
            };
        }
        return code;
    }

    function drawajaxbothsuccess(dataries, dataconv, ready) {
        if (ready < 2)
            return;
        if (dataries == 'nepodarilo sa spojit so serverom' || dataconv == 'nepodarilo sa spojit so serverom') {
            alert('Aplikácii sa nepodarilo nadviazať spojenie so serverom, skonrolujte svoje pripojenie a kontaktujte správcu serveru');
            return;
        }
        var idr = dataries['result'];
        var idc = dataconv['result'];
        var udajeriesenier = dataries['graphs'];
        var udajerieseniec = dataconv['graphs'];
        if ($('input[name=vykresligraf]').prop('checked'))
            $('#vykreslenie').css('display', 'block');
        if ($('input[name=riesenie]').prop('checked'))
            $('#vypis').css('display', 'block');
        if ($('input[name=vykresligraf]').prop('checked')) {
            bod = new String("t,Y");
            if (typeof (udajeriesenier[1]) !== 'undefined')
                for (var i = 0; i < (idr); i++) {
                    bod += ",X" + (i + 1);
                }
            bod += ",Ykonv";
            if (typeof (udajerieseniec[1]) !== 'undefined')
                for (var i = 0; i < (idc); i++) {
                    bod += ",Xkonv" + (i + 1);
                }

            if ($('input[name=delay]').val() == '0') {
                for (i = 0; i < udajeriesenier[0].length; i++) {
                    bod += "\n";
                    bod += udajeriesenier[0][i][0] + "," + udajeriesenier[0][i][1];
                    if (typeof (udajeriesenier[1]) !== 'undefined')
                        for (var j = 1; j <= idr; j++) {
                            bod += "," + udajeriesenier[j][i][1];
                        }
                    bod += "," + udajerieseniec[0][i][1];
                    if (typeof (udajerieseniec[1]) !== 'undefined')
                        for (var j = 1; j <= idc; j++) {
                            bod += "," + udajerieseniec[j][i][1];
                        }
                }
            } else {
                var onesk = parseFloat($('input[name=delay]').val());
                for (i = 0; i < udajeriesenier[0].length; i++) {
                    bod += "\n";
                    bod += (onesk + parseFloat(udajeriesenier[0][i][0])) + "," + udajeriesenier[0][i][1];
                    if (typeof (udajeriesenier[1]) !== 'undefined')
                        for (var j = 1; j <= idr; j++) {
                            bod += "," + udajeriesenier[j][i][1];
                        }
                    bod += "," + udajerieseniec[0][i][1];
                    if (typeof (udajeriesenier[1]) !== 'undefined')
                        for (var j = 1; j <= idc; j++) {
                            bod += "," + udajerieseniec[j][i][1];
                        }
                }
            }
            bod += "\n";
            var udajeinput = 'Zobraziť údaje : <br>';
            udajeinput += '<input type="checkbox" id="' + 0 + '" checked="" onclick="skryvanieudajov(this)"/> <label style="display:inline;" for="' + 0 + '">Y</label> <br>';
            if (typeof (udajeriesenier[1]) !== 'undefined')
                for (i = 1; i < idr + 1; i++) {
                    udajeinput += '<input type="checkbox" id="' + i + '" checked="" onclick="skryvanieudajov(this)"/> <label style="display:inline;" for="' + i + '">X' + (i) + '</label> <br>';
                }
            udajeinput += '</td><td><input type="checkbox" id="' + i + '" checked="" onclick="skryvanieudajov(this)"/> <label style="display:inline;" for="' + i + '">Ykonv</label> <br>';
            if (typeof (udajerieseniec[1]) !== 'undefined')
                for (i++, j = 1; j < idc + 1; i++, j++) {
                    udajeinput += '<input type="checkbox" id="' + i + '" checked="" onclick="skryvanieudajov(this)"/> <label style="display:inline;" for="' + i + '">Xkonv' + (j) + '</label> <br>';
                }
            document.getElementById("udajeinput").innerHTML = udajeinput;
            grafukaz();
        }
        if ($('input[name=riesenie]').prop('checked')) {
            konvtex = jQuery.parseJSON(dataries.formulas['tex']);
            var polenazvov = new Array();
            polenazvov[0] = "y<sub>t</sub>=";
            polenazvov[1] = "x<sub>t</sub>=";
            var konvmatstr = '<table border="0" >';
            for (i = 0; i < 2; i++) {
                if (typeof (konvtex[i]) === 'undefined')
                    break;
                if ($('input[name=delay]').val() != '0') {
                    konvtex[i] = konvtex[i].replace(/t/g, "(t-" + $('input[name=delay]').val() + ')');
                    konvtex[i] = konvtex[i].replace("ma(t-" + $('input[name=delay]').val() + ')rix', 'matrix');
                    konvtex[i] = konvtex[i].replace("lef(t-" + $('input[name=delay]').val() + ')', 'left');
                    konvtex[i] = konvtex[i].replace("righ(t-" + $('input[name=delay]').val() + ')', 'right');
                    konvtex[i] = konvtex[i].replace("sqr(t-" + $('input[name=delay]').val() + ')', 'sqrt');
                }
                konvmatstr += '<tr style="background-color:#E6E6E6;font-family:MathJax_Math;">';
                konvmatstr += '<td>' + polenazvov[i] + '</td><td>';
                konvmatstr += konvtex[i];
                if ($('input[name=delay]').val() != '0')
                    konvmatstr += '</td><td>$$&#951;(t-' + $('input[name=delay]').val() + ')$$';
                konvmatstr += '</td></tr>';
            }
            konvmatstr += '</table>';
            document.getElementById("maticeries").innerHTML = '<center><center><tr style="background-color:#E6E6E6;font-family:MathJax_Math;">$$Riešenie$$ </tr>' + konvmatstr + '</center>';
            if ($('input[name=riesenie]').prop('checked')) {
                konvtex = jQuery.parseJSON(dataconv.formulas['tex']);
                var polenazvov = new Array();
                polenazvov[0] = "yk<sub>t</sub>=";
                polenazvov[1] = "xk<sub>t</sub>=";
                var konvmatstr = '<table border="0" >';
                for (i = 0; i < 2; i++) {
                    if (typeof (konvtex[i]) === 'undefined')
                        break;
                    if ($('input[name=delay]').val() != '0')
                        konvtex[i] = konvtex[i].replace(/t/g, "(t-" + $('input[name=delay]').val() + ')');
                    konvtex[i] = konvtex[i].replace("ma(t-" + $('input[name=delay]').val() + ')rix', 'matrix');
                    konvtex[i] = konvtex[i].replace("lef(t-" + $('input[name=delay]').val() + ')', 'left');
                    konvtex[i] = konvtex[i].replace("righ(t-" + $('input[name=delay]').val() + ')', 'right');
                    konvtex[i] = konvtex[i].replace("sqr(t-" + $('input[name=delay]').val() + ')', 'sqrt');
                    konvmatstr += '<tr style="background-color:#E6E6E6;font-family:MathJax_Math;">';
                    konvmatstr += '<td>' + polenazvov[i] + '</td><td>';
                    konvmatstr += konvtex[i] + '';
                    if ($('input[name=delay]').val() != '0')
                        konvmatstr += '</td><td>$$&#951;(t-' + $('input[name=delay]').val() + ')$$';
                    konvmatstr += '</td> </tr>';
                }
                konvmatstr += '</table>';
                document.getElementById("maticeriesconvert").innerHTML = '<center><tr style="background-color:#E6E6E6;font-family:MathJax_Math;">$$Riešenie&nbsppo&nbspkonverzii$$</tr>' + konvmatstr + '</center>';
                MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
            }
        }
    }
    function drawfromboth() {
        var dataries = '';
        var dataconv = '';
        var ready = 0;
        $.ajax({
            method: 'post',
            url: 'riesenie.php',
            data: drawajaxdata(),
            dataType: "json",
            success: function (data) {
                dataries = data;
                ready++;
                drawajaxbothsuccess(dataries, dataconv, ready);
            }
        });
        $.ajax({
            method: 'post',
            url: 'riesenie.php',
            data: drawajaxconvertdata(),
            dataType: "json",
            success: function (data) {
                dataconv = data;
                ready++;
                drawajaxbothsuccess(dataries, dataconv, ready);
            }
        });
    }
    function drawajaxsuccess(data) {
        if (data == 'nepodarilo sa spojit so serverom') {
            alert('Aplikácii sa nepodarilo nadviazať spojenie so serverom, skonrolujte svoje pripojenie a kontaktujte správcu serveru');
            return;
        }
        var id = data['result'];
        udajeriesenie = data['graphs'];
        if ($('input[name=vykresligraf]').prop('checked'))
            $('#vykreslenie').css('display', 'block');
        if ($('input[name=riesenie]').prop('checked'))
            $('#vypis').css('display', 'block');
        if ($('input[name=vykresligraf]').prop('checked')) {
            bod = new String("t,Y");
            if (typeof (data['graphs'][1]) !== 'undefined')
                for (var i = 0; i < (id); i++) {
                    bod += ",X" + (i + 1);
                }
            if ($('input[name=delay]').val() == '0') {
                for (i = 0; i < data['graphs'][0].length; i++) {
                    bod += "\n";
                    bod += data['graphs'][0][i][0] + "," + data['graphs'][0][i][1];
                    if (typeof (data['graphs'][1]) !== 'undefined')
                        for (var j = 1; j <= id; j++) {
                            bod += "," + data['graphs'][j][i][1];
                        }
                }
            } else {
                var onesk = parseFloat($('input[name=delay]').val());
                for (i = 0; i < data['graphs'][0].length; i++) {

                    bod += "\n";
                    bod += (onesk + parseFloat(data['graphs'][0][i][0])) + "," + data['graphs'][0][i][1];
                    if (typeof (data['graphs'][1]) !== 'undefined')
                        for (var j = 1; j <= id; j++) {
                            bod += "," + data['graphs'][j][i][1];
                        }
                }
            }
            bod += "\n";
            var udajeinput = 'Zobraziť údaje : <br>';
            udajeinput += '<input type="checkbox" id="' + 0 + '" checked="" onclick="skryvanieudajov(this)"/> <label style="display:inline;" for="' + 0 + '">Y</label> <br>';
            if (typeof (data['graphs'][1]) !== 'undefined')
                for (i = 1; i < id + 1; i++) {
                    udajeinput += '<input type="checkbox" id="' + i + '" checked="" onclick="skryvanieudajov(this)"/> <label style="display:inline;" for="' + i + '">X' + (i) + '</label> <br>';
                }
            document.getElementById("udajeinput").innerHTML = udajeinput;
            grafukaz();
        }
        if ($('input[name=riesenie]').prop('checked')) {
            konvtex = jQuery.parseJSON(data.formulas['tex']);
            var polenazvov = new Array();
            polenazvov[0] = "y<sub>t</sub>=";
            polenazvov[1] = "x<sub>t</sub>=";
            var konvmatstr = '<table border="0" >';
            for (i = 0; i < 2; i++) {
                if (typeof (konvtex[i]) === 'undefined')
                    break;
                if ($('input[name=delay]').val() != '0') {
                    konvtex[i] = konvtex[i].replace(/t/g, "(t-" + $('input[name=delay]').val() + ')');
                    konvtex[i] = konvtex[i].replace("ma(t-" + $('input[name=delay]').val() + ')rix', 'matrix');
                    konvtex[i] = konvtex[i].replace("lef(t-" + $('input[name=delay]').val() + ')', 'left');
                    konvtex[i] = konvtex[i].replace("righ(t-" + $('input[name=delay]').val() + ')', 'right');
                    konvtex[i] = konvtex[i].replace("sqr(t-" + $('input[name=delay]').val() + ')', 'sqrt');
                }
                konvmatstr += '<tr style="background-color:#E6E6E6;font-family:MathJax_Math;">';
                konvmatstr += '<td>' + polenazvov[i] + '</td><td>';
                konvmatstr += konvtex[i];
                if ($('input[name=delay]').val() != '0')
                    konvmatstr += '</td><td>$$&#951;(t-' + $('input[name=delay]').val() + ')$$';
                konvmatstr += '</td></tr>';
            }
            konvmatstr += '</table>';
            document.getElementById("maticeries").innerHTML = '<center><tr style="background-color:#E6E6E6;font-family:MathJax_Math;">$$Riešenie$$ </tr><center>' + konvmatstr + '</center>';
            MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
        }
    }
    function drawajaxdata() {
        var code;
        if ($('input[name=inputforma]:checked').val() == 'zpf') {
            code = {
                'pfcit': cleaninput($('input[name=pfcit]').val()),
                'pfmen': cleaninput($('input[name=pfmen]').val()),
                'matlab_d': cleaninput($('input[name=matlab_d]').val()),
                'matlab_x0': cleaninput($('input[name=pf_x0]').val()),
                'matlab_u': cleaninput($('input[name=matlab_u]').val()),
                'graf': $('input[name=vykresligraf]').prop('checked'),
                'zobraz': $('input[name=riesenie]').prop('checked'),
                'tend': (parseFloat($('input[name=timeend]').val()) - parseFloat($('input[name=delay]').val())),
                'tzac': $('input[name=timestart]').val(),
                'typeinput': 'zpf',
                'nomatlab': false
            };
        } else if ($('input[name=inputforma]:checked').val() == 'diff') {

            code = {
                'pfcit': diffcoef(cleaninput($('input[name=diff]').val()), 'u'),
                'pfmen': diffcoef(cleaninput($('input[name=diff]').val()), 'y'),
                'matlab_x0': cleaninput($('input[name=diff_y0]').val()),
                'matlab_u': cleaninput($('input[name=matlab_u]').val()),
                'graf': $('input[name=vykresligraf]').prop('checked'),
                'zobraz': $('input[name=riesenie]').prop('checked'),
                'tend': (parseFloat($('input[name=timeend]').val()) - parseFloat($('input[name=delay]').val())),
                'tzac': $('input[name=timestart]').val(),
                'typeinput': 'zpf',
                'nomatlab': false
            };
        }
        else if ($('input[name=inputforma]:checked').val() == 'zmatice') {
            code = {
                'matlab_A': cleaninput($('input[name=matlab_A]').val()),
                'matlab_b': cleaninput($('input[name=matlab_b]').val()),
                'matlab_ct': cleaninput($('input[name=matlab_ct]').val()),
                'matlab_x0': cleaninput($('input[name=matlab_x0]').val()),
                'matlab_u': cleaninput($('input[name=matlab_u]').val()),
                'matlab_d': cleaninput($('input[name=matlab_d]').val()),
                'graf': $('input[name=vykresligraf]').prop('checked'),
                'zobraz': $('input[name=riesenie]').prop('checked'),
                'tend': (parseFloat($('input[name=timeend]').val()) - parseFloat($('input[name=delay]').val())),
                'tzac': $('input[name=timestart]').val(),
                'typeinput': 'zmatice',
                'nomatlab': false
            };
        }
        return code;
    }
    function drawajaxconvertsuccess(data) {
        if (data == 'nepodarilo sa spojit so serverom') {
            alert('Aplikácii sa nepodarilo nadviazať spojenie so serverom, skonrolujte svoje pripojenie a kontaktujte správcu serveru');
            return;
        }
        var id = data['result'];
        udajerieseniekonv = data['graphs'];
        if ($('input[name=vykresligraf]').prop('checked'))
            $('#vykreslenie').css('display', 'block');
        if ($('input[name=riesenie]').prop('checked'))
            $('#vypis').css('display', 'block');
        if ($('input[name=vykresligraf]').prop('checked')) {
            bodconvert = new String("t,Yk");
            if (typeof (data['graphs'][1]) !== 'undefined')
                for (var i = 0; i < (id); i++) {
                    bodconvert += ",Xk" + (i + 1);
                }
            if ($('input[name=delay]').val() == '0') {
                for (i = 0; i < data['graphs'][0].length; i++) {
                    bodconvert += "\n";
                    bodconvert += data['graphs'][0][i][0] + "," + data['graphs'][0][i][1];
                    if (typeof (data['graphs'][1]) !== 'undefined')
                        for (var j = 1; j <= id; j++) {
                            bodconvert += "," + data['graphs'][j][i][1];
                        }
                }
            } else {
                var onesk = parseFloat($('input[name=delay]').val());
                for (i = 0; i < data['graphs'][0].length; i++) {

                    bodconvert += "\n";
                    bodconvert += (onesk + parseFloat(data['graphs'][0][i][0])) + "," + data['graphs'][0][i][1];
                    if (typeof (data['graphs'][1]) !== 'undefined')
                        for (var j = 1; j <= id; j++) {
                            bodconvert += "," + data['graphs'][j][i][1];
                        }
                }
            }
            bodconvert += "\n";
            var udajeinput = 'Zobraziť údaje : <br>';
            udajeinput += '<input type="checkbox" id="1' + 0 + '" checked="" onclick="skryvanieudajovconvert(this)"/> <label style="display:inline;" for="' + 0 + '">Ykonv</label> <br>';
            if (typeof (data['graphs'][1]) !== 'undefined')
                for (i = 1; i < id + 1; i++) {
                    udajeinput += '<input type="checkbox" id="1' + i + '" checked="" onclick="skryvanieudajovconvert(this)"/> <label style="display:inline;" for="' + i + '">Xkonv' + (i) + '</label> <br>';
                }
            document.getElementById("udajeinputconvert").innerHTML = udajeinput;
            grafukazconvert();
        }
        if ($('input[name=riesenie]').prop('checked')) {
            var konvtex = jQuery.parseJSON(data.formulas['tex']);
            var polenazvov = new Array();
            polenazvov[0] = "yk<sub>t</sub>=";
            polenazvov[1] = "xk<sub>t</sub>=";
            var konvmatstr = '<table border="0" >';
            for (i = 0; i < 2; i++) {
                if (typeof (konvtex[i]) === 'undefined')
                    break;
                if ($('input[name=delay]').val() != '0') {
                    konvtex[i] = konvtex[i].replace(/t/g, "(t-" + $('input[name=delay]').val() + ')');
                    konvtex[i] = konvtex[i].replace("ma(t-" + $('input[name=delay]').val() + ')rix', 'matrix');
                    konvtex[i] = konvtex[i].replace("lef(t-" + $('input[name=delay]').val() + ')', 'left');
                    konvtex[i] = konvtex[i].replace("righ(t-" + $('input[name=delay]').val() + ')', 'right');
                    konvtex[i] = konvtex[i].replace("sqr(t-" + $('input[name=delay]').val() + ')', 'sqrt');
                }
                konvmatstr += '<tr style="background-color:#E6E6E6;font-family:MathJax_Math;">';
                konvmatstr += '<td>' + polenazvov[i] + '</td><td>';
                konvmatstr += konvtex[i] + '';
                if ($('input[name=delay]').val() != '0')
                    konvmatstr += '</td><td>$$&#951;(t-' + $('input[name=delay]').val() + ')$$';
                konvmatstr += '</td> </tr>';
            }
            konvmatstr += '</table>';
            document.getElementById("maticeriesconvert").innerHTML = '<center><tr style="background-color:#E6E6E6;font-family:MathJax_Math;">$$Riešenie&nbsppo&nbspkonverzii$$</tr>' + konvmatstr + '</center>';
            MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
        }
    }
    function drawajaxconvertdata() {
        var code;
        var matlab_d;
        if ((konvnative[konvnative.length - 1] == '2') || (konvnative[konvnative.length - 1] == '3') || (konvnative[konvnative.length - 1] == '4')) {
            if (($('input[name=inputforma]:checked').val() == 'zmatice'))
                matlab_d = $('input[name=matlab_d]').val();
            else
                matlab_d = '0';
            if (konvnative.length == '6')
                matlab_d = konvnative[4];
            code = {
                'matlab_A': konvnative[0],
                'matlab_b': konvnative[1],
                'matlab_ct': konvnative[2],
                'matlab_x0': konvnative[3],
                'matlab_u': $('input[name=matlab_u]').val().replace("$", " "),
                'matlab_d': matlab_d.replace("$", " "),
                'graf': $('input[name=vykresligraf]').prop('checked'),
                'zobraz': $('input[name=riesenie]').prop('checked'),
                'tend': (parseFloat($('input[name=timeend]').val()) - parseFloat($('input[name=delay]').val())),
                'tzac': $('input[name=timestart]').val(),
                'typeinput': 'zmatice',
                'nomatlab': true
            };
        }
        if ((konvnative[konvnative.length - 1] == '5') || (konvnative[konvnative.length - 1] == '6')) {
            matlab_d = '0'; //todo3
            code = {
                'pfcit': konvnative[1].replace("$", " ").replace(",", " "),
                'pfmen': konvnative[2].replace("$", " ").replace(",", " "),
                'matlab_d': matlab_d.replace("$", " "),
                'matlab_x0': konvnative[3],
                'matlab_u': cleaninput($('input[name=matlab_u]').val()),
                'graf': $('input[name=vykresligraf]').prop('checked'),
                'zobraz': $('input[name=riesenie]').prop('checked'),
                'tend': (parseFloat($('input[name=timeend]').val()) - parseFloat($('input[name=delay]').val())),
                'tzac': $('input[name=timestart]').val(),
                'typeinput': 'zpf',
                'nomatlab': true
            };
        }
        return code;
    }
    function drawfromconv() {
        $.ajax({
            method: 'post',
            url: 'riesenie.php',
            data: drawajaxconvertdata(),
            dataType: "json",
            success: function (data) {
                drawajaxconvertsuccess(data);
            }
        });
    }
    function drawfrominp() {
        $.ajax({
            method: 'post',
            url: 'riesenie.php',
            data: drawajaxdata(),
            dataType: "json",
            success: function (data) {
                drawajaxsuccess(data);
            }
        });
    }
    function grafukaz() {
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
            zoomCallback: function () {
                $('#oddial').css('display', 'inline');
            },
            labelsSeparateLines: true,
            axes: {
                x: {
                    valueFormatter: function (ms) {
                        var dmiesta = parseInt($('input[name=precision]').val());
                        if (dmiesta > 7)
                            dmiesta = 7;
                        if (dmiesta < 1)
                            dmiesta = 1;
                        return 't=' + ms.toFixed(dmiesta);
                    }
                },
                y: {
                    valueFormatter: function (ms) {
                        var dmiesta = parseInt($('input[name=precision]').val());
                        if (dmiesta > 7)
                            dmiesta = 7;
                        if (dmiesta < 1)
                            dmiesta = 1;
                        return 't=' + ms.toFixed(dmiesta);
                    }
                }
            }
        };
        g = new Dygraph(document.getElementById("graf"),
            bod,
            GrOptions);
        $('#download').css('display', 'inline');
        //document.getElementById("graph").innerHTML = "zle zadane udaje";
        //        document.getElementById("tlacitko").innerHTML = "";

        /*   g.resize(g.width_ + 10, g.height_ + 10);*/

    }
    function grafukazconvert() {
        $("#vykreslenie").slideDown();
        var GrOptions = {
            legend: 'always',
            animatedZooms: true,
            title: '<div  style="margin:1px 0px 0px 69px; border: thin solid white; border-bottom-color:black ;">Priebeh systémových veličín po konverzii</div>',
            drawGapEdgePoints: true,
            // drawAxesAtZero: true, 8
            xRangePad: 1,
            axisLineWidth: 0.6,
            axisTickSize: 10,
            panEdgeFraction: 0, //??
            labelsDiv: document.getElementById('legendaconvert'),
            hideOverlayOnMouseOut: false,
            gridLineWidth: 0.5,
            zoomCallback: function () {
                $('#oddialconvert').css('display', 'inline');
            },
            labelsSeparateLines: true,
            axes: {
                x: {
                    valueFormatter: function (ms) {
                        var dmiesta = parseInt($('input[name=precision]').val());
                        if (dmiesta > 7)
                            dmiesta = 7;
                        if (dmiesta < 1)
                            dmiesta = 1;
                        return 't=' + ms.toFixed(dmiesta);
                    }
                },
                y: {
                    valueFormatter: function (ms) {
                        var dmiesta = parseInt($('input[name=precision]').val());
                        if (dmiesta > 7)
                            dmiesta = 7;
                        if (dmiesta < 1)
                            dmiesta = 1;
                        return 't=' + ms.toFixed(dmiesta);
                    }
                }
            }
        };
        gconvert = new Dygraph(document.getElementById("grafconvert"),
            bodconvert,
            GrOptions);
        //document.getElementById("graph").innerHTML = "zle zadane udaje";
        //        document.getElementById("tlacitko").innerHTML = "";

        /*   g.resize(g.width_ + 10, g.height_ + 10);*/
        $('#downloadconvert').css('display', 'inline');
    }
    function skryvanieudajov(udaj) {
        g.setVisibility(parseInt(udaj.id), udaj.checked);
    }
    function skryvanieudajovconvert(udaj) {
        gconvert.setVisibility(parseInt(udaj.id) - 10, udaj.checked);
    }
    /////////////show functions
    function inputpolynom(input) {
        var code = "}";
        var rad = 0;
        var znamienkoplus = true;
        for (var i = input.length - 1; i > 0; i--) {
            if (input[i] == ' ') {
                rad++;
                if (znamienkoplus)
                    code = '+' + code;
                znamienkoplus = true;
                if (rad == 1) {
                    code = ' s' + code;
                }
                if (rad > 1) {
                    code = ' s^' + rad + code;
                }
            }
            if (input[i] == '-') {
                code = '-' + code;
                znamienkoplus = false;
                continue;
            }
            if ((input[i] == '.') || (input[i] == '0') || (input[i] == '1') || (input[i] == '2') || (input[i] == '3') || (input[i] == '4') || (input[i] == '5') || (input[i] == '6') || (input[i] == '7') || (input[i] == '8') || (input[i] == '9'))
                code = input[i] + code;
        }
        code = "{" + code;
        code = code.replace('{1 s', '{ s');
        var indexcode;
        while (code.indexOf("+0 s") > -1) {
            code = code.replace('+0 s', '+');
            indexcode = code.indexOf("+^");
            if (indexcode > -1) {
                code = code.replace('+^' + parseInt(code[indexcode + 2]), '');
            }
        }
        code = code.replace('++', '+');
        code = code.replace('+0}', '}');
        while (code.indexOf("+1 s") > -1)
            code = code.replace('+1 s', '+ s');
        while (code.indexOf("-1 s") > -1)
            code = code.replace('-1 s', '- s');
        return code;
    }
    function showinputpf(inputup, inputdown) {
        return '$${' + inputpolynom(inputup) + '\\over' + inputpolynom(inputdown) + '}$$';
    }
    function showinputdiff(inputy, inputu) {
        var show = '$$';
        inputy = inputy.replace('[', '');
        inputy = inputy.replace(']', '');
        inputu = inputu.replace('[', '');
        inputu = inputu.replace(']', '');
        inputy = inputy.split(" ");
        inputu = inputu.split(" ");
        if (inputy != '') {
            var it2 = 0;
            for (var it = inputy.length - 1; it > 1; it--, it2++) {
                if (inputy[it2] != '0') {
                    if ((inputy[it2].split('-').length - 1 == 0) && (it2 > 0))
                        show += '+';
                    show += inputy[it2] + '\\frac{d^' + it + 'y}{dt^' + it + '}';
                }
            }
            if ((inputy.length - 1 > 0)) {
                if (inputy[it2] != '0') {
                    if ((inputy[it2].split('-').length - 1 == 0) && (it2 > 0))
                        show += '+';
                    show += inputy[it2] + '\\frac{dy}{dt}';
                }
                it2++;
            }
            if (inputy[it2] != '0') {
                if ((inputy[it2].split('-').length - 1 == 0) && (it2 > 0))
                    show += '+';
                show += inputy[it2] + 'y';
            }
        } else
            show += '0';
        show += '=';
        if (inputu != '') {
            var it2 = 0;
            for (var it = inputu.length - 1, it2 = 0; it > 1; it--, it2++) {
                if (inputu[it2] != '0') {
                    if ((inputu[it2].split('-').length - 1 == 0))
                        show += '+';
                    show += inputu[it2] + '\\frac{d^' + it + 'u}{dt^' + it + '}';
                }
            }
            if ((inputu.length - 1 > 0)) {
                if (inputu[it2] != '0') {
                    if ((inputu[it2].split('-').length - 1 == 0))
                        show += '+';
                    show += inputu[it2] + '\\frac{du}{dt}';
                }
                it2++;
            }
            if (inputu[it2] != '0') {
                if ((inputu[it2].split('-').length - 1 == 0))
                    show += '+';
                show += inputu[it2] + 'u';
            }
        } else
            show += '0';
        show = show.replace('+1u', '+u');
        show = show.replace('+1y', '+y');
        while (show.indexOf("+1\\frac") > -1)
            show = show.replace('+1\\frac', '+\\frac');
        while (show.indexOf("-1\\frac") > -1)
            show = show.replace('-1\\frac', '-\\frac');
        show = show.replace('$+', '$');
        show = show.replace('$1\\', '$\\');
        show = show.replace('=+', '=');
        return show + '$$';
    }
    function showinputmatrix(input) {
        var transpose = '';
        if (input.search("\'") > 0)
            transpose = '^T';
        var code = '$$\\pmatrix{';
        for (i = 1; i < input.length; i++) {
            if (input[i] == ' ')
                code += '&';
            if (input[i] == ';')
                code += '\\cr ';
            if (input[i] == ']')
                code += '\\cr ';
            if ((input[i] == '-') || (input[i] == '.') || (input[i] == '0') || (input[i] == '1') || (input[i] == '2') || (input[i] == '3') || (input[i] == '4') || (input[i] == '5') || (input[i] == '6') || (input[i] == '7') || (input[i] == '8') || (input[i] == '9'))
                code += input[i];
        }
        return code + '}' + transpose + '$$';
    }

    /////////////unzoom graphs
    function unzoom() {
        g.resetZoom();
        g.updateOptions({xRangePad: 1}, false);
        setTimeout(function () {
            g.resetZoom();
            g.updateOptions({xRangePad: 1}, false);
            $('#oddial').css('display', 'none');
        }, 350);
    }
    function unzoomconvert() {
        gconvert.resetZoom();
        gconvert.updateOptions({xRangePad: 1}, false);
        setTimeout(function () {
            gconvert.resetZoom();
            gconvert.updateOptions({xRangePad: 1}, false);
            $('#oddialconvert').css('display', 'none');
        }, 350);
    }
    //////////////////decode diff function
    function maxradsearch(fcia, type) {
        var max = 0;
        var goty = false;
        var test;
        for (var it = 0; it < fcia.length; it++) {
            if (fcia[it] == 'd' || fcia[it] == 'D') {
                for (var it2 = it + 1; it2 < fcia.length; it2++) {
                    if (fcia[it2] == '1' || fcia[it2] == '2' || fcia[it2] == '3' || fcia[it2] == '4' || fcia[it2] == '5' || fcia[it2] == '6' || fcia[it2] == '7' || fcia[it2] == '8' || fcia[it2] == '9' || fcia[it2] == '0')
                        continue;
                    break;
                }
                if (fcia[it2] != type)
                    continue;
                test = parseInt(fcia.substring([it + 1], fcia.length));
                if (isNaN(test))
                    test = 1;
                if (test > max)
                    max = test;
            }
            if (fcia[it] == type)
                goty = true;
        }
        if (!goty)
            max = -1;
        return max;
    }
    function radsearch(fcia, rad, type) { //rad int
        var coef = 1;
        fcia = fcia.replace('=', '=+');
        /*                   if (type == 'u')
         coef = -1;*/
        if (rad == 0)
            return "" + coef * radsearchabs(fcia, type);
        if (!(fcia[0] == '+' || fcia[0] == '-'))
            fcia = '+' + fcia;
        fcia = fcia.replace('d' + type, 'd1' + type);
        fcia = fcia.replace('D' + type, 'D1' + type);
        for (var o = fcia.split('d').length + fcia.split('D').length - 2; o > 0; o--) {
            fcia = fcia.replace('+d', '+1d');
            fcia = fcia.replace('+D', '+1D');
            fcia = fcia.replace('-d', '-1d');
            fcia = fcia.replace('-D', '-1D');
        }
        var prvok = '0';
        for (var it = 0; it < fcia.length; it++) {
            if (fcia[it] == ',')
                fcia[it] = '.';
            if (fcia[it] == type) { //&& (fcia[it + 1] == '#' && parseInt(fcia.substring([it + 2], fcia.length)) == rad)
                for (var it2 = it - 1; !(fcia[it2] == '+' || fcia[it2] == '-' || fcia[it2] == 'd' || fcia[it2] == 'D'); it2--)
                    ;
                if (fcia[it2] == '+' || fcia[it2] == '-')
                    continue;
                if (parseInt(fcia.substring([it2 + 1], fcia.length)) == rad) {
                    for (var it2 = it2 - 1; !(fcia[it2] == '+' || fcia[it2] == '-'); it2--)
                        ;
                    prvok = parseFloat(fcia.substring([it2], fcia.length));
                    break;
                }
            }
        }
        return "" + coef * prvok;
    }
    function radsearchabs(fcia, type) {
        if (!(fcia[0] == '+' || fcia[0] == '-'))
            fcia = '+' + fcia;
        fcia += ' ';
        for (var it = 0; it < fcia.length; it++) {
            if (fcia[it] == ',')
                fcia[it] = '.';
            if (fcia[it] == type) {
                if (fcia[it - 1] == '+')
                    return 1;
                if (fcia[it - 1] == '-')
                    return -1;
                for (var it2 = it - 1; !(fcia[it2] == '+' || fcia[it2] == '-' || fcia[it2] == 'd' || fcia[it2] == 'D'); it2--) {
                }
                if (fcia[it2] == '+' || fcia[it2] == '-')
                    break;
            }

        }
        if (it == fcia.length)
            return 0;
        return parseFloat(fcia.substring([it2], fcia.length));
    }
    function diffcoef(fcn, type) {
        var pom;
        var coef = '[';
        if (maxradsearch(fcn, type) == -1)
            return coef + ']';
        for (var mit = maxradsearch(fcn, type); mit != 0; mit--) {
            //  pf_den+=radsearch(fcn,it)+' ';
            coef += radsearch(fcn, mit, type) + ' ';
        }
        pom = radsearch(fcn, mit, type);
        coef += pom;
        return coef + ']';
    }
    //// uprava vstupnych udajov
    function cleaninput(input) {
        while (input.indexOf("  ") > -1)
            input = input.replace('  ', ' ');
        while (input.indexOf(",") > -1)
            input = input.replace(',', ' ');
        while (input.indexOf("; ") > -1)
            input = input.replace('; ', ';');
        while (input.indexOf(" ;") > -1)
            input = input.replace(' ;', ';');
        input = input.replace(' [', '[');
        input = input.replace('] ', ']');
        input = input.replace('[ ', '[');
        input = input.replace(' ]', ']');
        input = input.replace('pi', '%pi');
        return input;
    }
    //////////////////funkcie
    $(document).ready(function () {
        var udajeriesenie;
        var udajerieseniekonv;
        var currslide = "1";
        ////////////// reakcia na input
        /*           $(':input[name=timeend]').on('input',function(e){
         parseFloat($(':input[name=timeend]').val())<parseFloat($(':input[name=timeend]').val())

         });
         $(':input[name=timestart]').on('input',function(e){


         });
         $(':input[name=delay]').on('input',function(e){
         parseFloat($(':input[name=timeend]').val())<parseFloat($(':input[name=delay]').val())

         });*/
        //////////////aplikovanie napovedy
        $(function () {
            $('.help').balloon();
        });
        $(function () {
            $('#download').balloon();
            $('#downloadconvert').balloon();
        });

        //////////////reakcia na tlacitko ukaz
        $("#showmediff").click(function () {

            document.getElementById('showndiff').innerHTML = '<table border="0" >\n\
                        <tr style="background-color:#E6E6E6;font-family:MathJax_Math;">\n\
                            <td></td><td>' + showinputdiff(diffcoef(cleaninput($('input[name=diff]').val()), 'y'), diffcoef(cleaninput($('input[name=diff]').val()), 'u')) + '</td></tr><table>\n\
                             <table border="0" ><center><tr style="background-color:#E6E6E6;font-family:MathJax_Math;"><td>ŷ<sub>0</sub>=</td><td>' + showinputmatrix(cleaninput($('input[name=diff_y0]').val())) + '</center></td></td></tr><table>';
            MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
        });
        $("#showmemat").click(function () {
            document.getElementById("shownmat").innerHTML = '<table border="0" >\n\
                        <tr style="background-color:#E6E6E6;font-family:MathJax_Math;">\n\
                        <td>\n\
                        <table border="0" ><tr style="background-color:#E6E6E6;font-family:MathJax_Math;"><td> A=</td><td>' + showinputmatrix(cleaninput($('input[name=matlab_A]').val())) + '</td></tr></table>\n\
                        </td>\n\
                        <td>\n\
                        <table border="0" ><tr style="background-color:#E6E6E6;font-family:MathJax_Math;"><td>b=</td><td>' + showinputmatrix(cleaninput($('input[name=matlab_b]').val())) + '</td></tr></table>\n\
                        </td>\n\
                        <td></td></tr>\n\
                        <tr style="background-color:#E6E6E6;font-family:MathJax_Math;">\n\
                        <td>\n\
        <table border="0" ><tr style="background-color:#E6E6E6;font-family:MathJax_Math;"><td> c<sup>t</sup>=</td><td>' + showinputmatrix(cleaninput($('input[name=matlab_ct]').val())) + '</td></tr></table>\n\
                  </td>\n\
                    <td> $${d=' + cleaninput($('input[name=matlab_d]').val()) + '}$$\n\
                      </td></tr><tr style="background-color:#E6E6E6;font-family:MathJax_Math;">\n\
                 <td><table border="0" ><tr style="background-color:#E6E6E6;font-family:MathJax_Math;"><td>x<sub>0</sub>=</td><td>' + showinputmatrix(cleaninput($('input[name=matlab_x0]').val())) + '</td></tr></table></td></tr></table>';
            MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
        });
        $("#showmepf").click(function () {

            document.getElementById("shownpf").innerHTML = '<table border="0" >\n\
                            <tr style="background-color:#E6E6E6;font-family:MathJax_Math;">\n\
                            <td> $$G(s)={{Y(s)}\\over{U(s)}}=$$</td><td>' + showinputpf(cleaninput($('input[name=pfcit]').val()), cleaninput($('input[name=pfmen]').val())) + '\n\
                            </td></tr><table>';
            MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
        });
        //  showinputpf(inputup, inputdown)
        ////////////TLACIDLA KONVETUJ A RIESENIE
        $(".konvshow").click(function () {
            resetresults(3);
            $('#convert').css('display', 'block');
            $(this).parent().parent().parent().parent().parent().slideUp();
            $(this).parent().parent().parent().parent().parent().prev().children().first().next().css('display', 'inline');
        });
        $(".casriesshow").click(function () {
            resetresults(1);
            $('#riesavykresli').css('display', 'block');
            $(this).parent().parent().parent().parent().parent().slideUp();
            $(this).parent().parent().parent().parent().parent().prev().children().first().next().css('display', 'inline');
        });
        ////////////ZOBRAZENIE PARAMETROV VYKRESLENIA GRAFU
        $("input[name=vykresligraf]").click(function () {
            $("#paramgraf").slideToggle();
        });
        //////////// cistenie medzi konverziami
        $("input[name=forma]").click(function () {
            resetresults(2);
        });
        //////////// PREPINANIE INPUT OKIEN
        $("input[name=inputforma]").click(function () {
            if ($('input[name=inputforma]:checked').val() == 'zmatice') {

                $("#slide" + currslide).css('display', 'none');
                $("#slide1").slideDown(400, function () {
                    $('#slide1').css('display', 'block');
                });
                currslide = "1";
                $('#convertpf').css('display', 'inline');
                $('#convertdiff').css('display', 'inline');
                $('.showshow')[0].innerHTML = '';
                $('.showshow')[1].innerHTML = '';
                $('.showshow')[2].innerHTML = '';
                resetresults(3);
            }
            if ($('input[name=inputforma]:checked').val() == 'zpf') {

                $("#slide" + currslide).css('display', 'none');
                $("#slide2").slideDown(400, function () {
                    $('#slide2').css('display', 'block');
                });
                currslide = "2";
                $('#convertpf').css('display', 'none');
                $('#convertdiff').css('display', 'inline');
                $('.showshow')[0].innerHTML = '';
                $('.showshow')[1].innerHTML = '';
                $('.showshow')[2].innerHTML = '';
                resetresults(3);
            }
            if ($('input[name=inputforma]:checked').val() == 'demo') {

                $("#slide" + currslide).css('display', 'none');
                $("#slide3").slideDown(400, function () {
                    $('#slide3').css('display', 'block');
                });
                currslide = "3";
                $('#convertpf').css('display', 'inline');
                $('#convertdiff').css('display', 'inline');
                $('.showshow')[0].innerHTML = '';
                $('.showshow')[1].innerHTML = '';
                $('.showshow')[2].innerHTML = '';
                resetresults(3);
            }
            if ($('input[name=inputforma]:checked').val() == 'diff') {

                $("#slide" + currslide).css('display', 'none');
                $("#slide4").slideDown(400, function () {
                    $('#slide4').css('display', 'block');
                });
                currslide = "4";
                $('#convertpf').css('display', 'inline');
                $('#convertdiff').css('display', 'none');
                $('.showshow')[0].innerHTML = '';
                $('.showshow')[1].innerHTML = '';
                $('.showshow')[2].innerHTML = '';
                resetresults(3);
            }

        });
        ////////////FUNKCIE PRE DEMO
        $('input[name=demo]').click(function () {
            choosedemo(currslide);
            $("#slide" + currslide).slideUp();
            $("#slide1").slideDown();
            currslide = "1";
            $('input[name=inputforma]')[0].checked = true;
            $('input[name=demo]:checked').attr('checked', false);
        });
        //////////// TLACITKA PRE MANAZMENT OKIEN
        $(".maximize").click(function () {
            $(this).parent().next().slideDown();
            $(this).css('display', 'none');
        });
        $(".minimize").click(function () {
            $(this).parent().parent().slideUp();
            $(this).parent().parent().prev().children().first().next().css('display', 'inline');
        });
        $(".quit").click(function () {
            $(this).parent().parent().slideUp();
        });
        //////////// ZOBRAZENIE MOZNOSTI 2 RIESENI DO 1 GRAFU
        $('.bothgraph').click(function () {
            if ($('input[name=drawfrominput]').prop('checked') && $('input[name=drawfromconvert]').prop('checked') && $('input[name=vykresligraf]').prop('checked'))
                $('#bothgraphs').css('display', 'inline');
            else {
                $('#bothgraphs').css('display', 'none');
                $('input[name=drawboth]').prop('checked', false);
            }
        });
        ////////////TLACIDLO ODDIAL PRI GRAFE
        $("#oddial").click(function () {
            unzoom();
        });
        $("#oddialconvert").click(function () {
            unzoomconvert();
        });
        ////////////
        $("#downloadconvert").click(function () {
            stiahnibodconvert();
        });
        $("#download").click(function () {
            stiahnibod();
        });
        ////////////KONVERZIA DO FORMY
        $('#doformy').click(function () {
            $('#afterconvert').css('display', 'inline');
            if ($('input[name=inputforma]:checked').val() == 'zmatice')
                $.ajax({
                    method: 'post',
                    url: 'konverzia.php',
                    data: convertajaxdata(),
                    dataType: "json",
                    success: function (data) {
                        if (data == 'nie je možné vytvoriť transformačnú maticu') {
                            alert('Aplikácii sa nepodarilo vytvoriť transformačnú maticu, pre konverziu do zvolého tvaru, matica neexistuje');
                            resetresults(2);
                            return;
                        }
                        if (data == 'nepodarilo sa spojit so serverom') {
                            alert('Aplikácii sa nepodarilo nadviazať spojenie so serverom, skonrolujte svoje pripojenie a kontaktujte správcu serveru');
                            return;
                        }
                        konvnative = data['native'];
                        konvnative.push($('input[name=forma]:checked').val());
                        konvtex = data['tex'];
                        $('#data').text(data);
                        var polenazvov = new Array();
                        polenazvov[0] = "A=";
                        polenazvov[1] = "b=";
                        polenazvov[2] = "c<sup>t</sup>=";
                        polenazvov[3] = "d=";
                        polenazvov[4] = "x<sub>0</sub>=";
                        if ($('input[name=forma]:checked').val() == '5') {
                            konvnative[2] = konvnative[2].replace('$', '').replace(/,/g, ' ');
                            konvnative[1] = konvnative[1].replace('$', '').replace(/,/g, ' ');
                            document.getElementById("matice").innerHTML = '<table border="0" > <tr style="background-color:#E6E6E6;font-family:MathJax_Math;"> <td>G(s)=</td><td>' + showinputpf(konvnative[1], konvnative[2]) + '</td></tr>\n\</table>';
                            MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
                            konvnative[3] = '0$'
                        } else if ($('input[name=forma]:checked').val() == '6') {
                            konvnative[2] = konvnative[2].replace('$', '').replace(/,/g, ' ');
                            konvnative[1] = konvnative[1].replace('$', '').replace(/,/g, ' ');
                            document.getElementById("matice").innerHTML = '<table border="0" > <tr style="background-color:#E6E6E6;font-family:MathJax_Math;"> <td> </td><td>' + showinputdiff(konvnative[2], konvnative[1]) + '</td><td>ŷ<sub>0</sub>=</td><td>' + konvtex[3] + ' </td></tr>\n\</table>';
                            MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
                        }
                        else {
                            var konvmatstr = '<table border="0" > ';
                            for (i = 0; i < konvtex.length; i++) {
                                if (i % 2 == 0 || polenazvov[0].length > 300)
                                    konvmatstr += '<tr style="background-color:#E6E6E6;font-family:MathJax_Math;">';
                                konvmatstr += '<td><table border="0" ><tr style="background-color:#E6E6E6;font-family:MathJax_Math;"><td>' + polenazvov[i] + '</td><td>';
                                if (i == 4)
                                    konvmatstr += konvtex[3] + '</td></tr></table></td>';
                                else if (i == 3)
                                    konvmatstr += konvtex[4] + '</td></tr></table></td>';
                                else
                                    konvmatstr += konvtex[i] + '</td></tr></table></td>';
                                if (i % 2 == 1 || polenazvov[0].length > 300)
                                    konvmatstr += '</tr>';
                            }
                            konvmatstr += '</table>';
                            document.getElementById("matice").innerHTML = konvmatstr;
                            if (konvtex.length < 3 || (konvtex.length === 1 && $('input[name=forma]:checked').val() != '5'))
                                document.getElementById("matice").innerHTML = "neexistuje takýto tvar matice";
                            MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
                        }
                    }

                });
            if ($('input[name=inputforma]:checked').val() == 'zpf')
                $.ajax({
                    method: 'post',
                    url: 'konverzia.php',
                    data: convertajaxdata(),
                    dataType: "json",
                    success: function (data) {
                        if (data == 'nie je možné vytvoriť transformačnú maticu') {
                            alert('Aplikácii sa nepodarilo vytvoriť transformačnú maticu, pre konverziu do zvolého tvaru, matica neexistuje');
                            resetresults(2);
                            return;
                        }
                        if (data == 'nepodarilo sa spojit so serverom') {
                            alert('Aplikácii sa nepodarilo nadviazať spojenie so serverom, skonrolujte svoje pripojenie a kontaktujte správcu serveru');
                            return;
                        }
                        konvnative = data['native'];
                        //                 konvnative = konvnative.split("\",\"");
                        konvnative.push($('input[name=forma]:checked').val());
                        konvtex = data['tex'];
                        $('#data').text(data);
                        var polenazvov = new Array();
                        polenazvov[0] = "A=";
                        polenazvov[1] = "b=";
                        polenazvov[2] = "c<sup>t</sup>=";
                        polenazvov[3] = "d=";
                        polenazvov[4] = "x<sub>0</sub>=";
                        if ($('input[name=forma]:checked').val() == '5') {
                            konvnative[2] = konvnative[2].replace('$', '').replace(/,/g, ' ');
                            konvnative[1] = konvnative[1].replace('$', '').replace(/,/g, ' ');
                            document.getElementById("matice").innerHTML = '<table border="0" > <tr style="background-color:#E6E6E6;font-family:MathJax_Math;"> <td>G(s)=</td><td>' + showinputdiff(konvnative[2], konvnative[1]) + '</td><td>x<sub>0</sub>=</td><td>' + konvtex[3] + ' </td></tr>\n\</table>';
                        } else if ($('input[name=forma]:checked').val() == '6') {
                            konvnative[2] = konvnative[2].replace('$', '').replace(/,/g, ' ');
                            konvnative[1] = konvnative[1].replace('$', '').replace(/,/g, ' ');
                            document.getElementById("matice").innerHTML = '<table border="0" > <tr style="background-color:#E6E6E6;font-family:MathJax_Math;"> <td> </td><td>' + showinputdiff(konvnative[2], konvnative[1]) + '</td><td>ŷ<sub>0</sub>=</td><td>' + konvtex[3] + ' </td></tr>\n\</table>';
                            MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
                        } else {
                            var konvmatstr = '<table border="0" > ';
                            for (i = 0; i < konvtex.length; i++) {
                                if (i % 2 == 0 || polenazvov[0].length > 300)
                                    konvmatstr += '<tr style="background-color:#E6E6E6;font-family:MathJax_Math;">';

                                konvmatstr += '<td><table border="0" ><tr style="background-color:#E6E6E6;font-family:MathJax_Math;"><td>' + polenazvov[i] + '</td><td>';
                                if (i == 4)
                                    konvmatstr += konvtex[3] + '</td></tr></table></td>';
                                else if (i == 3)
                                    konvmatstr += konvtex[4] + '</td></tr></table></td>';
                                else
                                    konvmatstr += konvtex[i] + '</td></tr></table></td>';
                                if (i % 2 == 1 || polenazvov[0].length > 300)
                                    konvmatstr += '</tr>';
                            }
                            konvmatstr += '</table>';
                            document.getElementById("matice").innerHTML = konvmatstr;
                            if (konvtex.length < 3)
                                document.getElementById("matice").innerHTML = "neexistuje takýto tvar matice";
                            MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
                        }
                    }

                });
            if ($('input[name=inputforma]:checked').val() == 'diff')
                $.ajax({
                    method: 'post',
                    url: 'konverzia.php',
                    data: convertajaxdata(),
                    dataType: "json",
                    success: function (data) {
                        if (data == 'nie je možné vytvoriť transformačnú maticu') {
                            alert('Aplikácii sa nepodarilo vytvoriť transformačnú maticu, pre konverziu do zvolého tvaru, matica neexistuje');
                            resetresults(2);
                            return;
                        }
                        if (data == 'nepodarilo sa spojit so serverom') {
                            alert('Aplikácii sa nepodarilo nadviazať spojenie so serverom, skonrolujte svoje pripojenie a kontaktujte správcu serveru');
                            return;
                        }
                        konvnative = data['native'];
                        konvnative.push($('input[name=forma]:checked').val());
                        konvtex = data['tex'];
                        $('#data').text(data);
                        var polenazvov = new Array();
                        polenazvov[0] = "A=";
                        polenazvov[1] = "b=";
                        polenazvov[2] = "c<sup>t</sup>=";
                        polenazvov[3] = "d=";
                        polenazvov[4] = "x<sub>0</subs>=";
                        if ($('input[name=forma]:checked').val() == '5') {
                            document.getElementById("matice").innerHTML = '<table border="0" > <tr style="background-color:#E6E6E6;font-family:MathJax_Math;"> <td> Pf=</td><td>' + showinputpf(konvnative[1].replace('$', '').replace(/,/g, ' '), konvnative[2].replace('$', '').replace(/,/g, ' ')) + '</td></tr>\n\</table>';
                            MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
                            konvnative[3] = '0$'
                        } else if ($('input[name=forma]:checked').val() == '6') {
                            document.getElementById("matice").innerHTML = '<table border="0" > <tr style="background-color:#E6E6E6;font-family:MathJax_Math;"> <td> </td><td>' + showinputdiff(konvnative[2].replace('$', '').replace(/,/g, ' '), konvnative[1].replace('$', '').replace(/,/g, ' ')) + '</td><td>ŷ<sub>0</sub>=</td><td>' + konvtex[3] + ' </td></tr>\n\</table>';
                            MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
                        }
                        else {
                            var konvmatstr = '<table border="0" > ';
                            for (i = 0; i < konvtex.length; i++) {
                                if (i % 2 == 0 || polenazvov[0].length > 300)
                                    konvmatstr += '<tr style="background-color:#E6E6E6;font-family:MathJax_Math;">';

                                konvmatstr += '<td><table border="0" ><tr style="background-color:#E6E6E6;font-family:MathJax_Math;"><td>' + polenazvov[i] + '</td><td>';
                                if (i == 4)
                                    konvmatstr += konvtex[3] + '</td></tr></table></td>';
                                else if (i == 3)
                                    konvmatstr += konvtex[4] + '</td></tr></table></td>';
                                else
                                    konvmatstr += konvtex[i] + '</td></tr></table></td>';
                                if (i % 2 == 1 || polenazvov[0].length > 300)
                                    konvmatstr += '</tr>';
                            }
                            konvmatstr += '</table>';
                            document.getElementById("matice").innerHTML = konvmatstr;
                            if (konvtex.length < 3)
                                document.getElementById("matice").innerHTML = "neexistuje takýto tvar matice";
                            MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
                        }
                    }

                });
        });
        //////////// URCENIE RIESENIA
        $('#odoslat').click(function () {
            if (parseFloat($(':input[name=timeend]').val()) < parseFloat($(':input[name=timestart]').val())) {
                var pompremenna = $(':input[name=timeend]').val();
                $(':input[name=timeend]').val($(':input[name=timestart]').val());
                $(':input[name=timestart]').val(pompremenna);
            }
            if ((parseFloat($(':input[name=timeend]').val()) - parseFloat($(':input[name=timestart]').val())) < $(':input[name=delay]').val()) {
                $(':input[name=timeend]').val(parseFloat($(':input[name=timeend]').val()) + parseFloat($(':input[name=delay]').val()));
            }
            resetresults(1);
            $(this).parent().parent().parent().parent().parent().slideUp();
            $(this).parent().parent().parent().parent().parent().prev().children().first().next().css('display', 'inline');
            $(this).parent().parent().parent().parent().parent().parent().prev().children().last().slideUp();
            $(this).parent().parent().parent().parent().parent().parent().prev().children().first().children().first().next().css('display', 'inline');
            if ($('input[name=drawboth]').prop('checked')) {
                drawfromboth();
            }
            if ($('input[name=drawfrominput]').prop('checked') && !($('input[name=drawboth]').prop('checked'))) {
                drawfrominp();
            }
            if ($('input[name=drawfromconvert]').prop('checked') && !($('input[name=drawboth]').prop('checked'))) {
                drawfromconv();
            }

        });
        $(document).ajaxStart(function () {
            $('body').addClass('kurzorcakaj');

        }).ajaxComplete(function () {

            $('body').removeClass('kurzorcakaj');

        });
    });
</script>