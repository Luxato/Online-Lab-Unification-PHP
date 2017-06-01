<?php
    session_start();
header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    header('Access-Control-Allow-Origin: *');

    define('API_KEY', 'c0a082896a8c2f946ea7f67d3ae39c41');
    $engine_upload_Url = 'http://147.175.105.140:8011/sciengine/engine/compute';
    
        $request = array(
            "engine" => "scicoslab",
            "data_type" => "simulation",
            "formula_output" => "raw",
            "variable_list" => "",
            "advanced_features" => "yes",
            "simulation_parameters" => "",
            "code" => "",
            "api_key" => API_KEY,
            "graphic_figure" => "",
            "file_name" => new CurlFile(realpath('ssfc.cos'))
        );   
        
        
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $engine_upload_Url);
    curl_setopt($ch, CURLOPT_POST, 1);
   // curl_setopt($ch, CURLOPT_WRITEFUNCTION, 'writeData');
   // curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array('data' => json_encode($request)));
    /*
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
    /
    */
    
    $_SESSION['response'] = $response = json_decode(curl_exec($ch));
    
    curl_close($ch);

    //exit();
    
    
        function sendMsg($id, $msg)
    {
        $data = (object)[
            'end' => $_SESSION['computeEnd'],//fixme: tato session nemusi byt nastavena
            'message' => $msg
        ];

        echo "id: $id" . PHP_EOL;//fixme: je id potrebne, vyskusaj, najdi dokumnetaciu
        echo "data: " . json_encode($data) . "\n";

        echo PHP_EOL;
        ob_flush();
        flush();
    }
             
?>


