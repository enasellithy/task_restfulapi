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
10. [Caching](#caching)
11. [Logging](#logging)
12. [Error Handling](#error-handling)

## Installation
------------

### Prerequisites

* PHP 8.0 or higher
* Composer 2.0 or higher
* A web server (e.g. Apache, Nginx)
* A database (e.g. MySQL, PostgreSQL)

### Installation Steps

1. Install Composer: `curl -sS https://getcomposer.org/installer | php`
2. Create a new Laravel project: `composer create-project --prefer-dist laravel/laravel project-name`
3. Install dependencies: `composer install`
4. Configure the database: `php artisan key:generate` and `php artisan migrate`
5. Start the server: `php artisan serve`

## Project Structure
-----------------

### Directory Structure

* `app/`: application code
	+ `Http/`: HTTP requests and responses
	+ `Models/`: database models
	+ `Controllers/`: application logic
	+ `Services/`: reusable services
* `database/`: database configuration and migrations
* `public/`: public assets (e.g. CSS, JS, images)
* `resources/`: view templates and assets
* `routes/`: route definitions
* `tests/`: unit tests and integration tests

### File Structure

* `app/Http/Controllers/`: controller classes
* `app/Models/`: model classes
* `app/Services/`: service classes
* `database/migrations/`: database migration files
* `database/seeds/`: database seed files
* `routes/web.php`: web route definitions
* `routes/api.php`: API route definitions

## Routing
---------

### Route Definitions

* `web.php`: web route definitions
* `api.php`: API route definitions

### Route Methods

* `get()`: handle GET requests
* `post()`: handle POST requests
* `put()`: handle PUT requests
* `delete()`: handle DELETE requests

### Route Parameters

* `:id`: route parameter for an ID
* `:name`: route parameter for a name

## Controllers
------------

### Controller Classes

* `app/Http/Controllers/`: controller classes
* `use Illuminate\Http\Request;`: use the Request class
* `public function __construct(Request $request)`: constructor method

### Controller Methods

* `index()`: handle GET requests
* `store()`: handle POST requests
* `update()`: handle PUT requests
* `destroy()`: handle DELETE requests

## Models
--------

### Model Classes

* `app/Models/`: model classes
* `use Illuminate\Database\Eloquent\Model;`: use the Model class
* `protected $fillable = ['name', 'email'];`: define fillable attributes

### Model Methods

* `create()`: create a new model instance
* `update()`: update an existing model instance
* `delete()`: delete a model instance

## Views
------

### View Templates

* `resources/views/`: view templates
* `@extends('layouts.app')`: extend a layout template
* `@section('content')`: define a section

### View Variables

* `@php`: use PHP code in a view
* `{{ $variable }}`: display a variable

## Database
----------

### Database Configuration

* `database.php`: database configuration file
* `DB::connection('mysql')->table('users')->get();`: use a database connection

### Database Migrations

* `database/migrations/`: database migration files
* `php artisan migrate`: run database migrations

## Authentication
--------------

### Authentication Middleware

* `auth`: authentication middleware
* `@auth`: check if a user is authenticated

### Authentication Routes

* `auth/login`: login route
* `auth/register`: register route

## Authorization
--------------

### Authorization Middleware

* `auth`: authorization middleware
* `@can('view-users')`: check if a user has a permission

### Authorization Policies

* `app/Providers/AuthServiceProvider.php`: authorization policy provider
* `use Illuminate\Foundation\Auth\Access\AuthorizesRequests;`: use the AuthorizesRequests trait

## Caching
---------

### Cache Store

* `cache`: cache store
* `Cache::store('file')->put('key', 'value');`: use a cache store

### Cache Tags

* `Cache::tags('users')->put('key', 'value');`: use cache tags

## Logging
---------

### Log Channels

* `log`: log channel
* `Log::channel('log')->info('message');`: use a log channel

### Log Levels

* `debug`: debug log level
* `info`: info log level
* `warning`: warning log level
* `error`: error log level
* `critical`: critical log level
* `alert`: alert log level
* `emergency`: emergency log level

## Error Handling
----------------

### Error Handling Middleware

* `exception`: error handling middleware
* `@error('message')`: display an error message

### Error Handling Routes

* `exception`: error handling route
* `php artisan make:controller ExceptionController`: create an exception controller

### Error Handling Policies

* `app/Providers/ExceptionServiceProvider.php`: error handling policy provider
* `use Illuminate\Foundation\Exceptions\Handler;`: use the Handler class