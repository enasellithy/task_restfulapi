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
* `vendor/`: Vendor directory

## Routing
---------

### Route Types

* `GET`: Retrieve a resource
* `POST`: Create a new resource
* `PUT`: Update an existing resource
* `DELETE`: Delete a resource

### Route Parameters

* `id`: Unique identifier of a resource
* `name`: Name of a resource

### Route Example

```php
Route::get('/users/{id}', function ($id) {
    return 'User ' . $id;
});
```

## Controllers
-------------

### Controller Structure

* `__construct()`: Constructor method
* `index()`: Index method
* `create()`: Create method
* `store()`: Store method
* `show()`: Show method
* `edit()`: Edit method
* `update()`: Update method
* `destroy()`: Destroy method

### Controller Example

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return 'User index';
    }

    public function create()
    {
        return 'User create';
    }

    public function store(Request $request)
    {
        return 'User store';
    }

    public function show($id)
    {
        return 'User show ' . $id;
    }

    public function edit($id)
    {
        return 'User edit ' . $id;
    }

    public function update(Request $request, $id)
    {
        return 'User update ' . $id;
    }

    public function destroy($id)
    {
        return 'User destroy ' . $id;
    }
}
```

## Models
--------

### Model Structure

* `__construct()`: Constructor method
* `fillable`: Fillable attributes
* `guarded`: Guarded attributes

### Model Example

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'email'];
    protected $guarded = ['id'];
}
```

## Views
------

### View Structure

* `index.blade.php`: Index view
* `create.blade.php`: Create view
* `show.blade.php`: Show view
* `edit.blade.php`: Edit view
* `update.blade.php`: Update view
* `destroy.blade.php`: Destroy view

### View Example

```php
<!-- resources/views/index.blade.php -->

<h1>User index</h1>

<ul>
    @foreach ($users as $user)
        <li>{{ $user->name }}</li>
    @endforeach
</ul>
```

## Database
----------

### Migration Structure

* `up()`: Up method
* `down()`: Down method

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
----------------

### Authentication Structure

* `AuthServiceProvider`: Authentication service provider
* `LoginController`: Login controller
* `RegisterController`: Register controller
* `ForgotPasswordController`: Forgot password controller
* `ResetPasswordController`: Reset password controller

### Authentication Example

```php
// app/Providers/AuthServiceProvider.php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        'App\Models\User' => 'App\Policies\UserPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view-users', function ($user) {
            return $user->hasRole('admin');
        });
    }
}
```

## Authorization
----------------

### Authorization Structure

* `Policy`: Policy class
* `Gate`: Gate facade

### Authorization Example

```php
// app/Policies/UserPolicy.php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->hasRole('admin');
    }

    public function update(User $user)
    {
        return $user->hasRole('admin');
    }
}
```

## Migrations
-------------

### Migration Structure

* `up()`: Up method
* `down()`: Down method

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

* `run()`: Run method

### Seeder Example

```php
// database/seeds/UserSeeder.php

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

* `test()`: Test method

### Test Example

```php
// tests/Feature/UserTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function test_user_index()
    {
        $response = $this->get('/users');

        $response->assertStatus(200);
    }
}
```