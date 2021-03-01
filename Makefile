init: clear docker-pull docker-build project-build start
restart: stop start

start:
	docker-compose up -d

stop:
	docker-compose down

clear:
	docker-compose down -v

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

phpcli:
	docker-compose run --rm clementine_php_cli /bin/ash

db-migrate:
	docker-compose run --rm clementine_php_cli php artisan migrate

project-build:
	docker-compose run --rm clementine_php_cli composer install