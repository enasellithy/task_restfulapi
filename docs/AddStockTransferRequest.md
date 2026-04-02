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
------------

To install Laravel, follow these steps:

### Step 1: Install Composer

First, you need to install Composer on your system. You can download it from the official website: <https://getcomposer.org/download/>

### Step 2: Create a New Laravel Project

Run the following command in your terminal:

```bash
composer create-project --prefer-dist laravel/laravel project-name
```

Replace `project-name` with the name of your project.

### Step 3: Install Dependencies

Run the following command to install the required dependencies:

```bash
composer install
```

### Step 4: Set Up the Database

Create a new database and update the `.env` file with the database credentials:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database-name
DB_USERNAME=root
DB_PASSWORD=password
```

Replace the values with your actual database credentials.

## Project Structure
------------------

The Laravel project structure is as follows:

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

Laravel uses the `Route` facade to define routes. You can define routes in the `routes/web.php` file.

### Example Route

```php
Route::get('/hello', function () {
    return 'Hello, World!';
});
```

## Controllers
-------------

Controllers are responsible for handling HTTP requests and returning responses. You can create a new controller by running the following command:

```bash
php artisan make:controller ControllerName
```

### Example Controller

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerName extends Controller
{
    public function index()
    {
        return 'Hello, World!';
    }
}
```

## Models
--------

Models are responsible for interacting with the database. You can create a new model by running the following command:

```bash
php artisan make:model ModelName
```

### Example Model

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelName extends Model
{
    protected $fillable = ['column1', 'column2'];
}
```

## Views
------

Views are responsible for rendering the user interface. You can create a new view by running the following command:

```bash
php artisan make:view view-name
```

### Example View

```php
<!-- resources/views/view-name.blade.php -->

<h1>Hello, World!</h1>
```

## Database
----------

Laravel uses Eloquent to interact with the database. You can create a new migration by running the following command:

```bash
php artisan make:migration create_table_name
```

### Example Migration

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTable extends Migration
{
    public function up()
    {
        Schema::create('table_name', function (Blueprint $table) {
            $table->id();
            $table->string('column1');
            $table->string('column2');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('table_name');
    }
}
```

## Authentication
--------------

Laravel provides a built-in authentication system. You can create a new user by running the following command:

```bash
php artisan make:auth
```

### Example User Model

```php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
```

## Migration
------------

Migrations are used to modify the database schema. You can create a new migration by running the following command:

```bash
php artisan make:migration migration-name
```

### Example Migration

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MigrationName extends Migration
{
    public function up()
    {
        Schema::table('table_name', function (Blueprint $table) {
            $table->string('column1');
        });
    }

    public function down()
    {
        Schema::table('table_name', function (Blueprint $table) {
            $table->dropColumn('column1');
        });
    }
}
```

## Seeding
---------

Seeding is used to populate the database with initial data. You can create a new seeder by running the following command:

```bash
php artisan make:seeder SeederName
```

### Example Seeder

```php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederName extends Seeder
{
    public function run()
    {
        DB::table('table_name')->insert([
            'column1' => 'value1',
            'column2' => 'value2',
        ]);
    }
}
```

You can run the seeder by running the following command:

```bash
php artisan db:seed
```