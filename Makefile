up:
	docker-compose up -d
build:
	docker-compose build --no-cache
up-build:
	docker-compose up -d --build
migrate:
	docker exec -it php php artisan migrate
migrate-refresh:
	docker exec -it php php artisan migrate:refresh
cache-clear:
	docker exec -it  php artisan cache:clear
config-clear:
	docker exec -it  php artisan cache:clear
test-unit:
	docker exec -it php php artisan test
test-unit:
	docker exec -it php php artisan test tests/Unit
test-feature:
	docker exec -it php php artisan test tests/Feature
test-feature-user:
	docker exec -it php php artisan test tests/Feature/Services/User
