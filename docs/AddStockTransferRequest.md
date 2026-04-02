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
*   **Eloquent ORM**: Laravel provides a powerful Object-Relational Mapping (ORM) system called Eloquent, which simplifies database interactions.
*   **Blade Templating Engine**: Laravel comes with a powerful templating engine called Blade, which allows you to write clean and maintainable HTML templates.

## Installation
--------------

To install Laravel, you can use Composer, the PHP package manager.

### Step 1: Install Composer

If you haven't installed Composer yet, you can download it from the official website: <https://getcomposer.org/download/>

### Step 2: Create a New Laravel Project

Run the following command in your terminal:

```bash
composer create-project --prefer-dist laravel/laravel project-name
```

Replace `project-name` with the name of your project.

### Step 3: Install Dependencies

Run the following command in your terminal:

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

### Step 5: Run the Migrations

Run the following command in your terminal:

```bash
php artisan migrate
```

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

Laravel uses the `Route` facade to define routes.

### Defining Routes

You can define routes in the `routes/web.php` file:

```php
Route::get('/home', 'HomeController@index')->name('home');
```

### Route Parameters

You can pass parameters to routes using the `Route::get` method:

```php
Route::get('/users/{id}', 'UserController@show')->name('user.show');
```

### Route Groups

You can group routes using the `Route::group` method:

```php
Route::group(['prefix' => 'admin'], function () {
    Route::get('/home', 'AdminController@index')->name('admin.home');
});
```

## Controllers
-------------

Laravel controllers handle HTTP requests and return responses.

### Creating a Controller

You can create a controller using the `php artisan make:controller` command:

```bash
php artisan make:controller UserController
```

### Controller Methods

You can define methods in the controller to handle different HTTP requests:

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function show($id)
    {
        return view('users.show', ['id' => $id]);
    }
}
```

## Models
--------

Laravel models interact with the database using Eloquent.

### Creating a Model

You can create a model using the `php artisan make:model` command:

```bash
php artisan make:model User
```

### Model Methods

You can define methods in the model to interact with the database:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'email'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
```

## Views
------

Laravel views are HTML templates that are rendered by the Blade templating engine.

### Creating a View

You can create a view by creating a new file in the `resources/views` directory:

```bash
resources/views/users/index.blade.php
```

### Blade Syntax

You can use Blade syntax to write clean and maintainable HTML templates:

```php
<!-- resources/views/users/index.blade.php -->

<h1>Users</h1>

<ul>
    @foreach ($users as $user)
        <li>{{ $user->name }}</li>
    @endforeach
</ul>
```

## Database
---------

Laravel interacts with the database using Eloquent.

### Creating a Migration

You can create a migration using the `php artisan make:migration` command:

```bash
php artisan make:migration create_users_table
```

### Migration Methods

You can define methods in the migration to create and modify database tables:

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

Laravel provides a built-in authentication system.

### Creating a User

You can create a user using the `User::create` method:

```php
use App\Models\User;

$user = User::create(['name' => 'John Doe', 'email' => 'john@example.com']);
```

### Authenticating a User

You can authenticate a user using the `Auth::attempt` method:

```php
use Illuminate\Support\Facades\Auth;

if (Auth::attempt(['email' => 'john@example.com', 'password' => 'password'])) {
    // User is authenticated
} else {
    // User is not authenticated
}
```

## Migration
---------

Laravel migrations are used to create and modify database tables.

### Creating a Migration

You can create a migration using the `php artisan make:migration` command:

```bash
php artisan make:migration create_users_table
```

### Migration Methods

You can define methods in the migration to create and modify database tables:

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

### Running Migrations

You can run migrations using the `php artisan migrate` command:

```bash
php artisan migrate
```