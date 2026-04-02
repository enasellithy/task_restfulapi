```php
<?php

namespace Tests\Unit\Http\Requests\Api\V1\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class LoginRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_request_rules()
    {
        $request = new Request();
        $request->merge([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $loginRequest = new LoginRequest($request);
        $this->assertTrue($loginRequest->authorize());
        $this->assertEquals([
            'email' => [
                'required',
                'email',
                'exists:users,email',
            ],
            'password' => [
                'required',
                'min:6',
                'max:25',
            ],
        ], $loginRequest->rules());
    }

    public function test_login_request_email_validation()
    {
        $request = new Request();
        $request->merge([
            'email' => 'invalid_email',
            'password' => 'password',
        ]);

        $loginRequest = new LoginRequest($request);
        $this->expectException(ValidationException::class);
        $loginRequest->validate();
    }

    public function test_login_request_password_validation()
    {
        $request = new Request();
        $request->merge([
            'email' => 'test@example.com',
            'password' => 'short',
        ]);

        $loginRequest = new LoginRequest($request);
        $this->expectException(ValidationException::class);
        $loginRequest->validate();
    }

    public function test_login_request_password_max_validation()
    {
        $request = new Request();
        $request->merge([
            'email' => 'test@example.com',
            'password' => 'passwordpasswordpasswordpasswordpassword',
        ]);

        $loginRequest = new LoginRequest($request);
        $this->expectException(ValidationException::class);
        $loginRequest->validate();
    }

    public function test_login_request_email_exists_validation()
    {
        $request = new Request();
        $request->merge([
            'email' => 'non_existent_email@example.com',
            'password' => 'password',
        ]);

        $loginRequest = new LoginRequest($request);
        $this->expectException(ValidationException::class);
        $loginRequest->validate();
    }
}
```