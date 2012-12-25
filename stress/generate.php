<?php

$A = 65;
$Z = $A + 25;

$fp = fopen('output.txt', 'w');

for($i = 0; $i < 10000; $i++) {
    $arr = [];
    for($k = 0; $k < 1000; $k++) {
        $arr[] = chr(rand($A, $Z));
    }
    fwrite($fp, implode('', $arr));
    fwrite($fp, "\n");
}

fclose($fp);
