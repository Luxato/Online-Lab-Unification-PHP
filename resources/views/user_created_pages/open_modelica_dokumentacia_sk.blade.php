
@extends('master')

@section('title') Open modelica príručka @stop

@section('seo_description') @stop

@section('keywords') @stop

@section('content')
    <link rel="stylesheet" href="<?= url('assets/css/shCore.css') ?>" type="text/css" />
    <link rel="stylesheet" href="<?= url('assets/css/shThemeDefault.css') ?>" type="text/css" />

    <h1>Open Modelica príručka</h1>
    <a target="_blank" href="http://147.175.105.140:8008/om.php"><button type="button" class="btn btn-primary">Odkaz na aplikáciu</button></a><br>
    <p>Táto aplikácia umožňuje vytvoriť spojenie a komunikovať so simulačným prostredím OpenModelica cez internet prostredníctvom technológií vzdialeného volania procedúr - JSON-RPC, XML-RPC. Vytvorené webové služby umožňujú vykonanie výpočtu matematického výrazu alebo simulácie a to vyplnením a odoslaním formulára cez webové rozhranie alebo vzdialene, odoslaním požiadavky z aplikácie užívateľa.</p>

    <p>Táto užívateľská príručka vysvetľuje základy práce s aplikáciou, popisuje komunikáciu prostredníctvom JSON-RPC aj XML-RPC a uvádza zdrojové kódy pre vzdialený prístup k aplikácii implementované v programovacom jazyku PHP.</p>

    Dokumentácia k simulačnému prostrediu OpenModelica sa nachádza na jej oficiálnych stránkach:
    <a target="_target" href="https://www.openmodelica.org/images/docs/OpenModelicaUserGuide.htm">https://www.openmodelica.org/images/docs/OpenModelicaUserGuide.htm</a>

    <h2>1 JSON-RPC</h2>
    <p>Príklad pre výpočet matematického výrazu a vykonanie simulácie spolu s príkladmi JSON-RPC požiadaviek a odpovedí.</p>
    <h3>1.1 Výpočet výrazu</h3>
    <p>Príklad JSON-RPC požiadavky a odpovede pre výpočet matematického výrazu 1+1. Výsledkom je hodnota členu result v JSON-RPC odpovedi.</p>
    <strong>request</strong>
    <pre class="brush: js">
{
	"jsonrpc": "2.0",
	"method": "comp",
	"params": {
		"expression": "1+1",
  		"api_key": "..." /* vas API kluc */
 	},
 	"id": "bd4250c1c3ea7cb241c58e5437feb0f26ae6122e"
}
    </pre>
    <strong>response</strong>
<pre class="brush: js">
{
 	"result": "2",
 	"id": "bd4250c1c3ea7cb241c58e5437feb0f26ae6122e",
 	"jsonrpc": "2.0"
}
</pre>
<h3>1.2 Simulácia</h3>
    <p>Príklad JSON-RPC požiadavky a odpovede pre simuláciu skúšobného modelu BouncingBall. Výsledkom je hodnota členu result v JSON-RPC odpovedi, teda cesta k súboru s hodnotami potrebnými na vykreslenie grafu.</p>
    <strong>request</strong>
    <pre class="brush: js">
{
	"jsonrpc": "2.0",
 	"method": "sim",
 	"params": {
  		"filename": "BouncingBall_1400425342.mo",
  		"startTime": 0,
  		"stopTime": 3,
  		"method": "dassl",
  		"outputFormat": "csv",
		"outputVariables": [],
  		"api_key": "..." /* vas API kluc */
 	},
 	"id": "46f88b3a9c107df6d55a78a2680cb246889e8099"
}
    </pre>
    <strong>response</strong>
    <pre class="brush: js">
{
    "result": "/var/www/json-rpc/BouncingBall_res.csv",
    "id": "46f88b3a9c107df6d55a78a2680cb246889e8099",
    "jsonrpc": "2.0"
}
    </pre>

    <h2>2 XML-RPC</h2>
    <p>Príklad pre výpočet matematického výrazu a vykonanie simulácie spolu s príkladmi XML-RPC požiadaviek a odpovedí.</p>
    <h3>2.1 Výpočet výrazu</h3>
    <p>Príklad XML-RPC požiadavky a odpovede pre výpočet matematického výrazu 1+1.</p>
    <strong>request</strong>
    <pre class="brush: xml">

<?xml version="1.0" encoding="iso-8859-1"?>
        <methodCall>
<methodName>comp</methodName>
<params>
 <param>
  <value>
   <struct>
	<member>
	 <name>expression</name>
	 <value>
	  <string>1+1</string>
	 </value>
	</member>
	<member>
	 <name>api_key</name>
	 <value>
	  <string>...</string>
	 </value>
	</member>
   </struct>
  </value>
    </param>
</params>
</methodCall>
    </pre>

    <strong>response</strong>
    <pre class="brush: xml">
<?xml version="1.0" encoding="iso-8859-1"?>
<methodResponse>
<params>
 <param>
  <value>
   <string>2</string>
  </value>
    </param>
</params>
</methodResponse>

    </pre>
    <h2>2.2 Simulácia</h2>
    <p>Príklad XML-RPC požiadavky a odpovede pre simuláciu skúšobného modelu BouncingBall. Výsledkom je cesta k súboru s hodnotami potrebnými na vykreslenie grafu.
    </p>
    <strong>request</strong>
    <pre class="brush: xml">
