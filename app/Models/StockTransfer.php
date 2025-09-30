<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    use HasFactory;
    protected $table = "stock_transfers";
    protected $fillable = [
        'from_warehouse_id',
        'to_warehouse_id',
        'inventory_item_id',
        'quantity',
        'status',
        'notes',
        'transferred_at'
    ];

    public function fromWarehouse(){
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
    }
    public function toWarehouse(){
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
    }
    public function inventoryItem(){
        return $this->belongsTo(InventoryItem::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->status = "completed";
        });
    }
}
