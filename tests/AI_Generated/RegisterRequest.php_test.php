```php
<?php

namespace Tests\Unit\Http\Requests\Api\V1\Auth;

use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterRequestTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_register_request_rules()
    {
        $request = new RegisterRequest();
        $this->assertEquals([
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
        ], $request->rules());
    }

    public function test_register_request_authorize()
    {
        $request = new RegisterRequest();
        $this->assertTrue($request->authorize());
    }

    public function test_register_request_name_validation()
    {
        $request = new RegisterRequest();
        $request->merge(['name' => '']);
        $this->assertFalse($request->passes());
        $this->assertEquals(['name' => ['The name field is required.']], $request->errors()->all());
    }

    public function test_register_request_email_validation()
    {
        $request = new RegisterRequest();
        $request->merge(['email' => 'invalid_email']);
        $this->assertFalse($request->passes());
        $this->assertEquals(['email' => ['The email must be a valid email address.']], $request->errors()->all());
    }

    public function test_register_request_email_unique_validation()
    {
        $request = new RegisterRequest();
        $request->merge(['email' => 'test@example.com']);
        $this->assertFalse($request->passes());
        $this->assertEquals(['email' => ['The email has already been taken.']], $request->errors()->all());
    }

    public function test_register_request_password_validation()
    {
        $request = new RegisterRequest();
        $request->merge(['password' => '']);
        $this->assertFalse($request->passes());
        $this->assertEquals(['password' => ['The password must be at least 6 characters.']], $request->errors()->all());
    }

    public function test_register_request_password_confirm_validation()
    {
        $request = new RegisterRequest();
        $request->merge(['password' => 'password', 'password_confirm' => 'wrong_password']);
        $this->assertFalse($request->passes());
        $this->assertEquals(['password_confirm' => ['The password confirm must be equal to password.']], $request->errors()->all());
    }
}
```