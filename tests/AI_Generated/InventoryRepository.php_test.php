```php
<?php

namespace Tests\Unit\Repositories;

use App\Models\Stock;
use App\Models\Warehouse;
use App\Solid\Repositories\InventoryRepository;
use Illuminate\Support\Facades\Cache;
use Mockery;
use Tests\TestCase;

class InventoryRepositoryTest extends TestCase
{
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new InventoryRepository();
    }

    public function test_get_all()
    {
        $request = Mockery::mock('Illuminate\Http\Request');
        $request->shouldReceive('filled')->andReturn(true);
        $request->shouldReceive('warehouse_id')->andReturn(1);
        $request->shouldReceive('name')->andReturn('test');
        $request->shouldReceive('sku')->andReturn('test');
        $request->shouldReceive('min_price')->andReturn(10);
        $request->shouldReceive('max_price')->andReturn(20);
        $request->shouldReceive('per_page')->andReturn(10);

        $cacheKey = 'inventory_' . md5($request->fullUrl());
        Cache::shouldReceive('remember')->andReturnUsing(function ($key, $ttl, $callback) {
            return $callback();
        });

        $stock = Mockery::mock('App\Models\Stock');
        $stock->shouldReceive('with')->andReturn($stock);
        $stock->shouldReceive('whereHas')->andReturn($stock);
        $stock->shouldReceive('paginate')->andReturn($stock);

        $this->repository->getAll($request);

        $this->assertTrue(true);
    }

    public function test_get_all_warehouses()
    {
        $data = Mockery::mock('Illuminate\Pagination\LengthAwarePaginator');
        $data->shouldReceive('latest')->andReturn($data);
        $data->shouldReceive('paginate')->andReturn($data);
        $data->shouldReceive('makeHidden')->andReturn($data);

        $warehouse = Mockery::mock('App\Models\Warehouse');
        $warehouse->shouldReceive('latest')->andReturn($warehouse);
        $warehouse->shouldReceive('paginate')->andReturn($data);

        $this->repository->getAllWarehouses();

        $this->assertTrue(true);
    }

    public function test_show_warehouse()
    {
        $data = Mockery::mock('App\Models\Warehouse');
        $data->shouldReceive('with')->andReturn($data);
        $data->shouldReceive('find')->andReturn($data);

        $this->repository->showWarehouse(1);

        $this->assertTrue(true);
    }
}
```