.PHONY: up down restart logs shell tinker migrate migrate-fresh queue-restart

COMPOSE=docker compose -f docker-compose.dev.yml
APP=$(COMPOSE) exec --user www-data app

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

restart:
	$(COMPOSE) down && $(COMPOSE) up -d

logs:
	$(COMPOSE) logs -f app

shell:
	$(COMPOSE) exec --user www-data app sh

tinker:
	$(APP) php artisan tinker

migrate:
	$(APP) php artisan migrate

migrate-fresh:
	$(APP) php artisan migrate:fresh

queue-restart:
	$(APP) php artisan queue:restart

cache-clear:
	$(APP) php artisan cache:clear
	$(APP) php artisan config:clear
	$(APP) php artisan route:clear

latest-ticket:
	$(APP) php artisan tinker --execute="dump(\App\Models\Ticket::with('products')->latest()->first()->toArray());"

seed:
	$(APP) php artisan db:seed
