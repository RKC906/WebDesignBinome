# Utiliser l'image officielle Apache + PHP
FROM php:8.2-apache

# Définir le répertoire de travail
WORKDIR /var/www/html

# Installer les extensions PHP nécessaires
ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get update -o Acquire::Retries=3 \
    && apt-get install -y --no-install-recommends \
    libpq-dev \
    ssl-cert \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Activer mod_rewrite pour le rewriting d'URLs
RUN a2enmod rewrite

# Activer les modules pour cache navigateur
RUN a2enmod expires headers

# Activer mod_ssl pour HTTPS
RUN a2enmod ssl

# Activer le site SSL
RUN a2ensite default-ssl

# Copier les fichiers de configuration Apache
COPY apache-config/ports.conf /etc/apache2/ports.conf
COPY apache-config/default.conf /etc/apache2/sites-available/000-default.conf
COPY apache-config/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf

# Copier le fichier php.ini personnalisé
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# Créer les répertoires pour les uploads
RUN mkdir -p /var/www/html/backoffice/uploads/articles \
    && mkdir -p /var/www/html/frontoffice/uploads \
    && chmod -R 755 /var/www/html

# Entrypoint pour ajuster les permissions des uploads
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Exposer les ports
EXPOSE 80 443

# Démarrer Apache au premier plan
CMD ["/usr/local/bin/docker-entrypoint.sh"]
