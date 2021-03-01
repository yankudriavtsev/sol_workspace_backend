init: clear docker-pull docker-build start
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
	docker-compose run --rm sol_workspace_php_cli /bin/ash

migrate:
	CURRENT_UID=${CURRENT_UID}:${CURRENT_UID} docker-compose run -w "/var/www/html" --rm sol_workspace_php_cli php artisan migrate