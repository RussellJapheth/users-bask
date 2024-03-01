#!/usr/bin/env bash

cd basket

cp env .env

chmod 777 ./writable -R # Needed on some systems to fix permission errors [NB: don't use 777 on an actual application 🫡]

cd ..

docker compose up -d --build

docker exec bubble-gum bash -c "composer install"

docker exec bubble-gum bash -c "php spark migrate"

sleep 60 # Wait for rabbitmq to start up

docker exec bubble-gum bash -c "nohup php spark notifications:listen &"
