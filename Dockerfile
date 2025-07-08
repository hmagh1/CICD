FROM php:8.2-cli
RUN apt-get update && apt-get install -y unzip git && docker-php-ext-install pdo pdo_mysql
COPY . /app
WORKDIR /app
RUN curl -sS https://getcomposer.org/installer | php && php composer.phar install
CMD ["vendor/bin/phpunit", "--testdox"]

EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
