#!/bin/bash

# ✅ XAMPP MySQL bin (Git Bash format)
MYSQLDUMP="/c/xampp/mysql/bin/mysqldump"
MYSQL="/c/xampp/mysql/bin/mysql"

set -a
source "$(dirname "$0")/../.env"
set +a

TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
DUMP_FILE="/tmp/prod_dump_$TIMESTAMP.sql"

echo "⬇️  Pulling production database..."

# Dump from production (Aiven requires SSL)
"$MYSQLDUMP" \
  -h "$PROD_DB_HOST" \
  -P "$PROD_DB_PORT" \
  -u "$PROD_DB_USERNAME" \
  -p"$PROD_DB_PASSWORD" \
  "$PROD_DB_DATABASE" \
  --ssl \
  --no-tablespaces \
  --single-transaction \
  > "$DUMP_FILE"

if [ $? -ne 0 ]; then
  echo "❌ Failed to dump production database."
  exit 1
fi

echo "✅ Production dumped to $DUMP_FILE"
echo "📥 Importing into local database..."

"$MYSQL" \
  -h "$DB_HOST" \
  -P "$DB_PORT" \
  -u "$DB_USERNAME" \
  "$DB_DATABASE" \
  < "$DUMP_FILE"

if [ $? -ne 0 ]; then
  echo "❌ Failed to import into local database."
  exit 1
fi

rm "$DUMP_FILE"
echo "🎉 Done! Production → Local sync complete."