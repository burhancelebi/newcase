FROM php:8.3-fpm

WORKDIR /var/www/html

COPY . /var/www/html

RUN cp .env.example .env

######## Composer.phar ########
RUN curl -s https://getcomposer.org/installer | php \
  # move composer into a bin directory you control:
  && mv composer.phar /usr/local/bin/composer \
  # double check composer works
  && composer about

RUN php -m && echo "============================================="

RUN apt-get update && apt-get install -y \
  libpng-dev \
  libxml2-dev \
  libxslt-dev \
  libzip-dev \
  libsodium-dev

RUN docker-php-ext-install \
  exif \
  opcache \
  pcntl \
  pdo_mysql \
  zip \
  sodium \
  sockets

RUN apt-get update && \
apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev && \
docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install gd

RUN chmod -R 775 /var/www/html
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

RUN composer install

# Expose port 8001 and start php-fpm server
EXPOSE 8001
CMD ["php-fpm"]
