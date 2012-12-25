#!/bin/bash

echo 'NAIVE PYTHON'
{ time cat stress/output.txt | python naive_caesar.py 5 > /dev/null; } 2>&1
echo 'NAIVE PHP'
{ time cat stress/output.txt | php naive_caesar.php 5 > /dev/null; } 2>&1

