#!/bin/bash

tests=$(ls tests)
tests_counter=0

for test in $tests
do
    command=$(cat tests/$test/command)
    actual=$(cat tests/$test/input | $command )
    expected=$(cat tests/$test/output)
    if [ "$expected" != "$actual" ] ; then
        echo "TEST $test FAILED!"
        echo '==============================='
        echo 'EXPECTED'
        echo $expected | cat -A
        echo -n 'chars '
        echo $expected | wc -c
        echo '==============================='
        echo 'ACTUAL'
        echo $actual | cat -A
        echo -n 'chars '
        echo $actual | wc -c
        exit 1
    fi
    tests_counter=$[$tests_counter+1]
done

echo "$tests_counter TESTS passed"
