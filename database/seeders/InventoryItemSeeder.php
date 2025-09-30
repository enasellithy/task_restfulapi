<?php

namespace Database\Seeders;

use App\Models\InventoryItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i <= 10; $i++) {
            InventoryItem::create([
                'name' => 'Laptop Dell ' . $i,
                'sku' => 'DLXPS13_' . $i,
                'description' => 'Description ' . $i,
                'price' => 1000 + $i,
            ]);
        }

    }
}
