#!/bin/sh

/usr/bin/supervisord -c /etc/supervisor/conf.d/laravel-worker.conf &

# update application cache
php artisan optimize

# start the application

php-fpm -D &&  nginx -g "daemon off;"

