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

echo 'MEM PHP'
for i in $(seq 1 $times)
do
    echo $i"th time"
    { time cat stress/output.txt | php mem_caesar.php 5 > /dev/null; } 2>&1
done

echo 'MEM PYTHON'
for i in $(seq 1 $times)
do
    echo $i"th time"
    { time cat stress/output.txt | python mem_caesar.py 5 > /dev/null; } 2>&1
done

echo 'MEM C'
for i in $(seq 1 $times)
do
    echo $i"th time"
    { time cat stress/output.txt | ./bin/mem_caesar 5 > /dev/null; } 2>&1
done
