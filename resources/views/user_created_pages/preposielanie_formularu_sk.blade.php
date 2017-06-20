@extends('master')

@section('title')
    Preposielanie Formuláru
@stop

@section('content')
    <link rel="stylesheet" href="<?= url( 'assets/css/shCore.css' ) ?>" type="text/css"/>
    <link rel="stylesheet" href="<?= url( 'assets/css/shThemeDefault.css' ) ?>" type="text/css"/>

    <div id="content" style="min-height: 195px;">
        <h1>Odosielanie formulára v statických html stránkach na e-mail</h1>
        <a target="_blank" href="http://vmzakova.fei.stuba.sk/form2mail/"><button type="button" class="btn btn-primary">Odkaz na aplikáciu</button></a>
        <br>

            Pred samotným použitím služby je potrebné si vygenerovať API kľúč. API kľúč je možné vygenerovať na tejto stránke po prihlásení.


        <p>
            Formulár,ktorý chcete posielať e-mailom, musí byť definovaný nasledovne
        </p>

        <pre class="brush: xml">
            <!--<form action="http://vmzakova.fei.stuba.sk/form2mail/form2mail.php" method="post" enctype="multipart/form-data" >-->
        </pre>

        <p>Parametre
            pre posielanie mailu sa odovzdávajú v skrytých poliach formulára (prípadne aj vo
            viditeľných textových poliach, napríklad ak sa na formulári má vypísať e-mailová
            adresa je ju možné použiť ako adresu odosielateľa). <br>
            <br>
        </p>

        <table border="0" class="baliky" cellspacing="0">
            <tbody>
            <tr class="bal_hrow2">
                <th width="25%">Názov parametra</th>
                <th width="75%">Funkcia
                </th>
            </tr>
            <tr>
                <td width="25%"><code class="important">apikey</code></td>
                <td width="75%">povinný parameter umožňujúci odoslať email iba registrovanému užívateľovi</td>
            </tr>

            <tr>
                <td width="25%"><code>from</code></td>
                <td width="75%">povinný parameter s emailovou adresou odosielateľa formuláru</td>
            </tr>
            <tr>
                <td width="25%"><code>sender</code></td>
                <td width="75%">nepovinný parameter s menom odosielateľa (toto meno bude vidieť ako odosielateľa mailu s vyplneným formulárom)</td>
            </tr>

            <tr>
                <td width="25%"><code>to</code></td>
                <td width="75%">povinný parameter udávajúci kam sa
                    má poslať formulár <br>(toto bude vaša adresa, na ktorú chcete dostávať vyplnené
                    formuláre z vašej stránky) </td>
            </tr>
            <tr>
                <td width="25%"><code>subject</code></td>
                <td width="75%">povinný parameter označujúci predmet správy</td>
            </tr>

            <tr>
                <td width="25%"><code>redirectOk</code></td>
                <td width="75%">povinný parameter s adresou
                    stránky, ktorá sa má zobraziť v prípade úspešného odoslania formuláru <strong>[príklad http://nieco.sk]</strong></td>
            </tr>
            <tr>
                <td width="25%"><code>redirectFalse</code></td>
                <td width="75%">povinný parameter s adresou
                    stránky, ktorá sa má zobraziť v prípade chyby <strong>[príklad http://nieco.sk]</strong>
                </td>
            </tr>
            </tbody>
        </table>
        <p>
            Kódovanie je nastavené na UTF-8.
        </p>
        <h3><a href="http://localhost:8000/downloads/email.html.txt"><i class="fa fa-download" aria-hidden="true"></i> Príklad na stiahnutie</a></h3>
        <p>
            Tento formulár môže slúžiť na posielanie e-mailu od návštevníkov Vašej stránky na Vašu poštovú adresu.
        </p><p>
            <b>Uvedený spôsob odosielania formulárov na e-mail je vhodný iba pre posielanie e-mailov zo statických HTML stránok. Na odosielanie e-mailov z PHP používajte štandardnú funkciu mail().  </b>
        </p>
    </div>

    <script type="text/javascript" src="<?= url('assets/js/syntaxhighlihter') ?>/shCore.js"></script>
    <script type="text/javascript" src="<?= url('assets/js/syntaxhighlihter') ?>/shBrushJScript.js"></script>
    <script src="<?= url('assets/js/syntaxhighlihter') ?>/shAutoloader.js"></script>
    <script>
        SyntaxHighlighter.autoloader(
            'php  <?= url('assets/js/syntaxhighlihter') ?>/shBroshPhp.js',
            'xml <?= url('assets/js/syntaxhighlihter') ?>/shBrushXml.js',
            'js <?= url('assets/js/syntaxhighlihter') ?>/shBrushJScript.js'
        );
        SyntaxHighlighter.all();
    </script>
@stop