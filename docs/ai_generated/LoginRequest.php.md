# Login Request API Documentation
=====================================

## Overview
------------

The `LoginRequest` class is a form request that handles login API requests. It validates the user's email and password before allowing them to log in.

## Properties
------------

### authorize()

*   **Description**: Determines whether the user is authorized to make a login request.
*   **Return Value**: `true` if the user is authorized, `false` otherwise.

### rules()

*   **Description**: Defines the validation rules for the login request.
*   **Return Value**: An array of validation rules for the email and password fields.

### failedValidation()

*   **Description**: Handles validation failures by throwing an `HttpResponseException` with a JSON response.
*   **Parameters**: `$validator` - The validator instance that failed.

## Validation Rules
-------------------

### Email

*   **Required**: The email field is required.
*   **Email**: The email field must be a valid email address.
*   **Exists**: The email field must exist in the `users` table.

### Password

*   **Required**: The password field is required.
*   **Min**: The password field must be at least 6 characters long.
*   **Max**: The password field must be at most 25 characters long.

## Error Handling
-----------------

If the validation fails, the `failedValidation()` method is called, which throws an `HttpResponseException` with a JSON response containing the error message.

### Example Response

```json
{
    "error": "The email field is required."
}
```

## Usage
-----

To use the `LoginRequest` class, create a new instance of it in your controller's `store()` method:

```php
use App\Http\Requests\Api\V1\Auth\LoginRequest;

class LoginController extends Controller
{
    public function store(LoginRequest $request)
    {
        // Login logic here
    }
}
```

This will automatically validate the request data and throw an `HttpResponseException` if the validation fails.