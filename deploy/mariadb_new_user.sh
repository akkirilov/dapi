#!/bin/bash

mysql -e "CREATE USER IF NOT EXISTS '$1'@'$4' IDENTIFIED BY '$2';"
mysql -e "CREATE DATABASE IF NOT EXISTS $3"
mysql -e "GRANT ALL PRIVILEGES ON $2.* TO '$1'@'$4';"
mysql -e "FLUSH PRIVILEGES;"
