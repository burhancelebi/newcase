#!/bin/bash

# Hataları yakala
set -e

# Eğer .env dosyası yoksa, .env.example'den kopyala
if [ ! -f .env ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
fi

# Laravel migration işlemleri
echo "Running migrations..."
php artisan migrate:fresh --force

# Laravel seed işlemleri
echo "Running seeders..."
php artisan db:seed --force

