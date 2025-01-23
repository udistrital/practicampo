#!/bin/bash

CONTAINER_NAME=dbpracticampo
DB_USER=viverouser
DB_NAME=udpracticampo
BACKUP_DIR=/home/decpracti/practicampo/db_backup/

# Fechas en formato YYYY-MM-DD
CURRENT_DATE=$(date +\%F)
CURRENT_MONTH=$(date +\%Y-\%m)
LAST_MONTH=$(date -d "last month" +\%Y-\%m)

# Rutas backup
DAILY_BACKUP_FILE="$BACKUP_DIR/daily_backup.sql"
MONTHLY_BACKUP_FILE="$BACKUP_DIR/backup_$LAST_MONTH.sql"

# Condicional para guardar un backup mensual
if [ $(date +\%d) -eq 01 ]; then
    cp $DAILY_BACKUP_FILE $MONTHLY_BACKUP_FILE
fi

# Se ejecuta el comando en el contenedor de docker
docker exec $CONTAINER_NAME /usr/bin/mysqldump -u $DB_USER --password=DBvivUSER.2021$ $DB_NAME > $DAILY_BACKUP_FILE

# Parte por validar que funcione: crontab para que se ejecute todos los dias a x hora
# crontab -e
# 0 3 * * * /home/decpracti/practicampo/backup.sh
