#!/bin/sh
set -e

# Права для Laravel
mkdir -p /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache || true
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache || true

# Запуск php-fpm
echo "🎯 Starting php-fpm"
php-fpm