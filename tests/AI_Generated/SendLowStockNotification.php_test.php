```php
<?php

namespace Tests\Feature\Listeners;

use App\Events\LowStockDetected;
use App\Models\InventoryItem;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SendLowStockNotificationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_handle_event_logs_low_stock_notification()
    {
        $inventoryItem = InventoryItem::factory()->create();
        $warehouse = Warehouse::factory()->create();
        $stock = $inventoryItem->warehouses()->save($warehouse, ['quantity' => 10, 'low_stock_threshold' => 5]);

        $event = new LowStockDetected($stock);

        $this->assertDatabaseMissing('logs', [
            'level' => 'warning',
            'channel' => 'low_stock',
            'context' => [
                'item_id' => $stock->inventory_item_id,
                'item_name' => $inventoryItem->name,
                'warehouse_id' => $stock->warehouse_id,
                'warehouse_name' => $warehouse->name,
                'current_quantity' => $stock->quantity,
                'threshold' => $stock->low_stock_threshold
            ]
        ]);

        $event->dispatch();

        $this->assertDatabaseHas('logs', [
            'level' => 'warning',
            'channel' => 'low_stock',
            'context' => [
                'item_id' => $stock->inventory_item_id,
                'item_name' => $inventoryItem->name,
                'warehouse_id' => $stock->warehouse_id,
                'warehouse_name' => $warehouse->name,
                'current_quantity' => $stock->quantity,
                'threshold' => $stock->low_stock_threshold
            ]
        ]);
    }

    public function test_handle_event_logs_low_stock_notification_with_unknown_item_name()
    {
        $inventoryItem = InventoryItem::factory()->create();
        $warehouse = Warehouse::factory()->create();
        $stock = $inventoryItem->warehouses()->save($warehouse, ['quantity' => 10, 'low_stock_threshold' => 5]);

        $event = new LowStockDetected($stock);

        $this->assertDatabaseMissing('logs', [
            'level' => 'warning',
            'channel' => 'low_stock',
            'context' => [
                'item_id' => $stock->inventory_item_id,
                'item_name' => 'Unknown',
                'warehouse_id' => $stock->warehouse_id,
                'warehouse_name' => $warehouse->name,
                'current_quantity' => $stock->quantity,
                'threshold' => $stock->low_stock_threshold
            ]
        ]);

        $event->dispatch();

        $this->assertDatabaseHas('logs', [
            'level' => 'warning',
            'channel' => 'low_stock',
            'context' => [
                'item_id' => $stock->inventory_item_id,
                'item_name' => 'Unknown',
                'warehouse_id' => $stock->warehouse_id,
                'warehouse_name' => $warehouse->name,
                'current_quantity' => $stock->quantity,
                'threshold' => $stock->low_stock_threshold
            ]
        ]);
    }

    public function test_handle_event_logs_low_stock_notification_with_unknown_warehouse_name()
    {
        $inventoryItem = InventoryItem::factory()->create();
        $warehouse = Warehouse::factory()->create();
        $stock = $inventoryItem->warehouses()->save($warehouse, ['quantity' => 10, 'low_stock_threshold' => 5]);

        $event = new LowStockDetected($stock);

        $this->assertDatabaseMissing('logs', [
            'level' => 'warning',
            'channel' => 'low_stock',
            'context' => [
                'item_id' => $stock->inventory_item_id,
                'item_name' => $inventoryItem->name,
                'warehouse_id' => $stock->warehouse_id,
                'warehouse_name' => 'Unknown',
                'current_quantity' => $stock->quantity,
                'threshold' => $stock->low_stock_threshold
            ]
        ]);

        $event->dispatch();

        $this->assertDatabaseHas('logs', [
            'level' => 'warning',
            'channel' => 'low_stock',
            'context' => [
                'item_id' => $stock->inventory_item_id,
                'item_name' => $inventoryItem->name,
                'warehouse_id' => $stock->warehouse_id,
                'warehouse_name' => 'Unknown',
                'current_quantity' => $stock->quantity,
                'threshold' => $stock->low_stock_threshold
            ]
        ]);
    }
}
```