#!/bin/bash

times=3

echo 'NAIVE PYTHON'
for i in $(seq 1 $times)
do
    echo $i"th time"
    { time cat stress/output.txt | python naive_caesar.py 5 > /dev/null; } 2>&1
done

echo 'NAIVE PHP'
for i in $(seq 1 $times)
do
    echo $i"th time"
    { time cat stress/output.txt | php naive_caesar.php 5 > /dev/null; } 2>&1
done
