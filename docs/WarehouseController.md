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

1. Install Composer using the following command:
   ```bash
curl -sS https://getcomposer.org/installer | php
```
2. Install Laravel using the following command:
   ```bash
composer create-project --prefer-dist laravel/laravel project-name
```
3. Change into the project directory:
   ```bash
cd project-name
```
4. Install the required dependencies using the following command:
   ```bash
composer install
```
5. Create a new database and update the `.env` file with the database credentials:
   ```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database-name
DB_USERNAME=root
DB_PASSWORD=password
```
6. Run the migrations using the following command:
   ```bash
php artisan migrate
```
7. Start the development server using the following command:
   ```bash
php artisan serve
```

## Project Structure
-------------------

### Directory Structure

* `app/`: Application directory
	+ `Http/`: HTTP request and response handling
		- `Controllers/`: Controller classes
		- `Middleware/`: Middleware classes
	+ `Models/`: Model classes
	+ `Providers/`: Service provider classes
* `database/`: Database directory
	+ `migrations/`: Migration files
	+ `seeds/`: Seeder classes
* `public/`: Public directory
	+ `index.php`: Entry point for the application
* `resources/`: Resource directory
	+ `views/`: View files
	+ `lang/`: Language files
	+ `public/`: Public assets
* `routes/`: Route directory
	+ `web.php`: Web routes
	+ `api.php`: API routes
* `tests/`: Test directory
	+ `Unit/`: Unit tests
	+ `Feature/`: Feature tests

## Routing
---------

### Route Types

* `web`: Web routes
* `api`: API routes

### Route Methods

* `get`: Handle GET requests
* `post`: Handle POST requests
* `put`: Handle PUT requests
* `delete`: Handle DELETE requests

### Route Parameters

* `id`: Route parameter for the ID of a resource
* `name`: Route parameter for the name of a resource

### Route Middleware

* `auth`: Authenticate the user before handling the request
* `guest`: Check if the user is a guest before handling the request

## Controllers
-------------

### Controller Methods

* `index`: Handle GET requests for the index action
* `create`: Handle GET requests for the create action
* `store`: Handle POST requests for the store action
* `show`: Handle GET requests for the show action
* `edit`: Handle GET requests for the edit action
* `update`: Handle PUT requests for the update action
* `destroy`: Handle DELETE requests for the destroy action

### Controller Inheritance

* `Controller`: Base controller class
* `ResourceController`: Controller class for resources

## Models
--------

### Model Methods

* `create`: Create a new instance of the model
* `update`: Update an existing instance of the model
* `delete`: Delete an existing instance of the model

### Model Relationships

* `hasOne`: One-to-one relationship
* `hasMany`: One-to-many relationship
* `belongsTo`: Many-to-one relationship
* `belongsToMany`: Many-to-many relationship

## Views
------

### View Files

* `index.blade.php`: View file for the index action
* `create.blade.php`: View file for the create action
* `show.blade.php`: View file for the show action
* `edit.blade.php`: View file for the edit action

### View Variables

* `title`: View variable for the title of the page
* `content`: View variable for the content of the page

## Database
----------

### Database Connections

* `mysql`: MySQL database connection

### Database Migrations

* `create_users_table`: Migration file for creating the users table
* `create_posts_table`: Migration file for creating the posts table

### Database Seeding

* `UserSeeder`: Seeder class for seeding the users table
* `PostSeeder`: Seeder class for seeding the posts table

## Authentication
--------------

### Authentication Middleware

* `auth`: Authenticate the user before handling the request

### Authentication Guards

* `web`: Web authentication guard
* `api`: API authentication guard

### Authentication Providers

* `eloquent`: Eloquent authentication provider
* `database`: Database authentication provider

## Authorization
--------------

### Authorization Middleware

* `auth`: Authenticate the user before handling the request
* `authorize`: Authorize the user before handling the request

### Authorization Policies

* `UserPolicy`: Policy class for authorizing users
* `PostPolicy`: Policy class for authorizing posts

## Migrations
------------

### Migration Files

* `create_users_table`: Migration file for creating the users table
* `create_posts_table`: Migration file for creating the posts table

### Migration Methods

* `up`: Migration method for creating the table
* `down`: Migration method for dropping the table

## Seeding
---------

### Seeder Classes

* `UserSeeder`: Seeder class for seeding the users table
* `PostSeeder`: Seeder class for seeding the posts table

### Seeder Methods

* `run`: Seeder method for seeding the table

## Testing
---------

### Unit Tests

* `TestUser`: Unit test class for testing the User model
* `TestPost`: Unit test class for testing the Post model

### Feature Tests

* `TestUserController`: Feature test class for testing the User controller
* `TestPostController`: Feature test class for testing the Post controller