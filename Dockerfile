FROM php:8.2-apache

RUN a2enmod rewrite ssl

WORKDIR /var/www/html/practicampo/

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    certbot \
    python3-certbot-apache \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

# COPY ./ssl/certificado.crt /etc/ssl/certs/
# COPY ./ssl/private_key.key /etc/ssl/certs/

COPY apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY apache/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
RUN a2ensite 000-default

RUN composer install --prefer-dist --no-scripts --no-autoloader

RUN chown -R www-data:www-data /var/www/html/practicampo/storage /var/www/html/practicampo/bootstrap/cache
RUN chmod -R 775 /var/www/html/practicampo/storage

RUN echo "memory_limit=256M" > /usr/local/etc/php/conf.d/memory-limit.ini

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80 443

CMD ["docker-entrypoint.sh"]
#CMD ["apache2-foreground"]
