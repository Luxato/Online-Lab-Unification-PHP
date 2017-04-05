
@extends('master')

@section('title')
	parne_alebo_neparne
@stop

@section('content')
    <style>
        /*NECHYAJ SA :*/
        #e-body-with-bgd{
            padding:0px;
            margin:0px;
        }
        .body_div_simi {
        //background-image: url("../images/simi_game/pozadie.jpg");
            margin: 0 auto;
            padding: 20px;
            font-family: 'Roboto', sans-serif;
            line-height: 1.8em;
            position: relative;
            overflow-x: auto;
        }

        /* Give headings their own font */

        .nadpisH1, .nadpisH2, .nadpisH3, .nadpisH4 {
            font-family: 'Montserrat', sans-serif;
            font-weight: bold;
        }

        .nadpisH1 {
            text-shadow: 2px 2px 4px #000000;
            color: #aaa;
            text-align: center;
            font-size: 2.5em;
            letter-spacing: 3px;
        }

        .nadpisH2 {
            text-align: center;
            letter-spacing: 5px;
            color:  rgb(250,235,215);
            text-shadow: 1px 1px 1px #000000;
        }

        .nadpisH3 {
            letter-spacing: 5px;
            color:  black;
        }

        #content {
            width: 1060px;
            height: 140px;
            padding: 20px 0;
            border: 2px solid #333;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;
            -moz-box-shadow: 0 0 .3em rgba(0, 0, 0, .8);
            -webkit-box-shadow: 0 0 .3em rgba(0, 0, 0, .8);
            box-shadow: 0 0 .3em rgba(0, 0, 0, .8);
            margin: 2% auto;
            background: rgb(218,154,19); /* #F3C300 */
        }

        .dragy {
            float: left;
            width: 93px;
            height: 98px;
            padding: 10px;
            padding-top: 3%;
            padding-bottom: 0;
            border: 2px solid #333;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;
            margin: 0 0 0 1%;
            background: brown;
            color: #fff;
            font-size: 15px;
            text-shadow: 0 0 3px #000;
            text-align: center;
        }

        #content div:first-child {
            margin-left: 10px;
        }

        .dragy:hover {
            background: rgb(156,63,0);
            box-shadow: 0 0 .5em rgba(0, 0, 0, .8);
        }

        #successMessage {
            position: absolute;
            left: 580px;
            top: 250px;
            width: 0;
            height: 0;
            z-index: 100;
            background: #dfd;
            border: 2px solid #333;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;
            -moz-box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
            -webkit-box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
            box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
            padding: 20px;
        }

        #uvod {
            margin: 2% 10%;
            padding: 2%;
            background: rgba(255, 255, 255, 0.5);
            width: 900px;
            height: auto;
            min-width: 900px;
            color: black;
        }

        .modal {
            display: none; /* Hidden by default */
            position: absolute; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.5); /* Black w/ opacity */
            animation: bounce 1s 0.5s 1 alternate backwards;
        }

        /* Modal Content */
        .modal-content {
            background-color: grey;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            color: black;
            text-align: center;
        }

        /*#myModal_reallyMy {
          display: none;
        } */

        .box.is-dragover {
            background-color: rgba(211,211,211,0.05);
        }

        .box {
            /*background-color: rgba(211,211,211,0.05); */
            margin: 2% 12% 0 12%;
            padding: 1% 1% 0 1%;
        }

        .modal.visible {

            -webkit-transform: scale(1);
            transform: scale(1);

            -webkit-transition:
                    -webkit-transform 0.3s cubic-bezier(0.465, 0.183, 0.153, 0.946),
                    opacity 0.3s cubic-bezier(0.465, 0.183, 0.153, 0.946);

            transition:
                    transform 0.3s cubic-bezier(0.465, 0.183, 0.153, 0.946),
                    opacity 0.3s cubic-bezier(0.465, 0.183, 0.153, 0.946);

        }

        table, tr, td {
            text-align: center;
            padding-bottom: 0;
            padding-top: 0;
        }

        table {
            width: 1060px;
        }

        #par_nazov {
            color: brown;
            font-weight: bold;
            font-size: 25px;
            font-family: 'Open Sans', sans-serif;
            text-shadow: 2px 2px 4px #000000;
        }

        #nepar_nazov {
            color: rgb(218,154,19); /*rgb(218,154,19)*/
            font-weight: bold;
            font-size: 25px;
            font-family: 'Open Sans', sans-serif;
            text-shadow: 2px 2px 4px #000000;
        }

        #info_body {
            background-color: rgba(211,211,211,0.05);
            width: 40%;
            margin: 0 30%;
            text-align: center;
        }

        #spravnost {
            font-size: 20px;
            font-family: 'Open Sans', sans-serif;
            text-shadow: 2px 2px 4px #000000;
            font-weight: bold;
        }

        #demo {
            color: white;
            font-family: 'Open Sans', sans-serif;
            text-shadow: 2px 2px 4px #000000;
        }

        #bodovy {
            color: red;
            font-size: 25px;
        }

        .hneda {
            color: brown;
        }

        .zlta {
            color: rgb(218,154,19);
        }

        .cervena {
            color: rgb(220,20,60);
        }

        .zelena {
            color: rgb(50,205,50);
        }

        .white {
            color: white;
        }

        .btn_my {
            background-color: rgb(218,154,19);
            padding: 12px 28px;
            border-radius: 12px;
            border: 2px solid brown;
            margin: 1% 45% auto;
        }

        .btn_my:hover {
            background-color: brown;
            color: white;
            box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
        }

        .button_znova {
            margin: 5% 0 0 0;
            background-color: rgb(218,154,19);
            padding: 6px 12px;
            border-radius: 12px;
        }

        .button_znova:hover {
            color: white;
            box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
        }

        .shadow {
            text-shadow: 1px 1px 1px #000000;
        }

        #casovac {
            background-color: rgba(211,211,211,0.05);
            width: 40%;
            margin: auto;
            text-align: center;
        }

        #hra {
            display: none;
            position: relative;
        }

        .font18 {
            font-size: 1.8em;
        }

        .font16 {
            font-size: 2em;
        }

        .hrMY {
            border: 0;
            height: 1px;
            background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
        }

    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        var bodovy_stav = 0;
        var polePrikladov = [];
        var poleVysledkov = [];
        var pocetVlozenychKarticiek = getCookie("pocetVlozenychKarticiek");
        var myScore;
        var seconds = 0;
        var minutes = 0;
        var timeEv;
        var time = 0;
        var final_score = 0;
        timer();

        function allowDrop(ev) {
            ev.preventDefault();drag1, drag2, drag3, drag4, drag5, drag6, drag7, drag8, drag9, drag10
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);

        }

        function drop(ev) {
            if(getCookie("bodovy_stav")!= 0)
            {
                bodovy_stav = getCookie("bodovy_stav");
            }
            var reS;
            if(getCookie('reS') != 0){
                reS = getCookie('reS');
            }
            else
            {
                reS = 10;
            }
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            var slovo = document.getElementById(data).innerHTML;

            for (i = 0; i < 10; i++) {
                if (slovo == polePrikladov[i])
                    priklad = poleVysledkov[i];
            }

            divName = $(ev.target).attr('id');
            ev.target.appendChild(document.getElementById(data));
            reS -= 1;
            setCookie("reS", reS, 30);
            if (((priklad % 2) == 0) && (divName == "parny_div")) {
                bodovy_stav++;
                document.getElementById("spravnost").style.color = "rgb(50,205,50)";
                document.getElementById("spravnost").innerHTML = "Spravne!";

            }
            else {
                if (((priklad % 2) == 1) && (divName == "neparny_div")) {
                    bodovy_stav++;
                    document.getElementById("spravnost").style.color = "rgb(50,205,50)";
                    document.getElementById("spravnost").innerHTML = "Spravne!";
                }
                else {
                    document.getElementById("spravnost").style.color = "rgb(220,20,60)";
                    document.getElementById("spravnost").innerHTML = "Nespravne!";
                }

            }

            //console.log(bodovy_stav);


            document.getElementById("demo").innerHTML = 'Tvoj bodovy stav je: <span id="bodovy">' + bodovy_stav + '</span>';
            pocetVlozenychKarticiek++;
            console.log(pocetVlozenychKarticiek);
            setCookie("bodovy_stav ", bodovy_stav , 30);
            setCookie("pocetVlozenychKarticiek", pocetVlozenychKarticiek, 30);
            if (getCookie("pocetVlozenychKarticiek") == 10) {
                koniecHry();
            }

        }
        function Reset()
        {
            setCookie("bodovy_stav ",0 , 30);
            setCookie("pocetVlozenychKarticiek",0, 30);
            setCookie("reS", 0, 30);
            reLoadPage();
        }
        function pridajHodnoty() {
            timer();
            document.getElementById("uvod").style.display = "none";
            document.getElementById("hra").style.display = "block";

            if(getCookie('reS') == 0)
            {
                for(var i = 1; i <= 10; i++){
                    $("#content").append( "<div id='drag"+i+"' class='dragy' draggable='true' ondragstart='drag(event)'></div>" );
                }
            }
            else{
                for(var i = 1; i <= getCookie('reS'); i++){
                    $("#content").append( "<div id='drag"+i+"' class='dragy' draggable='true' ondragstart='drag(event)'></div>" );
                }
            }

            for (i = 0; i < 3; i++) {
                num1 = Math.floor(Math.random() * (10 - 1 + 1)) + 1;
                num2 = Math.floor(Math.random() * (10 - 1 + 1)) + 1;
                polePrikladov[i] = num1 +" + "+ num2;
                poleVysledkov[i] = num1+num2;
                document.getElementById("drag"+(i+1)).innerHTML = polePrikladov[i];
            }

            for (i = 3; i < 7; i++) {
                num1 = Math.floor(Math.random() * (10 - 1 + 1)) + 1;
                num2 = Math.floor(Math.random() * (10 - 1 + 1)) + 1;
                num3 = Math.floor(Math.random() * (10 - 1 + 1)) + 1;
                polePrikladov[i] = num1 +" + "+ num2 + " * " + num3;
                poleVysledkov[i] = num1+num2*num3;
                document.getElementById("drag"+(i+1)).innerHTML = polePrikladov[i];
            }

            for (i = 7; i < 10; i++) {
                num1 = Math.floor(Math.random() * (10 - 1 + 1)) + 1;
                num2 = Math.floor(Math.random() * (10 - 1 + 1)) + 1;
                num3 = Math.floor(Math.random() * (10 - 1 + 1)) + 1;
                polePrikladov[i] = num1 +" + "+ num2 + " + " +num3;
                poleVysledkov[i] = num1+num2+num3;
                document.getElementById("drag"+(i+1)).innerHTML = polePrikladov[i];
            }

            console.log(polePrikladov);
            console.log(poleVysledkov);

        }


        function koniecHry() {
            koniecCasovac();
            var konecny_cas = time - 1;

            //CELKOVE BODOVANIE: cas vynasobeny poctom nespravnych odpovedi zvacseny o jedna
            final_score = konecny_cas * (10 - bodovy_stav + 1);


            document.getElementById('koniecText').innerHTML = '<h1 class="cervena nadpisH1">Koniec Hry</h1>';

            if (bodovy_stav == 10) {
                document.getElementById('koniecText2').innerHTML = '<b>Blahoželáme!</b> <br> Išlo ti to naozaj skvele, dosiahol si maximálny počet bodov <span class="zelena shadow"><b>10/10</b></span> :) <br> Zvládol si to za <span class="white shadow">' + konecny_cas + ' s</span> <hr class="hrMY"> <b>Tvoje práve nahraté skoré: <span class="hneda shadow font16">' + final_score + '</span></b><hr class="hrMY"><span id="najSkore"></span>';
            }
            if ((bodovy_stav < 10) && (bodovy_stav > 7)) {
                document.getElementById('koniecText2').innerHTML = '<b>Blahoželáme!</b> <br> Išlo ti to celkom slušne. <br> <span class="zelena shadow"><b>' + bodovy_stav + ' bodov z 10</b></span> <br> Zvládol si to za <span class="white shadow">' + konecny_cas + ' s</span><hr class="hrMY"> <b>Tvoje práve nahraté skoré: <span class="hneda shadow font16">' + final_score + '</span></b><hr class="hrMY"><span id="najSkore"></span>';
            }
            if ((bodovy_stav < 8) && (bodovy_stav > 4)) {
                document.getElementById('koniecText2').innerHTML = '<b>Blahoželáme!</b> <br> Išlo ti to celkom slušne, ale dá sa to aj lepšie, skús znova :) <br> <span class="cervena shadow"><b>' + bodovy_stav + ' bodov z 10</b></span> <br> Zvládol si to za <span class="white shadow">' + konecny_cas + ' s</span><hr class="hrMY"> <b>Tvoje práve nahraté skoré: <span class="hneda shadow font16">' + final_score + '</span></b><hr class="hrMY"><span id="najSkore"></span>';
            }
            if (bodovy_stav < 5) {
                document.getElementById('koniecText2').innerHTML = 'Nedosiahol si ani polovicu možných bodov. Nebudúce to snáď bude lepšie :)<br> <span class="cervena shadow"><b>' + bodovy_stav + ' b z 10</b></span><br> Zvládol si to za <span class="white shadow">' + konecny_cas + ' s</span><hr class="hrMY"> <b>Tvoje práve nahraté skoré: <span class="hneda shadow font16">' + final_score + '</span></b><hr class="hrMY"><span id="najSkore"></span>';
            }
            save();
            setCookie("bodovy_stav ",0 , 30);
            setCookie("pocetVlozenychKarticiek",0, 30);
            setCookie("reS", 0, 30);
            document.getElementById('myModal').style.display = "block";
        }

        function reLoadPage() {
            location.reload();
        }

        function timer(){
            document.getElementById('cas').innerHTML = time++;
            timeEv = setTimeout(timer,1000);
        }

        function koniecCasovac() {
            clearTimeout(timeEv);
        }


        function save() {
            var val = getCookie("bestScoreSimi");
            if ((val == null) || (val == "")){
                setCookie("bestScoreSimi", final_score, 30);   // plati na 30dni
            }
            else{
                if (parseInt(val) > final_score)
                    setCookie("bestScoreSimi", final_score, 30);
            }
            val = getCookie("bestScoreSimi");
            document.getElementById('najSkore').innerHTML = '<b>Tvoje doteraz najlepšie skoré je: <span class="zelena shadow font18">' + val + '</span></b>';
        }

        function setCookie(cname, cvalue, exdays){
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires="+d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires;
        }

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }



    </script>
    <script>
        $(document).ready(function()
        {

            function getCookie(name) {
                var dc = document.cookie;
                var prefix = name + "=";
                var begin = dc.indexOf("; " + prefix);
                if (begin == -1) {
                    begin = dc.indexOf(prefix);
                    if (begin != 0) return null;
                }
                else
                {
                    begin += 2;
                    var end = document.cookie.indexOf(";", begin);
                    if (end == -1) {
                        end = dc.length;
                    }
                }
                // because unescape has been deprecated, replaced with decodeURI
                //return unescape(dc.substring(begin + prefix.length, end));
                return decodeURI(dc.substring(begin + prefix.length, end));
            }
        });
    </script>
    <!-- Menu -->
    <!--
    ================================================== -->
    <!-- TOOT JE KAZDEHO CAST DO KTOREJ MOZE VKLADAT VECI -->

    <div class="container" >


        <div class="body_div_simi">
            <div id="uvod">
                <h1 class="nadpisH1"><span class="hneda">Even</span> or <span class="zlta">odd</span> ?</h1>
                <h3 class="nadpisH3">Cieľ hry:</h3>
                <p>Hráč musí roztriediť kartičky s vygenerovanými príkladmi do správnych boxov, podľa toho, či je výsledok príkladu párny alebo nepárny s čo najnižším skoré.</p>
                <h3 class="nadpisH3">Pravidlá hry:</h3>
                <ul>
                    <li>Akonáhle hráč klikne na tlačidlo "Začni hru" spustí sa časovač, ktorý počíta čas, za ktorý bola hra vyriešená.</li>
                    <li>Kliknutím a následným ťahaním kartičky, hráč vloží kartičku do (ne)párneho boxu.</li>
                    <li>Ak hráč priradí kartičku správne, pripočíta sa mu bod za správnu odpoveď.</li>
                    <li>Dôležité je získať čo najnižšie skoré, to sa počíta podľa nasledovného vzorca: čas * (počet nesprávnych odpovedí + 1) </li>
                </ul>
                <button class="btn_my" type="button" onclick="pridajHodnoty()">Začni hru</button>

                <br>
            </div>

            <div id="hra">
                <div id="casovac" class="zlta">Tvoj čas: <span class="cervena shadow"><b><span id="cas"></span> s</b></span></div>
                <div id="content">

                </div>

                <table>
                    <tr>
                        <td><img id="parny_div" class="box" src="games/odd_even/par.png" ondrop="drop(event)" ondragover="allowDrop(event)" alt="parny box" width="210" height="210" /></td>
                        <td><img id="neparny_div" class="box" src="games/odd_even/nepar.png" ondrop="drop(event)" ondragover="allowDrop(event)" alt="neparny box" width="210" height="210"/></td>
                    </tr>
                    <tr>
                        <td id="par_nazov">Párne čísla</td>
                        <td id="nepar_nazov">Nepárne čísla</td>
                    </tr>
                    <button class="btn_my" type="button" onclick="Reset()">Reset</button>
                </table>

                <div id="info_body">
                    <p id="spravnost"></p>
                    <p id="demo"></p>
                </div>

            </div>

            <div id="myModal" class="modal">
                <div class="modal-content">
                    <p id="koniecText"></p>
                    <p id="koniecText2"></p>
                    <button class="button_znova" onclick="reLoadPage()">Choď na začiatok</button>
                </div>
            </div>

        </div>
    </div>
@stop