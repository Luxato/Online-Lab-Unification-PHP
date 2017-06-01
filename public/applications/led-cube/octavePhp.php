<?php

$file = 'frames/'.$_GET['file'].'/octave.m';
$model = $_GET['model'];
if($model=='3D'){
$matlabFnc = 'matlabFncs.m';
}else{
    $matlabFnc = 'matlabFncs2D.m';
}
$script = $_GET['scriptText'];
$fncs = file_get_contents($matlabFnc);
file_put_contents($file, $fncs.$script);
$cmd = "octave -p --eval ".$file ;
$output = shell_exec($cmd);
echo $output;



