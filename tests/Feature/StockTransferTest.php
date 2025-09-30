<?php

namespace Tests\Feature;

use App\Models\InventoryItem;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockTransferTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_it_transfers_stock_successfully()
    {
        $this->actingAs($this->user);

        $warehouse1 = Warehouse::create([
            'name' => 'Main Warehouse',
            'location' => 'Cairo'
        ]);

        $warehouse2 = Warehouse::create([
            'name' => 'Branch Warehouse',
            'location' => 'Giza'
        ]);

        $item = InventoryItem::create([
            'name' => 'Test Laptop',
            'sku' => 'SKU-001',
            'description' => 'Test description',
            'price' => 999.99
        ]);

        $stock = Stock::create([
            'warehouse_id' => $warehouse1->id,
            'inventory_item_id' => $item->id,
            'quantity' => 100,
            'low_stock_threshold' => 10
        ]);

        $response = $this->postJson('/api/inventory_transfer', [
            'from_warehouse_id' => $warehouse1->id,
            'to_warehouse_id' => $warehouse2->id,
            'inventory_item_id' => $item->id,
            'quantity' => 50
        ]);

        $response->assertSuccessful();
        $this->assertEquals(50, $stock->fresh()->quantity);
    }

    public function test_it_fails_when_transferring_more_than_available_stock()
    {
        $this->actingAs($this->user);

        $warehouse1 = Warehouse::create([
            'name' => 'Source Warehouse',
            'location' => 'Alex'
        ]);

        $warehouse2 = Warehouse::create([
            'name' => 'Warehouse',
            'location' => 'Lux'
        ]);

        $item = InventoryItem::create([
            'name' => 'Test Phone',
            'sku' => 'SKU-002',
            'description' => 'Test description',
            'price' => 499.99
        ]);

        Stock::create([
            'warehouse_id' => $warehouse1->id,
            'inventory_item_id' => $item->id,
            'quantity' => 30,
            'low_stock_threshold' => 10
        ]);

        $response = $this->postJson('/api/inventory_transfer', [
            'from_warehouse_id' => $warehouse1->id,
            'to_warehouse_id' => $warehouse2->id,
            'inventory_item_id' => $item->id,
            'quantity' => 50
        ]);

        $response->assertStatus(400)
            ->assertJsonStructure([
                'status',
                'message'
            ])
            ->assertJson([
                'status' => false
            ]);
    }
}
