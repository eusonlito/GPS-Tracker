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

![Screenshot from 2022-10-31 09-37-46](https://user-images.githubusercontent.com/644551/198966515-1afb7ac3-b2a6-428a-b65d-a9eacff35ded.png)

![Screenshot from 2022-10-31 09-38-26](https://user-images.githubusercontent.com/644551/198966533-961ca22c-832a-4bd6-a176-d78b060c9d3e.png)

![Screenshot from 2022-10-18 18-31-10](https://user-images.githubusercontent.com/644551/196489823-7ef35c1d-4c88-49dd-b0b7-e50a24b7beb2.png)

![Screenshot from 2022-10-18 18-31-21](https://user-images.githubusercontent.com/644551/196489866-e1b89302-1558-41ef-89a2-02a3f335ec17.png)

![Screenshot from 2022-10-18 18-31-27](https://user-images.githubusercontent.com/644551/196489891-2f3a81a8-b788-44e1-bb9e-1457bcba92ba.png)

![Screenshot from 2022-10-18 18-30-06](https://user-images.githubusercontent.com/644551/196489713-969ffb72-a864-434e-8533-afc87e700582.png)

![Screenshot from 2022-10-18 18-30-15](https://user-images.githubusercontent.com/644551/196489740-b71e0042-51e9-4038-9a6d-03d5bf8180ac.png)

![Screenshot from 2022-10-18 18-30-37](https://user-images.githubusercontent.com/644551/196489787-6f570213-6e4b-444d-979b-62bdf0625582.png)
