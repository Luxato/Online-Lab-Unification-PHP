<?php
header ("Cache-Control: no-cache");

function readStaticModel($fName){
  return file_get_contents("./models/".$fName);
}

function replaceTags($fContent, $data){
  foreach($data as $key => $value){
    $fContent = str_replace('#'.$key.'#', $value, $fContent);
  }
  return $fContent;
}

function rewriteDynamicModel($fContent){
  $file = fopen("./models/Segway.mo", "w");
  fwrite($file, $fContent);
  fclose($file);
}

function checkInputs(){
  if(!(isset($_POST['time']) && is_numeric($_POST['time']) && $_POST['time'] >= 0 && $_POST['time'] <= 50)){
    return false;
  }
  else if(!(isset($_POST['degree']) && is_numeric($_POST['degree']) && $_POST['degree'] >= 0 && $_POST['degree'] <= 70)){
    return false;
  }
  else if(!(isset($_POST['speed']) && is_numeric($_POST['speed']) && $_POST['speed'] >= -10 && $_POST['speed'] <= 10)){
    return false;
  }



  else return true;
}


if(!checkInputs()){
  echo false;
}
else{
  $newFileContent = replaceTags(readStaticModel($_POST["pid"]),$_POST);
  rewriteDynamicModel($newFileContent);
  $time = $_POST['time'];
  $noi = 1500;

  $url = 'http://147.175.105.140:8008/json-rpc/server.php';
  $modelName ='Segway.mo';
  $file_name_with_full_path = realpath(dirname(__FILE__)) .'/models/'. $modelName;
  $request = '{
              "jsonrpc": "2.0", 
              "method": "ext_sim", 
              "params": {
                "filename": "' . $modelName . '",
                "startTime": 0,
                "stopTime": 50,
                "numberOfIntervals": '.$noi.',
                "method": "dassl",
                "outputFormat": "array",     
                "outputVariables": [["time", "x"], ["time","phi"]],
                "api_key": "87d6f50b9e43b1c2a5ce15098c68eb0x"
              },
              "id": 1
            }';
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST,1);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, array("jsonrpc" => $request, "filename" => "@".$file_name_with_full_path));
  curl_setopt($ch, CURLOPT_POSTFIELDS, array("jsonrpc" => $request, "filename" => new CurlFile($file_name_with_full_path)));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  $response = curl_exec($ch);
  curl_close ($ch);
  echo $response;
}
?>