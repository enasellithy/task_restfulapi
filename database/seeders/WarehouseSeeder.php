<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warehouses = [
            [
                'name' => 'Main Central Warehouse',
                'location' => 'Cairo',
            ],
            [
                'name' => 'Alex  Center',
                'location' => 'Alexandria',
            ]
        ];
        foreach ($warehouses as $warehouse) {
            Warehouse::create($warehouse);
        }
    }
}
