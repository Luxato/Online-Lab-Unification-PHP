@extends('master')

@section('title') Scilab Dokumentácia @stop

@section('seo_description') @stop

@section('keywords') @stop

@section('content')
    <link rel="stylesheet" href="<?= url( 'assets/css/shCore.css' ) ?>" type="text/css"/>
    <link rel="stylesheet" href="<?= url( 'assets/css/shThemeDefault.css' ) ?>" type="text/css"/>

    <h1>Simulačné prostredia</h1>
    <a target="_blank" href="http://147.175.105.140:8011/sciclient/index.php">
        <button type="button" class="btn btn-primary">Odkaz na aplikáciu</button>
    </a>
    <br>
    <strong>Scilab 5.5.0</strong>
    <strong>ScicosLab 4.4.1</strong>

    <strong>engine</strong>
    <p>Simulačné prostredie. Scilab alebo ScicosLab. [scilab/scicoslab]</p>

    <strong>data_type</strong>
    <p>Zdroj vstupných dát, ktoré budú odoslané do simulačného prostredia:
    <ul>
        <li>[textdata] - Text area, pozri paramater [code]</li>
        <li>[filedata] - súbor s kódom</li>
        <li>[simulation] - súbor s blokovou schémou, ktorá sa odsimuluje na serveri</li>
    </ul>
    <strong>formula_output</strong>
    Výstup zo simulačného prostredia.
    <ul>
        <li>raw - dáta nie sú formátované</li>
        <li>tex - výstupné dáta vo formate TeX, Latex</li>
    </ul>
    <strong>code</strong>
    <p>
        Kód (matematický výraz), ktorý sa vyhodnotí simulačným prostredím. Príkazové inštrukcie je potrebné oddeľovať čiarkou(,) alebo bodkočiarkou(;). Pri bodkočiarke nie je výsledok inštrukcií zobrazený pri číarke sa zobrazí (je navrátený simulačným prostredím)</p>

    <strong>api_key</strong>
    <p>Reťazec znakov identifikujúci odosielaťeľa požiadavky.</p>

    <strong>variable_output</strong>
    <p>V prípade Scilabu nadobúda hodnotu ["json"] - premenné sa exportuju v json formate, v prípade Scicoslabu je parameter ignorovaný.</p>

    <strong>variable_list</strong>
    <p>Zoznam premenných ktoré sa budú zo simulačných prostredí exportovať oddelené čiarkou. ["x, y, z"].</p>

    <strong>graphic_figure</strong>
    <p>Exportovanie grafiky, resp. grafov do viacerých rôznych formátov. Pre Scilab sú to: *.png, *.svg, *.jpg,*.ps pre Scicoslab: *.gif,*.ps,*.fig,*.ppm. Hodnoty parametra sú v tvare stringu, oddelené čiarkou: ["png, svg"].</p>

    <strong>advanced_features ["yes"]</strong>
    <p>Načítanie rozšírených funkcií (v prípade scicoslabu - Java). Potrebné pri spúštaní simulácií v Scilabe, exportovanie grafov do obrázkov. Používanie pokročilých funkcií predĺžuje dobu spúštania Scilabu niekoľkonásobne (používajte iba v nutných prípadoch). V prípade nepoužívania pokročilých funkcií sa paramater vynecháva.</p>

    <strong>simulation_parameters</strong>
    <p>Hodnoty parametra sa oddeľujú čiarkou a sú v tvare "premenna1=hodnota1, premenna2=hodnota2". Využíva sa pri nastavovaní/zmene parametrov v blokových schémach.</p>

    <pre class="brush: js">
{
    "engine": "scilab",
    "data_type": "textdata",
    "formula_output": "raw",
    "code": "factorial(170);disp(ans)",
    "api_key": "c0a082896a8c2f946ea7f67d3ae39c41",
}
    </pre>
    <strong>status</strong>
    <p>Úspešnosť vyhodnotenia požiadavky serverom.</p>
    <ul>
        <li>success - úspešné spracovanie</li>
        <li>error - chyba pri spracovaní (napr. zlý API kľúč,...)</li>
    </ul>
    <p>Ak nastala chyba, response obsahuje položku code - pole chýb</p>
    <strong>response</strong>
    <ul>
        <li>raw - výstup zo simulačného prostredia</li>
        <li>json - vrátený JSON s premennými zadanými v parametri "variable_list"</li>
        <li>json_file - odkaz na vytvorený json súbor (Scilab)</li>
        <li>variables - exportované premenné zo Scicoslabu</li>
        <li>variable_files - odkaz na vytvorený txt súbor zo Scicoslabu</li>
    </ul>
    <pre class="brush: js">
{
    "status": "success",
    "response": {
    "raw": " y  =\n \n    2.    2.    5.    31.  \n",
    "json": {
        "y": [
            2,
            2,
            5,
            31
        ]
    },
    "json_file": "147.175.105.140:8011/sciengine/tmppublic/1464544941_json.json"
} }
    </pre>
    <pre class="brush: js">
{
    "status": "success",
    "response": {
        "raw": " x  =\n \n    10.  \n",
        "variables": {
            "x": "   10.000000000000000     \n"
        },
        "variable_files": {
            "x": "147.175.105.140:8011/sciengine/tmppublic/1465746254_sci_x.txt"
        }
    }
}
    </pre>



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