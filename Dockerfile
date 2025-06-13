FROM php:8.2-cli

# Installer extensions requises
RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libonig-dev libxml2-dev \
    zip unzip git curl libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip bcmath

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Dossier de travail
WORKDIR /var/www/html

# Copier le projet
COPY . .

# Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Donner permissions
RUN chmod -R 755 /var/www/html && chown -R www-data:www-data /var/www/html

# Exposer le port Laravel par défaut sur Render/Koyeb
EXPOSE 10000

# Lancer le serveur intégré Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
