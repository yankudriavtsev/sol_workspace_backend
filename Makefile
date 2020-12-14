CURRENT_UID := $(shell id -u)
CURRENT_GID := $(shell id -g)

export CURRENT_UID
export CURRENT_GID

up:
	CURRENT_UID=${CURRENT_UID}:${CURRENT_UID} docker-compose up -d

up_build:
	CURRENT_UID=${CURRENT_UID}:${CURRENT_UID} docker-compose up -d --build

permissions:
	sudo chown -R ${CURRENT_UID}:${CURRENT_UID} ./database/*
	sudo chmod -R 777 ./src/storage/logs

phpcli:
	CURRENT_UID=${CURRENT_UID}:${CURRENT_UID} docker-compose run --rm -w "/var/www/html" sol_workspace_php_cli /bin/ash


migrate:
	CURRENT_UID=${CURRENT_UID}:${CURRENT_UID} docker-compose run -w "/var/www/html" --rm sol_workspace_php_cli php artisan migrate

