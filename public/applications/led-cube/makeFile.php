<?php

$i = 0;
while (true) {
    if (!is_dir("frames/" . $i)) {
        mkdir("frames/" . $i,0777);
        echo $i;
        break;
    }
    $i++;
}

