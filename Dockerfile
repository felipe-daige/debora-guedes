FROM php:8.4-fpm-alpine
RUN apk add --no-cache postgresql-client postgresql-dev libzip-dev icu-dev $PHPIZE_DEPS \
    && docker-php-ext-install pdo_pgsql intl zip opcache \
    && apk del postgresql-dev $PHPIZE_DEPS
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist --optimize-autoloader
COPY . .
RUN composer run-script post-autoload-dump && mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache
USER www-data
CMD ["php-fpm"]
