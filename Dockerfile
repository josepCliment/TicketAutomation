FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    nginx \
    supervisor \
    sqlite-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    imagemagick \
    imagemagick-dev \
    shadow \
    nodejs \
    npm \
    $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install gd pdo pdo_pgsql pcntl \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && usermod -u 1000 www-data \
    && groupmod -g 1000 www-data \
    && rm -rf /var/cache/apk/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN npm install && npm run build && rm -rf node_modules

RUN mkdir -p storage/app/tickets \
             storage/framework/cache \
             storage/framework/sessions \
             storage/framework/views \
             storage/logs \
             database \
             /var/log/supervisor \
    && touch database/database.sqlite \
    && chown -R www-data:www-data storage database bootstrap/cache \
    && chmod -R 775 storage database bootstrap/cache

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
