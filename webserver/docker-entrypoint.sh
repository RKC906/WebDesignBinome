#!/usr/bin/env sh
set -e

# Ensure uploads directory is writable for Apache/PHP
if [ -d "/var/www/html/uploads" ]; then
  chown -R www-data:www-data /var/www/html/uploads
  chmod -R 775 /var/www/html/uploads
fi

exec apache2-foreground
