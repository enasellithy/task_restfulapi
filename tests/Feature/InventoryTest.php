<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\InventoryItem;
use App\Models\Stock;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_inventory_list_with_filters(): void
    {
        $user = User::factory()->create();

        $warehouse = Warehouse::factory()->create([
            'id' => 2,
            'name' => 'Alex Center',
            'location' => 'Alexandria'
        ]);

        $inventoryItem = InventoryItem::factory()->create([
            'id' => 1,
            'name' => 'phone',
            'sku' => 'PHONE_001',
            'description' => 'Smart Phone',
            'price' => '300.00'
        ]);

        $stock = Stock::factory()->create([
            'id' => 12,
            'warehouse_id' => $warehouse->id,
            'inventory_item_id' => $inventoryItem->id,
            'quantity' => 95,
            'low_stock_threshold' => 11
        ]);

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/inventory?name=phone&min_price=100&max_price=500&warehouse_id=2&page=1');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'current_page',
                'data' => [
                    '*' => [
                        'id',
                        'warehouse_id',
                        'inventory_item_id',
                        'quantity',
                        'low_stock_threshold',
                        'created_at',
                        'updated_at',
                        'inventory_item' => [
                            'id',
                            'name',
                            'sku',
                            'description',
                            'price',
                            'created_at',
                            'updated_at'
                        ],
                        'warehouse' => [
                            'id',
                            'name',
                            'location',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]
        ]);

        $response->assertJson([
            'status' => true,
            'message' => 'Success',
            'data' => [
                'current_page' => 1,
                'data' => [
                    [
                        'id' => 12,
                        'warehouse_id' => 2,
                        'inventory_item_id' => 1,
                        'quantity' => 95,
                        'low_stock_threshold' => 11,
                        'inventory_item' => [
                            'id' => 1,
                            'name' => 'phone',
                            'sku' => 'PHONE_001',
                            'description' => 'Smart Phone',
                            'price' => '300.00'
                        ],
                        'warehouse' => [
                            'id' => 2,
                            'name' => 'Alex Center',
                            'location' => 'Alexandria'
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function test_inventory_list_without_authentication(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/inventory?name=phone&min_price=100&max_price=500&warehouse_id=2&page=1');

        $response->assertStatus(401);
    }

    public function test_inventory_list_with_invalid_token(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer invalid_token',
        ])->get('/api/inventory?name=phone&min_price=100&max_price=500&warehouse_id=2&page=1');

        $response->assertStatus(401);
    }

    public function test_inventory_list_with_different_filters(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/inventory?name=laptop&page=1');

        $response->assertStatus(200);
        $response->assertJson(['status' => true]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/inventory?min_price=50&max_price=1000&page=1');

        $response->assertStatus(200);
        $response->assertJson(['status' => true]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/inventory?warehouse_id=2&page=1');

        $response->assertStatus(200);
        $response->assertJson(['status' => true]);
    }
}
