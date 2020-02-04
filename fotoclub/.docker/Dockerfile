FROM composer:latest AS composer

#generate certificates
FROM frapsoft/openssl:latest as openssl
RUN mkdir -p /export; \
    openssl req \
        -x509 \
        -nodes \
        -days 365 \
        -newkey rsa:2048 \
        -subj "/C=NL/ST=Noord-Holland/L=Amsterdam/O=XS4ALL/CN=www.fotoclubuitgeest.test" \
        -keyout /export/server.key -out /export/server.crt

#install php & extensions
FROM php:7.4-apache
LABEL maintainer="watcher46@gmail.com"

RUN apt-get update -y && \
    apt-get install -y unzip libzip-dev libxslt-dev libpq-dev git libpng-dev libjpeg62-turbo-dev libicu-dev  && \
    docker-php-ext-configure zip && \
    docker-php-ext-install pdo xsl pdo_mysql mysqli pdo_pgsql zip opcache intl && \
    docker-php-ext-configure gd && \
    docker-php-ext-install gd && \
    docker-php-ext-enable opcache

# Set permissions correctly on the www-data user
RUN mkdir -p /var/www/html && chown -R www-data:www-data /var/www/html

# Copy SSL certificates from intermediate OpenSSL container
COPY --from=openssl /export/ /var/www/certs/

#copy vhost to container
COPY ./.docker/apache/vhosts.conf /etc/apache2/sites-enabled/000-default.conf
RUN a2enmod ssl rewrite

USER www-data
WORKDIR /var/www/html

USER root
