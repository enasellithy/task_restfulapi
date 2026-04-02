# AuthRepository Class
======================

## Overview
-----------

The `AuthRepository` class is responsible for handling user authentication logic. It provides a method for logging in users and returns a JSON response with the user's token and details.

## Usage
-----

### Login Method
---------------

The `login` method takes an array of user credentials as input and attempts to authenticate the user using Laravel's built-in authentication system.

```php
public function login(array $data)
```

### Parameters
------------

* `$data`: An array containing the user's email and password.

### Return Value
--------------

The method returns a JSON response with the user's token and details if authentication is successful, or an error message if authentication fails.

### Example Response
-------------------

```json
{
    "token": "Bearer <token>",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john.doe@example.com"
    }
}
```

### Example Error Response
-------------------------

```json
{
    "error": "Error Try Again Later"
}
```

## Methods
---------

### `login(array $data)`

*   Attempts to authenticate the user using Laravel's built-in authentication system.
*   Returns a JSON response with the user's token and details if authentication is successful, or an error message if authentication fails.

## Traits
--------

### `JsonTrait`

The `JsonTrait` is used to handle JSON responses.

## Dependencies
------------

### `App\Http\Resources\Api\V1\UserResource`

The `UserResource` class is used to transform the user data into a JSON response.

### `Illuminate\Support\Facades\Auth`

The `Auth` facade is used to interact with Laravel's built-in authentication system.

## Version History
-----------------

*   1.0.0: Initial release.

## Changelog
------------

*   1.0.0: Added login method.

## API Documentation
-------------------

### Login Method

*   **POST /login**
*   **Request Body**
    *   `email`: The user's email address.
    *   `password`: The user's password.
*   **Response**
    *   `token`: The user's token.
    *   `user`: The user's details.