<?php
	
	function replaceStringWithTag($tag, $content, $fileContent){
		$newTag = '#' . $tag . '#';
		$replaced = str_replace($newTag, $content, $fileContent);
		return $replaced;
	}

	function replaceTagInFile($file, $data){
		$fileContent = file_get_contents($file);

		foreach($data as $key => $tag){
			$fileContent = replaceStringWithTag($key, $data[$key], $fileContent);

		}    
        $fileToSave = explode('.', $file);
		$handle = fopen("models/" . $fileToSave[0] . '.mo', "w");
		fwrite($handle, $fileContent);
		fclose($handle);
	}
	
	$type = 'Hydraulika';
	
	//if (isset($_REQUEST['checked'])&&$_REQUEST['checked']){
	if ($_REQUEST['checked']){
	$type .= 'PID';
	}
	
	if ($_REQUEST['riad']=='1'){
	$type .= 'q1';
	}
	else if ($_REQUEST['riad']=='2'){
	$type .= 'q2';
	}
	else if ($_REQUEST['riad']=='3'){
	$type .= 'q3';
	}
		
	replaceTagInFile($type . '.mo', $_REQUEST);
		
    require_once 'func.php';
	
  	$url = 'http://147.175.105.140:8008/json-rpc/server.php';
	$modelName = $type . '.mo';
	$file_name_with_full_path = realpath(dirname(__FILE__).'/models/' .$modelName);
  

	$request = '{
  					"jsonrpc": "2.0", 
  					"method": "ext_sim", 
  					"params": {
  						"filename": "' . $modelName . '",
  						"startTime": 0,
  						"stopTime": '.$_REQUEST['st'].',
						"numberOfIntervals": '.$_REQUEST['nv'].',
  						"method": "dassl",
  						"outputFormat": "array",     
  						"outputVariables": [["time", "h1"], ["time","h2"], ["time","h3"]],
  						"api_key": "87d6f50b9e43b1c2a5ce15098c68eb0x"
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
  
  	$response = json_decode($response);
	
    $outputArray=data2array($request,$response);
	$outputArray=json_encode($outputArray);
	
	//var_dump($outputArray);
	echo $outputArray;
                     
    ?>
