<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Resumen

El juego consta de una tirada de dos dados. Si la suma de ambos dados es igual a 7, el jugador gana. De lo contrario pierde.

Este proyecto es una API REST creada con Laravel. Utiliza Passport y Spatie para la autenticación y la gestión de roles, respectivamente, garantizando la seguridad. Passport permite la autenticación de API mediante OAuth2, mientras que Spatie asigna roles a los usuarios y controla el acceso a las funcionalidades.

Ademas, se ha intentado mantener el principio de responsabilidad única, asignando a cada parte del código una tarea específica. Además, se han realizado “commits atómicos”, cambios pequeños y autocontenidos, para mantener un historial de cambios claro y facilitar la detección y corrección de errores. Estas prácticas mejoran la calidad del código y la eficiencia del desarrollo.


## Requerimientos

- PHP >= 7.4
- Composer >= 2.6.5
- Laravel/Framework ^10.10
- Laravel/Passport ^11.10
- Spatie/Laravel-Permission ^6.1

## Configuración e Instalación

1. Clonar el repositorio: `git clone https://github.com/PatriPomes/Juego.git`
2. Instalar las dependencias: `composer install`
3. Configurar el archivo .env con las credenciales de la base de datos.
4. Ejecutar las migraciones: `php artisan migrate`
5. Generar las claves de Passport: `php artisan passport:install`
6. No olvides tambien crear un cliente con Passport: 'php artisan passport:client --personal'
7. Vuelve a configurar el archivo .env con tu 'cliente personal de passport'
8. Iniciar el servidor de desarrollo: `php artisan serve`

## Cómo jugar?

Para jugar debes registrarte como usuario, introduciento un nombre, email y password. El nombre y el mail han de ser únicos. Por defecto se te asignara el role de Jugador.
Posteriormente deberas realizar un login para acceder. El registro solo es una única vez.
Todo jugador puede:
- Actualizar sus datos.
- Realizar tantas tirada como desee.
- Borrar sus tiradas. 
- Ver los resultados de todas sus tiradas.
- Ver el ranking total del juego.

Todo administrador puede:
- Crear otros administradores.
- Actualizar sus datos.
- Consultar el mejor y peor jugador.
- Ver el ranking total del juego.
- Ver el porcentaje medio de exito de todos los jugadores.

## Licencia

El framework Laravel es un software de código abierto con licencia MIT.
