[Castellano](README.md)

# GPS Tracker (Laravel 9 + PHP 8.1 + MySQL 8)

Sinotrack ST-90x device management platform built with Laravel 9 + PHP 8.1 and MySQL 8.

### Installation

1. Create the database in MySQL.

2. Clone the repository.

```bash
git clone https://github.com/eusonlito/GPS-Tracker.git
```

3. Perform the first installation (remember always using the PHP 8.1 binary).

```bash
composer install --no-scripts --no-dev
composer install --no-dev --optimize-autoloader --classmap-authoritative
```

4. Configure the `.env` file with the necessary data.

```bash
cp .env.example .env
```

5. Generate the application key.

```bash
php artisan key:generate
```

6. Regenerate the caches.

```bash
composer artisan-cache
```

7. Launch the initial migration.

```bash
php artisan migrate --path=database/migrations
```

8. Launch the seeder.

```bash
php artisan db:seed --class=Database\\Seeders\\Database
```

9. Fill Timezones GeoJSON.

```bash
php artisan timezone:geojson
```

10. Configure the cron job for the user related to the project:

```
* * * * * cd /var/www/tracker.domain.com && install -d storage/logs/artisan/$(date +"\%Y-\%m-\%d") && /usr/bin/php artisan schedule:run >> storage/logs/artisan/$(date +"\%Y-\%m-\%d")/schedule-run.log 2>&1
```

11. Create the main user.

```bash
php artisan user:create --email=user@domain.com --name=Admin --password=StrongPassword2 --enabled --admin
```

12. Configure the web server `DocumentRoot` to `/var/www/project/public`.

13. Profit!

### Socket connection

The opened port for the connection of devices with H02 protocol is `8091` made by default, but it can be customized by changing the `config/sockets.php` file.

To configure your device via SMS you can do it with the following command:

```
804{PASSWORD} {IP/HOST} {PORT}
```

You can configure the connection server in the device using either the IP or a HOST that will resolve internally BUT ONLY AT THE TIME OF RECEIVING THE COMMAND, so if the server does not have a fixed IP as soon as it changes you will stop receiving data from the device.

### Common Sinotrack ST-901 SMS commands

#### Configuring the Phone from which you can connect to the device

```
{PHONE}{PASSWORD} 1
```

#### Set the time zone to UTC to delegate the time adjustment to the platform.

```
896{PASSWORD}E00
```

#### Enable GPRS Mode

```
710{PASSWORD}
```

#### Configure APN Operator

```
803{PASSWORD} {OPERATOR}
```

#### Configure Server

```
804{PASSWORD} {IP/HOST} {PORT}
```

#### Configure frequency in seconds of sending position reports with the car ignition on

```
805{PASSWORD} {SECONDS}
```

#### Configure frequency in seconds of sending position reports with the car ignition off

```
809{PASSWORD} {SECONDS}
```

#### Set timeout before switching to SLEEP mode when the car is stopped

```
SLEEP{PASSWORD} {SECONDS}
```

#### Deactivate call in case of alarm

```
151{PASSWORD}
```

#### Password change

```
777{PASSWORD-NEW}{PASSWORD-OLD}
```

#### Device restart

```
RESTART
```

#### Show current configuration

```
RCONF
```

### Platform Update

Updating the platform can be done in a simple way with the `composer deploy` command executed by the user who manages that project (usually `www-data`).

This command performs the following actions:

```
"rm -f bootstrap/cache/*.php",
"git checkout .",
"git pull",
"@composer env-version --ansi",
"@composer install --no-dev --optimize-autoloader --classmap-authoritative --ansi",
"@php artisan migrate --force --ansi",
"@php artisan db:seed --force --ansi --class=\"Database\\Seeders\\Database\"",
"@php artisan maintenance:migration:clean",
"@php artisan socket:server:all --reset"
```

### Platform Commands

#### User Creation:

```bash
php artisan user:create {--email=} {--name=} {--password=} {--enabled} {--admin}
```

#### Start or Restart all configured sockets:

The `reset` option allows you to reset the port in case it is being used.

```bash
php artisan socket:server:all {--reset}
```

#### Start or Restart only one socket port:

The `reset` option allows you to reset the port in case it is being used.

```bash
php artisan socket:server {--port=} {--reset}
```

### Screenshots

![Screenshot from 2022-10-31 09-37-46](https://user-images.githubusercontent.com/644551/198966515-1afb7ac3-b2a6-428a-b65d-a9eacff35ded.png)

![Screenshot from 2022-10-31 09-38-26](https://user-images.githubusercontent.com/644551/198966533-961ca22c-832a-4bd6-a176-d78b060c9d3e.png)

![Screenshot from 2022-10-18 18-31-10](https://user-images.githubusercontent.com/644551/196489823-7ef35c1d-4c88-49dd-b0b7-e50a24b7beb2.png)

![Screenshot from 2022-10-18 18-31-21](https://user-images.githubusercontent.com/644551/196489866-e1b89302-1558-41ef-89a2-02a3f335ec17.png)

![Screenshot from 2022-10-18 18-31-27](https://user-images.githubusercontent.com/644551/196489891-2f3a81a8-b788-44e1-bb9e-1457bcba92ba.png)

![Screenshot from 2022-10-18 18-30-06](https://user-images.githubusercontent.com/644551/196489713-969ffb72-a864-434e-8533-afc87e700582.png)

![Screenshot from 2022-10-18 18-30-15](https://user-images.githubusercontent.com/644551/196489740-b71e0042-51e9-4038-9a6d-03d5bf8180ac.png)

![Screenshot from 2022-10-18 18-30-37](https://user-images.githubusercontent.com/644551/196489787-6f570213-6e4b-444d-979b-62bdf0625582.png)
