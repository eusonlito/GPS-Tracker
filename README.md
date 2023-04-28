[Castellano](README.es.md)

# GPS Tracker (Laravel 10 + PHP 8.1 + MySQL 8)

Sinotrack ST-90x device management platform built with Laravel 10 + PHP 8.1 and MySQL 8.

### Requirements

- PHP 8.1 or higher (bcmath bz2 intl mbstring opcache pdo_mysql pcntl redis sockets xsl zip)
- MySQL 8.0
- Redis

### Local Installation

1. Create the database in MySQL.

2. Clone the repository.

```bash
git clone https://github.com/eusonlito/GPS-Tracker.git
```

3. Copy the `.env.example` file as `.env` and fill in the necessary variables.

```bash
cp .env.example .env
```

4. Install composer dependencies (remember that we always use the PHP 8.1 binary).

```bash
composer install --no-dev --optimize-autoloader --classmap-authoritative --ansi
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

#### Upgrade

Updating the platform can be done in a simple way with the `composer deploy` command executed by the user who manages that project (usually `www-data`).

### Docker Installation

1. Clone the repository.

```bash
git clone https://github.com/eusonlito/GPS-Tracker.git
```

2. [OPTIONAL] Copy file `docker/.env.example` to `.env` and configure your own settings

```bash
cp docker/.env.example .env
```

3. [OPTIONAL] Copy file `docker/docker-compose.yml.example` to `docker/docker-compose.yml` and configure your own settings

```bash
cp docker/docker-compose.yml.example docker/docker-compose.yml
```

4. Build docker images (will ask for the sudo password)

```bash
./docker/build.sh
```

5. Start containers (will ask for the sudo password)

```bash
./docker/run.sh
```

6. Create the admin user (will ask for the sudo password)

```bash
./docker/user.sh
```

7. Launch the Timezone GeoJSON fill (will ask for the sudo password)

```bash
./docker/timezone-geojson.sh
```

8. Open your web browser and goto http://localhost:8080

9. Remember to add a web server (apache2, nginx, etc...) as a proxy to add features as SSL.

10. If you are going to add or change the default ports for GPS Devices (`8091`) you must edit the `gpstracker-app` properties in `docker-compose.yml` to adapt them to your own configuration.

#### Docker Upgrade

1. Update the project source

```bash
git pull
```

2. Build docker images (will ask for the sudo password)

```bash
./docker/build.sh
```

3. Start containers (will ask for the sudo password)

```bash
./docker/run.sh
```

4. Open your web browser and goto http://localhost:8080

### Server connection

The default port for devices with H02 protocol is `8091`, but it can be customized on configuration panel (as admin).

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
SLEEP{PASSWORD} {MINUTES}
```

#### Deactivate call in case of alarm

```
151{PASSWORD}
```

#### Enable Device Low Battery SMS

```
011{PASSWORD}
```

#### Disable Device Low Battery SMS

