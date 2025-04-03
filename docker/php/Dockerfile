FROM ubuntu:24.04

# Установка основных пакетов и добавление PPA для PHP
RUN apt-get update && apt-get install -y \
    software-properties-common \
    && add-apt-repository ppa:ondrej/php -y \
    && apt-get update

# Установка PHP 8.3 и необходимых расширений
RUN apt-get install -y \
    php8.3-fpm \
    php8.3-cli \
    php8.3-dev \
    php8.3-gd \
    php8.3-mysql \
    php8.3-mbstring \
    php8.3-xml \
    php8.3-zip \
    php8.3-bcmath \
    php8.3-exif \
    php8.3-redis \
    php8.3-intl \
    php8.3-pdo \
    php8.3-http \
    php8.3-raphf \
    php8.3-curl \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libzip-dev \
    libxml2-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    zip \
    unzip

RUN apt-get install -y git

RUN apt-get install -y nginx

RUN  apt-get install -y cron

RUN  apt-get install -y supervisor

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка зависимостей через Composer
WORKDIR /var/www

# Копирование пользовательской конфигурации PHP
COPY ./docker/php/local.ini /usr/local/etc/php/conf.d/local.ini
#Копирование конфигурации Supervisor
COPY ./docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
# Копирование конфигурации Nginx
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
# Копирование файла cron
COPY ./docker/cron/schedule-cron /etc/cron.d/schedule-cron

# Установка прав для cron-файла
RUN chmod 0644 /etc/cron.d/schedule-cron

# Регистрация cron задачи
RUN crontab /etc/cron.d/schedule-cron


RUN chmod 644 /etc/supervisor/conf.d/supervisord.conf


# Запуск Nginx, PHP-FPM, Supervisor и Cron
CMD service cron start && /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
