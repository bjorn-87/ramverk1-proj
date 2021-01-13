#!/usr/bin/env bash
#
# Recreate and reset the database ramverk1proj.
#
echo ">>> Reset ramverk1proj"
echo ">>> Recreate the database (as root)"
mysql -uroot -p ramverk1proj < setup.sql > /dev/null

# file="ddl.sql"
# echo ">>> Create tables, views and process ($file)"
# mysql -uuser -ppass ramverk1proj < $file > /dev/null

# echo ">>> Copy the database to ramverk1proj"
# mysql -uuser -ppass ramverk1proj < backup.sql

echo ">>> Check user"
mysql -uuser -ppass ramverk1proj -e "SELECT * FROM user;"
