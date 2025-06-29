FROM php:8.2-fpm

# Installer nginx et dépendances
RUN apt-get update && apt-get install -y nginx supervisor

# Copier config nginx
COPY nginx.conf /etc/nginx/sites-available/default

# Copier code de l'application
COPY . /var/www/html
WORKDIR /var/www/html

# Donne les bons droits
RUN chown -R www-data:www-data /var/www/html

# Copier la config Supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Exposer le port 80
EXPOSE 80

# Démarrer nginx + php-fpm via supervisord
CMD ["/usr/bin/supervisord"]
