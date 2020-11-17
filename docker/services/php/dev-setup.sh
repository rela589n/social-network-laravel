#!/bin/bash

cd /var/www/

composer install
php artisan key:generate
php artisan storage:link
echo "* * * * * cd /var/www/ && php artisan schedule:run >> /dev/null 2>&1" >> /etc/crontab
php artisan migrate:fresh
php artisan db:seed

exec "$@"
