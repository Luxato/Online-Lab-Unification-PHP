<?php
$path = 'frames/'.$_POST['path'].'/';
$deleteVideo=$_POST['deleteVideo'];
if($deleteVideo == 0){
$files = glob(''.$path.'/*.png'); // get all file names
} else {
    $files = glob(''.$path.'/*.mp4');
}
foreach($files as $file){ // iterate files
  if(is_file($file)){
    unlink($file); // delete file
  }
}
