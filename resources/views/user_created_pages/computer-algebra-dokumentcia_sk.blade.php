@extends('master')

@section('title') Computer Algebra Dokumentácia @stop

@section('seo_description') @stop

@section('keywords') @stop

@section('content')
    <link rel="stylesheet" href="<?= url('assets/css/shCore.css') ?>" type="text/css" />
    <link rel="stylesheet" href="<?= url('assets/css/shThemeDefault.css') ?>" type="text/css" />
    <h1>Dokumentácia</h1>
    <div class="col-md-6">
        Adresa aplikácie:
        <i>http://obelix.urpi.fei.stuba.sk/~targroup/slivkap/app/</i><br />
        Aktuálne verzie CAS:<br />
        - Maxima 5.26.0<br />
        - GNU Octave 3.6.1<br />
        Aplikácia reaguje na volania vo formáte XML-RPC a JSON-RPC

        <h2>Metódy</h2>
        <h3>eval</h3>
        eval (api_key, code, engine [, graph_output [, formula_output [, load ]]])<br />
        Vyhodnotí zadaný kód pomocou zvoleného enginu.
        <h4>Parametre</h4>
        <dl>
            <dt>api_key</dt>
            <dd>Reťazec znakov, ktorý identifikuje odosielateľa požiadavky</dd>

            <dt>code</dt>
            <dd>Reťazec kódu, ktorý sa má vyhodnotiť</dd>

            <dt>engine</dt>
            <dd>Computer Algebra System určený na výpočet požiadavky.<br />
                Môže byť zadaný jednou z nasledovných hodnôt:<br />
                <table>
                    <tbody>
                    <tr>
                        <td class="param_name">maxima</td>
                        <td>predvolená hodnota</td>
                    </tr>
                    <tr>
                        <td class="param_name">octave</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </dd>

            <dt>graph_output</dt>
            <dd>Výstupný formát grafov.<br />
                Môže byť zadaný nasledovnými hodnotami:<br />
                <table>
                    <tbody>
                    <tr>
                        <td class="param_name">png</td>
                        <td>Rastrová grafika. Predvolená hodnota.</td>
                    </tr>
                    <tr>
                        <td class="param_name">svg</td>
                        <td>Vektorová grafika.</td>
                    </tr>
                    <tr>
                        <td class="param_name">array</td>
                        <td>Vracia graf ako pole hodnôt.</td>
                    </tr>
                    <tr>
                        <td class="param_name">text</td>
                        <td>Textova interpretácia grafu. Hodnoty sú na jednotlivých riadkoch oddelené medzerou.</td>
                    </tr>
                    </tbody>
                </table>
                Parameter môže byť zadaný aj ako pole hodnôt.
            </dd>

            <dt>formula_output</dt>
            <dd>Výstupný formát vzorcov.<br />
                Môže byť zadaný nasledovnými hodnotami:<br />
                <table>
                    <tbody>
                    <tr>
                        <td class="param_name">tex</td>
                        <td>Vzorec vo formáte LaTex. Predvolená hodnota.</td>
                    </tr>
                    <tr>
                        <td class="param_name">image</td>
                        <td>Vzorec ako obrázok.</td>
                    </tr>
                    <tr>
                        <td class="param_name">native</td>
                        <td>Vzorec v natívnom tvare CAS, ktorý je možné použiť pre ďalší výpočet.</td>
                    </tr>
                    </tbody>
                </table>
                Parameter môže byť zadaný aj ako pole hodnôt.
            </dd>

            <dt>load</dt>
            <dd>reťazec base64-enkódovaných binárnych dát, ktoré búdú načítané do inštancie CAS. Parameter môže byť zadaný aj ako pole reťazcov.</dd>
        </dl>

        <h4>Vracia</h4>
        <dl>
            <dt>result</dt>
            <dd>výsledok výpočtu</dd>

            <dt>graphs</dt>
            <dd>pole grafov v žiadanom formáte. V prípade požiadavky na viacero formátov je výstupom asociované pole/hash.</dd>

            <dt>formulas</dt>
            <dd>pole vzorcov v žiadanom formáte. V prípade požiadavky na viacero formátov je výstupom asociované pole/hash.</dd>

            <dt>error</dt>
            <dd>chybové hlásenie</dd>
        </dl>
        <br />

    </div>
    <div class="col-md-6">
        <h2>Príklad</h2>
        Príklad jednoduchej požiadavky na výpočet sin(x)/x v prostredí Maxima. Vzorec je požadovaný
        v natívnom formáte a vo formáte LaTex. Graf je požadovaný vo formáte png.
        <h3>JSON-RPC</h3>
        <h4>request</h4>

        <div><div id="highlighter_508667" class="syntaxhighlighter  js"><div class="toolbar"><span><a href="#" class="toolbar_item command_help help">?</a></span></div><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td class="gutter"><div class="line number1 index0 alt2">1</div><div class="line number2 index1 alt1">2</div><div class="line number3 index2 alt2">3</div><div class="line number4 index3 alt1">4</div><div class="line number5 index4 alt2">5</div><div class="line number6 index5 alt1">6</div><div class="line number7 index6 alt2">7</div><div class="line number8 index7 alt1">8</div><div class="line number9 index8 alt2">9</div><div class="line number10 index9 alt1">10</div><div class="line number11 index10 alt2">11</div><div class="line number12 index11 alt1">12</div><div class="line number13 index12 alt2">13</div></td><td class="code"><div class="container"><div class="line number1 index0 alt2"><code class="js plain">{</code></div><div class="line number2 index1 alt1"><code class="js spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="js string">"method"</code><code class="js plain">: </code><code class="js string">"eval"</code><code class="js plain">,</code></div><div class="line number3 index2 alt2"><code class="js spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="js string">"params"</code><code class="js plain">: {</code></div><div class="line number4 index3 alt1"><code class="js spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="js string">"api_key"</code><code class="js plain">: </code><code class="js string">"API kľúč"</code><code class="js plain">,</code></div><div class="line number5 index4 alt2"><code class="js spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="js string">"code"</code><code class="js plain">: </code><code class="js string">"sin(x)/x;\r\nplot2d (sin(x)/x, [x, -20, 20])$"</code><code class="js plain">,</code></div><div class="line number6 index5 alt1"><code class="js spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="js string">"engine"</code><code class="js plain">: </code><code class="js string">"maxima"</code><code class="js plain">,</code></div><div class="line number7 index6 alt2"><code class="js spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="js string">"graph_output"</code><code class="js plain">: </code><code class="js string">"png"</code><code class="js plain">,</code></div><div class="line number8 index7 alt1"><code class="js spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="js string">"formula_output"</code><code class="js plain">: [</code></div><div class="line number9 index8 alt2"><code class="js spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="js string">"tex"</code><code class="js plain">, </code><code class="js string">"native"</code></div><div class="line number10 index9 alt1"><code class="js spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="js plain">]</code></div><div class="line number11 index10 alt2"><code class="js spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="js plain">},</code></div><div class="line number12 index11 alt1"><code class="js spaces">&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="js string">"id"</code><code class="js plain">: 1</code></div><div class="line number13 index12 alt2"><code class="js plain">}</code></div></div></td></tr></tbody></table></div></div>

        <h4>response</h4>

	    <?php
	    $var = '{
    "id": 1,
    "result": {
        "result": "
                 sin(x)
          (%i1)  ------
                   x
                sin(x)
          (%o1) ------
                  x
                         sin(x)
          (%i2)  plot2d(------, [x, - 20, 20])
                           x
        ",
        "graphs": [
            "http:\/\/ ... \/plot1-1335352585.png"
        ],
        "formulas": {
            "tex": [
                "$${{\\sin x}\\over{x}}$$"
            ],
            "native": [
                "sin(x)\/x$"
        ]
        }
    },
    "error": null
}';
	    ?>
        <pre class="brush: js">
        <?= $var ?>
    </pre>
	    <?php
	    $var = '&lt;?xml version="1.0"?&gt;
