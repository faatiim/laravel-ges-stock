FROM php:8.2-fpm

# Installer dépendances système et extensions PHP requises (dont bcmath)
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    unzip \
    git \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip bcmath

# Copier Composer depuis l'image officielle composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier tous les fichiers de l'application
COPY . .

# Installer les dépendances PHP via Composer
RUN composer install --no-dev --optimize-autoloader --working-dir=/var/www/html

# Fixer les droits
RUN chown -R www-data:www-data /var/www/html

# Copier les configs nginx et supervisor (à adapter selon tes fichiers)
COPY nginx.conf /etc/nginx/sites-available/default
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Exposer le port 80
EXPOSE 80

# Démarrer supervisord
CMD ["/usr/bin/supervisord"]
