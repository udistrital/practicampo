#!/bin/bash

echo "0 0 * * * certbot renew --quiet --post-hook 'apache2ctl graceful'" | crontab -

service cron start

if [ ! -f /etc/letsencrypt/live/tu-dominio.com/fullchain.pem ]; then
  certbot certonly --webroot -w /var/www/html/practicampo --non-interactive --agree-tos -m practicampo@udistrital.edu.co -d practicampo.udistrital.edu.co
fi

# Iniciar Apache en modo foreground
apache2-foreground
