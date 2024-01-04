[Castellano](README.es.md)

<p align="center">
    <img src="https://github.com/eusonlito/GPS-Tracker/assets/644551/ef440878-fde8-4ec0-95db-c28e968f3249">
</p>

# GPS Tracker (Laravel 10 + PHP 8.1 + MySQL 8)

Open source GPS device management platform developed using Laravel 10, PHP 8.1 and MySQL 8. This comprehensive GPS tracking solution is designed to offer robust performance and an intuitive user interface, suitable for both individual users and companies that need to manage multiple tracking devices. This platform is intended as a possible simple alternative to [Traccar](https://github.com/traccar/traccar).

### Supported Devices

* **Sinotrack**: Confirmed ST-90X models using the Sinotrack protocol.
* **Coban**: TK303G model confirmed using GP103 protocol.
* **Concox** and **JimiLab**: JM-LL01 model confirmed via GT06 protocol.
* **Queclink**: Confirmed model GV500MA using Queclink protocol.
* **OsmAnd**: Using HTTP OsmAnd protocol.

### Features

* **Modern platform with user-friendly interface:** The platform uses Laravel 10 to provide a smooth user experience and an attractive graphical interface.
* **PHP 8.1 compatibility:** Leverages the latest features of PHP 8.1, including performance and security enhancements. It is also compatible with higher versions of PHP.
* **Data Management with MySQL 8:** Uses MySQL 8.0.12 or higher for efficient and secure management of large volumes of tracking data, as well as extensive support for GIS functionality.
* **Real-Time Tracking:** Allows users to track the location and status of their Sinotrack ST-90x devices in real time.
* **Detailed Reporting:** Generates comprehensive reports that aid in decision making and data analysis.
* **Alarms and Notifications:** Configure custom alarms (geofence, motion, speed, etc...) for specific events related to the tracking devices. Notifications can be configured via Telegram.
* **Multi-User Support:** Supports the creation of multiple user accounts with different levels of access and permissions.
* **Public Environment:** If you wish you can generate links for individual trips and share them publicly. You can also directly share a device where all its trips will be publicly visible.

### Requirements

- PHP 8.1 or higher (bcmath bz2 intl mbstring opcache pdo_mysql pcntl redis sockets xsl zip)
- MySQL 8.0.12 or higher
- Redis

### Demo

You can test the demo version at https://tracker-demo.lito.com.es/

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
* * * * * cd /var/www/tracker.domain.com && install -d storage/logs/artisan/$(date +"\%Y/\%m/\%d") && /usr/bin/php artisan schedule:run >> storage/logs/artisan/$(date +"\%Y/\%m/\%d")/schedule-run.log 2>&1
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

### Initial Configuration

1. By default a server is created for protocol `H02` (Sinotrack) on port `8091`. If you wish you can customize this configuration in `Servers` > `List`.
2. In `Servers` > `Status`, we select the server we just created and press the `Start/Restart` button.
3. The server should appear started in the upper listing of `Servers` > `Status`.
4. If the server does not start, we can check the logs generated in the `laravel` folder from the `Servers` > `Logs` menu.
5. Now we can create a vehicle in `Vehicles` > `Create`. We fill in the necessary fields and save it.
6. Once we have a vehicle, we go to create a device from `Devices` > `List` > `Create`. It is important to correctly indicate the `Serial Number` as it is the identifier that the device will send to the server and by which it can be recognized. We associate it with the vehicle we just created and save.
7. From here, we only have to wait to receive the first connections from the device to generate the first trips.
8. To configure the connection to our server for a Sinotrack device, follow the steps below.
9. If you have problems receiving the connection from the device you can go to `Servers` > `List` > `Edit` and enable debug mode. Once the change is saved remember to restart the server in `Servers` > `Status`.

### Device connection

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

![screencapture-tracker-2023-11-22-09_36_09](https://github.com/eusonlito/GPS-Tracker/assets/644551/103bb4d5-34c0-4677-9a6f-4137060293ee)
![screencapture-tracker-2023-11-22-09_36_27](https://github.com/eusonlito/GPS-Tracker/assets/644551/87afab20-4522-42ec-9bc1-12c7955feab4)
![screencapture-tracker-trip-2023-11-22-09_36_37](https://github.com/eusonlito/GPS-Tracker/assets/644551/90e94c47-cfad-4a76-9c49-95bf6330f312)
![screencapture-tracker-trip-59-2023-11-22-09_37_23](https://github.com/eusonlito/GPS-Tracker/assets/644551/48314ef5-a983-493d-8331-7f455b6d04aa)
![screencapture-tracker-trip-59-stat-2023-11-22-09_37_30](https://github.com/eusonlito/GPS-Tracker/assets/644551/b0231c9c-c94a-4f92-bebe-42946f92876b)
![screencapture-tracker-trip-59-map-2023-11-22-09_37_38](https://github.com/eusonlito/GPS-Tracker/assets/644551/f236c92f-1543-4f11-a0d9-1b2a52b6f5ba)
![screencapture-tracker-trip-59-position-2023-11-22-09_37_47](https://github.com/eusonlito/GPS-Tracker/assets/644551/f96b1d3d-2dd9-4fb2-9e1d-6f9fc6c03b8a)
![screencapture-tracker-trip-59-merge-2023-11-22-09_37_54](https://github.com/eusonlito/GPS-Tracker/assets/644551/17569986-27d1-489a-8229-56a3f7968d18)
![screencapture-tracker-refuel-2023-11-22-09_38_13](https://github.com/eusonlito/GPS-Tracker/assets/644551/d3dfb646-58f8-421c-ba3c-f1b9f9f07720)
![screencapture-tracker-refuel-58-2023-11-22-09_38_20](https://github.com/eusonlito/GPS-Tracker/assets/644551/8c8fa9d9-d865-4eea-ba72-107ea11edd19)
![screencapture-tracker-maintenance-2023-11-22-09_38_25](https://github.com/eusonlito/GPS-Tracker/assets/644551/cf479211-852b-42da-90f3-f829d5d6e063)
![screencapture-tracker-maintenance-2-2023-11-22-09_38_30](https://github.com/eusonlito/GPS-Tracker/assets/644551/14b1fe07-2e8b-4741-8d4b-eb27542eedc1)
![screencapture-tracker-maintenance-2-item-2023-11-22-09_38_35](https://github.com/eusonlito/GPS-Tracker/assets/644551/ae2f18d6-2489-44ff-afe3-37e0c9ebb68a)
![screencapture-tracker-maintenance-item-2023-11-22-09_38_40](https://github.com/eusonlito/GPS-Tracker/assets/644551/ae377753-53be-42db-bbd2-d8fddceaf6f1)
![screencapture-tracker-vehicle-2023-11-22-09_38_45](https://github.com/eusonlito/GPS-Tracker/assets/644551/e68bcb6e-8f16-4e5a-bffb-56670c6af33e)
![screencapture-tracker-vehicle-1-2023-11-22-09_38_50](https://github.com/eusonlito/GPS-Tracker/assets/644551/f8236e28-03bf-44f3-8131-48e9d2bf72b9)
![screencapture-tracker-vehicle-1-device-2023-11-22-09_38_56](https://github.com/eusonlito/GPS-Tracker/assets/644551/854f2f77-d673-4625-9db5-8c4222024c08)
![screencapture-tracker-vehicle-1-alarm-2023-11-22-09_39_02](https://github.com/eusonlito/GPS-Tracker/assets/644551/bc53f72e-77d5-425f-b68b-1308130b047e)
![screencapture-tracker-device-2023-11-22-09_39_08](https://github.com/eusonlito/GPS-Tracker/assets/644551/116a55df-b42c-47af-847a-a7985ed20198)
![screencapture-tracker-device-1-2023-11-22-09_39_13](https://github.com/eusonlito/GPS-Tracker/assets/644551/ac13ba33-9c8d-496f-b45e-84d61f1a5d9a)
![screencapture-tracker-device-1-transfer-2023-11-22-09_39_20](https://github.com/eusonlito/GPS-Tracker/assets/644551/a04b16d2-62d4-482a-aa6a-031c4dd55d21)
![screencapture-tracker-device-map-2023-11-22-09_39_30](https://github.com/eusonlito/GPS-Tracker/assets/644551/3b465e6c-9202-425b-b3c3-1f4d936928e2)
![screencapture-tracker-alarm-2023-11-22-09_39_36](https://github.com/eusonlito/GPS-Tracker/assets/644551/7250076c-87ee-4e65-9d39-703bc8b0b086)
![screencapture-tracker-alarm-2-2023-11-22-09_39_42](https://github.com/eusonlito/GPS-Tracker/assets/644551/56ebbcb8-cd6e-47a5-82da-fd476828d65a)
![screencapture-tracker-alarm-create-2023-11-22-09_40_33](https://github.com/eusonlito/GPS-Tracker/assets/644551/c675bf1c-ba39-496c-a157-e7bb0d35e3c4)
![screencapture-tracker-profile-2023-11-22-09_40_39](https://github.com/eusonlito/GPS-Tracker/assets/644551/fb9ade96-11c5-4617-9e37-c9e09c914674)
![screencapture-tracker-configuration-2023-11-22-09_40_49](https://github.com/eusonlito/GPS-Tracker/assets/644551/419c8fbe-83ef-4edd-a14a-896c983cf0a4)
![screencapture-tracker-user-2023-11-22-09_40_55](https://github.com/eusonlito/GPS-Tracker/assets/644551/7fb8c18b-6947-4678-8738-f930eedb8d14)
![screencapture-tracker-user-1-2023-11-22-09_41_03](https://github.com/eusonlito/GPS-Tracker/assets/644551/23d3627e-5ccb-4ffc-90c6-126ba75609a6)
![screencapture-tracker-user-session-2023-11-22-09_41_09](https://github.com/eusonlito/GPS-Tracker/assets/644551/e57d91d0-acb7-4c0f-9109-ba7781875791)
![screencapture-tracker-server-status-2023-11-22-09_41_58](https://github.com/eusonlito/GPS-Tracker/assets/644551/0cb22188-d583-4bdf-b805-4d4254e4b887)
![screencapture-tracker-server-1-2023-11-22-09_42_07](https://github.com/eusonlito/GPS-Tracker/assets/644551/4f77ee90-051a-4e59-81d0-9451f592c00c)
![screencapture-tracker-server-log-2023-11-22-09_42_13](https://github.com/eusonlito/GPS-Tracker/assets/644551/6e32a9de-97ce-44e3-acb2-1702db290157)
![screencapture-tracker-timezone-2023-11-22-09_42_22](https://github.com/eusonlito/GPS-Tracker/assets/644551/35dec451-fea1-4734-a28c-c70a7dc13be0)
![screencapture-tracker-shared-trip-11da6b7b-88bd-11ee-b488-4cedfbcaec68-2023-11-22-09_42_50](https://github.com/eusonlito/GPS-Tracker/assets/644551/5f5e2fcc-1b33-48cb-b62d-1e5cfebde6c9)
![screencapture-tracker-shared-device-066b1953-88bd-11ee-b488-4cedfbcaec68-2023-11-22-09_42_57](https://github.com/eusonlito/GPS-Tracker/assets/644551/f0be5f69-0a8e-40c4-9e8d-72f6cb828ec7)

