#!/bin/bash

# Install project dependencies
composer install

# Laravel scripts
php artisan optimize && php artisan view:clear && php artisan route:clear && php artisan config:clear

# Migrations run
php artisan migrate

# Browser Detect
echo 'Publicando Service Provider do BrowserDetect';
php artisan vendor:publish --provider="hisorange\BrowserDetect\ServiceProvider"

# Swagger API Documentation
echo 'Publicando Service Provider do L5Swagger';
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
