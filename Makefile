build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down

init:
	docker-compose exec php composer create-project laravel/laravel .

list:
	docker-compose ps

enter:
	docker-compose exec -it $(name) /bin/bash

php:
	docker-compose exec php /bin/bash

npm:
	docker-compose exec npm /bin/bash

vite:
	docker-compose exec npm npm run dev

vite-build:
	docker-compose exec npm npm run build

