# JsonTrait Documentation
==========================

## Overview
-----------

The `JsonTrait` is a reusable PHP trait that provides methods for generating JSON responses in a Laravel application.

## Methods
---------

### whenDone($data, $message = null)

*   **Description:** Returns a successful JSON response with the provided data and optional message.
*   **Parameters:**
    *   `$data`: The data to be returned in the response.
    *   `$message`: An optional message to be included in the response (default: 'Success').
*   **Returns:** A JSON response with a 200 status code.

### whenError($data)

*   **Description:** Returns an error JSON response with the provided data.
*   **Parameters:**
    *   `$data`: The data to be returned in the response.
*   **Returns:** A JSON response with a 400 status code.

## Example Usage
---------------

```php
use App\Solid\Traits\JsonTrait;

class MyController extends Controller
{
    use JsonTrait;

    public function myMethod()
    {
        $data = ['key' => 'value'];
        $message = 'My custom message';

        $response = $this->whenDone($data, $message);
        // or
        $response = $this->whenError('Invalid data');
    }
}
```

## API Documentation
-------------------

### whenDone($data, $message = null)

*   **HTTP Method:** GET, POST, PUT, DELETE, etc.
*   **URL:** /
*   **Request Body:** None
*   **Response:**
    *   **200 OK:** JSON response with the provided data and optional message.
    *   **Error:** JSON response with a 400 status code and an error message.

### whenError($data)

*   **HTTP Method:** GET, POST, PUT, DELETE, etc.
*   **URL:** /
*   **Request Body:** None
*   **Response:**
    *   **400 Bad Request:** JSON response with the provided data and an error message.