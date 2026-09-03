# Build the Vite assets separately so the runtime image only contains PHP.
FROM node:22-bookworm-slim AS assets

WORKDIR /var/www

COPY package.json ./
RUN npm install

COPY resources ./resources
COPY public ./public
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build

FROM php:8.2-fpm-bookworm

RUN apt-get update && apt-get install -y --no-install-recommends \
        nginx \
        git \
        unzip \
        libpq-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libonig-dev \
        libxml2-dev \
        libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        exif \
        gd \
        mbstring \
        pcntl \
        pdo_pgsql \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist --no-scripts

COPY . .
COPY --from=assets /var/www/public/build ./public/build

RUN composer dump-autoload --no-dev --optimize

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views \
    && chown -R www-data:www-data storage bootstrap/cache

COPY .docker/nginx.conf /etc/nginx/sites-available/default

EXPOSE 80

CMD ["sh", "-c", "php artisan migrate --force && php artisan db:seed --force && sed -i \"s/listen 80;/listen ${PORT:-80};/\" /etc/nginx/sites-available/default && php-fpm -D && exec nginx -g 'daemon off;'"]