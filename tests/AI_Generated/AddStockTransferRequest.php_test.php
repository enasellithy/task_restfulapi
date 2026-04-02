```php
<?php

namespace Tests\Unit\Http\Requests\Api\V1\StockTransfer;

use App\Http\Requests\Api\V1\StockTransfer\AddStockTransferRequest;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddStockTransferRequestTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testAuthorizeReturnsTrue()
    {
        $request = new AddStockTransferRequest();
        $this->assertTrue($request->authorize());
    }

    public function testRulesPassesValidData()
    {
        $request = new AddStockTransferRequest();
        $request->merge([
            'from_warehouse_id' => 1,
            'to_warehouse_id'   => 2,
            'inventory_item_id' => 3,
            'quantity'          => 4,
            'notes'             => 'test',
        ]);

        $this->assertTrue($request->rules()->passes());
    }

    public function testRulesFailsWhenFromWarehouseIdIsInvalid()
    {
        $request = new AddStockTransferRequest();
        $request->merge([
            'from_warehouse_id' => '',
            'to_warehouse_id'   => 2,
            'inventory_item_id' => 3,
            'quantity'          => 4,
            'notes'             => 'test',
        ]);

        $this->assertFalse($request->rules()->passes());
        $this->assertEquals('The from warehouse id field is required.', $request->errors()->first('from_warehouse_id'));
    }

    public function testRulesFailsWhenToWarehouseIdIsInvalid()
    {
        $request = new AddStockTransferRequest();
        $request->merge([
            'from_warehouse_id' => 1,
            'to_warehouse_id'   => '',
            'inventory_item_id' => 3,
            'quantity'          => 4,
            'notes'             => 'test',
        ]);

        $this->assertFalse($request->rules()->passes());
        $this->assertEquals('The to warehouse id field is required.', $request->errors()->first('to_warehouse_id'));
    }

    public function testRulesFailsWhenInventoryItemIdIsInvalid()
    {
        $request = new AddStockTransferRequest();
        $request->merge([
            'from_warehouse_id' => 1,
            'to_warehouse_id'   => 2,
            'inventory_item_id' => '',
            'quantity'          => 4,
            'notes'             => 'test',
        ]);

        $this->assertFalse($request->rules()->passes());
        $this->assertEquals('The inventory item id field is required.', $request->errors()->first('inventory_item_id'));
    }

    public function testRulesFailsWhenQuantityIsInvalid()
    {
        $request = new AddStockTransferRequest();
        $request->merge([
            'from_warehouse_id' => 1,
            'to_warehouse_id'   => 2,
            'inventory_item_id' => 3,
            'quantity'          => '',
            'notes'             => 'test',
        ]);

        $this->assertFalse($request->rules()->passes());
        $this->assertEquals('The quantity field is required.', $request->errors()->first('quantity'));
    }

    public function testRulesFailsWhenQuantityIsNotInteger()
    {
        $request = new AddStockTransferRequest();
        $request->merge([
            'from_warehouse_id' => 1,
            'to_warehouse_id'   => 2,
            'inventory_item_id' => 3,
            'quantity'          => 'test',
            'notes'             => 'test',
        ]);

        $this->assertFalse($request->rules()->passes());
        $this->assertEquals('The quantity must be an integer.', $request->errors()->first('quantity'));
    }

    public function testRulesFailsWhenQuantityIsLessThanOne()
    {
        $request = new AddStockTransferRequest();
        $request->merge([
            'from_warehouse_id' => 1,
            'to_warehouse_id'   => 2,
            'inventory_item_id' => 3,
            'quantity'          => 0,
            'notes'             => 'test',
        ]);

        $this->assertFalse($request->rules()->passes());
        $this->assertEquals('The quantity must be at least 1.', $request->errors()->first('quantity'));
    }

    public function testRulesFailsWhenFromWarehouseIdDoesNotHaveStock()
    {
        $request = new AddStockTransferRequest();
        $request->merge([
            'from_warehouse_id' => 1,
            'to_warehouse_id'   => 2,
            'inventory_item_id' => 3,
            'quantity'          => 4,
            'notes'             => 'test',
        ]);

        $stock = Stock::create([
            'warehouse_id' => 2,
            'inventory_item_id' => 3,
            'quantity' => 5,
        ]);

        $this->assertFalse($request->rules()->passes());
        $this->assertEquals('No quantity Available in warehouse', $request->errors()->first('from_warehouse_id'));
    }

    public function testRulesFailsWhenQuantityIsMoreThanAvailableStock()
    {
        $request = new AddStockTransferRequest();
        $request->merge([
            'from_warehouse_id' => 1,
            'to_warehouse_id'   => 2,
            'inventory_item_id' => 3,
            'quantity'          => 6,
            'notes'             => 'test',
        ]);

        $stock = Stock::create([
            'warehouse_id' => 1,
            'inventory_item_id' => 3,
            'quantity' => 5,
        ]);

        $this->assertFalse($request->rules()->passes());
        $this->assertEquals('quantity required (6) not available in warehouse', $request->errors()->first('from_warehouse_id'));
    }

    public function testFailedValidationThrowsHttpResponseException()
    {
        $request = new AddStockTransferRequest();
        $request->merge([
            'from_warehouse_id' => '',
            'to_warehouse_id'   => 2,
            'inventory_item_id' => 3,
            'quantity'          => 4,
            'notes'             => 'test',
        ]);

        $this->expectException(HttpResponseException::class);
        $this->expectExceptionMessage($request->whenError('The from warehouse id field is required.'));
        $request->failedValidation($request->validator());
    }
}
```