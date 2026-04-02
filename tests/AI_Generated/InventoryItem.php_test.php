```php
<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\InventoryItem;
use App\Models\Stock;
use App\Models\StockTransfer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InventoryItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_inventory_item_has_many_stocks()
    {
        $inventoryItem = InventoryItem::factory()->create();
        $stock = Stock::factory()->create(['inventory_item_id' => $inventoryItem->id]);

        $this->assertTrue($inventoryItem->stocks()->contains($stock));
    }

    public function test_inventory_item_has_many_transfers()
    {
        $inventoryItem = InventoryItem::factory()->create();
        $transfer = StockTransfer::factory()->create(['inventory_item_id' => $inventoryItem->id]);

        $this->assertTrue($inventoryItem->transfers()->contains($transfer));
    }

    public function test_inventory_item_is_not_null()
    {
        $inventoryItem = InventoryItem::factory()->create();

        $this->assertNotNull($inventoryItem);
    }

    public function test_inventory_item_has_factory()
    {
        $inventoryItem = InventoryItem::factory()->create();

        $this->assertInstanceOf(InventoryItem::class, $inventoryItem);
    }
}
```