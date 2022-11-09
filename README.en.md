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

![gps-tracker-2022-11-09-15_43_06](https://user-images.githubusercontent.com/644551/200862784-b53868e1-03ad-4e5b-98ef-e2c8eb314ba1.png)

![gps-tracker-2022-11-09-15_43_36](https://user-images.githubusercontent.com/644551/200862818-6b1fd847-0dce-46f2-9529-b8a8b20a0bd2.png)

![gps-tracker-2022-11-09-15_44_26](https://user-images.githubusercontent.com/644551/200862848-44ba2d78-f614-46dd-a5bb-6435f4269dcb.png)

![gps-tracker-2022-11-09-15_44_52](https://user-images.githubusercontent.com/644551/200862881-478a4264-0eae-4bd2-9bd5-d95cfd28d616.png)

![gps-tracker-2022-11-09-15_45_13](https://user-images.githubusercontent.com/644551/200862915-1454768c-894d-405b-b1c5-616fcc242fdc.png)

![gps-tracker-2022-11-09-15_45_39](https://user-images.githubusercontent.com/644551/200862939-fd3b8610-1019-4930-9149-cf560414459b.png)

![gps-tracker-2022-11-09-15_47_46](https://user-images.githubusercontent.com/644551/200862976-32047c5e-3a4b-4770-9e59-8b3d092eb963.png)

![gps-tracker-2022-11-09-15_48_58](https://user-images.githubusercontent.com/644551/200863006-67032098-bbbc-4708-8113-71220c56ad2e.png)

![gps-tracker-2022-11-09-15_49_16](https://user-images.githubusercontent.com/644551/200863049-c8671732-b03d-4b7e-b21c-dfa12ad7587a.png)

![gps-tracker-2022-11-09-15_50_50](https://user-images.githubusercontent.com/644551/200863108-d36b4e26-5f4b-4487-8d5e-8dbfbb8d6160.png)

![gps-tracker-2022-11-09-15_51_10](https://user-images.githubusercontent.com/644551/200863128-0a0e14a9-7920-4caa-b080-b48a0c4ecae6.png)
