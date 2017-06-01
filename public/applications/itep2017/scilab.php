<?php


//    header('Content-Type: text/event-stream');
    header('Content-Type: text/plain; charset=UTF-8');
    header('Cache-Control: no-cache');
	
$engineUrl = 'http://147.175.105.140:8011/sciengine/engine/compute';
 
$request = array(
    'engine' => 'scilab',
    "data_type" => "simulation",
    "advanced_features"=> "yes",
    "formula_output" => "raw",
    "code" => "",
    "api_key" => "c0a082896a8c2f946ea7f67d3ae39c41",
);
 
// sendRequest
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $engine_upload_Url);
curl_setopt($ch, CURLOPT_POST, 1);
//php < 5.5.0 : $request['file'] = '@/path/to/file';
$request['file'] = new CurlFile(realpath('ssfc.zcos'));
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