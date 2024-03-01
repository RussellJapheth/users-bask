#!/usr/bin/env bash

docker compose up -d

docker exec bubble-gum bash -c "php spark migrate"

sudo chmod 777 ./basket/writable -R # Needed on some systems to fix permission errors [NB: don't use 777 on an actual application 🫡]

sleep 60 # Wait for rabbitmq to start up

docker exec bubble-gum bash -c "nohup php spark notifications:listen &"
