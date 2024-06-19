FROM php:7.4-apache
# Instalamos las extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libgd-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql bcmath zip gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Habilitar el módulo de reescritura de Apache
RUN a2enmod rewrite

# Agregamos la configuración al archivo apache2.conf
RUN echo "<Directory /var/www/html/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride all\n\
    Require all granted\n\
    </Directory>" >> /etc/apache2/apache2.conf

# Establecemos el límite de memoria
RUN echo "memory_limit = 2048M" > /usr/local/etc/php/conf.d/memory-limit.ini
RUN echo "upload_max_filesize = 100M" > /usr/local/etc/php/conf.d/upload-max-filesize.ini
RUN echo "post_size_max = 100M" > /usr/local/etc/php/conf.d/post-size-max.ini

# Instalamos Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Exponemos el puerto 80 para acceder a la aplicación desde el host
EXPOSE 80

# Ejecutamos el servidor Apache en primer plano
CMD ["apache2-foreground"]