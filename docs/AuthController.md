# Laravel Documentation
=========================

## Table of Contents
-----------------

1. [Introduction](#introduction)
2. [Installation](#installation)
3. [Project Structure](#project-structure)
4. [Routing](#routing)
5. [Controllers](#controllers)
6. [Models](#models)
7. [Views](#views)
8. [Database](#database)
9. [Migrations](#migrations)
10. [Seeding](#seeding)
11. [Authentication](#authentication)
12. [Authorization](#authorization)
13. [Caching](#caching)
14. [Debugging](#debugging)

## Introduction
-------------

Laravel is a free, open-source PHP web framework, intended for the development of web applications following the model–view–controller (MVC) architectural pattern.

### Features

*   **Modular**: Laravel is built on top of the Symfony framework, making it highly modular and flexible.
*   **MVC Architecture**: Laravel follows the Model-View-Controller (MVC) pattern, separating the application logic into three interconnected components.
*   **Eloquent ORM**: Laravel includes a powerful Object-Relational Mapping (ORM) system called Eloquent, which simplifies database interactions.
*   **Blade Templating Engine**: Laravel comes with a powerful templating engine called Blade, which allows for easy and efficient view rendering.

## Installation
--------------

To install Laravel, follow these steps:

### Step 1: Install Composer

First, you need to install Composer, the PHP package manager.

```bash
curl -sS https://getcomposer.org/installer | php
```

### Step 2: Create a New Laravel Project

Run the following command to create a new Laravel project:

```bash
composer create-project --prefer-dist laravel/laravel project-name
```

### Step 3: Install Dependencies

Navigate to the project directory and install the required dependencies:

```bash
composer install
```

### Step 4: Configure the Database

Open the `.env` file and update the database settings:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

## Project Structure
-------------------

A Laravel project consists of the following directories:

*   `app`: Contains the application code, including controllers, models, and services.
*   `bootstrap`: Contains the application's bootstrap files, including the kernel and the service provider.
*   `config`: Contains the application's configuration files.
*   `database`: Contains the database migration files and the seeders.
*   `public`: Contains the public assets, including the index.php file.
*   `resources`: Contains the application's resources, including the views and the language files.
*   `routes`: Contains the application's routes.
*   `storage`: Contains the application's storage files, including the logs and the cache.
*   `tests`: Contains the application's test files.

## Routing
---------

Laravel uses the `Route` facade to define routes. You can define routes in the `routes/web.php` file.

### Route Types

*   **GET**: Used to define a GET route.
*   **POST**: Used to define a POST route.
*   **PUT**: Used to define a PUT route.
*   **DELETE**: Used to define a DELETE route.

### Route Parameters

You can pass parameters to a route using the `:name` syntax.

```php
Route::get('/users/{id}', function ($id) {
    return 'User ' . $id;
});
```

## Controllers
-------------

Controllers are responsible for handling HTTP requests and returning responses. You can create a new controller using the `make:controller` Artisan command.

```bash
php artisan make:controller UserController
```

### Controller Methods

*   **index**: Used to handle GET requests.
*   **create**: Used to handle POST requests.
*   **store**: Used to handle PUT requests.
*   **update**: Used to handle DELETE requests.

## Models
--------

Models are responsible for interacting with the database. You can create a new model using the `make:model` Artisan command.

```bash
php artisan make:model User
```

### Model Methods

*   **create**: Used to create a new record in the database.
*   **update**: Used to update an existing record in the database.
*   **delete**: Used to delete a record from the database.

## Views
------

Views are responsible for rendering the user interface. You can create a new view using the `make:view` Artisan command.

```bash
php artisan make:view user.index
```

### View Syntax

*   **{{ }}**: Used to echo a variable.
*   **@if**: Used to conditionally render a section of the view.
*   **@foreach**: Used to loop through a collection of data.

## Database
---------

Laravel uses the Eloquent ORM to interact with the database.

### Database Methods

*   **create**: Used to create a new record in the database.
*   **update**: Used to update an existing record in the database.
*   **delete**: Used to delete a record from the database.

## Migrations
------------

Migrations are used to modify the database schema. You can create a new migration using the `make:migration` Artisan command.

```bash
php artisan make:migration create_users_table
```

### Migration Methods

*   **up**: Used to apply the migration.
*   **down**: Used to revert the migration.

## Seeding
---------

Seeding is used to populate the database with initial data. You can create a new seeder using the `make:seeder` Artisan command.

```bash
php artisan make:seeder UserTableSeeder
```

### Seeder Methods

*   **run**: Used to seed the database.

## Authentication
----------------

Laravel includes a built-in authentication system. You can create a new authentication controller using the `make:auth` Artisan command.

```bash
php artisan make:auth
```

### Authentication Methods

*   **login**: Used to handle login requests.
*   **register**: Used to handle registration requests.
*   **logout**: Used to handle logout requests.

## Authorization
----------------

Laravel includes a built-in authorization system. You can create a new policy using the `make:policy` Artisan command.

```bash
php artisan make:policy UserPolicy
```

### Policy Methods

*   **authorize**: Used to authorize a user to perform an action.

## Caching
---------

Laravel includes a built-in caching system. You can create a new cache store using the `make:cache` Artisan command.

```bash
php artisan make:cache
```

### Cache Methods

*   **get**: Used to retrieve a cached value.
*   **put**: Used to store a value in the cache.
*   **forget**: Used to delete a cached value.

## Debugging
------------

Laravel includes a built-in debugging system. You can enable debugging using the `debug` configuration option.

```php
'debug' => true,
```

### Debugging Methods

*   **dump**: Used to dump a variable to the console.
*   **dd**: Used to dump a variable and die.