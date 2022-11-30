[English](README.en.md)

# GPS Tracker (Laravel 9 + PHP 8.1 + MySQL 8)

Plataforma de gestión de dispositivos Sinotrack ST-90x creada con Laravel 9 + PHP 8.1 y MySQL 8.

### Instalación

1. Creamos la base de datos en MySQL.

2. Clonamos el repositorio.

```bash
git clone https://github.com/eusonlito/GPS-Tracker.git
```

3. Realizamos la primera instalación (recuerda que siempre usando el binario de PHP 8.1).

```bash
composer install --no-scripts --no-dev
composer install --no-dev --optimize-autoloader --classmap-authoritative
```

4. Configuramos el fichero `.env` con los datos necesarios.

```bash
cp .env.example .env
```

5. Generamos la clave de aplicación.

```bash
php artisan key:generate
```

6. Regeneramos las cachés.

```bash
composer artisan-cache
```

7. Lanzamos la migración inicial.

```bash
php artisan migrate --path=database/migrations
```

8. Lanzamos el seeder.

```bash
php artisan db:seed --class=Database\\Seeders\\Database
```

9. Generamos los GeoJSON para los Timezones.

```bash
php artisan timezone:geojson
```

10. Configuramos la tarea cron para el usuario relacionado con el proyecto:

```
* * * * * cd /var/www/tracker.domain.com && install -d storage/logs/artisan/$(date +"\%Y-\%m-\%d") && /usr/bin/php artisan schedule:run >> storage/logs/artisan/$(date +"\%Y-\%m-\%d")/schedule-run.log 2>&1
```

11. Creamos el usuario principal.

```bash
php artisan user:create --email=user@domain.com --name=Admin --password=StrongPassword2 --enabled --admin
```

12. Configuramos el `DocumentRoot` del servidor web para apuntar a `/var/www/project/public`.

13. Profit!

### Conexión vía Socket

El puerto abierto para la conexión de dispositivos con protocolo H02 se realiza por defecto en el puerto `8091`, pero puede ser personalizado cambiando el fichero `config/sockets.php`.

Para configurar tu dispositivo vía SMS puedes hacerlo con el siguiente comando:

```
804{PASSWORD} {IP/HOST} {PUERTO}
```

Puedes configurar el servidor de conexión en el dispositivo usando o bien la IP o bien un HOST que resolverá internamente PERO SÓLO EN EL MOMENTO DE RECIBIR EL COMANDO, con lo cual si el servidor no tiene IP fija en cuanto cambie dejarás de recibir los datos del dispositivo.

### SMS comunes para Sinotrack ST-901

#### Configurar el Teléfono desde el cual te puedes conectar al dispositivo

```
{TELEFONO}{PASSWORD} 1
```

#### Configurar la zona horaria para UTC y así delegar en la plataforma el ajuste horario

```
896{PASSWORD}E00
```

#### Activar Modo GPRS

```
710{PASSWORD}
```

#### Configurar APN Operadora

```
803{PASSWORD} {OPERADORA}
```

#### Configurar Servidor

```
804{PASSWORD} {IP/HOST} {PUERTO}
```

#### Configurar frecuencia en segundos de envío reportes de posición con el contacto puesto

```
805{PASSWORD} {SEGUNDOS}
```

#### Configurar frecuencia en segundos de envío reportes de posición SIN el contacto puesto

```
809{PASSWORD} {SEGUNDOS}
```

#### Configurar tiempo de espera antes de pasar a modo SLEEP con el coche parado

```
SLEEP{PASSWORD} {SEGUNDOS}
```

#### Desactivar llamada en caso de alarma

```
151{PASSWORD}
```

#### Cambiar Contraseña

```
777{PASSWORD-NEW}{PASSWORD-OLD}
```

#### Reiniciar dispositivo

```
RESTART
```

#### Mostrar configuración actual

```
RCONF
```

### Actualización de la Plataforma

La actualización de la plataforma se puede realizar de manera sencilla con el comando `composer deploy` ejecutado por el usuario que gestiona ese projecto (normalmente `www-data`).

Este comando realiza las siguientes acciones:

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

### Comandos

#### Alta de usuario:

```bash
php artisan user:create {--email=} {--name=} {--password=} {--enabled} {--admin}
```

#### Iniciar/Reiniciar todos los sockets configurados:

La opción de `reset` permite reiniciar el puerto en caso de que esté siendo usado.

```bash
php artisan socket:server:all {--reset}
```

#### Iniciar/Reiniciar socket en un puerto en concreto:

La opción de `reset` permite reiniciar el puerto en caso de que esté siendo usado.

```bash
php artisan socket:server {--port=} {--reset}
```

### Capturas