&lt;methodCall&gt;
  &lt;methodName&gt;eval&lt;/methodName&gt;
  &lt;params&gt;
    &lt;param&gt;
        &lt;struct&gt;
            &lt;member&gt;
                &lt;name&gt;api_key&lt;/name&gt;
                &lt;value&gt;&lt;string&gt;API kľúč&lt;/string&gt;&lt;/value&gt;
            &lt;/member&gt;
            &lt;member&gt;
                &lt;name&gt;code&lt;/name&gt;
                &lt;value&gt;&lt;string&gt;&lt;![CDATA[sin(x)/x;\r\nplot2d (sin(x)/x, [x, -20, 20])$]]&gt;&lt;/string&gt;&lt;/value&gt;
            &lt;/member&gt;
            &lt;member&gt;
                &lt;name&gt;engine&lt;/name&gt;
                &lt;value&gt;&lt;string&gt;maxima&lt;/string&gt;&lt;/value&gt;
            &lt;/member&gt;
            &lt;member&gt;
                &lt;name&gt;graph_output&lt;/name&gt;
                &lt;value&gt;&lt;string&gt;png&lt;/string&gt;&lt;/value&gt;
            &lt;/member&gt;
            &lt;member&gt;
                &lt;name&gt;formula_output&lt;/name&gt;
                &lt;value&gt;
                    &lt;array&gt;
                        &lt;data&gt;
                            &lt;value&gt;&lt;string&gt;tex&lt;/string&gt;&lt;/value&gt;
                            &lt;value&gt;&lt;string&gt;native&lt;/string&gt;&lt;/value&gt;
                        &lt;/data&gt;
                    &lt;/array&gt;
                &lt;/value&gt;
            &lt;/member&gt;
        &lt;/struct&gt;
    &lt;/param&gt;
  &lt;/params&gt;
 &lt;/methodCall&gt;;
