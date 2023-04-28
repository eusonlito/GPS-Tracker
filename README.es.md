[English](README.md)

# GPS Tracker (Laravel 10 + PHP 8.1 + MySQL 8)

Plataforma de gestión de dispositivos Sinotrack ST-90x creada con Laravel 10 + PHP 8.1 y MySQL 8.

### Requisitos

- PHP 8.1 o superior (bcmath bz2 intl mbstring opcache pdo_mysql pcntl redis sockets xsl zip)
- MySQL 8.0
- Redis

### Instalación Local

1. Creamos la base de datos en MySQL.

2. Clonamos el repositorio.

```bash
git clone https://github.com/eusonlito/GPS-Tracker.git
```

3. Copia el fichero `.env.example` como `.env` y rellena las variables necesarias.

```bash
cp .env.example .env
```

4. Realizamos la primera instalación (recuerda que siempre usando el binario de PHP 8.1).

```bash
composer install --no-dev --optimize-autoloader --classmap-authoritative --ansi
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

#### Actualización

La actualización de la plataforma se puede realizar de manera sencilla con el comando `composer deploy` ejecutado por el usuario que gestiona ese projecto (normalmente `www-data`).

### Instalación vía Docker

1. Clonamos el repositorio.

```bash
git clone https://github.com/eusonlito/GPS-Tracker.git
```

2. [OPCIONAL] Copia el fichero `docker/.env.example` en `.env` y configura tus propios ajustes

```bash
cp docker/.env.example .env
```

3. [OPCIONAL] Copia el fichero `docker/docker-compose.yml.example` en `docker/docker-compose.yml` y configura tus propios ajustes

```bash
cp docker/docker-compose.yml.example docker/docker-compose.yml
```

4. Realizamos el build (pedirá la contraseña de sudo)

```bash
./docker/build.sh
```

5. Iniciamos los contenedores (pedirá la contraseña de sudo)

```bash
./docker/run.sh
```

6. Creamos el usuario principal (pedirá la contraseña de sudo)

```bash
./docker/user.sh
```

7. Lanzamos el rellenado de los GeoJSON para las zonas horarias (pedirá la contraseña de sudo)

```bash
./docker/timezone-geojson.sh
```

8. Ya podemos acceder desde http://localhost:8080

9. Recuerda añadir un servidor web (apache2, nginx, etc...) como proxy para añadir funcionalidades como SSL.

10. Si vas añadir o cambiar los puertos por defecto para los dispositivos GPS (`8091`) debes editar las propiedades de `gpstracker-app` en `docker-compose.yml` para adaptarlas a tu propia configuración.

#### Actualización

1. Actualizamos el código del proyecto

```bash
git pull
```

2. Realizamos el build (pedirá la contraseña de sudo)

```bash
./docker/build.sh
```

3. Iniciamos los contenedores (pedirá la contraseña de sudo)

```bash
./docker/run.sh
```

4. Ya podemos acceder desde http://localhost:8080

### Conexión vía Socket

El puerto abierto para la conexión de dispositivos con protocolo H02 se realiza por defecto en el puerto `8091`, pero puede ser personalizado desde el panel de configuración (como administrador).

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
SLEEP{PASSWORD} {MINUTOS}
```

#### Activar llamadas de eventos (Batería baja, reporte diario, aviso grúa, salida geovalla, contacto, SOS)

```
150{PASSWORD}
```

#### Desactivar llamadas de eventos (Batería baja, reporte diario, aviso grúa, salida geovalla, contacto, SOS)

```
151{PASSWORD}
```

#### Activar SMS de Alarma de Batería baja

```
011{PASSWORD}
```

#### Desactivar SMS de Alarma de Batería baja

```
010{PASSWORD}
```

#### Activar SMS de Eventos (Batería baja, SLEEP, reporte diario, aviso grúa, salida geovalla, contacto)

```
712{PASSWORD}
```

#### Desactivar SMS de Eventos (Batería baja, SLEEP, reporte diario, aviso grúa, salida geovalla, contacto)

```
713{PASSWORD}
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

### Comandos

#### Alta de usuario:

```bash
php artisan user:create {--email=} {--name=} {--password=} {--enabled} {--admin}
```

#### Iniciar/Reiniciar todos los servidores configurados:

La opción de `reset` permite reiniciar el puerto en caso de que esté siendo usado.

```bash
php artisan server:start:all {--reset}
```

#### Iniciar/Reiniciar servidor en un puerto en concreto:

La opción de `reset` permite reiniciar el puerto en caso de que esté siendo usado.

```bash
php artisan server:start {--port=} {--reset}
```

### Capturas

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
