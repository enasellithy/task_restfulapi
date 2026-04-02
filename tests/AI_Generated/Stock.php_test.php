```php
<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\InventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    public function test_stock_belongs_to_warehouse()
    {
        $warehouse = Warehouse::factory()->create();
        $stock = Stock::factory()->create(['warehouse_id' => $warehouse->id]);

        $this->assertTrue($stock->warehouse()->get()->contains($warehouse));
    }

    public function test_stock_belongs_to_inventory_item()
    {
        $inventoryItem = InventoryItem::factory()->create();
        $stock = Stock::factory()->create(['inventory_item_id' => $inventoryItem->id]);

        $this->assertTrue($stock->inventoryItem()->get()->contains($inventoryItem));
    }

    public function test_stock_table_name()
    {
        $this->assertEquals('stocks', Stock::getTable());
    }

    public function test_stock_guarded_columns()
    {
        $this->assertNull(Stock::$guarded);
    }
}
```