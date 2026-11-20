#!/bin/sh
set -eu
mkdir -p /backups
while true; do
  filename="/backups/postgres-$(date +%Y%m%d-%H%M%S).dump.gz"
  PGPASSWORD="$DB_PASSWORD" pg_dump -h "${DB_HOST:-postgres}" -U "$DB_USERNAME" -d "$DB_DATABASE" --no-owner --no-acl | gzip > "$filename"
  find /backups -type f -name 'postgres-*.dump.gz' -mtime "+${BACKUP_RETENTION_DAYS:-14}" -delete
  sleep "${BACKUP_INTERVAL_SECONDS:-86400}"
done
