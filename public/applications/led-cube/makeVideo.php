<?php
echo
$path = 'frames/'.$_POST['path'].'/';


$cmd = 'ffmpeg -framerate 8 -i '.$path.'%08d.png '.$path.'output.mp4';
shell_exec($cmd);
if( file_exists ('frames/'.$_POST['path'].'/output.mp4') ){

    echo "true";
}else {
    echo "false";
};