```
010{PASSWORD}
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

### Platform Commands

#### User Creation:

```bash
php artisan user:create {--email=} {--name=} {--password=} {--enabled} {--admin}
```

#### Start or Restart all configured servers:

The `reset` option allows you to reset the port in case it is being used.

```bash
php artisan server:start:all {--reset}
```

#### Start or Restart only one server port:

The `reset` option allows you to reset the port in case it is being used.

```bash
php artisan server:start {--port=} {--reset}
```

### Screenshots

Screenshots are in spanish, you can change the system language to english.

![gps-tracker-2022-12-30-11_46_09](https://user-images.githubusercontent.com/644551/210064626-546f2d32-b39c-4d08-b4a3-05da832f69cf.png)

![gps-tracker-2022-12-30-11_47_14](https://user-images.githubusercontent.com/644551/210064624-115268df-8418-40c4-a867-2423643c5362.png)

![gps-tracker-2022-12-30-11_47_46](https://user-images.githubusercontent.com/644551/210064012-a2ef4d18-0b29-457a-bf08-94b2b3de57c9.png)

![gps-tracker-2022-12-30-11_48_31](https://user-images.githubusercontent.com/644551/210064011-00f8ef87-b47c-4570-9f76-72cbaa148c32.png)

![gps-tracker-2022-12-30-11_49_20](https://user-images.githubusercontent.com/644551/210064010-a417013e-4218-4245-8edd-83b1b3cf3253.png)

![gps-tracker-2022-12-30-11_49_55](https://user-images.githubusercontent.com/644551/210064008-3832c8e3-5cc6-45de-850a-6d4593174d4e.png)

![gps-tracker-2022-12-30-11_51_24](https://user-images.githubusercontent.com/644551/210064006-00b726b3-183f-421f-98b8-86eb4ff86636.png)

![gps-tracker-2022-12-30-11_51_49](https://user-images.githubusercontent.com/644551/210064005-54238ce2-80a7-48c6-a2a4-f9653b4a519d.png)

![gps-tracker-2022-12-30-11_52_07](https://user-images.githubusercontent.com/644551/210064004-cf50b5c4-9918-4dec-b77c-473502728de1.png)

![gps-tracker-2022-12-30-11_52_51](https://user-images.githubusercontent.com/644551/210064003-d0dac472-37d1-491b-829b-a23ba78cfc20.png)

![gps-tracker-2022-12-30-11_55_23](https://user-images.githubusercontent.com/644551/210064002-c56009e6-bfd7-4ca6-ae6e-d5098865d116.png)

![gps-tracker-2022-12-30-11_55_48](https://user-images.githubusercontent.com/644551/210064001-f447a7d3-a7b2-414e-b1fe-75fd9387bb52.png)

![gps-tracker-2022-12-30-11_56_07](https://user-images.githubusercontent.com/644551/210063999-a6dbe759-4e33-499d-ae81-086a5467c26f.png)

![gps-tracker-2022-12-30-11_56_33](https://user-images.githubusercontent.com/644551/210063997-4adfed30-1f07-49b7-9b3b-ac76f51f2c28.png)

![gps-tracker-2022-12-30-11_57_50](https://user-images.githubusercontent.com/644551/210063996-22323f37-45f9-4bdf-b8e5-e120d28a6918.png)

![gps-tracker-2022-12-30-11_58_06](https://user-images.githubusercontent.com/644551/210063994-98fbbf6d-8127-4b38-8483-29740d1af21f.png)

![gps-tracker-2022-12-30-11_58_56](https://user-images.githubusercontent.com/644551/210063989-4fb43878-4041-42b7-9648-4b3d03f5db04.png)

![gps-tracker-2022-12-30-11_59_25](https://user-images.githubusercontent.com/644551/210063988-dcf5f604-0d9e-45cc-9f71-31c675368758.png)

![gps-tracker-2022-12-30-11_59_48](https://user-images.githubusercontent.com/644551/210063987-112e8db4-0866-4b81-a03f-3a9059e2ef55.png)

![gps-tracker-2022-12-30-12_00_04](https://user-images.githubusercontent.com/644551/210063983-86739319-e6b5-4a7c-8c68-e6155d2d976f.png)

![gps-tracker-2022-12-30-12_00_30](https://user-images.githubusercontent.com/644551/210063981-95ab19b4-7bc6-4f33-b998-cac02b10016c.png)

![gps-tracker-2022-12-30-12_01_20](https://user-images.githubusercontent.com/644551/210063980-354eec06-e7fc-4611-9a33-b23788a8aa43.png)

![gps-tracker-2022-12-30-12_01_43](https://user-images.githubusercontent.com/644551/210063978-753a20f6-68eb-487e-aa6f-1745f9769fd4.png)

![gps-tracker-2022-12-30-12_02_01](https://user-images.githubusercontent.com/644551/210063976-c3cda554-4335-4c75-820c-f666f207489b.png)

![gps-tracker-2022-12-30-12_03_07](https://user-images.githubusercontent.com/644551/210063974-97b37bab-86cf-4ee7-9a69-70799c7ca34f.png)

![gps-tracker-2022-12-30-12_03_37](https://user-images.githubusercontent.com/644551/210063972-17d143ad-9cdc-47f0-9005-cc3d429ae78e.png)
