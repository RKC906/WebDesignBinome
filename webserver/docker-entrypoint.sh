#!/usr/bin/env sh
set -e

# Ensure uploads directory is writable for Apache/PHP
if [ -d "/var/www/html/uploads" ]; then
  chown -R www-data:www-data /var/www/html/uploads
  chmod -R 775 /var/www/html/uploads
fi

# Clear PHP sessions so login page is shown after restart
if [ -d "/var/lib/php/sessions" ]; then
  rm -f /var/lib/php/sessions/sess_*
fi

exec apache2-foreground
