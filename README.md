# GPS Tracker (Laravel 9 + PHP 8.1 + MySQL 8)

Plataforma de gestión de dispositivos Sinotrack ST-90x creada con Laravel 9 + PHP 8.1 y MySQL 8.

### Instalación

1. Creamos la base de datos en MySQL.

2. Clonamos el repositorio.

```bash
git clone https://github.com/eusonlito/GPS-Tracker.git
```

3. Realizamos la primera instalación (recuerda que siempre usando el binario de PHP 8.0).

```bash
composer install --no-scripts --no-dev
composer install --no-dev --optimize-autoloader --classmap-authoritative
```

4. Configuramos el fichero `.env` con los datos necesarios.

```bash
cp .env.example .env
```

5. Generamos la clave de aplicación. Recuerda guardar una copia de seguridad de esta clave (`.env` > `APP_KEY`).

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

9. Configuramos la tarea cron para el usuario relacionado con el proyecto:

```
* * * * * cd /var/www/tracker.domain.com && install -d storage/logs/artisan/$(date +"\%Y-\%m-\%d") && /usr/bin/php artisan schedule:run >> storage/logs/artisan/$(date +"\%Y-\%m-\%d")/schedule-run.log 2>&1
```

10. Creamos el usuario principal.

```bash
php artisan user:create --email=user@domain.com --name=Admin --password=StrongPassword2 --enabled --admin
```

11. Configuramos el servidor para acceso web con `DOCUMENT_ROOT` en `public`.

12. Profit!

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
