<?php
$path = $_POST['path'];

 $files = glob(''.$path.'/*');

foreach($files as $file){ // iterate files
  if(is_file($file)){
    echo $file."*";
  }
}


