FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

USER root

# Install system dependencies and PHP extensions
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS oniguruma-dev sqlite-dev linux-headers \
    && apk add --no-cache git shadow \
    && pecl install pcov apcu \
    && docker-php-ext-enable pcov apcu \
    && docker-php-ext-install exif pdo pdo_sqlite opcache \
    && apk del -f .build-deps

# Set up user permissions
ARG PUID=1000
ENV PUID=${PUID}
ARG PGID=1000
ENV PGID=${PGID}

RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

# Set up working directory permissions
RUN mkdir -p /var/www/html && \
    chown -R www-data:www-data /var/www/html

# Switch to non-root user
USER www-data

# Health check
HEALTHCHECK --interval=30s --timeout=3s \
    CMD php -v || exit 1
