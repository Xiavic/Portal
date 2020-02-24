#!make
include .env
export $(shell sed 's/=.*//' .env)

apache_container=apache

status:
	docker ps

up:
	docker-compose up -d

down:
	docker-compose down

restart: down up

jumpin: up
	docker-compose exec ${apache_container} bash

tail-logs:
	docker-compose logs -f ${apache_container}

clean:
	docker system prune

clean-all:
	docker system prune -a

%:
	@: