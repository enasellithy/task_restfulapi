```php
<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_can_be_created()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function test_user_can_be_updated()
    {
        $user = User::factory()->create();

        $user->update([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);
    }

    public function test_password_is_hashed()
    {
        $user = User::factory()->create();

        $this->assertNotEquals($user->password, bcrypt('password'));
    }

    public function test_password_is_set_correctly()
    {
        $user = new User();
        $user->password = 'password';
        $user->save();

        $this->assertEquals(bcrypt('password'), $user->password);
    }

    public function test_email_verified_at_is_casted_to_datetime()
    {
        $user = User::factory()->create();

        $this->assertIsString($user->email_verified_at);
        $this->assertMatchesRegularExpression('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $user->email_verified_at);
    }

    public function test_email_verified_at_is_null_by_default()
    {
        $user = new User();

        $this->assertNull($user->email_verified_at);
    }
}
```