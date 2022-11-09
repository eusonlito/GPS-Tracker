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
