CONTAINER_NAME := symfony-udemy-php

### DOCKER ###
build:
	@docker-compose build

up:
	@docker-compose up -d

down:
	@docker-compose down

clean:
	@docker system prune --all --force

bash:
	@docker exec -it $(CONTAINER_NAME) sh

### COMPOSER ###
composer:
	@docker exec -e APP_ENV=test -it $(CONTAINER_NAME) composer install