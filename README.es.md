[English](README.md)

<p align="center">
    <img src="https://github.com/eusonlito/GPS-Tracker/assets/644551/ef440878-fde8-4ec0-95db-c28e968f3249">
</p>

# GPS Tracker (Laravel 10 + PHP 8.1 + MySQL 8)

Plataforma de código abierto para la gestión para dispositivos GPS desarrollada utilizando Laravel 10, PHP 8.1 y MySQL 8. Esta solución integral de rastreo GPS está diseñada para ofrecer un rendimiento robusto y una interfaz de usuario intuitiva, adecuada tanto para usuarios individuales como para empresas que necesitan gestionar múltiples dispositivos de rastreo. Esta plataforma está pensada como una posible alternativa sencilla a [Traccar](https://github.com/traccar/traccar).

### Dispositivos Soportados

* **Sinotrack**: Confirmados los modelos ST-90X mediante el protocolo Sinotrack.
* **Coban**: Confirmado el modelo TK303G mediante el protocolo GP103.
* **Concox** y **JimiLab**: Confirmado el modelo JM-LL01 mediante el protocolo GT06.
* **Queclink**: Confirmado el modelo GV500MA mediante el protocolo Queclink.
* **OsmAnd**: Mediante el protocolo HTTP OsmAnd.

### Características Clave

* **Plataforma moderna con interface amigable:** La plataforma utiliza Laravel 10 para proporcionar una experiencia de usuario fluida y una interfaz gráfica atractiva.
* **Compatibilidad con PHP 8.1:** Aprovecha las últimas características de PHP 8.1, incluyendo mejoras en el rendimiento y seguridad. También es compatible con las versiones superiores de PHP.
* **Gestión de Datos con MySQL 8:** Utiliza MySQL 8.0.12 o superior para una gestión eficiente y segura de grandes volúmenes de datos de rastreo, así como una amplio soporte de funcionalidades GIS.
* **Seguimiento en Tiempo Real:** Permite a los usuarios seguir la ubicación y el estado de sus dispositivos Sinotrack ST-90x en tiempo real.
* **Informes Detallados:** Genera informes completos que ayudan en la toma de decisiones y en el análisis de datos.
* **Alarmas y Notificaciones:** Configura alarmas personalizadas (geovalla, movimiento, velocidad, etc...) para eventos específicos relacionados con los dispositivos de rastreo. Las notificaciones se pueden configurar a través de Telegram.
* **Soporte Multiusuario:** Admite la creación de múltiples cuentas de usuario con diferentes niveles de acceso y permisos.
* **Entorno Público:** Si lo deseas puedes generar enlaces para viajes individuales y compartirlos públicamente. También puedes compartir directamente un dispositivo donde todos sus viajes serán visibles de forma pública.

### Requisitos

- PHP 8.1 o superior (bcmath bz2 intl mbstring opcache pdo_mysql pcntl redis sockets xsl zip)
- MySQL 8.0.12 o superior
- Redis

### Demo

Puedes probar la versión de demostración en https://tracker-demo.lito.com.es/

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

4. Realizamos la primera instalación (recuerda que siempre usando el binario de PHP 8.1 o superior).

```bash
./composer install --no-dev --optimize-autoloader --classmap-authoritative --ansi
```

5. Generamos la clave de aplicación.

```bash
php artisan key:generate
```

6. Regeneramos las cachés.

```bash
./composer artisan-cache
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

La actualización de la plataforma se puede realizar de manera sencilla con el comando `./composer deploy` ejecutado por el usuario que gestiona ese projecto (normalmente `www-data`).

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

### Configuración Inicial

1. Por defecto se crea un servidor para el protocolo `H02` (Sinotrack) en el puerto `8091`. Si lo deseas puedes personalizar esta configuración en `Servidores` > `Lista`.
2. En `Servidores` > `Estado` Seleccionamos el servidor que acabamos de crear y pulsamos el botón de `Iniciar/Reiniciar`.
3. Se servidor debería aparecer iniciado en el listado superior de `Servidores` > `Estado`.
4. Si el servidor no se inicia, podemos revisar los logs generados en la carpeta `laravel` del menú `Servidores` > `Logs`.
5. Ahora podemos crear un vehículo en `Vehículos` > `Crear`. Rellenamos los campos necesarios y lo guardamos.
6. Una vez disponemos de vehículo vamos a crear un dispositivo desde `Dispositivos` > `Lista` > `Crear`. Es importante indicar correctamente el `Número de Serie` ya que es el identificador que enviará el dispositivo al servidor y con el que podrá ser reconocido. Le asociamos el vehículo que acabamos de crear y guardamos.
7. A partir de aquí sólo queda esperar a recibir las primeras conexiones desde el dispositivo para generar los primeros viajes.
8. Para configurar la conexión a nuestro servidor un dipositivo Sinotrack sigue los pasos indicados a continuación.
9. Si tienes problemas para recibir la conexión desde el dispositivo puedes ir a `Servidores` > `Lista` > `Editar` y activar el modo debug. Una vez guardado el cambio recuerda reiniciar el servidor en `Servidores` > `Estado`.

### Conexión del Dispositivo

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
