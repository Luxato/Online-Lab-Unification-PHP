<?php

if (!isset($_GET['ex'])) {
    header('Content-Type: text/html; charset=UTF-8');
    ?>

    Scilab simulácia: <a href="curl.php?ex=1" target="_blank">Scilab</a>
    <br>
    Scilab súbor s fibonacci funkciou: <a href="curl.php?ex=2" target="_blank">Scilab</a>
    <br>
    Scilab výpočet: <a href="curl.php?ex=3" target="_blank">Scilab</a>
    <br>
    Scicoslab simulácia: <a href="curl.php?ex=4" target="_blank">water tank</a>
    <br><br>

    <pre>
        //headre tu môžu, ale nemusia byť

        header('Content-Type: text/plain; charset=UTF-8');
        header('Cache-Control: no-cache');

        $request = array(
            'engine' => 'scilab',
            "data_type" => "simulation",
            "advanced_features"=> "yes",
            "formula_output" => "raw",
            "code" => "",
            "graphic_figure" => [
                "png",
                "svg"
            ],
            "api_key" => API_KEY,            
            "file_name" => new CurlFile(realpath('scilab_demo_watertank.zcos')) //root stránky
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://147.175.105.140:8011/sciengine/engine/compute");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, 'writeData');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);

        function writeData($ch, $str)
        {
            echo $str;
            ob_flush();
            flush();

            return strlen($str);
        }

        if (($response = curl_exec($ch)) == null) {
            echo curl_error($ch);
        }
        curl_close($ch);
        exit();
    </pre>

<?php
}

if (isset($_GET['ex'])) {

//    header('Content-Type: text/event-stream');
    header('Content-Type: text/plain; charset=UTF-8');
    header('Cache-Control: no-cache');

    define('API_KEY', 'c0a082896a8c2f946ea7f67d3ae39c41');
    $engine_upload_Url = 'http://147.175.105.140:8011/sciengine/engine/compute';
//    $engine_upload_Url = 'http://147.175.105.140:8011/sciengine/index.php?action=computev2';

    if ($_GET['ex'] == 1) {
        $request = array(
            'engine' => 'scilab',
            "data_type" => "simulation",
            "advanced_features"=> "yes",
            "formula_output" => "raw",
            "code" => "",
            "api_key" => API_KEY,
            "id" => 138,
            "file_name" => new CurlFile(realpath('scilab_demo_watertank.zcos'))
        );
    }

    if ($_GET['ex'] == 2) {
        $request = array(
            'engine' => 'scilab',
            "data_type" => "filedata",
            "formula_output" => "raw",
            "code" => "",
            "api_key" => API_KEY,
            "id" => 138,
            "file_name" => new CurlFile(realpath('scilab_file_fibonacii.sci'))
        );
    }

    if ($_GET['ex'] == 3) {
        $request = array(
            'engine' => 'scilab',
            "data_type" => "textdata",
            "formula_output" => "raw",
            "code" => "x=620;y=factor(x),",
            "api_key" => API_KEY,
            "id" => 138,
            "file_name" => ""
        );
    }

    if ($_GET['ex'] == 4) {
        $request = array(
            'engine' => 'scicoslab',
            "data_type" => "simulation",
            "formula_output" => "raw",
            "code" => "",
            "api_key" => API_KEY,
            "id" => 138,
            "file_name" => new CurlFile(realpath('scicoslab_demo_watertank.cos'))
        );
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $engine_upload_Url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_WRITEFUNCTION, 'writeData');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);

    function writeData($ch, $str)
    {
        echo $str;
        ob_flush();
        flush();

        return strlen($str);
    }

    if (($response = curl_exec($ch)) == null) {
        echo curl_error($ch);
    }
    curl_close($ch);

    exit();

}





//$engineUrl = 'http://194.160.104.75/sciengine/index.php?action=compute';
//$engine_upload_Url = 'http://147.175.105.140:8011/sciengine/index.php?action=uploadScript';
////$engine_upload_Url = 'http://147.175.105.140:8011/sciengine/index.php?action=computev2';//computev2 //computeTest

/*$request = array(
    'engine' => 'scilab',
    "data_type" => "textdata",//"simulation",
    "formula_output" => "raw",
    "code" => "factorial(170),",
    "api_key" => "c0a082896a8c2f946ea7f67d3ae39c41",
    "id" => 138,
    //"file_name" => "scilab_demo_watertank.zcos"
);*/
/*
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $engine_upload_Url);
curl_setopt($ch, CURLOPT_POST, 1);

// Set a referer
//curl_setopt($ch, CURLOPT_REFERER, "http://localhost/scilabklient/curl.php");
//curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.125 Safari/537.36 OPR/30.0.1835.88");
//curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_WRITEFUNCTION, 'writeData');
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_TIMEOUT, 10);


function writeData($ch, $str)
{
    //global $fd;
    //$len = fwrite($fd,$str);
    echo $str;
    ob_flush();
    flush();

    return strlen($str);
}


//$args['file'] = curl_file_create('img/albumart.jpg', 'image/jpg', 'albumart.jpg');
$request['file_name'] = new CurlFile(realpath('scilab_demo_watertank.zcos'));
curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
if (($response = curl_exec($ch)) == null) {
    echo curl_error($ch);
}
curl_close($ch);

exit();

*/


//echo $response;

//echo json_decode($response);


/*



$request = array(
    'engine' => 'scilab',
    "data_type" => "textdata",
    "formula_output" => "raw",
    "code" => "factorial(170);disp(ans)",
    "api_key" => "c0a082896a8c2f946ea7f67d3ae39c41",
    "id" => 138,
    "filename" => ""
);

// sendRequest
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $engineUrl);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request);//array('data' => 'ahoj'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_HTTPHEADER, Array("application/x-www-form-urlencoded"));
if(($response = curl_exec($ch)) == null){
    echo curl_error($ch);
}
curl_close($ch);

// decode response
//$response = json_decode($response);

var_dump($response);*/