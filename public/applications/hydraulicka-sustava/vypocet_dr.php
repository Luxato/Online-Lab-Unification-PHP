<?php
	$path = './models/';

	function replaceStringWithTag($tag, $content, $fileContent){
		$newTag = '#' . $tag . '#';
		$replaced = str_replace($newTag, $content, $fileContent);
		return $replaced;
	}

	function replaceTagInFile($file, $data){
		global $path;
		$fileContent = file_get_contents($path . $file);

		foreach($data as $key => $tag){
			$fileContent = replaceStringWithTag($key, $data[$key], $fileContent);

		}    
        $fileToSave = explode('.', $file);
		$handle = fopen($path . $fileToSave[0] . '.mo', "w");
		fwrite($handle, $fileContent);
		fclose($handle);
	}
	
	$type = 'Hydraulika';
	
	//if (isset($_REQUEST['checked'])&&$_REQUEST['checked']){
	if (isset($_REQUEST['checked'])){
	$type .= 'PID';
	}
	
	if (isset($_REQUEST['riad'])) {
		if ($_REQUEST['riad']=='1'){
		$type .= 'q1';
		}
		else if ($_REQUEST['riad']=='2'){
		$type .= 'q2';
		}
		else if ($_REQUEST['riad']=='3'){
		$type .= 'q3';
		}
	}

	replaceTagInFile($type . '.mo', $_REQUEST);

function data2array($request,$response)
{ $arr=json_decode($request, true);
	$no = count($arr['params']['outputVariables']);
	foreach ($response->result[0] as &$value)
	{ $outputArray[0][] = $value->x;
		$outputArray[1][] = $value->y;
	}
	if ($no > 1)
	{ for ($x=2; $x<=$no; $x++)
	{ foreach ($response->result[$x-1] as &$value)
	{ $outputArray[$x][] = $value->y;
	}
	}
	}
	return $outputArray;
}
	
  	$url = 'http://147.175.105.140:8008/json-rpc/server.php';
	$modelName = $type . '.mo';
	$file_name_with_full_path = realpath(dirname(__FILE__).'./models/' .$modelName);

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
  	curl_setopt($ch, CURLOPT_POSTFIELDS, array("jsonrpc" => $request, "filename" => new CurlFile($file_name_with_full_path)));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  	$response = curl_exec($ch);
  	curl_close ($ch);
  
  	$response = json_decode($response);
    $outputArray=data2array($request,$response);
	$outputArray=json_encode($outputArray);

	echo $outputArray;
                     
    ?>
