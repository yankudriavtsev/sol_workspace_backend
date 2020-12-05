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

phpcli:
	CURRENT_UID=${CURRENT_UID}:${CURRENT_UID} docker-compose run --rm -w "/var/www/html" sol_workspace_php_cli /bin/ash




install:
	docker-compose run -w "/var/www/html/idbm" --rm intelli_php72_cli composer install
	docker-compose run -w "/var/www/html/corp" --rm intelli_php72_cli composer install
	docker-compose run -w "/var/www/html/lms" --rm intelli_php72_cli composer install
	docker-compose run -w "/var/www/html/app" --rm intelli_php72_cli composer install
	docker-compose run -w "/var/www/html/corp" --rm intelli_php72_cli php artisan key:generate
	docker-compose run -w "/var/www/html/lms" --rm intelli_php72_cli php artisan key:generate
	docker-compose run -w "/code/lms" --rm intelli_node npm install
	docker-compose run -w "/code/lms" --rm intelli_node npm run dev

migrate:
	CURRENT_UID=$(id -u):$(id -g) docker-compose run -w "/var/www/html/idbm" --rm intelli_php72_cli vendor/bin/phinx migrate -e us
	CURRENT_UID=$(id -u):$(id -g) docker-compose run -w "/var/www/html/idbm" --rm intelli_php72_cli vendor/bin/phinx migrate -e eu
	CURRENT_UID=$(id -u):$(id -g) docker-compose run -w "/var/www/html/idbm" --rm intelli_php72_cli vendor/bin/phinx migrate -e au
	CURRENT_UID=$(id -u):$(id -g) docker-compose run -w "/var/www/html/idbm" --rm intelli_php72_cli vendor/bin/phinx migrate -e ca
	CURRENT_UID=$(id -u):$(id -g) docker-compose run -w "/var/www/html/idbm" --rm intelli_php72_cli vendor/bin/phinx migrate -c phinx_general.yml

rollback:
	CURRENT_UID=$(id -u):$(id -g) docker-compose run -w "/var/www/html/idbm" --rm intelli_php72_cli vendor/bin/phinx rollback -e us
	CURRENT_UID=$(id -u):$(id -g) docker-compose run -w "/var/www/html/idbm" --rm intelli_php72_cli vendor/bin/phinx rollback -e eu
	CURRENT_UID=$(id -u):$(id -g) docker-compose run -w "/var/www/html/idbm" --rm intelli_php72_cli vendor/bin/phinx rollback -e au
	CURRENT_UID=$(id -u):$(id -g) docker-compose run -w "/var/www/html/idbm" --rm intelli_php72_cli vendor/bin/phinx rollback -e ca
	CURRENT_UID=$(id -u):$(id -g) docker-compose run -w "/var/www/html/idbm" --rm intelli_php72_cli vendor/bin/phinx rollback -c phinx_general.yml
