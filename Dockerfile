# Étape 1 : Builder Composer
FROM composer:2 as vendor

WORKDIR /app

# Copier uniquement les fichiers nécessaires pour installer les dépendances
COPY composer.json composer.lock ./

# Installer les dépendances sans les packages de dev
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# Étape 2 : PHP avec FPM (production ready)
FROM php:8.2-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libonig-dev libxml2-dev \
    zip unzip git curl libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip bcmath opcache

# Copier Composer depuis l'image précédente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier tous les fichiers de l'application
COPY . .

# Copier le dossier vendor depuis l’étape vendor
COPY --from=vendor /app/vendor ./vendor

# Donner les bonnes permissions à Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Port utilisé par Laravel via nginx ou reverse proxy (Render)
EXPOSE 8000

# Lancer php-fpm
CMD ["php-fpm"]
