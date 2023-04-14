#FROM docker-registry.ctti.extranet.gencat.cat/gencatcloud/apache-php:8.1
FROM php:8.1-apache
# install all the dependencies and enable PHP modules
RUN apt-get update && apt-get upgrade -y && apt-get install -y \
      vim \
      dos2unix \
      telnet \
      mariadb-client-10.5 \
      net-tools \
      procps \
      nano \
      git \
      unzip \
      libicu-dev \
      zlib1g-dev \
      libxml2 \
      libxml2-dev \
      libreadline-dev \
      supervisor \
      cron \
      sudo \
      libzip-dev \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
      pdo_mysql \
      sockets \
      intl \
      opcache \
      zip \
    && rm -rf /tmp/* \
    && rm -rf /var/list/apt/* \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get clean

# disable default site and delete all default files inside APP_HOME
RUN a2dissite 000-default.conf

# put apache and php config for Laravel, enable sites
COPY ./apache/laravel.conf /etc/apache2/sites-available/laravel.conf
COPY ./apache/laravel-ssl.conf /etc/apache2/sites-available/laravel-ssl.conf
COPY ./apache/ports.conf /etc/apache2/ports.conf
COPY ./apache/apache2.conf /etc/apache2/apache2.conf
RUN a2ensite laravel.conf && a2ensite laravel-ssl
#COPY ./apache/$BUILD_ARGUMENT_ENV/php.ini /usr/local/etc/php/php.ini

# enable apache modules
RUN a2enmod rewrite
#RUN a2enmod ssl

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN chmod +x /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1



# set working directory
WORKDIR /var/www/html
#COPY --chown=www-data:www-data . /var/www/html/
COPY --chown=1013020000:1013020000 . /var/www/html/
RUN chmod 777 -R /var/www/html/storage /var/www/html/bootstrap/cache 

USER 1013020000
# Install Laravel PHP dependencies
#RUN composer install --optimize-autoloader --no-interaction --no-progress --no-dev; 

# Install composer and Laravel dependencies with composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && composer install --no-dev --optimize-autoloader


RUN chmod +x ./docker-entrypoint.sh
RUN chmod +x ./scripts/start.sh

EXPOSE 1080
#ENTRYPOINT ["sh","./docker-entrypoint.sh"]
CMD ["./scripts/start.sh"]
