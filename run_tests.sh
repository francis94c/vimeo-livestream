#!/bin/bash

cd ./tests/server 

LIB_ENV=testing php -S 127.0.0.1:3067 -c php.ini > /dev/null 2>&1 &

cd ../..

vendor/bin/phpunit

killall -9 php