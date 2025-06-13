FROM php:8.2-cli

# Installer les extensions utiles pour Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Dossier de travail
WORKDIR /var/www/html

# Copier les fichiers Laravel
COPY . .

# Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Donner les bonnes permissions
RUN chmod -R 755 /var/www/html && chown -R www-data:www-data /var/www/html

# Port attendu par Render
EXPOSE 10000

# Lancer le serveur Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
