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
12. [Caching](#caching)
13. [Queueing](#queueing)
14. [Logging](#logging)

## Installation
-------------

### Prerequisites

* PHP 8.0 or higher
* Composer 2.0 or higher
* A web server (e.g. Apache, Nginx)
* A database (e.g. MySQL, PostgreSQL)

### Installation Steps

1. Install Composer: `curl -sS https://getcomposer.org/installer | php`
2. Create a new Laravel project: `composer create-project --prefer-dist laravel/laravel project-name`
3. Install dependencies: `composer install`
4. Configure database settings in `.env` file
5. Run database migrations: `php artisan migrate`
6. Run database seeds: `php artisan db:seed`

## Project Structure
-------------------

### Directory Structure

* `app/`: application code
	+ `Http/`: HTTP requests and responses
	+ `Models/`: database models
	+ `Controllers/`: application controllers
	+ `Services/`: application services
* `database/`: database configuration and migrations
* `public/`: public assets (e.g. CSS, JS, images)
* `resources/`: application resources (e.g. views, language files)
* `routes/`: application routes
* `storage/`: application storage (e.g. logs, cache)

### File Structure

* `app/Http/Kernel.php`: HTTP kernel
* `app/Models/User.php`: user model
* `app/Controllers/Controller.php`: base controller
* `app/Services/Service.php`: base service
* `database/migrations/2022_01_01_000000_create_users_table.php`: user migration
* `routes/web.php`: web routes
* `routes/api.php`: API routes

## Routing
---------

### Route Types

* `GET`: retrieve data
* `POST`: create data
* `PUT`: update data
* `DELETE`: delete data

### Route Parameters

* `id`: unique identifier for a resource
* `name`: human-readable name for a resource

### Route Examples

* `GET /users`: retrieve all users
* `POST /users`: create a new user
* `GET /users/{id}`: retrieve a user by ID
* `PUT /users/{id}`: update a user by ID
* `DELETE /users/{id}`: delete a user by ID

## Controllers
-------------

### Controller Structure

* `app/Controllers/Controller.php`: base controller
* `app/Controllers/UserController.php`: user controller

### Controller Methods

* `index()`: retrieve all resources
* `create()`: create a new resource
* `store()`: store a new resource
* `show()`: retrieve a resource by ID
* `update()`: update a resource by ID
* `destroy()`: delete a resource by ID

### Controller Examples

* `app/Controllers/UserController.php`:
```php
namespace App\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        return redirect()->route('users.index');
    }

    public function show($id)
    {
        return User::find($id);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('users.index');
    }
}
```

## Models
--------

### Model Structure

* `app/Models/User.php`: user model

### Model Methods

* `all()`: retrieve all resources
* `find($id)`: retrieve a resource by ID
* `create()`: create a new resource
* `update()`: update a resource by ID
* `delete()`: delete a resource by ID

### Model Examples

* `app/Models/User.php`:
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'email'];

    public function scopeAll($query)
    {
        return $query->get();
    }

    public function scopeFind($query, $id)
    {
        return $query->find($id);
    }

    public function scopeCreate($query, $data)
    {
        return $query->create($data);
    }

    public function scopeUpdate($query, $id, $data)
    {
        return $query->find($id)->update($data);
    }

    public function scopeDelete($query, $id)
    {
        return $query->find($id)->delete();
    }
}
```

## Views
------

### View Structure

* `resources/views/`: application views
* `resources/views/users/`: user views

### View Examples

* `resources/views/users/index.blade.php`:
```php
@extends('layouts.app')

@section('content')
    <h1>Users</h1>
    <ul>
        @foreach($users as $user)
            <li>{{ $user->name }} ({{ $user->email }})</li>
        @endforeach
    </ul>
@endsection
```

## Database
----------

### Database Configuration

* `.env` file: database settings
* `database/migrations/`: database migrations

### Database Migrations

* `database/migrations/2022_01_01_000000_create_users_table.php`: user migration

### Database Seeding

* `database/seeds/`: database seeds
* `database/seeds/UserTableSeeder.php`: user seed

### Database Examples

* `database/migrations/2022_01_01_000000_create_users_table.php`:
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
```

## Authentication
--------------

### Authentication Configuration

* `config/auth.php`: authentication settings

### Authentication Examples

* `config/auth.php`:
```php
return [
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],
];
```

## Authorization
--------------

### Authorization Configuration

* `config/authorization.php`: authorization settings

### Authorization Examples

* `config/authorization.php`:
```php
return [
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],
];
```

## Migrations
------------

### Migration Structure

* `database/migrations/`: database migrations

### Migration Examples

* `database/migrations/2022_01_01_000000_create_users_table.php`:
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
```

## Seeding
---------

### Seeder Structure

* `database/seeds/`: database seeds

### Seeder Examples

* `database/seeds/UserTableSeeder.php`:
```php
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);
    }
}
```

## Caching
---------

### Cache Configuration

* `config/cache.php`: cache settings

### Cache Examples

* `config/cache.php`:
```php
return [
    'default' => env('CACHE_DRIVER', 'file'),
    'stores' => [
        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache'),
        ],
    ],
];
```

## Queueing
---------

### Queue Configuration

* `config/queue.php`: queue settings

### Queue Examples

* `config/queue.php`:
```php
return [
    'default' => env('QUEUE_DRIVER', 'sync'),
    'connections' => [
        'sync' => [
            'driver' => 'sync',
        ],
        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
        ],
    ],
];
```

## Logging
---------

### Log Configuration

* `config/logging.php`: log settings

### Log Examples

* `config/logging.php`:
```php
return [
    'default' => env('LOG_CHANNEL', 'stack'),
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
        ],
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],
    ],
];
```

This documentation covers the basics of Laravel, including installation, project structure, routing, controllers, models, views, database, authentication, authorization, migrations, seeding, caching, queueing, and logging.