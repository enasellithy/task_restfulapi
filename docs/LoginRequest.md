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
6. Run the following command to create the database tables:
   ```bash
php artisan migrate
```
7. Run the following command to seed the database:
   ```bash
php artisan db:seed
```

## Project Structure
-------------------

### Directory Structure

* `app/`: Application directory
	+ `Http/`: HTTP directory
		- `Controllers/`: Controller directory
		- `Middleware/`: Middleware directory
	+ `Models/`: Model directory
	+ `Providers/`: Service provider directory
* `database/`: Database directory
	+ `migrations/`: Migration directory
	+ `seeds/`: Seeder directory
* `public/`: Public directory
	+ `index.php`: Entry point of the application
* `resources/`: Resource directory
	+ `views/`: View directory
	+ `lang/`: Language directory
	+ `public/`: Public resource directory
* `routes/`: Route directory
* `tests/`: Test directory

## Routing
---------

### Route Types

* `GET`: Retrieve data
* `POST`: Create data
* `PUT`: Update data
* `DELETE`: Delete data

### Route Registration

* Use the `Route::get()` method to register a GET route:
   ```php
Route::get('/users', 'UserController@index');
```
* Use the `Route::post()` method to register a POST route:
   ```php
Route::post('/users', 'UserController@store');
```
* Use the `Route::put()` method to register a PUT route:
   ```php
Route::put('/users/{id}', 'UserController@update');
```
* Use the `Route::delete()` method to register a DELETE route:
   ```php
Route::delete('/users/{id}', 'UserController@destroy');
```

## Controllers
-------------

### Controller Structure

* Use the `Controller` class as the base class for your controllers:
   ```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Retrieve data
    }

    public function store(Request $request)
    {
        // Create data
    }

    public function update(Request $request, $id)
    {
        // Update data
    }

    public function destroy($id)
    {
        // Delete data
    }
}
```

## Models
--------

### Model Structure

* Use the `Model` class as the base class for your models:
   ```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'name',
        'email',
    ];
}
```

## Views
------

### View Structure

* Use the `view()` function to render a view:
   ```php
return view('users.index');
```
* Use the `compact()` function to pass data to a view:
   ```php
return view('users.index', compact('users'));
```

## Database
----------

### Migration Structure

* Use the `Migration` class as the base class for your migrations:
   ```php
namespace Database\Migrations;

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

### Seeder Structure

* Use the `Seeder` class as the base class for your seeders:
   ```php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
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

## Authentication
--------------

### Authentication Structure

* Use the `Auth` facade to authenticate users:
   ```php
use Illuminate\Support\Facades\Auth;

if (Auth::check()) {
    // User is authenticated
} else {
    // User is not authenticated
}
```

### Authentication Routes

* Use the `Auth::routes()` method to register authentication routes:
   ```php
Auth::routes();
```

## Authorization
--------------

### Authorization Structure

* Use the `Gate` facade to authorize users:
   ```php
use Illuminate\Support\Facades\Gate;

if (Gate::allows('view-users')) {
    // User is authorized to view users
} else {
    // User is not authorized to view users
}
```

### Authorization Policies

* Use the `Policy` class as the base class for your policies:
   ```php
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->id === auth()->id();
    }
}
```

## Migrations
------------

### Migration Structure

* Use the `Migration` class as the base class for your migrations:
   ```php
namespace Database\Migrations;

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

* Use the `Seeder` class as the base class for your seeders:
   ```php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
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

## Testing
---------

### Test Structure

* Use the `TestCase` class as the base class for your tests:
   ```php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function test_user_can_be_created()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $this->assertNotNull($user);
    }
}
```

### Test Methods

* Use the `test()` method to define a test:
   ```php
public function test_user_can_be_created()
{
    // Test code here
}
```
* Use the `assert()` method to assert a condition:
   ```php
$this->assertNotNull($user);
```
* Use the `assertEqual()` method to assert two values are equal:
   ```php
$this->assertEquals('John Doe', $user->name);
```
* Use the `assertNotEqual()` method to assert two values are not equal:
   ```php
$this->assertNotEquals('Jane Doe', $user->name);
```