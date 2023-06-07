composer install --no-dev
cp .env.example .env
php artisan key:generate
php artisan storage:link