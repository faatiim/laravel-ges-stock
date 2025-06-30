
# Utiliser une image de base avec PHP et FPM
FROM php:8.2-fpm

# Installer les outils nécessaires : nginx, supervisor, git, unzip, etc.
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
    && docker-php-ext-install pdo pdo_mysql zip

# Installer Composer (officiellement)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Créer les dossiers nécessaires pour nginx et supervisor
RUN mkdir -p /run/php /var/log/supervisor

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier ton code source
COPY . .

# Installer les dépendances PHP avec Composer
RUN composer install --no-dev --optimize-autoloader --working-dir=/var/www/html

# Donner les bons droits
RUN chown -R www-data:www-data /var/www/html

# Copier les fichiers de config
COPY nginx.conf /etc/nginx/sites-available/default
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Exposer le port 80
EXPOSE 80

# Lancer supervisord pour gérer php-fpm + nginx
CMD ["/usr/bin/supervisord"]
