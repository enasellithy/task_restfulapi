```php
<?php

namespace Tests\Unit\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\StockTransferController;
use App\Http\Requests\Api\V1\StockTransfer\AddStockTransferRequest;
use App\Solid\Repositories\StockTransferRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockTransferControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller = new StockTransferController(
            new StockTransferRepository()
        );
    }

    /**
     * @test
     */
    public function store_request_is_valid()
    {
        $request = new AddStockTransferRequest();
        $request->merge([
            'field1' => 'value1',
            'field2' => 'value2',
        ]);

        $response = $this->controller->store($request);

        $this->assertTrue($response->successful());
    }

    /**
     * @test
     */
    public function store_request_is_invalid()
    {
        $request = new AddStockTransferRequest();
        $request->merge([
            'field1' => 'value1',
        ]);

        $response = $this->controller->store($request);

        $this->assertFalse($response->successful());
    }

    /**
     * @test
     */
    public function store_request_is_valid_and_create_stock_transfer()
    {
        $request = new AddStockTransferRequest();
        $request->merge([
            'field1' => 'value1',
            'field2' => 'value2',
        ]);

        $response = $this->controller->store($request);

        $this->assertTrue($response->successful());
        $this->assertDatabaseHas('stock_transfers', [
            'field1' => 'value1',
            'field2' => 'value2',
        ]);
    }
}
```