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
   DB_DATABASE=project-name
   DB_USERNAME=root
   DB_PASSWORD=
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
* `config/database.php`: Database configuration file
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
        $user->email = $request->input('email');
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
    protected $fillable = ['name', 'email'];
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
        <li>{{ $user->name }} ({{ $user->email }})</li>
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
// database/migrations/2022_01_01_000000_create_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

### Seeder Example

```php
// database/seeds/DatabaseSeeder.php

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

### Authentication Methods

* `login()`: Login user
* `logout()`: Logout user
* `register()`: Register user

### Authentication Example

```php
// app/Http/Controllers/Auth/LoginController.php

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

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
```

## Migration
------------

### Migration Structure

* `database/migrations/`: Migration files
* `database/migrations/2022_01_01_000000_create_users_table.php`: User migration file

### Migration Example

```php
// database/migrations/2022_01_01_000000_create_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
* `database/seeds/DatabaseSeeder.php`: Database seeder file

### Seeder Example

```php
// database/seeds/DatabaseSeeder.php

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
* `tests/Feature/`: Feature test files
* `tests/Unit/`: Unit test files

### Testing Example

```php
// tests/Feature/UserTest.php

namespace Tests\Feature;

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
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);
    }
}
```