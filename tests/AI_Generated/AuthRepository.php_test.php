```php
<?php

namespace Tests\Unit\Solid\Repositories;

use App\Solid\Repositories\AuthRepository;
use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthRepositoryTest extends TestCase
{
    public function test_login_success()
    {
        $user = factory(\App\Models\User::class)->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = AuthRepository::login([
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertTrue(Auth::check());
        $this->assertArrayHasKey('token', $response);
        $this->assertArrayHasKey('user', $response);
        $this->assertInstanceOf(UserResource::class, $response['user']);
    }

    public function test_login_failure()
    {
        $response = AuthRepository::login([
            'email' => 'invalid@example.com',
            'password' => 'invalid',
        ]);

        $this->assertFalse(Auth::check());
        $this->assertArrayHasKey('error', $response);
        $this->assertEquals('Error Try Again Later', $response['error']);
    }

    public function test_login_empty_credentials()
    {
        $response = AuthRepository::login([]);

        $this->assertFalse(Auth::check());
        $this->assertArrayHasKey('error', $response);
        $this->assertEquals('Error Try Again Later', $response['error']);
    }
}
```