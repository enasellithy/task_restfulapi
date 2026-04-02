# AuthController
================

## Overview
--------

The `AuthController` is responsible for handling user authentication and registration requests.

## Dependencies
------------

* `App\Http\Controllers\Controller`
* `App\Http\Requests\Api\V1\Auth\LoginRequest`
* `App\Http\Requests\Api\V1\Auth\RegisterRequest`
* `App\Models\User`
* `App\Solid\Repositories\AuthRepository`
* `App\Solid\Traits\JsonTrait`

## Properties
------------

### `data`

* Type: `AuthRepository`
* Description: An instance of the `AuthRepository` class used for authentication operations.

## Methods
-------

### `__construct`

* Description: Initializes the `AuthController` instance with an instance of the `AuthRepository` class.
* Parameters:
	+ `$data`: An instance of the `AuthRepository` class.

### `register`

* Description: Handles user registration requests.
* Parameters:
	+ `$r`: An instance of the `RegisterRequest` class containing the registration data.
* Returns:
	+ A JSON response indicating the registration status.

### `login`

* Description: Handles user login requests.
* Parameters:
	+ `$r`: An instance of the `LoginRequest` class containing the login data.
* Returns:
	+ A JSON response containing the login result.

## Example Usage
--------------

### Registering a New User

```bash
POST /api/v1/auth/register HTTP/1.1
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john.doe@example.com",
    "password": "password123"
}
```

### Logging In an Existing User

```bash
POST /api/v1/auth/login HTTP/1.1
Content-Type: application/json

{
    "email": "john.doe@example.com",
    "password": "password123"
}
```

## API Endpoints
----------------

### `POST /api/v1/auth/register`

* Description: Creates a new user account.
* Request Body: `RegisterRequest` instance containing the user data.

### `POST /api/v1/auth/login`

* Description: Authenticates an existing user.
* Request Body: `LoginRequest` instance containing the user credentials.