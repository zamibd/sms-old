# Use the official lightweight PHP 8.3 FPM Alpine base image
FROM php:8.3-fpm-alpine

# Define build tools required for compiling PHP extensions
ENV PHPIZE_DEPS="autoconf gcc g++ make pkgconfig"

# Set the working directory inside the container
WORKDIR /var/www/html

# Install system dependencies, configure timezone, install Redis and PHP extensions
RUN set -ex \
    && apk add --no-cache \
        git bash tzdata \
        libzip-dev libxml2-dev \
        curl curl-dev libcurl \
        mariadb-connector-c-dev \
        mariadb-client \           
        redis \                    
        $PHPIZE_DEPS \
    # Configure container timezone to Asia/Dubai
    && cp /usr/share/zoneinfo/Asia/Dubai /etc/localtime \
    && echo "Asia/Dubai" > /etc/timezone \
    # Install and enable the Redis PHP extension
    && pecl install redis \
    && docker-php-ext-enable redis \
    # Install core PHP extensions
    && docker-php-ext-install \
        pdo pdo_mysql mysqli zip pcntl bcmath curl \
    # Remove build tools and clear cache to reduce image size
    && apk del $PHPIZE_DEPS \
    && rm -rf /var/cache/apk/*

# Copy the Composer binary from the official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# php.ini & PHP-FPM config
COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# Expose PHP-FPM port and define the default startup command
EXPOSE 9000
CMD ["php-fpm"]
