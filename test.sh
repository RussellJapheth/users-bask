#!/usr/bin/env bash

./start.sh

docker exec bubble-gum bash -c "vendor/bin/phpunit"
