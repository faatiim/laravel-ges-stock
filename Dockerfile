# Étape 1 : PHP avec toutes les extensions nécessaires
FROM php:8.2-fpm AS app

# Installer les extensions PHP requises par Laravel
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip bcmath opcache

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier uniquement les fichiers nécessaires pour installer les dépendances
COPY composer.json composer.lock ./

# Installer les dépendances PHP (maintenant dans l'image PHP avec toutes les extensions)
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# Étape 2 : Copier le reste du code
COPY . .

# Permissions Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 storage bootstrap/cache

# Expose le port 8000 si derrière nginx ou reverse proxy
EXPOSE 8000

# Lancer PHP-FPM (géré par Render/nginx ou autre)
CMD ["php-fpm"]
