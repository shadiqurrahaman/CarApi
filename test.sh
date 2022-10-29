#!/bin/sh

	
sudo docker run --rm -v $(pwd):/app composer install

sudo chown -R $USER:$USER ~/.

docker-compose up -d

docker-compose exec app php artisan key:generate

docker-compose exec app php artisan config:cache

docker-compose exec app php artisan migrate:fresh

echo "-----START API TESTING-----\n"
echo "----API: POST /cars-----\n"
curl -X POST http://127.0.0.1:8000/api/cars \
   -H 'Accept: application/json'\
   -H 'Content-Type: application/json'\
   -d '{"make":"Toyota","model":"Axio"}'\
   | json_pp
echo "\n"

echo "----API: GET /cars/{id}----\n"
curl -X GET http://127.0.0.1:8000/api/cars/1\
   -H 'Accept: application/json'\
   -H 'Content-Type: application/json'\
   | json_pp

echo "\n"


echo "----API: POST /cars/{id}/years----\n"
curl -X POST http://127.0.0.1:8000/api/cars/1/years\
   -H 'Accept: application/json'\
   -H 'Content-Type: application/json'\
   -d '{"years":[2023,1925,2000],"expiry":2000}'\
   | json_pp

echo "\n"

echo "----API: GET /cars?years=<year1>,<year2>,<year3>-----\n"

curl -X GET http://127.0.0.1:8000/api/cars?years=2022,2000\
   -H 'Accept: application/json'\
   -H 'Content-Type: application/json'\
   | json_pp

echo "\n---------------------\n"

echo "\n------Thank You------\n"

docker-compose down 