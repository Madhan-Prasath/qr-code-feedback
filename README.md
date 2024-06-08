# QR Code Portal Laravel Backend

## Building

### Pre-requisites:
1. Install laravel using composer: https://laravel.com/docs/8.x/installation#installation-via-composer
2. Install Postgresql v12 server using WSL2 or Docker Desktop
3. It is recommended to setup Postgresql reachable on localhost
4. Install HeidiSQL for DB management: https://www.heidisql.com/download.php 

### Create a local Postgres database for development

```sql
CREATE USER qrcode WITH PASSWORD 'qrcode';
CREATE DATABASE qrcode OWNER qrcode;
GRANT ALL PRIVILEGES ON DATABASE qrcode TO qrcode;
```

Note: Postgres 12 and below require superuser privilege to install extensions. So connect to `qrcode` DB as the `postgres` user and create the following extensions:

```sql
CREATE EXTENSION IF NOT EXISTS citext;
```

### Install application dependencies and DB migration

```sh
git clone git@github.com:Madhan-Prasath/qr-code-feedback.git
cd qr-code-feedback
cp .env.example .env
composer install
php artisan migrate
php artisan key:generate
php artisan db:seed
php artisan storage:link
php artisan serve

# Access Portal at http://127.0.0.1:8000/admin
```

## Running in production

### Server prerequisites

Recommended solution is to deploy in the application in docker using [docker-compose.yml](docker-compose.yml) file.

Set apache DocumentRoot to the Laravel application `public` folder, eg. `/var/www/public`.

Create a Postgres database and user as required. See development DB creation steps for reference.

### Install application dependencies and DB migration

```sh
cd /var/www
git clone git@github.com:Madhan-Prasath/qr-code-feedback.git
cd html

chown -Rh www-data storage/framework

cp .env.prod .env
```

### Steps to run inside the docker container

```sh
composer install
php artisan migrate
php artisan key:generate
php artisan db:seed
php artisan storage:link

```
