<?php

namespace Database\Seeders;

use App\Models\InventoryItem;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warehouses = Warehouse::all();
        $inventoryItems = InventoryItem::all();
        $this->createStocks($warehouses, $inventoryItems);
    }

    private function createStocks($warehouses, $inventoryItems): void
    {
        foreach ($warehouses as $warehouse) {
            foreach ($inventoryItems as $item) {
                $warehouse->stocks()->create([
                    'inventory_item_id' => $item->id,
                    'quantity' => rand(0, 100),
                    'low_stock_threshold' => rand(0, 11),
                ]);
            }
        }
    }
}
