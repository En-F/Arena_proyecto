#!/bin/bash

# Esperar a la base de datos
until php artisan db:monitor; do
  echo "Postgres está dormido... esperando..."
  sleep 2
done

# Permisos (Correcto para que Apache no de Forbidden)
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Configuración de Laravel
php artisan key:generate --force
php artisan migrate:fresh --seed --force
php artisan storage:link
php artisan ziggy:generate
php artisan optimize:clear

# Lanzar Vite en segundo plano (desarrollo)
npm run dev -- --host 

sudo ufw disable

# Lanzar Apache en primer plano
echo "🚀 Servidor arena.com arrancando..."
exec apache2-foreground