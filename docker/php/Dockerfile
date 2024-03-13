FROM php:8.2-fpm-alpine3.17

COPY ./docker/php/php.ini /

# Install required packages
RUN apk update \
    && apk add --no-cache curl build-base zlib-dev oniguruma-dev autoconf git bash icu-data-full icu-dev libzip-dev postgresql-dev tzdata supervisor nodejs npm asciidoctor

# Configure non-root user.
ARG PUID=1000
ARG PGID=1000
RUN apk --no-cache add shadow && \
    groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

# Source code
COPY ./ /var/www
WORKDIR /var/www

RUN apk --no-cache add ca-certificates && update-ca-certificates

# Install required php extensions
RUN docker-php-ext-install opcache \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install pdo pdo_pgsql \
    && docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install zip

# Install Xdebug
RUN apk add --update linux-headers  \
    && apk --update --no-cache add autoconf g++ make  \
    && pecl install -f xdebug\
    && docker-php-ext-enable xdebug \
    && apk del --purge autoconf g++ make


# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
#RUN composer install --no-interaction

# Install Symfony CLI
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash \
    && apk add symfony-cli

CMD php-fpm

EXPOSE 9000