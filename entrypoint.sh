#!/bin/sh

# Tunggu MySQL ready dulu
echo "🕒 Waiting for MySQL to be ready..."
until nc -z -v -w30 $DB_HOST $DB_PORT
do
  echo "Waiting for database connection at $DB_HOST:$DB_PORT..."
  sleep 5
done

# Copy .env jika belum ada
if [ ! -f ".env" ]; then
    cp .env.example .env
fi

# Bersihin cache 
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Generate key 
php artisan key:generate

# Cache ulang semua
php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan storage:link

# Jalankan migration dan seeder 
php artisan migrate --force
php artisan db:seed --force

# Start laravel
exec php -S 0.0.0.0:8000 -t public