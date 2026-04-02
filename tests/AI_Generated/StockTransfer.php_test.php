```php
<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\StockTransfer;
use App\Models\Warehouse;
use App\Models\InventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockTransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_stock_transfer_model_exists()
    {
        $this->assertTrue(class_exists(StockTransfer::class));
    }

    public function test_stock_transfer_model_has_factory()
    {
        $this->assertTrue(method_exists(StockTransfer::class, 'newFactory'));
    }

    public function test_stock_transfer_model_has_table()
    {
        $this->assertEquals('stock_transfers', StockTransfer::$table);
    }

    public function test_stock_transfer_model_has_fillable()
    {
        $fillable = StockTransfer::$fillable;
        $this->assertIsArray($fillable);
        $this->assertCount(7, $fillable);
        $this->assertContains('from_warehouse_id', $fillable);
        $this->assertContains('to_warehouse_id', $fillable);
        $this->assertContains('inventory_item_id', $fillable);
        $this->assertContains('quantity', $fillable);
        $this->assertContains('status', $fillable);
        $this->assertContains('notes', $fillable);
        $this->assertContains('transferred_at', $fillable);
    }

    public function test_stock_transfer_model_has_from_warehouse_relationship()
    {
        $stockTransfer = StockTransfer::factory()->create();
        $this->assertInstanceOf(Warehouse::class, $stockTransfer->fromWarehouse);
    }

    public function test_stock_transfer_model_has_to_warehouse_relationship()
    {
        $stockTransfer = StockTransfer::factory()->create();
        $this->assertInstanceOf(Warehouse::class, $stockTransfer->toWarehouse);
    }

    public function test_stock_transfer_model_has_inventory_item_relationship()
    {
        $stockTransfer = StockTransfer::factory()->create();
        $this->assertInstanceOf(InventoryItem::class, $stockTransfer->inventoryItem);
    }

    public function test_stock_transfer_model_sets_status_to_completed_on_create()
    {
        $stockTransfer = StockTransfer::factory()->create();
        $this->assertEquals('completed', $stockTransfer->status);
    }
}
```