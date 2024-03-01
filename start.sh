#!/usr/bin/env bash

docker compose up -d

docker exec bubble-gum bash -c "php spark migrate"

sleep 60 # Wait for rabbitmq to start up

docker exec bubble-gum bash -c "nohup php spark notifications:listen &"
