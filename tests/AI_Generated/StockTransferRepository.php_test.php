```php
<?php

namespace Tests\Unit\Repositories;

use App\Models\Stock;
use App\Models\StockTransfer;
use App\Solid\Repositories\StockTransferRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class StockTransferRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateTransfer()
    {
        $data = [
            'from_warehouse_id' => 1,
            'to_warehouse_id' => 2,
            'inventory_item_id' => 1,
            'quantity' => 10,
            'status' => 'pending',
        ];

        $repository = new StockTransferRepository();
        $transfer = $repository->create($data);

        $this->assertDatabaseHas('stock_transfers', [
            'id' => $transfer->id,
            'from_warehouse_id' => $data['from_warehouse_id'],
            'to_warehouse_id' => $data['to_warehouse_id'],
            'inventory_item_id' => $data['inventory_item_id'],
            'quantity' => $data['quantity'],
            'status' => $data['status'],
        ]);

        $this->assertDatabaseHas('stocks', [
            'warehouse_id' => $data['from_warehouse_id'],
            'inventory_item_id' => $data['inventory_item_id'],
            'quantity' => 10,
        ]);

        $this->assertDatabaseHas('stocks', [
            'warehouse_id' => $data['to_warehouse_id'],
            'inventory_item_id' => $data['inventory_item_id'],
            'quantity' => 0,
        ]);
    }

    public function testUpdateTransfer()
    {
        $data = [
            'from_warehouse_id' => 1,
            'to_warehouse_id' => 2,
            'inventory_item_id' => 1,
            'quantity' => 10,
            'status' => 'pending',
        ];

        $transfer = StockTransfer::create($data);

        $newData = [
            'from_warehouse_id' => 3,
            'to_warehouse_id' => 4,
            'inventory_item_id' => 2,
            'quantity' => 20,
            'status' => 'pending',
        ];

        $repository = new StockTransferRepository();
        $updatedTransfer = $repository->updateTransfer($transfer, $newData);

        $this->assertDatabaseHas('stock_transfers', [
            'id' => $updatedTransfer->id,
            'from_warehouse_id' => $newData['from_warehouse_id'],
            'to_warehouse_id' => $newData['to_warehouse_id'],
            'inventory_item_id' => $newData['inventory_item_id'],
            'quantity' => $newData['quantity'],
            'status' => $newData['status'],
        ]);

        $this->assertDatabaseHas('stocks', [
            'warehouse_id' => $newData['from_warehouse_id'],
            'inventory_item_id' => $newData['inventory_item_id'],
            'quantity' => 20,
        ]);

        $this->assertDatabaseHas('stocks', [
            'warehouse_id' => $newData['to_warehouse_id'],
            'inventory_item_id' => $newData['inventory_item_id'],
            'quantity' => 0,
        ]);
    }

    public function testDeleteTransfer()
    {
        $data = [
            'from_warehouse_id' => 1,
            'to_warehouse_id' => 2,
            'inventory_item_id' => 1,
            'quantity' => 10,
            'status' => 'completed',
        ];

        $transfer = StockTransfer::create($data);

        $repository = new StockTransferRepository();
        $deleted = $repository->deleteTransfer($transfer);

        $this->assertTrue($deleted);

        $this->assertDatabaseMissing('stock_transfers', [
            'id' => $transfer->id,
        ]);

        $this->assertDatabaseHas('stocks', [
            'warehouse_id' => $data['from_warehouse_id'],
            'inventory_item_id' => $data['inventory_item_id'],
            'quantity' => 10,
        ]);

        $this->assertDatabaseHas('stocks', [
            'warehouse_id' => $data['to_warehouse_id'],
            'inventory_item_id' => $data['inventory_item_id'],
            'quantity' => 0,
        ]);
    }

    public function testExecuteTransfer()
    {
        $data = [
            'from_warehouse_id' => 1,
            'to_warehouse_id' => 2,
            'inventory_item_id' => 1,
            'quantity' => 10,
            'status' => 'completed',
        ];

        $transfer = StockTransfer::create($data);

        $repository = new StockTransferRepository();
        $repository->executeTransfer($transfer);

        $this->assertDatabaseHas('stocks', [
            'warehouse_id' => $data['from_warehouse_id'],
            'inventory_item_id' => $data['inventory_item_id'],
            'quantity' => 0,
        ]);

        $this->assertDatabaseHas('stocks', [
            'warehouse_id' => $data['to_warehouse_id'],
            'inventory_item_id' => $data['inventory_item_id'],
            'quantity' => 10,
        ]);
    }

    public function testReverseTransfer()
    {
        $data = [
            'from_warehouse_id' => 1,
            'to_warehouse_id' => 2,
            'inventory_item_id' => 1,
            'quantity' => 10,
            'status' => 'completed',
        ];

        $transfer = StockTransfer::create($data);

        $repository = new StockTransferRepository();
        $repository->reverseTransfer($transfer);

        $this->assertDatabaseHas('stocks', [
            'warehouse_id' => $data['from_warehouse_id'],
            'inventory_item_id' => $data['inventory_item_id'],
            'quantity' => 10,
        ]);

        $this->assertDatabaseHas('stocks', [
            'warehouse_id' => $data['to_warehouse_id'],
            'inventory_item_id' => $data['inventory_item_id'],
            'quantity' => 0,
        ]);
    }

    public function testIsCriticalDataChanged()
    {
        $data = [
            'from_warehouse_id' => 1,
            'to_warehouse_id' => 2,
            'inventory_item_id' => 1,
            'quantity' => 10,
            'status' => 'completed',
        ];

        $transfer = StockTransfer::create($data);

        $newData = [
            'from_warehouse_id' => 3,
            'to_warehouse_id' => 4,
            'inventory_item_id' => 2,
            'quantity' => 20,
            'status' => 'completed',
        ];

        $repository = new StockTransferRepository();
        $this->assertTrue($repository->isCriticalDataChanged($transfer, $newData));
    }
}
```