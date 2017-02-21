@extends('master')

@section('title')
    Maxima octave
@stop

@section('content')
    <h1>Dokumentácia</h1>
    <p>
        Adresa aplikácie:
        <i>http://obelix.urpi.fei.stuba.sk/~targroup/slivkap/app/</i><br>
        Aktuálne verzie CAS:<br>
        - Maxima 5.26.0<br>
        - GNU Octave 3.6.1<br>
        Aplikácia reaguje na volania vo formáte XML-RPC a JSON-RPC
    </p>
    <h2>Metódy</h2>
    <h3 style="text-decoration:underline;">eval</h3>
    <code>eval (api_key, code, engine [, graph_output [, formula_output [, load ]]])<br></code>
    <p>
        Vyhodnotí zadaný kód pomocou zvoleného enginu.
    </p>

    <div class="maxima_octave_manual">


        <h4>Parametre</h4>
        <dl>
            <dt>api_key</dt>
            <dd>Reťazec znakov, ktorý identifikuje odosielateľa požiadavky</dd>

            <dt>code</dt>
            <dd>Reťazec kódu, ktorý sa má vyhodnotiť</dd>

            <dt>engine</dt>
            <dd>Computer Algebra System určený na výpočet požiadavky.<br>
                Môže byť zadaný jednou z nasledovných hodnôt:<br>
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
            <dd>Výstupný formát grafov.<br>
                Môže byť zadaný nasledovnými hodnotami:<br>
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
            <dd>Výstupný formát vzorcov.<br>
                Môže byť zadaný nasledovnými hodnotami:<br>
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

    </div>


    <br><h1>Príklady použitia</h1>

@stop