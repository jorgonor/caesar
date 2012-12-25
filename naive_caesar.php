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
    foreach(str_split($input) as $c) {
        $ord_c = ord($c);
        if ($ord_c >= $ord_low_bounds[0] && $ord_c <= $ord_low_bounds[1])
        {
            $x = $ord_c + $N;
            if ($x > $ord_low_bounds[1]) {
                $x -= $diff;
            }
            if ($x < $ord_low_bounds[0]) {
                $x += $diff;
            }
            $c = chr($x);
        }

        if ($ord_c >= $ord_up_bounds[0] && $ord_c <= $ord_up_bounds[1]) {
            $x = $ord_c + $N;
            if ($x > $ord_up_bounds[1]) {
                $x -= $diff;
            }
            if ($x < $ord_up_bounds[0]) {
                $x += $diff;
            }

            $c = chr($x);
        }
        echo $c;
    }
}

fclose($fp);
