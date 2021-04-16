# dapi
dapi is a simple but powerfull api, written in php and interacting with database

# Installation
### Requierments:
- nginx
- php
- mysql / mariadb

### Quick installation
You can make quick installation, which is not recommended, but it is the fastest way to start the api.

First, check the sample dapi.conf file, which will enable the api via nginx.
Change the values as your needs, or use it like it is.

To copy the nginx conf file to the nginx sites-enabled dir, run from deploy dir:
- `sudo bash install.sh`

To create new user and database, run from deploy dir:
- `sudo bash mariadb_new_user.sh user pass database host`

Anyway, you can edit the shell scripts as you want, so you can use more secure way for creating users and databases. The same is valid for the basic dapi.conf file.

# Requests
Currently dapi provides nexts requests:
- GET
- POST /not implemented yet/
- PUT /not implemented yet/
- PATCH /not implemented yet/
- DELETE /not implemented yet/

## GET request
Get request is used to select data:

- `host/username/password/database/table`

You can add where clause as query string, just adding it after the get request:
- `?id=1&name=Pesho`

If your where clause contains numeric value, you can add `.gt` or `.lt` next to the key:
- `?id.gt=1` = `id>1`
- `?id.lt=1` = `id<1`

## POST request

## PUT request

## PATCH request

## DELETE request

# Handlers
You can use some of the provided handlers, or write your own for example if you want to use other db, etc. 

The default handler is mysql, if use other, don't forget to register it in config.php.

## Custom handlers
Every handler should have next functions, accepting the specified arguments:

- `parseQueryString($queryString)`
- `parseBodyKeys($body)`
- `parseBodyValues($body)`
- `select($user, $pass, $db, $table, $where, $DB_HOST, $DB_PORT)`
- `post($user, $pass, $db, $table, $body, $DB_HOST, $DB_PORT)`
- `put($user, $pass, $db, $table, $where, $body, $DB_HOST, $DB_PORT)`
- `patch($user, $pass, $db, $table, $where, $body, $DB_HOST, $DB_PORT)`
- `delete($user, $pass, $db, $table, $where, $DB_HOST, $DB_PORT)`

$DB_HANDLER, $DB_HOST and $DB_PORT should be configured in config.php.


