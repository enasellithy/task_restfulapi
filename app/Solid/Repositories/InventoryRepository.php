<?php


namespace App\Solid\Repositories;


use App\Models\Stock;
use App\Models\Warehouse;
use App\Solid\Traits\JsonTrait;
use Illuminate\Support\Facades\Cache;

class InventoryRepository
{
    use JsonTrait;

    public function getAll()
    {
        $request = request();
        $cacheKey = 'inventory_' . md5($request->fullUrl());
        $inventory = Cache::remember($cacheKey, 60, function () use ($request) {
            return Stock::with(['inventoryItem', 'warehouse'])
                ->when($request->filled('warehouse_id'), function ($q) use ($request) {
                    $q->whereHas('warehouse', function ($q) use ($request) {
                        $q->where('warehouse_id', $request->warehouse_id);
                    });
                })
                ->when($request->filled('name'), function ($q) use ($request) {
                    $q->whereHas('inventoryItem', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->name . '%');
                    });
                })
                ->when($request->filled('sku'), function ($q) use ($request) {
                    $q->whereHas('inventoryItem', function ($q) use ($request) {
                        $q->where('sku', 'like', '%' . $request->sku . '%');
                    });
                })
                ->when($request->filled('min_price'), function ($q) use ($request) {
                    $q->whereHas('inventoryItem', function ($q) use ($request) {
                        $q->where('price', '>=', $request->min_price);
                    });
                })
                ->when($request->filled('max_price'), function ($q) use ($request) {
                    $q->whereHas('inventoryItem', function ($q) use ($request) {
                        $q->where('price', '<=', $request->max_price);
                    });
                })
                ->paginate($request->per_page ?? 10);
        });
        return $this->whenDone($inventory);
    }

    public function getAllWarehouses()
    {
        $data = Warehouse::latest()->paginate(10);
        $data->makeHidden(['created_at', 'updated_at']);
        return $this->whenDone($data);
    }

    public function showWarehouse($id)
    {
        $data = Warehouse::with([
            'stocks.inventoryItem'
        ])->find($id);
        if (!$data) {
            return $this->whenError('Warehouse not found');
        }
        return $this->whenDone($data);
    }
}
