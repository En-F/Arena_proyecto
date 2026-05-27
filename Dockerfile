FROM php:8.3-apache

# Instalar dependencias del sistema y herramientas de Node.js
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev libpq-dev zip unzip \
    && curl -sL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP para Postgres
RUN docker-php-ext-install pdo pdo_pgsql

# Configuración de Apache
COPY apache/arena.conf /etc/apache2/sites-available/arena.conf
RUN a2dissite 000-default.conf && a2ensite arena.conf && a2enmod rewrite

# Copiar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiamos el proyecto
COPY . .

# Instalamos dependencias y compilamos
RUN composer install --no-interaction --optimize-autoloader
RUN npm install && npm run build

# PERMISOS: Muy importante para evitar el Forbidden
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Script de entrada
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80 

ENTRYPOINT ["docker-entrypoint.sh"]