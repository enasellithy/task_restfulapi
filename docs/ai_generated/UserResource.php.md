# UserResource Class
=====================

## Overview
-----------

The `UserResource` class is a custom resource class for the `User` model, used to transform the model data into a JSON response for API requests.

## Class Definition
-------------------

```php
namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    // ...
}
```

## toArray Method
-----------------

The `toArray` method is used to transform the resource data into an array. This method is called automatically when the resource is converted to a JSON response.

### Parameters
------------

* `$request`: The current HTTP request instance.

### Returns
----------

* `array`: An array containing the transformed resource data.

### Example
--------

```php
public function toArray(Request $request): array
{
    return [
        'id' => $this->id,
        'name' => $this->name,
        'email' => $this->email,
    ];
}
```

## Usage
-----

To use the `UserResource` class, you can create a new instance of the class and pass the `User` model instance to it. The `toArray` method will be called automatically when the resource is converted to a JSON response.

```php
$user = User::find(1);
$userResource = new UserResource($user);
return $userResource;
```

This will return a JSON response containing the transformed `User` model data.

## API Documentation
-------------------

### GET /users/{id}

* **Response:**
	+ `200 OK`
		- `id`: The user ID.
		- `name`: The user name.
		- `email`: The user email.

### Example Response
--------------------

```json
{
    "id": 1,
    "name": "John Doe",
    "email": "john.doe@example.com"
}
```