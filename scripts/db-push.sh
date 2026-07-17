#!/bin/bash

# ✅ XAMPP MySQL bin (Git Bash format)
MYSQLDUMP="/c/xampp/mysql/bin/mysqldump"
MYSQL="/c/xampp/mysql/bin/mysql"

echo "⚠️  WARNING: This will OVERWRITE your production database!"
read -p "Type 'yes' to continue: " CONFIRM

if [ "$CONFIRM" != "yes" ]; then
  echo "Aborted."
  exit 0
fi

set -a
source "$(dirname "$0")/../.env"
set +a

TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
DUMP_FILE="/tmp/local_dump_$TIMESTAMP.sql"

echo "⬆️  Pushing local database to production..."

# Dump from local
"$MYSQLDUMP" \
  -h "$DB_HOST" \
  -P "$DB_PORT" \
  -u "$DB_USERNAME" \
  "$DB_DATABASE" \
  --no-tablespaces \
  --single-transaction \
  > "$DUMP_FILE"

if [ $? -ne 0 ]; then
  echo "❌ Failed to dump local database."
  exit 1
fi

echo "✅ Local dumped to $DUMP_FILE"
echo "📤 Importing into production..."

# Import into production (Aiven requires SSL)
"$MYSQL" \
  -h "$PROD_DB_HOST" \
  -P "$PROD_DB_PORT" \
  -u "$PROD_DB_USERNAME" \
  -p"$PROD_DB_PASSWORD" \
  --ssl \
  "$PROD_DB_DATABASE" \
  < "$DUMP_FILE"

if [ $? -ne 0 ]; then
  echo "❌ Failed to push to production."
  exit 1
fi

rm "$DUMP_FILE"
echo "🎉 Done! Local → Production sync complete."