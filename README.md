# Beat The Weather

## Challenge

Create a service, which returns product recommendations depending on current weather.

## Used technologies

Laravel 6.11, MySQL

## Setup guide

### Clone repo

### Change to directory

````
cd Beat-The-Weather
````   

### Install dependencies

````
composer install
````

### Copy .env file

```
cp .env.example .env
```

### Modify `DB_*` value in `.env` with your database config.

### Generate application key:

````
php artisan key:generate
````

### Migrate

````
php artisan migrate
````

### Seed database

````
php artisan db:seed
````

## Usage examples

Change city in the url:
`api/products/recommended/{city}`

Like this:
`api/products/recommended/Kaunas`