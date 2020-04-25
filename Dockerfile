FROM php:7.4-fpm

RUN apt-get update -y \
    && apt-get install -y nginx \
    && apt-get install -y libpq-dev \
    && apt-get install -y postgresql-client \
    && docker-php-ext-install pdo pdo_pgsql

COPY nginx/service.conf /etc/nginx/sites-enabled/default
COPY nginx/entrypoint.sh /etc/entrypoint.sh

COPY --chown=www-data:www-data . /var/www/service

WORKDIR /var/www/service

EXPOSE 80 443

ENTRYPOINT ["sh", "/etc/entrypoint.sh"]