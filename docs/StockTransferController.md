# Laravel Documentation
=========================

## Table of Contents
-----------------

1. [Installation](#installation)
2. [Project Structure](#project-structure)
3. [Routing](#routing)
4. [Controllers](#controllers)
5. [Models](#models)
6. [Views](#views)
7. [Database](#database)
8. [Authentication](#authentication)
9. [Migration](#migration)
10. [Seeding](#seeding)

## Installation
-------------

### Prerequisites

* PHP 8.0 or higher
* Composer 2.0 or higher
* MySQL 5.7 or higher

### Installation Steps

1. Install Laravel using Composer:
```bash
composer create-project --prefer-dist laravel/laravel project-name
```
2. Change into the project directory:
```bash
cd project-name
```
3. Install dependencies:
```bash
composer install
```
4. Create a new database:
```bash
mysql -u root -p
```
5. Create a new database and grant privileges:
```sql
CREATE DATABASE project_name;
GRANT ALL PRIVILEGES ON project_name.* TO 'project_name'@'%' IDENTIFIED BY 'password';
```
6. Configure the database connection in `.env` file:
```makefile
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project_name
DB_USERNAME=project_name
DB_PASSWORD=password
```
7. Run the migration:
```bash
php artisan migrate
```
8. Run the seed:
```bash
php artisan db:seed
```

## Project Structure
-------------------

### Directory Structure

* `app/`: Application code
	+ `Http/`: HTTP requests and responses
	+ `Models/`: Database models
	+ `Controllers/`: Controller classes
	+ `Services/`: Service classes
* `database/`: Database configuration and migrations
* `public/`: Public assets
* `resources/`: View templates and assets
* `routes/`: Route definitions
* `tests/`: Unit tests and integration tests

### File Structure

* `app/Http/Controllers/`: Controller classes
* `app/Http/Requests/`: Request classes
* `app/Http/Responses/`: Response classes
* `app/Models/`: Database models
* `app/Services/`: Service classes
* `database/migrations/`: Database migrations
* `database/seeds/`: Database seeders
* `public/index.php`: Public entry point
* `routes/web.php`: Web route definitions
* `routes/api.php`: API route definitions

## Routing
---------

### Route Definitions

* `web.php`: Web route definitions
* `api.php`: API route definitions

### Route Methods

* `get()`: Handle GET requests
* `post()`: Handle POST requests
* `put()`: Handle PUT requests
* `delete()`: Handle DELETE requests

### Route Parameters

* `id`: Integer parameter
* `name`: String parameter

### Route Middleware

* `auth`: Authenticate requests
* `guest`: Prevent authenticated users from accessing routes

## Controllers
-------------

### Controller Classes

* `App\Http\Controllers\Controller`: Base controller class
* `App\Http\Controllers\Auth\LoginController`: Login controller class
* `App\Http\Controllers\Auth\RegisterController`: Register controller class

### Controller Methods

* `index()`: Handle GET requests
* `store()`: Handle POST requests
* `update()`: Handle PUT requests
* `destroy()`: Handle DELETE requests

## Models
--------

### Model Classes

* `App\Models\User`: User model class
* `App\Models\Post`: Post model class

### Model Methods

* `create()`: Create a new model instance
* `update()`: Update an existing model instance
* `delete()`: Delete a model instance

## Views
------

### View Templates

* `resources/views/`: View templates
* `resources/views/layouts/`: Layout templates

### View Variables

* `$title`: Page title
* `$content`: Page content

## Database
----------

### Database Configuration

* `.env`: Database connection configuration
* `database/migrations/`: Database migrations

### Database Migrations

* `php artisan migrate`: Run database migrations
* `php artisan migrate:rollback`: Rollback database migrations

## Authentication
--------------

### Authentication Middleware

* `auth`: Authenticate requests

### Authentication Routes

* `web.php`: Web route definitions
* `api.php`: API route definitions

### Authentication Controllers

* `App\Http\Controllers\Auth\LoginController`: Login controller class
* `App\Http\Controllers\Auth\RegisterController`: Register controller class

## Migration
------------

### Migration Classes

* `App\Database\Migrations\Migration`: Base migration class

### Migration Methods

* `up()`: Run migration
* `down()`: Rollback migration

## Seeding
---------

### Seeder Classes

* `App\Database\Seeds\Seeder`: Base seeder class

### Seeder Methods

* `run()`: Run seeder
* `rollback()`: Rollback seeder