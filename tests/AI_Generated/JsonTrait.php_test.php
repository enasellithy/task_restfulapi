```php
<?php

namespace Tests\Unit\Solid\Traits;

use Tests\TestCase;
use App\Solid\Traits\JsonTrait;
use Illuminate\Http\Response;

class JsonTraitTest extends TestCase
{
    private $trait;

    protected function setUp(): void
    {
        $this->trait = new class() extends JsonTrait {};
    }

    /**
     * @test
     */
    public function it_returns_success_response()
    {
        $data = ['test' => 'data'];
        $response = $this->trait->whenDone($data);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(true, $response->json('status'));
        $this->assertEquals('Success', $response->json('message'));
        $this->assertEquals($data, $response->json('data'));
    }

    /**
     * @test
     */
    public function it_returns_success_response_with_custom_message()
    {
        $data = ['test' => 'data'];
        $message = 'Custom message';
        $response = $this->trait->whenDone($data, $message);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(true, $response->json('status'));
        $this->assertEquals($message, $response->json('message'));
        $this->assertEquals($data, $response->json('data'));
    }

    /**
     * @test
     */
    public function it_returns_error_response()
    {
        $data = ['test' => 'error'];
        $response = $this->trait->whenError($data);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals(false, $response->json('status'));
        $this->assertEquals($data, $response->json('message'));
        $this->assertEquals(null, $response->json('data'));
    }
}
```