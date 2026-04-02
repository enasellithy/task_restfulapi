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
9. [Authorization](#authorization)
10. [Migrations](#migrations)
11. [Seeding](#seeding)
12. [Testing](#testing)

## Installation
-------------

### Prerequisites

* PHP 8.0 or higher
* Composer 2.0 or higher
* MySQL 5.7 or higher
* Node.js 14 or higher

### Installation Steps

1. Install Composer: `curl -sS https://getcomposer.org/installer | php`
2. Install Laravel: `composer create-project --prefer-dist laravel/laravel project-name`
3. Install dependencies: `composer install`
4. Create a new database: `mysql -u root -p`
5. Configure database connection in `.env` file
6. Run migrations: `php artisan migrate`
7. Run seeders: `php artisan db:seed`

## Project Structure
-------------------

### Directory Structure

* `app/`: Application code
	+ `Http/`: HTTP requests and responses
	+ `Models/`: Database models
	+ `Controllers/`: Controller classes
	+ `Services/`: Service classes
* `database/`: Database configuration and migrations
* `public/`: Public assets (CSS, JS, images)
* `resources/`: View templates and language files
* `routes/`: Route definitions
* `storage/`: Storage for uploaded files
* `tests/`: Unit tests and integration tests

### File Structure

* `app/Http/Controllers/`: Controller classes
* `app/Models/`: Database models
* `app/Services/`: Service classes
* `database/migrations/`: Database migration files
* `database/seeds/`: Database seeder files
* `routes/web.php`: Web route definitions
* `routes/api.php`: API route definitions

## Routing
---------

### Route Types

* `GET`: Retrieve data
* `POST`: Create data
* `PUT`: Update data
* `DELETE`: Delete data

### Route Parameters

* `id`: Unique identifier for a resource
* `slug`: Human-readable identifier for a resource

### Route Examples

* `GET /users`: Retrieve all users
* `GET /users/{id}`: Retrieve a user by ID
* `POST /users`: Create a new user
* `PUT /users/{id}`: Update a user
* `DELETE /users/{id}`: Delete a user

## Controllers
-------------

### Controller Structure

* `app/Http/Controllers/`: Controller classes
* `app/Http/Controllers/Controller.php`: Base controller class

### Controller Methods

* `index()`: Retrieve data
* `create()`: Create data
* `store()`: Store data
* `show()`: Retrieve a single resource
* `edit()`: Update a single resource
* `update()`: Update a single resource
* `destroy()`: Delete a single resource

### Controller Examples

* `app/Http/Controllers/UserController.php`: User controller class
* `app/Http/Controllers/UserController.php`: `index()` method
* `app/Http/Controllers/UserController.php`: `create()` method

## Models
--------

### Model Structure

* `app/Models/`: Database models
* `app/Models/User.php`: User model class

### Model Methods

* `create()`: Create a new instance
* `update()`: Update an existing instance
* `delete()`: Delete an instance

### Model Examples

* `app/Models/User.php`: User model class
* `app/Models/User.php`: `create()` method
* `app/Models/User.php`: `update()` method

## Views
------

### View Structure

* `resources/views/`: View templates
* `resources/views/layouts/`: Layout templates
* `resources/views/partials/`: Partial templates

### View Examples

* `resources/views/layouts/app.blade.php`: App layout template
* `resources/views/partials/navbar.blade.php`: Navbar partial template
* `resources/views/users/index.blade.php`: User index view

## Database
----------

### Database Configuration

* `.env` file: Database connection settings
* `database.php` file: Database configuration

### Migration Files

* `database/migrations/`: Database migration files
* `php artisan migrate`: Run migrations

### Seeder Files

* `database/seeds/`: Database seeder files
* `php artisan db:seed`: Run seeders

## Authentication
--------------

### Authentication Middleware

* `auth`: Authenticate users
* `guest`: Authenticate guests

### Authentication Examples

* `app/Http/Middleware/Authenticate.php`: Authentication middleware class
* `app/Http/Middleware/Guest.php`: Guest middleware class

## Authorization
--------------

### Authorization Middleware

* `authorize`: Authorize users
* `can`: Authorize users

### Authorization Examples

* `app/Http/Middleware/Authorize.php`: Authorization middleware class
* `app/Http/Middleware/Can.php`: Can middleware class

## Migrations
------------

### Migration Files

* `database/migrations/`: Database migration files
* `php artisan migrate`: Run migrations

### Migration Examples

* `database/migrations/2022_01_01_000000_create_users_table.php`: User migration file
* `database/migrations/2022_01_01_000001_create_roles_table.php`: Role migration file

## Seeding
---------

### Seeder Files

* `database/seeds/`: Database seeder files
* `php artisan db:seed`: Run seeders

### Seeder Examples

* `database/seeds/UserTableSeeder.php`: User seeder file
* `database/seeds/RoleTableSeeder.php`: Role seeder file

## Testing
---------

### Testing Framework

* `phpunit`: Testing framework

### Testing Examples

* `tests/Unit/UserTest.php`: User unit test class
* `tests/Feature/UserTest.php`: User feature test class