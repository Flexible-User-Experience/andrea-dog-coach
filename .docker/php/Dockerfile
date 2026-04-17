FROM php:8.4.20-fpm-alpine3.23 AS base

WORKDIR /var/www/box-idiomes/

ENV FPM_PM_MAX_CHILDREN="10" \
    PHP_OPCACHE_VALIDATE_TIMESTAMPS="1" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="20000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="256" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10" \
    PHP_REALPATH_CACHE_TTL="120" \
    TZ="Europe/Madrid"

ARG PHPIZE_DEPS

RUN apk update                               && \
    apk add --no-cache --upgrade tini fcgi curl ;

RUN apk add --no-cache --virtual .build-deps    \
    $PHPIZE_DEPS                                \
    bash                                        \
    tzdata                                      \
    icu-dev                                     \
    curl-dev                                    \
    oniguruma-dev                               \
    sqlite-dev                                  \
    libzip-dev                                  \
    libjpeg-turbo-dev                           \
    libpng-dev                                  \
    libwebp-dev                                 \
    libxml2-dev                                 \
    libxslt-dev                                 \
    linux-headers                               ;

RUN docker-php-ext-configure zip                                    && \
    docker-php-ext-configure gd --enable-gd --with-jpeg --with-webp && \
    docker-php-ext-install -j$(nproc)                                  \
    bcmath                                                             \
    curl                                                               \
    xml                                                                \
    mbstring                                                           \
    zip                                                                \
    pdo                                                                \
    pdo_sqlite                                                         \
    intl                                                               \
    xsl                                                                \
    gd                                                                 ;

RUN pecl install          \
        apcu-5.1.28    && \
    pecl clear-cache&&    \
    docker-php-ext-enable \
        apcu              \
        opcache           ;

RUN { \
    EXT_DIR=$(php -r 'echo ini_get("extension_dir");');                                         \
    for ext in apcu bcmath curl xml mbstring zip pdo pdo_sqlite intl gd; do                     \
    test -f "$EXT_DIR/${ext}.so" || { echo "ERROR: ${ext}.so not found in $EXT_DIR"; exit 1; }; \
    done;                                                                                       \
};

COPY --from=composer/composer:2.9-bin /composer /usr/local/bin/composer

RUN deluser --remove-home www-data && \
    adduser -u1000 -D www-data        ;

FROM base AS development

RUN pecl install pcov-1.0.12 && \
    docker-php-ext-enable pcov  ;

RUN pecl install xdebug-3.5.0 && \
    docker-php-ext-enable xdebug ;

RUN mkdir -p /var/www/box-idiomes/var/cache /var/www/box-idiomes/var/log

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY .docker/php/php.ini-development "$PHP_INI_DIR/conf.d/90-custom.ini"
COPY .docker/php/opcache.ini "$PHP_INI_DIR/conf.d/docker-php-ext-opcache.ini"
COPY .docker/php/xdebug-disabled.ini "$PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini"

RUN wget https://github.com/maglnet/ComposerRequireChecker/releases/download/4.19.0/composer-require-checker.phar && \
    chmod +x composer-require-checker.phar                                                                        && \
    mv composer-require-checker.phar /usr/local/bin/composer-require-checker                                         ;

RUN wget https://github.com/composer-unused/composer-unused/releases/download/0.9.5/composer-unused.phar && \
    chmod +x composer-unused.phar                                                                        && \
    mv composer-unused.phar /usr/local/bin/composer-unused                                                  ;

RUN wget https://github.com/overtrue/phplint/releases/download/9.7.1/phplint.phar && \
    chmod +x phplint.phar                                                         && \
    mv phplint.phar /usr/local/bin/phplint                                           ;


FROM base AS prod

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV APP_ENV=prod
ENV PHP_MEMORY_LIMIT="2G"
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0"
ENV FPM_PM_MAX_CHILDREN=80 \
    FPM_PM_START_SERVERS=20 \
    FPM_PM_MIN_SPARE_SERVERS=20 \
    FPM_PM_MAX_SPARE_SERVERS=60 \
    FPM_PM_MAX_REQUESTS=100

RUN rm -r /tmp/pear; \
     # - Detect Runtime Dependencies of the installed extensions. \
     # - src: https://github.com/docker-library/wordpress/blob/master/latest/php8.0/fpm-alpine/Dockerfile \
        out="$(php -r 'exit(0);')"; \
            [ -z "$out" ]; err="$(php -r 'exit(0);' 3>&1 1>&2 2>&3)"; \
            [ -z "$err" ]; extDir="$(php -r 'echo ini_get("extension_dir");')"; \
            [ -d "$extDir" ]; \
            runDeps="$( \
                scanelf --needed --nobanner --format '%n#p' --recursive "$extDir" \
                    | tr ',' '\n' | sort -u | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
            )"; \
            # Save Runtime Deps in a virtual deps
            apk add --no-network --virtual .php-extensions-rundeps $runDeps; \
            # Uninstall Everything we Installed (minus the runtime Deps)
            apk del --no-network .build-deps; \
            # check for output like "PHP Warning:  PHP Startup: Unable to load dynamic library 'foo' (tried: ...)
            err="$(php --version 3>&1 1>&2 2>&3)"; [ -z "$err" ]

RUN apk update && apk add --no-cache --virtual .build-deps supervisor

# PHP config
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY --chown=www-data:www-data --link .docker/php/php.ini-production "$PHP_INI_DIR/conf.d/90-custom.ini"
COPY --chown=www-data:www-data --link .docker/php/opcache.ini "$PHP_INI_DIR/conf.d/docker-php-ext-opcache.ini"

# PHP-FPM config
RUN rm /usr/local/etc/php-fpm.d/*
COPY --chown=www-data:www-data --link .docker/php/php-fpm.d /usr/local/etc/php-fpm.d

# Supervisor config
RUN mkdir -p /etc/supervisor/conf.d && chown -R www-data:www-data /etc/supervisor

COPY --chown=www-data:www-data --link scripts/supervisor /etc/supervisor/conf.d
COPY --chown=www-data:www-data --link .docker/supervisor/supervisord.conf /etc/supervisord.conf

# Healthcheck
COPY --chown=www-data:www-data --link .docker/php/php-fpm-healthcheck /usr/local/bin
RUN chmod +x /usr/local/bin/php-fpm-healthcheck

HEALTHCHECK CMD ["php-fpm-healthcheck"]

USER www-data

ENTRYPOINT []

CMD ["supervisord", "-c", "/etc/supervisord.conf"]
