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

3. Install Node.js dependencies using the following command:
   ```bash
   npm install
   ```

4. Run the following command to create a new database and migrate the schema:
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
* `app/Models/`: Model files
* `app/Providers/`: Service provider files
* `config/app.php`: Application configuration file
* `database/migrations/`: Migration files
* `database/seeds/`: Seeder files
* `routes/web.php`: Web route file
* `routes/api.php`: API route file

## Routing
---------

### Route Types

* `GET`: Retrieve data
* `POST`: Create data
* `PUT`: Update data
* `DELETE`: Delete data

### Route Parameters

* `id`: Unique identifier for a resource
* `slug`: Unique identifier for a resource

### Route Examples

* `GET /users`: Retrieve all users
* `POST /users`: Create a new user
* `GET /users/{id}`: Retrieve a user by ID
* `PUT /users/{id}`: Update a user by ID
* `DELETE /users/{id}`: Delete a user by ID

## Controllers
-------------

### Controller Structure

* `app/Http/Controllers/`: Controller files
* `app/Http/Controllers/Controller.php`: Base controller file

### Controller Methods

* `index()`: Retrieve data
* `create()`: Create data
* `store()`: Store data
* `show()`: Retrieve data by ID
* `edit()`: Update data
* `update()`: Update data
* `destroy()`: Delete data

### Controller Examples

* `app/Http/Controllers/UserController.php`:
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
        $user->email = $request->input('email');
        $user->save();
        return redirect()->route('users.index');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
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
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.index');
    }
}
```

## Models
--------

### Model Structure

* `app/Models/`: Model files
* `app/Models/Model.php`: Base model file

### Model Methods

* `all()`: Retrieve all data
* `find($id)`: Retrieve data by ID
* `create($data)`: Create new data
* `update($id, $data)`: Update data by ID
* `delete($id)`: Delete data by ID

### Model Examples

* `app/Models/User.php`:
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

### View Structure

* `resources/views/`: View files
* `resources/views/layouts/`: Layout files
* `resources/views/partials/`: Partial files

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

### Database Structure

* `database/migrations/`: Migration files
* `database/seeds/`: Seeder files

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

### Seeder Examples

* `database/seeds/DatabaseSeeder.php`:
```php
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
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

* `app/Http/Controllers/Auth/`: Authentication controller files
* `app/Http/Controllers/Auth/LoginController.php`: Login controller file
* `app/Http/Controllers/Auth/RegisterController.php`: Register controller file

### Authentication Methods

* `login(Request $request)`: Login user
* `register(Request $request)`: Register new user
* `logout()`: Logout user

### Authentication Examples

* `app/Http/Controllers/Auth/LoginController.php`:
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

### Authorization Methods

* `authorize(Request $request)`: Authorize user
* `unauthorize(Request $request)`: Unauthorize user

### Authorization Examples

* `app/Http/Controllers/Auth/AuthorizeController.php`:
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
        return redirect()->route('login');
    }
}
```

## Migrations
------------

### Migration Structure

* `database/migrations/`: Migration files

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

* `database/seeds/`: Seeder files

### Seeder Examples

* `database/seeds/DatabaseSeeder.php`:
```php
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
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

### Testing Structure

* `tests/`: Test files

### Testing Examples

* `tests/ExampleTest.php`:
```php
namespace Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
```

This documentation covers the basics of Laravel, including installation, project structure, routing, controllers, models, views, database, authentication, authorization, migrations, seeding, and testing. It provides examples of how to implement each concept, making it easier for developers to understand and use Laravel in their projects.