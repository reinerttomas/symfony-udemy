PHP := symfony-udemy-php
DATABASE := symfony-udemy-database

### DOCKER ###
build:
	@docker-compose build

up:
	@docker-compose up -d

down:
	@docker-compose down

clean:
	@docker system prune --all --force

php:
	@docker exec -it $(PHP) sh

db:
	@docker exec -it $(DATABASE) sh

### DOCTRINE ###
migration-list:
	@docker exec -it $(PHP) bin/console d:m:list

migration-diff:
	@docker exec -it $(PHP) bin/console d:m:diff

migration-mig:
	@docker exec -it $(PHP) bin/console d:m:m

### COMPOSER ###
composer:
	@docker exec -e APP_ENV=test -it $(PHP) composer install