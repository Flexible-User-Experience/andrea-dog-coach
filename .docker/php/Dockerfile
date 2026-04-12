FROM php:8.4.18-fpm AS base

WORKDIR /var/www/andrea-dog-coach/

ENV FPM_PM_MAX_CHILDREN="10" \
    PHP_OPCACHE_VALIDATE_TIMESTAMPS="1" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="20000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="256" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10" \
    PHP_REALPATH_CACHE_TTL="120" \
    TZ="Europe/Madrid"

RUN rm /etc/apt/preferences.d/no-debian-php

RUN apt-get update																								&&	\
    apt-get -y install --no-install-recommends																		\
    acl 																											\
    curl 																											\
    git 																											\
    wget 																											\
    zip 																											\
    unzip 																											\
    libicu-dev 																									    \
    libonig-dev 																									\
    libpng-dev 																										\
    libzip-dev																										\
    libpq-dev 																										\
    libxslt-dev 																									\
    libxml2-dev 																									\
    libssl-dev 																										\
    libgmp-dev 																										\
    libcurl4-openssl-dev 																							\
    zlib1g-dev 																										\
    libssh-dev 																										;

RUN docker-php-ext-configure zip																				&&	\
    docker-php-ext-install -j$(nproc)																				\
    bcmath 																											\
    curl 																											\
    xml 																											\
    mbstring 																										\
    zip 																											\
    pdo 																											\
    pdo_mysql 																										\
    intl 																											\
    gd 																												\
    sockets 																										\
    gmp 																											\
    xsl 																											\
    pcntl																											;

RUN pecl install																									\
    	apcu-5.1.28																								&&	\
    pecl clear-cache																							&&	\
    docker-php-ext-enable																							\
    	apcu																										\
    	opcache																										;

COPY --from=composer/composer:2.9.5-bin /composer /usr/local/bin/composer

FROM base AS development

RUN pecl install pcov-1.0.12																					&&	\
    docker-php-ext-enable pcov																						;

RUN pecl install xdebug-3.5.0																					&&	\
    docker-php-ext-enable xdebug																					;


RUN mkdir -p /var/www/andrea-dog-coach/var/cache /var/www/andrea-dog-coach/var/log 							          &&	\
    setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX /var/www/andrea-dog-coach/var							      && 	\
	setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX /var/www/andrea-dog-coach/var								        ;

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY .docker/php/php.ini-development "$PHP_INI_DIR/conf.d/90-custom.ini"
COPY .docker/php/opcache.ini "$PHP_INI_DIR/conf.d/docker-php-ext-opcache.ini"
COPY .docker/php/xdebug-disabled.ini "$PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini"

RUN wget https://github.com/maglnet/ComposerRequireChecker/releases/download/4.19.0/composer-require-checker.phar && \
    chmod +x composer-require-checker.phar 																		  && \
    mv composer-require-checker.phar /usr/local/bin/composer-require-checker										  ;

RUN wget https://github.com/composer-unused/composer-unused/releases/download/0.9.5/composer-unused.phar 		&& 	\
    chmod +x composer-unused.phar 																				&& 	\
    mv composer-unused.phar /usr/local/bin/composer-unused															;

RUN wget https://github.com/overtrue/phplint/releases/download/9.7.1/phplint.phar 		                        && 	\
    chmod +x phplint.phar 																				        && 	\
    mv phplint.phar /usr/local/bin/phplint															                ;


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

RUN apt-get update && apt-get -y install --no-install-recommends supervisor

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY --chown=www-data:www-data --link .docker/php/php.ini-production "$PHP_INI_DIR/conf.d/90-custom.ini"
COPY --chown=www-data:www-data --link .docker/php/opcache.ini "$PHP_INI_DIR/conf.d/docker-php-ext-opcache.ini"
COPY --chown=www-data:www-data --link .docker/php/php-fpm.d /usr/local/etc/php-fpm.d

COPY --link scripts/supervisor /etc/supervisor/conf.d

CMD supervisord -c /etc/supervisor/supervisord.conf && php-fpm --nodaemonize
