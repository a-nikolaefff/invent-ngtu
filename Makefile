.PHONY: help

CONTAINER_PHP=php

COMMANDS_WITH_ARGUMENTS := debug migration

ifneq (,$(filter $(firstword $(MAKECMDGOALS)),$(COMMANDS_WITH_ARGUMENTS)))
  RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
endif

help: ## Print help
	@awk 'BEGIN {FS = ":.*##"; printf "\nCommands:\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-10s\033[0m %s\n", $$1, $$2 }' $(MAKEFILE_LIST)

#------------------------------------------------- Docker commands ----------------------------------------------------#

build: ## Build all containers
	docker compose build

up: ## Start all containers
	docker compose up -d

down: ## Stop all containers
	docker compose down

php: ## Enter PHP container
	docker compose exec ${CONTAINER_PHP} /bin/bash

#---------------------------------------------------- NPM commands ----------------------------------------------------#

watch: ## Watch assets
	npm run dev

prod: ## Build assets
	npm run build

#--------------------------------------------------- Common commands --------------------------------------------------#

clear: ## Clear application cache, configuration cache file and cached bootstrap files
	docker compose exec ${CONTAINER_PHP} "php artisan cache:clear && php artisan config:clear && php artisan optimize:clear"

debug: ## Debug artisan command, for example: make debug app:test-command
	docker compose exec ${CONTAINER_PHP} php -dxdebug.mode=debug -dxdebug.start_with_request=yes -dxdebug.client_port=9000 -dxdebug.client_host=host.docker.internal artisan $(RUN_ARGS)

tinker: ## Run artisan tinker
	docker compose exec ${CONTAINER_PHP} php artisan tinker

#-------------------------------------------------- Database commands -------------------------------------------------#

migration: ## Create new migration with given name
	docker compose exec ${CONTAINER_PHP} php artisan make:migration $(RUN_ARGS)

migrate: ## Run last database migration files
	docker compose exec ${CONTAINER_PHP} php artisan migrate

rollback: ## Rollback last database migration files
	docker compose exec ${CONTAINER_PHP} php artisan migrate:rollback

fresh: ## Drop all tables and re-run all migrations
	docker compose exec ${CONTAINER_PHP} php artisan migrate:fresh --seed

#------------------------------------------------- Commands for tests --------------------------------------------------#

pint: ## Run Laravel Pint
	docker compose exec ${CONTAINER_PHP} /bin/bash -c ./vendor/bin/pint  --config pint.json

pint-test: ## Run Laravel Pint in test mode
	docker compose exec ${CONTAINER_PHP} /bin/bash -c ./vendor/bin/pint --test --config pint.json

test: ## Run unit and feature tests
	docker compose exec ${CONTAINER_PHP} php artisan test

unit: ## Run unit tests
	docker compose exec ${CONTAINER_PHP} php artisan test --testsuite=Unit

feat: ## Run feature tests
	docker compose exec ${CONTAINER_PHP} php artisan test --testsuite=Feature

dusk: ## Run browser tests
	docker compose exec ${CONTAINER_PHP} php artisan dusk


