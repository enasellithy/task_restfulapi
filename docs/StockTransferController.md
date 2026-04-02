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
9. [Authentication](#authentication)
10. [Migration](#migration)

## Introduction
-------------

Laravel is a free, open-source PHP web framework, intended for the development of web applications following the model–view–controller (MVC) architectural pattern.

### Features

*   **Modular**: Laravel is built on top of the Symfony framework, which provides a modular structure for the application.
*   **MVC Pattern**: Laravel follows the Model-View-Controller (MVC) pattern, which separates the application logic into three interconnected components.
*   **Eloquent ORM**: Laravel comes with Eloquent, an Object-Relational Mapping (ORM) system that simplifies database interactions.
*   **Blade Templating Engine**: Laravel uses the Blade templating engine, which provides a simple and expressive syntax for creating views.

## Installation
--------------

To install Laravel, follow these steps:

### Step 1: Install Composer

Composer is a dependency manager for PHP. You can download it from the official website: <https://getcomposer.org/download/>

### Step 2: Install Laravel

Run the following command in your terminal:

```bash
composer create-project --prefer-dist laravel/laravel project-name
```

Replace `project-name` with the name of your project.

### Step 3: Set Up the Database

Create a new database and update the `.env` file with the database credentials:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=root
DB_PASSWORD=password
```

Replace the database credentials with your actual database credentials.

## Project Structure
-------------------

A Laravel project has the following structure:

```bash
project-name/
app/
Console/
Controllers/
Exceptions/
Http/
Kernel.php
Providers/
Requests/
Services/
tests/
database/
factories/
migrations/
public/
resources/
views/
routes/
web.php
routes/
api.php
routes/
console.php
storage/
bootstrap/
cache/
framework/
sessions/
logs/
public/
index.php
vendor/
composer.json
composer.lock
.env
```

## Routing
---------

Laravel uses the `Route` facade to define routes. You can define routes in the `routes/web.php` file:

```php
Route::get('/home', function () {
    return 'Welcome to Laravel!';
});
```

You can also define routes using the `Route::get()` method:

```php
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return 'Welcome to Laravel!';
});
```

## Controllers
-------------

Controllers handle the business logic of the application. You can create a new controller using the following command:

```bash
php artisan make:controller ControllerName
```

Replace `ControllerName` with the name of your controller.

## Models
--------

Models represent the data in the database. You can create a new model using the following command:

```bash
php artisan make:model ModelName
```

Replace `ModelName` with the name of your model.

## Views
------

Views are the user interface of the application. You can create a new view using the following command:

```bash
php artisan make:view ViewName
```

Replace `ViewName` with the name of your view.

## Database
---------

Laravel uses the Eloquent ORM to interact with the database. You can create a new migration using the following command:

```bash
php artisan make:migration CreateTableName
```

Replace `TableName` with the name of your table.

## Authentication
----------------

Laravel provides a built-in authentication system. You can create a new user using the following command:

```bash
php artisan make:auth
```

This will create the necessary routes and controllers for authentication.

## Migration
------------

Migrations are used to modify the database schema. You can create a new migration using the following command:

```bash
php artisan make:migration CreateTableName
```

Replace `TableName` with the name of your table.

You can then run the migration using the following command:

```bash
php artisan migrate
```

This will apply the migration to the database.