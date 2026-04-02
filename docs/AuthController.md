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
4. Install dependencies using the following command:
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
* `app/Models/`: Model files
* `app/Providers/`: Provider files
* `app/Services/`: Service files
* `config/app.php`: Application configuration file
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

* `id`: Unique identifier
* `name`: String parameter
* `email`: Email parameter

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
* `update()`: Update data by ID
* `destroy()`: Delete data by ID

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
* `app/Models/User.php`: User model file

### Model Methods

* `all()`: Retrieve all data
* `find($id)`: Retrieve data by ID
* `create()`: Create data
* `update()`: Update data
* `delete()`: Delete data

### Model Examples

* `app/Models/User.php`:
   ```php
   namespace App\Models;

   use Illuminate\Database\Eloquent\Model;

   class User extends Model
   {
       protected $fillable = ['name', 'email'];

       public function scopeActive($query)
       {
           return $query->where('active', 1);
       }
   }
   ```

## Views
------

### View Structure

* `resources/views/`: View files
* `resources/views/users/`: User view files

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

## Authentication
--------------

### Authentication Structure

* `app/Http/Controllers/Auth/`: Authentication controller files
* `app/Http/Controllers/Auth/LoginController.php`: Login controller file
* `app/Http/Controllers/Auth/RegisterController.php`: Register controller file

### Authentication Methods

* `login()`: Login user
* `register()`: Register user
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

           if (!Auth::attempt($credentials)) {
               return redirect()->back()->withErrors(['Invalid credentials']);
           }

           return redirect()->route('home');
       }
   }
   ```

## Authorization
--------------

### Authorization Structure

* `app/Http/Controllers/Auth/`: Authorization controller files
* `app/Http/Controllers/Auth/AuthorizeController.php`: Authorize controller file

### Authorization Methods

* `authorize()`: Authorize user
* `unauthorize()`: Unauthorize user

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
           if (!Auth::check()) {
               return redirect()->route('login');
           }

           return redirect()->route('home');
       }
   }
   ```

## Migrations
------------

### Migration Structure

* `database/migrations/`: Migration files
* `database/migrations/2022_01_01_000000_create_users_table.php`: User migration file

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
* `database/seeds/UserTableSeeder.php`: User seeder file

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

## Testing
---------

### Testing Structure

* `tests/`: Test files
* `tests/Feature/`: Feature test files
* `tests/Unit/`: Unit test files

### Testing Examples

* `tests/Feature/UserTest.php`:
   ```php
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
   * `tests/Unit/UserTest.php`:
   ```php
   use Tests\TestCase;
   use App\Models\User;

   class UserTest extends TestCase
   {
       public function test_user_can_be_created()
       {
           $user = new User();
           $user->name = 'John Doe';
           $user->email = 'john.doe@example.com';
           $user->save();

           $this->assertNotNull($user);
       }
   }
   ```