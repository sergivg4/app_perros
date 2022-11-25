# CRUD LARAVEL + VUE (SPA)

## Resumen

En esta aplicación disponemos de una tabla con información sobre distintas razas de perros, junto a ella hay tres botones, uno para ver más información sobre la raza, otro para editar dicha información y otro para eliminarlo.
En caso de querer añadir más razas de perros, se puede hacer con el formulario que hay bajo las tablas.

## Información importante

Importante, para que Laravel funcione correctamente en su versión 5.3, es necesario usar las versiones especificadas.

- Node v10
- npm v6
- PHP v7
- Composer
- Xamp / Lamp / Laragon
- Mysql / MariaDB

## Instalación

- Renombrar .env.example -> .env
- Crear BBDD y cambiar los siguientes parámetros en .env
	- DB_DATABASE= "nombre de la base de datos que se va a utilizar"
	- DB_USERNAME= "usuario de la base de datos"
	- DB_PASSWORD= "contraseña del usuario (si tene, sinó dejar en blanco)"
- npm i
- npm run prod
- composer install
- php artisan key:generate
- php artisan migrate
- php artisan db:seed
- php artisan serve
