# api.mississippirecords.net

> As hackneyed and precious as it may be interpreted, we actually believe that records can be  powerful hoodoo totemistic and utilitarian objects that can further the development of culture, revolution and spirituality. They can be more than just cultural commodities.  
– Eric Isaacson, Mississippi Records

This project contains the source code for  PHP web API developed using the [Lumen](https://lumen.laravel.com/) framework with the [Eloquent](https://laravel.com/docs/5.0/eloquent) ORM. Dependencies are managed using [Composer](https://getcomposer.org/).

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

Seed the database with placeholder data

```shell
php artisan db:seed
```

#### Serve the project locally via MAMP or WAMP

Move this project to the root of your server's directory

```shell
mv api.mississippirecords.net ~/Sites/api.mississippirecords.net
```

In your browser, navigate to the project via your server's localhost port: [http://localhost:8888/api.mississippirecords.net/](http://localhost:8888/api.mississippirecords.net/)

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

---

### Why keep this repo public?

Besides being a staunch open-source advocate, it's important for me to keep a public-facing document of my progress with new (to me) technologies. It leads me to be more responsible with my development, and write cleaner code. Additionally, I aim to follow the [OWASP](https://www.owasp.org/) principal which encourages organizations to "[avoid security by obscurity](https://www.owasp.org/index.php/Avoid_security_by_obscurity)".
