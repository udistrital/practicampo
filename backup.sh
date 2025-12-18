#!/bin/bash
source /home/decpracti/practicampo/.env
CONTAINER_NAME=dbpracticampo
DB_USER=viverouser
DB_NAME=udpracticampo
BACKUP_DIR=/home/decpracti/practicampo/db_backup/

# Fechas en formato YYYY-MM-DD
#CURRENT_DATE=$(date +%F)
#CURRENT_HOUR=$(date +%F_%H)

# Rutas backup
DAILY_BACKUP_FILE="$BACKUP_DIR/daily_backup.sql"
HOURLY_BACKUP_FILE="$BACKUP_DIR/hourly_backup.sql"

mkdir -p "$BACKUP_DIR"

# Validar variable de entorno
if [ -z "$DB_PASSWORD" ]; then
  echo "ERROR: DB_PASSWORD no está definida" >&2
  exit 1
fi

# Se ejecuta el comando en el contenedor de docker
docker exec "$CONTAINER_NAME" /usr/bin/mysqldump -u "$DB_USER" --password="$DB_PASSWORD" "$DB_NAME" > "$HOURLY_BACKUP_FILE"

# Condicional para guardar un backup diario
if [ ! -f "$DAILY_BACKUP_FILE" ] || \
   [ "$(date -d "$(stat -c %y "$DAILY_BACKUP_FILE")" +%F)" != "$(date +%F)" ]; then

    docker exec "$CONTAINER_NAME" /usr/bin/mysqldump -u "$DB_USER" --password="$DB_PASSWORD" "$DB_NAME" > "$DAILY_BACKUP_FILE"
fi

# Parte por validar que funcione: crontab para que se ejecute todas las horas
# chmod +x /home/decpracti/practicampo/backup.sh
# Para ejecutar manualmente antes de hacer el cron, si falla usar bash -x para revisar
    # /home/decpracti/practicampo/backup.sh
# systemctl status cron
    # (si no está activo)
    # sudo systemctl enable --now cron
# crontab -e
    # 0 * * * * /home/decpracti/practicampo/backup.sh
# crontab -l
