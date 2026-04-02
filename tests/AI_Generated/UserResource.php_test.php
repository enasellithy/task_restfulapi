```php
<?php

namespace Tests\Unit\Resources\Api\V1;

use Tests\TestCase;
use App\Models\User;
use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Http\Request;

class UserResourceTest extends TestCase
{
    public function test_user_resource_returns_expected_data()
    {
        $user = User::factory()->create();

        $request = new Request();
        $resource = new UserResource($user);

        $data = $resource->toArray($request);

        $this->assertEquals($user->id, $data['id']);
        $this->assertEquals($user->name, $data['name']);
        $this->assertEquals($user->email, $data['email']);
    }

    public function test_user_resource_returns_null_when_user_is_null()
    {
        $request = new Request();
        $resource = new UserResource(null);

        $data = $resource->toArray($request);

        $this->assertNull($data);
    }
}
```