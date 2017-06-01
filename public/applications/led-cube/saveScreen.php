<?php
include("config.php");

$path = 'frames/'.$_POST['path'].'/';
if(isset($_POST['data']) && isset($_POST['i']) && is_numeric($_POST['i'])) {
    
    if($_POST['i'] == $NUMBER_OF_PICUTRES || $ADMIN==0){
       echo "stop";
    }else if($_POST['i'] > $NUMBER_OF_PICUTRES){
        
    }
    else{
    $data = explode(',', $_POST['data']);

    $data = base64_decode(trim($data[1]));
 
    $filename = sprintf('%s%08d.png', $path, $_POST['i']);
    file_put_contents($filename, $data);
    chmod($filename,0777);
    
   
    }
}