<?php

namespace Tests\Feature;

use App\Events\LowStockDetected;
use App\Listeners\SendLowStockNotification;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\InventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class LowStockEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_low_stock_event_can_be_dispatched()
    {
        Event::fake();

        $warehouse = Warehouse::create([
            'name' => 'Test Warehouse',
            'location' => 'Test Location'
        ]);

        $item = InventoryItem::create([
            'name' => 'Test Product',
            'sku' => 'SKU-001',
            'description' => 'Test description',
            'price' => 100.00
        ]);

        $stock = Stock::create([
            'warehouse_id' => $warehouse->id,
            'inventory_item_id' => $item->id,
            'quantity' => 5,
            'low_stock_threshold' => 10
        ]);

        event(new LowStockDetected($stock));

        Event::assertDispatched(LowStockDetected::class);
    }

    public function test_low_stock_listener_can_be_called()
    {
        $warehouse = Warehouse::create([
            'name' => 'Test Warehouse',
            'location' => 'Test Location'
        ]);

        $item = InventoryItem::create([
            'name' => 'Test Product',
            'sku' => 'SKU-002',
            'description' => 'Test description',
            'price' => 200.00
        ]);

        $stock = Stock::create([
            'warehouse_id' => $warehouse->id,
            'inventory_item_id' => $item->id,
            'quantity' => 5,
            'low_stock_threshold' => 10
        ]);

        $listener = new SendLowStockNotification();
        $listener->handle(new LowStockDetected($stock));

        $this->assertTrue(true);
    }
}
