[Castellano](README.es.md)

# GPS Tracker (Laravel 10 + PHP 8.1 + MySQL 8)

Sinotrack ST-90x device management platform built with Laravel 10 + PHP 8.1 and MySQL 8.

### Requirements

- PHP 8.1 or higher (bcmath bz2 intl mbstring opcache pdo_mysql pcntl redis sockets xsl zip)
- MySQL 8.0.12 or higher
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
./composer install --no-dev --optimize-autoloader --classmap-authoritative --ansi
```

5. Generate the application key.

```bash
php artisan key:generate
```

6. Regenerate the caches.

```bash
./composer artisan-cache
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

Updating the platform can be done in a simple way with the `./composer deploy` command executed by the user who manages that project (usually `www-data`).

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

Screenshots are in english, you can change the system language to spanish.

![Screenshot from 2023-10-09 11-52-03](https://github.com/eusonlito/GPS-Tracker/assets/644551/5217b62a-aeba-4ba3-8926-624260091652)
![Screenshot from 2023-10-09 11-52-07](https://github.com/eusonlito/GPS-Tracker/assets/644551/80f396e0-59dd-4443-a109-65466308ca38)
![Screenshot from 2023-10-09 11-52-28](https://github.com/eusonlito/GPS-Tracker/assets/644551/9c44af72-f8e6-4aad-952b-2b437ea72bab)
![Screenshot from 2023-10-09 11-52-42](https://github.com/eusonlito/GPS-Tracker/assets/644551/f07c4e86-6ac4-4a57-81a4-bf5a019e80a8)
![Screenshot from 2023-10-09 11-52-53](https://github.com/eusonlito/GPS-Tracker/assets/644551/c622e8ec-38e9-4bf8-8cc5-1fc7193cfa4a)
![Screenshot from 2023-10-09 11-53-05](https://github.com/eusonlito/GPS-Tracker/assets/644551/2a653e10-4c74-4af6-8561-6082d5f7298e)
![Screenshot from 2023-10-09 11-53-12](https://github.com/eusonlito/GPS-Tracker/assets/644551/a50c96af-4e8e-4263-99bd-1eb395f5068a)
![Screenshot from 2023-10-09 11-53-25](https://github.com/eusonlito/GPS-Tracker/assets/644551/a4201b10-86b0-48e6-b3cd-6486e5c4fcba)
![Screenshot from 2023-10-09 11-53-31](https://github.com/eusonlito/GPS-Tracker/assets/644551/39338c5c-a7e0-40ae-89ae-2c99baceea05)
![Screenshot from 2023-10-09 11-53-37](https://github.com/eusonlito/GPS-Tracker/assets/644551/fac01e4a-6b87-44a9-8ccc-dc5971abdd4c)
![Screenshot from 2023-10-09 11-53-43](https://github.com/eusonlito/GPS-Tracker/assets/644551/9e69845a-dcd9-4f0c-9985-9659dc6640a2)
![Screenshot from 2023-10-09 11-53-46](https://github.com/eusonlito/GPS-Tracker/assets/644551/82e9eb54-8076-464c-aab8-5e49497577f5)
![Screenshot from 2023-10-09 11-53-50](https://github.com/eusonlito/GPS-Tracker/assets/644551/c06fc928-bc33-4a8c-9ea7-ccd1216f3450)
![Screenshot from 2023-10-09 11-54-01](https://github.com/eusonlito/GPS-Tracker/assets/644551/edb4f4bc-2e20-4f6b-99b6-738ea9e58adc)
![Screenshot from 2023-10-09 11-54-29](https://github.com/eusonlito/GPS-Tracker/assets/644551/3b1b49d0-058c-46d3-afcf-fe41167325a0)
![Screenshot from 2023-10-09 11-54-35](https://github.com/eusonlito/GPS-Tracker/assets/644551/801510b1-6707-45a8-abef-296b0ab94b65)
![Screenshot from 2023-10-09 11-54-45](https://github.com/eusonlito/GPS-Tracker/assets/644551/9a63b9b2-b8ac-4939-b2de-10e8a294fddd)
![Screenshot from 2023-10-09 11-54-49](https://github.com/eusonlito/GPS-Tracker/assets/644551/faff6659-1650-41e1-a95e-e9f97b88bbad)
![screencapture-tracker-local-lan-alarm-10-2023-10-09-11_55_02](https://github.com/eusonlito/GPS-Tracker/assets/644551/9a39f858-6a11-40c0-84ef-f6a86f7d5208)
![Screenshot from 2023-10-09 11-55-24](https://github.com/eusonlito/GPS-Tracker/assets/644551/2c2bca9c-2560-44a9-8eec-c202be156033)
![Screenshot from 2023-10-09 11-55-35](https://github.com/eusonlito/GPS-Tracker/assets/644551/43acdb70-e1fb-4ede-95e0-b88caf0385d2)
![Screenshot from 2023-10-09 11-55-42](https://github.com/eusonlito/GPS-Tracker/assets/644551/2aab9135-f08c-402e-9db8-4445a85ee48a)
![Screenshot from 2023-10-09 11-55-47](https://github.com/eusonlito/GPS-Tracker/assets/644551/49710f8f-95f1-4ff2-87c0-36a6c0cffef9)
![Screenshot from 2023-10-09 11-56-00](https://github.com/eusonlito/GPS-Tracker/assets/644551/5346a6e4-b3c4-4f4e-89b1-6b064805a3e5)
![Screenshot from 2023-10-09 11-57-15](https://github.com/eusonlito/GPS-Tracker/assets/644551/89fe034a-e912-4f57-8982-8f75786fb4b2)
![Screenshot from 2023-10-23 11-39-12](https://github.com/eusonlito/GPS-Tracker/assets/644551/f7214971-adcd-4b4b-8090-4c62fd3bde3e)
![Screenshot from 2023-10-09 11-57-24](https://github.com/eusonlito/GPS-Tracker/assets/644551/0bd15163-6717-4a98-87dc-b3968dd16012)
![Screenshot from 2023-10-09 11-57-31](https://github.com/eusonlito/GPS-Tracker/assets/644551/de2130b4-1ae7-4d58-afa3-f7eb064d88c6)
![Screenshot from 2023-10-09 11-57-36](https://github.com/eusonlito/GPS-Tracker/assets/644551/c79a6dff-4729-46fe-8be0-5a8ef0c83c4f)
![Screenshot from 2023-10-09 11-58-26](https://github.com/eusonlito/GPS-Tracker/assets/644551/8c3aa719-ea30-4da3-ae3d-aec8ee09aed4)
![Screenshot from 2023-10-09 11-58-58](https://github.com/eusonlito/GPS-Tracker/assets/644551/b4f24a03-726a-4e33-80bd-882ff79a0e68)
