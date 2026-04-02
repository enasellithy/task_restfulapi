```php
<?php

namespace Tests\Unit\Http\Controllers\Api\V1;

use Tests\TestCase;
use App\Http\Controllers\Api\V1\WarehouseController;
use App\Solid\Repositories\InventoryRepository;
use Mockery;
use Illuminate\Http\Request;

class WarehouseControllerTest extends TestCase
{
    public function testIndex()
    {
        $inventoryRepository = Mockery::mock(InventoryRepository::class);
        $inventoryRepository->shouldReceive('getAllWarehouses')->andReturn(['warehouses' => ['warehouse1', 'warehouse2']]);

        $warehouseController = new WarehouseController($inventoryRepository);
        $response = $warehouseController->index();

        $this->assertEquals(['warehouses' => ['warehouse1', 'warehouse2']], $response);
    }

    public function testShow()
    {
        $inventoryRepository = Mockery::mock(InventoryRepository::class);
        $inventoryRepository->shouldReceive('showWarehouse')->with(1)->andReturn(['warehouse' => 'warehouse1']);

        $warehouseController = new WarehouseController($inventoryRepository);
        $response = $warehouseController->show(1);

        $this->assertEquals(['warehouse' => 'warehouse1'], $response);
    }

    public function testInventory()
    {
        $inventoryRepository = Mockery::mock(InventoryRepository::class);
        $inventoryRepository->shouldReceive('showWarehouse')->with(1, Mockery::any())->andReturn(['warehouse' => 'warehouse1']);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('all')->andReturn(['inventory' => 'inventory1']);

        $warehouseController = new WarehouseController($inventoryRepository);
        $response = $warehouseController->inventory(1);

        $this->assertEquals(['warehouse' => 'warehouse1'], $response);
    }
}
```