FROM php:8.2-apache

# PHP extensions commonly needed by PHP + MySQL sites
RUN apt-get update && apt-get install -y --no-install-recommends \
        libpng-dev libjpeg-dev libzip-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install mysqli pdo_mysql gd zip opcache \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# Allow .htaccess overrides and silence ServerName warning
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Render terminates HTTPS at its proxy; tell PHP the request was secure
RUN echo 'SetEnvIf X-Forwarded-Proto https HTTPS=on' > /etc/apache2/conf-available/proxy-https.conf \
    && a2enconf proxy-https

# Production PHP settings
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && sed -i 's/^upload_max_filesize.*/upload_max_filesize = 10M/' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/^post_max_size.*/post_max_size = 12M/' "$PHP_INI_DIR/php.ini"

WORKDIR /var/www/html
COPY . /var/www/html/

# Writable folder for uploads (change/add folders to match your site)
RUN mkdir -p /var/www/html/uploads/resumes \
    && chown -R www-data:www-data /var/www/html

# Render provides $PORT at runtime; make Apache listen on it
ENV PORT=10000
EXPOSE 10000
CMD ["sh", "-c", "sed -i \"s/Listen 80/Listen ${PORT}/\" /etc/apache2/ports.conf && sed -i \"s/:80>/:${PORT}>/\" /etc/apache2/sites-available/000-default.conf && apache2-foreground"]