![screencapture-tracker-2022-11-30-10_55_47](https://user-images.githubusercontent.com/644551/204769144-5c679b26-fa9e-42eb-8d6f-11fcf9a63b49.png)

![screencapture-tracker-trip-2022-11-30-10_56_37](https://user-images.githubusercontent.com/644551/204769140-d2b57a0c-4ef1-4986-b3a8-9e1c49fe0c9d.png)

![screencapture-tracker-trip-193-map-2022-11-30-10_57_25](https://user-images.githubusercontent.com/644551/204769137-e1f6d120-02c8-4b56-9b83-1b095dd55f0d.png)

![screencapture-tracker-trip-193-position-2022-11-30-10_57_40](https://user-images.githubusercontent.com/644551/204769128-2a0a01aa-4857-4b90-bdd9-2813a3e63222.png)

![screencapture-tracker-trip-193-alarm-notification-2022-11-30-10_58_00](https://user-images.githubusercontent.com/644551/204769125-c873b5e5-9924-4d7c-b60a-4377e0fb53b8.png)

![screencapture-tracker-trip-193-merge-2022-11-30-10_58_10](https://user-images.githubusercontent.com/644551/204769123-c9996419-5064-4503-9a0e-8b5b7a560807.png)

![screencapture-tracker-refuel-2022-11-30-10_58_17](https://user-images.githubusercontent.com/644551/204769119-a60c1f65-e333-4ea5-b4af-c8a7ec9f94bc.png)

![screencapture-tracker-device-2022-11-30-10_58_38](https://user-images.githubusercontent.com/644551/204769118-083693b9-3143-45a5-9161-65f9a62f8ae7.png)

![screencapture-tracker-device-1-2022-11-30-10_59_00](https://user-images.githubusercontent.com/644551/204769116-14700fd3-8bd8-462d-be51-088ff98ded01.png)

![screencapture-tracker-device-1-alarm-2022-11-30-10_59_09](https://user-images.githubusercontent.com/644551/204769115-56c1ae24-2952-4ecf-9189-9bc01af891ad.png)

![screencapture-tracker-device-1-alarm-notification-2022-11-30-10_59_33](https://user-images.githubusercontent.com/644551/204769113-c60ec7f3-f5ba-4a1d-8303-9ef315c144eb.png)

![screencapture-tracker-device-1-device-message-2022-11-30-11_00_35](https://user-images.githubusercontent.com/644551/204769109-8815d715-e2d1-4c99-886e-093dbe0e38a9.png)

![screencapture-tracker-alarm-2022-11-30-11_00_46](https://user-images.githubusercontent.com/644551/204769107-46f7ab5f-50bb-4477-b8c7-cbf807dafec4.png)

![screencapture-tracker-alarm-7-2022-11-30-11_00_55](https://user-images.githubusercontent.com/644551/204769104-5687a3de-0395-405c-a857-40d2743b8ce7.png)

![screencapture-tracker-alarm-7-device-2022-11-30-11_01_10](https://user-images.githubusercontent.com/644551/204769101-07b0212b-321b-4ee3-a65d-5a62b1b49e1b.png)

![screencapture-tracker-alarm-7-alarm-notification-2022-11-30-11_01_19](https://user-images.githubusercontent.com/644551/204769100-255774e4-4ead-40b0-9c39-4ae900a65c23.png)

![screencapture-tracker-alarm-6-2022-11-30-11_01_35](https://user-images.githubusercontent.com/644551/204769097-286d0746-9cdb-4ad2-8130-af5b9a7e4f46.png)

![screencapture-tracker-alarm-notification-2022-11-30-11_01_44](https://user-images.githubusercontent.com/644551/204769093-0f6f57f7-a92f-4c05-9a77-aff969d161f1.png)

![screencapture-tracker-user-2022-11-30-11_03_54](https://user-images.githubusercontent.com/644551/204769089-6a9bdea8-04cc-4e80-91a0-08bc25114dda.png)

![screencapture-tracker-user-profile-2022-11-30-11_04_24](https://user-images.githubusercontent.com/644551/204769087-368e017d-29f0-435c-91a4-e6faa0493253.png)

![screencapture-tracker-user-profile-telegram-2022-11-30-11_04_41](https://user-images.githubusercontent.com/644551/204769083-6492d09c-aa51-4b40-8057-1d54d885148c.png)

![screencapture-tracker-configuration-2022-11-30-11_04_55](https://user-images.githubusercontent.com/644551/204769082-3504baf6-2fc9-4cc1-8fb8-6c2e72dbb8aa.png)

![screencapture-tracker-socket-2022-11-30-11_05_44](https://user-images.githubusercontent.com/644551/204769078-8a778a4c-c733-4335-858c-0ba19c0c8c05.png)

![screencapture-tracker-server-log-2022-11-30-11_05_51](https://user-images.githubusercontent.com/644551/204769076-9eae1eb3-717c-4865-918b-a1d2a29c2c28.png)

![screencapture-tracker-timezone-2022-11-30-11_05_58](https://user-images.githubusercontent.com/644551/204769071-3207bce1-8178-48d6-9587-d3991c53d93e.png)


