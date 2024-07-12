FROM php:8.1-fpm

# setup user as root
USER root

WORKDIR /var/www/app

# Install environment dependencies
# PS. you can deploy an image that stops at this step so that your cI/CD builds are a bit faster (if not cached) this is what takes the most time in the deployment process.
RUN apt-get update \
    # gd
    && apt-get install -y build-essential  openssl nginx libfreetype6-dev libjpeg-dev libpng-dev libwebp-dev zlib1g-dev libzip-dev gcc g++ make vim unzip curl libxrender1 libfontconfig1 libx11-dev libjpeg62 libxtst6 wget git jpegoptim optipng pngquant gifsicle locales libonig-dev nodejs  \
    && docker-php-ext-configure gd  \
    && docker-php-ext-install gd \
    # gmp
    && apt-get install -y --no-install-recommends libgmp-dev \
    && docker-php-ext-install gmp \
    # pdo_mysql
    && docker-php-ext-install pdo_mysql mbstring \
    # pdo
    && docker-php-ext-install pdo \
    # opcache
    && docker-php-ext-enable opcache \
    # exif
    && docker-php-ext-install exif \
    && docker-php-ext-install sockets \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install bcmath \
    # zip
    && docker-php-ext-install zip \
    && apt-get autoclean -y \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /tmp/pear/

# Supervisor Setup
RUN apt-get update && apt-get install -y supervisor

RUN mkdir -p /etc/supervisor/conf.d

COPY ./deploy/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

# Copy files
COPY . /var/www/app

COPY ./deploy/local.ini /usr/local/etc/php/

COPY ./deploy/php.ini /usr/local/etc/php/php.ini

RUN rm /etc/nginx/sites-available/default

COPY ./nginx/nginx.conf /etc/nginx/sites-available/default

# Permissions are hereby granted
#RUN chmod +rwx /var/www/app/

# RUN wget https://github.com/h4cc/wkhtmltopdf-amd64/blob/master/bin/wkhtmltopdf-amd64?raw=true -O /usr/local/bin/wkhtmltopdf

COPY wkhtmltopdf /usr/local/bin

RUN chmod -R 777 /var/www/app/

RUN chmod +x /usr/local/bin/wkhtmltopdf

# setup composer and laravel
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN /usr/local/bin/composer install --working-dir="/var/www/app"

RUN composer dump-autoload --working-dir="/var/www/app"

# Cache Clearing Commands
RUN php artisan storage:link

RUN php artisan optimize:clear

RUN php artisan cache:clear

RUN php artisan route:clear

# RUN php artisan route:cache

RUN php artisan config:clear

RUN php artisan view:clear

RUN php artisan config:cache

# RUN php artisan view:cache

# remove this line if you do not want to run migrations on each build
# RUN php artisan migrate --force

EXPOSE 80

RUN ["chmod", "+x", "post_deploy.sh"]

CMD [ "sh", "./post_deploy.sh" ]
