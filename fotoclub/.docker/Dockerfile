FROM composer:1.7 AS composer

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
FROM php:7.2-apache
LABEL maintainer="watcher46@gmail.com"

RUN apt-get update -y && \
    apt-get install -y unzip libzip-dev libxslt-dev libpq-dev git && \
    docker-php-ext-configure zip --with-libzip && \
    docker-php-ext-install pdo xsl pdo_mysql mysqli pdo_pgsql zip opcache && \
    docker-php-ext-enable opcache

# Set permissions correctly on the www-data user
ARG USER_ID=502
RUN userdel www-data && groupadd www-data
RUN useradd -g www-data -u ${USER_ID} -l www-data

RUN mkdir -p /var/www/html && chown -R www-data:www-data /var/www/html

# Copy SSL certificates from intermediate OpenSSL container
COPY --from=openssl /export/ /var/www/certs/

#copy vhost to container
COPY ./.docker/apache/vhosts.conf /etc/apache2/sites-enabled/000-default.conf
RUN a2enmod ssl rewrite

USER www-data
WORKDIR /var/www/html

USER root
