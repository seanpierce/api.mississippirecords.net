# PHP/ Lumen API

This project contains the source code for  PHP web API developed using the Lumen framework with the Eloquent ORM. Dependencies are managed using Composer.

## Usage

### Running this project locally

Download the project

```shell
git clone https://github.com/seanpierce/api.mississippirecords.net
```

Install dependencies

```shell
composer update
```

Create a mysql database and add the connection info to the `.env` file in the projetc's root

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=lumenapidb
DB_USERNAME=root
DB_PASSWORD=root
```

```shell
php artisan migrate
```

Seed the database

```shell
php artisan db:seed
```

#### Serve the project locally via MAMP or WAMP

Move this project to the root of your server's directory

```shell
mv lumen-api ~/Sites/lumen-api
```

In your browser, navigate to the project via your server's localhost port: [http://localhost:8888/lumen-api/](http://localhost:8888/lumen-api/)

#### Serve the projet locally using php's built-in development server

```shell
# from the public directory (default configuration)
php -S localhost:8000 -t public
# from the root directory
php -S localhost:8000
```

In your browser, navigate to: [http://localhost:8000/](http://localhost:8000/)

### Developing new features

Generate a migration for the project's database

```shell
# Generate a migration for the project's database
php artisan make:migration create_some_table
# Specify a table to update with the "--table" flag
php artisan make:migration update_some_table --table=some_table
```

### Documentation

Download the latest postman docs/ API request and response data [here](https://www.getpostman.com/collections/80ed11f450a2ae156ba4).

### TODOs

* ~~Create and enable CORS midleware~~
* Establish Pilot subdomain
* Deploy API as a proof-of-concept
