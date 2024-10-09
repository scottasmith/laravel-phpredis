FROM public.ecr.aws/docker/library/php:8.3.7-fpm-bookworm AS api

# (CHANGE VERSION TO 6.0.2 TO TEST)
RUN pecl install -o -f redis-6.1.0 \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

RUN mkdir -p /var/www/app

WORKDIR /var/www/app

ENTRYPOINT ["php", "-S", "0.0.0.0:80", "-t", "public"]
