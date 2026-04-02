# User Model Documentation
=====================================

## Overview
------------

The `User` model represents a user in the application. It extends the `Authenticatable` class from Laravel's authentication system.

## Properties
------------

### Fillable Attributes
----------------------

The following attributes can be mass assigned:

* `name`: The user's name.
* `email`: The user's email address.
* `password`: The user's password.

```php
protected $fillable = [
    'name',
    'email',
    'password',
];
```

### Hidden Attributes
----------------------

The following attributes are hidden from serialization:

* `password`: The user's password.
* `remember_token`: The user's remember token.

```php
protected $hidden = [
    'password',
    'remember_token',
];
```

### Casts
---------

The following attributes are cast to specific types:

* `email_verified_at`: Cast to `datetime`.
* `password`: Cast to `hashed`.

```php
protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
```

## Methods
----------

### setPasswordAttribute

Sets the user's password using bcrypt.

```php
public function setPasswordAttribute($value){
    $this->attributes['password'] = bcrypt($value);
}
```

## Traits
---------

The `User` model uses the following traits:

* `HasApiTokens`: Provides API token functionality.
* `HasFactory`: Provides factory functionality for creating model instances.
* `Notifiable`: Provides notification functionality.

```php
use HasApiTokens, HasFactory, Notifiable;
```