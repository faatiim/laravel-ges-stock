FROM php:8.2-fpm

# Installer les dépendances système et les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    git curl zip unzip libonig-dev libpq-dev \
    && docker-php-ext-install pdo_pgsql mbstring bcmath

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer


# Définir le dossier de travail
WORKDIR /var/www

# Copier les fichiers du projet
COPY . .

# Copier le fichier .env spécifique à Docker
COPY .env.docker .env

# Copier tout sauf ce qui est ignoré par .dockerignore (ex : storage)
# COPY . /var/www/html

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Créer le lien symbolique vers le dossier storage/public
RUN php artisan storage:link

# Donner les bons droits à Laravel
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache


# Exposer le port du container PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
