[English](README.md)

# GPS Tracker (Laravel 10 + PHP 8.1 + MySQL 8)

Plataforma de gestión de dispositivos Sinotrack ST-90x creada con Laravel 10 + PHP 8.1 y MySQL 8.

### Requisitos

- PHP 8.1 o superior (bcmath bz2 intl mbstring opcache pdo_mysql pcntl redis sockets xsl zip)
- MySQL 8.0.12 o superior
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

1. En `Servidores` > `Lista` > `Crear` damos de alta un servidor en el puerto de conexión que desees (Se recomienda a partir del 8090).
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