<?xml version="1.0" encoding="iso-8859-1"?>
        <methodCall>
<methodName>sim</methodName>
<params>
 <param>
  <value>
   <struct>
    <member>
     <name>filename</name>
     <value>
      <string>BouncingBall_1400425342.mo</string>
     </value>
    </member>
    <member>
     <name>startTime</name>
     <value>
      <int>0</int>
     </value>
    </member>
    <member>
     <name>stopTime</name>
     <value>
      <int>3</int>
     </value>
    </member>
    <member>
     <name>method</name>
     <value>
      <string>dassl</string>
     </value>
    </member>
    <member>
     <name>outputFormat</name>
     <value>
      <string>csv</string>
     </value>
    </member>
    <member>
     <name>api_key</name>
     <value>
      <string>...</string>
     </value>
    </member>
   </struct>
  </value>
    </param>
</params>
</methodCall>
    </pre>

    <strong>response</strong>
    <pre class="brush: xml">
<?xml version="1.0" encoding="iso-8859-1"?>
<methodResponse>
<params>
 <param>
  <value>
   <string>/var/www/xml-rpc/BouncingBall_res.csv</string>
  </value>
    </param>
</params>
</methodResponse>
    </pre>
    <h2>3 Vzdialený prístup</h2>
<p>Nasledujúce zdrojové kódy ukazujú ako využívať vytvorené služby vzdialene - z vlastnej aplikácie. Využíva sa knižnica cURL, ktorú je potrebné pred používaním povoliť v konfigurácii PHP.</p>
<h3>3.1 Výpočet pomocou JSON-RPC</h3>
    <pre class="brush: php">
&lt;?php
	// url
	$url = "http://147.175.125.30:8008/json-rpc/server.php";

	// request array
	$request = array(
		"jsonrpc" => "2.0",
		"method" => "ext_comp",
		"params" => array(
			"expression" => "1+1",
			"api_key" => "..." /* vas API kluc */
		),
		"id" => 1
	);
	// send request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, array("jsonrpc" => json_encode($request)));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = curl_exec($ch);
	curl_close($ch);

	// decode response and print result
	$response = json_decode($response);
	echo "Expression: " . $request['params']['expression'] . "<br />";
	echo "Result: " . $response->result;
?&gt;
</pre>
<h3>3.2 Simulácia pomocou JSON-RPC</h3>
    <p>Člen outputFormat môže nadobúdať hodnoty: csv, mat, plt a array. V prípade, že hodnotu nastavíme na array sa ako výsledok vráti pole/polia s hodnotami, ak zvolime csv, mat alebo plt, súbor s výsledkami sa automaticky stiahne.</p>
    <p>Člen outputVariables môže obsahovať aj viacero dvojíc premenných. Ak by sme chceli sledovať aj závislosť rýchlosti od času, vyzeral by tento člen takto: "outputVariables": [[time, h], [time, v]]. Služba v takomto prípade vráti 2 polia s hodnotami.</p>

<pre class="brush: php">
    &lt;?php
	// url
	$url = 'http://147.175.125.30:8008/json-rpc/server.php';

	$modelName = "BouncingBall.mo";
	$file_name_with_full_path = realpath('/home/ubuntu/OPENMODELICA_1_8_1/Examples/' . $modelName);

	// request in JSON format
	$request = '{
		"jsonrpc": "2.0",
		"method": "ext_sim",
		"params": {
			"filename": "' . $modelName . '",
			"startTime": 0,
			"stopTime": 2,
			"method": "dassl",
			"outputFormat": "csv",
			"outputVariables": [["time", "h"]],
			"api_key": "..." /* vas API kluc */
		},
		"id": 1
	    }';

	// send request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, array("jsonrpc" => $request, "filename" => "@".$file_name_with_full_path));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	$response = curl_exec($ch);
	curl_close ($ch);

	// decode response
	$response = json_decode($response);

	// check errors
	if(isset($response->result->error)) {
		die($response->result->error);
	}
	else {
		if(json_decode($request)->params->outputFormat == "array") {
			print_r($response->result);
		}
		// download result file
		else {
			header("Content-Type: application/octet-stream");
			header("Content-Transfer-Encoding: Binary");
			header("Content-disposition: attachment; filename=\"" . basename($response->result) . "\"");
			readfile($response->result);
		}
	}
	?&gt;
</pre>
<p>Dôležité je, aby bol request zakódovaný do požadovaného formátu, v tomto prípade do formátu JSON. Na to slúži funkcia json_encode(), ktorá je súčasťou jadra PHP od jeho verzie 5.2. XML-RPC requesty zakódujeme pomocou funkcie xmlrpc_encode_request(), ktorá je dostupná v balíčku XML-RPC (ten je ale potrebné doinštalovať, pretože štadardne nieje povolený).</p>
<h3>3.3 Výpočet pomocou XML-RPC</h3>
<pre class="brush: php">
    &lt;?php
    // url
$url = 'http://147.175.125.30:8005/xml-rpc/server.php';

// request array
$request = array(
		"expression" => "1+1",
		"api_key" => "..." /* vas API kluc */
		  );

// send request
$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, xmlrpc_encode_request("comp", $request));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

// decode response and print result
$response = xmlrpc_decode($response);
echo "Expression: " . $request['expression'] . "<br />";
echo "Result: " . $response;
    ?&gt;
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