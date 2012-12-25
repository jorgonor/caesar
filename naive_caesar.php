<?php

function error_die($message) {
    $STDERR = fopen('php://stderr', 'w');
    fwrite($STDERR, $message);
    fwrite($STDERR, PHP_EOL);
    fclose($STDERR);
    die();
}


if (count($argv) < 2) {
    error_die('Usage: ./caesar.php N');
}

$N = $argv[1];

if (!is_numeric($N)) {
    error_die("$N should be numeric");
}

define('CHUNK_SIZE', 1024);

$N = intval($N);

$low_bounds = array('a', 'z');
$up_bounds = array('A', 'Z');
$diff = ord('Z') - ord('A') + 1;
$ord_low_bounds = array(ord('a'), ord('z'));
$ord_up_bounds = array(ord('A'), ord('Z'));

$fp = fopen('php://stdin', 'r');

while ( $input = fread($fp, CHUNK_SIZE) ) {
    $i = 0;
    while (isset($input[$i])) {
        $c = $input[$i];
        if ($c >= $low_bounds[0] && $c <= $low_bounds[1])
        {
            $c = ord($input[$i]) + $N;
            if ($c > $ord_low_bounds[1]) {
                $c -= $diff;
            }
            if ($c < $ord_low_bounds[0]) {
                $c += $diff;
            }
            $c = chr($c);
        }

        if ($c >= $up_bounds[0] && $c <= $up_bounds[1]) {
            $c = ord($input[$i]) + $N;
            if ($c > $ord_up_bounds[1]) {
                $c -= $diff;
            }
            if ($c < $ord_up_bounds[0]) {
                $c += $diff;
            }

            $c = chr($c);
        }
        $i++;
        echo $c;
    }
}

fclose($fp);
