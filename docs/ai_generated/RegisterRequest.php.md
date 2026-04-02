# Register Request
================

## Overview
--------

The `RegisterRequest` class is a custom request class for handling user registration requests in the API.

## Usage
-----

This class is used to validate user registration requests. It checks for the presence of required fields, validates email addresses, and ensures that passwords meet certain criteria.

## Properties
------------

### authorize()

Determines whether the request is authorized to proceed.

```php
public function authorize()
{
    return true;
}
```

### rules()

Defines the validation rules for the request.

```php
public function rules()
{
    return [
        'name' => [
            'required',
            'string',
            'min:3',
            'max:25',
        ],
        'email' => [
            'required',
            'email',
            'unique:users',
        ],
        'password' => [
            'required',
            'min:6',
            'max:25',
        ],
        'password_confirm' => [
            'required',
            'same:password'
        ],
    ];
}
```

### failedValidation()

Handles validation failures by throwing an `HttpResponseException` with a JSON response.

```php
protected function failedValidation(Validator $validator)
{
    $err = $validator->errors()->first();
    throw new HttpResponseException($this->whenError($err));
}
```

## Methods
---------

### whenError()

Returns a JSON response with the error message.

```php
private function whenError($error)
{
    return response()->json(['error' => $error], 422);
}
```

## Traits
--------

### JsonTrait

Provides a `whenError()` method for returning a JSON response with the error message.

```php
use App\Solid\Traits\JsonTrait;
```