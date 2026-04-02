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
FLUSH PRIVILEGES;
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
8. Run the seeders:
```bash
php artisan db:seed
```

## Project Structure
-------------------

### Directory Structure

* `app/`: Application code
	+ `Http/`: HTTP requests and responses
	+ `Models/`: Database models
	+ `Providers/`: Service providers
* `database/`: Database configuration and migrations
* `public/`: Public assets
* `resources/`: View templates and assets
* `routes/`: Route definitions
* `tests/`: Unit tests and integration tests

### File Structure

* `app/Http/Controllers/`: Controller classes
* `app/Http/Requests/`: Request classes
* `app/Models/`: Model classes
* `database/migrations/`: Migration files
* `database/seeds/`: Seeder classes
* `routes/web.php`: Web route definitions
* `routes/api.php`: API route definitions

## Routing
---------

### Route Definitions

Laravel uses the `Route` facade to define routes. There are two types of routes: web routes and API routes.

### Web Routes

Web routes are defined in the `routes/web.php` file. They are used to handle HTTP requests and responses.

```php
Route::get('/', function () {
    return view('welcome');
});
```

### API Routes

API routes are defined in the `routes/api.php` file. They are used to handle API requests and responses.

```php
Route::get('/users', 'UserController@index');
```

## Controllers
-------------

### Controller Classes

Controller classes are used to handle HTTP requests and responses. They are located in the `app/Http/Controllers/` directory.

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Handle the request
    }
}
```

## Models
--------

### Model Classes

Model classes are used to interact with the database. They are located in the `app/Models/` directory.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'email'];
}
```

## Views
------

### View Templates

View templates are used to render HTML responses. They are located in the `resources/views/` directory.

```php
<!-- resources/views/welcome.blade.php -->

<h1>Welcome to Laravel!</h1>
```

## Database
---------

### Database Configuration

Laravel uses the `DB` facade to interact with the database. The database configuration is stored in the `.env` file.

```makefile
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project_name
DB_USERNAME=project_name
DB_PASSWORD=password
```

### Migration

Migration files are used to create and modify the database schema. They are located in the `database/migrations/` directory.

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

### Seeder

Seeder classes are used to populate the database with initial data. They are located in the `database/seeds/` directory.

```php
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create(['name' => 'John Doe', 'email' => 'john.doe@example.com']);
    }
}
```

## Authentication
--------------

### Authentication Configuration

Laravel uses the `Auth` facade to handle authentication. The authentication configuration is stored in the `config/auth.php` file.

```php
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
```

### Authentication Routes

Authentication routes are defined in the `routes/web.php` file.

```php
Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');
```

## Migration
---------

### Migration Files

Migration files are used to create and modify the database schema. They are located in the `database/migrations/` directory.

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

Migrations can be run using the `artisan migrate` command.

```bash
php artisan migrate
```

## Seeding
---------

### Seeder Classes

Seeder classes are used to populate the database with initial data. They are located in the `database/seeds/` directory.

```php
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create(['name' => 'John Doe', 'email' => 'john.doe@example.com']);
    }
}
```

### Running Seeders

Seeders can be run using the `artisan db:seed` command.

```bash
php artisan db:seed
```