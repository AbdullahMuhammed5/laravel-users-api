#!/bin/bash

if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

if [ ! -f ".env" ]; then
    echo "Creating env file for env $APP_ENV"
    cp .env.example .env
else
    echo "env file exists."
fi

# Wait for the database to become available
until php artisan migrate:status &> /dev/null; do
    echo "Waiting for the database..."
    sleep 2
done

php artisan config:clear
php artisan migrate
php artisan optimize
php artisan view:cache

php-fpm -D
nginx -g "daemon off;"
