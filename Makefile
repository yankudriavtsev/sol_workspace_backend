phpcli:
	docker-compose run --rm sol_workspace_php_cli /bin/ash

migrate:
	CURRENT_UID=${CURRENT_UID}:${CURRENT_UID} docker-compose run -w "/var/www/html" --rm sol_workspace_php_cli php artisan migrate