';
	    ?>
        <h3>XML-RPC</h3>
        <h4>request</h4>

        <pre class="brush: xml">
        <?= $var ?>
    </pre>

        <h4>response</h4>

	    <?php
	    $var= '&lt;?xml version="1.0" encoding="iso-8859-1"?&gt;
&lt;methodResponse&gt;
&lt;params&gt;
 &lt;param&gt;
  &lt;value&gt;
   &lt;struct&gt;
    &lt;member&gt;
     &lt;name&gt;result&lt;/name&gt;
     &lt;value&gt;
      &lt;string&gt;&#10;       sin(x)&#10;(%i1)  ------&#10;         x  &#10;      sin(x)&#10;(%o1) ------&#10;        x&#10;              sin(x)&#10;(%i2)  plot2d(------, [x, - 20, 20])&#10;                x&#10;
      &lt;/string&gt;
     &lt;/value&gt;
    &lt;/member&gt;
    &lt;member&gt;
     &lt;name&gt;graphs&lt;/name&gt;
     &lt;value&gt;
      &lt;array&gt;
       &lt;data&gt;
        &lt;value&gt;
         &lt;string&gt;http:// ... /plot1-1335364865.png&lt;/string&gt;
        &lt;/value&gt;
       &lt;/data&gt;
      &lt;/array&gt;
     &lt;/value&gt;
    &lt;/member&gt;
    &lt;member&gt;
     &lt;name&gt;formulas&lt;/name&gt;
     &lt;value&gt;
      &lt;struct&gt;
       &lt;member&gt;
        &lt;name&gt;tex&lt;/name&gt;
        &lt;value&gt;
         &lt;array&gt;
          &lt;data&gt;
           &lt;value&gt;
            &lt;string&gt;$${{\sin x}\over{x}}$$&lt;/string&gt;
           &lt;/value&gt;
          &lt;/data&gt;
         &lt;/array&gt;
        &lt;/value&gt;
       &lt;/member&gt;
       &lt;member&gt;
        &lt;name&gt;native&lt;/name&gt;
        &lt;value&gt;
         &lt;array&gt;
          &lt;data&gt;
           &lt;value&gt;
            &lt;string&gt;sin(x)/x$&lt;/string&gt;
           &lt;/value&gt;
          &lt;/data&gt;
         &lt;/array&gt;
        &lt;/value&gt;
       &lt;/member&gt;
      &lt;/struct&gt;
     &lt;/value&gt;
    &lt;/member&gt;
    &lt;member&gt;
     &lt;name&gt;error&lt;/name&gt;
     &lt;value&gt;
      &lt;string&gt;null&lt;/string&gt;
     &lt;/value&gt;
    &lt;/member&gt;
   &lt;/struct&gt;
  &lt;/value&gt;
 &lt;/param&gt;
&lt;/params&gt;
&lt;/methodResponse&gt;
	    '?>
        <pre class="brush: xml">
        <?= $var ?>
    </pre>
    </div>



    <script type="text/javascript" src="<?= url('assets/js/syntaxhighlihter') ?>/shCore.js"></script>
    <script type="text/javascript" src="<?= url('assets/js/syntaxhighlihter') ?>/shBrushJScript.js"></script>
    <script src="<?= url('assets/js/syntaxhighlihter') ?>/shAutoloader.js"></script>
    <script>
        SyntaxHighlighter.autoloader(
            'php  <?= url('assets/js/syntaxhighlihter') ?>/shBroshPhp.js',
            'xml <?= url('assets/js/syntaxhighlihter') ?>/shBrushXml.js'
        );
        SyntaxHighlighter.all();
    </script>
@stop

