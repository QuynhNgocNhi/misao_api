# Interval waiting time of dependent container
INTERVAL := 10

.PHONY: all
all: install up

.PHONY: test
test: phpunit

.PHONY: coverage
coverage: phpunit-coverage

.PHONY: install
install:
	@docker-compose --version
	@docker --version
	@make prepare
	@docker-compose run --rm php sh -c "sleep $(INTERVAL) && composer install && php artisan key:generate"

.PHONY: db-setup
db-setup:
	@docker-compose --version
	docker-compose exec php php artisan migrate:reset
	docker-compose exec php php artisan migrate
	docker-compose exec php php artisan db:seed

.PHONY: db-clean
db-clean:
	@docker-compose --version
	docker-compose exec php php artisan migrate:fresh --seed

.PHONY: up
up:
	@docker-compose --version
	@docker-compose up -d

.PHONY: restart
restart:
	@docker-compose --version
	@docker-compose down
	@docker-compose up -d

.PHONY: daemon
daemon:
	@docker-compose --version
	@make prepare
	@docker-compose up -d
	@sleep $(INTERVAL)
	@make db-setup

.PHONY: build
build:
	@docker-compose --version
	-mkdir -p build
	-mkdir -p xhprof-data
	-mkdir -p storage
	-cp -n .env.local .env
	@docker-compose build

.PHONY: down
down:
	@docker-compose --version
	@docker-compose down

.PHONY: clean
clean:
	@docker-compose --version
	@docker-compose down --rmi all
	@docker container prune -f
	@docker network prune -f
	@docker image prune -f
	@docker volume prune -f
	rm -rf build
	rm -rf xhprof-data

.PHONY: cache
cache:
	@docker-compose --version
	@docker-compose exec php composer dump-autoload
	@docker-compose exec php php artisan cache:clear
	@docker-compose exec php php artisan config:clear
	@docker-compose exec php php artisan route:clear
	@docker-compose exec php php artisan view:clear

.PHONY: php-xdebug-on
php-xdebug-on:
	@docker-compose --version
	@docker-compose exec --user=root php docker-php-ext-enable xdebug

.PHONY: php-xdebug-off
php-xdebug-off:
	@docker-compose --version
	@docker-compose exec --user=root php docker-php-ext-disable xdebug

.PHONY: test
phpunit:
	@docker-compose --version
	@docker-compose exec php php artisan test

.PHONY: tinker
tinker:
	@docker-compose --version
	@docker-compose exec php php artisan tinker

.PHONY: php
php:
	@docker-compose --version
	@docker-compose exec php bash

.PHONY: rm-log
rm-log:
	@docker-compose --version
	@docker-compose exec php rm ./storage/logs/laravel.log

