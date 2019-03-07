# PHP/ Lumen API

This project contains the source code for  PHP web API developed using the Lumen framework. Dependencies are managed with Composer.

## Usage

### Running this project locally

Install dependencies

```shell
composer update
```

Create and migrate the database

```shell
php artisan migrate
```

Serve the project locally

```shell
php -S localhost:8000 -t public
```

### Developing new features

Generate a migration for the project's database

```shell
php artisan make:migration create_or_update_table --table-some_table
```