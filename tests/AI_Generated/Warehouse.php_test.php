```php
<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Warehouse;
use App\Models\Stock;
use App\Models\StockTransfer;

class WarehouseTest extends TestCase
{
    public function test_warehouses_table()
    {
        $warehouse = new Warehouse();
        $this->assertEquals('warehouses', $warehouse->getTable());
    }

    public function test_warehouses_guarded()
    {
        $warehouse = new Warehouse();
        $this->assertEmpty($warehouse->getGuarded());
    }

    public function test_stocks_relationship()
    {
        $warehouse = new Warehouse();
        $this->assertInstanceOf(Stock::class, $warehouse->stocks());
    }

    public function test_outgoing_transfers_relationship()
    {
        $warehouse = new Warehouse();
        $this->assertInstanceOf(StockTransfer::class, $warehouse->outgoingTransfers());
    }

    public function test_incoming_transfers_relationship()
    {
        $warehouse = new Warehouse();
        $this->assertInstanceOf(StockTransfer::class, $warehouse->incomingTransfers());
    }

    public function test_stocks_transfer_direction()
    {
        $warehouse = new Warehouse();
        $this->assertNotEquals($warehouse->stocks()->getRelated()->first()->id, $warehouse->outgoingTransfers()->getRelated()->first()->from_warehouse_id);
        $this->assertNotEquals($warehouse->stocks()->getRelated()->first()->id, $warehouse->incomingTransfers()->getRelated()->first()->to_warehouse_id);
    }
}
```