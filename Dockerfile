FROM node:latest AS node
FROM php:8-apache

RUN apt update -y && apt install -y git zip neovim

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

ENV UID=1000
RUN mkdir -p /home/appuser && groupadd -g ${GID:-1000} appuser && \
    useradd -r -u ${UID:-1000} -g appuser appuser && \
    usermod -aG www-data appuser && \
    chown -R appuser:appuser /home/appuser

WORKDIR /var/www/html
RUN chown www-data.www-data -R /var/www/html && a2enmod rewrite

RUN docker-php-ext-install mysqli pdo pdo_mysql 
RUN pecl install xdebug && docker-php-ext-enable xdebug

USER appuser
