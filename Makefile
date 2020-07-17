test:
	php artisan test
setup:
	composer install
	cp -n .env.example .env || true
	php artisan key:generate
	touch database/database.sqlite
	php artisan migrate
seed:
	php artisan db:seed
