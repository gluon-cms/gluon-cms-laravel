# THIS IS GLUON CMS 

Gluon CMS is based on SQL, Laravel and VueJS. 
It provide an unified SQL data model for all your CMS needs.

## First installation

* git clone
* composer install
* npm install
* cp .env.exemple .env
* configure stuffs in your .env (DB_* especially)
* create your local database
* php artisan migrate
* php artisan db:seed
* php artisan key:generate

## Developpement

* npm run watch
* php artisan serve (or configure your local server)

## Deployement

* npm run prod

