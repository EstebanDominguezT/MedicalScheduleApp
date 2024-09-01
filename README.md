<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Proceso de instalacion del poyecto
### 1. Duplicar el archivo `.env.example`
Duplica el archivo `.env.example` y ajusta las configuraciones según sea necesario para tu entorno. Puedes copiarlo y nombrarlo como `.env`, por ejemplo
Ejemplo: `cp .env.example .env`
Ejemplo de configuracion:
```DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=medicalschedulerdbdev
DB_USERNAME=postgres
DB_PASSWORD=admin
```
### 2. Instalar las dependencias
Ejecuta el siguiente comando para instalar las dependencias del proyecto
```bash
composer install
```
### 3. Generar la llave de la aplicacion
Ejecuta el siguiente comando para generar la llave de la aplicacion
```bash
php artisan key:generate
```
### 4. Genera la llave secreta de JWT
Ejecuta el siguiente comando para generar la llave secreta de JWT
```bash
php artisan jwt:secret
```

### 5. Ejecutar las migraciones
Ejecuta el siguiente comando para ejecutar las migraciones
```bash
php artisan migrate
```
### 6. Ejecutar los seeders
Ejecuta el siguiente comando para ejecutar los seeders
```bash
php artisan db:seed
```
### 7. Instala dependencias de node
Ejecuta el siguiente comando para instalar las dependencias de node
```bash
npm install
```
### 8. Compilar los assets
Ejecuta el siguiente comando para compilar los assets
```bash
npm run dev
```
### 9. Iniciar el servidor
Ejecuta el siguiente comando para iniciar el servidor
```bash
php artisan serve
```
### 10. Acceder a la aplicacion
Accede a la aplicacion en tu navegador con la siguiente url
```bash
http://127.0.0.1:8000
```
### 11. Acceso como administrador
Para acceder como administrador puedes utilizar las siguientes credenciales
```bash
email: estebantalavera17@gmail.com
password: esteband1
```
Para acceder como doctor puedes utilizar las siguientes credenciales
```bash
email: mariaelena.gonzalez@example.com
password: 123456!
```
Para acceder como paciente puedes utilizar las siguientes credenciales
```bash
email: javierantonio.perez@example.com
password: 123456!
```
### 12. La coleccion postman se encuentra en la raiz del proyecto con el nombre `MedicalScheduler.postman_collection.json`

## Gracias por la oportunidad de poder demostrar un poco de mis conocimientos!!