# PHP/ Lumen API

This project contains the source code for  PHP web API developed using the Lumen framework. Dependencies are managed with Composer.

## Usage

### Running this project locally

Download the project

```shell
git clone https://github.com/seanpierce/lumen-api
```

Install dependencies

```shell
# either
composer update
# or if that doesnt work
composer install
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

In your browser, navigate to the project via your server's localhost port: http://localhost:8888/lumen-api/

#### Serve the projet locally using php's built-in web server

```shell
# from the public directory (default configuration)
php -S localhost:8000 -t public
# from the root directory
php -S localhost:8000
```

In your browser, navigate to: http://localhost:8000/

### Developing new features

Generate a migration for the project's database

```shell
php artisan make:migration create_or_update_table --table=some_table
```