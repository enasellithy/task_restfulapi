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
8. [Migrations](#migrations)
9. [Seeding](#seeding)
10. [Authentication](#authentication)
11. [Authorization](#authorization)
12. [Caching](#caching)
13. [Queueing](#queueing)
14. [Logging](#logging)

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
6. Run the following command to create the database tables:
   ```bash
php artisan migrate
```

## Project Structure
-------------------

### Directory Structure

* `app/`: Application code
* `bootstrap/`: Bootstrap files
* `config/`: Configuration files
* `database/`: Database files
* `public/`: Public files
* `resources/`: Resource files
* `routes/`: Route files
* `storage/`: Storage files
* `tests/`: Test files
* `vendor/`: Composer dependencies

### File Structure

* `app/Http/Controllers/`: Controller files
* `app/Http/Requests/`: Request files
* `app/Http/Responses/`: Response files
* `app/Models/`: Model files
* `app/Providers/`: Provider files
* `app/Services/`: Service files

## Routing
---------

### Route Types

* `GET`: Retrieve data
* `POST`: Create data
* `PUT`: Update data
* `DELETE`: Delete data

### Route Parameters

* `id`: Unique identifier
* `name`: String parameter

### Route Example

```php
Route::get('/users/{id}', 'UserController@show');
```

## Controllers
-------------

### Controller Structure

* `app/Http/Controllers/`: Controller files
* `app/Http/Controllers/Controller.php`: Base controller file

### Controller Methods

* `index()`: Retrieve data
* `create()`: Create data
* `store()`: Store data
* `show()`: Retrieve data
* `edit()`: Update data
* `update()`: Update data
* `destroy()`: Delete data

### Controller Example

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->save();
        return redirect()->route('users.index');
    }
}
```

## Models
--------

### Model Structure

* `app/Models/`: Model files
* `app/Models/User.php`: User model file

### Model Methods

* `all()`: Retrieve all data
* `find($id)`: Retrieve data by ID
* `create($data)`: Create data
* `update($data)`: Update data
* `delete()`: Delete data

### Model Example

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name'];
}
```

## Views
------

### View Structure

* `resources/views/`: View files
* `resources/views/users/index.blade.php`: User index view file

### View Example

```php
<!-- resources/views/users/index.blade.php -->

<h1>Users</h1>

<ul>
    @foreach($users as $user)
        <li>{{ $user->name }}</li>
    @endforeach
</ul>
```

## Database
----------

### Database Structure

* `database/migrations/`: Migration files
* `database/seeds/`: Seeder files

### Migration Example

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
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
```

### Seeder Example

```php
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create(['name' => 'John Doe']);
    }
}
```

## Migrations
------------

### Migration Structure

* `database/migrations/`: Migration files
* `database/migrations/2022_01_01_000000_create_users_table.php`: User migration file

### Migration Example

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

* `database/seeds/`: Seeder files
* `database/seeds/UserSeeder.php`: User seeder file

### Seeder Example

```php
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create(['name' => 'John Doe']);
    }
}
```

## Authentication
--------------

### Authentication Structure

* `app/Http/Controllers/Auth/`: Authentication controller files
* `app/Http/Controllers/Auth/LoginController.php`: Login controller file

### Authentication Example

```php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        }

        return redirect()->back()->withErrors(['Invalid credentials']);
    }
}
```

## Authorization
--------------

### Authorization Structure

* `app/Http/Controllers/Auth/`: Authorization controller files
* `app/Http/Controllers/Auth/AuthorizeController.php`: Authorize controller file

### Authorization Example

```php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthorizeController extends Controller
{
    public function authorize(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return redirect()->back()->withErrors(['You are not authorized']);
    }
}
```

## Caching
---------

### Caching Structure

* `app/Http/Controllers/`: Caching controller files
* `app/Http/Controllers/CacheController.php`: Cache controller file

### Caching Example

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
    public function cache(Request $request)
    {
        $data = Cache::get('data');

        if (!$data) {
            $data = 'Hello, World!';
            Cache::put('data', $data, 60);
        }

        return response($data);
    }
}
```

## Queueing
---------

### Queueing Structure

* `app/Http/Controllers/`: Queueing controller files
* `app/Http/Controllers/QueueController.php`: Queue controller file

### Queueing Example

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;

class QueueController extends Controller
{
    public function queue(Request $request)
    {
        Queue::push('App\Jobs\MyJob', ['data' => 'Hello, World!']);
        return response('Job queued');
    }
}
```

## Logging
---------

### Logging Structure

* `app/Http/Controllers/`: Logging controller files
* `app/Http/Controllers/LogController.php`: Log controller file

### Logging Example

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{
    public function log(Request $request)
    {
        Log::info('Hello, World!');
        return response('Log created');
    }
}
```