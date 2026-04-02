```php
<?php

namespace Tests\Unit\Controllers\Api\V1;

use Tests\TestCase;
use App\Solid\Repositories\InventoryRepository;
use Illuminate\Http\Request;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;

class InventoryControllerTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_all_inventory()
    {
        $inventoryRepository = Mockery::mock(InventoryRepository::class);
        $inventoryRepository->shouldReceive('getAll')->andReturn([
            ['id' => 1, 'name' => 'Product 1'],
            ['id' => 2, 'name' => 'Product 2'],
        ]);

        $controller = new \App\Http\Controllers\Api\V1\InventoryController($inventoryRepository);

        $response = $controller->index();

        $this->assertEquals([
            ['id' => 1, 'name' => 'Product 1'],
            ['id' => 2, 'name' => 'Product 2'],
        ], $response);
    }

    /**
     * @test
     */
    public function it_stores_a_new_resource_in_storage()
    {
        $inventoryRepository = Mockery::mock(InventoryRepository::class);
        $inventoryRepository->shouldReceive('store')->with([
            'name' => 'Product 1',
            'quantity' => 10,
        ])->andReturn(true);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('all')->andReturn([
            'name' => 'Product 1',
            'quantity' => 10,
        ]);

        $controller = new \App\Http\Controllers\Api\V1\InventoryController($inventoryRepository);

        $response = $controller->store($request);

        $this->assertTrue($response);
    }

    /**
     * @test
     */
    public function it_displays_the_specified_resource()
    {
        $inventoryRepository = Mockery::mock(InventoryRepository::class);
        $inventoryRepository->shouldReceive('show')->with(1)->andReturn([
            'id' => 1,
            'name' => 'Product 1',
        ]);

        $controller = new \App\Http\Controllers\Api\V1\InventoryController($inventoryRepository);

        $response = $controller->show(1);

        $this->assertEquals([
            'id' => 1,
            'name' => 'Product 1',
        ], $response);
    }

    /**
     * @test
     */
    public function it_updates_the_specified_resource_in_storage()
    {
        $inventoryRepository = Mockery::mock(InventoryRepository::class);
        $inventoryRepository->shouldReceive('update')->with(1, [
            'name' => 'Product 1',
            'quantity' => 10,
        ])->andReturn(true);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('all')->andReturn([
            'name' => 'Product 1',
            'quantity' => 10,
        ]);

        $controller = new \App\Http\Controllers\Api\V1\InventoryController($inventoryRepository);

        $response = $controller->update($request, 1);

        $this->assertTrue($response);
    }

    /**
     * @test
     */
    public function it_removes_the_specified_resource_from_storage()
    {
        $inventoryRepository = Mockery::mock(InventoryRepository::class);
        $inventoryRepository->shouldReceive('destroy')->with(1)->andReturn(true);

        $controller = new \App\Http\Controllers\Api\V1\InventoryController($inventoryRepository);

        $response = $controller->destroy(1);

        $this->assertTrue($response);
    }
}
```