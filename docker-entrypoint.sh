#!/bin/bash

echo "0 0 * * * certbot renew --quiet --post-hook 'apache2ctl graceful'" | crontab -

cron &

if [ ! -f /etc/letsencrypt/live/practicampo.udistrital.edu.co/fullchain.pem ]; then
  certbot certonly --webroot -w /var/www/html/practicampo/public --non-interactive --agree-tos -m practicampo@udistrital.edu.co -d practicampo.udistrital.edu.co
fi

# Iniciar Apache en modo foreground
exec apache2-foreground
