FROM php:8.0-fpm

ARG ENV_FILE=.env.example
ARG XDEBUG_MODE="off"

# For composer
RUN apt-get update && apt-get install -y \
     git \
     iputils-ping \
     net-tools \
     zlib1g-dev \
     unzip \
     libzip-dev \
     libfreetype6-dev \
     libpng-dev \
     libjpeg-dev

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --version=2.1.3 \
  | php -- --install-dir=/usr/local/bin --filename=composer \
  && mv composer.phar /usr/local/bin/composer

# Set composer environment
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

# ZIP
RUN docker-php-ext-install zip

# PHP's DB setting
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli

# Install opcache
RUN docker-php-ext-install opcache && docker-php-ext-enable opcache

# Install gd
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Install xdebug
COPY ./docker/containers/php/php/xdebug.ini /usr/local/etc/php/conf.d/
RUN echo -e "\nxdebug.mode = $XDEBUG_MODE" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN pecl channel-update pecl.php.net \
  && pecl install -o -f xdebug \
  && docker-php-ext-enable xdebug

# nginx
RUN apt update
RUN apt install -y nginx vim
RUN useradd -m nginx

RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime
RUN echo 'date.timezone = "Asia/Tokyo"' > /usr/local/etc/php/conf.d/timezone.ini

ADD ./docker/containers/php/nginx/nginx.conf /etc/nginx/nginx.conf
ADD ./docker/containers/php/nginx/conf.d /etc/nginx/conf.d

# Copy source files into the container for ECS env
ADD . /var/www/src/

# Move to Document Root
WORKDIR /var/www/src

# composer install
RUN composer config -g repos.packagist composer https://packagist.jp \
    && composer install

# Setup Laravel
RUN cp -n ./${ENV_FILE} .env
RUN php artisan key:generate
RUN chmod -R a+w storage/ bootstrap/cache

COPY ./docker/containers/php/entrypoint.sh /etc/entrypoint.sh
ENTRYPOINT ["sh", "/etc/entrypoint.sh"]
